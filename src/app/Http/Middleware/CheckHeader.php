<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Response;

class CheckHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->header('X_NAZOLOG_TOKEN') !== config('myenv.X_NAZOLOG_TOKEN')) {
            return Response::json([
                'message' => 'unexpected access.'
            ], 422);
        }

        return $next($request);
    }
}
