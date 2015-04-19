<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

    	$users = [
    		[
				'id' => 100001,
				'name'          => 'Test Tester',
                'email' => 'devinnewbery@hotmail.com',
                'password' => '$2y$10$WIrulrMi1N0Ur9N.UsFDVeJPhhln.8TyLi7ct6qMPk42SGZSWG4Eq',
    		],
    	];

        foreach ($users as $user) {
            User::create($user);
        }
    }

}