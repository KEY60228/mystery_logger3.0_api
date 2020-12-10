<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Review;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * ユーザー詳細
     * 
     * @param Illuminate\Http\Request
     * @param string $id
     * @return Illuminate\Support\Facades\Response
     */
    public function show(Request $request, $id) {
        $user = User::whereAccountId($id)->with([
            'reviews',
            'reviews.product',
            'reviews.product.category',
            'wannas.product',
            'follows',
            'followers',
            'review_likes',
            'review_likes.review',
            'review_likes.review.user',
            'review_likes.review.product',
        ])->first();

        if (!$user) {
            return Response::json([
                'errors' => [
                    'account_id' => '指定されたアカウントIDのユーザーはいません。',
                ],
                'messages' => 'The given data was invalid.',
            ], 404);
        }
        
        return Response::json($user, 200);
    }

    /**
     * クッキーログイン & ユーザー情報更新
     * 
     * @param Illuminate\Http\Request
     * @return Illuminate\Support\Facades\Response
     */
    public function currentuser(Request $request) {
        $user = Auth::user();

        if (!$user) {
            return Response::json([], 204);
        }

        return Response::json([
            'id' => $user->id,
            'account_id' => $user->account_id,
            'name' => $user->name,
            'follows_id' => $user->follows_id,
            'followers_id' => $user->followers_id,
            'done_id' => $user->done_id,
            'wanna_id' => $user->wanna_id,
            'like_reviews_id' => $user->like_reviews_id,
        ], 200);
    }

    public function update(UpdateUserRequest $request, $id) {
        $user = Auth::user();

        if (!$user) {
            return Response::json([], 422);
        }

        $user->update([
            'name' => $request->name,
            'account_id' => $request->account_id,
            'profile' => $request->profile,
        ]);

        return Response::json([], 200);
    }
}
