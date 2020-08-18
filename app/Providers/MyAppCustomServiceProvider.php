<?php

namespace App\Providers;

use App\Repositories\EntityRepository;
use App\Repositories\MealTaskGroupMemberRepository;
use App\Repositories\PageRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\UserRepository;
use App\Services\AccountService;
use App\Services\ComponentService;
use App\Services\EntityService;
use App\Services\WebConfigService;
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
        // out("::registering services::");
        $this->app->profile_repository = new ProfileRepository(); 
        $this->app->page_repository = new PageRepository();
        $this->app->user_repository = new UserRepository(); 
        $this->app->entity_repository = new EntityRepository();
        $this->app->meal_task_group_member_repo = new MealTaskGroupMemberRepository();
        $this->app->web_config_service = new WebConfigService( $this->app->entity_repository);
        $this->app->entity_service = new EntityService($this->app->entity_repository, $this->app->web_config_service);
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
        $this->app->bind('App\Repositories\EntityRepository', function ($app) {
            return $app->entity_repository;
        });

         //Services//
        $this->app->bind('App\Services\AccountService', function ($app) {
            return new AccountService($app->user_repository);
        });
        $this->app->bind('App\Services\EntityService', function ($app) {
            return  ($app->entity_service );
        });
        $this->app->bind('App\Services\ComponentService', function ($app) {
            $service = new ComponentService($app->profile_repository, $app->page_repository, $app->web_config_service, $app->meal_task_group_member_repo);
            $service->setEntityRepoAndEntitySvc($app->entity_repository, $app->entity_service);
            return $service;
        });
        $this->app->bind('App\Services\WebConfigService', function ($app) {
            return $app->web_config_service;
        });
       
          
    }
}
