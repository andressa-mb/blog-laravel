<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostImage;
use App\Policies\CategoryPolicy;
use App\Policies\PostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        Category::class => CategoryPolicy::class,
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('post-image', function($user, $post){
            return $user->id === $post->user_id;
        });

        Gate::define('delete-image', function($user, PostImage $image) {
            return $user->id === $image->post->user_id;
        });

        Gate::define('create-posts', function ($user) {
            return $user->isAdmin;
        });
    }
}
