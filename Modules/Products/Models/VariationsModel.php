<?php

namespace Products\Models;

use CodeIgniter\Model;

class VariationsModel extends Model
{
    protected $table      = 'variations';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'variation_name',
        'variation_status',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
