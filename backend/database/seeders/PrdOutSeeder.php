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
        $products = \App\Models\Storage\ProductsModel::all();
        $outs = [];
        for ($i = 0; $i < 10; $i++) { 
            $product = $products[$i];

            $outs[] = [
                'id_product' => $product->id,
                'qunt_remove' => rand(1, 10),
                'dt_out' => Carbon::createFromFormat('Y-m-d', '2024-0'.rand(5, 9).'-'.rand(1, 28))->format('Y-m-d')
            ];
            $product->update([
                'product_amount' => max(0, intval($product->product_amount) - intval($outs[$i]['qunt_remove'])) // Garante que não tenha valor negativo
            ]);
        }
        \App\Models\Storage\PrdOutModel::insert($outs);

    }
}
