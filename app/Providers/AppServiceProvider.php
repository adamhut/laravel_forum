<?php

namespace App\Providers;

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
            $view->with('channels',\App\ForumChannel::all());
        });
         /**/
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
    }
}
