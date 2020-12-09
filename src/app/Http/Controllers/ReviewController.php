<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\PostReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Review;
use App\Models\User;

class ReviewController extends Controller
{
    public function post(PostReviewRequest $request) {
        $review = Review::create([
            'user_id' => $request->user()->id,
            'product_id' => $request->product_id,
            'spoil' => $request->spoil,
            'contents' => $request->contents,
            'result' => $request->result,
            'rating' => $request->rating,
            'joined_at' => $request->joined_at,
        ]);

        return Response::json([], 201);
    }

    public function show(Request $request, $id) {
        $review = Review::whereId($id)->with([
            'user',
            'product',
            'product.category',
            'product.organizer',
            'product.performances.venue',
            'review_comments',
            'review_comments.user',
        ])->first();

        if (!$review) {
            return Response::json([
                'errors' => [
                    'review_id' => [
                        '指定されたIDのレビューは存在しません。',
                    ],
                ],
                'message' => 'The given data was invalid.',
            ], 404);
        }

        return Response::json($review, 200);
    }

    public function update(UpdateReviewRequest $request, $id) {
        $review = Review::find($id);

        if (!$review) {
            return Response::json([
                'errors' => [
                    'review_id' => [
                        '指定されたIDのレビューは存在しません。',
                    ],
                ],
                'message' => 'The given data was invalid.',
            ], 404);
        }

        $review->update([
            'contents' => $request->contents,
            'spoil' => $request->spoil,
            'result' => $request->result,
            'rating' => $request->rating,
            'joined_at' => $request->joined_at,
        ]);

        return Response::json([], 200);
    }

    public function delete(Request $request, $id) {
        Review::find($id)->delete();

        return Response::json([], 204);
    }

    public function index(Request $request) {
        $user = User::find($request->user_id);
        $userId = $user->id;
        $followsId = $user->follows_id;
        $followsId[] = $userId;

        $timeline = Review::whereIn('user_id', $followsId)->with(['product', 'user'])->orderBy('created_at', 'desc')->get();

        return Response::json($timeline, 200);
    }
}
