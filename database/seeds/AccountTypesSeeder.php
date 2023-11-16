<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AccountTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accountTypes = [
            [
                'name' => 'Sale',
                'alias' => 'S',
            ],
            [
                'name' => 'Purchase',
                'alias' => 'P',
            ],
            [
                'name' => 'Expense',
                'alias' => 'E',
            ],
            [
                'name' => 'Cash in Hand',
                'alias' => 'CH',
            ],
        ];

        \Illuminate\Support\Facades\DB::table('account_types')->insert($accountTypes);
    }
}
