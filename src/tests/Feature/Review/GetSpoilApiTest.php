<?php

namespace Tests\Feature\Review;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Review;
use App\Models\Product;

class GetSpoilApiTest extends TestCase
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
            'spoil' => true,
        ]);
    }

    /**
     * @test
     */
    public function 正常系()
    {
        $response = $this->actingAs($this->user)->json('GET', route('review.spoil', $this->review->id));

        $response->assertStatus(200)->assertJson([
            'id' => $this->review->id,
            'product_id' => $this->product->id,
            'user_id' => $this->user->id,
            'exposed_contents' => $this->review->contents,
        ]);
    }

    /**
     * @test
     */
    public function 異常系_未認証ユーザー()
    {
        $response = $this->json('GET', route('review.spoil', $this->review->id));

        $response->assertStatus(401)->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    /**
     * @test
     */
    public function 異常系_指定されたidのReviewがない()
    {
        $response = $this->actingAs($this->user)->json('GET', route('review.spoil', 999999));

        $response->assertStatus(404)->assertJson([
            'errors' => [
                'review_id' => [
                    '指定されたIDのレビューは存在しません。',
                ],
            ],
            'message' => 'The given data was invalid.'
        ]);
    }

    /**
     * @test
     */
    public function 異常系_参加していないユーザー()
    {
        $wrongUser = factory(User::class)->create();

        $response = $this->actingAs($wrongUser)->json('GET', route('review.spoil', $this->review->id));

        $response->assertStatus(422)->assertJson([
            'message' => 'You have no right to see.',
        ]);
    }
}
