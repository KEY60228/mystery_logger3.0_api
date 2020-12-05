<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Accompany;

class AccompanyController extends Controller
{
    public function index(Request $request) {
        $accompanies = Accompany::with([
            'user',
            'performance',
        ])->get();
        return Response::json($accompanies, 200);
    }
}
