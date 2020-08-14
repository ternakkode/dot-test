<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Auth;
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
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['status' => false]);
        }

        session(['akses' => true, 'token' => $token]);
        return Response::json(['status' => true,
                               'token' => $token]);
    }

    public function prosesLogout(){
        session()->forget('akses');
        auth()->logout();
        return redirect('login');
    }
}
