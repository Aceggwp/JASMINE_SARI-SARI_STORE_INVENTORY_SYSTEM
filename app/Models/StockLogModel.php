<?php

namespace App\Models;

use CodeIgniter\Model;

class StockLogModel extends Model
{
    protected $table = 'stock_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['product_id', 'user_id', 'quantity_change', 'previous_quantity', 'new_quantity', 'type', 'reference_no', 'reason'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = null; // 👈 Disable updated_at
}