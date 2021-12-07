<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificatorTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'call',
            'sms',
            'email'
        ];

        foreach ($types as $type) {
            DB::table('notificator_types')->insert([
                'name' => $type
            ]);
        }
    }
}
