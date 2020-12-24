<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogOutController extends Controller
{
    public function __invoke()
    {
        auth()->logout();
        return response()->json([
            'message' => 'User Logout Successfully',
            'status_code' => 200
        ],Response::HTTP_OK);
    }
}
