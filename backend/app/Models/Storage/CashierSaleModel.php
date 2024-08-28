<?php

namespace App\Models\Storage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashierSaleModel extends Model
{
    use HasFactory;
    protected $table = 'cashier_sale';
    protected $primaryKey = "id";
    protected $fillable = [
        "total_value",
        "id_pg_method",
        "id_client"
    ];
    public $timestamps = false;
}
