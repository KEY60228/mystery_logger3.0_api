<?php

namespace Tests\Feature\tests\Feature\Review;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Review;
use App\Models\User;

class DeleteReviewApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->review = factory(Review::class)->create([
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * @test
     */
    public function 正常系()
    {
        $response = $this->actingAs($this->user)->json('DELETE', route('review.delete', [
            'reviewId' => $this->review->id,
        ]));

        $response->assertStatus(204);
        $this->assertSoftDeleted('reviews', [
            'id' => $this->review->id,
        ]);
    }

    /**
     * @test
     */
    public function 異常系_自分のレビューでない()
    {
        $wrongUser = factory(User::class)->create();

        $response = $this->actingAs($wrongUser)->json('DELETE', route('review.delete', [
            'reviewId' => $this->review->id,
        ]));

        $response->assertStatus(422)->assertJson([
            'message' => '不正な操作です。'
        ]);
        $this->assertDatabaseHas('reviews', [
            'id' => $this->review->id,
        ]);
    }

    /**
     * @test
     */
    public function 異常系_未認証ユーザー()
    {
        $response = $this->json('DELETE', route('review.delete', [
            'reviewId' => $this->review->id,
        ]));

        $response->assertStatus(401)->assertJson([
            'message' => 'Unauthenticated.',
        ]);
        $this->assertDatabaseHas('reviews', [
            'id' => $this->review->id,
        ]);
    }

    /**
     * @test
     */
    public function 異常系_指定されたIDのReviewがない()
    {
        $response = $this->actingAs($this->user)->json('DELETE', route('review.delete', [
            'reviewId' => 999999,
        ]));

        $response->assertStatus(404)->assertJson([
            'errors' => [
                'review_id' => [
                    '指定されたIDのレビューは存在しません。',
                ],
            ],
            'message' => 'The given data was invalid.',
        ]);
        $this->assertDatabaseHas('reviews', [
            'id' => $this->review->id,
        ]);
    }
}
