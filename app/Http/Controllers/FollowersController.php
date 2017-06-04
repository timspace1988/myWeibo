<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\User;
use Auth;

class FollowersController extends Controller
{
    public function __construct(){
        $this->middleware('auth', [
            'store', 'destroy'
        ]);
    }

    //action of following a user
    public function store($id){
        $user = User::findOrFail($id);

        if(Auth::user()->id === $user->id){
            return redirect('/');
        }

        if(!Auth::user()->isFollowing($id)){
            Auth::user()->follow($id);
        }

        return redirect()->route('users.show', $id);
    }

    //action of unfollowing a user
    public function destroy($id){
        $user = User::findOrFail($id);

        if(Auth::user()->id === $user->id){
            return redirect('/');
        }

        if(Auth::user()->isFollowing($id)){
            Auth::user()->unfollow($id);
        }

        return redirect()->route('users.show', $id);
    }
}
