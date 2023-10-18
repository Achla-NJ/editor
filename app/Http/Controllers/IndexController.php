<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    public function index($slug = null)
    {
        if ($slug === null) { 
            $slug =  \Str::random(20);  
            return redirect()->route('index', ['slug' => $slug]);
        }
        $page = Page::updateOrCreate(['slug' => $slug]); 
        $page =Page::query()->where('slug',$slug)->firstOrFail() ?? [];
        
        if(session()->has('login')){
            return view('pages.index', compact('slug','page')); 
        }
        if(!empty($page->password)){
            return redirect()->route('login' , $page->slug);
        }        
        return view('pages.index', compact('slug','page'));
    }

    public function login($slug)
    {
        return view('pages.login', compact('slug'));                        
    }

    public function signin(Request $request)
    { 
        $hashedPassword = Hash::make($request->password);
        if(Hash::check($request->password, $hashedPassword)){ 
            Page::query()->where(['slug'=>$request->slug])->first();
            session()->put('login' , 'yes');       
            return redirect()->route('index' , $request->slug); 
        }
        return redirect()->route('login' , $request->slug); 
    }

    public function updateContent(Request $request)
    {  
        Page::updateOrCreate(['slug' => $request->slug] ,[ 'content'=>$request->content]);  
    }

    public function updateUrl(Request $request)
    {  
        $this->validate($request, [
            'url' => 'required|min:4',
        ]); 

        $page = Page::query()->where('slug' , $request->slug)->first();  
        $page->update(['slug' => $request->url] );  
        return redirect()->route('index', ['slug' => $request->url]);
    }

    public function addPassword(Request $request)
    {  
        $this->validate($request, [
            'password' => 'required|min:4',
        ]);

        $hashedPassword = Hash::make($request->password);

        Page::updateOrCreate(['slug' => $request->slug] ,[ 'password'=>$hashedPassword]); 
        session()->put('login' , 'yes');       
        return response()->json(["success" => true, "status" => 200 ]);
    }

    public function removePassword(Request $request){
        Page::updateOrCreate(['slug' => $request->slug] ,[ 'password'=>'']); 
        return response()->json(["success" => true, "status" => 200 ]);
    }

   
}


    
