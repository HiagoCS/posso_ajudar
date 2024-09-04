<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Storage\ProductsModel;
use App\Models\Storage\PrdEntryModel;
use App\Models\Storage\PrdOutModel;
use App\Models\Storage\CashierSaleModel;
use App\Models\Storage\PrdStockModel; // Adicionado para incluir a model PrdStock
use App\Models\Account\Client;
use App\Models\Account\PGModel;
use Faker\Factory as Faker;

class SalesSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Cria alguns produtos fictícios
        $products = ProductsModel::all();

        // Cria alguns clientes fictícios
        $clients = [];
        for ($i = 0; $i < 5; $i++) {
            $clients[] = Client::create([
                'name' => $faker->name,
                'cpf' => $faker->unique()->numerify('###########'), // CPF fictício
                'id_fav_pg_method' => PGModel::inRandomOrder()->first()->id // Associa com um método de pagamento existente
            ]);
        }

        // Cria algumas vendas fictícias
        foreach ($clients as $client) {
            $sale = CashierSaleModel::create([
                'total_value' => $faker->randomFloat(2, 50, 200), // Valor total da venda
                'id_pg_method' => PGModel::inRandomOrder()->first()->id, // Método de pagamento
                'id_client' => $client->id, // Cliente associado
                'dt_sale' => $faker->date('Y-m-d') // Data da venda
            ]);

            // Adiciona saídas de produtos
            foreach ($products as $product) {
                // Simula entrada de produto
                PrdEntryModel::create([
                    'id_product' => $product->id,
                    'qunt_toAdd' => $faker->numberBetween(1, 10), // Quantidade adicionada
                    'dt_entry' => $faker->date('Y-m-d') // Data da entrada
                ]);

                // Simula saída de produto
                PrdOutModel::create([
                    'id_product' => $product->id,
                    'qunt_remove' => $faker->numberBetween(1, 10), // Quantidade removida
                    'dt_out' => $faker->date('Y-m-d') // Data da saída
                ]);

                // Simula a saída de produtos por venda
                PrdStockModel::create([
                    'id_sale' => $sale->id,
                    'id_product' => $product->id,
                    'qunt_remove' => $faker->numberBetween(1, 10), // Quantidade removida
                    'dt_sale' => $faker->date('Y-m-d') // Data da venda
                ]);
            }
        }
    }
}
