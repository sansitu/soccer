<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$roles = ['Admin', 'User'];

    	foreach ($roles as $role) {
    		DB::table('roles')->insert([
            	'name' => $role,
            	'created_at' => now(),
            	'updated_at' => now()
        	]);
    	}
    }
}
