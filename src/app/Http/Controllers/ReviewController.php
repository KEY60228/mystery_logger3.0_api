<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Review;
use App\Models\User;

class ReviewController extends Controller
{
    /**
     * レビュー投稿
     * 
     * @param App\Http\Requests\PostReviewRequest
     * @return Illuminate\Support\Facades\Response
     */
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

    /**
     * レビュー詳細
     * 
     * @param Illuminate\Http\Request
     * @param string $id
     * @return Illuminate\Support\Facades\Response
     */
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

    /**
     * レビュー更新
     * 
     * @param App\Http\Requests\UpdateReviewRequest
     * @param string $id
     * @return Illuminate\Support\Facades\Response
     */
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

        if ((Integer)$review->user_id !== $request->user()->id) {
            return Response::json([
                'message' => '不正な操作です。',
            ], 422);
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

    /**
     * レビュー削除
     * 
     * @param Illuminate\Http\Request
     * @param string $id
     * @return Illuminate\Support\Facades\Response
     */
    public function delete(Request $request, $id) {
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

        if ((Integer)$review->user_id !== $request->user()->id) {
            return Response::json([
                'message' => '不正な操作です。',
            ], 422);
        }

        $review->delete();

        return Response::json([], 204);
    }

    /**
     * タイムライン
     * 
     * @param Illuminate\Http\Request
     * @return Illuminate\Support\Facades\Response
     */
    public function index(Request $request) {
        $user_reviews = Review::where('user_id', $request->user()->id)->with([
            'product',
            'user',
        ])->get();
            
        $follows_reviews = Review::whereIn('user_id', $request->user()->follows_id)->with([
            'product',
            'user',
        ])->get();

        $timeline = $user_reviews->merge($follows_reviews)->sortByDesc('created_at')->values()->all();

        return Response::json($timeline, 200);
    }

    /**
     * ネタバレ取得
     */
    public function spoil(Request $request, $id) {
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
        
        $user = Auth::user();

        if (!$user->reviews->contains('product_id', $review->product_id)) {
            return Response::json([
                'message' => 'You have no right to see.'
            ], 422);
        }

        $review->exposed_contents = $review->contents;
        $review->spoil = false;

        return Response::json($review, 200);
    }
}
