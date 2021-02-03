<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ChangePasswordController extends Controller
{
    public function saveResetPassword(ChangePasswordRequest $request)
    {
        return $this->getPasswordResetTableRow($request)->count() > 0 ? $this->changePassword($request) : $this->tokenNotFoundresponse();
    }

    private function getPasswordResetTableRow($request)
    {
        return DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->resetToken]);
    }

    private function changePassword($request)
    {
        $user = User::whereEmail($request->email)->first();

        $user->update(['password' => bcrypt($request->password) ]);

        $this->getPasswordResetTableRow($request)->delete();

        return response()->json([
            'message' => 'Password Successfully Changed'
        ], Response::HTTP_CREATED);
    }

    private function tokenNotFoundresponse()
    {
        return response()->json([
            'error' => 'Email and Token is incorrect'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

}
