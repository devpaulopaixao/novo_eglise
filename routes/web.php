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

Route::get('/hsy/schedule-run', function () {
    $dir = env('APP_ENV') == 'local' ? '/home/hotsystems/Documentos/novo_eglise' : '/home/financeiramentepleno/www/projeto';
    $command = "cd {$dir} && php artisan schedule:run > {$dir}/storage/logs/schedule-run.log";
    $returnVar = null;
    $output = null;
    exec($command, $output, $returnVar);
    if(!$returnVar){
        dd('Schedule works!');
    }else{
        dd('Schedule failed');
    }
});

Route::get('/hsy/queue-work', function () {
    $dir = env('APP_ENV') == 'local' ? '/home/hotsystems/Documentos/novo_eglise' : '/home/financeiramentepleno/www/projeto';
    $command = "cd {$dir} && nohup php artisan queue:work --once > {$dir}/storage/logs/queue-work.log";
    $returnVar = null;
    $output = null;
    exec($command, $output, $returnVar);
    if(!$returnVar){
        dd('Queue works!');
    }else{
        dd('Queue failed');
    }
});

Route::get('/registre-se', 'PlataformaController@registrar')->name('registre-se');
Route::post('/registrar', 'RegistrarController@registrar')->name('registrar');

/*Route::get('/', function () {
return redirect('login');
});*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', 'PlataformaController@inicio')->name('inicio');

    Route::get('/{url}', 'SiteController@inicio')->name('index');

});

Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'admin'], function () {
        Route::resource('perfis', 'RoleController');
        Route::resource('usuarios', 'UserController');
    });

    Route::group(['prefix' => 'usuario'], function () {

        Route::get('/home', 'HomeController@index')->name('home');

        Route::get('/novo-produto', 'HomeController@new')->name('new.product');
        Route::get('/nova-igreja', 'HomeController@newChurch')->name('new.church');
        Route::get('/ser-membro', 'HomeController@beMember')->name('be.member');

        Route::get('/perfil', 'ProfileController@index')->name('perfil');
        Route::post('/perfil/atualizar', 'ProfileController@update')->name('perfil.atualizar');
        Route::post('/perfil/novasenha', 'ProfileController@novaSenha')->name('perfil.novasenha');

        Route::get('/igreja', 'IgrejaController@igreja')->name('igreja');
        Route::post('/igreja-configurar', 'IgrejaController@configurar')->name('igreja.configurar');

        Route::post('/cadastrar-igreja', 'HomeController@cadastrarIgreja')->name('home.cadastrar-igreja');

        Route::get('/igrejas', 'IgrejaController@index')->name('igrejas');
        Route::post('/igrejas/store', 'IgrejaController@store')->name('igrejas.store');
        Route::post('/igrejas/update', 'IgrejaController@update')->name('igrejas.update');
        Route::get('/igrejas/{id}/destroy', 'IgrejaController@destroy')->name('igrejas.destroy');
        Route::post('/igrejas/fetch_data', 'IgrejaController@fetch_data')->name('igrejas.fetch');

        Route::get('/celulas', 'CelulaController@index')->name('celulas');
        Route::post('/celulas/store', 'CelulaController@store')->name('celulas.store');
        Route::post('/celulas/update', 'CelulaController@update')->name('celulas.update');
        Route::get('/celulas/{id}/destroy', 'CelulaController@destroy')->name('celulas.destroy');
        Route::post('/celulas/fetch_data', 'CelulaController@fetch_data')->name('celulas.fetch');

        Route::get('/membros/conectar/{igreja_id}', 'MembrosController@conectar')->name('membros.conectar');
        Route::get('/membros/desconectar/{igreja_id}', 'MembrosController@desconectar')->name('membros.desconectar');

        Route::post('/menus/create', 'MenusController@create')->name('menus.create');
        Route::post('/menus/update', 'MenusController@update')->name('menus.update');
        Route::get('/menus/{id}/destroy', 'MenusController@destroy')->name('menus.destroy');

    });

});
