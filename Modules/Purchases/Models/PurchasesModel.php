<?php

namespace Purchases\Models;

use CodeIgniter\Model;

class PurchasesModel extends Model
{
    protected $table      = 'purchases';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'supplier_id',
        'reference_no',
        'total_amount',
        'paid_amount',
        'remaining_amount',
        'purchase_date',
        'payment_status',
        'purchase_status',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
