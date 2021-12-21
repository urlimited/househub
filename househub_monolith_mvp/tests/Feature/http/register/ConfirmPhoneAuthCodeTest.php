<?php

namespace Tests\Feature\http\register;

use App\Enums\TokenType;
use App\Enums\UserStatus;
use Database\Seeders\testing\TestingUserSeeder;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ConfirmPhoneAuthCodeTest extends TestCase
{
    /**
     * @return void
     * @testdox Standard scenario for user phone confirmation
     */
    public function testStandardConfirmPhoneAuthCode()
    {
        $data = [
            'phone' => '+77771557027',
            'code' => '1111'
        ];

        $this->seed(TestingUserSeeder::class);

        $userId = DB::table('users')->where('login', $data['phone'])->first()->id;

        $response = $this->json(method: 'post', uri: '/api/auth/auth_code_confirmation', data: $data);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "data" => [
                "access_token"
            ]
        ]);

        $this->assertDatabaseHas(table: 'user_status_histories', data: [
            "user_id" => $userId,
            "status_id" => UserStatus::loginConfirmed
        ]);

        $this->assertDatabaseHas(table: 'tokens', data: [
            'user_id' => $userId,
            'type_id' => TokenType::access,
            'value' => json_decode($response->getContent(), true)['data']['access_token']['value']
        ]);
    }
}
