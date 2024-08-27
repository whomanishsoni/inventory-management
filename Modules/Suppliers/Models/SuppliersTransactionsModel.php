<?php

namespace Suppliers\Models;

use CodeIgniter\Model;

class SuppliersTransactionsModel extends Model
{
    protected $table = 'suppliers_transactions';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'suppliers_id',
        'transaction_type',
        'amount',
        'balance',
        'transaction_date',
        'description',
        'reference_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
