<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use App\Models\Category;
use App\Models\Organizer;
use App\Models\Venue;
use App\Models\Performance;

class GetTopPageApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->category = factory(Category::class)->create();
        $this->organizer = factory(Organizer::class)->create();
        $this->user = factory(User::class)->create();
        $this->product = factory(Product::class)->create([
            'category_id' => $this->category->id,
            'organizer_id' => $this->organizer->id,
        ]);
        $this->venue = factory(Venue::class)->create([
            'organizer_id' => $this->organizer->id,
        ]);
        $this->performance = factory(Performance::class)->create([
            'product_id' => $this->product->id,
            'venue_id' => $this->venue->id,
        ]);
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
        $response = $this->json('GET', route('product.index'));

        $reviewCount = Review::whereProductId($this->product->id)->count();
        $avgRating = Review::whereProductId($this->product->id)->avg('rating');

        $allCount = Review::where('product_id', $this->product->id)->count();
        $NACount = Review::where('product_id', $this->product->id)->where('result', 0)->count();
        if ($allCount === 0 || $NACount === $allCount) {
            $successCount = 0;
            $successRate = null;
        } else {
            $successCount = Review::where('product_id', $this->product->id)->where('result', 1)->count();
            $successRate = $successCount / ($allCount - $NACount);
        }

        $response->assertStatus(200)->assertJson([
            'products_sortby_ratings' => [[
                // 'id' => $this->product->id,
                // 'name' => $this->product->name,
                // 'reviews_count' => (Integer)$reviewCount,
                // 'avg_rating' => round($avgRating, 2),
                // 'success_rate' => round($successRate, 2),
            ]],
            'products_sortby_reviews_count' => [[
                // 'id' => $this->product->id,
                // 'name' => $this->product->name,
                // 'reviews_count' => (Integer)$reviewCount,
                // 'avg_rating' => round($avgRating, 2),
                // 'success_rate' => round($successRate, 2),
            ]],
            'products_sortby_success_rate' => [[
                // 'id' => $this->product->id,
                // 'name' => $this->product->name,
                // 'reviews_count' => (Integer)$reviewCount,
                // 'avg_rating' => round($avgRating, 2),
                // 'success_rate' => round($successRate, 2),
            ]],
            'products_categorizeby_organizer' => [[
                // 'id' => $this->product->id,
                // 'name' => $this->product->name,
                // 'reviews_count' => (Integer)$reviewCount,
                // 'avg_rating' => round($avgRating, 2),
                // 'success_rate' => round($successRate, 2),
            ]],
            'products_categorizeby_venue' => [[
                // ' => $this->product->id,
                // 'name' => $this->product->name,
                // 'reviews_count' => (Integer)$reviewCount,
                // 'avg_rating' => round($avgRating, 2),
                // 'success_rate' => round($successRate, 2),
            ]],
            'products_categorizeby_category' => [[
                // ' => $this->product->id,
                // 'name' => $this->product->name,
                // 'reviews_count' => (Integer)$reviewCount,
                // 'avg_rating' => round($avgRating, 2),
                // 'success_rate' => round($successRate, 2),
            ]],
            'users_sortby_reviews_count' => [[
                // ' => $this->user->id,
                // 'name' => $this->user->name,
            ]],
            'users_sortby_success_rate' => [[
                // ' => $this->user->id,
                // 'name' => $this->user->name,
            ]],
        ]);
    }
}
