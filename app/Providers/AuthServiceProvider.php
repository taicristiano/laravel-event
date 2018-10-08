<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\CommentPolicy;
use App\Comment;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Comment::class => CommentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // Gate::define('edit-comment', function ($user, $commment) {
        //     return $user->id == $comment->user_id;
        // });
        Gate::define('edit-comment', function () {
            return false;
        });
        // Gate::define('edit-comment', '\App\Policies\UserPolicy@editComment');
        Gate::resource('comments', 'CommentPolicy');
    }
}
