<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\VerificationCode;
use App\Mail\otpMail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;
use Auth;
use Mail;

class AuthController extends Controller
{
    public function createUser(Request $request)
    {
        try {
            //Validated
            
            DB::beginTransaction();
            $validateUser = Validator::make($request->all(), 
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:8',
                'term' => 'accepted'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 2,
                'email_verified_at' => null
            ]);

            $otp = rand(123456, 999999);

            VerificationCode::create([
                'user_id' => $user->id,
                'otp' => $otp,
                'expire_at' => Carbon::now()->addMinutes(10)
            ]);

            $details = ['otp' => $otp];

            Mail::to($request->email)->send(new otpMail($details));

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'data' => [
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email
                    ],
                    'token' => $user->createToken("API TOKEN")->plainTextToken
                ]
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        #Validation
        $request->validate([
            'otp' => 'required'
        ]);

        #Validation Logic
        $verificationCode  = VerificationCode::where('user_id', Auth::user()->id)->where('otp', $request->otp)->first();

        $now = Carbon::now();
        if (!$verificationCode) {
            return response()->json([
                'status' => false,
                'message' => 'Your OTP is not correct',
            ], 401);
        }elseif($verificationCode && $now->isAfter($verificationCode->expire_at)){
            return response()->json([
                'status' => false,
                'message' => 'Your OTP has expired',
            ], 401);
        }

        $user = User::whereId(Auth::user()->id)->first();

        if($user){
            // Expire The OTP
            $verificationCode->delete();
            
            $user->email_verified_at = $now;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'data' => [
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email
                    ],
                    'token' => $user->createToken("API TOKEN")->plainTextToken
                ]
            ], 200);
        }
 
        return response()->json([
            'status' => false,
            'message' => 'Your OTP is not correct',
        ], 401);
    }

    public function generateOtp() {
        try {
            
            DB::beginTransaction();

            $otp = rand(123456, 999999);
            $verificationCode  = VerificationCode::where('user_id', Auth::user()->id)->first();

            if (!$verificationCode) {
                return response()->json([
                    'status' => false,
                    'message' => 'You already verified',
                ], 401);
            }
            
            $verificationCode->otp = $otp;
            $verificationCode->expire_at = Carbon::now()->addMinutes(10);
            $verificationCode->save();

            $details = ['otp' => $otp];

            Mail::to('satrahmadi@gmail.com')->send(new otpMail($details));

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'OTP send Successfully',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logoutUser(Request $request) {
        try {
            auth()->user()->tokens()->delete();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $response = Auth::guard('web')->logout();
            return response()->json([
                'status' => true,
                'message' => $response
            ], 200);
        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function updateUser(Request $request)
    {
        try {
            //Validated
            
            DB::beginTransaction();
            $validateUser = Validator::make($request->all(), 
            [
                'name' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::firstWhere('email',Auth::user()->email)->update([
                'name' => $request->name
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => $user,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            DB::beginTransaction();
                $validateUser = Validator::make($request->all(), 
                [
                    'old_password' => ['required',
                        function ($attribute, $value, $fail) {
                            if (!Hash::check($value, Auth::user()->password)) {
                                $fail('Old Password didn\'t match');
                            }
                        }
                    ],
                    'password' => [
                        'required',
                        Password::min(8)
                            ->letters()
                            ->mixedCase()
                            ->numbers()
                            // ->uncompromised()
                    ],
                    'password_confirmation' => 'required|same:password'
                ]);

                if($validateUser->fails()){
                    return response()->json([
                        'status' => false,
                        'message' => 'validation error',
                        'errors' => $validateUser->errors()
                    ], 401);
                }

                $user = User::find(Auth::user()->id);
                $user->password = Hash::make($request->password);
                $user->save();
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

    public function handleProviderCallback(Request $request)
    {
        try {
            $s_user = Socialite::with($request->provider)->stateless()->userFromToken($request->access_token);
            $user = $this->findOrCreateUser($s_user, $request->provider);
            if($request->login) $user->createToken("API TOKEN")->plainTextToken;
            return response()->json([
                'status' => true,
                'message' => $user
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    private function findOrCreateUser($socialLiteUser, $provider)
    {
        $user = User::firstOrNew([
            'email' => $socialLiteUser->email,
        ], [
            'email' => $socialLiteUser->email,
            $provider.'_id' => $socialLiteUser->id,
            'role_id' => 2,
            'name' => $socialLiteUser->name,
            'password' => Hash::make('default_password')
        ]);

        return $user;
    }

}
