<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    //
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();

        if($user):
        // $data is not empty
            $user = $user->toArray();
        endif;
        
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                $data = array(
                    "errorCode"         => "401",
                    "errorDescription"  => "Invalid Credentials",
                    "data"              => array(
                                            "name"  => $user['name'],
                                            "email" => $user['email'],
                                            "token" => null
                                         )
                );
            
                return response()->json($data, 401);
            }
        } catch (JWTException $e) {
            $data = array(
                "errorCode"         => "500",
                "errorDescription"  => "Could Not Create Token",
                "data"              => array(
                                        "name"  => $user['name'],
                                        "email" => $user['email'],
                                        "token" => $token
                                     )
            );
            return response()->json($data, 500);
        }
 
            $data = array(
                "errorCode"         => "200",
                "errorDescription"  => "Success",
                "data"              => array( 
                                        "name"  => $user['name'],
                                        "email" => $user['email'],
                                        "token" => $token
                                    )
            );
        return response()->json($data,200);
    }
 
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:20',
            'userid' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'required|numeric|min:10',
            'dept_id'   => 'required|numeric|exists:departments,id',
            'gender'   => 'in:M,Y',
            'birthdate'   => 'required|date_format:d-m-Y'
        ]);
 
        if($validator->fails()){
            $data = array(
                "errorCode"         => "400",
                "errorDescription"  => "Fail to Register User",
                "errorMessage"      => $validator->messages()
            );
            return response()->json($data, 400);
        }
 
        $user = User::create([
            'name' => $request->get('name'),
            'userid' => $request->get('userid'),
            'email' => $request->get('email'),
            'phone_number' => $request->get('phone_number'),
            'dept_id' => $request->get('dept_id'),
            'gender' => $request->get('gender'),
            'birthdate' => date('Y-m-d', strtotime($request->get('birthdate'))),
            'password' => Hash::make($request->get('password')),
        ]);
 
        $token = JWTAuth::fromUser($user);

        $data = array(
            "errorCode"         => "200",
            "errorDescription"  => "User Successfully Registered",
            "errorMessage"      => $validator->messages()
        );
 
        return response()->json($data,200);
    }
 
    public function getAuthenticatedUser()
    {
        try {
 
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
 
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
 
            return response()->json(['token_expired'], $e->getStatusCode());
 
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
 
            return response()->json(['token_invalid'], $e->getStatusCode());
 
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
 
            return response()->json(['token_absent'], $e->getStatusCode());
 
        }
 
        return response()->json(compact('user'));
    }
}
