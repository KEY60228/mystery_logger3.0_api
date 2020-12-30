<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\ReviewComment;
use App\Http\Requests\PostReviewCommentRequest;

class ReviewCommentController extends Controller
{
    /**
     * レビューに対するコメントの投稿
     * 
     * @param App\Http\Requests\PostReviewCommentRequest
     * @return Illuminate\Support\Facades\Response
     */
    public function post(PostReviewCommentRequest $request) {
        $comment = ReviewComment::create([
            'user_id' => $request->user()->id,
            'review_id' => $request->review_id,
            'contents' => $request->contents,
        ]);

        return Response::json([], 201);
    }
}
