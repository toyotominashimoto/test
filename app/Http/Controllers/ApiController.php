<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function signup(Request $request)
    {
        $token = $request->user()->createToken($request->input('body.token_name'));
        return response()->json(['token' => $token->plainTextToken]);
    }
    public function signin(REquest $request)
    {
        $user = User::find($request->input('body.id'));
        if ($user==null) {
            return response()->json(['msg' => 'failed signing in']);
        }

    }
}
