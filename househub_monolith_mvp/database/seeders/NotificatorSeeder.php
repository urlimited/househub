<?php

namespace Database\Seeders;

use App\Enums\NotificatorType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notificators = [
            [
                'type_id' => NotificatorType::call,
                'value' => '+12268403260'
            ],
            [
                'type_id' => NotificatorType::call,
                'value' => '+14252243198'
            ]
        ];

        foreach ($notificators as $type) {
            DB::table('notificator_types')->insert([
                'name' => $type
            ]);
        }
    }
}
