<?php

namespace Suppliers\Models;

use CodeIgniter\Model;

class SuppliersModel extends Model
{
    protected $table      = 'suppliers';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'supplier_name',
        'supplier_contact_person',
        'supplier_email',
        'supplier_phone',
        'supplier_address',
        'supplier_pincode',
        'city_id',
        'state_id',
        'country_id',
        'supplier_notes',
        'supplier_status',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
