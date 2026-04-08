<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
    protected $table = 'sales';
    protected $primaryKey = 'id';
    protected $allowedFields = ['invoice_no', 'user_id', 'customer_name', 'total_amount', 'discount', 'tax', 'grand_total', 'payment_method', 'payment_status', 'notes', 'sale_date'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = null; // 👈 Disable updated_at (table has no such column)
    
    public function getTopProducts($limit = 5)
    {
        return $this->db->table('sale_items')
                        ->select('products.name, SUM(sale_items.quantity) as total_sold')
                        ->join('products', 'products.id = sale_items.product_id')
                        ->groupBy('sale_items.product_id')
                        ->orderBy('total_sold', 'DESC')
                        ->limit($limit)
                        ->get()
                        ->getResultArray();
    }
}