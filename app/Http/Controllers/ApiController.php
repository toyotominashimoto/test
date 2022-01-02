<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function signup(Request $request)
    {
        $token = $request->user()->createToken($request->input('body.token_name'));
        return response()->json(['token' => $token->plainTextToken]);
    }
    public function signin()
    {
        return response()->json(['msg' => 'failed signing in']);
    }
}
