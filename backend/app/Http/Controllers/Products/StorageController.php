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
    public function index($index, $perpage, Request $request, ProductsModel $prdModel, RolesModel $roles, PrdEntryModel $prdEntryModel, PrdOutModel $prdOutModel, PrdStockModel $prdStockModel){
        if (!$roles->admAccess($request->user())) {
            return response()->json([
                'status' => 403,
                'msg' => "SEM PERMISSÃO PARA ESSA REQUISIÇÃO"
            ], 403);
        }
    
        try {
            // Paginação dos produtos
            $products = $prdModel->paginate($perpage, ['*'], 'page', $index);
    
            // Adiciona informações de entrada e saída para cada produto
            $products->getCollection()->transform(function ($product) use ($prdEntryModel, $prdStockModel, $prdOutModel) {
                // Obtém a entrada de estoque para o produto
                $product->entries = $prdEntryModel->where('id_product', $product->id)->get();
    
                // Obtém as saídas de estoque por venda
                $product->sales_out = $prdStockModel->where('id_product', $product->id)->get();
    
                // Obtém as saídas de estoque por retirada direta
                $product->direct_out = $prdOutModel->where('id_product', $product->id)->get();
    
                return $product;
            });
    
            return response()->json($products);
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
    public function insert(Request $request, ProductsModel $prdModel, RolesModel $roles){
        if (!$roles->admAccess($request->user())) {
            return response()->json([
                'status' => 403,
                'msg' => "SEM PERMISSÃO PARA ESSA REQUISIÇÃO"
            ], 403);
        }
    
        try {
            // Extrai dados do request
            $productData = $request->only(['sm_code', 'bar_code', 'name', 'description', 'value', 'product_amount', 'status']);
            
            // Verifica se o produto já existe
            $existingProduct = $prdModel->where('sm_code', $productData['sm_code'])
                                        ->orWhere('bar_code', $productData['bar_code'])
                                        ->first();
    
            if ($existingProduct) {
                return response()->json([
                    'status' => 400,
                    'msg' => "Produto já existente com o código fornecido!",
                    'data' => $existingProduct
                ], 400);
            }
    
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
