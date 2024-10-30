<?php

namespace Customers\Models;

use CodeIgniter\Model;

class CustomerTransactionsModel extends Model
{
    protected $table      = 'customer_transactions';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'customer_id',
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
