<?php

namespace Products\Models;

use CodeIgniter\Model;

class VariationValuesModel extends Model
{
    protected $table      = 'variation_values';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'variation_id',
        'variation_value',
        'variation_value_status',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
