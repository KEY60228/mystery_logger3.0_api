<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Follow;
use App\Models\User;
use App\Http\Requests\FollowRequest;

class FollowController extends Controller
{
    /**
     * フォロー
     * 
     * @param App\Http\Requests\FollowRequest $request
     * @return Illuminate\Support\Facades\Response
     */
    public function follow(FollowRequest $request) {
        $follow = Follow::create([
            'following_id' => $request->user()->id,
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
