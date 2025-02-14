<?php

namespace Products\Models;

use CodeIgniter\Model;

class TaxRatesModel extends Model
{
    protected $table      = 'tax_rates';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'tax_name',
        'tax_rate',
        'group_id',
        'tax_status',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
