<?php

use App\User;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Use faker to populate users table
        factory(User::class, 10)->create();

        for ($i=2; $i < 12; $i++) {
            $user = User::find($i);
            $user->assignRole(3);//Usuário
        }
    }
}
