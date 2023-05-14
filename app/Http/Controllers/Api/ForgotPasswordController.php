<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\forgotPassword as MailForgotPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon; 
use App\Models\User; 
use App\Models\ForgotPassword;
use App\Mail\forgotPasswordMail;
use Mail; 
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function submitForgetPasswordForm(Request $request)
    {
        try {
            DB::beginTransaction();
                $validateUser = Validator::make($request->all(), 
                [
                    'email' => 'required|email|exists:users,email'
                ]);

                if($validateUser->fails()){
                    return response()->json([
                        'status' => false,
                        'message' => 'validation error',
                        'errors' => $validateUser->errors()
                    ], 401);
                }
                $token = Str::random(64);
                ForgotPassword::create([
                    'email' => $request->email, 
                    'token' => $token, 
                    'created_at' => Carbon::now()
                ]);

                Mail::to('dibuattest@gmail.com')->send(new forgotPasswordMail($token));
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Email Send Successfully',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function submitResetPasswordForm(Request $request)
    {
        try {
            DB::beginTransaction();
                $validateUser = Validator::make($request->all(), 
                [
                    'email' => 'required|email|exists:users,email',
                    'password' => 'required|confirmed|min:8',
                    'token' => 'required'
                ]);

                if($validateUser->fails()){
                    return response()->json([
                        'status' => false,
                        'message' => 'validation error',
                        'errors' => $validateUser->errors()
                    ], 401);
                }

                $updatePassword = ForgotPassword::where([
                        'email' => $request->email, 
                        'token' => $request->token
                    ])->first();

                if(!$updatePassword){
                    return response()->json([
                        'status' => false,
                        'message' => 'invalid token'
                    ], 401);
                }

                User::where('email', $request->email)
                            ->update(['password' =>  Hash::make($request->password)]);

                DB::table('password_resets')->where(['email'=> $request->email])->delete();
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Your password has been changed!',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
