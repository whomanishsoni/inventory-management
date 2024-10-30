<?php

namespace Locations\Models;

use CodeIgniter\Model;

class CitiesModel extends Model
{
    protected $table      = 'cities';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'city_name',
        'state_id',
        'country_id',
        'city_status',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
