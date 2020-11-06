<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Review;

class UserController extends Controller
{
    public function show(Request $request, $id) {
        $user = User::whereAccountId($id)->with(['reviews', 'reviews.product', 'reviews.product.category'])->first();

        if (is_null($user)) {
            // エラーハンドリング
            return Response::json([], 422);
        }

        // TODO: アクセサに統一する
            foreach ($user->reviews as $review) {
            $product = Product::whereId($review['product']->id)->first();
            $review['product']->reviews_count = $product->reviews_count;
        }

        return Response::json($user, 200);
    }

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
        ], 200);
    }
}
