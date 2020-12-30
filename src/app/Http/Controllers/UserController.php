<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

    /**
     * ユーザー情報のアップデート
     * 
     * @param App\Http\Requests\UpdateUserRequest $request
     * @return Illuminate\Support\Facades\Response
     */
    public function update(UpdateUserRequest $request) {
        $user = Auth::user();

        // ファイルの拡張子取得
        if ($request->image_name) {
            $extension = $request->image_name->extension();
            
            // ランダムな英数字+拡張子でファイル名決定
            $chars = array_merge(
                range(0, 9), range('a', 'z'), range('A', 'Z'), ['-', '_']
            );
            $filename = '';
            for ($i = 0; $i < 12; $i++) {
                $filename .= $chars[array_rand($chars)];
            }
            $filename .= '.' . $extension;
            
            // ファイル保存
            Storage::disk('public')->putFileAs('/user_img', $request->image_name, $filename);
    
            // DBエラー時にファイル削除するためトランザクション開始
            DB::beginTransaction();
            try {
                // 成功時のためにファイル名取っておく
                $ex_filename = $user->image_name;

                $user->update([
                    'name' => $request->name,
                    'account_id' => $request->account_id,
                    'profile' => $request->profile,
                    'image_name' => '/storage/user_img/' . $filename,
                ]);
                DB::commit();

                // 成功時元ファイル削除
                if ($ex_filename !== '/storage/user_img/default.jpeg') {
                    Storage::disk('public')->delete(substr($ex_filename, 9));
                }
            } catch (\Exception $e) {
                DB::rollback();
                // 失敗時ファイル削除
                Storage::delete($filename);
                throw $e;
            }
        } else {
            $user->update([
                'name' => $request->name,
                'account_id' => $request->account_id,
                'profile' => $request->profile,
            ]);
        }

        return Response::json([], 200);
    }
}
