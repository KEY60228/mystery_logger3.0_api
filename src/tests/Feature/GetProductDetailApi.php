<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;

class GetProductDetailApi extends TestCase
{
  use RefreshDatabase;

  public function setUp(): void
  {
    parent::setUp();
    $this->product = factory(Product::class)->create();
    $this->user = factory(User::class)->create();
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

    $response->assertStatus(200)->assertJson([
      'id' => $this->product->id,
      'name' => $this->product->name,
      'reviews' => [[
        'user_id' => $this->user->id,
        'product_id' => $this->product->id,
      ]]
    ]);
  }
}
