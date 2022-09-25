<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function register(Request $request) {

        try {
            // Validate the value...
        } catch (Throwable $e) {
          
     
            $userValidate = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required',
            ]);

            if($userValidate->fails()) {
                return response()->json([
                    "status"=>false, 
                    'message' => 'validation error',
                    'errors' => $userValidate->errors(),
                ], 401); 
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

           return response()->json([
            'status' => true,
            'message' => 'success message',
            'token' => $user->
           ])
            return false;
        }
    }

}
