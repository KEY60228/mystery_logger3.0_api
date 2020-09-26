<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\PostReviewRequest;
use App\Models\Review;

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
    $review = Review::whereId($id)->with(['user', 'product'])->first();

    return Response::json($review, 200);
  }
}
