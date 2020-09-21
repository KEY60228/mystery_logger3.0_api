<?php

namespace Tests\Feature;

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

    $this->artisan('migrate');
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

    $this->assertEquals($preUser->email, $response['email']);
    $this->assertEquals($preUser->id, $response['pre_register_id']);
    $response->assertStatus(200);
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
    
      $this->assertEquals($preUser->email, $response['email']);
      $this->assertEquals($preUser->id, $response['pre_register_id']);
    $response->assertStatus(200);
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

    $response->assertStatus(422);
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
  
    $response->assertStatus(422);
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
  
    $response->assertStatus(422);
  }
}
