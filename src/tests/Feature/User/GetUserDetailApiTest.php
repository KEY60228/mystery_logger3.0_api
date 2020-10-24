<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Review;
use App\Models\Category;

class getUserDetailApiTest extends TestCase
{
  use RefreshDatabase;

  public function setUp(): void
  {
    parent::setUp();
    $this->user = factory(User::class)->create();
    $this->category = factory(Category::class)->create();
    $this->product = factory(Product::class)->create([
      'category_id' => $this->category->id,
    ]);
    $this->reviews = factory(Review::class, 3)->create([
      'user_id' => $this->user->id,
      'product_id' => $this->product->id,
    ]);
  }

  /**
   * @test
   */
  public function 正常系()
  {
    $response = $this->json('GET', route('user.show', [
      'userId' => $this->user->account_id,
    ]));

    $response->assertStatus(200)->assertJson([
      'id' => $this->user->id,
      'name' => $this->user->name,
      'account_id' => $this->user->account_id,
      'reviews' => [[
        'user_id' => $this->user->id,
        'product' => [
          'id' => $this->product->id,
          'avg_rating' => $this->product->avg_rating,
          'success_count' => $this->product->success_count,
          'category' => [
            'id' => $this->category->id,
          ]
        ]
      ]]
    ]);
  }

  public function 該当しないID()
  {
    $response = $this->json('GET', route('user.show', [
      'userId' => 'a',
    ]));

    $response->assertStatus(422);
  }
}
