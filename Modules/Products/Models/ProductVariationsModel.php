<?php

namespace Products\Models;

use CodeIgniter\Model;

class ProductVariationsModel extends Model
{
    protected $table      = 'product_variations';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'product_id',
        'variation_sku_code',
        'variation_product_name',
        'variation_id',
        'variation_value_id',
        'variation_brand_id',
        'variation_unit_id',
        'variation_category_id',
        'variation_sub_category_id',
        'variation_tax_group_id',
        'variation_buying_price',
        'variation_customer_price',
        'variation_tax_amount',
        'variation_sale_price',
        'variation_product_status',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
