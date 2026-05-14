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
        
        $chartData = $saleModel->getDailySalesLast7Days();
        
        $data = [
            'total_products' => $productModel->countAll(),
            'total_categories' => $categoryModel->countAll(),
            'revenue_today' => $saleModel->getRevenueToday(),
            'total_users' => $userModel->countAll(),
            'low_stock_products' => $productModel->where('quantity <= reorder_level')->countAllResults(),
            'recent_sales' => $saleModel->orderBy('id', 'DESC')->limit(5)->findAll(),
            'top_products' => $saleModel->getTopProducts(5),
            'chart_labels' => json_encode($chartData['labels']),
            'chart_data' => json_encode($chartData['data'])
        ];
        
        return view('dashboard/index', $data);
    }
}