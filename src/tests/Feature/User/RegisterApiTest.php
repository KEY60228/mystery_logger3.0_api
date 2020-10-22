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

    $this->artisan('migrate');
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

    $response->assertStatus(201);
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
      'message' => 'The given data was invalid.'
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
      'errors' => ['pre_register' => ['The given email have not been pre-registered']],
      'message' => 'The given data was invalid.'
    ]);
  }
}
