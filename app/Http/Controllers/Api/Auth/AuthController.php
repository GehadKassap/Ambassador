<?php

namespace App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HttpRequests\RegisterRequest;
use App\Models\User;
use Auth;
// use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    //to save info of user in database
    public function register(RegisterRequest $request){
        $user = User::create($request->only('first_name' , 'last_name' , 'email') + [
           'password' => \Hash::make($request->input('password')),
           'is_admin' => 1
        ]);
         return response($user , 201);//it will return HTTP_CREATED status with info of user
    }
    // to check user to login
    public function login(Request $request){

        $cred = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if($cred){
            $user = Auth::user();
            $jwt =$user->createToken('token')->plainTextToken;
            $cookie = cookie('jwt', $jwt, 60*24); //setting token in cookies
            return response(['message'=>'success',
                            //   'token'=>$jwt
                    ])->withCookie($cookie);
        }else{
           return  response(['errors'=>'Email or password is invalid'], 401);
        }
        //401 ==> HTTP_UNAUTHORIZED
    }
    //to get authenticated user
    public function user(Request $request){
        return $request->user();
    }
    // to logout from system
    public function logout(){
        //remove the cookie of token
        $cookie = \Cookie::forget('jwt');
        // Auth::logout();
        return response(['message'=>'success',
        //   'token'=>$jwt
        ])->withCookie($cookie);
    }
}
