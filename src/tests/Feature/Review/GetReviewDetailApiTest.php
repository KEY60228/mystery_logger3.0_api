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
        'performance_id' => $this->performance->id,
        'performance' => [
          'venue_id' => $this->venue->id,
        ]
      ],
    ]);
  }
}
