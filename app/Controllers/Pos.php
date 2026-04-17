<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\SaleModel;
use App\Models\SaleItemModel;
use App\Models\StockLogModel;

class Pos extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $data['products'] = $productModel->where('status', 1)
                                          ->where('quantity >', 0)
                                          ->orderBy('name', 'ASC')
                                          ->findAll();
        $data['cart'] = session()->get('pos_cart') ?? [];
        $data['cartTotal'] = $this->calculateCartTotal($data['cart']);
        return view('pos/index', $data);
    }

    public function addToCart()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = (int)$this->request->getPost('quantity');
        
        $productModel = new ProductModel();
        $product = $productModel->find($productId);
        
        if (!$product || $product['quantity'] < $quantity) {
            return $this->response->setJSON(['success' => false, 'message' => 'Insufficient stock']);
        }
        
        $cart = session()->get('pos_cart') ?? [];
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'stock' => $product['quantity']
            ];
        }
        
        session()->set('pos_cart', $cart);
        
        return $this->response->setJSON([
            'success' => true,
            'cart' => $cart,
            'total' => $this->calculateCartTotal($cart)
        ]);
    }
    
    public function updateCart()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = (int)$this->request->getPost('quantity');
        
        $cart = session()->get('pos_cart') ?? [];
        
        if (!isset($cart[$productId])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Product not in cart']);
        }
        
        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $productModel = new ProductModel();
            $product = $productModel->find($productId);
            if ($product && $quantity > $product['quantity']) {
                return $this->response->setJSON(['success' => false, 'message' => 'Quantity exceeds stock']);
            }
            $cart[$productId]['quantity'] = $quantity;
        }
        
        session()->set('pos_cart', $cart);
        
        return $this->response->setJSON([
            'success' => true,
            'cart' => $cart,
            'total' => $this->calculateCartTotal($cart)
        ]);
    }
    
    public function removeFromCart($productId)
    {
        $cart = session()->get('pos_cart') ?? [];
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->set('pos_cart', $cart);
        }
        
        return redirect()->to('/pos')->with('success', 'Item removed from cart');
    }
    
    public function checkout()
    {
        $cart = session()->get('pos_cart') ?? [];
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty');
        }
        
        $customerName = $this->request->getPost('customer_name') ?: 'Walk-in Customer';
        $paymentMethod = $this->request->getPost('payment_method');
        $discount = (float)$this->request->getPost('discount');
        $paidAmount = (float)$this->request->getPost('paid_amount');
        
        $totalAmount = $this->calculateCartTotal($cart);
        $tax = $totalAmount * 0.12;
        $grandTotal = $totalAmount - $discount + $tax;
        
        if ($paidAmount < $grandTotal) {
            return redirect()->back()->with('error', 'Insufficient payment amount');
        }
        
        $change = $paidAmount - $grandTotal;
        
        // Generate invoice number
        $invoiceNo = 'INV-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        
        $saleModel = new SaleModel();
        $saleId = $saleModel->insert([
            'invoice_no' => $invoiceNo,
            'user_id' => session()->get('user_id'),
            'customer_name' => $customerName,
            'total_amount' => $totalAmount,
            'discount' => $discount,
            'tax' => $tax,
            'grand_total' => $grandTotal,
            'payment_method' => $paymentMethod,
            'payment_status' => 'paid',
            'notes' => "Paid: ₱" . number_format($paidAmount, 2) . " | Change: ₱" . number_format($change, 2)
        ]);
        
        if (!$saleId) {
            return redirect()->back()->with('error', 'Checkout failed');
        }
        
        $saleItemModel = new SaleItemModel();
        $productModel = new ProductModel();
        $stockLogModel = new StockLogModel();
        
        foreach ($cart as $item) {
            // Insert sale items
            $saleItemModel->insert([
                'sale_id' => $saleId,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity']
            ]);
            
            // Update stock
            $product = $productModel->find($item['id']);
            $newQuantity = $product['quantity'] - $item['quantity'];
            $productModel->update($item['id'], ['quantity' => $newQuantity]);
            
            // Log stock movement
            $stockLogModel->insert([
                'product_id' => $item['id'],
                'user_id' => session()->get('user_id'),
                'quantity_change' => -$item['quantity'],
                'previous_quantity' => $product['quantity'],
                'new_quantity' => $newQuantity,
                'type' => 'sale',
                'reference_no' => $invoiceNo,
                'reason' => 'POS Sale'
            ]);
        }
        
        // Clear cart
        session()->remove('pos_cart');
        
        log_activity('POS Sale', "Completed sale: $invoiceNo - ₱" . number_format($grandTotal, 2));
        
        return redirect()->to("/pos/receipt/$saleId")->with('success', 'Sale completed successfully!');
    }
    
    public function receipt($saleId)
    {
        $saleModel = new SaleModel();
        $saleItemModel = new SaleItemModel();
        
        $data['sale'] = $saleModel->select('sales.*, users.full_name as cashier')
                                  ->join('users', 'users.id = sales.user_id', 'left')
                                  ->find($saleId);
        
        if (!$data['sale']) {
            return redirect()->to('/pos')->with('error', 'Sale not found');
        }
        
        $data['items'] = $saleItemModel->select('sale_items.*, products.name as product_name')
                                       ->join('products', 'products.id = sale_items.product_id')
                                       ->where('sale_id', $saleId)
                                       ->findAll();
        
        return view('pos/receipt', $data);
    }
    
    public function searchProducts()
    {
        $search = $this->request->getGet('term');
        $productModel = new ProductModel();
        
        $products = $productModel->select('id, name, price, quantity')
                                 ->like('name', $search)
                                 ->where('quantity >', 0)
                                 ->where('status', 1)
                                 ->limit(10)
                                 ->find();
        
        return $this->response->setJSON($products);
    }
    
    private function calculateCartTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}