<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Response;
use App\Models\Review;

class ProductController extends Controller
{
    public function index(Request $request) {
        $products = Product::with([
            'category',
            'performances',
            'performances.venue',
            'organizer'
        ])->get();
        return Response::json($products, 200);
    }

    public function show(Request $request, $id) {
        $product = Product::whereId($id)->with([
            'reviews',
            'reviews.user',
            'category',
            'performances',
            'performances.venue',
            'organizer'
        ])->first();

        if (!$product) {
            return Response::json([
                'errors' => [
                    'product_id' => '指定されたIDの作品はありません。'
                ],
                'message' => 'The given data was invalid.',
            ], 404);
        }

        return Response::json($product, 200);
    }
}
