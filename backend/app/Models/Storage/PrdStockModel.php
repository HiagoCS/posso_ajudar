<?php

namespace App\Models\Storage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Storage\ProductsModel;
use App\Models\Storage\CashierSaleModel;

class PrdStockModel extends Model
{
    use HasFactory;
    protected $table = 'products_stock_sale';
    protected $primaryKey = "id";
    protected $fillable = [
        "id_sale",
        "id_product",
        "qunt_remove",
        "dt_sale"
    ];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(ProductsModel::class, 'id_product', 'id');
    }
    public function sale()
    {
        return $this->belongsTo(CashierSaleModel::class, 'id_sale', 'id');
    }
}
