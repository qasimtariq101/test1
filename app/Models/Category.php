<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations;
     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'categories';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    public $translatable = ['name'];

    public function getURLAttribute()
    {
        return $this->attributes['url'] = route('books.categories.index',[$this->slug]);
        //return $this->attributes['url'] = route('books.index',['category'=>$this->slug]);
    }    

    public function sub_categories()
    {
        return $this->hasMany('App\Models\Category','parent_id','id');
    }

    public function parent()
    {
        return $this->hasOne('App\Models\Category','id','parent_id');
    }      
}
