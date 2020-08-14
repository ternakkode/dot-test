<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Response;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AutentikasiController
{
    public function login(){
        if(session('akses')){
            return redirect('/');
        }

        return view('admin/login');
    }

    public function prosesLogin(Request $request){
        $credentials = $request->only('username', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return Response::json(['status' => false,
                                         'error' => 'invalid_credentials']);
            }
        } catch (JWTException $e) {
            return Response::json(['status' => false,
                                     'error' => 'could_not_create_token']);
        }

        session(['akses' => true]);
        return Response::json(['status' => true,
                               'token' => $token]);
    }

    public function prosesLogout(){
        
    }
}
