<?php

namespace Tests\Feature\http\register;

use App\Enums\AuthCodeType;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SendConfirmationPhoneCallTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     * @testdox Standard scenario for resident user registration
     */
    public function testStandardSendConfirmationCall()
    {
        $data = [
            'phone' => '+77771557027'
        ];

        $userId = DB::table('users')->where('login', $data['phone'])->first()->id;

        $response = $this->json(method: 'post', uri: '/api/auth/auth_code', data: $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas(table: 'auth_codes', data: [
            "user_id" => $userId,
            "type_id" => AuthCodeType::phone
        ]);
    }

    //TODO: realise
    public function test25Calls() {

    }

    //TODO: realise
    public function testWhenAllPhonesAreOut() {

    }

    //TODO: realise
    public function testWhenUserIsBlocked() {

    }
}
