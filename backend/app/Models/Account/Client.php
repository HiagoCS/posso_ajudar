<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
