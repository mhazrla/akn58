<?php

namespace App\Models;

use CodeIgniter\Model;

class Sales extends Model
{
    protected $table            = 'sales';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields    = ["id", "product_id", "faktur_sale", "total_price",  "sales_date", "qty", "category_id"];
}
