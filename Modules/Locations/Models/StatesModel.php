<?php

namespace Locations\Models;

use CodeIgniter\Model;

class StatesModel extends Model
{
    protected $table      = 'states';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'state_name',
        'country_id',
        'state_status',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
