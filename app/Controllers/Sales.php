<?php

namespace App\Controllers;

use App\Models\SaleModel;
use App\Models\SaleItemModel;
use App\Models\ProductModel;
use App\Models\StockLogModel;

class Sales extends BaseController
{
    public function index()
    {
        $model = new SaleModel();
        $data['sales'] = $model->select('sales.*, users.full_name as cashier')
                               ->join('users', 'users.id = sales.user_id', 'left')
                               ->orderBy('sales.id', 'DESC')
                               ->findAll();
        return view('sales/index', $data);
    }
    
    public function create()
    {
        $productModel = new ProductModel();
        $data['products'] = $productModel->where('quantity >', 0)->where('status', 1)->findAll();
        return view('sales/create', $data);
    }
    
    public function store()
    {
        $saleModel = new SaleModel();
        $saleItemModel = new SaleItemModel();
        $productModel = new ProductModel();
        $stockLogModel = new StockLogModel();
        
        $cart = json_decode($this->request->getPost('cart'), true);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty');
        }
        
        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['total'];
        }
        
        $discount = $this->request->getPost('discount') ?? 0;
        $tax = $this->request->getPost('tax') ?? 0;
        $grand_total = $subtotal - $discount + $tax;
        
        // Generate invoice number
        $invoice_no = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);
        
        // Insert sale
        $saleData = [
            'invoice_no' => $invoice_no,
            'user_id' => session()->get('user_id'),
            'customer_name' => $this->request->getPost('customer_name'),
            'total_amount' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'grand_total' => $grand_total,
            'payment_method' => $this->request->getPost('payment_method'),
            'payment_status' => 'paid',
            'notes' => $this->request->getPost('notes')
        ];
        
        $saleId = $saleModel->insert($saleData);
        
        if ($saleId) {
            // Insert sale items and update stock
            foreach ($cart as $item) {
                $saleItemModel->insert([
                    'sale_id' => $saleId,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['total']
                ]);
                
                // Update product stock
                $product = $productModel->find($item['product_id']);
                $new_quantity = $product['quantity'] - $item['quantity'];
                $productModel->update($item['product_id'], ['quantity' => $new_quantity]);
                
                // Log stock change
                $stockLogModel->insert([
                    'product_id' => $item['product_id'],
                    'user_id' => session()->get('user_id'),
                    'quantity_change' => -$item['quantity'],
                    'previous_quantity' => $product['quantity'],
                    'new_quantity' => $new_quantity,
                    'type' => 'sale',
                    'reference_no' => $invoice_no,
                    'reason' => 'Sale transaction'
                ]);
            }
            
            log_activity('Create Sale', "Created sale with invoice: {$invoice_no}, Amount: {$grand_total}");
            return redirect()->to("/sales/{$saleId}")->with('success', 'Sale completed successfully');
        }
        
        return redirect()->back()->with('error', 'Failed to process sale');
    }
    
    public function show($id)
    {
        $saleModel = new SaleModel();
        $saleItemModel = new SaleItemModel();
        
        $data['sale'] = $saleModel->select('sales.*, users.full_name as cashier')
                                  ->join('users', 'users.id = sales.user_id', 'left')
                                  ->find($id);
        
        if (!$data['sale']) {
            return redirect()->to('/sales')->with('error', 'Sale not found');
        }
        
        $data['items'] = $saleItemModel->select('sale_items.*, products.name as product_name')
                                       ->join('products', 'products.id = sale_items.product_id')
                                       ->where('sale_id', $id)
                                       ->findAll();
        
        return view('sales/view', $data);
    }
    
    public function invoice($id)
    {
        $saleModel = new SaleModel();
        $saleItemModel = new SaleItemModel();
        
        $data['sale'] = $saleModel->select('sales.*, users.full_name as cashier')
                                  ->join('users', 'users.id = sales.user_id', 'left')
                                  ->find($id);
        
        if (!$data['sale']) {
            return redirect()->to('/sales')->with('error', 'Sale not found');
        }
        
        $data['items'] = $saleItemModel->select('sale_items.*, products.name as product_name')
                                       ->join('products', 'products.id = sale_items.product_id')
                                       ->where('sale_id', $id)
                                       ->findAll();
        
        return view('sales/invoice', $data);
    }
    
    public function delete($id)
    {
        $model = new SaleModel();
        $sale = $model->find($id);
        if ($sale && $model->delete($id)) {
            log_activity('Delete Sale', "Deleted sale invoice: {$sale['invoice_no']}");
            return redirect()->to('/sales')->with('success', 'Sale deleted successfully');
        }
        return redirect()->to('/sales')->with('error', 'Failed to delete sale');
    }
}