<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'reported_books';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function book()
    {
        return $this->hasOne('App\Models\Book','id','book_id');
    }

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

}
