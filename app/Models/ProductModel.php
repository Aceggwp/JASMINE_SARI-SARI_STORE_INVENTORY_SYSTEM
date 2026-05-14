<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'sku', 'category_id', 'description', 'price', 'cost_price', 'quantity', 'reorder_level', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'name'          => 'required|min_length[2]|max_length[255]',
        'sku'           => 'permit_empty|max_length[100]|is_unique[products.sku,id,{id}]',
        'category_id'   => 'permit_empty|is_not_unique[categories.id]',
        'price'         => 'required|numeric|greater_than_equal_to[0]',
        'cost_price'    => 'permit_empty|numeric|greater_than_equal_to[0]',
        'quantity'      => 'permit_empty|numeric|greater_than_equal_to[0]',
        'reorder_level' => 'permit_empty|numeric|greater_than_equal_to[0]',
        'status'        => 'permit_empty|in_list[0,1]'
    ];

    protected $validationMessages = [
        'sku' => [
            'is_unique' => 'This SKU is already in use.'
        ],
        'category_id' => [
            'is_not_unique' => 'The selected category does not exist.'
        ]
    ];
}