<?php

namespace App\Models\Storage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpdateOutModel extends Model
{
    use HasFactory;
    protected $table = 'update_stock_out';
    protected $primaryKey = "id";

    protected $fillable = [
        "id_stock_out",
        "name",
        "value",
        "cost",
        "quantity"
    ];
    public function stockOut()
    {
        return $this->belongsTo(PrdOutModel::class, 'id_stock_out', 'id');
    }
}
