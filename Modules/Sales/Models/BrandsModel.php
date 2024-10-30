<?php

namespace Products\Models;

use CodeIgniter\Model;

class BrandsModel extends Model
{
    protected $table      = 'brands';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'brand_name',
        'brand_status',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
