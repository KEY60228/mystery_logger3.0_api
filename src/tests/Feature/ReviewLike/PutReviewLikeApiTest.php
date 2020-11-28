<?php

namespace Tests\Feature;

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
        $response = $this->json('PUT', route('like.review'), [
            'user_id' => $this->user->id,
            'review_id' => $this->review->id,
        ]);

        $like = ReviewLike::first();

        $response->assertStatus(201);
        $this->assertEquals($like->user_id, $this->user->id);
        $this->assertEquals($like->review_id, $this->review->id);
    }
}
