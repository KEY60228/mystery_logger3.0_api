<?php

namespace Tests\Feature;

use App\Models\EmailVerification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerificationMail;

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

    $preuser = EmailVerification::first();

    Mail::assertSent(EmailVerificationMail::class, 1);
    
    $this->assertEquals($data['email'], $preuser->email);
    $this->assertEquals(0, $preuser->status);
    $this->assertEquals(Carbon::now()->addHours(1), $preuser->expiration_time);
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
