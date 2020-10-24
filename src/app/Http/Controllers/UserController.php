<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use App\Models\Product;
use App\Models\Review;

class UserController extends Controller
{
  public function show(Request $request, $id) {
    $user = User::whereAccountId($id)->with(['reviews', 'reviews.product', 'reviews.product.category'])->withCount(['reviews'])->first();

    if (is_null($user)) {
      // エラーハンドリング
      return Response::json([], 422);
    }

    // TODO: アクセサに統一する
    foreach ($user->reviews as $review) {
      $product = Product::whereId($review['product']->id)->withCount(['reviews'])->first();
      $review['product']->reviews_count = $product->reviews_count;
    }

    return Response::json($user, 200);
  }
}
