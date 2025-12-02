<?php

namespace App\Providers\Filament;

use App\Models\Admin;
use App\Models\Company;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Pages\Dashboard;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Support\Facades\Storage;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->authGuard('admin')
            ->id('admin')
            ->path('admin')
                  // ← important!
        ->databaseNotifications()         // optional but recommended
        ->databaseTransactions()
        // Force correct ID from admin guard      // ← important!
            ->sidebarFullyCollapsibleOnDesktop()
           ->brandName('Admin')
           ->databaseNotifications()

            // Dynamic logo – resolved on every request
            ->brandLogo(fn () => $this->getCurrentCompanyLogo())

            // Optional: different logo for dark mode
            ->darkModeBrandLogo(fn () => $this->getCurrentCompanyLogo(dark: true))

            ->brandLogoHeight('3rem') // adjust as needed

            ->profile()
            ->login()

            ->colors([
                'primary' => Color::Indigo,
                'secondary' => Color::Gray,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([

            ])
           ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                \Filament\Http\Middleware\Authenticate::class,
            ]);
    }

    // Helper method to get the current logo
    protected function getCurrentCompanyLogo(bool $dark = false): ?string
    {
        // Adjust this query to match your logic
        // Examples:
        // - Company::first()
        // - auth()->user()?->company
        // - filament()->getTenant()
        $company = Company::first();

        if (!$company) {
            return asset('images/logo-fallback.png'); // fallback
        }

        $logoColumn = $dark ? 'logo_dark' : 'logo'; // if you have separate dark logo

        if ($company->$logoColumn && Storage::disk('public')->exists($company->$logoColumn)) {
            return Storage::url($company->$logoColumn) . '?v=' . ($company->updated_at?->timestamp ?? '');
        }

        // Fallback paths
        return $dark
            ? asset('images/logo-dark.png')
            : asset('images/logo.png');
    }
}
