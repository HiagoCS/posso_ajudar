<?php

namespace App\Models\Storage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Storage\PrdStockModel;
use App\Models\Account\Client;

class CashierSaleModel extends Model
{
    use HasFactory;
    protected $table = 'cashier_sale';
    protected $primaryKey = "id";
    protected $fillable = [
        "total_value",
        "id_pg_method",
        "id_client",
        "dt_sale"
    ];
    public $timestamps = false;

    public function productsStock()
    {
        return $this->hasMany(PrdStockModel::class, 'id_sale', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client', 'id');
    }
}
