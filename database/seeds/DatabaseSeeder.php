<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*$this->call(\Database\Seeders\UserSeeder::class);
        $this->call(\Database\Seeders\PartySeeder::class);
        $this->call(\Database\Seeders\BrandSeeder::class);*/
//        $this->call(\Database\Seeders\ProductSeeder::class);
        $this->call(\Database\Seeders\AccountTypesSeeder::class);
    }
}
