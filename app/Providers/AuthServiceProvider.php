<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',

        'App\Article' => 'App\Policies\ArticlePolicy',
        'App\Category' => 'App\Policies\CategoryPolicy',
        'App\Role' => 'App\Policies\RolePolicy',
        'App\Tag' => 'App\Policies\TagPolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\Specie' => 'App\Policies\SpeciePolicy',
        'App\Pet' => 'App\Policies\PetPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
