<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Response;
use App\Models\Review;

class ProductController extends Controller
{
  public function index(Request $request) {
    $products = Product::all();

    return Response::json($products, 200);
  }

  public function show(Request $request, $id) {
    $product = Product::whereId($id)->with(['reviews', 'reviews.user'])->withCount('reviews')->first();

    $avgRating = $product->reviews()->avg('rating');
    if ($avgRating === 0) {
      $product->avgRating = '-';
    } else {
      $product->avgRating = $avgRating;
    }

    $allCount = Review::where('product_id', $id)->count();
    if ($allCount === 0) {
      $product->reviewCount = 0;
      $product->successCount = 0;
      $product->successRate = '-';
    } else {
      $successCount = Review::where('product_id', $id)->where('result', 1)->count();
      $NACount = Review::where('product_id', $id)->where('result', 0)->count();
      $successRate = $successCount / ($allCount - $NACount);

      $product->reviewCount = $allCount;
      $product->successCount = $successCount;
      $product->successRate = $successRate;
    }
    

    return Response::json($product, 200);
  }
}
