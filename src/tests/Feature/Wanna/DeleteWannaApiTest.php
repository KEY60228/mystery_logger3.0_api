<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Wanna;

class DeleteWannaApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->product = factory(Product::class)->create();
        $this->wanna = factory(Wanna::class)->create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);
    }

    /**
     * @test
     */
    public function 正常系()
    {
        $response = $this->json('DELETE', route('unwanna'), [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);

        $response->assertStatus(204);
        $this->assertNull(Wanna::whereUserId($this->user->id)->whereProductId($this->product->id)->first());
    }
}
