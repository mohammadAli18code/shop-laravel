<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    protected $fillable = ['name' , 'english_name' , 'parent_id' , 'slug'];
    
    public function products(){
        return $this->hasMany('App\Models\Product');
    }

    public function children(){
        return $this->hasMany('App\Models\Category' , 'parent_id');
    }

    public function parent(){
        return $this->belongsTo('App\Models\Category' , 'parent_id');
    }

    public function scopeAllParents($query){

        return $query->whereNull('parent_id');
    }

    public function ScopeAllChildren($query){
        return $query->whereNotNull('parent_id');
    }
}
