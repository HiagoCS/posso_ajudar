<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PrdEntrysSeeder extends Seeder
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
                \App\Models\Storage\PrdEntryModel::create([
                    'id_product' => $product->id,
                    'qunt_toAdd' => $product->product_amount,
                    'dt_entry' => $date
                ]);
            }
        }
    }
}