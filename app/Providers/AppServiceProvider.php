<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        \DB::listen(function($e){
            info($e->sql);
        });
        //
        /*
        \View::composer('threads/create', function($view){
            $view->with('channels',\App\Channel::all());
        });
        */
        //if you want to share it on every single page. you can do * or change the function to share, pass an array

        \View::composer('*', function ($view) {
            $channels = Cache::rememberForever('channels', function () {
                return \App\Channel::all();
            });
            $view->with('channels', $channels);
        });
        /**/
        \View::share('signIn', auth()->check());
        \View::share('user', auth()->user() ?: new \App\User);
        //Move it to dedicate service provider ==>ViewServiceProvider
        /*
        \View::share('channels',\App\Channel::all());
        */

        \Validator::extend('spamfree', 'App\Rules\SpamFree@passes');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
