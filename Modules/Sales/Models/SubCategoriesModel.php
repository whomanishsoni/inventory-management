<?php

namespace Products\Models;

use CodeIgniter\Model;

class SubCategoriesModel extends Model
{
    protected $table      = 'sub_categories';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'category_id',
        'sub_category_name',
        'sub_category_description',
        'sub_category_status',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
