<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use \Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
  
    public function register(): void
    {
        
    }

    public function boot(): void
    {
        //View::share('title', 'Cabuyao City Disaster Risk Reduction Management Office');

        // View::composer('cdrrmo.dashboard', function($view){
        //     $view->with('admin', User::all());
        // });
    }
}
