<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Review;
use App\Models\ReviewComment;

class PostReviewCommentApiTest extends TestCase
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
        $data = [
            'review_id' => $this->review->id,
            'contents' => '面白かった！',
        ];

        $response = $this->actingAs($this->user)->json('POST', route('comment.review.post'), $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('review_comments', $data);
    }

    /**
     * @test
     */
    public function 異常系_未認証ユーザー()
    {
        $data = [
            'review_id' => $this->review->id,
            'contents' => '面白かった！',
        ];

        $response = $this->json('POST', route('comment.review.post'), $data);

        $response->assertStatus(401)->assertJson([
            'message' => 'Unauthenticated.'
        ]);
        $this->assertDatabaseMissing('review_comments', $data);
    }

    /**
     * @test
     */
    public function 異常系_存在しないレビューID()
    {
        $data = [
            'review_id' => 999999,
            'contents' => '面白かった！',
        ];

        $response = $this->actingAs($this->user)->json('POST', route('comment.review.post'), $data);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'review_id' => [
                    '指定されたreview idは存在しません。',
                ],
            ],
            'message' => 'The given data was invalid.',
        ]);
        $this->assertDatabaseMissing('review_comments', $data);
    }
}
