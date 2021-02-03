<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordEmail;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetPasswordController extends Controller
{
    public function forgetPassword(Request $request)
    {
        if (!$this->validateEmail($request->email))
        {
            return $this->faildResponse();
        }

        $this->send($request->email);

        return $this->successResponse();
    }

    public function send($email)
    {
        $token = $this->createToken($email);

        Mail::to($email)->queue(new ResetPasswordEmail($token));
    }

    public function createToken($email)
    {
        $oldToken = DB::table('password_resets')->where('email',$email)->first();

        if ($oldToken)
        {
            return $oldToken;
        }

        $token = Str::random(60);

        $this->saveToken($email, $token);

        return $token;
    }

    public function saveToken($token, $email)
    {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }

    public function validateEmail($email)
    {
        return !!User::where('email', $email)->first();
    }

    public function faildResponse()
    {
        return response()->json([
            'error' => 'Email Does\\t Found On Our Record'
        ], Response::HTTP_NOT_FOUND);
    }

    public function successResponse()
    {
        return \response()->json([
            'message' => 'Reset Password Email Sent Successfully, please Check Your Inbox'
        ], Response::HTTP_OK);
    }
}
