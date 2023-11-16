<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            [
                'name' => 'Saphire',
            ],
            [
                'name' => 'Gul Ahmed',
            ],
            [
                'name' => 'J.',
            ],
        ];

        \Illuminate\Support\Facades\DB::table('brands')->insert($brands);
    }
}
