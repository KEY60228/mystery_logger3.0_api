<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Wanna;

class PutWannaApiTest extends TestCase
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
        $response = $this->json('PUT', route('wanna'), [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);

        $wanna = Wanna::whereUserId($this->user->id)->first();

        $response->assertStatus(200);
        $this->assertEquals($wanna->product_id, $this->product->id);
    }
}
