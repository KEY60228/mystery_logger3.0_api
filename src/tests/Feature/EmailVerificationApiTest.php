<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\PreRegister;

class EmailVerificationApiTest extends TestCase
{
  use RefreshDatabase;

  protected function setUp(): void
  {
    parent::setUp();

    $this->artisan('migrate');
    
    // シーダーに変える？
    $data = [
      'email' => 'dummy@dummy.com',
    ];
    $response = $this->json('POST', route('preregister'), $data);
  }

  /**
   * @test
   */
  public function should_認証して200を返す()
  {
    $preuser = PreRegister::first();

    $data = [
      'token' => $preuser->token,
    ];

    $response = $this->json('POST', route('verify'), $data);

    $response->assertStatus(200);
  }
  
  /**
   * @test
   */
  public function should_認証失敗させて422を返す()
  {
    $data = [
      // 不正なトークン
      'token' => ''
    ];
    
    $response = $this->json('POST', route('verify'), $data);
    
    $response->assertStatus(422);
  }
}
