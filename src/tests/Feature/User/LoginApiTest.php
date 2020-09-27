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

    $response->assertStatus(200);
    $this->assertEquals($this->user->account_id, $response['account_id']);
    $this->assertEquals($this->user->name, $response['name']);
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

    $response->assertStatus(422);
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
  
    $response->assertStatus(422);    
  }
}
