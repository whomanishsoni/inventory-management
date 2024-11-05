<?php

namespace Sales\Models;

use CodeIgniter\Model;

class SalesModel extends Model
{
    protected $table = 'sales';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'customer_id',
        'reference_no',
        'total_amount',
        'discount_amount',
        'paid_amount',
        'remaining_amount',
        'sale_date',
        'payment_status',
        'sale_status',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
