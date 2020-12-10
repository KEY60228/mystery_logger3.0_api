<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Wanna;
use App\Http\Requests\WannaRequest;
use App\Http\Requests\UnwannaRequest;

class WannaController extends Controller
{
    /**
     * 「行きたい」登録
     * 
     * @param App\Http\Requests\WannaRequest
     * @return Illuminate\Support\Facades\Response
     */
    public function wanna(WannaRequest $request) {
        $wanna = Wanna::create([
            'user_id' => $request->user()->id,
            'product_id' => $request->product_id,
        ]);

        return Response::json([], 200);
    }

    /**
     * 「行きたい」登録解除
     * 
     * @param App\Http\Requests\UnwannaRequest
     * @return Illuminate\Support\Facades\Response
     */
    public function unwanna(UnwannaRequest $request) {
        $wanna = Wanna::whereUserId($request->user()->id)->whereProductId($request->product_id)->first();

        if (!$wanna) {
            return Response::json([
                'errors' => [
                    'product_id' => [
                        '指定されたproduct idは存在しません。'
                    ],
                ],
                'message' => 'The given data was invalid.'
            ], 422);
        }

        $wanna->delete();
        return Response::json([], 204);
    }
}
