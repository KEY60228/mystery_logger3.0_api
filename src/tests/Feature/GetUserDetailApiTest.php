<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class getUserDetailApiTest extends TestCase
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
    $response = $this->json('GET', route('user.show', [
      'userId' => $this->user->account_id,
    ]));

    $response->assertStatus(200)->assertJsonFragment([
      'id' => $this->user->id,
      'name' => $this->user->name,
      'account_id' => $this->user->account_id,
    ]);
  }

  public function 該当しないID()
  {
    $response = $this->json('GET', route('user.show', [
      'userId' => 'a',
    ]));

    $response->assertStatus(422);
  }
}
