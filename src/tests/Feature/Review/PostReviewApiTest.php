<?php

namespace Tests\Feature\Review;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;

class PostReviewApiTest extends TestCase
{
  use RefreshDatabase;

  public function setUp(): void
  {
    parent::setUp();
    $this->user = factory(User::class)->create();
    $this->product = factory(Product::class)->create();
  }

  /**
   * @test
   */
  public function 正常系()
  {
    $data = [
      'user_id' => $this->user->id,
      'product_id' => $this->product->id,
      'contents' => 'めちゃめちゃ面白かった！',
      'result' => 1,
      'clear_time' => 165,
      'rating' => 4.5,
      'joined_at' => '2020/9/24',
    ];

    $response = $this->json('POST', route('review.post'), $data);

    $review = Review::first();

    $response->assertStatus(201);
    $this->assertEquals($data['user_id'], $review->user_id);
    $this->assertEquals($data['contents'], $review->contents);
  }
  
  /**
   * @test
   */
  public function 不正系_不正なユーザーID()
  {
    $data = [
      'user_id' => 2316,
      'product_id' => $this->product->id,
      'contents' => '面白かった',
      'result' => 1,
      'clear_time' => 165,
      'rating' => 4.5,
      'joined_at' => '2020/9/20'
    ];
    
    $response = $this->json('POST', route('review.post'), $data);
  
    $review = Review::first();
  
    $response->assertStatus(422);
    $this->assertNull($review);
  }

  /**
   * @test
   */
  public function 不正系_不正な作品ID()
  {
    $data = [
      'user_id' => $this->user->id,
      'product_id' => 2123,
      'contents' => '面白かった',
      'result' => 1,
      'clear_time' => 165,
      'rating' => 4.5,
      'joined_at' => '2020/9/20'
    ];
    
    $response = $this->json('POST', route('review.post'), $data);
  
    $review = Review::first();
  
    $response->assertStatus(422);
    $this->assertNull($review);
  }
  
  /**
   * @test
   */
  public function 不正系_不正なresult()
  {
    $data = [
      'user_id' => $this->user->id,
      'product_id' => $this->product->id,
      'contents' => '面白かった',
      'result' => 5,
      'clear_time' => 165,
      'rating' => 4.5,
      'joined_at' => '2020/9/20'
    ];
    
    $response = $this->json('POST', route('review.post'), $data);
  
    $review = Review::first();
  
    $response->assertStatus(422);
    $this->assertNull($review);
  }
  
  /**
   * @test
   */
  public function 不正系_未来のjoined_at()
  {
    $data = [
      'user_id' => $this->user->id,
      'product_id' => $this->product->id,
      'contents' => '面白かった',
      'result' => 5,
      'clear_time' => 165,
      'rating' => 4.5,
      'joined_at' => '2020/10/20'
    ];
    
    $response = $this->json('POST', route('review.post'), $data);
  
    $review = Review::first();
  
    $response->assertStatus(422);
    $this->assertNull($review);
  }
}
