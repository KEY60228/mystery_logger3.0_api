<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Organizer;
use App\Models\Venue;
use App\Models\Performance;
use App\Models\Product;

class GetOrganizerApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->organizer = factory(Organizer::class)->create();
        $this->venue = factory(Venue::class)->create([
            'organizer_id' => $this->organizer->id,
        ]);
        $this->product = factory(Product::class)->create([
            'organizer_id' => $this->organizer->id,
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
            'name' => $this->organizer->name,
            'venues' => [[
                'id' => $this->venue->id,
            ]],
            'products' => [[
                'id' => $this->product->id,
            ]],
        ]);
    }
}
