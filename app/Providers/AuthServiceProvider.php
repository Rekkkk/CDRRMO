<?php

namespace App\Providers;
use Illuminate\Auth\TokenGuard;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot(): void
    {
        Auth::extend('api', function ($application, $name, array $config) {
            $Tguard = new TokenGuard(
                Auth::createUserProvider($config['provider']),
                $application['request']
            );
    
            $application->refresh('request', $Tguard, 'setRequest');
    
            return $Tguard;
        });
    }
}
