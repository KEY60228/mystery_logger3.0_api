<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Wanna;

class WannaController extends Controller
{
    public function wanna(Request $request) {
        $wanna = Wanna::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
        ]);

        return Response::json([], 200);
    }

    public function unwanna(Request $request) {
        $wanna = Wanna::whereUserId($request->user_id)->whereProductId($request->product_id)->first();

        if (!$wanna) {
            return Response::json([], 422);
        }

        $wanna->delete();
        return Response::json([], 204);
    }
}
