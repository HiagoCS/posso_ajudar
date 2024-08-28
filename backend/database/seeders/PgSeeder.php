<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Account\PGModel;

class PgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PGModel::create(["name" => "Dinheiro"]);
        PGModel::create(["name" => "Cartão de Crédito"]);
        PGModel::create(["name" => "Cartão de Débito"]);
        PGModel::create(["name" => "PIX"]);
    }
}
