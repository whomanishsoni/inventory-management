<?php

namespace Purchases\Models;

use CodeIgniter\Model;

class PurchaseItemsModel extends Model
{
    protected $table      = 'purchase_items';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = [
        'purchase_id',
        'product_id',
        'product_name',
        'sku_code',
        'variation_id',
        'variation_value_id',
        'quantity',
        'unit_price',
        'total_price',
        'manufacture_date',
        'expiry_date',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}
