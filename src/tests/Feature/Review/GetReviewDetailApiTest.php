<?php

namespace Tests\Feature\Review;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Review;
use App\Models\Category;
use App\Models\Performance; 
use App\Models\Organizer;
use App\Models\Venue;

class GetReviewDetailApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->category = factory(Category::class)->create();
        $this->organizer = factory(Organizer::class)->create();
        $this->user = factory(User::class)->create();
        $this->product = factory(Product::class)->create([
            'category_id' => $this->category->id,
        ]);
        $this->review = factory(Review::class)->create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);
        $this->venue = factory(Venue::class)->create([
            'organizer_id' => $this->organizer->id,
        ]);
        $this->performance = factory(Performance::class)->create([
            'product_id' => $this->product->id,
            'venue_id' => $this->venue->id,
        ]);
    }

    /**
     * @test
     */
    public function 正常系()
    {
        $response = $this->json('GET', route('review.show', [
            'reviewId' => $this->review->id,
        ]));

        $response->assertStatus(200)->assertJson([
            'id' => $this->review->id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'product' => [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'reviews_count' => $this->product->reviews_count,
                'category' => [
                    'id' => $this->category->id,
                ],
                'performances' => [[
                    'venue' => [
                        'id' => $this->venue->id,
                    ],
                ]],
            ],
        ]);
    }

    /**
     * @test
     */
    public function 異常系_指定されたidのReviewがない()
    {
        $response = $this->json('GET', route('review.show', [
            'reviewId' => 999999,
        ]));

        $response->assertStatus(404)->assertJson([
            'errors' => [
                'review_id' => [
                    '指定されたIDのレビューは存在しません。',
                ],
            ],
            'message' => 'The given data was invalid.'
        ]);
    }
}
