<?php

namespace App\Models\Storage;

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

    public $timestamps = false;
    public function searchId($search){
        return $this->where(function ($query) use($search){
            $query->where('status', '!=', '0')->find($search);
        })->get()->first();
    }
    public function searchName($search){
        return $this->where(function ($query) use($search){
            $query->orWhere("name", "like", "%".$search."%")
            ->where('status', '!=', '0')->orderBy("name");
        })->get()->all();
    }
    public function searchSmallCode($search){
        return $this->where(function ($query) use($search){
            $query->orWhere("sm_code", "like", "%".$search."%")
            ->where('status', '!=', '0')->orderBy("sm_code");
        })->get()->all();
    }
    public function searchBarCode($search){
        return $this->where(function ($query) use($search){
            $query->orWhere("bar_code", "like", "%".$search."%")
            ->where('status', '!=', '0')->orderBy("bar_code");
        })->get()->all();
    }
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
