<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Storage\ProductsModel;
use App\Models\Storage\PrdOutModel;
use App\Models\Storage\PrdEntryModel;
use App\Models\Storage\PrdStockModel;
use App\Models\Account\RolesModel;
use Carbon\Carbon;

class StorageController extends Controller
{
    public function stock($id, $index, $perpage, Request $request, ProductsModel $prdModel, RolesModel $roles, PrdEntryModel $prdEntryModel, PrdOutModel $prdOutModel, PrdStockModel $prdStockModel)
{
    if (!$roles->admAccess($request->user())) {
        return response()->json([
            'status' => 403,
            'msg' => "SEM PERMISSÃO PARA ESSA REQUISIÇÃO"
        ], 403);
    }

    try {
        // Busca o produto específico pelo id
        $product = $prdModel->find($id);
        
        if (!$product) {
            return response()->json([
                'status' => 404,
                'msg' => 'Produto não encontrado'
            ], 404);
        }

        // Busca entradas de estoque do produto
        $entries = $prdEntryModel->where('id_product', $id)->get()->map(function ($entry) {
            return [
                'type' => 'entry',
                'quantity' => $entry->qunt_toAdd,
                'date' => $entry->dt_entry
            ];
        });

        // Busca saídas de estoque por venda
        $sales_out = $prdStockModel->where('id_product', $id)->get()->map(function ($sale) {
            return [
                'type' => 'sale',
                'quantity' => $sale->qunt_remove,
                'date' => $sale->dt_sale
            ];
        });

        // Busca saídas de estoque por retirada direta
        $direct_out = $prdOutModel->where('id_product', $id)->get()->map(function ($out) {
            return [
                'type' => 'direct_out',
                'quantity' => $out->qunt_remove,
                'date' => $out->dt_out
            ];
        });

        // Junta todas as entradas e saídas
        $stockMovements = $entries->concat($sales_out)->concat($direct_out);

        // Ordena pelo campo 'date' de forma decrescente (mais recentes primeiro)
        $sortedMovements = $stockMovements->sortByDesc('date')->values();

        // Adiciona as informações ao produto
        $product->movements = $sortedMovements;

        // Retorna o produto com suas movimentações de estoque paginadas
        return response()->json([
            'product' => $product
        ]);

    } catch (\Throwable $th) {
        return response()->json([
            'status' => 500,
            'msg' => 'Erro ao buscar informações de estoque',
            'data' => $th->getMessage()
        ], 500);
    }
}

    public function index($index, $perpage, Request $request, ProductsModel $prdModel, RolesModel $roles, PrdEntryModel $prdEntryModel, PrdOutModel $prdOutModel, PrdStockModel $prdStockModel){
        if (!$roles->admAccess($request->user())) {
            return response()->json([
                'status' => 403,
                'msg' => "SEM PERMISSÃO PARA ESSA REQUISIÇÃO"
            ], 403);
        }
    
        try {
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'msg' => 'Erro ao buscar produtos e informações de estoque',
                'data' => $th->getMessage()
            ], 500);
        }
    }
    public function search($term, $search, ProductsModel $prdModel){
        /* $search = $request->all(); */
        $results = [];
        if($term==='name') $results['name'] = $prdModel->searchName($search);
        if($term==='sm_code') $results['sm_code'] = $prdModel->searchSmallCode($search);
        if($term==='bar_code') $results['bar_code'] = $prdModel->searchBarCode($search);
        if($term==='id') $results['id'] = $prdModel->searchId($search);
        if(empty($results)) return $prdModel->all();
        return response()->json($results);
    }
    public function insert(Request $request, ProductsModel $prdModel, RolesModel $roles, PrdEntryModel $prdEntryModel, PrdOutModel $prdOutModel, PrdStockModel $prdStockModel){
        if (!$roles->admAccess($request->user())) {
            return response()->json([
                'status' => 403,
                'msg' => "SEM PERMISSÃO PARA ESSA REQUISIÇÃO"
            ], 403);
        }
    
        try {
            // Extrai dados do request
            $productData = $request->only(['sm_code', 'bar_code', 'name', 'description', 'value', 'product_amount', 'status', 'cost']);
    
            // Cria o novo produto
            $product = $prdModel->create($productData);
    
            // Obtém a data atual usando Carbon
            $currentDate = Carbon::now()->toDateString(); // ou toDateTimeString() se precisar do horário
    
            // Prepara os dados da entrada
            $entryData = [
                'id_product' => $product->id,
                'qunt_toAdd' => $product->product_amount, // Quantidade a adicionar no estoque
                'dt_entry' => $currentDate // Data da entrada
            ];
    
            // Cria o registro de entrada de estoque
            $prdEntryModel->create($entryData);
    
            return response()->json([
                "status" => 200,
                'msg' => "Produto " . $product->name . " inserido com sucesso!",
                'data' => $product
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'data' => 'Erro no registro de Produtos - ManagerController',
                'msg' => $th->getMessage()
            ], 500);
        }
    }
    public function update($id, Request $request, ProductsModel $prdModel, RolesModel $roles){
        if(!$roles->admAccess($request->user()))
            return "SEM PERMISSÃO PARA ESSA REQUISIÇÃO";
        try{
            $product = $prdModel->find($id);
            if($request['bar_code']){
                $bcode = $product['bar_code'];
                if($bcode != $prdModel->EAN13Validation($bcode))
                    return response()->json([
                        'status' => 500,
                        'data' => 'Erro, código de barras não validado!! - ManagerController'
                    ], 500);
            }
            if(intval($request['product_amount']) > intval($product['product_amount'])){
                $date = Carbon::now()->format('Y-m-d');
                $entry = \App\Models\Storage\PrdEntryModel::create([
                    'id_product' => $product->id,
                    'qunt_toAdd' => intval($request['product_amount'])-intval($product['product_amount']),
                    'dt_entry' => $date
                ]);
            }
            if(intval($request['product_amount']) < intval($product['product_amount'])){
                $date = Carbon::now()->format('Y-m-d');
                $out = \App\Models\Storage\PrdOutModel::create([
                    'id_product' => $product->id,
                    'qunt_remove' => intval($product['product_amount'])-intval($request['product_amount']),
                    'dt_out' => $date
                ]);
            }
           
            if($product->update($request->all())) 
                return response()->json([
                    "status" => 200,
                    'msg' => "Produto ".$product['name']." atualizado com sucesso!",
                    'data' => $product
                ]);
        } catch (\Throwable $th) {
        return response()->json([
            'status' => 500,
            'data' => 'Erro na edição de Produtos - ManagerController',
            'msg' => $th->getMessage()
        ], 500);
        }
    }
    public function delete($id,Request $request, ProductsModel $prdModel,  RolesModel $roles){
        if(!$roles->admAccess($request->user()))
            return "SEM PERMISSÃO PARA ESSA REQUISIÇÃO";
        try{
            $product = $prdModel->find($id);
            if(!isset($product)) return response()->json([
                'status' => 500,
                'data' => 'Erro, produto não encontrado! - ManagerController'
            ], 500);
            if($product->delete()) 
                return response()->json([
                    "status" => 200,
                    'msg' => "Produto ".$product['name']." deletado com sucesso!",
                    'data' => $product
                ]);
        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'data' => 'Erro na exclusão de Produtos - ManagerController',
                'msg' => $th->getMessage()
            ], 500);
            }
    }
}
