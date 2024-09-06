<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsSeed extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name' => 'Arroz Branco',
                'sm_code' => 'ARBR',
                'description' => 'Arroz branco tipo 1, 5kg.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 15.50,
                'value' => $this->calculateValue(15.50),
                'product_amount' => 100,
                'status' => 1
            ],
            [
                'name' => 'Feijão Carioca',
                'sm_code' => 'FECA',
                'description' => 'Feijão carioca tipo 1, 1kg.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 8.90,
                'value' => $this->calculateValue(8.90),
                'product_amount' => 150,
                'status' => 1
            ],
            [
                'name' => 'Macarrão Espaguete',
                'sm_code' => 'MAES',
                'description' => 'Macarrão espaguete, 500g.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 4.80,
                'value' => $this->calculateValue(4.80),
                'product_amount' => 200,
                'status' => 1
            ],
            [
                'name' => 'Óleo de Soja',
                'sm_code' => 'OESO',
                'description' => 'Óleo de soja, 900ml.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 7.20,
                'value' => $this->calculateValue(7.20),
                'product_amount' => 180,
                'status' => 1
            ],
            [
                'name' => 'Leite Integral',
                'sm_code' => 'LEIN',
                'description' => 'Leite integral, 1 litro.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 4.50,
                'value' => $this->calculateValue(4.50),
                'product_amount' => 250,
                'status' => 1
            ],
            [
                'name' => 'Café Torrado',
                'sm_code' => 'CATO',
                'description' => 'Café torrado e moído, 500g.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 12.30,
                'value' => $this->calculateValue(12.30),
                'product_amount' => 120,
                'status' => 1
            ],
            [
                'name' => 'Açúcar Cristal',
                'sm_code' => 'ACCR',
                'description' => 'Açúcar cristal, 1kg.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 3.70,
                'value' => $this->calculateValue(3.70),
                'product_amount' => 300,
                'status' => 1
            ],
            [
                'name' => 'Sal Refinado',
                'sm_code' => 'SARE',
                'description' => 'Sal refinado, 1kg.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 2.50,
                'value' => $this->calculateValue(2.50),
                'product_amount' => 280,
                'status' => 1
            ],
            [
                'name' => 'Farinha de Trigo',
                'sm_code' => 'FATR',
                'description' => 'Farinha de trigo, 1kg.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 4.20,
                'value' => $this->calculateValue(4.20),
                'product_amount' => 150,
                'status' => 1
            ],
            [
                'name' => 'Creme de Leite',
                'sm_code' => 'CRLE',
                'description' => 'Creme de leite, 200g.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 3.90,
                'value' => $this->calculateValue(3.90),
                'product_amount' => 110,
                'status' => 1
            ],
            [
                'name' => 'Leite Condensado',
                'sm_code' => 'LECO',
                'description' => 'Leite condensado, 395g.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 6.50,
                'value' => $this->calculateValue(6.50),
                'product_amount' => 95,
                'status' => 1
            ],
            [
                'name' => 'Margarina com Sal',
                'sm_code' => 'MASA',
                'description' => 'Margarina com sal, 500g.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 5.60,
                'value' => $this->calculateValue(5.60),
                'product_amount' => 180,
                'status' => 1
            ],
            [
                'name' => 'Biscoito Recheado',
                'sm_code' => 'BIRE',
                'description' => 'Biscoito recheado sabor chocolate, 130g.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 2.90,
                'value' => $this->calculateValue(2.90),
                'product_amount' => 140,
                'status' => 1
            ],
            [
                'name' => 'Achocolatado em Pó',
                'sm_code' => 'ACPO',
                'description' => 'Achocolatado em pó, 400g.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 7.50,
                'value' => $this->calculateValue(7.50),
                'product_amount' => 130,
                'status' => 1
            ],
            [
                'name' => 'Sabão em Pó',
                'sm_code' => 'SAPO',
                'description' => 'Sabão em pó, 1kg.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 12.90,
                'value' => $this->calculateValue(12.90),
                'product_amount' => 160,
                'status' => 1
            ],
            [
                'name' => 'Detergente Líquido',
                'sm_code' => 'DELI',
                'description' => 'Detergente líquido, 500ml.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 2.20,
                'value' => $this->calculateValue(2.20),
                'product_amount' => 210,
                'status' => 1
            ],
            [
                'name' => 'Amaciante de Roupas',
                'sm_code' => 'AMRO',
                'description' => 'Amaciante de roupas, 2 litros.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 8.60,
                'value' => $this->calculateValue(8.60),
                'product_amount' => 85,
                'status' => 1
            ],
            [
                'name' => 'Papel Higiênico',
                'sm_code' => 'PAHI',
                'description' => 'Papel higiênico, pacote com 4 rolos.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 6.30,
                'value' => $this->calculateValue(6.30),
                'product_amount' => 140,
                'status' => 1
            ],
            [
                'name' => 'Creme Dental',
                'sm_code' => 'CRDE',
                'description' => 'Creme dental, 90g.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 3.80,
                'value' => $this->calculateValue(3.80),
                'product_amount' => 120,
                'status' => 1
            ],
            [
                'name' => 'Sabonete Líquido',
                'sm_code' => 'SALI',
                'description' => 'Sabonete líquido, 250ml.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 4.50,
                'value' => $this->calculateValue(4.50),
                'product_amount' => 75,
                'status' => 1
            ],
            [
                'name' => 'Desodorante Aerosol',
                'sm_code' => 'DEAER',
                'description' => 'Desodorante aerosol, 150ml.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 12.40,
                'value' => $this->calculateValue(12.40),
                'product_amount' => 50,
                'status' => 1
            ],
            [
                'name' => 'Shampoo',
                'sm_code' => 'SHAM',
                'description' => 'Shampoo para cabelos normais, 400ml.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 14.90,
                'value' => $this->calculateValue(14.90),
                'product_amount' => 60,
                'status' => 1
            ],
            [
                'name' => 'Condicionador',
                'sm_code' => 'COND',
                'description' => 'Condicionador para cabelos normais, 400ml.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 16.90,
                'value' => $this->calculateValue(16.90),
                'product_amount' => 50,
                'status' => 1
            ],
            [
                'name' => 'Água Sanitária',
                'sm_code' => 'AGSA',
                'description' => 'Água sanitária, 2 litros.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 3.60,
                'value' => $this->calculateValue(3.60),
                'product_amount' => 220,
                'status' => 1
            ],
            [
                'name' => 'Desinfetante',
                'sm_code' => 'DESE',
                'description' => 'Desinfetante multiuso, 500ml.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 5.20,
                'value' => $this->calculateValue(5.20),
                'product_amount' => 200,
                'status' => 1
            ],
            [
                'name' => 'Sabonete em Barra',
                'sm_code' => 'SABA',
                'description' => 'Sabonete em barra, 85g.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 1.90,
                'value' => $this->calculateValue(1.90),
                'product_amount' => 400,
                'status' => 1
            ],
            [
                'name' => 'Esponja de Aço',
                'sm_code' => 'ESAC',
                'description' => 'Esponja de aço, pacote com 8 unidades.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 3.50,
                'value' => $this->calculateValue(3.50),
                'product_amount' => 230,
                'status' => 1
            ],
            [
                'name' => 'Limpador Multiuso',
                'sm_code' => 'LIMU',
                'description' => 'Limpador multiuso, 500ml.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 6.90,
                'value' => $this->calculateValue(6.90),
                'product_amount' => 180,
                'status' => 1
            ],
            [
                'name' => 'Sabão Líquido',
                'sm_code' => 'SALIQ',
                'description' => 'Sabão líquido, 1 litro.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 10.90,
                'value' => $this->calculateValue(10.90),
                'product_amount' => 160,
                'status' => 1
            ],
            [
                'name' => 'Água Mineral',
                'sm_code' => 'AGMI',
                'description' => 'Água mineral sem gás, 500ml.',
                'bar_code' => $this->generateBarcode(),
                'cost' => 1.50,
                'value' => $this->calculateValue(1.50),
                'product_amount' => 500,
                'status' => 1
            ]
        ];

        DB::table('products')->insert($products);
    }

    private function generateBarcode()
    {
        return Str::random(12);
    }

    private function calculateValue($cost)
    {
        return round($cost * 1.7, 2); // Margem de 70%
    }
}
