<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Auth;

class UsersController extends Controller
{

    public function roles() 
    {
        try {
            $roles = Role::get();
            return response()->json([
                'status' => true,
                'message' => $roles
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function list ()
    {
        try {
            $users = User::get();
            return response()->json([
                'status' => true,
                'message' => $users
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function create (Request $request)
    {
        try {
            //Validated
            
            DB::beginTransaction();
            $validateUser = Validator::make($request->all(), 
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'numeric',
                'role' => 'required'
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
                'password' => Hash::make('password'),
                'role_id' => $request->role,
                'email_verified_at' => Carbon::now(),
                'status' => $request->status
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
}
