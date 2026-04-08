<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\StockLogModel;

class Products extends BaseController
{
    public function index()
    {
        $model = new ProductModel();
        $data['products'] = $model->select('products.*, categories.name as category_name')
                                  ->join('categories', 'categories.id = products.category_id', 'left')
                                  ->orderBy('products.id', 'DESC')
                                  ->findAll();
        return view('products/index', $data);
    }
    
    public function create()
    {
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->where('status', 1)->findAll();
        return view('products/form', $data);
    }
    
    public function store()
    {
        $model = new ProductModel();
        $data = [
            'name'          => $this->request->getPost('name'),
            'sku'           => $this->request->getPost('sku'),
            'category_id'   => $this->request->getPost('category_id'),
            'description'   => $this->request->getPost('description'),
            'price'         => $this->request->getPost('price'),
            'cost_price'    => $this->request->getPost('cost_price'),
            'quantity'      => $this->request->getPost('quantity') ?? 0,
            'reorder_level' => $this->request->getPost('reorder_level') ?? 5,
            'status'        => $this->request->getPost('status') ?? 1
        ];
        
        if ($model->insert($data)) {
            if ($data['quantity'] > 0) {
                $stockLog = new StockLogModel();
                $stockLog->insert([
                    'product_id'        => $model->getInsertID(),
                    'user_id'           => session()->get('user_id'),
                    'quantity_change'   => $data['quantity'],
                    'previous_quantity' => 0,
                    'new_quantity'      => $data['quantity'],
                    'type'              => 'add',
                    'reason'            => 'Initial stock'
                ]);
            }
            log_activity('Create Product', "Created product: {$data['name']}");
            return redirect()->to('/products')->with('success', 'Product created successfully');
        }
        return redirect()->back()->with('errors', $model->errors());
    }
    
    public function edit($id)
    {
        $model = new ProductModel();
        $data['product'] = $model->find($id);
        if (!$data['product']) {
            return redirect()->to('/products')->with('error', 'Product not found');
        }
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->where('status', 1)->findAll();
        return view('products/form', $data);
    }
    
    public function update($id)
{
    $model = new ProductModel();
    $data = [
        'name'          => $this->request->getPost('name'),
        'sku'           => $this->request->getPost('sku'),
        'category_id'   => $this->request->getPost('category_id'),
        'description'   => $this->request->getPost('description'),
        'price'         => $this->request->getPost('price'),
        'cost_price'    => $this->request->getPost('cost_price'),
        'reorder_level' => $this->request->getPost('reorder_level') ?? 5,
        'status'        => $this->request->getPost('status') ?? 1
    ];
    
    if ($model->update($id, $data)) {
        log_activity('Update Product', "Updated product ID: {$id}");
        return redirect()->to('/products')->with('success', 'Product updated successfully');
    }
    return redirect()->back()->with('errors', $model->errors());
}
    
    public function delete($id)
{
    $model = new ProductModel();
    $product = $model->find($id);
    
    if ($product && $model->delete($id)) {
        log_activity('Delete Product', "Deleted product: {$product['name']}");
        return redirect()->to('/products')->with('success', 'Product deleted successfully');
    }
    return redirect()->to('/products')->with('error', 'Failed to delete product');
}
}