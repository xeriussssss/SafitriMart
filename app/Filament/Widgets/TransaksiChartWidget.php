<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class TransaksiChartWidget extends ChartWidget
{
    protected static ?string $heading = '📊 Jumlah Transaksi (30 Hari)';
    protected static ?int $sort = 3;
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

        $data = Transaksi::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('date')->orderBy('date')->get()->keyBy('date');

        $labels = [];
        $counts = [];
        foreach ($days as $day) {
            $labels[] = \Carbon\Carbon::parse($day)->format('d M');
            $counts[] = $data->has($day) ? (int) $data[$day]->count : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Transaksi',
                    'data' => $counts,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245,158,11,0.2)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointRadius' => 3,
                    'pointHoverRadius' => 6,
                    'pointBackgroundColor' => '#f59e0b',
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
                'y' => ['beginAtZero' => true, 'ticks' => ['stepSize' => 1, 'precision' => 0], 'grid' => ['color' => 'rgba(255,255,255,0.05)']],
                'x' => ['grid' => ['display' => false]],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}