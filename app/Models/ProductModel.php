<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'sku', 'category_id', 'description', 'price', 'cost_price', 'quantity', 'reorder_level', 'status'];
    protected $useTimestamps = true;
    protected $validationRules = [
        'name' => 'required|min_length[2]',
        'price' => 'required|numeric',
        'quantity' => 'permit_empty|numeric'
    ];
}