<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Support\Facades\Auth;

class TransaksiTerbaruWidget extends TableWidget
{
    protected static ?int $sort = 6;
    protected static ?string $heading = 'Transaksi Terbaru';
    protected int|string|array $columnSpan = 1; // setengah lebar

    public static function canView(): bool
    {
        return in_array(Auth::user()?->role, ['owner', 'admin']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Transaksi::query()
                    ->with(['user', 'detailTransaksi'])
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('No. Transaksi')
                    ->formatStateUsing(fn($state) => '#TRX' . str_pad($state, 6, '0', STR_PAD_LEFT)),
                Tables\Columns\TextColumn::make('nama_pembeli')
                    ->label('Pembeli')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('total_bayar')
                    ->label('Total')
                    ->money('IDR', true)
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'diproses',
                        'primary' => 'dikirim',
                        'success' => 'selesai',
                        'danger' => 'dibatalkan',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('lihat')
                    ->label('Lihat')
                    ->url(fn(Transaksi $record) => route('filament.admin.resources.transaksis.view', $record))
                    ->color('primary'),
            ])
            ->paginated(false);
    }
}