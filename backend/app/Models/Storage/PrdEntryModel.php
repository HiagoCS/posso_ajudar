<?php

namespace App\Models\Storage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrdEntryModel extends Model
{
    use HasFactory;
    
    protected $table = 'products_stock_entry';
    protected $primaryKey = "id";
    
    protected $fillable = [
        'id_product',
        'qunt_toAdd',
        'dt_entry'
    ];

    public $timestamps = false;

    // Relacionamento com a tabela products
    public function product()
    {
        return $this->belongsTo(ProductsModel::class, 'id_product', 'id');
    }
}
