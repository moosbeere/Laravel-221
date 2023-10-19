<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\Response;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Article' => 'App\Policies\ArticleControllerPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function($user){
            if ($user->role === 'moderator') return true;
        });

        Gate::define('comment', function(User $user, Comment $comment){
            return $comment->user_id === $user->id ?
                    Response::allow() :
                    Response::deny('Your dont author!');
        });
    }
}
