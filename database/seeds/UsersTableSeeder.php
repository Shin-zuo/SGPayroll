<?php

use Illuminate\Database\Seeder;
use SGpayroll\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'sample@email.com'],
            [
                'name' => 'Sample User',
                'password' => bcrypt('testPass'),
                'user_type' => 1,
            ]
        );
    }
}
