<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug', 
        'content',
        'password',
    ]; 


    public function files(){
        return $this->hasMany(File::class);
    }
}
 