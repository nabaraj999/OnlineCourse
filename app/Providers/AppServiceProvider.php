<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Enrollment;
use App\Models\Seo;
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
        View::composer('*', function ($view) {
            $seo = Seo::first(); // Fetch company data
            //seo also

            $view->with('seo', $seo);
        });

        $company = Company::first();
        View::share(['company' => $company]);


        Model::unguard();
        Teacher::observe(TeacherObserver::class);
        Enrollment::observe(EnrollmentObserver::class);
    }
}
