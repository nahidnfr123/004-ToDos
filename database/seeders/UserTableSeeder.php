<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->first_name = 'Nahid';
        $user->last_name = 'Ferdous';
        $user->username = 'nahid123';
        $user->email = 'nahid@gmail.com';
        $user->email_verified_at = now();
        $user->password = Hash::make('nahid@gmail.com');
        $user->save();

        // Laravel sanctum
        $user->createToken('user-access-control', ['access-dashboard', 'todo-view', 'todo:store', 'todo:update', 'todo:delete']);
        //$user->createToken('token_name', ['permission_1', 'permission_2']);

    }
}
