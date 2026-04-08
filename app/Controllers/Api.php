<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Api extends BaseController
{
    public function getProduct($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);
        
        if ($product) {
            return $this->response->setJSON([
                'success' => true,
                'product' => [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $product['quantity']
                ]
            ]);
        }
        
        return $this->response->setJSON(['success' => false]);
    }
    
    public function getProducts()
    {
        $productModel = new ProductModel();
        $products = $productModel->where('quantity >', 0)->where('status', 1)->findAll();
        return $this->response->setJSON($products);
    }
}