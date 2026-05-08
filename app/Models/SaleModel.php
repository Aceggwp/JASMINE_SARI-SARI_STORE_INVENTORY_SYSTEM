<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
    protected $table = 'sales';
    protected $primaryKey = 'id';
    
    // Define all columns that can be inserted/updated
    protected $allowedFields = [
        'invoice_no',
        'user_id',
        'customer_name',
        'total_amount',
        'discount',
        'tax',
        'grand_total',
        'payment_method',
        'payment_status',
        'notes',
        'sale_date'
    ];
    
    // Disable CI automatic timestamps because the database handles them
    protected $useTimestamps = false;
    
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