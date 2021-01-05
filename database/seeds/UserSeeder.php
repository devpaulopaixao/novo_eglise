<?php

use App\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('users')->delete();

        $role = Role::create(['name' => 'SuperAdmin']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user = User::create([
        	'name' => 'Paulo Paixão',
        	'email' => 'paulinhohenrique90@yahoo.com.br',
            'password' => bcrypt('paixao')
        ]);

        $user->assignRole([$role->id]);

        Role::create(['name' => 'Admin']);

        $role = Role::create(['name' => 'Usuário']);
        $permissions = Permission::where('id','>',12)->get()->pluck('id','id');
        $role->syncPermissions($permissions);

        Model::reguard();
    }
}
