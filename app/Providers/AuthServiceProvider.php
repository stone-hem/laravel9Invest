<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


            Passport::routes();

            Gate::before(function ($user, $ability) {
                if ($user->isAdministrator()) {
                    return true;
                }
            });

            Gate::define('admin',function($user){
                return $user->role_id=='1';
            });
            Gate::define('manager',function($user){
                return $user->role_id=='2';
            });
            Gate::define('user',function($user){
                return $user->role_id=='3';
            });

            // Gate::define('create',function($user){
            //     return $user->role_id=='1';
            // });

    }
}