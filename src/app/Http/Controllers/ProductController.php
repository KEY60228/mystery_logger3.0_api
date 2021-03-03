<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Response;
use App\Models\Review;
use App\Models\User;

use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * トップページ用API
     * 
     * @param Illuminate\Http\Request
     * @return Illuminate\Support\Facades\Response
     */
    public function index(Request $request) {
        // 評価の高い作品10本
        $products_sortby_ratings = Product::query()
            ->selectRaw('products.*, AVG(reviews.rating) as avg')
            ->join('reviews', function ($join) {
                $join->on('products.id', '=', 'reviews.product_id');
                $join->whereNull('reviews.deleted_at');
            })
            ->groupBy('products.id')
            ->havingRaw('AVG(reviews.rating) > 0')
            ->orderBy('avg', 'desc')
            ->limit(10)
            ->get();

        // 投稿数の多い作品10本
        $products_sortby_reviews_count = Product::query()
            ->selectRaw('products.*, COUNT(reviews.*) as count')
            ->join('reviews', function ($join) {
                $join->on('products.id', '=', 'reviews.product_id');
                $join->whereNull('reviews.deleted_at');
            })
            ->groupBy('products.id')
            ->havingRaw('COUNT(reviews.*) > 0')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        // 成功率の低い作品10本
        $tmp_products = Product::query()
            ->whereIn('products.id', Review::query()->select('reviews.product_id'))
            ->get();
        $products_sortby_success_rate = $tmp_products->sortBy('success_rate')->slice(0, 9)->values();

        // ToDo: テストDBをpostgresqlに (DISTINCT ONはpostgresの方言だからSQLiteテストは通らない)

        // 主催団体別に1本抽出
        $products_categorizeby_organizer = Product::query()
            ->selectRaw('DISTINCT ON (products.organizer_id) products.*, organizers.service_name AS organizer_name')
            ->join('organizers', 'organizers.id', '=', 'products.organizer_id')
            ->get();

        // 都道府県別に1本抽出
        $products_categorizeby_venue = Product::query()
            ->selectRaw('DISTINCT ON (venues.addr_pref_id) products.*, venues.addr_prefecture, venues.addr_pref_id')
            ->join('performances', 'products.id', '=', 'performances.product_id')
            ->join('venues', function($join) {
                $join->on('venues.id', '=', 'performances.product_id');
                $join->whereNotNull('venues.addr_pref_id');
            })
            ->orderBy('venues.addr_pref_id', 'ASC')
            ->get();

        // カテゴリー別に1本抽出
        $products_categorizeby_category = Product::query()
            ->selectRaw('DISTINCT ON (categories.id) products.*, categories.name AS category_name')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->get();

        // 参加数の多いユーザーTOP10
        $users_sortby_reviews_count = User::query()
            ->selectRaw('users.*, COUNT(reviews.*) AS count')
            ->join('reviews', function ($join) {
                $join->on('users.id', '=', 'reviews.user_id');
                $join->whereNull('reviews.deleted_at');
            })
            ->groupBy('users.id')
            ->havingRaw('COUNT(reviews.*) > 0')
            ->orderBy('count', 'DESC')
            ->limit(10)
            ->get();

        // 脱出率の高いユーザーTOP10
        $tmp_users = User::query()
            ->whereIn('users.id', Review::query()->select('reviews.user_id'))
            ->get();
        $users_sortby_success_rate = $tmp_users->sortByDesc('success_rate')->slice(0, 9)->values();

        $response = [
            'products_sortby_ratings' => $products_sortby_ratings->all(),
            'products_sortby_reviews_count' => $products_sortby_reviews_count->all(),
            'products_sortby_success_rate' => $products_sortby_success_rate->all(),
            'products_categorizeby_organizer' => $products_categorizeby_organizer->all(),
            'products_categorizeby_venue' => $products_categorizeby_venue->all(),
            'products_categorizeby_category' => $products_categorizeby_category->all(),
            'users_sortby_reviews_count' => $users_sortby_reviews_count->all(),
            'users_sortby_success_rate' => $users_sortby_success_rate->all(),
        ];

        return Response::json($response, 200);
    }

    /**
     * 作品詳細
     * 
     * @param Illuminate\Http\Request
     * @param string $id
     * @return Illuminate\Support\Facades\Response
     */
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
