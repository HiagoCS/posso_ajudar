<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Storage\ProductsModel;
use App\Models\Account\RolesModel;

class StorageController extends Controller
{
    /* if(!$roles->bossAccess($request->user()))
            return "SEM PERMISSÃO PARA ESSA REQUISIÇÃO"; */
    public function index(Request $request, ProductsModel $prdModel, RolesModel $roles){
        if(!$roles->admAccess($request->user()))
            return "SEM PERMISSÃO PARA ESSA REQUISIÇÃO";
        return response()->json($prdModel->get()->all());
    }
    public function search($term, $search, ProductsModel $prdModel){
        /* $search = $request->all(); */
        $results = [];
        if($term==='name') $results['name'] = $prdModel->searchName($search);
        if($term==='sm_code') $results['sm_code'] = $prdModel->searchSmallCode($search);
        if($term==='bar_code') $results['bar_code'] = $prdModel->searchBarCode($search);
        if(empty($results)) return $prdModel->all();
        return response()->json($results);
    }
    public function insert(Request $request, ProductsModel $prdModel){
        if(!$roles->admAccess($request->user()))
            return "SEM PERMISSÃO PARA ESSA REQUISIÇÃO";
        try{
            $products = $request->all();
            $bcode = $products['bar_code'];
            if($bcode != $prdModel->EAN13Validation($bcode))
                return response()->json([
                    'status' => 500,
                    'data' => 'Erro, código de barras não validado!! - ManagerController'
                ], 500);
            if($prdModel->create($products)) 
                return response()->json([
                    "status" => 200,
                    'msg' => "Produto ".$products['name']." inserido com sucesso!",
                    'data' => $products
                ]);
        } catch (\Throwable $th) {
        return response()->json([
            'status' => 500,
            'data' => 'Erro no registro de Produtos - ManagerController',
            'msg' => $th->getMessage()
        ], 500);
        }
    }
    public function update($id, Request $request, ProductsModel $prdModel){
        if(!$roles->admAccess($request->user()))
            return "SEM PERMISSÃO PARA ESSA REQUISIÇÃO";
        try{
            $product = $prdModel->find($id);
            $bcode = $product['bar_code'];
            if($bcode != $prdModel->EAN13Validation($bcode))
                return response()->json([
                    'status' => 500,
                    'data' => 'Erro, código de barras não validado!! - ManagerController'
                ], 500);
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
    public function delete($id, ProductsModel $prdModel){
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
