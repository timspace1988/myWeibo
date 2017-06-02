<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\User;
use Auth;

class UsersController extends Controller
{
    //action of user sign up
    public function create(){
        return view('users.create');
    }

    //action of showing user's personal page
    public function show($id){
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));//compact('user') will return ['user' => $user]
    }

    //action of processing user sign up request(post)
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        //let user signed in after registration
        Auth::login($user);

        session()->flash('success', 'Welcome, your new journey starts here.');

        return redirect()->route('users.show', [$user]);//in laravel, route() will automatically get $user->id,
        //above equals to return redirect()->route('users.show', [$user->id]);
    }
}
