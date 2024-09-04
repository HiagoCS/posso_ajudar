<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Storage\CashierSaleModel;
use App\Models\Account\PGModel;

class Client extends Model
{
    use HasFactory;
    protected $table = 'client';
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        "cpf",
        "id_fav_pg_method"
    ];
    public $timestamps = false;

    public function sales()
    {
        return $this->hasMany(CashierSaleModel::class, 'id_client', 'id');
    }
    public function favoritePaymentMethod()
    {
        return $this->belongsTo(PGModel::class, 'id_fav_pg_method', 'id')->nullable();
    }
}
