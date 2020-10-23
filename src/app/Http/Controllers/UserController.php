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

      // 平均レートの取得
      $avgRating = $product->reviews->avg('rating');
      if ($avgRating === 0 || $avgRating === null) {
        $review['product']->avgRating = null;
      } else {
        $review['product']->avgRating = round($avgRating, 2);
      }

      // 成功数、成功率の取得
      $allCount = Review::where('product_id', $review['product']->id)->count();
      $NACount = Review::where('product_id', $review['product']->id)->where('result', 0)->count();

      if ($allCount === 0 || $NACount === $allCount) {
        $review['product']->successCount = 0;
        $review['product']->successRate = null;
      } else {
        $successCount = Review::where('product_id', $review['product']->id)->where('result', 1)->count();
        $successRate = $successCount / ($allCount - $NACount);

        $review['product']->successCount = $successCount;
        $review['product']->successRate = round($successRate, 2);
      }
    }

    return Response::json($user, 200);
  }
}
