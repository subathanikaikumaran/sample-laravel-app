<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petition extends Model
{
    use HasFactory;


    // to protect from mass assignment vulnerability

    // listed filed can allow mass assignment on
    protected $fillable =['title','description', 'category', 'author_id', 'signees']; 

     // can not be mass assignmenyt
    // protected $guarded;

    function author(){
        return $this->belongsTo(Author::class);
    }
}
