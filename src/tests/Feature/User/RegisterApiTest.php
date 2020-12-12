<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\PreRegister;
use App\Models\User;

class RegisterApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function 正常系()
    {
        $preUser = factory(PreRegister::class)->create([
            'status' => PreRegister::MAIL_VERIFY,
        ]);

        $data = [
            'account_id' => 'dummy',
            'name' => 'dummy',
            'email' => $preUser->email,
            'pre_register_id' => $preUser->id,
            'password' => 'dummydummy',
            'password_confirmation' => 'dummydummy',
        ];

        $response = $this->json('POST', route('register'), $data);

        $response->assertStatus(201)->assertJson([
            'account_id' => $data['account_id'],
            'name' => $data['name'],
        ]);
        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
        ]);
    }

    /**
     * @test
     */
    public function 不正系_未認証メールアドレス()
    {
        $preUser = factory(PreRegister::class)->create([
            'status' => PreRegister::SEND_MAIL,
        ]);

        $data = [
            'account_id' => 'dummy',
            'name' => 'dummy',
            'email' => $preUser->email,
            'pre_register_id' => $preUser->id,
            'password' => 'dummydummy',
            'password_confirmation' => 'dummydummy',
        ];

        $response = $this->json('POST', route('register'), $data);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'pre_register' => [
                    'メールアドレスが未認証です。'
                ]
            ],
            'message' => 'The given data was invalid.'
        ]);
    }

    /**
     * @test
     */
    public function 不正系_不正な値()
    {
        $preUser = factory(PreRegister::class)->create([
            'status' => PreRegister::MAIL_VERIFY,
        ]);

        $data = [
            'account_id' => '',
            'name' => '',
            'email' => $preUser->email,
            'pre_register_id' => $preUser->id,
            'password' => 'dummydummy',
            'password_confirmation' => '',
        ];

        $response = $this->json('POST', route('register'), $data);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'account_id' => [
                    'account idは必須です。',
                ],
                'name' => [
                    'nameは必須です。',
                ],
                'password' => [
                    'passwordが確認用の値と一致しません。',
                ],
            ],
            'message' => 'The given data was invalid.'
        ]);
    }

    /**
     * @test
     */
    public function 不正系_登録済accound_id()
    {
        $existUser = factory(User::class)->create();

        $preUser = factory(PreRegister::class)->create([
            'status' => PreRegister::MAIL_VERIFY,
        ]);

        $data = [
            'account_id' => $existUser->account_id,
            'name' => 'dummy',
            'email' => $preUser->email,
            'pre_register_id' => $preUser->id,
            'password' => 'dummydummy',
            'password_confirmation' => 'dummydummy',
        ];

        $response = $this->json('POST', route('register'), $data);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'account_id' => [
                    'そのaccount idはすでに使われています。'
                ],
            ],
            'message' => 'The given data was invalid.'
        ]);
    }


}
