<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'brand_id' => 1,
                'name' => 'Stiched Shirt',
                'price' => 1500,
                'size' => 'Toddler',
            ],
            [
                'brand_id' => 2,
                'name' => 'Frock',
                'price' => 1000,
                'size' => 'Toddler',
            ],
            [
                'brand_id' => 2,
                'name' => 'Cloth',
                'price' => 2500,
                'size' => 'Small',
            ],
            [
                'brand_id' => 1,
                'name' => 'Shalwar Qameez',
                'price' => 1200,
                'size' => 'Large',
            ],
            [
                'brand_id' => 3,
                'name' => 'Kurta',
                'price' => 2000,
                'size' => 'Medium',
            ],
        ];

        \Illuminate\Support\Facades\DB::table('products')->insert($products);
    }
}
