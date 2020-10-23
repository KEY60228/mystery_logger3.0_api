<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use App\Models\Performance;
use App\Models\Category;
use App\Models\Venue;
use App\Models\Organizer;

class GetProductDetailApi extends TestCase
{
  use RefreshDatabase;

  public function setUp(): void
  {
    parent::setUp();
    $this->user = factory(User::class)->create();
    $this->organizer = factory(Organizer::class)->create();
    $this->category = factory(Category::class)->create();
    $this->product = factory(Product::class)->create([
      'organizer_id' => $this->organizer->id,
      'category_id' => $this->category->id,
    ]);
    $this->venue = factory(Venue::class)->create([
      'organizer_id' => $this->organizer->id,
    ]);
    $this->performance = factory(Performance::class)->create([
      'product_id' => $this->product->id,
      'venue_id' => $this->venue->id,
    ]);
    $this->review = factory(Review::class, 3)->create([
      'user_id' => $this->user->id,
      'product_id' => $this->product->id,
    ]);
  }

  /**
   * @test
   */
  public function 正常系()
  {
    $response = $this->json('GET', route('product.show', [
      'id' => $this->product->id
    ]));

    $reviewCount = Review::whereProductId($this->product->id)->count();
    $avgRating = Review::whereProductId($this->product->id)->avg('rating');

    $allCount = Review::where('product_id', $this->product->id)->count();
    $NACount = Review::where('product_id', $this->product->id)->where('result', 0)->count();
    if ($allCount === 0 || $NACount === $allCount) {
      $successCount = 0;
      $successRate = null;
    } else {
      $successCount = Review::where('product_id', $this->product->id)->where('result', 1)->count();
      $successRate = $successCount / ($allCount - $NACount);
    }

    $response->assertStatus(200)->assertJson([
      'id' => $this->product->id,
      'name' => $this->product->name,
      'reviews' => [[
        'user_id' => $this->user->id,
        'product_id' => $this->product->id,
        'user' => [
          'name' => $this->user->name,
        ]
      ]],
      'category' => [
        'name' => $this->category->name,
      ],
      'reviews_count' => (Integer)$reviewCount,
      'avgRating' => round($avgRating, 2),
      'successRate' => round($successRate, 2),
      'performances' => [[
        'product_id' => $this->performance->product_id,
        'venue' => [
          'name' => $this->venue->name,
        ]
      ]],
      'organizer' => [
        'name' => $this->organizer->name,
      ]
    ]);
  }
}
