<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'password', 'full_name', 'role', 'is_active'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'username' => 'required|min_length[3]|is_unique[users.username,id,{id}]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'full_name' => 'required|min_length[3]',
        'password' => 'required|min_length[6]'
    ];
}