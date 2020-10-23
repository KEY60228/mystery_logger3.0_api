<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use App\Models\Category;

class GetAllProductsApiTest extends TestCase
{
  use RefreshDatabase;

  public function setUp(): void
  {
    parent::setUp();
    $this->user = factory(User::class)->create();
    $this->product = factory(Product::class)->create();
    $this->review = factory(Review::class, 3)->create([
      'user_id' => $this->user->id,
      'product_id' => $this->product->id,
    ]);
    $this->category = factory(Category::class)->create();
  }

  /**
   * @test
   */
  public function 正常系()
  {
    $response = $this->json('GET', route('product.index'));

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

    $response->assertStatus(200)->assertJson([[
      'id' => $this->product->id,
      'name' => $this->product->name,
      'reviews_count' => (Integer)$reviewCount,
      'avgRating' => round($avgRating, 2),
      'successRate' => round($successRate, 2),
      'category' =>  [
        'name' => $this->category->name,
      ],
    ]]);
  }
}
