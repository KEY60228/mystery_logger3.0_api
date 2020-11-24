<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Review;
use App\Models\Comment;

class PostCommentApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->review = factory(Review::class)->create();
    }

    /**
     * @test
     */
    public function 正常系()
    {
        $data = [
            'user_id' => $this->user->id,
            'review_id' => $this->review->id,
            'contents' => '面白かった！',
        ];

        $response = $this->json('POST', route('comment.post'), $data);

        $comment = Comment::first();

        $response->assertStatus(201);
        $this->assertEquals($data['contents'], $comment->contents);
    }
}
