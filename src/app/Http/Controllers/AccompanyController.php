<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Accompany;

class AccompanyController extends Controller
{
    /**
     * 同行募集一覧の取得
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Support\Facades\Response
     */
    public function index(Request $request) {
        $accompanies = Accompany::with([
            'user',
            'performance',
            'performance.product',
            'performance.venue',
        ])->get();

        return Response::json($accompanies, 200);
    }
}
