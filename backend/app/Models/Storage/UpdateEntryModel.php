<?php

namespace App\Models\Storage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpdateEntryModel extends Model
{
    use HasFactory;

    protected $table = 'update_stock_entry';
    protected $primaryKey = "id";

    protected $fillable = [
        "id_stock_entry",
        "name",
        "value",
        "cost",
        "quantity"
    ];
    public function stockEntry()
    {
        return $this->belongsTo(PrdEntryModel::class, 'id_stock_entry', 'id');
    }
}
