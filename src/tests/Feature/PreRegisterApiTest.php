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
  public function should_仮登録してメールを送信する()
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
  public function should_仮登録せずに422を返す()
  {
    $data = [
      'email' => '',
    ];

    $response = $this->json('POST', route('preregister'), $data);

    $response->assertStatus(422);
  }
}
