<?php

namespace Tests\Feature\Accompany;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Accompany;
use App\Models\User;
use App\Models\Performance;
use App\Models\Venue;
use App\Models\Product;

class GetAccompaniesApiTest extends TestCase
{
    use RefreshDatabase;
    
    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->product = factory(Product::class)->create();
        $this->venue = factory(Venue::class)->create();
        $this->performance = factory(Performance::class)->create([
            'product_id' => $this->product->id,
            'venue_id' => $this->venue->id,
        ]);
        $this->accompany = factory(Accompany::class)->create([
            'user_id' => $this->user->id,
            'performance_id' => $this->performance->id,
        ]);
    }

    /**
     * @test
     */
    public function 正常系()
    {
        $response = $this->json('GET', route('accompanies'));

        $response->assertStatus(200)->assertJson([[
            'user_id' => $this->user->id,
            'performance_id' => $this->performance->id,
            'user' => [
                'id' => $this->user->id,
            ],
            'performance' => [
                'id' => $this->performance->id,
                'venue' => [
                    'id' => $this->venue->id,
                ],
                'product' => [
                    'id' => $this->product->id,
                ],
            ],
        ]]);
    }
}
