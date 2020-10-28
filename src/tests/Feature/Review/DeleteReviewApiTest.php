<?php

namespace Tests\Feature\tests\Feature\Review;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Review;

class DeleteReviewApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->review = factory(Review::class)->create();
    }

    /**
     * @test
     */
    public function 正常系()
    {
        $response = $this->json('DELETE', route('review.delete', [
            'reviewId' => $this->review->id,
        ]));

        $response->assertStatus(204);
        $this->assertNull(Review::find($this->review->id));
    }
}
