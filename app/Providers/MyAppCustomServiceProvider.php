<?php

namespace App\Providers;

use App\Repositories\PageRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\UserRepository;
use App\Services\AccountService;
use App\Services\ComponentService;
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
        $this->app->profile_repository = new ProfileRepository(); 
        $this->app->page_repository = new PageRepository();
        $this->app->user_repository = new UserRepository(); 

        
        //Repositories//
        $this->app->bind('App\Repositories\UserRepository', function ($app) {
            return $app->user_repository;
        });
        $this->app->bind('App\Repositories\ProfileRepository', function ($app) {
            return $app->profile_repository;
        });
        $this->app->bind('App\Repositories\PageRepository', function ($app) {
            return $app->page_repository;
        });

         //Services//
        $this->app->bind('App\Services\AccountService', function ($app) {
            return new AccountService($app->user_repository);
        });
         $this->app->bind('App\Services\ComponentService', function ($app) {
            return new ComponentService($app->profile_repository, $app->page_repository);
        });
          
    }
}
