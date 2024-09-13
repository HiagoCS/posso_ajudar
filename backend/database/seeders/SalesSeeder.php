<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $products = \App\Models\Storage\ProductsModel::get()->all();
        foreach($products as $product){
            for($i=1;$i<=1;$i++){
                $sales = [
                    "id_product" => $product->id,
                    "qunt_remove" => rand(1, 10)
                ];
                $date = new Carbon('2024-0'.rand(5, 9).'-'.rand(1, 6));
                $cashiersale = \App\Models\Storage\CashierSaleModel::create([
                    'total_value' => $products[rand(1, 29)]->value * rand(1, 5),
                    'id_pg_method' => rand(1, 4),
                    'id_client' => null,
                    'dt_sale' => $date->format("Y-m-d")
                ]);
                if (!isset($sales['id_sale'])) {
                    $sales['id_sale'] = $cashiersale->id;
                    $sales['dt_sale'] = $cashiersale->dt_sale;

                    $prd = \App\Models\Storage\ProductsModel::find($sales['id_product']);
                    
                    $prd->update(['product_amount' => strval(intval($prd['product_amount']) - intval($sales['qunt_remove']))]);
                    $sale = \App\Models\Storage\PrdStockModel::create($sales);
                    if($sale){
                        $updatedSale = \App\Models\Storage\UpdateSaleModel::create([
                            'id_stock_sale' => $sale->id,
                            "name" =>  $prd->name,
                            "value" => $prd->value,
                            "cost" => $prd->cost,
                            "quantity" => $prd->product_amount
                        ]);
                    }
                    break;
                }
                
            }
        }
    }
    /* {
        $products = \App\Models\Storage\ProductsModel::all();
        $entries = []; // Corrigir o nome para refletir múltiplas entradas

        for ($i = 0; $i <= 10; $i++) {
            for($ia = 1; $ia <= 1; $ia++) {
                array_push($entries, [
                    "id_product" => $products[$i]->id,
                    "qunt_remove" => rand(1, 10)
                ]);
            }
        }

        for ($i = 0; $i <= 10; $i++) {
            $date = new Carbon('2024-0'.rand(5, 9).'-'.rand(1, 6)); // Garante datas válidas
            $cashiersale = \App\Models\Storage\CashierSaleModel::create([
                'total_value' => $products[rand(1, 29)]->value * rand(1, 5),
                'id_pg_method' => rand(1, 4),
                'id_client' => null,
                'dt_sale' => $date->format("Y-m-d")
            ]);

            // Adiciona as informações da venda ao array de entradas
            foreach($entries as $key => $entry) {
                if (!isset($entries[$key]['id_sale'])) {
                    $entries[$key]['id_sale'] = $cashiersale->id;
                    $entries[$key]['dt_sale'] = $cashiersale->dt_sale;

                    $prd = \App\Models\Storage\ProductsModel::find($entries[$key]['id_product']);
                    
                    $prd->update(['product_amount' => strval(intval($prd['product_amount']) - intval($entries[$key]['qunt_remove']))]);
                    break;
                }
            }
        }

        // Inserir todas as entradas de uma vez
        \App\Models\Storage\PrdStockModel::insert($entries);
    } */
}
