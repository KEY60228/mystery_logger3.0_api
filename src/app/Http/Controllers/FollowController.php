<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Follow;
use App\Models\User;

class FollowController extends Controller
{
    public function follow(Request $request) {
        $follow = Follow::create([
            'following_id' => $request->following_id,
            'followed_id' => $request->followed_id,
        ]);

        return Response::json([], 200);
    }

    public function unfollow(Request $request) {
        $follow = Follow::whereFollowingId($request->following_id)->whereFollowedId($request->followed_id)->first();

        if (!$follow) {
            return Response::json([], 422);
        }

        $follow->delete();
        return Response::json([], 204);
    }
}
