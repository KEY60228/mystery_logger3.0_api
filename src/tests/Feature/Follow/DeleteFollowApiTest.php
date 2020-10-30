<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Follow;

class UnfollowApiTest extends TestCase
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
        $response = $this->json('DELETE', route('unfollow'), [
            'following_id' => $this->follows->id,
            'followed_id' => $this->follower->id,
        ]);

        $response->assertStatus(204);
        $this->assertNull(Follow::whereFollowingId($this->follows->id)->first());
    }
}
