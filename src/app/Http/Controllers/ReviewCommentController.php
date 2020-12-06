<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\ReviewComment;

class ReviewCommentController extends Controller
{
    public function post(Request $request) {
        $comment = ReviewComment::create([
            'user_id' => $request->user_id,
            'review_id' => $request->review_id,
            'contents' => $request->contents,
        ]);
        
        if (is_null($comment)) {
            return Response::json([], 422);
        }
        
        return Response::json([], 201);
    }
}
