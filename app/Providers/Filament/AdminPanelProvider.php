<?php

namespace App\Providers\Filament;

use App\Filament\Admin\Pages\Dashboard;
use App\Filament\Admin\Widgets\CategoryDonutWidget;
use App\Filament\Admin\Widgets\KpiStatsOverview;
use App\Filament\Admin\Widgets\RecentOrdersTable;
use App\Filament\Admin\Widgets\RevenueChartWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
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
        ->id('admin')
          ->path('admin')
            ->brandName('SR MAC SHOP — Admin')
            ->brandLogo(fn () => \App\Models\Setting::logoUrl())
            ->brandLogoHeight('2.25rem')
            ->favicon(fn () => \App\Models\Setting::logoUrl())
            ->login()
            ->colors([
                'primary' => Color::Blue,
                'warning' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
          ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
           KpiStatsOverview::class,
         RevenueChartWidget::class,
           CategoryDonutWidget::class,
                RecentOrdersTable::class,
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
            ])
            ->renderHook(
                PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
                fn (): string => Blade::render(<<<'BLADE'
                    <p style="text-align:center;font-size:12px;color:#6b7280;margin-top:18px;line-height:1.5">
                        Cambodia's most trusted MacBook specialist since 2018.<br>
                        <a href="https://srmacshop.com" style="color:#f97316;font-weight:600;text-decoration:none">srmacshop.com</a> · Phnom Penh
                    </p>
                BLADE)
            )
            ->renderHook(
                PanelsRenderHook::TOPBAR_END,
                fn (): string => Blade::render(<<<'BLADE'
                    <a href="{{ url('/') }}" target="_blank"
                       style="display:inline-flex;align-items:center;gap:5px;padding:5px 14px;background:#f97316;color:#fff;border-radius:980px;font-size:12px;font-weight:700;text-decoration:none;margin-right:6px;white-space:nowrap;line-height:1">
                        🛍️ Visit Shop
                    </a>
                BLADE)
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => view('filament.admin._mac-theme')->render()
            );
    }
}
