<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    const randomPassword = 'sf78fs80f@#';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Khalil ur Rehman',
                'email' => 'khalil@test.com',
                'password' => bcrypt(Self::randomPassword),
            ],
        ];

        \Illuminate\Support\Facades\DB::table('users')->insert($users);
    }
}
