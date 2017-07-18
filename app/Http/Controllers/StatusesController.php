<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Status;
use Auth;

use App\Services\UploadManager;

class StatusesController extends Controller
{
    protected $manager;
    public function __construct(UploadManager $manager){
        $this->manager = $manager;
        $this->middleware('auth', [
            'only' => ['store', 'destroy']
        ]);
    }

    //action of posting a status
    public function store(Request $request){
        var_dump("3");
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);
        var_dump("2");
        //$user->statuses()->create() will automatically set new status's user_id as $user->id, while Status->create() will not
        $newStatus = Auth::user()->statuses()->create([
            'content' => $request->content
        ]);
        var_dump("1");


        if($request->haveImage === "yes"){
            var_dump("0");
            exit();
            $result = $this->manager->moveDirectory(Auth::user()->id.'_tmp', $newStatus->id);
            var_dump("-1";
            var_dump($result);
            exit();
            if($result === true){
                session()->flash('success', 'Your status has been posted.');
            }else{
                session()->flash('info', 'Your status has been posted, but an error occurs during posting your images.');
            }
        }



        return redirect()->back();
    }

    //action of deleting a status
    public function destroy($id)
    {
        $status = Status::findOrFail($id);
        $this->authorize('destroy', $status);
        $status->delete();
        //if the given status has images, delete the folder and images
        $result = $this->manager->deleteDirectory($id, true);
        // if($result === false){
        //     session()->flash('info', 'Status has been deleted but failed to delete the images');
        // }
        session()->flash('success', 'Status has been deleted.');
        return redirect()->back();
    }
}
