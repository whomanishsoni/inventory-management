<?php

namespace Products\Models;

use CodeIgniter\Model;

class ProductVariationsModel extends Model
{
    protected $table      = 'product_variations';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'product_name',
        'product_id',
        'variation_id',
        'variation_value_id',
        'variation_tax_group_id',
        'variation_buying_price',
        'variation_customer_price',
        'variation_sale_price',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
