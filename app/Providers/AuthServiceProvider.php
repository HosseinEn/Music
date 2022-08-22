<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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

        Gate::define('delete-admin', function($currentUser, $deleteUser) {
            return !$deleteUser->is_admin;
        });

        Gate::define('edit-admin', function($currentUser, $editUser) {
            return $currentUser->id == $editUser->id || !$editUser->is_admin;
        });

        Gate::define('promote', function($currentUser, $editUser) {
            return $currentUser->id !== $editUser->id && !$editUser->is_admin;
        });
    }
}
