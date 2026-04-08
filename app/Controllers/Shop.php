<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\SaleModel;
use App\Models\SaleItemModel;
use App\Models\StockLogModel;

class Shop extends BaseController
{
    public function index()
    {
        $model = new ProductModel();
        $data['products'] = $model->where('status', 1)
                                   ->where('quantity >', 0)
                                   ->orderBy('name', 'ASC')
                                   ->findAll();
        return view('shop/index', $data);
    }

    public function cart()
    {
        $cart = session()->get('cart') ?? [];
        $data['cart'] = $cart;
        $data['total'] = $this->calculateCartTotal($cart);
        return view('shop/cart', $data);
    }

    public function addToCart()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = (int)$this->request->getPost('quantity');

        $productModel = new ProductModel();
        $product = $productModel->find($productId);

        if (!$product || $product['quantity'] < $quantity) {
            return redirect()->back()->with('error', 'Product not available or insufficient stock.');
        }

        $cart = session()->get('cart') ?? [];
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id'       => $product['id'],
                'name'     => $product['name'],
                'price'    => $product['price'],
                'quantity' => $quantity,
                'stock'    => $product['quantity']
            ];
        }

        // Validate stock again
        if ($cart[$productId]['quantity'] > $product['quantity']) {
            return redirect()->back()->with('error', 'Quantity exceeds available stock.');
        }

        session()->set('cart', $cart);
        return redirect()->to('/cart')->with('success', 'Product added to cart.');
    }

    public function updateCart()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = (int)$this->request->getPost('quantity');

        $cart = session()->get('cart') ?? [];
        if (!isset($cart[$productId])) {
            return redirect()->back()->with('error', 'Product not in cart.');
        }

        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            // Validate against current stock
            $productModel = new ProductModel();
            $product = $productModel->find($productId);
            if ($product && $quantity > $product['quantity']) {
                return redirect()->back()->with('error', 'Requested quantity exceeds available stock.');
            }
            $cart[$productId]['quantity'] = $quantity;
        }

        session()->set('cart', $cart);
        return redirect()->to('/cart')->with('success', 'Cart updated.');
    }

    public function removeFromCart($productId)
    {
        $cart = session()->get('cart') ?? [];
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->set('cart', $cart);
        }
        return redirect()->to('/cart')->with('success', 'Item removed.');
    }

    public function checkout()
    {
        $cart = session()->get('cart') ?? [];
        if (empty($cart)) {
            return redirect()->to('/shop')->with('error', 'Your cart is empty.');
        }
        $data['cart'] = $cart;
        $data['total'] = $this->calculateCartTotal($cart);
        return view('shop/checkout', $data);
    }

    public function processCheckout()
    {
        $cart = session()->get('cart') ?? [];
        if (empty($cart)) {
            return redirect()->to('/shop')->with('error', 'Cart is empty.');
        }

        $customerName = $this->request->getPost('customer_name');
        $paymentMethod = $this->request->getPost('payment_method');
        $notes = $this->request->getPost('notes');

        if (empty($customerName)) {
            return redirect()->back()->with('error', 'Please enter your name.');
        }

        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $discount = 0;
        $tax = 0;
        $grandTotal = $totalAmount - $discount + $tax;

        // Generate invoice number
        $invoiceNo = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);

        $saleModel = new SaleModel();
        $saleData = [
            'invoice_no'     => $invoiceNo,
            'user_id'        => session()->get('customer_id'), // now customer ID
            'customer_name'  => $customerName,
            'total_amount'   => $totalAmount,
            'discount'       => $discount,
            'tax'            => $tax,
            'grand_total'    => $grandTotal,
            'payment_method' => $paymentMethod,
            'payment_status' => 'paid',
            'notes'          => $notes
        ];

        $saleId = $saleModel->insert($saleData);
        if (!$saleId) {
            return redirect()->back()->with('error', 'Checkout failed. Please try again.');
        }

        $saleItemModel = new SaleItemModel();
        $productModel = new ProductModel();
        $stockLogModel = new StockLogModel();

        foreach ($cart as $item) {
            // Insert sale item
            $saleItemModel->insert([
                'sale_id'    => $saleId,
                'product_id' => $item['id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
                'total'      => $item['price'] * $item['quantity']
            ]);

            // Update product stock
            $product = $productModel->find($item['id']);
            $newQuantity = $product['quantity'] - $item['quantity'];
            $productModel->update($item['id'], ['quantity' => $newQuantity]);

            // Log stock movement
            $stockLogModel->insert([
                'product_id'        => $item['id'],
                'user_id'           => null,
                'quantity_change'   => -$item['quantity'],
                'previous_quantity' => $product['quantity'],
                'new_quantity'      => $newQuantity,
                'type'              => 'sale',
                'reference_no'      => $invoiceNo,
                'reason'            => 'Customer purchase'
            ]);
        }

        // Clear cart
        session()->remove('cart');

        return redirect()->to('/order/success/' . $invoiceNo)->with('success', 'Order placed successfully!');
    }

    public function orderSuccess($invoiceNo)
    {
        $saleModel = new SaleModel();
        $sale = $saleModel->where('invoice_no', $invoiceNo)->first();
        if (!$sale) {
            return redirect()->to('/shop')->with('error', 'Order not found.');
        }
        $data['sale'] = $sale;
        return view('shop/success', $data);
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