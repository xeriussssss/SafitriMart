<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\TransaksiChartWidget;
use App\Filament\Widgets\PendapatanChartWidget;
use App\Filament\Widgets\ProdukChartWidget;
use App\Filament\Widgets\TransaksiTerbaruWidget;
use App\Filament\Widgets\StokMenipisWidget;
use App\Filament\Widgets\ExportLaporanWidget;
use App\Filament\Widgets\StokAlertWidget;
use App\Filament\Widgets\RiwayatStokWidget;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    public function getColumns(): int|string|array
    {
        return 2;
    }

    public function getWidgets(): array
    {
        $user = Auth::user();

        if ($user->isOwner()) {
            return [
                ExportLaporanWidget::class,
                StatsOverviewWidget::class,
                TransaksiChartWidget::class,
                PendapatanChartWidget::class,
                ProdukChartWidget::class,
                TransaksiTerbaruWidget::class,
                StokAlertWidget::class,
                StokMenipisWidget::class,
                RiwayatStokWidget::class,
            ];
        }

        if ($user->isAdmin()) {
            return [
                StatsOverviewWidget::class,
                TransaksiChartWidget::class,
                PendapatanChartWidget::class,
                ProdukChartWidget::class,
                TransaksiTerbaruWidget::class,
                StokAlertWidget::class,
                StokMenipisWidget::class,
            ];
        }

        if ($user->isStaffGudang()) {
            return [
                StokAlertWidget::class,
                StokMenipisWidget::class,
                RiwayatStokWidget::class,
            ];
        }

        return [];
    }
}