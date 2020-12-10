<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Review;
use App\Models\Follow;

class GetReviewsApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->follows = factory(User::class)->create();
        $this->product = factory(Product::class)->create();
        $this->userReview = factory(Review::class)->create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);
        $this->followsReview = factory(Review::class)->create([
            'user_id' => $this->follows->id,
            'product_id' => $this->product->id,
        ]);
    }

    /**
     * @test
     */
    public function 正常系()
    {
        $response = $this->actingAs($this->user)->json('GET', route('review.timeline'));

        // ToDo: Followしている人の投稿のテストができていない (assertJsonの仕様？)
        $response->assertStatus(200)->assertJson([[
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]]);
    }

    /**
     * @test
     */
    public function 異常系_未認証ユーザー()
    {
        $response = $this->json('GET', route('review.timeline'));

        $response->assertStatus(401)->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }
}
