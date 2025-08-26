<?php

namespace App\Providers;

use App\Models\Teacher;
use App\Observers\TeacherObserver;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        Teacher::observe(TeacherObserver::class);


        FilamentIcon::register([
        'panels::topbar.global-search.field' => 'fa-solid fa-magnifying-glass',
        'panels::sidebar.group.collapse-button' => 'fa-solid fa-caret-up',
    ]);

    
    }
}
