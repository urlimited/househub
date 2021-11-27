<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactInformationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contacts = [
            'phone',
            'email'
        ];

        foreach ($contacts as $contact) {
            DB::table('contact_information_types')->insert([
                'name' => $contact
            ]);
        }
    }
}
