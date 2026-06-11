<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ExportLaporanWidget extends Widget
{
    protected static ?int $sort = -3;
    protected static string $view = 'filament.widgets.export-laporan-widget';
    protected int | string | array $columnSpan = 'full';

    public string $bulan = '';

    public function mount(): void
    {
        $this->bulan = now()->format('Y-m');
    }

    public function export(): void
    {
        $this->redirect(route('admin.laporan.export-pdf', ['bulan' => $this->bulan]));
    }
}
