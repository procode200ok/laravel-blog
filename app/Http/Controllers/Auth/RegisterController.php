<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Exception;


class RegisterController extends Controller
{
    public function register(Request $request)
    {
        //dd($request);
        /**
         * resgister blog 
         * user
         */
        try {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'phone_number' => ['required']
            ]);

            $validatedData['password'] = Hash::make($validatedData['password']);


            $user = User::create($validatedData);

        

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['token' => $token], 201);
        }catch (Exception $e) {
            return response()->json(['error' => [$e->getMessage()]], $e->status);
        }
    }
}
