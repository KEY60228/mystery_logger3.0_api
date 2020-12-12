<?php

namespace Tests\Feature\Wanna;

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
        $response = $this->actingAs($this->user)->json('DELETE', route('unwanna'), [
            'product_id' => $this->product->id,
        ]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('wannas', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);
    }

    /**
     * @test
     */
    public function 異常系_未認証ユーザー()
    {
        $response = $this->json('DELETE', route('unwanna'), [
            'product_id' => $this->product->id,
        ]);

        $response->assertStatus(401)->assertJson([
            'message' => 'Unauthenticated.'
        ]);
        $this->assertDatabaseHas('wannas', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
        ]);
    }

    /**
     * @test
     */
    public function 異常系_「行きたい」未登録()
    {
        $otherProduct = factory(Product::class)->create();

        $response = $this->actingAs($this->user)->json('DELETE', route('unwanna'), [
            'product_id' => $otherProduct->id,
        ]);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'product_id' => [
                    '指定されたproduct idは存在しません。'
                ],
            ],
            'message' => 'The given data was invalid.',
        ]);
    }
}
