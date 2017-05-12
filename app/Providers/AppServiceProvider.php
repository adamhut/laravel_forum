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
        //
        /*
        \View::composer('threads/create', function($view){
            $view->with('channels',\App\ForumChannel::all());
        });
        */
       //if you want to share it on every single page. you can do * or change the function to share, pass an array
      
        \View::composer('*', function($view){
            $channels = Cache::rememberForever('channels', function(){
                return \App\ForumChannel::all();
            });
            $view->with('channels',$channels);
        });
         /**/
        \View::share('signIn',auth()->check());
        \View::share('user',auth()->user()?: new \App\User);
       //Move it to dedicate service provider ==>ViewServiceProvider
       /*
       \View::share('channels',\App\ForumChannel::all());
       */
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if($this->app->isLocal())
        {
           $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
            
        }
    }
}
