<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\ReviewLike;
use App\Models\Review;
use App\Models\User;

class ReviewLikeController extends Controller
{
    public function like(Request $request) {
        $like = ReviewLike::create([
            'user_id' => $request->user_id,
            'review_id' => $request->review_id,
        ]);

        if (!$like) {
            return Response::json([], 422);
        }

        return Response::json([], 201);
    }

    public function unlike(Request $request) {
        $unlike = ReviewLike::whereUserId($request->user_id)->whereReviewId($request->review_id)->first();

        if (!$unlike) {
            return Response::json([], 422);
        }

        $unlike->delete();
        return Response::json([], 204);
    }
}