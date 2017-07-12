<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\UploadManager;
use Illuminate\Support\Facades\File;
use Auth;


class UploadController extends Controller
{
    protected $manager;

    public function __construct(UploadManager $manager){
        $this->manager = $manager;
    }

    public function upload(Request $request){

        //$files = $_FILES;
        $files = $request->file('files');
        //exit;
        $folder = Auth::user()->id . '_tmp';

        $folderReady = $this->manager->createDirectory($folder);

        if($folderReady === false){
            return response()->json(['message' => 'Something went wrong.']);
        }

        // foreach($files as $file){
        //
        // }
        //return response()->json(['message' => 'Wrong']);
        foreach($files as $file){
            //return response()->json(['message' => 'Wrong']);
            //$path = $file->getClientOriginalName();//this is ne original name uploaded file
            $extension = $file->getClientOriginalExtension();
            $path = $folder . '/' . uniqid(rand(10,30), true) . '.' . $extension;
            $tmpPath = $file->getRealPath();
            $content = File::get($tmpPath);

            $result = $this->manager->saveFile($path, $content);
            if($result !==true){

                return response()->json(['message' => $result]);
            }
            // var_dump($path);
            // var_dump($realPath);
        }

        return response()->json(['message' => 'Files has been uploaded']);

    }
}
