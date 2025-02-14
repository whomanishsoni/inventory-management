<?php

namespace Products\Models;

use CodeIgniter\Model;

class TaxGroupsModel extends Model
{
    protected $table      = 'tax_groups';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'tax_group_name',
        'tax_group_status',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
