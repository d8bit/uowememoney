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
        DB::table('users')->insert(
            [
                'name' => 'David',
                'email' => 'deibit@protonmail.com',
                'password' => bcrypt('yokese3'),
            ],
            [
                'name' => 'Patty',
                'email' => 'pfuentes.zorita@gmail.com',
                'password' => bcrypt('yokese3'),
            ]
        );
    }
}
