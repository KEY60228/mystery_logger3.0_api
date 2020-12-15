<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\UploadedFile;

class UpdateUserApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }
    
    /**
     * @test
     */
    public function 正常系()
    {
        // テスト用ストレージ
        Storage::fake('public');

        $response = $this->actingAs($this->user)->json('PUT', route('user.update'), [
            'name' => 'guest',
            'account_id' => 'GUEST',
            'profile' => 'よろです！！',
            'image_name' => UploadedFile::fake()->image('user_image.jpeg'),
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'name' => 'guest',
            'account_id' => 'GUEST',
            'profile' => 'よろです！！',
        ]);
        $user = User::first();
        Storage::disk('public')->assertExists(substr($user->image_name, 9));
    }

    /**
     * @test
     */
    public function 異常系_未認証ユーザー()
    {
        $response = $this->json('PUT', route('user.update'), [
            'name' => 'guest',
            'account_id' => 'GUEST',
            'profile' => 'よろです！！',
            ]);
            
        $response->assertStatus(401)->assertJson([
            'message' => 'Unauthenticated.'
        ]);
        $this->assertDatabaseMissing('users', [
            'name' => 'guest',
            'account_id' => 'GUEST',
            'profile' => 'よろです！！',
        ]);
    }

    /**
     * @test
     */
    public function 異常系_AccountIDの重複()
    {
        $wrongUser = factory(User::class)->create();

        $response = $this->actingAs($this->user)->json('PUT', route('user.update'), [
            'name' => 'guest',
            'account_id' => $wrongUser->account_id,
            'profile' => 'よろです！！',
        ]);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'account_id' => [
                    'そのaccount idはすでに使われています。',
                ],
            ],
            'message' => 'The given data was invalid.'
        ]);
        $this->assertDatabaseMissing('users', [
            'id' => $this->user->id,
            'name' => 'guest',
            'account_id' => $wrongUser->account_id,
            'profile' => 'よろです！！',
        ]);
    }

    /**
     * @test
     */
    public function 異常系_DBエラー()
    {
        Schema::drop('users');
        Storage::fake('public');

        $response = $this->actingAs($this->user)->json('PUT', route('user.update'), [
            'name' => 'guest',
            'account_id' => 'GUEST',
            'profile' => 'よろです！！',
            'image_name' => UploadedFile::fake()->image('user_image.jpeg'),
        ]);

        $response->assertStatus(500);
        $this->assertEquals(0, count(Storage::disk('public')->files()));
    }
}
