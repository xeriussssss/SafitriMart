<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityLogResource\Pages;
use Spatie\Activitylog\Models\Activity;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Log Aktivitas';
    protected static ?string $navigationGroup = 'Monitoring';
    protected static ?int $navigationSort = 1;
    protected static ?string $slug = 'activity-logs';

    public static function canAccess(): bool
    {
        return in_array(Auth::user()?->role, ['owner', 'admin']);
    }

    public static function canCreate(): bool { return false; }
    public static function canEdit($record): bool { return false; }
    public static function canDelete($record): bool { return Auth::user()?->role === 'owner'; }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->width('60px'),

                Tables\Columns\TextColumn::make('causer.name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->default('Sistem')
                    ->description(fn ($record) => $record->causer?->email ?? '')
                    ->icon('heroicon-m-user'),

                Tables\Columns\BadgeColumn::make('causer.role')
                    ->label('Role')
                    ->formatStateUsing(fn (?string $state): string => match($state) {
                        'owner'        => '👑 Owner',
                        'admin'        => '🛠️ Admin',
                        'staff_gudang' => '📦 Staff',
                        'user'         => '👤 User',
                        default        => '🤖 Sistem',
                    })
                    ->colors([
                        'warning' => 'owner',
                        'primary' => 'admin',
                        'info'    => 'staff_gudang',
                        'gray'    => 'user',
                    ]),

                Tables\Columns\TextColumn::make('description')
                    ->label('Aktivitas')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'login'            => '🔑 Login',
                        'logout'           => '🚪 Logout',
                        'created'          => '➕ Dibuat',
                        'updated'          => '✏️ Diubah',
                        'deleted'          => '🗑️ Dihapus',
                        'checkout'         => '🛒 Checkout',
                        'tambah_keranjang' => '🛍️ Tambah Keranjang',
                        'pakai_voucher'    => '🎟️ Pakai Voucher',
                        'upload_bukti'     => '📎 Upload Bukti',
                        'cancel_pesanan'   => '❌ Batalkan Pesanan',
                        default            => $state,
                    })
                    ->badge()
                    ->colors([
                        'success' => fn ($state) => in_array($state, ['login', 'created', 'checkout']),
                        'warning' => fn ($state) => in_array($state, ['updated', 'tambah_keranjang']),
                        'danger'  => fn ($state) => in_array($state, ['logout', 'deleted', 'cancel_pesanan']),
                        'primary' => fn ($state) => in_array($state, ['pakai_voucher', 'upload_bukti']),
                    ]),

                Tables\Columns\TextColumn::make('subject_type')
                    ->label('Objek')
                    ->formatStateUsing(fn (?string $state): string => match($state) {
                        'App\Models\Transaksi'  => '🛒 Transaksi',
                        'App\Models\Produk'     => '📦 Produk',
                        'App\Models\Kategori'   => '🏷️ Kategori',
                        'App\Models\User'       => '👤 User',
                        'App\Models\Voucher'    => '🎟️ Voucher',
                        'App\Models\Keranjang'  => '🛍️ Keranjang',
                        'App\Models\StokMasuk'  => '📥 Stok Masuk',
                        'App\Models\StokKeluar' => '📤 Stok Keluar',
                        default                 => $state ?? '-',
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('subject_id')
                    ->label('ID Objek')
                    ->default('-'),

                Tables\Columns\TextColumn::make('properties')
                    ->label('Detail')
                    ->formatStateUsing(function ($state) {
                        if (!$state || $state->isEmpty()) return '-';
                        $data = $state->toArray();
                        if (isset($data['attributes'])) {
                            return collect($data['attributes'])
                                ->take(3)
                                ->map(fn ($v, $k) => "$k: $v")
                                ->join(', ');
                        }
                        return collect($data)->take(2)->map(fn ($v, $k) => "$k: $v")->join(', ');
                    })
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y H:i:s')
                    ->sortable()
                    ->since()
                    ->tooltip(fn ($record) => $record->created_at->format('d M Y H:i:s')),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('description')
                    ->label('Aktivitas')
                    ->options([
                        'login'            => '🔑 Login',
                        'logout'           => '🚪 Logout',
                        'created'          => '➕ Dibuat',
                        'updated'          => '✏️ Diubah',
                        'deleted'          => '🗑️ Dihapus',
                        'checkout'         => '🛒 Checkout',
                        'tambah_keranjang' => '🛍️ Tambah Keranjang',
                        'pakai_voucher'    => '🎟️ Pakai Voucher',
                        'cancel_pesanan'   => '❌ Batalkan Pesanan',
                    ]),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('dari')->label('Dari Tanggal'),
                        \Filament\Forms\Components\DatePicker::make('sampai')->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['dari'], fn ($q, $v) => $q->whereDate('created_at', '>=', $v))
                            ->when($data['sampai'], fn ($q, $v) => $q->whereDate('created_at', '<=', $v));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => Auth::user()?->role === 'owner'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => Auth::user()?->role === 'owner'),
                ]),
            ])
            ->poll('30s');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
        ];
    }
}
