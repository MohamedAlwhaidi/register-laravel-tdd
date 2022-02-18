<?php

namespace Tests\Feature;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Requests\RegisterRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;

class RegisterConrollerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_valid_register_route()
    {
        $response = $this->post('/api/register');

        $response->assertStatus(200);
    }


    public function test_user_can_register()
    {
        $user = [
            'username' => 'Joe',
            'email' => 'testemail@test.com',
            'password' => 'passwordtest',
            'mobile' => '059242',
        ];

        $this->postJson('api/register', $user)
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'id' => '1',
                    'username' => 'Joe',
                    'email' => 'testemail@test.com',
                    'mobile' => '059242',
                ],
            ]);

    }

    public function test_fields_register_user_mobile_is_require()
    {

        $user = [
            'username' => 'asdf0',
            'email' => 'asdfasdf@d.d',
            'password' => 'sdfsdfsd',
        ];

        $this->postJson('api/register', $user)
            ->assertInvalid('mobile');
    }

    public function test_fields_register_user_mobile_invalid_data_type()
    {

        $user = [
            'username' => 'asdf0',
            'email' => 'asdfasdf@d.d',
            'password' => 'asdfasdf',
            'mobile' => 'asdfa',
        ];

        $this->postJson('api/register', $user)
            ->assertInvalid('mobile');
    }

    public function test_invalid_fields_register_user_validation()
    {

        $user = [
            'username' => '',
            'email' => 'd.d',
            'mobile' => 'asdfasdf',
            'password' => ''
        ];

        $this->postJson('api/register', $user)
            ->assertJsonValidationErrors([
                'username',
                'email',
                'password',
                'mobile',
            ]);
    }

    public function test_fields_register_user_email_exist()
    {
        $user = [
            'username' => 'user1',
            'email' => 'user1@user.user',
            'password' => 'password',
            'mobile' => '123123',
        ];
        $user2 = [
            'username' => 'user1',
            'email' => 'user1@user.user',
            'password' => 'password',
            'mobile' => '123123',
        ];

        $this->postJson('api/register', $user);
        $this->postJson('api/register', $user2)
            ->assertInvalid('email');
    }



//    public function test_invalid_fields_register_user_validation1()
//    {
//
//        $user = [
//            'username'=>'required|string',
//            'email'=>'required|email',
//            'password'=>'required|string',
//            'mobile'=>'required|numeric',
//        ];
//
//        RegisterRequest->ru;
//
//
//    }
}
