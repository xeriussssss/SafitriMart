<?php

namespace App\Filament\Widgets;

use App\Models\Produk;
use App\Models\Kategori;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ProdukChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Produk per Kategori';
    protected static ?int $sort = 5;
    protected int|string|array $columnSpan = 1; // setengah lebar

    protected function getData(): array
    {
        $data = Kategori::withCount('produk')->get();
        $labels = $data->pluck('nama')->toArray();
        $counts = $data->pluck('produk_count')->toArray();

        $colors = [
            '#f59e0b',
            '#ef4444',
            '#10b981',
            '#3b82f6',
            '#8b5cf6',
            '#ec4899',
            '#14b8a6',
            '#f97316',
            '#6366f1',
            '#84cc16',
            '#06b6d4',
            '#a855f7',
        ];

        return [
            'datasets' => [
                [
                    'data' => $counts,
                    'backgroundColor' => array_slice($colors, 0, count($counts)),
                    'borderWidth' => 2,
                    'borderColor' => '#1e293b',
                ]
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => true, 'position' => 'bottom'],
            ],
            'cutout' => '60%',
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}