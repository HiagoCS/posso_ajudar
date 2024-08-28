<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;

use App\Models\Storage\CashierSaleModel;
use App\Models\Storage\PrdStockModel;
use App\Models\Storage\ProductsModel;
use App\Models\Account\PGModel;
use App\Models\Account\Client;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function insert(Request $request,CashierSaleModel $csmodel, PGModel $pgmodel, Client $clntModel, PrdStockModel $prdStockModel, ProductsModel $productsModel){
        $sale = $request->all();
        $pg_method = $pgmodel->find($sale['id_pg_method']);
        $client = [];
        if($sale['client']){
            $client = $clntModel->where(function($query) use ($sale){
                if($sale['client']['cpf']){
                    $query->where("cpf", $sale['client']['cpf']);
                    if(count($query->get()) === 0) $query->create(['name' => $sale['client']['name'], 'cpf' => $sale['client']['cpf']]);
                }else if(!$sale['client']['cpf'] && $sale['client']['name']){
                    $query->where("name", $sale['client']['name']);
                    if(count($query->get()) === 0) $query->create(['name' => $sale['client']['name'], 'cpf' => null]);
                }
            })->get();
        }
        if(!$pg_method) return response()->json(["error" => "payment method invalid!!"],500);
        if(count($client) == 0){
            $csdata = $csmodel->create([
                "total_value" => floatval($sale['total_value']),
                "id_pg_method" => $pg_method->id,
                "id_client" => null
            ]);
        }else{
            $csdata = $csmodel->create([
                "total_value" => floatval($sale['total_value']),
                "id_pg_method" => $pg_method->id,
                "id_client" => $client[0]->id
            ]);
        }
        foreach($sale['products'] as $products){
            $prdStock = $prdStockModel->create([
                "id_sale" => $csdata->id,
                "id_product" => $products['id'],
                "qunt_remove" =>$products['qunt']
            ]);
            if($prdStock){
                $product = $productsModel->find($prdStock->id_product);
                $product->update(["product_amount" => (floatval($product['product_amount']) - floatval($prdStock['qunt_remove']))]);
            }

        }
        
        return $csdata;
    }
}
