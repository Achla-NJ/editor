<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class Content extends Component
{
    public $content = '';
    
 
    public function updateContent()
    {
        dump(request()->all());
        // $slug = $this->slug();
        // $page = Page::updateOrCreate(['slug' => $slug , 'content'=>$content]); 
    }
  
    public function render()
    {   
        
        return view('livewire.content');
    }

    public function slug()
    {  
        return request('slug');
    }

    
 
}
