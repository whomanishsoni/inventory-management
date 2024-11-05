<?php

namespace Sales\Models;

use CodeIgniter\Model;

class SaleItemsModel extends Model
{
    protected $table = 'sales_items';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'sale_id',
        'product_id',
        'variation_id',
        'variation_value_id',
        'brand_id',
        'unit_id',
        'category_id',
        'sub_category_id',
        'sku_code',
        'product_name',
        'quantity',
        'unit_price',
        'total_price',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
