<?php

namespace App\Providers;

use App\Models\Branch;
use App\Models\Meeting;
use App\Models\User;
use App\Policies\BranchPolicy;
use App\Policies\MeetingPolicy;
use App\Policies\UserPolicy;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Branch::class => BranchPolicy::class,
        User::class => UserPolicy::class,
        Meeting::class => MeetingPolicy::class
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
