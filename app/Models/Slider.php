<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'slider';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];


}


