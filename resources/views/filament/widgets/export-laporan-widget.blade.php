<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-success-100 dark:bg-success-900">
                    <x-filament::icon
                        icon="heroicon-o-document-arrow-down"
                        class="h-5 w-5 text-success-600 dark:text-success-400"
                    />
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-950 dark:text-white">Export Laporan PDF</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Download laporan transaksi bulanan dalam format PDF</p>
                </div>
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto">
                <div wire:ignore>
                    <select
                        wire:model="bulan"
                        class="fi-select-input block w-full sm:w-48 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 shadow-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >
                        @foreach(collect(range(0, 11))->mapWithKeys(function ($i) {
                            $d = now()->subMonths($i);
                            return [$d->format('Y-m') => $d->format('F Y')];
                        }) as $value => $label)
                        <option value="{{ $value }}" @if($bulan === $value) selected @endif>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <x-filament::button
                    wire:click="export"
                    color="success"
                    icon="heroicon-o-arrow-down-tray"
                    size="sm"
                >
                    Download PDF
                </x-filament::button>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
