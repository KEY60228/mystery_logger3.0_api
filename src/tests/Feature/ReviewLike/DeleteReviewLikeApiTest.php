<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Review;
use App\Models\ReviewLike;

class DeleteReviewLikeApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->review = factory(Review::class)->create();
        $this->like = factory(ReviewLike::class)->create([
            'user_id' => $this->user->id,
            'review_id' => $this->review->id,
        ]);
    }

    /**
     * @test
     */
    public function 正常系()
    {
        $response = $this->actingAs($this->user)->json('DELETE', route('unlike.review'), [
            'review_id' => $this->review->id,
        ]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('review_likes', [
            'user_id' => $this->user->id,
            'review_id' => $this->review->id,
        ]);
    }

    /**
     * @test
     */
    public function 異常系_未認証ユーザー()
    {
        $response = $this->json('DELETE', route('unlike.review'), [
            'review_id' => $this->review->id,
        ]);

        $response->assertStatus(401)->assertJson([
            'message' => 'Unauthenticated.'
        ]);
        $this->assertDatabaseHas('review_likes', [
            'user_id' => $this->user->id,
            'review_id' => $this->review->id,
        ]);
    }

    /**
     * @test
     */
    public function 異常系_未LIKE()
    {
        $otherReview = factory(Review::class)->create();

        $response = $this->actingAs($this->user)->json('DELETE', route('unlike.review'), [
            'review_id' => $otherReview->id,
        ]);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'review_id' => [
                    '指定されたreview idは存在しません。'
                ],
            ],
            'message' => 'The given data was invalid.'
        ]);
        $this->assertDatabaseHas('review_likes', [
            'user_id' => $this->user->id,
            'review_id' => $this->review->id,
        ]);
    }
}
