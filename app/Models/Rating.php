<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'ratings';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
 

    
}
