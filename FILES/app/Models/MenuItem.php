<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'menu_items';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];

    // Define the relationship with Menu model
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
