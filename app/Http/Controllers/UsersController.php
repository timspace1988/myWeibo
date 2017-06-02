<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\User;
use Auth;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware('auth', [
            'only' => ['edit', 'update', 'destroy']
        ]);

        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    //action of lising all users
    public function index(){
        $users = User::paginate(30);
        return view('users.index', compact('users'));
    }

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

    //action of getting profile edit page
    public function edit($id){
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    //action of updating uer profile
    public function update($id, Request $request){
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'confirmed|min:6'
        ]);

        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $data = [];
        $data['name'] = $request->name;
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', 'Profiles have been updated.');

        return redirect()->route('users.show', $id);
    }

    //action of deleting a user
    public function destroy($id){
        $user = User::findOrFail($id);
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', 'Selected user has been deleted.');
        return back();
    }
}
