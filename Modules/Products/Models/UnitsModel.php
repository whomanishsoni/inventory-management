<?php

namespace Products\Models;

use CodeIgniter\Model;

class UnitsModel extends Model
{
    protected $table      = 'units';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'unit_name',
        'unit_abbreviation',
        'unit_status',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
