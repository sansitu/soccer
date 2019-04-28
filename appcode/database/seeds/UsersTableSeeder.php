<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Soccer Admin',
            'email' => 'admin@soccer.com',
            'password' => '$2y$10$gUTdInJY8vRLew9BTMtICuAcFRzFwcI2D8fVbkvq98OgsPM1jv/sq',
            'remember_token' => 'DDH6iDqjAzZPhsFYSZRmZ6zBV5nYJcZF5qHBFTxoe2tsuggop89vPkAStRuN'
        ]);
    }
}
