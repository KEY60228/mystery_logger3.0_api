<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Review;

class GetReviewsApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->follows = factory(User::class)->create();
        $this->product = factory(Product::class)->create();
        $this->reviews = factory(Review::class)->create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);
    }

    /**
     * @test
     */
    public function 正常系()
    {
        $response = $this->json('GET', route('review.timeline'), [
            'user_id' => $this->user->id,
        ]);

        $response->assertStatus(200)->assertJson([[
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]]);
    }
}
