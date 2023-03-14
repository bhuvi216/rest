<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),
        [
            'name'=>'reqired',
            'email'=>'required|email',
            'password'=>'required',
            'c_password'=>'required|same.password'

        ]);
        if($validator->fails()){
            return response()->json(['message'=>'validator error'],400);
        }
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $response['token']=$user->createToken('myapp');
        $response['name'] = $user->name();
        return response()->json($response, 200);


    }
    public function login(Request $request){
        if (Auth::attempt(['email'=>$request->input('email'),'passowrd'=>$request->input('password')])){
            $user = Auth::user();
            $response['token']=$user->createToken('myapp');
            $response['name'] = $user->name();
            return response()->json($response, 200);


        }else {
            return response()->json(['message'=>'invalid crendencital error'],400);
        }

        }
        public function detail(){
        $user = Auth::user();
        $response['user'] = $user;
        return response()->json($response, 200);
        }
    }

