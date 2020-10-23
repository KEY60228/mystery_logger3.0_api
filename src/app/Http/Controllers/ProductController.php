<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Response;
use App\Models\Review;

class ProductController extends Controller
{
  public function index(Request $request) {
    $products = Product::with(['category'])->withCount('reviews')->get();

    foreach ($products as $product) {
      // 平均レートの取得
      $avgRating = $product->reviews->avg('rating');
      if ($avgRating === 0 || $avgRating === null) {
        $product->avgRating = null;
      } else {
        $product->avgRating = round($avgRating, 2);
      }

      // 成功数、成功率の取得
      $allCount = Review::where('product_id', $product->id)->count();
      $NACount = Review::where('product_id', $product->id)->where('result', 0)->count();

      if ($allCount === 0 || $NACount === $allCount) {
        $product->successCount = 0;
        $product->successRate = null;
      } else {
        $successCount = Review::where('product_id', $product->id)->where('result', 1)->count();
        $successRate = $successCount / ($allCount - $NACount);          

        $product->successCount = $successCount;
        $product->successRate = round($successRate, 2);
      }
    }

    return Response::json($products, 200);
  }

  public function show(Request $request, $id) {
    $product = Product::whereId($id)->with(['reviews', 'reviews.user', 'category', 'performances', 'performances.venue', 'organizer'])->withCount('reviews')->first();

    // 平均レートの取得
    $avgRating = $product->reviews->avg('rating');
    if ($avgRating === 0 || $avgRating === null) {
      $product->avgRating = null;
    } else {
      $product->avgRating = round($avgRating, 2);
    }

    // 成功数、成功率の取得
    $allCount = Review::where('product_id', $id)->count();
    $NACount = Review::where('product_id', $id)->where('result', 0)->count();

    if ($allCount === 0 || $NACount === $allCount) {
      $product->successCount = 0;
      $product->successRate = null;
    } else {
      $successCount = Review::where('product_id', $id)->where('result', 1)->count();
      $successRate = $successCount / ($allCount - $NACount);

      $product->successCount = $successCount;
      $product->successRate = round($successRate, 2);
    }

    return Response::json($product, 200);
  }
}
