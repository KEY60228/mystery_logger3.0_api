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
        $response = $this->actingAs($this->user)->json('PUT', route('wanna'), [
            'product_id' => $this->product->id,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('wannas', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);
    }

    /**
     * @test
     */
    public function 異常系_未認証ユーザー()
    {
        $response = $this->json('PUT', route('wanna'), [
            'product_id' => $this->product->id,
        ]);

        $response->assertStatus(401)->assertJson([
            'message' => 'Unauthenticated.',
        ]);
        $this->assertDatabaseMissing('wannas', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);
    }

    /**
     * @test
     */
    public function 二重で行きたい()
    {
        $existWanna = factory(Wanna::class)->create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);

        $response = $this->actingAs($this->user)->json('PUT', route('wanna'), [
            'product_id' => $this->product->id,
        ]);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'product_id' => [
                    'そのproduct idはすでに使われています。'
                ],
            ],
            'message' => 'The given data was invalid.',
        ]);
    }

    /**
     * @test
     */
    public function 存在しない作品()
    {
        $response = $this->actingAs($this->user)->json('PUT', route('wanna'), [
            'product_id' => 999999,
        ]);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'product_id' => [
                    '指定されたproduct idは存在しません。'
                ],
            ],
            'message' => 'The given data was invalid.',
        ]);
        $this->assertDatabaseMissing('wannas', [
            'user_id' => $this->user->id,
            'product_id' => 999999,
        ]);
    }
}
