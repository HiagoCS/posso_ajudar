<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account\Client;
use Faker\Factory as Faker;
use Faker\Provider\pt_BR\Person as FakerBrazilPerson;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('pt_BR');
        $faker->addProvider(new FakerBrazilPerson($faker));

        for ($i = 0; $i < 20; $i++) {
            Client::create([
                'name' => $faker->name,
                'cpf' => $faker->cpf(false), // Gera um CPF válido sem pontuação
            ]);
        }
    }
}
