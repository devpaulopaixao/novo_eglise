<?php

use App\User;
use App\Igreja;
use Illuminate\Database\Seeder;

class IgrejaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(2);

        $igreja = $user->igrejas()->create([
            'nome' => 'Primeira Igreja Batista do Oeste',
            'sobre' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
            'telefone' => '31 93848-6771',
        ]);

        $igreja->endereco()->create([
            'cep' => '35.181-044',
            'rua' => 'Rua das Macieiras',
            'numero' => '48',
            'bairro' => 'Alegre',
            'cidade' => 'Timóteo',
            'estado' => 'MG',
        ]);
    }
}
