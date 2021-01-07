<?php

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => true, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/logout', function () {
    Auth::logout();
    Session::flush();
    return redirect('login');
});

/*Route::get('/', function () {
    return redirect('login');
});*/

Route::get('/', 'SiteController@inicio')->name('inicio');
Route::get('/registre-se', 'SiteController@registrar')->name('registre-se');

Route::post('/registrar', 'RegistrarController@registrar')->name('registrar');


Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/cadastrar-igreja', 'HomeController@cadastrarIgreja')->name('home.cadastrar-igreja');

    Route::get('/perfil', 'ProfileController@index')->name('perfil');
    Route::post('/perfil/atualizar', 'ProfileController@update')->name('perfil.atualizar');
    Route::post('/perfil/novasenha', 'ProfileController@novaSenha')->name('perfil.novasenha');

    Route::resource('perfis','RoleController');

    Route::resource('usuarios','UserController');
    Route::post('usuariosdoperfil','UserController@getUsersByRole')->name('usuarios.com.perfil');

    Route::get('/igreja', 'IgrejaController@igreja')->name('igreja');
    Route::post('/igreja-configurar', 'IgrejaController@configurar')->name('igreja.configurar');

    Route::get('/celulas', 'CelulaController@index')->name('celulas');
    Route::post('/celulas/store', 'CelulaController@store')->name('celulas.store');
    Route::post('/celulas/update', 'CelulaController@update')->name('celulas.update');
    Route::get('/celulas/{id}/destroy', 'CelulaController@destroy')->name('celulas.destroy');
    Route::post('/celulas/fetch_data', 'CelulaController@fetch_data')->name('celulas.fetch');

    Route::get('/igrejas', 'IgrejaController@index')->name('igrejas');
    Route::post('/igrejas/store', 'IgrejaController@store')->name('igrejas.store');
    Route::post('/igrejas/update', 'IgrejaController@update')->name('igrejas.update');
    Route::get('/igrejas/{id}/destroy', 'IgrejaController@destroy')->name('igrejas.destroy');
    Route::post('/igrejas/fetch_data', 'IgrejaController@fetch_data')->name('igrejas.fetch');

    Route::get('/membros/conectar/{igreja_id}', 'MembrosController@conectar')->name('membros.conectar');
    Route::get('/membros/desconectar/{igreja_id}', 'MembrosController@desconectar')->name('membros.desconectar');

});
