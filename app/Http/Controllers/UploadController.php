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
        $cleanFolder = $request->cleanFolder;
        //exit;
        $folder = Auth::user()->id . '_tmp';

        //check if we need to clean the old files.
        if($cleanFolder !== "cleaned"){
            $result = $this->manager->deleteDirectory($folder, true);
            if($result === false){
                return response()->json(['message' => 'Something went wrong.']);
            }
        }

        $folderReady = $this->manager->createDirectory($folder);



        if($folderReady === false){
            return response()->json(['message' => 'Something went wrong.']);
        }

        // foreach($files as $file){
        //
        // }
        //return response()->json(['message' => 'Wrong']);
        $pathSet = [];
        foreach($files as $file){
            //return response()->json(['message' => 'Wrong']);
            //$path = $file->getClientOriginalName();//this is ne original name uploaded file
            $extension = $file->getClientOriginalExtension();
            $path = $folder . '/' . uniqid('', true) . rand(10,30) . '.' . $extension;
            $tmpPath = $file->getRealPath();
            $content = File::get($tmpPath);

            $result = $this->manager->saveFile($path, $content);
            if($result !==true){

                return response()->json(['message' => $result]);
            }

            //$pathSet[] = rtrim(config('upload.webpath'), '/') . '/' . ltrim($path, '/');
            $pathSet[] = $path;
            $urlSet[] = $this->manager->getWebpath($path);
            // var_dump($realPath);
            $data = ['pathSet' => $pathSet, 'urlSet' => $urlSet];
        }

        return response()->json($data);

    }

    public function remove(Request $request){
        //$path = $request->input('path');
        $path = $request->path;

        $result = $this->manager->deleteFile($path);
        if($result === false){
            return response()->json(['message' => 'Something went wrong']);
        }else{
            return response()->json(['message' => 'deleted']);
        }

        $data = ['message' => $path];
        //
        return response()->json($data);

    }
}
