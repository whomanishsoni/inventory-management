<?php

namespace Customers\Models;

use CodeIgniter\Model;

class CustomersModel extends Model
{
    protected $table      = 'customers';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'customer_pincode',
        'city_id',
        'state_id',
        'country_id',
        'customer_status',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
