<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Status;
use Auth;

class StatusesController extends Controller
{
    public function __construct(){
        $this->middleware('auth', [
            'only' => ['store', 'destroy']
        ]);
    }

    //action of posting a status
    public function store(Request $request){
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);

        //$user->statuses()->create() will automatically set new status's user_id as $user->id, while Status->create() will not
        Auth::user()->statuses()->create([
            'content' => $request->content
        ]);

        return redirect()->back();
    }
}
