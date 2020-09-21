<?php

namespace Tests\Feature;

use App\Models\PreRegister;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use App\Models\User;

class PreRegisterApiTest extends TestCase
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
    Mail::fake();

    $data = [
      'email' => 'dummy@dummy.com',
    ];

    $response = $this->json('POST', route('preregister'), $data);

    $preUser = PreRegister::first();

    Mail::assertSent(EmailVerification::class, 1);
    
    $this->assertEquals($data['email'], $preUser->email);
    $this->assertEquals(PreRegister::SEND_MAIL, $preUser->status);
    $this->assertEquals(Carbon::now()->addHours(1), $preUser->expiration_time);
    $response->assertStatus(201);
  }

  /**
   * @test
   */
  public function 正常系_仮登録済メールアドレス()
  {
    Mail::fake();

    factory(PreRegister::class)->create([
      'email' => 'dummy@dummy.com',
      'status' => PreRegister::SEND_MAIL,
    ]);

    $data = [
      'email' => 'dummy@dummy.com',
    ];

    $response = $this->json('POST', route('preregister'), $data);

    $preUser = PreRegister::first();

    Mail::assertSent(EmailVerification::class, 1);
    
    $this->assertEquals($data['email'], $preUser->email);
    $this->assertEquals(PreRegister::SEND_MAIL, $preUser->status);
    $this->assertEquals(Carbon::now()->addHours(1), $preUser->expiration_time);
    $response->assertStatus(201);
  }

  /**
   * @test
   */
  public function 正常系_認証済メールアドレス()
  {
    Mail::fake();

    factory(PreRegister::class)->create([
      'email' => 'dummy@dummy.com',
      'status' => PreRegister::MAIL_VERIFY,
    ]);

    $data = [
      'email' => 'dummy@dummy.com',
    ];

    $response = $this->json('POST', route('preregister'), $data);

    $preUser = PreRegister::first();

    Mail::assertSent(EmailVerification::class, 1);
    
    $this->assertEquals($data['email'], $preUser->email);
    $this->assertEquals(PreRegister::MAIL_VERIFY, $preUser->status);
    $this->assertEquals(Carbon::now()->addHours(1), $preUser->expiration_time);
    $response->assertStatus(201);
  }

  /**
   * @test
   */
  public function 不正系_不正なメールアドレス()
  {
    $data = [
      'email' => '',
    ];

    $response = $this->json('POST', route('preregister'), $data);

    $response->assertStatus(422);
  }

  /**
   * ToDo
   * 
   * @test
   */
  public function 不正系_本登録済メールアドレス()
  {
    Mail::fake();

    $existUser = factory(User::class)->create();

    $data = [
      'email' => $existUser->email,
    ];

    $response = $this->json('POST', route('preregister'), $data);

    $response->assertStatus(422);
  }
}
