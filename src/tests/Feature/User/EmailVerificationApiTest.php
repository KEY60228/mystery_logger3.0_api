<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\PreRegister;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EmailVerificationApiTest extends TestCase
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
            'status' => PreRegister::SEND_MAIL,
        ]);

        $data = [
            'token' => $preUser->token,
        ];

        $response = $this->json('POST', route('verify'), $data);

        $response->assertStatus(200)->assertJson([
            'email' => $preUser->email,
            'pre_register_id' => $preUser->id,
        ]);
    }
    
    /**
     * @test
     */
    public function 正常系_認証済トークン()
    {
        $preUser = factory(PreRegister::class)->create([
            'status' => PreRegister::MAIL_VERIFY,
        ]);

        $data = [
            'token' => $preUser->token,
        ];

        $response = $this->json('POST', route('verify'), $data);

        $response->assertStatus(200)->assertJson([
            'email' => $preUser->email,
            'pre_register_id' => $preUser->id,
        ]);
    }
    
    /**
     * @test
     */
    public function 不正系_トークン不整合()
    {
        $data = [
            'token' => Str::random(250),
        ];

        $response = $this->json('POST', route('verify'), $data);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'verify' => [
                    'トークンが不正です。'
                ]
            ],
            'message' => 'The given token was invalid.',
        ]);
    }
    
    /**
     * @test
     */
    public function 不正系_有効期限切れトークン()
    {
        $preUser = factory(PreRegister::class)->create([
            'status' => PreRegister::SEND_MAIL,
            'expiration_time' => Carbon::yesterday(),
        ]);

        $data = [
            'token' => $preUser->token,
        ];

        $response = $this->json('POST', route('verify'), $data);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'verify' => [
                    'トークンが不正です。'
                ]
            ],
            'message' => 'The given token was invalid.'
        ]);
    }
    
    /**
     * @test
     */
    public function 不正系_本登録済トークン()
    {
        $preUser = factory(PreRegister::class)->create([
            'status' => PreRegister::REGISTERED,
        ]);

        $data = [
            'token' => $preUser->token,
        ];

        $response = $this->json('POST', route('verify'), $data);
    
        $response->assertStatus(422)->assertJson([
            'errors' => [
                'verify' => [
                    'トークンが不正です。'
                ]
            ],
            'message' => 'The given token was invalid.'
        ]);
    }
}
