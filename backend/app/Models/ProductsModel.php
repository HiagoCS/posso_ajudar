<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsModel extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = "id";
    protected $fillable = [
        'sm_code',
        'bar_code',
        'name',
        'description',
        'value',
        'product_amount',
        'status',
      ];
    protected $hidden = ['password'];

    public $timestamps = false;

    public function EAN13Validation($bcode){
            $bcde = preg_replace("/\D/",'', $bcode);
            if(strlen($bcde) != 13){
                return $bcode;
            }
            
            $valid = substr($bcde,0,12);
            $soma = 0;
            for($i = 0; $i < strlen($valid); $i++){
                $soma += ($i % 2 == 0) ? $valid[$i] : ($valid[$i] * 3);
            }
            for($i = 0; $i <= 9; $i++){
                if(($soma + $i) % 10 == 0) return $valid.$i;
            }
    }
}
