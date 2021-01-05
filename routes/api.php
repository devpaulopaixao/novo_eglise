<?php

use Illuminate\Http\Request;

Route::resource('authenticate', 'Api\AuthenticateController', ['only' => ['index']]);
Route::post('authenticate', 'Api\AuthenticateController@authenticate');
