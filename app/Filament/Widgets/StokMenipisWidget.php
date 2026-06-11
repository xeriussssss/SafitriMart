<?php

namespace App\Filament\Widgets;

use App\Models\Produk;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Support\Facades\Auth;

class StokMenipisWidget extends TableWidget
{
    protected static ?int $sort = 7;
    protected static ?string $heading = 'Stok Menipis';
    protected int | string | array $columnSpan = 1; // setengah lebar

    public static function canView(): bool
    {
        return in_array(Auth::user()?->role, ['owner', 'admin', 'staff_gudang']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Produk::query()
                    ->where('stok', '<=', 5)
                    ->orderBy('stok', 'asc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Produk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kategori.nama')
                    ->label('Kategori'),
                Tables\Columns\TextColumn::make('harga')
                    ->label('Harga')
                    ->money('IDR', true),
                Tables\Columns\TextColumn::make('stok')
                    ->label('Stok')
                    ->badge()
                    ->color(fn ($state): string => $state == 0 ? 'danger' : 'warning'),
            ])
            ->emptyStateHeading('Semua stok aman ✅')
            ->emptyStateIcon('heroicon-o-check-circle')
            ->paginated(false);
    }
}