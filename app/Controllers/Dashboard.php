<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\SaleModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $saleModel = new SaleModel();
        $userModel = new UserModel();
        
        $data = [
            'total_products' => $productModel->countAll(),
            'total_categories' => $categoryModel->countAll(),
            'total_sales_today' => $saleModel->where('DATE(sale_date)', date('Y-m-d'))->countAllResults(),
            'total_users' => $userModel->countAll(),
            'low_stock_products' => $productModel->where('quantity <= reorder_level', null, false)->countAllResults(),
            'recent_sales' => $saleModel->orderBy('id', 'DESC')->limit(5)->findAll(),
            'top_products' => $saleModel->getTopProducts(5)
        ];
        
        return view('dashboard/index', $data);
    }
}