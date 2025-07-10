<?php

namespace App\Providers\Filament;

use App\Filament\Penjual\Pages\EditToko as PagesEditToko;
use App\Filament\Penjual\Resources\NoneResource\Pages\EditToko;
use App\Filament\Penjual\Resources\PesananResource\Widgets\PendapatanChart;
use App\Filament\Penjual\Resources\PesananResource\Widgets\Pesanan;
use App\Filament\Penjual\Resources\PesananResource\Widgets\PesananChart;
use App\Http\Middleware\Penjual;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PenjualPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('penjual')
            ->path('penjual')
            ->login()
            ->colors([
                'primary' => \Filament\Support\Colors\Color::Hex('#16a34a'),
            ])
            ->discoverResources(in: app_path('Filament/Penjual/Resources'), for: 'App\\Filament\\Penjual\\Resources')
            ->discoverPages(in: app_path('Filament/Penjual/Pages'), for: 'App\\Filament\\Penjual\\Pages')
            ->pages([
                Pages\Dashboard::class,
                PagesEditToko::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Penjual/Widgets'), for: 'App\\Filament\\Penjual\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
                Pesanan::class,
                PendapatanChart::class,
                PesananChart::class,
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
            ]);
    }
}
