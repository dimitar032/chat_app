<?php

namespace App\Providers;

use App\ChatRoom;
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

        Gate::define('can-auth-user-see-chat-room', function ($user, $chatRoomId) {
            $chatRoom = ChatRoom::findOrFail($chatRoomId);

            if ($chatRoom->users()->where('users.id', $user->id)->exists()) {
                return true;
            } else {
                return false;
            }

        });
    }
}
