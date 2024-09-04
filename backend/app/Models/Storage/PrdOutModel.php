<?php

namespace App\Models\Storage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrdOutModel extends Model
{
    use HasFactory;
    
    protected $table = 'products_stock_out';
    protected $primaryKey = "id";
    
    protected $fillable = [
        'id_product',
        'qunt_remove',
        'dt_out'
    ];

    public $timestamps = false;

    // Relacionamento com a tabela products
    public function product()
    {
        return $this->belongsTo(ProductsModel::class, 'id_product', 'id');
    }
}
