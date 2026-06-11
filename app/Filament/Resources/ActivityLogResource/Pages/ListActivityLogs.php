<?php

namespace App\Filament\Resources\ActivityLogResource\Pages;

use App\Filament\Resources\ActivityLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListActivityLogs extends ListRecords
{
    protected static string $resource = ActivityLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('clearOld')
                ->label('Hapus Log Lama (>30 hari)')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Hapus Log Lama')
                ->modalDescription('Yakin ingin menghapus semua log yang lebih dari 30 hari?')
                ->visible(fn () => Auth::user()?->role === 'owner')
                ->action(function () {
                    \Spatie\Activitylog\Models\Activity::where('created_at', '<', now()->subDays(30))->delete();
                    \Filament\Notifications\Notification::make()
                        ->title('Log lama berhasil dihapus!')
                        ->success()
                        ->send();
                }),
        ];
    }
}
