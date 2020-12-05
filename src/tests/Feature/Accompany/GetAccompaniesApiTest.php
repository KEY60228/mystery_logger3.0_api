<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Accompany;
use App\Models\User;
use App\Models\Performance;

class GetAccompaniesApiTest extends TestCase
{
    use RefreshDatabase;
    
    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->performance = factory(Performance::class)->create();
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
            ],
        ]]);
    }
}
