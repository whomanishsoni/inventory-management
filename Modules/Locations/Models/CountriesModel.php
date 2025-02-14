<?php

namespace Locations\Models;

use CodeIgniter\Model;

class CountriesModel extends Model
{
    protected $table      = 'countries';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'country_name',
        'country_status',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
