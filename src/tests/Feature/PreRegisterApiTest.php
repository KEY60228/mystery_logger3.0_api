<?php

namespace Tests\Feature;

use App\Models\PreRegister;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;

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
    $this->assertEquals(0, $preUser->status);
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
      'status' => 0,
    ]);

    $data = [
      'email' => 'dummy@dummy.com',
    ];

    $response = $this->json('POST', route('preregister'), $data);

    $preUser = PreRegister::first();

    Mail::assertSent(EmailVerification::class, 1);
    
    $this->assertEquals($data['email'], $preUser->email);
    $this->assertEquals(0, $preUser->status);
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
      'status' => 1,
    ]);

    $data = [
      'email' => 'dummy@dummy.com',
    ];

    $response = $this->json('POST', route('preregister'), $data);

    $preUser = PreRegister::first();

    Mail::assertSent(EmailVerification::class, 1);
    
    $this->assertEquals($data['email'], $preUser->email);
    $this->assertEquals(1, $preUser->status);
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
  // public function 不正系_本登録済メールアドレス()
  // {
  //   Mail::fake();

  //   $preregister = PreRegister::create([
  //     'email' => 'dummy@dummy.com',
  //     'token' => \Illuminate\Support\Str::random(250),
  //     'status' => PreRegister::REGISTERED,
  //     'expiration_time' => Carbon::now()->addHours(1),
  //   ]);

  //   $data = [
  //     'email' => 'dummy@dummy.com',
  //   ];

  //   $response = $this->json('POST', route('preregister'), $data);

  //   $response->assertStatus(422);
  // }
}
