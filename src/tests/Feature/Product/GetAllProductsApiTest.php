<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;

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
    $successCount = Review::where('product_id', $this->product->id)->where('result', 1)->count();
    $NACount = Review::where('product_id', $this->product->id)->where('result', 0)->count();
    $successRate = $successCount / ($allCount - $NACount);

    $response->assertStatus(200)->assertJson([[
      'id' => $this->product->id,
      'name' => $this->product->name,
      'reviews' => [[
        'user_id' => $this->user->id,
        'product_id' => $this->product->id,
      ]],
      'reviews_count' => $reviewCount,
      'avgRating' => $avgRating,
      'successRate' => $successRate,
    ]]);
  }
}
