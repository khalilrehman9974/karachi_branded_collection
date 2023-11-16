<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parties = [
            [
                'name' => 'Rehmat and sons',
                'email' => 'rehmat@test.com',
                'phone_no' => '0425887788',
                'mobile_no' => '0300857858',
                'whatsapp_no' => '03216588974',
                'mailing_address' => 'House#433, street#9, G-11/2 Islamabad',
                'shipping_address' => 'House#433, street#9, G-11/2 Islamabad',
                'city' => 'Islamabad',
            ],
            [
                'name' => 'Noor and sons',
                'email' => 'noor@test.com',
                'phone_no' => '0425887788',
                'mobile_no' => '0300857858',
                'whatsapp_no' => '03216588974',
                'mailing_address' => 'House#433, street#9, G-11/2 Islamabad',
                'shipping_address' => 'House#433, street#9, G-11/2 Islamabad',
                'city' => 'Islamabad',
            ],
            [
                'name' => 'Peshawar Khan',
                'email' => 'peshawar.khan@test.com',
                'phone_no' => '0425887788',
                'mobile_no' => '0300857858',
                'whatsapp_no' => '03216588974',
                'mailing_address' => 'House#433, street#9, G-11/2 Islamabad',
                'shipping_address' => 'House#433, street#9, G-11/2 Islamabad',
                'city' => 'Islamabad',
            ],
            [
                'name' => 'Queita Khan',
                'email' => 'quita@test.com',
                'phone_no' => '0425887788',
                'mobile_no' => '0300857858',
                'whatsapp_no' => '03216588974',
                'mailing_address' => 'House#433, street#9, G-11/2 Islamabad',
                'shipping_address' => 'House#433, street#9, G-11/2 Islamabad',
                'city' => 'Islamabad',
            ],
        ];

        \Illuminate\Support\Facades\DB::table('parties')->insert($parties);
    }
}
