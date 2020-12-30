<?php

namespace Tests\Feature\Organizer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Organizer;
use App\Models\Venue;
use App\Models\Performance;
use App\Models\Product;
use App\Models\Category;

class GetOrganizerApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->organizer = factory(Organizer::class)->create();
        $this->category = factory(Category::class)->create();
        $this->venue = factory(Venue::class)->create([
            'organizer_id' => $this->organizer->id,
        ]);
        $this->product = factory(Product::class)->create([
            'organizer_id' => $this->organizer->id,
            'category_id' => $this->category->id,
        ]);
        $this->performance = factory(Performance::class)->create([
            'venue_id' => $this->venue->id,
            'product_id' => $this->product->id,
        ]);
    }

    /**
     * @test
     */
    public function 正常系()
    {
        $response = $this->json('GET', route('organizer.show', $this->organizer->id));

        $response->assertStatus(200)->assertJson([
            'service_name' => $this->organizer->service_name,
            'venues' => [[
                'id' => $this->venue->id,
            ]],
            'products' => [[
                'id' => $this->product->id,
                'category' => [
                    'id' => $this->category->id,
                ],
                'performances' => [[
                    'id' => $this->performance->id,
                    'venue' => [
                        'id' => $this->venue->id,
                    ]
                ]],
                'organizer' => [
                    'id' => $this->organizer->id,
                ],
            ]],
        ]);
    }

    /**
     * @test
     */
    public function 異常系_存在しない主催者ID()
    {
        $response = $this->json('GET', route('organizer.show', 999999));

        $response->assertStatus(404)->assertJson([
            'errors' => [
                'organizer_id' => [
                    '指定されたorganizer idは存在しません。'
                ],
            ],
            'message' => 'The given data was invalid.'
        ]);
    }
}
