<?php

namespace Tests\Feature\Follow;

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
        $response = $this->actingAs($this->follows)->json('PUT', route('follow'), [
            'followed_id' => $this->follower->id,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('follows', [
            'following_id' => $this->follows->id,
            'followed_id' => $this->follower->id,
        ]);
    }

    /**
     * @test
     */
    public function 異常系_未認証ユーザー()
    {
        $response = $this->json('PUT', route('follow'), [
            'followed_id' => $this->follower->id,
        ]);

        $response->assertStatus(401)->assertJson([
            'message' => 'Unauthenticated.'
        ]);
    }

    /**
     * @test
     */
    public function 異常系_二重フォロー()
    {
        $this->follow = factory(Follow::class)->create([
            'following_id' => $this->follows->id,
            'followed_id' => $this->follower->id,
        ]);

        $response = $this->actingAs($this->follows)->json('PUT', route('follow'), [
            'followed_id' => $this->follower->id,
        ]);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'followed_id' => [
                    'そのfollowed idはすでに使われています。',
                ],
            ],
            'message' => 'The given data was invalid.',
        ]);
    }

    /**
     * @test
     */
    public function 異常系_存在しないフォロワー()
    {
        $response = $this->actingAs($this->follows)->json('PUT', route('follow'), [
            'followed_id' => 999999,
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
