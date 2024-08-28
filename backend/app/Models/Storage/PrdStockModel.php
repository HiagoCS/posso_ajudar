<?php

namespace App\Models\Storage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrdStockModel extends Model
{
    use HasFactory;
    protected $table = 'products_stock';
    protected $primaryKey = "id";
    protected $fillable = [
        "id_sale",
        "id_product",
        "qunt_remove"
    ];

    public $timestamps = false;
}
