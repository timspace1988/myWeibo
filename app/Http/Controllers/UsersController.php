<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\User;
use Auth;
use Mail;

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

        //send confirmation email
        $this->sendEmailConfirmationTo($user);

        session()->flash('success', 'We have sent you a confirmation letter, please check your email inbox');
        return redirect('/');

        //return redirect()->route('users.show', [$user]);//in laravel, route() will automatically get $user->id,
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

    //action of sending confirmation letter
    public function sendEmailConfirmationTo($user){
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'aufree@estgroupe.com';
        $name = 'Aufree';
        $to = $user->email;
        $subject = "Thank you for your register, please confirm your email";

        Mail::send($view, $data, function($message) use ($from, $name, $to, $subject){
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }

    //action of user confirms email addres(activation)
    public function confirmEmail($token){
        $user = User::where('activation_token', $token)->where('activation_token', '<>', '')->firstOrFail();

        $user->activated = true;
        $user->activation_token = "";
        $user->save();

        Auth::login($user);
        session()->flash('success', 'Congratulations, your account has been activated.');
        return redirect()->route('users.show', compact('user'));
    }
}
