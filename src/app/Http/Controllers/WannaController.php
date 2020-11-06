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
}
