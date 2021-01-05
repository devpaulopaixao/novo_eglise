<?php

namespace App\Providers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FakerGenerator::class, function () {
            return FakerFactory::create('pt_BR');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('cpf', '\App\Utils\CpfValidation@validate');
        ini_set('max_execution_time', '300');
        Carbon::setLocale('pt_BR');//Altera o idioma do texto diffForHumans;
        Schema::defaultStringLength(191);
    }
}
