<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class TokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, User $user)
    {
        $auth_token = $request->header('X-Auth-Token', null);

        if ($auth_token) {
            $token = $user->tokens->contains(function ($value, $key) {
                return $value == $auth_token;
            });
            if (!$token) {
                return response()->json(['msg' => 'provided token is invalid']);
            }

        } else {
            return response()->json(['msg' => 'no token provided']);
        }

        return $next($request);
    }
}
