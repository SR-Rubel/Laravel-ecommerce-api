<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'email|required|unique:users',
            'password'=>'required|confirmed',
            'phone_no'=>'required'
            
        ]);
        
        $user=new User();

        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->phone_no=$request->phone_no;
        $user->save();

        $token=$user->createToken('auth_token')->accessToken;

        return response()->json(["status"=>1,"msg"=>'registered!',"token"=>$token],200);
    }

    public function login(Request $request)
    {

        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        $crediantials=$request->only(['email','password']);

        if(!auth()->attempt($crediantials)){
            return response()->json(['status'=>0,'msg'=>'invalid credintials'],401);
        }

        $token=auth()->user()->createToken('auth_token')->accessToken;

        return response()->json(['status'=>1,'msg'=>'logged in!!',"token"=>$token],200);

        // return $crediantials;
        
    }

    public function profile(){
        $user=auth()->user();

        return response()->json(['status'=>1,'msg'=>auth()->user()],200);
    }
    public function logout(){
        // if (Auth::check()) {
        //     Auth::user()->AauthAcessToken()->delete();
        //  }
        $user = Auth::user()->token();
        $user->revoke();
        return response()->json(['status'=>1,'msg'=>'logged out!!'],200);
    }
}
