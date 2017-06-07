<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;



use Auth;

class SessionsController extends Controller
{
    public function __construct(){
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    //action of getting sign in page
    public function create(){
        return view('sessions.create');
    }

    //action of store user login
    public function store(Request $request){
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if(Auth::attempt($credentials, $request->has('remember'))){
            if(Auth::user()->activated){
                session()->flash('success', 'Welcome back!');
                return redirect()->intended(route('users.show', [Auth::user()]));//Auth::user() willl return currently signed in user
            }else{
                Auth::logout();
                session()->flash('Warning', 'Your account has not been activated, we have sent you an activation letter to your email address');
                return redirect('/');
            }

        }else{
            session()->flash('danger', 'Sorry, incorrect email or password');
            return redirect()->back();
        }

        return;
    }

    //action of user logging out
    public function destroy(){
        Auth::logout();
        session()->flash('success', 'You have been successfully signed out');
        return redirect('login');
    }
}
