<?php

namespace App\Models\Storage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpdateSaleModel extends Model
{
    use HasFactory;
    protected $table = 'update_stock_sale';
    protected $primaryKey = "id";

    protected $fillable = [
        "id_stock_sale",
        "name",
        "value",
        "cost",
        "quantity"
    ];
    public function stockSale()
    {
        return $this->belongsTo(PrdStockModel::class, 'id_stock_sale', 'id');
    }
}
