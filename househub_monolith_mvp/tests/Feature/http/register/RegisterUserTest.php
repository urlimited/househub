<?php

namespace Tests\Feature\http\register;

use App\Enums\CompanyStatus;
use App\Enums\CompanyType;
use App\Enums\Role;
use App\Enums\UserStatus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use JetBrains\PhpStorm\NoReturn;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     * @covers RegisterController::registerUser
     * @return void
     * @testdox Standard scenario for service company user registration
     *          Expected to register the user
     *
     */
    public function testStandardRegistrationServiceCompanyUserProcess(): void
    {
        // 1. Data initialization
        $data = [
            'company_id' => 1,
            'first_name' => 'Bobby',
            'last_name' => 'Brown',
            'phone' => '+77771557027',
            'email' => 'bobby@brown.com',
            'user_registration_comment' => 'Hey, I am CEO',
            'role' => Role::serviceCompanyWorker
        ];

        // 2. Action
        $response = $this->json(method: 'post', uri: '/api/auth/users/register', data: $data);

        // 3.1 Assert status
        $response->assertStatus(200);

        // 3.2 Assert response structure
        $response->assertJsonStructure([
            "data" => [
                "first_name",
                "last_name",
                "phone",
                "email",
                "role_id",
                "role",
                "status_id",
                "status",
                "company_id",
                "company_name"
            ]
        ]);

        $userId = json_decode($response->getContent())->data->id;

        // 3.3 Assert action results in DB
        $this->assertDatabaseHas(table: 'users', data: [
            "id" => $userId,
            "first_name" => "Bobby",
            "last_name" => "Brown",
            "login" => "+77771557027",
            "role_id" => Role::serviceCompanyWorker
        ]);

        $this->assertDatabaseHas(table: 'user_status_histories', data: [
            "status_id" => UserStatus::registered,
            "user_id" => $userId
        ]);
    }

    /**
     * @covers RegisterController::registerUser
     * @return void
     * @testdox Service company for current user to be registered is not created
     *          Expected to create registration request for a new service company
     */
    #[NoReturn]
    public function testServiceCompanyIsNotCreated(): void
    {
        // 1. Data initialization
        $data = [
            'company_name' => 'Big City Life LLP',
            'company_type' => CompanyType::serviceCompany,
            'company_bin' => '12345678901112',
            'company_address' => 'ул. Абая, 124д. кв.15',
            'company_email' => 'info@bigcitylife.com',
            'company_website' => 'bigcitylife.com',
            'company_registration_comment' => 'Наша компания занимается подбором персонала в штаты',

            'first_name' => 'Bobby',
            'last_name' => 'Brown',
            'phone' => '+77771557027',
            'email' => 'bobby@brown.com',
            'user_registration_comment' => 'Hey, I am CEO',
            'role' => Role::serviceCompanyWorker
        ];

        // 2. Action
        $response = $this->json(method: 'post', uri: '/api/auth/users/register', data: $data);

        // 3.1 Assert status
        $response->assertStatus(200);

        // 3.2 Assert response structure
        $response->assertJsonStructure([
            "data" => [
                "first_name",
                "last_name",
                "phone",
                "email",
                "role_id",
                "role",
                "status_id",
                "status",
                "company_id",
                "company_name"
            ]
        ]);

        $userId = json_decode($response->getContent())->data->id;
        $companyId = json_decode($response->getContent())->data->company_id;

        // 3.3 Assert action results in DB
        $this->assertDatabaseHas(table: 'users', data: [
            "id" => $userId,
            "first_name" => "Bobby",
            "last_name" => "Brown",
            "login" => "+77771557027",
            "role_id" => Role::serviceCompanyWorker
        ]);

        $this->assertDatabaseHas(table: 'user_status_histories', data: [
            "status_id" => UserStatus::registered,
            "user_id" => $userId
        ]);

        $this->assertDatabaseHas(table: 'companies', data: [
            "name" => 'Big City Life LLP',
            "bin" => '12345678901112',
            "email" => "info@bigcitylife.com",
            "website" => "bigcitylife.com",
            "comments" => "Наша компания занимается подбором персонала в штаты",
            "type_id" => CompanyType::serviceCompany
        ]);

        $this->assertDatabaseHas(table: 'company_status_histories', data: [
            "status_id" => CompanyStatus::registered,
            "company_id" => $companyId
        ]);
    }
}
