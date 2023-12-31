<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\File;
use Illuminate\Support\Facades\Hash;
use Str;
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

        Page::updateOrCreate(['slug' => $request->slug] ,['password'=>$hashedPassword]); 
        session()->put('login' , 'yes');       
        return response()->json(["success" => true, "status" => 200 ]);
    }

    public function removePassword(Request $request){
        Page::updateOrCreate(['slug' => $request->slug] ,[ 'password'=>'']); 
        return response()->json(["success" => true, "status" => 200 ]);
    }
    
    public  function FileUpload(Request $request)
    {
        if($request->hasFile('file')){
            foreach ($request->file('file') as $key => $file) {
            
                $fname = $file->store( 'uploads', 'public');
                $mime = $file->getClientMimeType();
                File::create([
                    'file' => $fname , 
                    'page_id' => $request->page_id,
                    'mime' => $mime
                ]);

                $page = Page::find($request->page_id);
            }

            $data = view('components.media' , compact('page'))->render();

            return response()->json(['success'=>true , 'data' => $data]);
        }
    }

    public  function removeFile(Request $request)
    {
        $file = File::find($request->id);
        $page = Page::find($file->page_id);
        $file = $file->delete(); 
        return view('components.media' , compact('page'));
    }

    public  function logout(Request $request)
    {
        session()->forget('login');       
        return redirect()->route('index', $request->slug);
    }

    public function shareUrl(Request $request)
    {  
        $this->validate($request, [
            'mobile_no' => 'required|numeric',
        ]);
        
        return response()->json(["success" => true, "status" => 200 ]);
    }
}


    
