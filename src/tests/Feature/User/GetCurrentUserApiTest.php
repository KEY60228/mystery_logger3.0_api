<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class GetCurrentUserApiTest extends TestCase
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
        $response = $this->actingAs($this->user)->json('GET', route('currentUser'));

        $response->assertStatus(200)->assertJson([
            'account_id' => $this->user->account_id,
            'name' => $this->user->name,
            'follows_id' => $this->user->follows_id,
            'followers_id' => $this->user->followers_id,
        ]);
    }

    /**
     * @test
     */
    public function クッキーなし()
    {
        $response = $this->json('GET', route('currentUser'));

        $response->assertStatus(204);
    }
}
