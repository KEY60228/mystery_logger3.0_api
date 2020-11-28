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
        $response = $this->json('DELETE', route('unlike.review'), [
            'user_id' => $this->user->id,
            'review_id' => $this->review->id,
        ]);

        $response->assertStatus(204);
        $this->assertNull(ReviewLike::first());
    }
}
