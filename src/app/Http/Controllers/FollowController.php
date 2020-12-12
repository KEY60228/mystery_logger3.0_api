<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Follow;
use App\Models\User;
use App\Http\Requests\FollowRequest;
use App\Http\Requests\UnfollowRequest;

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

    /**
     * フォロー解除
     * 
     * @param App\Http\Requests\UnfollowRequest $request
     * @return Illuminate\Support\Facades\Response
     */
    public function unfollow(UnfollowRequest $request) {
        $follow = Follow::whereFollowingId($request->user()->id)->whereFollowedId($request->followed_id)->first();

        if (!$follow) {
            return Response::json([
                'errors' => [
                    'followed_id' => [
                        '指定されたfollowed idは存在しません。',
                    ],
                ],
                'message' => 'The given data was invalid.',
            ], 422);
        }

        $follow->delete();
        return Response::json([], 204);
    }
}
