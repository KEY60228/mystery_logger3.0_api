<?php

namespace Tests\Feature\Follow;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Follow;

class DeleteFollowApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->follows = factory(User::class)->create();
        $this->follower = factory(User::class)->create();
        $this->follow = factory(Follow::class)->create([
            'following_id' => $this->follows->id,
            'followed_id' => $this->follower->id,
        ]);
    }

    /**
     * @test
     */
    public function 正常系()
    {
        $response = $this->actingAs($this->follows)->json('DELETE', route('unfollow'), [
            'followed_id' => $this->follower->id,
        ]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('follows', [
            'following_id' => $this->follows->id,
            'followed_id' => $this->follower->id,
        ]);
    }

    /**
     * @test
     */
    public function 異常系_未認証ユーザー()
    {
        $response = $this->json('DELETE', route('unfollow'), [
            'followed_id' => $this->follower->id,
        ]);

        $response->assertStatus(401)->assertJson([
            'message' => 'Unauthenticated.'
        ]);
    }

    /**
     * @test
     */
    public function 異常系_未フォロー()
    {
        $wrongUser = factory(User::class)->create();

        $response = $this->actingAs($this->follows)->json('DELETE', route('unfollow'), [
            'followed_id' => $wrongUser->id,
        ]);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'followed_id' => [
                    '指定されたfollowed idは存在しません。',
                ],
            ],
            'message' => 'The given data was invalid.'
        ]);
    }
}
