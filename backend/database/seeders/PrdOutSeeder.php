<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PrdOutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = \App\Models\Storage\ProductsModel::get()->all();

        foreach($products as $product){
            for($i=1;$i<=1;$i++){
                $date = new Carbon("2024-0".rand(5,9)."-".rand(0,6));
                $out = \App\Models\Storage\PrdOutModel::create([
                    'id_product' => $product->id,
                    'qunt_remove' => rand(1, 10),
                    'dt_out' => $date
                ]);
                $product->update([
                    'product_amount' => max(0, intval($product->product_amount) - intval($out['qunt_remove'])) // Garante que não tenha valor negativo
                ]);
                if($out){
                    $updatedOut = \App\Models\Storage\UpdateOutModel::create([
                        'id_stock_out' => $out->id,
                        "name" =>  $product->name,
                        "value" => $product->value,
                        "cost" => $product->cost,
                        "quantity" => $product->product_amount
                    ]);
                }
            }
        }

    }
}
