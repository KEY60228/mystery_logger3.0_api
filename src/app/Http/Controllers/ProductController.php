<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
  public function index(Request $request) {
    $products = Product::all();

    return Response::json($products, 200);
  }

  public function show(Request $request, $id) {
    $product = Product::whereId($id)->with(['reviews', 'reviews.user'])->first();

    return Response::json($product, 200);
  }
}
