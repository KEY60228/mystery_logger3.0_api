<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UpdateUserApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->user2 = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function 正常系()
    {
        $response = $this->actingAs($this->user)->json('PUT', route('user.update', $this->user->id), [
            'name' => $this->user->name,
            'account_id' => $this->user->account_id,
            'profile' => $this->user->profile,
        ]);

        $user = User::find($this->user->id);

        $response->assertStatus(200);
        $this->assertEquals($this->user->name, $user->name);
    }
    
    /**
     * @test
     */
    public function 異常系_AccountIDの重複()
    {
        $response = $this->actingAs($this->user2)->json('PUT', route('user.update', $this->user2->id), [
            'name' => $this->user2->name,
            'account_id' => $this->user->account_id, // 重複
            'profile' => $this->user2->profile,
        ]);
    
        $user2 = User::find($this->user2->id);
    
        $response->assertStatus(422);
    }
}
