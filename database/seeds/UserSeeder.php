<?php

use Illuminate\Database\Seeder;
use SGpayroll\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'sample@email.com',
            'password' => bcrypt('testPass'),
            'user_type' => '1',
        ]);

        User::create([
            'name' => 'Employee User',
            'email' => 'sample@yahoo.com',
            'password' => bcrypt('testPass'),
            'user_type' => '2',
        ]);
    }
}
