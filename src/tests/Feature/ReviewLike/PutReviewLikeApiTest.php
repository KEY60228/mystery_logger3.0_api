<?php

namespace Tests\Feature\ReviewLike;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Review;
use App\Models\ReviewLike;

class PutReviewLikeApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->review = factory(Review::class)->create();
    }

    /**
     * @test
     */
    public function 正常系()
    {
        $response = $this->actingAs($this->user)->json('PUT', route('like.review'), [
            'review_id' => $this->review->id,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('review_likes', [
            'user_id' => $this->user->id,
            'review_id' => $this->review->id,
        ]);
    }

    /**
     * @test
     */
    public function 異常系_未認証ユーザー()
    {
        $response = $this->json('PUT', route('like.review'), [
            'review_id' => $this->review->id,
        ]);

        $response->assertStatus(401)->assertJson([
            'message' => 'Unauthenticated.'
        ]);
        $this->assertDatabaseMissing('review_likes', [
            'user_id' => $this->user->id,
            'review_id' => $this->review->id,
        ]);
    }

    /**
     * @test
     */
    public function 異常系_二重LIKE()
    {
        $reviewLike = factory(ReviewLike::class)->create([
            'user_id' => $this->user->id,
            'review_id' => $this->review->id,
        ]);

        $response = $this->actingAs($this->user)->json('PUT', route('like.review'), [
            'review_id' => $this->review->id,
        ]);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'review_id' => [
                    'そのreview idはすでに使われています。',
                ],
            ],
            'message' => 'The given data was invalid.',
        ]);
    }

    /**
     * @test
     */
    public function 異常系_存在しないレビューID()
    {
        $response = $this->actingAs($this->user)->json('PUT', route('like.review'), [
            'review_id' => 999999,
        ]);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'review_id' => [
                    '指定されたreview idは存在しません。',
                ],
            ],
            'message' => 'The given data was invalid.',
        ]);
        $this->assertDatabaseMissing('review_likes', [
            'user_id' => $this->user->id,
            'review_id' => 999999,
        ]);
    }
}
