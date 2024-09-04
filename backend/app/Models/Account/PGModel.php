<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Account\Client;
use App\Models\Storage\CashierSaleModel;

class PGModel extends Model
{
    use HasFactory;
    protected $table = 'pg_method';
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'status'
      ];
    public $timestamps = false;

    public function clients()
    {
        return $this->hasMany(Client::class, 'id_fav_pg_method', 'id');
    }

    public function sales()
    {
        return $this->hasMany(CashierSaleModel::class, 'id_pg_method', 'id');
    }
}
