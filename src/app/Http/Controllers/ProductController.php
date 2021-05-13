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
        // $tmp_products = Product::query()
        //     ->whereIn('products.id', Review::query()->select('reviews.product_id'))
        //     ->get();
        // $products_sortby_success_rate = $tmp_products->sortBy('success_rate')->slice(0, 9)->values();
        $sub_tmp_table = Review::query()
            ->selectRaw('reviews.product_id, CASE WHEN (SELECT COUNT(*) FROM reviews r1 WHERE r1.product_id = reviews.product_id) = (SELECT COUNT(*) FROM reviews r1 WHERE r1.result = 2 AND r1.product_id = reviews.product_id) THEN NULL ELSE CAST((SELECT COUNT(*) FROM reviews r1 WHERE r1.result = 1 AND r1.product_id = reviews.product_id) AS NUMERIC) / ((SELECT COUNT(*) FROM reviews r1 WHERE r1.product_id = reviews.product_id) - (SELECT COUNT(*) FROM reviews r1 WHERE r1.result = 2 AND r1.product_id = reviews.product_id)) END AS success_rate')
            ->groupBy('reviews.product_id');
        $products_sortby_success_rate = Product::query()
            ->joinSub($sub_tmp_table, 'sub_tmp_table', function($join) {
                $join->on('products.id', '=', 'sub_tmp_table.product_id');
            })
            ->orderBy('success_rate', 'ASC')
            ->limit(10)
            ->get();

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
                $join->on('venues.id', '=', 'performances.venue_id');
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
        // $tmp_users = User::query()
        //     ->whereIn('users.id', Review::query()->select('reviews.user_id'))
        //     ->get();
        // $users_sortby_success_rate = $tmp_users->sortByDesc('success_rate')->slice(0, 9)->values();
        $sub_tmp_table = Review::query()
            ->selectRaw('reviews.user_id, CASE WHEN (SELECT COUNT(*) FROM reviews r1 WHERE r1.user_id = reviews.user_id) = (SELECT COUNT(*) FROM reviews r1 WHERE r1.result = 2 AND r1.user_id = reviews.user_id) THEN NULL ELSE CAST((SELECT COUNT(*) FROM reviews r1 WHERE r1.result = 1 AND r1.user_id = reviews.user_id) AS NUMERIC) / ((SELECT COUNT(*) FROM reviews r1 WHERE r1.user_id = reviews.user_id) - (SELECT COUNT(*) FROM reviews r1 WHERE r1.result = 2 AND r1.user_id = reviews.user_id)) END AS success_rate')
            ->groupBy('reviews.user_id');
        $users_sortby_success_rate = User::query()
            ->joinSub($sub_tmp_table, 'sub_tmp_table', function($join) {
                $join->on('users.id', '=', 'sub_tmp_table.user_id');
            })
            ->orderBy('success_rate', 'DESC')
            ->limit(10)
            ->get();

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

    /**
     * 検索 & 結果の返却
     * 
     * @param Illuminate\Http\Request
     * @return Illuminate\Support\Facades\Response
     */
    public function search(Request $request) {
        $query = Product::query()->select('products.*')
            ->with(['category', 'performances', 'performances.venue', 'organizer']);

        if ($request->query('keywords', false)) {
            $query = $query->whereRaw("name LIKE '%'||?||'%'", [$request->query('keywords')])
                ->orWhereRaw("kana_name LIKE '%'||?||'%'", [$request->query('keywords')])
                ->orWhereRaw("phrase LIKE '%'||?||'%'", [$request->query('keywords')]);
        }

        if ($request->query('organizer', false)) {
            $query = $query->where('products.organizer_id', $request->query('organizer'));
        }

        if ($request->query('category', false)) {
            $query = $query->where('category_id', $request->query('category'));
        }

        if ($request->query('venue', false)) {
            $query = $query->where('venue_id', $request->query('venue'))
                ->join('performances', 'products.id', '=', 'performances.product_id');
        }

        if ($request->query('pref', false)) {
            $query = $query->where('venues.addr_pref_id', $request->query('pref'))
                ->join('performances', 'products.id', '=', 'performances.product_id')
                ->join('venues', 'performances.venue_id', '=', 'venues.id');
        }

        if ($request->query('ranking', false)) {
            switch ($request->query('ranking')) {
                case 1: // 評価が高い順
                    $result = $query->selectRaw('AVG(reviews.rating) as avg, COUNT(reviews.id) as count')
                        ->leftJoin('reviews', function($join) {
                            $join->on('products.id', '=', 'reviews.product_id');
                            $join->whereNull('reviews.deleted_at');
                        })
                        ->orderByRaw('avg DESC NULLS LAST, count DESC');
                    break;
                case 2: // 投稿数が多い順
                    $result = $query->selectRaw('COUNT(reviews.id) as count, AVG(reviews.rating) as avg')
                        ->leftJoin('reviews', function($join) {
                            $join->on('products.id', '=', 'reviews.product_id');
                            $join->whereNull('reviews.deleted_at');
                        })
                        ->orderByRaw('count DESC NULLS LAST, avg DESC');
                    break;
                case 3: // 成功率が低い順
                    $query->selectRaw(
                        'CASE WHEN SUM(reviews.result) = 0 OR SUM(reviews.result) IS NULL THEN NULL ' .
                        'ELSE (CAST(SUM(CASE WHEN reviews.result = 1 THEN 1 ELSE 0 END) AS float) / SUM(CASE WHEN reviews.result = 0 THEN 0 ELSE 1 END)) ' .
                        'END as rate, COUNT(reviews.id) as count'
                    )
                        ->leftJoin('reviews', function($join) {
                            $join->on('products.id', '=', 'reviews.product_id');
                            $join->whereNull('reviews.deleted_at');
                            $join->where('reviews.result', '!=', '0');
                        })
                        ->orderByRaw('rate ASC NULLS LAST, count DESC');
                    break;
                case 4: // 成功率が高い順
                    $query->selectRaw(
                        'CASE WHEN SUM(reviews.result) = 0 OR SUM(reviews.result) IS NULL THEN NULL ' .
                        'ELSE (CAST(SUM(CASE WHEN reviews.result = 1 THEN 1 ELSE 0 END) AS float) / SUM(CASE WHEN reviews.result = 0 THEN 0 ELSE 1 END)) ' .
                        'END as rate, COUNT(reviews.id) as count'
                    )
                        ->leftJoin('reviews', function($join) {
                            $join->on('products.id', '=', 'reviews.product_id');
                            $join->whereNull('reviews.deleted_at');
                            $join->where('reviews.result', '!=', '0');
                        })
                        ->orderByRaw('rate DESC NULLS LAST, count DESC');
                    break;
                case 5: // 「行きたい」「Like」が多い順
                    $query->selectRaw('COUNT(wannas.id) as count, AVG(reviews.rating) as avg')
                        ->leftJoin('wannas', function($join) {
                            $join->on('products.id', '=', 'wannas.product_id');
                        })
                        ->leftJoin('reviews', function($join) {
                            $join->on('products.id', '=', 'reviews.product_id');
                        })
                        ->orderByRaw('count DESC NULLS LAST, avg DESC');
                    break;
            }
        }

        // For Debug
        // $result = $query->groupBy('products.id')->toSql();
        // return Response::json(['sql' => $result], 200);

        $result = $query->groupBy('products.id')->paginate(10);

        return Response::json($result, 200);
    }
}
