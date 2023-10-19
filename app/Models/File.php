<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'file', 
        'page_id', 
        'mime'
    ]; 

    public function page(){
        return $this->belongsTo(Page::class);
    }
}
 