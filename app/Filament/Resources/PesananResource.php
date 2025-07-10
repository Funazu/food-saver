<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesananResource\Pages;
use App\Filament\Resources\PesananResource\RelationManagers;
use App\Filament\Resources\PesananResource\Widgets\PendapatanChart;
use App\Filament\Resources\PesananResource\Widgets\PesananChart;
use App\Models\Pesanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PesananResource extends Resource
{
    protected static ?string $model = Pesanan::class;

    protected static ?string $navigationLabel = 'Orders';
    protected static ?string $navigationGroup = 'Manajemen Pesanan';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $pluralModelLabel = 'Daftar Pesanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('unique_code')->label('Kode'),
                TextColumn::make('pembeli.nama')->label('Pembeli'),
                TextColumn::make('makanan.name')->label('Makanan'),
                TextColumn::make('penjual.nama_toko')->label('Toko'),
                TextColumn::make('quantity')->label('Qty'),
                TextColumn::make('total_price')->money('IDR'),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn(string $state) => match ($state) {
                        'pending' => 'Menunggu',
                        'dikonfirmasi' => 'Dikonfirmasi',
                        'siap_diambil' => 'Siap Diambil',
                        'sudah_diambil' => 'Sudah Diambil',
                        'dibatalkan_pembeli' => 'Dibatalkan Pembeli',
                        'dibatalkan_penjual' => 'Dibatalkan Penjual',
                        default => ucfirst($state),
                    })
                    ->color(fn(string $state) => match ($state) {
                        'pending' => 'gray',
                        'dikonfirmasi' => 'blue',
                        'siap_diambil' => 'amber',
                        'sudah_diambil' => 'green',
                        'dibatalkan_pembeli', 'dibatalkan_penjual' => 'red',
                        default => 'gray',
                    }),
                TextColumn::make('order_date')->label('Tgl Pesan')->dateTime('d M Y H:i'),
                TextColumn::make('pickup_date')->label('Tgl Ambil')->dateTime('d M Y H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPesanans::route('/'),
            'create' => Pages\CreatePesanan::route('/create'),
            'edit' => Pages\EditPesanan::route('/{record}/edit'),
        ];
    }
}
