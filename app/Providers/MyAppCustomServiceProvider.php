<?php

namespace App\Providers;

use App\Repositories\ProfileRepository;
use App\Repositories\UserRepository;
use App\Services\AccountService;
use Illuminate\Support\ServiceProvider;

class MyAppCustomServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    { 
        //Services//
        $this->app->bind('App\Services\AccountService', function ($app) {
            return new AccountService();
          });



        //Repositories//
        $this->app->bind('App\Repositories\UserRepository', function ($app) {
            return new UserRepository();
        });
        $this->app->bind('App\Repositories\ProfileRepository', function ($app) {
         return new ProfileRepository();
        });
          
    }
}
