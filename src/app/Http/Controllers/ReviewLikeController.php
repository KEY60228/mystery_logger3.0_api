<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\ReviewLike;
use App\Models\Review;
use App\Models\User;
use App\Http\Requests\ReviewLikeRequest;
use App\Http\Requests\ReviewUnlikeRequest;

class ReviewLikeController extends Controller
{
    /**
     * レビューへのLIKE
     * 
     * @param App\Http\Requests\ReviewLikeRequest
     * @return Illuminate\Support\Facades\Response
     */
    public function like(ReviewLikeRequest $request) {
        $like = ReviewLike::create([
            'user_id' => $request->user()->id,
            'review_id' => $request->review_id,
        ]);

        return Response::json([], 201);
    }

    /**
     * レビューへのLIKE取り消し
     * 
     * @param App\Http\Requests\ReviewUnlikeRequest
     * @return Illuminate\Support\Facades\Response
     */
    public function unlike(ReviewUnlikeRequest $request) {
        $unlike = ReviewLike::whereUserId($request->user()->id)->whereReviewId($request->review_id)->first();

        if (!$unlike) {
            return Response::json([
                'errors' => [
                    'review_id' => [
                        '指定されたreview idは存在しません。',
                    ],
                ],
                'message' => 'The given data was invalid.',
            ], 422);
        }

        $unlike->delete();
        return Response::json([], 204);
    }
}
