<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductsModel;

class StorageController extends Controller
{
    public function index(ProductsModel $prdModel){
        return response()->json(["request" => $prdModel->get()->all()]);
    }
    public function insert(Request $request, ProductsModel $prdModel){
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
