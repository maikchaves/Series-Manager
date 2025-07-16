<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AuthDirectives extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /*ao usar @guest (uma diretiva Laravel), não apenas vrificará se o usuário é Auth::guest(), mas também se tá na tela de login,
        pois o link de "entrar" não deverá aparecer na tela de login, uma vez que ele direciona para essa mesma tela
        */
        Blade::if('guest', function(){
            return !Route::is('login') && Auth::guest();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
