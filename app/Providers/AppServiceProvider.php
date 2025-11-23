<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Enrollment;
use App\Models\Teacher;
use App\Observers\EnrollmentObserver;
use App\Observers\TeacherObserver;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
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
        $company = Company::first();
        View::share(['company' => $company]);


        Model::unguard();
        Teacher::observe(TeacherObserver::class);
        Enrollment::observe(EnrollmentObserver::class);


    }
}
