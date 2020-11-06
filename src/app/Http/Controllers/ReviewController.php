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
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'contents' => $request->contents,
            'result' => $request->result,
            'clear_time' => $request->clear_time,
            'rating' => $request->rating,
            'joined_at' => $request->joined_at,
        ]);

        if (is_null($review)) {
            return Response::json([], 422);
        }

        return Response::json([], 201);
    }

    public function show(Request $request, $id) {
        $review = Review::whereId($id)->with(['user', 'product', 'product.category', 'product.organizer', 'product.performances.venue'])->first();

        return Response::json($review, 200);
    }

    public function update(UpdateReviewRequest $request, $id) {
        $review = Review::find($id)->update([
            'contents' => $request->contents,
            'result' => $request->result,
            'clear_time' => $request->clear_time,
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
