<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Follow;

class PutFollowApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->follows = factory(User::class)->create();
        $this->follower = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function 正常系()
    {
        $response = $this->json('PUT', route('follow'), [
            'following_id' => $this->follows->id,
            'followed_id' => $this->follower->id,
        ]);

        $followings = Follow::first();

        $response->assertStatus(200);
        $this->assertEquals($followings->following_id, $this->follows->id);
        $this->assertEquals($followings->followed_id, $this->follower->id);
    }
}
