<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Page;



class IndexController extends Controller
{
    public function index($slug = '')
    {
        $page =Page::query()->where('slug',$slug)->first();
        if($page){
            return view('pages.index' ,compact('page' , 'slug'));
        }
        else{
            $slug = \Str::random(30);
            return redirect()->route('index',$slug);
            // return view('pages.index' ,compact('page' , 'slug'));
        }
    }   
}
