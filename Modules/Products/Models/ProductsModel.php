<?php

namespace Products\Models;

use CodeIgniter\Model;

class ProductsModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'product_name',
        'sku_code',
        'brand_id',
        'unit_id',
        'category_id',
        'sub_category_id',
        'tax_group_id',
        'tax_amount',
        'product_status',
        'has_variation',
        'buying_price',
        'customer_price',
        'sale_price',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
