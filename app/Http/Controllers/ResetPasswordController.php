<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User; 

class ResetPasswordController extends Controller
{
    public function getPassword($token) 
    { 
        return view('reset', ['token' => $token]);
    }
   
     public function updatePassword(Request $request)
     {
   
     $request->validate([
         'email' => 'required|email|exists:users',
         'password' => 'required|string|min:5|confirmed',
         'password_confirmation' => 'required',
   
     ]);
   
     $updatePassword = DB::table('password_resets')
                         ->where(['email' => $request->email, 'token' => $request->token])
                         ->first();
   
     if(!$updatePassword)
         return back()->withInput()->with('error', 'Invalid token!');
   
       $user = User::where('email', $request->email)
                   ->update(['password' => Hash::make($request->password)]);
   
       DB::table('password_resets')->where(['email'=> $request->email])->delete();
   
       return redirect('/login')->with('success', 'Your password has been changed!');
   
     }
}
