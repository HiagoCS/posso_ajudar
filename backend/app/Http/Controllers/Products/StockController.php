<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\Storage\ProductsModel;
use App\Models\Storage\PrdOutModel;
use App\Models\Storage\PrdEntryModel;
use App\Models\Storage\PrdStockModel;
use App\Models\Storage\UpdateEntryModel;
use App\Models\Storage\UpdateOutModel;
use App\Models\Storage\UpdateSaleModel;
use App\Models\Account\RolesModel;
use Carbon\Carbon;

class StockController extends Controller
{
    public function index($id, $index, $perpage, 
    Request $request, 
    ProductsModel $prdModel, 
    RolesModel $roles, 
    PrdEntryModel $prdEntryModel, 
    PrdOutModel $prdOutModel, 
    PrdStockModel $prdStockModel,
    UpdateEntryModel $updateEntryModel,
    UpdateOutModel $updateOutModel,
    UpdateSaleModel $updateSaleModel
    ){
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
        $entries = $prdEntryModel->where('id_product', $id)->get()->map(function ($entry) use ($updateEntryModel) {
            $update = $updateEntryModel->where('id_stock_entry', $entry->id)->first();
            return [
                'id' => $entry->id,
                'type' => 'entry',
                'quantity' => $entry->qunt_toAdd,
                'date' => $entry->dt_entry,
                'state' => $update ? [
                    'name' => $update->name,
                    'value' => $update->value,
                    'cost' => $update->cost,
                    'quantity' => $update->quantity
                ] : null
            ];
        });

        // Busca saídas de estoque por venda
        $sales_out = $prdStockModel->where('id_product', $id)->get()->map(function ($sale) use ($updateSaleModel) {
            $update = $updateSaleModel->where('id_stock_sale', $sale->id)->first();
            return [
                'id' => $sale->id,
                'type' => 'sale',
                'quantity' => $sale->qunt_remove,
                'date' => $sale->dt_sale,
                'state' => $update ? [
                    'name' => $update->name,
                    'value' => $update->value,
                    'cost' => $update->cost,
                    'quantity' => $update->quantity
                ] : null
            ];
        });

        // Busca saídas de estoque por retirada direta
        $direct_out = $prdOutModel->where('id_product', $id)->get()->map(function ($out) use ($updateOutModel) {
            $update = $updateOutModel->where('id_stock_out', $out->id)->first();
            return [
                'id' => $out->id,
                'type' => 'direct_out',
                'quantity' => $out->qunt_remove,
                'date' => $out->dt_out,
                'state' => $update ? [
                    'name' => $update->name,
                    'value' => $update->value,
                    'cost' => $update->cost,
                    'quantity' => $update->quantity
                ] : null
            ];
        });
        // Junta todas as entradas e saídas
        $stockMovements = $entries->concat($sales_out)->concat($direct_out);

        // Ordena pelo campo 'date' de forma decrescente (mais recentes primeiro)
        $sortedMovements = $stockMovements->sortByDesc('date')->values();

        $currentPage = $index;
        $perPage = $perpage;
        $currentPageItems = $sortedMovements->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedMovements = new LengthAwarePaginator(
            $currentPageItems,
            $sortedMovements->count(), // Número total de itens
            $perPage, // Itens por página
            $currentPage, // Página atual
            ['path' => request()->url(), 'query' => request()->query()] // Para manter a URL e os parâmetros de query
        );

        // Adiciona as informações ao produto
        $product->movements = $paginatedMovements;

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
public function update($id, $type, $id_product, Request $request, PrdEntryModel $prdEntryModel, PrdOutModel $prdOutModel, PrdStockModel $prdStockModel, RolesModel $roles, UpdateEntryModel $updateEntryModel, UpdateOutModel $updateOutModel, UpdateSaleModel $updateSaleModel){
        
}
public function delete($id, $type, $id_product, Request $request, PrdEntryModel $prdEntryModel, PrdOutModel $prdOutModel, PrdStockModel $prdStockModel, RolesModel $roles, UpdateEntryModel $updateEntryModel, UpdateOutModel $updateOutModel, UpdateSaleModel $updateSaleModel){
    if(!$roles->admAccess($request->user()))
            return "SEM PERMISSÃO PARA ESSA REQUISIÇÃO";
        try{
            if($type==='entry') $stock = $prdEntryModel->where('id_product', $id_product)->get()->first();
            if($type==='direct_out') $stock = $prdOutModel->where('id_product', $id_product)->get()->first();
            if($type==='sale') $stock = $prdStockModel->where('id_product', $id_product)->get()->first();
            if(!isset($stock)) return response()->json([
                'status' => 500,
                'data' => 'Erro, movimentação não encontrada! - StockController'
            ], 500);

            if($type==='entry') $updateStock = $updateEntryModel->where('id_stock_entry', $stock->id)->get()->first();
            if($type==='direct_out') $updateStock = $updateOutModel->where('id_stock_out', $stock->id)->get()->first();
            if($type==='sale') $updateStock = $updateSaleModel->where('id_stock_sale', $stock->id)->get()->first();
            if(!isset($updateStock)) return response()->json([
                'status' => 500,
                'data' => 'Erro, tabela de atualização do movimento não encontrada! - StockController'
            ], 500);
            if($updateStock->delete()){
                if($stock->delete()) 
                return response()->json([
                    "status" => 200,
                    'msg' => "Movimento ".$type."#".$stock['id']." deletado com sucesso!",
                    'data' => $stock
                ]);
            }
        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'data' => 'Erro na exclusão de Produtos - StockController',
                'msg' => $th->getMessage()
            ], 500);
        }
}
}
