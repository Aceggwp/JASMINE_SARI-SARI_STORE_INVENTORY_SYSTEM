<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'status'];
    protected $useTimestamps = true;
    protected $validationRules = [
        'name' => 'required|min_length[2]|is_unique[categories.name,id,{id}]'
    ];
}