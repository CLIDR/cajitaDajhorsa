<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use App\Models\Company;
use Filament\PanelProvider;
use Filament\Facades\Filament;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use App\Http\Middleware\ApplyTenantScopes;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Filament\App\Pages\Tenancy\RegisterCompany;
use Illuminate\Routing\Middleware\SubstituteBindings;
use App\Filament\App\Pages\Tenancy\EditCompanyProfile;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->tenant(Company::class, ownershipRelationship: 'company', slugAttribute: 'ruc')
            ->tenantRegistration(RegisterCompany::class)
            ->tenantProfile(EditCompanyProfile::class)
            ->default()
            ->brandName('Dajhorsa Demo')
            ->id('app')
            ->path('app')
            ->tenantRoutePrefix('company')
            ->login()
            ->maxContentWidth(MaxWidth::Full)
            ->profile(isSimple: false)
            ->tenantMenuItems([
                // MenuItem::make()
                //     ->label('Settings')
                //     ->url('/')
                //     ->icon('heroicon-m-cog-8-tooth'),
            ])
            ->userMenuItems([
                MenuItem::make('admin-panel')
                    ->label('Admin Panel')
                    ->url('/admin')
                    ->icon('heroicon-o-cog-6-tooth'),
                // MenuItem::make()
                //     ->label('Lock session')
                //     ->postAction(fn (): string => route('lock-session'))
            ])
            ->colors([
                'primary' => Color::Orange,
            ])
            ->font('Poppins')
            ->discoverResources(in: app_path('Filament/App/Resources'), for: 'App\\Filament\\App\\Resources')
            ->discoverPages(in: app_path('Filament/App/Pages'), for: 'App\\Filament\\App\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/App/Widgets'), for: 'App\\Filament\\App\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
                Authenticate::class,
                ApplyTenantScopes::class
            ], isPersistent: true);
            // ->plugins([
            //     \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
            // ]);
    }
}
