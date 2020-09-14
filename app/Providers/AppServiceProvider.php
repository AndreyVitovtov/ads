<?php

namespace App\Providers;

use App\Services\Contracts\AdminService;
use App\Services\Contracts\AdService;
use App\Services\Contracts\CityService;
use App\Services\Contracts\ContactService;
use App\Services\Contracts\CountryService;
use App\Services\Contracts\InteractionService;
use App\Services\Contracts\LanguageService;
use App\Services\Contracts\PermissionService;
use App\Services\Contracts\ReferralSystemService;
use App\Services\Contracts\RoleService;
use App\Services\Contracts\RubricService;
use App\Services\Contracts\SubsectionService;
use App\Services\Contracts\UserService;
use App\Services\Implement\AdminServiceImpl;
use App\Services\Implement\AdServiceImpl;
use App\Services\Implement\CityServiceImpl;
use App\Services\Implement\ContactServiceImpl;
use App\Services\Implement\CountryServiceImpl;
use App\Services\Implement\InteractionServiceImpl;
use App\Services\Implement\LanguageServiceImpl;
use App\Services\Implement\PermissionServiceImpl;
use App\Services\Implement\ReferralSystemImpl;
use App\Services\Implement\RoleServiceImpl;
use App\Services\Implement\RubricServiceImpl;
use App\Services\Implement\SubsectionServiceImpl;
use App\Services\Implement\UserServiceImpl;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AdminService::class, function() {
            return new AdminServiceImpl();
        });

        $this->app->singleton(AdService::class, function() {
            return new AdServiceImpl();
        });

        $this->app->singleton(CityService::class, function() {
            return new CityServiceImpl();
        });

        $this->app->singleton(CountryService::class, function() {
            return new CountryServiceImpl();
        });

        $this->app->singleton(ContactService::class, function() {
            return new ContactServiceImpl();
        });

        $this->app->singleton(CountryService::class, function() {
            return new CountryServiceImpl();
        });

        $this->app->singleton(InteractionService::class, function() {
            return new InteractionServiceImpl();
        });

        $this->app->singleton(LanguageService::class, function() {
            return new LanguageServiceImpl();
        });

        $this->app->singleton(PermissionService::class, function() {
            return new PermissionServiceImpl();
        });

        $this->app->singleton(ReferralSystemService::class, function() {
            return new ReferralSystemImpl();
        });

        $this->app->singleton(RoleService::class, function() {
            return new RoleServiceImpl();
        });

        $this->app->singleton(RubricService::class, function() {
            return new RubricServiceImpl();
        });

        $this->app->singleton(SubsectionService::class, function() {
            return new SubsectionServiceImpl();
        });

        $this->app->singleton(UserService::class, function() {
            return new UserServiceImpl();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}