<?php

namespace Tests\Feature\http\register;

use Database\Seeders\testing\TestingUserSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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

        $this->seed(TestingUserSeeder::class);

        $response = $this->json(method: 'post', uri: '/api/auth/auth_code', data: $data);

        $response->assertStatus(201);

        /*$this->assertDatabaseHas(table: 'auth_codes', data: [
            "user_id" => $userId,
            "type_id" => AuthCodeType::phone
        ]);*/

        /*$response->assertJson([
            "data" => [
                "phone" => "+77771557027",
            ]
        ]);*/

        //$userId = json_decode($response->getContent())->data->id;

        /*$this->assertDatabaseHas(table: 'users', data: [
            "id" => $userId,
            "first_name" => "Bob",
            "last_name" => "Willson",
            "login" => "+77771557027",
            "role_id" => Role::resident
        ]);

        $this->assertDatabaseHas(table: 'user_status_histories', data: [
            "status_id" => UserStatus::registered,
            "user_id" => $userId
        ]);*/
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
