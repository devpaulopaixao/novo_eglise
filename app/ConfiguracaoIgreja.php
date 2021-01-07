<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfiguracaoIgreja extends Model
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
}
