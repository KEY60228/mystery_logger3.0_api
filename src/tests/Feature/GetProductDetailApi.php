<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;

class GetProductDetailApi extends TestCase
{
  use RefreshDatabase;

  public function setUp(): void
  {
    parent::setUp();
    $this->product = factory(Product::class)->create();
  }

  /**
   * @test
   */
  public function 正常系()
  {
    $response = $this->json('GET', route('product.show', [
      'id' => $this->product->id
    ]));

    $response->assertStatus(200);

    $response->assertStatus(200)->assertJsonFragment([
      'id' => $this->product->id,
      'name' => $this->product->name,
    ]);
  }
}
