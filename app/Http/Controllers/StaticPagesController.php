<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Status;
use Auth;

use App\Services\UploadManager;

class StaticPagesController extends Controller
{
    protected $manager;
    public function __construct(UploadManager $manager){
        $this->manager = $manager;
    }

    public function home(){
        $feed_items = [];
        if(Auth::check()){
            $feed_items = Auth::user()->feed()->paginate(30);
        }
        $uploadManager = $this->manager;
        return view('static_pages/home', compact('feed_items', 'uploadManager'));
    }

    public function help(){
        return view('static_pages/help');
    }

    public function about(){
        return view('static_pages/about');
    }
}
