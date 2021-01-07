<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Igreja extends Model
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

    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function endereco()
    {
        return $this->hasOne('App\Endereco','igreja_id', 'id');
    }

    public function membros(){
        return $this->hasMany('App\Membros', 'igreja_id', 'id');
    }

    public function celulas(){
        return $this->hasMany('App\Celula', 'igreja_id', 'id');
    }

    public function configuracao()
    {
        return $this->hasOne('App\ConfiguracaoIgreja','igreja_id', 'id');
    }

    public function menus()
    {
        return $this->hasMany('App\Menu','igreja_id', 'id');
    }
}
