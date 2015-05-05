<?php

use App\Gender;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class GendersTableSeeder extends Seeder {

    public function run()
    {
        Model::unguard();
        
        DB::table('genders')->delete();

    	$genders = [
            [
                'description' => 'Undefined',
            ],
    		[
                'description' => 'Female',
    		],
            [
                'description' => 'Male',
            ],
            [
                'description' => 'Trans*',
            ],
    	];

        foreach ($genders as $gender) {
            Gender::create($gender);
        }
    }

}