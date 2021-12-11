<?php

namespace Tests\Feature\http\register;

use App\Enums\Role;
use App\Enums\UserStatus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RegisterResidentUserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     * @testdox Standard scenario for resident user registration
     *
     */
    public function testStandardRegisterProcess()
    {
        $data = [
            'first_name' => 'Bob',
            'last_name' => 'Willson',
            'phone' => '+77771557027'
        ];

        $response = $this->json(method: 'post', uri: '/api/auth/register', data: $data);

        $response->assertStatus(200);

        $response->assertJson([
            "data" => [
                "first_name" => "Bob",
                "last_name" => "Willson",
                "phone" => "+77771557027",
                "role_id" => 1,
                "role" => "resident",
                "status_id" => 1,
                "status" => "registered"
            ]
        ]);

        $userId = json_decode($response->getContent())->data->id;

        $this->assertDatabaseHas(table: 'users', data: [
            "id" => $userId,
            "first_name" => "Bob",
            "last_name" => "Willson",
            "login" => "+77771557027",
            "role_id" => Role::resident
        ]);

        $this->assertDatabaseHas(table: 'user_status_histories', data: [
            "status_id" => UserStatus::registered,
            "user_id" => $userId
        ]);
    }

    public function testDoubleRegistrationIssue(){

    }
}
