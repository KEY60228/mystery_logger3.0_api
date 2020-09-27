<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use Illuminate\Support\Facades\Response;

class GetAllProductsApiTest extends TestCase
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
    $response = $this->json('GET', route('product.index'));

    $response->assertStatus(200)->assertJsonFragment([
      'name' => $this->product->name,
      'contents' => $this->product->contents,
      'image_name' => $this->product->image_name,
    ]);
  }
}
