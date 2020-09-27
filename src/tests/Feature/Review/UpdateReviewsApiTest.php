<?php

namespace Tests\Feature\Review;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Review;

class UpdateReviewsApiTest extends TestCase
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
    $data = [
      'contents' => 'めちゃめちゃ面白かった！',
      'result' => 1,
      'clear_time' => 165,
      'rating' => 4.5,
      'joined_at' => '2020/9/24',
    ];

    $response = $this->json('PUT', route('review.update', [
      'reviewId' => $this->review->id,
    ]), $data);

    $review = Review::find($this->review->id);

    $response->assertStatus(200);
    $this->assertEquals($review->user_id, $this->user->id);
    $this->assertEquals($review->product_id, $this->product->id);
    $this->assertEquals($review->contents, $data['contents']);
  }
}
