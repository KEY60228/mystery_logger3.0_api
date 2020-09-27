<?php

namespace Tests\Feature\Review;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Review;

class GetReviewDetailApiTest extends TestCase
{
  use RefreshDatabase;

  public function setUp(): void
  {
    parent::setUp();
    $this->user = factory(User::class)->create();
    $this->product = factory(Product::class)->create();
    $this->review = factory(Review::class)->create([
      'user_id' => $this->user->id,
      'product_id' => $this->product->id,
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
      ]
    ]);
  }
}
