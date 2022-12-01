<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\ReCaptcha;
use Mail;
use Auth;
use Hash;

class MainController extends Controller
{

    function home()
    {
        return view ('home');
    }

    function login()
    {
        return view('login');
    }

    function register()
    {
        return view('register');
    }    
    /*
    function forgotpassword()
    {
        return view('forgotpassword');
    }
    */

    function login_auth(Request $request)
    {
        $this->validate($request, [
        'email'   => 'required|email',
        'password'  => 'required|alphaNum|min:5',
        'g-recaptcha-response' => ['required',new ReCaptcha]
        ]);
        
            $user_data = array(
            'email'  => $request->get('email'),
            'password' => $request->get('password')
            );

            if(Auth::attempt($user_data))
            {
                return redirect('/twofactor');
            }
            else
            {
                return back()->with('error', 'Incorrect details');
            }
        


    }


    // function datacallback(Request $request)
    // {
    //     ('#hrecaptcha').val($request);
    //     ('#hrecaptchaerror').html('');
    // }

    // function expiredcallback()
    // {
    //     ('#hrecaptcha').val('');
    // }

    function logout()
    {
        Auth::logout();
        return redirect('/home');
    }

    function edit_profile()
    {
        $user = auth()->user();
        $data['user']=$user;
        return view('updateinfo',$data);
    }

    function update_profile(Request $request)
    {
         $request->validate([
            'firstname' => 'required|min:2|max:70',
            'lastname' => 'required|min:2|max:70',
         ],[
            'firstname.required' => 'First name is required',
            'lastname.required' => 'Last name is required',
         ]);

         $user =auth()->user();

         $user->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
         ]);

         return redirect('/profile')->with('success','Profile is successfully updated');
    }

    function change_password()
    {
        return view('change_password');
    }

    function update_password(Request $request)
    {
         $request->validate([
            'old_password' => 'required|min:5',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password'
        ],[
            'old_password.required' => 'Current password is required',
            'new_password.required' => 'New Password is required',
            'confirm_password.required' => 'Confirm Password is required'
         ]);

         $current_user = auth()->user();

         if(Hash::check($request->old_password,$current_user->password)){
            $current_user->update([
                'password' => $request->new_password
            ]);
            return redirect('/index')->with('success','Password is successfully updated');

         }else{
            return redirect('/change_password')->with('error','Current password does not match');
         }
    }

    protected function authenticated(Request $request, $user)
    {
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
    }

    // function dissertation_details()
    // {
    //     return view('dissertation');
    // }
    
    function uploadetd()
    {
        return view('upload_etd');
    }
    

}
 