<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\User;

class UserController extends Controller
{
  public function show(Request $request, $id) {
    $user = User::whereAccountId($id)->first();

    if (is_null($user)) {
      // エラーハンドリング
      return Response::json([], 422);
    }

    return Response::json($user, 200);
  }
}
