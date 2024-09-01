<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Storage\ProductsModel;
use Faker\Factory as Faker;

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
            ['name' => 'Bolacha Maria', 'description' => 'Bolacha Maria tradicional, pacote de 400g', 'value' => 3.99, 'product_amount' => 150, 'sm_code' => 'BMT400G'],
            ['name' => 'Refrigerante Coca-Cola', 'description' => 'Refrigerante Coca-Cola 2L', 'value' => 7.49, 'product_amount' => 200, 'sm_code' => 'RFCC2L'],
            ['name' => 'Refrigerante Guaraná Antártica', 'description' => 'Refrigerante Guaraná Antártica 2L', 'value' => 6.99, 'product_amount' => 180, 'sm_code' => 'RFGA2L'],
            ['name' => 'Chocolate Lacta Ao Leite', 'description' => 'Barra de Chocolate Lacta Ao Leite 170g', 'value' => 8.99, 'product_amount' => 120, 'sm_code' => 'CLAL170G'],
            ['name' => 'Margarina Qualy', 'description' => 'Margarina Qualy 500g', 'value' => 4.79, 'product_amount' => 90, 'sm_code' => 'MQ500G'],
            ['name' => 'Pão de Forma Pullman', 'description' => 'Pão de Forma Pullman Tradicional 500g', 'value' => 6.49, 'product_amount' => 80, 'sm_code' => 'PFPT500G'],
            ['name' => 'Creme Dental Colgate', 'description' => 'Creme Dental Colgate Total 12, 90g', 'value' => 3.29, 'product_amount' => 160, 'sm_code' => 'CDCT90G'],
            ['name' => 'Sabão em Pó Omo', 'description' => 'Sabão em Pó Omo 1kg', 'value' => 10.99, 'product_amount' => 130, 'sm_code' => 'SPO1K'],
            ['name' => 'Café Pilão', 'description' => 'Café Pilão Torrado e Moído 500g', 'value' => 12.49, 'product_amount' => 70, 'sm_code' => 'CPT500G'],
            ['name' => 'Arroz Tio João', 'description' => 'Arroz Branco Tio João Tipo 1, 1kg', 'value' => 5.99, 'product_amount' => 200, 'sm_code' => 'ATJ1K'],
            ['name' => 'Feijão Carioca Kicaldo', 'description' => 'Feijão Carioca Kicaldo 1kg', 'value' => 7.89, 'product_amount' => 190, 'sm_code' => 'FCK1K'],
            ['name' => 'Açúcar União', 'description' => 'Açúcar Refinado União 1kg', 'value' => 4.29, 'product_amount' => 210, 'sm_code' => 'AU1K'],
            ['name' => 'Macarrão Instantâneo Nissin', 'description' => 'Macarrão Instantâneo Nissin Lámen Galinha 85g', 'value' => 1.99, 'product_amount' => 300, 'sm_code' => 'MINLG85G'],
            ['name' => 'Molho de Tomate Elefante', 'description' => 'Extrato de Tomate Elefante 340g', 'value' => 2.99, 'product_amount' => 140, 'sm_code' => 'MT340G'],
            ['name' => 'Óleo de Soja Soya', 'description' => 'Óleo de Soja Soya 900ml', 'value' => 8.49, 'product_amount' => 110, 'sm_code' => 'OSS900ML'],
            ['name' => 'Refrigerante Fanta Laranja', 'description' => 'Refrigerante Fanta Laranja 2L', 'value' => 6.79, 'product_amount' => 170, 'sm_code' => 'RFL2L'],
            ['name' => 'Maionese Hellmann\'s', 'description' => 'Maionese Hellmann\'s Tradicional 500g', 'value' => 10.49, 'product_amount' => 100, 'sm_code' => 'MH500G'],
            ['name' => 'Farinha de Trigo Dona Benta', 'description' => 'Farinha de Trigo Dona Benta 1kg', 'value' => 4.79, 'product_amount' => 150, 'sm_code' => 'FTDB1K'],
            ['name' => 'Leite Integral Parmalat', 'description' => 'Leite Integral Parmalat 1L', 'value' => 3.49, 'product_amount' => 130, 'sm_code' => 'LIP1L'],
            ['name' => 'Creme de Leite Nestlé', 'description' => 'Creme de Leite Nestlé 200g', 'value' => 4.99, 'product_amount' => 140, 'sm_code' => 'CLN200G'],
            ['name' => 'Biscoito Recheado Bono', 'description' => 'Biscoito Recheado Bono Chocolate 130g', 'value' => 4.49, 'product_amount' => 80, 'sm_code' => 'BRB130G'],
            ['name' => 'Detergente Ypê', 'description' => 'Detergente Ypê 500ml', 'value' => 2.99, 'product_amount' => 160, 'sm_code' => 'DY500ML'],
            ['name' => 'Sabonete Dove', 'description' => 'Sabonete Dove Hidratante 90g', 'value' => 2.79, 'product_amount' => 200, 'sm_code' => 'SDH90G'],
            ['name' => 'Fralda Pampers', 'description' => 'Fralda Pampers Comfort Sec Tamanho M', 'value' => 34.99, 'product_amount' => 60, 'sm_code' => 'FPCS-M'],
            ['name' => 'Shampoo Seda', 'description' => 'Shampoo Seda Anti-Queda 400ml', 'value' => 8.99, 'product_amount' => 100, 'sm_code' => 'SSAQ400ML'],
            ['name' => 'Condicionador Seda', 'description' => 'Condicionador Seda Anti-Queda 400ml', 'value' => 8.99, 'product_amount' => 100, 'sm_code' => 'CSAQ400ML'],
            ['name' => 'Aspirina', 'description' => 'Aspirina Adulto 20 Comprimidos', 'value' => 5.49, 'product_amount' => 70, 'sm_code' => 'AA20C'],
            ['name' => 'Vitamina C', 'description' => 'Vitamina C 60 Cápsulas', 'value' => 15.99, 'product_amount' => 50, 'sm_code' => 'VC60C'],
            ['name' => 'Cereal Kellogg\'s', 'description' => 'Cereal Kellogg\'s Corn Flakes 300g', 'value' => 6.49, 'product_amount' => 90, 'sm_code' => 'CKCF300G'],
            ['name' => 'Amaciante Downy', 'description' => 'Amaciante Downy 1L', 'value' => 7.29, 'product_amount' => 110, 'sm_code' => 'AD1L'],
            ['name' => 'Desinfetante Pinho Sol', 'description' => 'Desinfetante Pinho Sol 500ml', 'value' => 4.99, 'product_amount' => 140, 'sm_code' => 'DPS500ML'],
            ['name' => 'Sopa Instantânea Knorr', 'description' => 'Sopa Instantânea Knorr Galinha 65g', 'value' => 1.79, 'product_amount' => 200, 'sm_code' => 'SIK65G'],
            ['name' => 'Queijo Parmesão', 'description' => 'Queijo Parmesão Ralado 150g', 'value' => 9.99, 'product_amount' => 80, 'sm_code' => 'QPR150G'],
            ['name' => 'Maionese Heinz', 'description' => 'Maionese Heinz 400g', 'value' => 6.49, 'product_amount' => 100, 'sm_code' => 'MH400G'],
            ['name' => 'Café Expresso', 'description' => 'Café Expresso Tradicional 250g', 'value' => 11.99, 'product_amount' => 90, 'sm_code' => 'CET250G'],
            ['name' => 'Lata de Atum', 'description' => 'Lata de Atum Gomes da Costa 170g', 'value' => 4.29, 'product_amount' => 110, 'sm_code' => 'LAGC170G'],
            ['name' => 'Barrinha de Cereal', 'description' => 'Barrinha de Cereal Nutry 120g', 'value' => 5.49, 'product_amount' => 150, 'sm_code' => 'BCN120G'],
            ['name' => 'Purê de Tomate', 'description' => 'Purê de Tomate 340g', 'value' => 3.29, 'product_amount' => 130, 'sm_code' => 'PT340G'],
            ['name' => 'Papel Toalha', 'description' => 'Papel Toalha Scott 2 Rolos', 'value' => 6.99, 'product_amount' => 100, 'sm_code' => 'PTS2R'],
            ['name' => 'Cerveja Skol', 'description' => 'Cerveja Skol 350ml', 'value' => 2.79, 'product_amount' => 200, 'sm_code' => 'CS350ML'],
            ['name' => 'Refrigerante Pepsi', 'description' => 'Refrigerante Pepsi 2L', 'value' => 7.99, 'product_amount' => 180, 'sm_code' => 'RP2L'],
            ['name' => 'Biscoito Salgado', 'description' => 'Biscoito Salgado Treloso 250g', 'value' => 3.59, 'product_amount' => 160, 'sm_code' => 'BST250G'],
            ['name' => 'Pasta de Dente Sensodyne', 'description' => 'Pasta de Dente Sensodyne 90g', 'value' => 7.49, 'product_amount' => 140, 'sm_code' => 'PDS90G'],
            ['name' => 'Cereal Integral Nestlé', 'description' => 'Cereal Integral Nestlé 500g', 'value' => 8.49, 'product_amount' => 110, 'sm_code' => 'CIN500G'],
            ['name' => 'Suco de Laranja Del Valle', 'description' => 'Suco de Laranja Del Valle 1L', 'value' => 5.99, 'product_amount' => 120, 'sm_code' => 'SLDV1L'],
            ['name' => 'Alho Picado', 'description' => 'Alho Picado 100g', 'value' => 2.29, 'product_amount' => 180, 'sm_code' => 'AP100G'],
            ['name' => 'Grão de Bico', 'description' => 'Grão de Bico 500g', 'value' => 4.29, 'product_amount' => 160, 'sm_code' => 'GB500G'],
            ['name' => 'Salsicha Viena', 'description' => 'Salsicha Viena 500g', 'value' => 9.99, 'product_amount' => 90, 'sm_code' => 'SV500G'],
            ['name' => 'Queijo Prato', 'description' => 'Queijo Prato 200g', 'value' => 7.49, 'product_amount' => 110, 'sm_code' => 'QP200G'],
            ['name' => 'Sopa de Legumes', 'description' => 'Sopa de Legumes 500g', 'value' => 4.99, 'product_amount' => 140, 'sm_code' => 'SL500G'],
            ['name' => 'Bolacha de Água e Sal', 'description' => 'Bolacha de Água e Sal 150g', 'value' => 2.49, 'product_amount' => 200, 'sm_code' => 'BAS150G'],
            ['name' => 'Suco de Uva Integral', 'description' => 'Suco de Uva Integral 1L', 'value' => 6.49, 'product_amount' => 100, 'sm_code' => 'SU1L'],
            ['name' => 'Leite Condensado Moça', 'description' => 'Leite Condensado Moça 395g', 'value' => 5.99, 'product_amount' => 130, 'sm_code' => 'LCM395G'],
            ['name' => 'Molho Shoyu', 'description' => 'Molho Shoyu 300ml', 'value' => 3.29, 'product_amount' => 140, 'sm_code' => 'MS300ML'],
            ['name' => 'Queijo Frescal', 'description' => 'Queijo Frescal 300g', 'value' => 7.99, 'product_amount' => 100, 'sm_code' => 'QF300G'],
            ['name' => 'Cerveja Brahma', 'description' => 'Cerveja Brahma 350ml', 'value' => 2.99, 'product_amount' => 200, 'sm_code' => 'CB350ML'],
            ['name' => 'Ketchup Heinz', 'description' => 'Ketchup Heinz 397g', 'value' => 6.49, 'product_amount' => 120, 'sm_code' => 'KH397G'],
            ['name' => 'Purê de Abóbora', 'description' => 'Purê de Abóbora 400g', 'value' => 4.29, 'product_amount' => 150, 'sm_code' => 'PA400G'],
            ['name' => 'Pipoca para Micro-ondas', 'description' => 'Pipoca para Micro-ondas 100g', 'value' => 3.49, 'product_amount' => 180, 'sm_code' => 'PM100G'],
            ['name' => 'Tempero em Pó', 'description' => 'Tempero em Pó 50g', 'value' => 2.79, 'product_amount' => 200, 'sm_code' => 'TP50G'],
            ['name' => 'Granola', 'description' => 'Granola 400g', 'value' => 8.99, 'product_amount' => 90, 'sm_code' => 'G400G'],
            ['name' => 'Caldo de Carne Knorr', 'description' => 'Caldo de Carne Knorr 6 Cubos', 'value' => 5.49, 'product_amount' => 130, 'sm_code' => 'CCK6C'],
            ['name' => 'Cereal Infantil', 'description' => 'Cereal Infantil 250g', 'value' => 4.99, 'product_amount' => 100, 'sm_code' => 'CI250G'],
            ['name' => 'Maçã Fuji', 'description' => 'Maçã Fuji Unidade', 'value' => 1.79, 'product_amount' => 150, 'sm_code' => 'MFU'],
            ['name' => 'Laranja Pera', 'description' => 'Laranja Pera Unidade', 'value' => 1.49, 'product_amount' => 200, 'sm_code' => 'LP'],
            ['name' => 'Banana Prata', 'description' => 'Banana Prata Unidade', 'value' => 1.29, 'product_amount' => 180, 'sm_code' => 'BP'],
            ['name' => 'Cenoura', 'description' => 'Cenoura Unidade', 'value' => 0.89, 'product_amount' => 220, 'sm_code' => 'CEN'],
            ['name' => 'Batata Doce', 'description' => 'Batata Doce Unidade', 'value' => 1.59, 'product_amount' => 160, 'sm_code' => 'BD'],
            ['name' => 'Tomate', 'description' => 'Tomate Unidade', 'value' => 2.49, 'product_amount' => 200, 'sm_code' => 'TOM'],
            ['name' => 'Pepino', 'description' => 'Pepino Unidade', 'value' => 1.19, 'product_amount' => 150, 'sm_code' => 'PEP'],
            ['name' => 'Refrigerante Sprite', 'description' => 'Refrigerante Sprite 2L', 'value' => 7.49, 'product_amount' => 170, 'sm_code' => 'RS2L'],
            ['name' => 'Biscoito de Maisena', 'description' => 'Biscoito de Maisena 300g', 'value' => 3.99, 'product_amount' => 140, 'sm_code' => 'BM300G'],
            ['name' => 'Creme de Avelã', 'description' => 'Creme de Avelã 350g', 'value' => 10.99, 'product_amount' => 110, 'sm_code' => 'CA350G'],
            ['name' => 'Achocolatado', 'description' => 'Achocolatado 400g', 'value' => 9.49, 'product_amount' => 120, 'sm_code' => 'AC400G'],
            ['name' => 'Refrigerante Guaraná', 'description' => 'Refrigerante Guaraná 1L', 'value' => 5.99, 'product_amount' => 180, 'sm_code' => 'RG1L'],
            ['name' => 'Bolacha de Chocolate', 'description' => 'Bolacha de Chocolate 150g', 'value' => 4.29, 'product_amount' => 130, 'sm_code' => 'BCC150G'],
            ['name' => 'Maçã Gala', 'description' => 'Maçã Gala Unidade', 'value' => 2.49, 'product_amount' => 150, 'sm_code' => 'MGU']
        ];
        $faker = Faker::create();
        foreach ($products as $product) {
            $product['bar_code'] =  $faker->unique()->numerify('789#########');
            ProductsModel::create($product);
        }
    }
}
