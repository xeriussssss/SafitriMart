<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class PendapatanChartWidget extends ChartWidget
{
    protected static ?string $heading = '💰 Pendapatan (30 Hari)';
    protected static ?int $sort = 4;
    protected int|string|array $columnSpan = 1; // setengah lebar

    public static function canView(): bool
    {
        return in_array(Auth::user()?->role, ['owner', 'admin']);
    }

    protected function getData(): array
    {
        $days = collect();
        for ($i = 29; $i >= 0; $i--) {
            $days->push(now()->subDays($i)->format('Y-m-d'));
        }

        $data = Transaksi::selectRaw('DATE(created_at) as date, SUM(total_bayar) as revenue')
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->where('status', '!=', 'dibatalkan')
            ->groupBy('date')->orderBy('date')->get()->keyBy('date');

        $labels = [];
        $revenue = [];
        foreach ($days as $day) {
            $labels[] = \Carbon\Carbon::parse($day)->format('d M');
            $revenue[] = $data->has($day) ? (int) round($data[$day]->revenue / 1000) : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan (×Rp1.000)',
                    'data' => $revenue,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16,185,129,0.2)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointRadius' => 3,
                    'pointHoverRadius' => 6,
                    'pointBackgroundColor' => '#10b981',
                    'borderWidth' => 2,
                ]
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => ['legend' => ['display' => true, 'position' => 'bottom']],
            'scales' => [
                'y' => ['beginAtZero' => true, 'grid' => ['color' => 'rgba(255,255,255,0.05)']],
                'x' => ['grid' => ['display' => false]],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}