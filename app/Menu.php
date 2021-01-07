<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    public function igreja()
    {
        return $this->belongsTo('App\Igreja', 'igreja_id', 'id');
    }

    public function submenus(){
        return $this->hasMany('App\Menu', 'menu_id', 'id');
    }
}
