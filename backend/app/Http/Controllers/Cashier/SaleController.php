<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;

use App\Models\Storage\CashierSaleModel;
use App\Models\Storage\PrdStockModel;
use App\Models\Storage\ProductsModel;
use App\Models\Storage\UpdateSaleModel;
use App\Models\Account\PGModel;
use App\Models\Account\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SaleController extends Controller
{
    public function insert(Request $request, PGModel $pgmodel, Client $clntModel, CashierSaleModel $csmodel, PrdStockModel $prdStockModel, ProductsModel $productsModel){
        $sale = $request->all();
        $pg_method = $pgmodel->find($sale['id_pg_method']);
        $date = Carbon::now();

        // Validação do método de pagamento
        if (!$pg_method) {
            return response()->json(["error" => "Método de pagamento inválido!"], 500);
        }

        // Busca ou cria cliente
        $client = null;
        if (isset($sale['client'])) {
            $client = $clntModel->firstOrCreate(
                ['cpf' => $sale['client']['cpf']],
                ['name' => $sale['client']['name']]
            );
        }

        // Criação da venda no caixa
        $csdata = $csmodel->create([
            'dt_sale' => $date->format("Y-m-d"),
            'total_value' => floatval($sale['total_value']),
            'id_pg_method' => $pg_method->id,
            'id_client' => $client ? $client->id : null
        ]);

        // Processa cada produto vendido
        foreach ($sale['products'] as $productData) {
            // Atualiza o estoque do produto
            $prdStock = $prdStockModel->create([
                'dt_sale' => $date->format("Y-m-d"),
                'id_sale' => $csdata->id,
                'id_product' => $productData['id'],
                'qunt_remove' => $productData['qunt']
            ]);

            if ($prdStock) {
                $product = $productsModel->find($productData['id']);

                // Atualiza a quantidade do produto no estoque
                $newQuantity = floatval($product->product_amount) - floatval($prdStock->qunt_remove);
                $product->update(['product_amount' => $newQuantity]);

                // Registra o estado do produto no momento da venda
                UpdateSaleModel::create([
                    'id_stock_sale' => $prdStock->id,
                    'name' => $product->name,
                    'value' => $product->value,
                    'cost' => $product->cost,
                    'quantity' => $newQuantity
                ]);
            }
        }

        // Retorna a venda registrada
        return response()->json([
            'sale' => $csdata,
            'message' => 'Venda registrada com sucesso!'
        ], 200);
    }
    public function getPayments(){
        return PGModel::all();
    }
    public function getClients(){
        return Client::all();
    }
}
