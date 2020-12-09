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
            'spoil' => true,
            'contents' => 'めちゃめちゃ面白かった！',
            'result' => 1,
            'rating' => 4.5,
            'joined_at' => '2020/9/24',
        ];

        $response = $this->json('PUT', route('review.update', [
            'reviewId' => $this->review->id,
        ]), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('reviews', $data);
    }

    /**
     * @test
     */
    public function 異常系_指定されたIDのReviewがない()
    {
        $data = [
            'spoil' => true,
            'contents' => 'めちゃめちゃ面白かった！',
            'result' => 1,
            'rating' => 4.5,
            'joined_at' => '2020/9/24',
        ];

        $response = $this->json('PUT', route('review.update', [
            'reviewId' => 999999,
        ]), $data);

        $response->assertStatus(404)->assertJson([
            'errors' => [
                'review_id' => [
                    '指定されたIDのレビューは存在しません。',
                ],
            ],
            'message' => 'The given data was invalid.'
        ]);
        $this->assertDatabaseMissing('reviews', $data);
    }

    /**
     * @test
     */
    public function 異常系_不正な値()
    {
        $data = [
            'contents' => 'めちゃめちゃ面白かった！',
            'joined_at' => '2099/12/31',
        ];

        $response = $this->json('PUT', route('review.update', [
            'reviewId' => $this->review->id,
        ]), $data);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'spoil' => [
                    'spoilは必須です。',
                ],
                'result' => [
                    'resultは必須です。',
                ],
                'rating' => [
                    'ratingは必須です。',
                ],
                'joined_at' => [

                ],
            ],
            'message' => 'The given data was invalid.'
        ]);
        $this->assertDatabaseMissing('reviews', $data);
    }
}
