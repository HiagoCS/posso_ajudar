<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Storage\ProductsModel;

class ProductsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductsModel::create([
            'sm_code' => 'BL1234',
            'bar_code' => '7891234567890',
            'name' => 'Bolacha Maria',
            'description' => 'Bolacha Maria tradicional, pacote de 400g',
            'value' => 3.99,
            'product_amount' => 150,
            'status' => 1,
        ]);

        ProductsModel::create([
            'sm_code' => 'RF5678',
            'bar_code' => '7892345678901',
            'name' => 'Refrigerante Coca-Cola',
            'description' => 'Refrigerante Coca-Cola 2L',
            'value' => 7.49,
            'product_amount' => 200,
            'status' => 1,
        ]);

        ProductsModel::create([
            'sm_code' => 'RC9101',
            'bar_code' => '7893456789012',
            'name' => 'Refrigerante Guaraná Antártica',
            'description' => 'Refrigerante Guaraná Antártica 2L',
            'value' => 6.99,
            'product_amount' => 180,
            'status' => 1,
        ]);

        ProductsModel::create([
            'sm_code' => 'CH2345',
            'bar_code' => '7894567890123',
            'name' => 'Chocolate Lacta Ao Leite',
            'description' => 'Barra de Chocolate Lacta Ao Leite 170g',
            'value' => 8.99,
            'product_amount' => 120,
            'status' => 1,
        ]);

        ProductsModel::create([
            'sm_code' => 'MX6789',
            'bar_code' => '7895678901234',
            'name' => 'Margarina Qualy',
            'description' => 'Margarina Qualy 500g',
            'value' => 4.79,
            'product_amount' => 90,
            'status' => 1,
        ]);

        ProductsModel::create([
            'sm_code' => 'PS1011',
            'bar_code' => '7896789012345',
            'name' => 'Pão de Forma Pullman',
            'description' => 'Pão de Forma Pullman Tradicional 500g',
            'value' => 6.49,
            'product_amount' => 80,
            'status' => 1,
        ]);

        ProductsModel::create([
            'sm_code' => 'CR1213',
            'bar_code' => '7897890123456',
            'name' => 'Creme Dental Colgate',
            'description' => 'Creme Dental Colgate Total 12, 90g',
            'value' => 3.29,
            'product_amount' => 160,
            'status' => 1,
        ]);

        ProductsModel::create([
            'sm_code' => 'SA1415',
            'bar_code' => '7898901234567',
            'name' => 'Sabão em Pó Omo',
            'description' => 'Sabão em Pó Omo 1kg',
            'value' => 10.99,
            'product_amount' => 130,
            'status' => 1,
        ]);

        ProductsModel::create([
            'sm_code' => 'CF1617',
            'bar_code' => '7899012345678',
            'name' => 'Café Pilão',
            'description' => 'Café Pilão Torrado e Moído 500g',
            'value' => 12.49,
            'product_amount' => 70,
            'status' => 1,
        ]);

        ProductsModel::create([
            'sm_code' => 'AR1819',
            'bar_code' => '7890123456789',
            'name' => 'Arroz Tio João',
            'description' => 'Arroz Branco Tio João Tipo 1, 1kg',
            'value' => 5.99,
            'product_amount' => 200,
            'status' => 1,
        ]);

        ProductsModel::create([
            'sm_code' => 'FE2021',
            'bar_code' => '7891234567801',
            'name' => 'Feijão Carioca Kicaldo',
            'description' => 'Feijão Carioca Kicaldo 1kg',
            'value' => 7.89,
            'product_amount' => 190,
            'status' => 1,
        ]);

        ProductsModel::create([
            'sm_code' => 'AZ2223',
            'bar_code' => '7892345678912',
            'name' => 'Açúcar União',
            'description' => 'Açúcar Refinado União 1kg',
            'value' => 4.29,
            'product_amount' => 210,
            'status' => 1,
        ]);

        ProductsModel::create([
            'sm_code' => 'MC2425',
            'bar_code' => '7893456789123',
            'name' => 'Macarrão Instantâneo Nissin',
            'description' => 'Macarrão Instantâneo Nissin Lámen Galinha 85g',
            'value' => 1.99,
            'product_amount' => 300,
            'status' => 1,
        ]);

        ProductsModel::create([
            'sm_code' => 'ML2627',
            'bar_code' => '7894567891234',
            'name' => 'Molho de Tomate Elefante',
            'description' => 'Extrato de Tomate Elefante 340g',
            'value' => 2.99,
            'product_amount' => 140,
            'status' => 1,
        ]);

        ProductsModel::create([
            'sm_code' => 'OL2829',
            'bar_code' => '7895678902345',
            'name' => 'Óleo de Soja Soya',
            'description' => 'Óleo de Soja Soya 900ml',
            'value' => 8.49,
            'product_amount' => 110,
            'status' => 1,
        ]);

        ProductsModel::create([
            'sm_code' => 'RF3031',
            'bar_code' => '7896789013456',
            'name' => 'Refrigerante Fanta Laranja',
            'description' => 'Refrigerante Fanta Laranja 2L',
            'value' => 6.79,
            'product_amount' => 170,
            'status' => 1,
        ]);

        ProductsModel::create([
            'sm_code' => 'MA3233',
            'bar_code' => '7897890124567',
            'name' => 'Maionese Hellmann\'s',
            'description' => 'Maionese Hellmann\'s Tradicional 500g',
            'value' => 10.49,
            'product_amount' => 100,
            'status' => 1,
        ]);

        ProductsModel::create([
            'sm_code' => 'FR3435',
            'bar_code' => '7898901235678',
            'name' => 'Farinha de Trigo Dona Benta',
            'description' => 'Farinha de Trigo Dona Benta 1kg',
            'value' => 4.79,
            'product_amount' => 150,
            'status' => 1,
        ]);

        ProductsModel::create([
            'sm_code' => 'LE3637',
            'bar_code' => '7899012346789',
            'name' => 'Leite Integral Parmalat',
            'description' => 'Leite Integral Parmalat 1L',
            'value' => 3.49,
            'product_amount' => 130,
            'status' => 1,
        ]);

        ProductsModel::create([
            'sm_code' => 'CR3839',
            'bar_code' => '7890123457890',
            'name' => 'Creme de Leite Nestlé',
            'description' => 'Creme de Leite Nestlé 200g',
            'value' => 4.99,
            'product_amount' => 140,
            'status' => 1,
        ]);
    }
}
