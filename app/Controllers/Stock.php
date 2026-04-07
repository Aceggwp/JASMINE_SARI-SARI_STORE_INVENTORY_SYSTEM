<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\StockLogModel;

class Stock extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $data['products'] = $productModel->select('products.*, categories.name as category_name')
                                         ->join('categories', 'categories.id = products.category_id', 'left')
                                         ->orderBy('products.quantity', 'ASC')
                                         ->findAll();
        return view('stock/index', $data);
    }
    
    public function adjust()
    {
        $productModel = new ProductModel();
        $data['products'] = $productModel->where('status', 1)->findAll();
        return view('stock/adjust', $data);
    }
    
    public function adjustStore()
    {
        $productModel = new ProductModel();
        $stockLogModel = new StockLogModel();
        
        $product_id = $this->request->getPost('product_id');
        $quantity_change = $this->request->getPost('quantity');
        $type = $this->request->getPost('type');
        $reason = $this->request->getPost('reason');
        
        $product = $productModel->find($product_id);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }
        
        $new_quantity = ($type == 'add') ? $product['quantity'] + $quantity_change : $product['quantity'] - $quantity_change;
        
        if ($new_quantity < 0) {
            return redirect()->back()->with('error', 'Stock cannot be negative');
        }
        
        // Update product quantity
        $productModel->update($product_id, ['quantity' => $new_quantity]);
        
        // Log stock change
        $stockLogModel->insert([
            'product_id' => $product_id,
            'user_id' => session()->get('user_id'),
            'quantity_change' => ($type == 'add') ? $quantity_change : -$quantity_change,
            'previous_quantity' => $product['quantity'],
            'new_quantity' => $new_quantity,
            'type' => 'adjustment',
            'reason' => $reason
        ]);
        
        log_activity('Stock Adjustment', "Adjusted stock for {$product['name']}: {$type} {$quantity_change}");
        return redirect()->to('/stock')->with('success', 'Stock adjusted successfully');
    }
    
    public function logs()
    {
        $stockLogModel = new StockLogModel();
        $data['logs'] = $stockLogModel->select('stock_logs.*, products.name as product_name, users.full_name as user_name')
                                      ->join('products', 'products.id = stock_logs.product_id')
                                      ->join('users', 'users.id = stock_logs.user_id', 'left')
                                      ->orderBy('stock_logs.id', 'DESC')
                                      ->findAll();
        return view('stock/logs', $data);
    }
}