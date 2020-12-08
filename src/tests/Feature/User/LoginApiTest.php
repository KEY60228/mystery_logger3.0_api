<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function 正常系()
    {
        $data = [
            'email' => $this->user->email,
            'password' => 'password',
        ];

        $response = $this->json('POST', route('login'), $data);

        $response->assertStatus(200)->assertJson([
            'account_id' => $this->user->account_id,
            'name' => $this->user->name,
            'follows_id' => $this->user->follows_id,
            'followers_id' => $this->user->followers_id,
            'done_id' => $this->user->done_id,
            'wanna_id' => $this->user->wanna_id,
            'like_reviews_id' => $this->user->like_reviews_id,
        ]);

        $this->assertAuthenticatedAs($this->user);
    }

    /**
     * @test
     */
    public function 不正系_不正なemail、password()
    {
        $data = [
            'email' => '',
            'password' => '',
        ];

        $response = $this->json('POST', route('login'), $data);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'email' => [
                    'emailは必須です。'
                ],
                'password' => [
                    'passwordは必須です。'
                ],
            ],
            'message' => 'The given data was invalid.',
        ]);
    }
    
    /**
     * @test
     */
    public function 不正系_照合が合わない()
    {
        $data = [
            'email' => $this->user->email,
            'password' => 'pass',
        ];
    
        $response = $this->json('POST', route('login'), $data);
    
        $response->assertStatus(422)->assertJson([
            'errors' => [
                'email' => [
                    '認証に失敗しました。',
                ],
            ],
            'message' => 'The given data was invalid.',
        ]);
    }
}
