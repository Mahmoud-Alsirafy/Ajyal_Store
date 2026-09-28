<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CheckApiToken
{
    public function handle(Request $request, Closure $next)
    {
        $expectedToken = config('app.app_token');
        $providedToken = (string) $request->header('x-api-key', '');

        if (empty($expectedToken) || ! hash_equals($expectedToken, $providedToken)) {
            return Response::json([
                'message' => 'Invalid Api Key',
            ], 401);
        }
        return $next($request);
    }
}