<?php

namespace Tests\Feature\http\register;

use App\Enums\TokenType;
use App\Enums\UserStatus;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\NoReturn;
use Tests\TestCase;

class ConfirmPhoneAuthCodeTest extends TestCase
{
    /**
     * @covers RegisterController::confirmPhoneAuthCode
     * @return void
     * @testdox Standard scenario for user phone confirmation
     */
    #[NoReturn]
    public function testStandardConfirmPhoneAuthCode(): void
    {
        $data = [
            'phone' => '+77771557027',
            'code' => '1111'
        ];

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

    /**
     * @covers RegisterController::confirmPhoneAuthCode
     * @return void
     * @testdox User to be registered filled wrong confirmation code
     *          Expected to block the user
     */
    #[NoReturn]
    public function testServiceCompanyUserConfirmedWrongNumber(): void
    {
        //TODO: realise test
    }
}
