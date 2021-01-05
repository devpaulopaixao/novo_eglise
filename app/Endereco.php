<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
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

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

}
