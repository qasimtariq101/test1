<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];

    // Define the relationship with MenuItem model
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }
}
