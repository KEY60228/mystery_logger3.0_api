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
            'spoil' => true,
            'contents' => 'めちゃめちゃ面白かった！',
            'result' => 1,
            'rating' => 4.5,
            'joined_at' => '2020/9/24',
        ];

        $response = $this->json('POST', route('review.post'), $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('reviews', $data);
    }

    /**
     * @test
     */
    public function 不正系_不正なユーザーID()
    {
        $data = [
            'user_id' => 999999,
            'product_id' => $this->product->id,
            'spoil' => true,
            'contents' => '面白かった',
            'result' => 1,
            'rating' => 4.5,
            'joined_at' => '2020/9/20'
        ];

        $response = $this->json('POST', route('review.post'), $data);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'user_id' => [
                    '指定されたuser idは存在しません。',
                ],
            ],
            'message' => 'The given data was invalid.',
        ]);
        $this->assertDatabaseMissing('reviews', $data);
    }

    /**
     * @test
     */
    public function 不正系_不正な作品ID()
    {
        $data = [
            'user_id' => $this->user->id,
            'product_id' => 999999,
            'spoil' => true,
            'contents' => '面白かった',
            'result' => 1,
            'rating' => 4.5,
            'joined_at' => '2020/9/20'
        ];
        
        $response = $this->json('POST', route('review.post'), $data);
    
        $review = Review::first();
    
        $response->assertStatus(422)->assertJson([
            'errors' => [
                'product_id' => [
                    '指定されたproduct idは存在しません。',
                ],
            ],
            'message' => 'The given data was invalid.',
        ]);
        $this->assertDatabaseMissing('reviews', $data);
    }

    /**
     * @test
     */
    public function 不正系_不正なresult()
    {
        $data = [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'spoil' => true,
            'contents' => '面白かった',
            'result' => 5,
            'rating' => 4.5,
            'joined_at' => '2020/9/20'
        ];
        
        $response = $this->json('POST', route('review.post'), $data);
    
        $review = Review::first();
    
        $response->assertStatus(422)->assertJson([
            'errors' => [
                'result' => [
                    'resultには0〜2までの数値を指定してください。',
                ],
            ],
            'message' => 'The given data was invalid.',
        ]);
        $this->assertDatabaseMissing('reviews', $data);
    }

    /**
     * @test
     */
    public function 不正系_未来のjoined_at()
    {
        $data = [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'spoil' => true,
            'contents' => '面白かった',
            'result' => 1,
            'rating' => 4.5,
            'joined_at' => '2099/12/31'
        ];
        
        $response = $this->json('POST', route('review.post'), $data);
    
        $review = Review::first();
    
        $response->assertStatus(422)->assertJson([
            'errors' => [
                'joined_at' => [
                    
                ],
            ],
            'message' => 'The given data was invalid.',
        ]);
        $this->assertDatabaseMissing('reviews', $data);
    }

    /**
     * @test
     */
    public function 不正系_2回目の投稿()
    {
        Review::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'spoil' => true,
            'result' => 1,
            'rating' => 1,
        ]);

        $data = [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'spoil' => true,
            'result' => 2,
            'rating' => 1,
        ];

        $response = $this->json('POST', route('review.post'), $data);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'product_id' => [
                    
                ],
            ],
            'message' => 'The given data was invalid.',
        ]);
        $this->assertDatabaseMissing('reviews', $data);
    }
}
