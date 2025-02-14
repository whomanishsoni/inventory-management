<?php

namespace Products\Models;

use CodeIgniter\Model;

class CategoriesModel extends Model
{
    protected $table      = 'categories';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'category_name',
        'category_description',
        'category_status',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
