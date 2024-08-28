<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PGModel extends Model
{
    use HasFactory;
    protected $table = 'pg_method';
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'status'
      ];
}
