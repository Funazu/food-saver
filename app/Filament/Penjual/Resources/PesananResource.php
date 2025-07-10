<?php

namespace App\Filament\Penjual\Resources;

use App\Filament\Penjual\Resources\PesananResource\Pages;
use App\Filament\Penjual\Resources\PesananResource\RelationManagers;
use App\Models\Pesanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
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
    protected static ?string $pluralModelLabel = 'Daftar Pesanan';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'dikonfirmasi' => 'Dikonfirmasi',
                        'siap_diambil' => 'Siap Diambil',
                        'sudah_diambil' => 'Sudah Diambil',
                        'dibatalkan_penjual' => 'Dibatalkan Penjual',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('unique_code')
                    ->label('Kode Pesanan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('pembeli.nama')
                    ->label('Pembeli')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('makanan.name')
                    ->label('Makanan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label('Jumlah')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total_price')
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(function (string $state) {
                        return match ($state) {
                            'pending' => 'Menunggu',
                            'dikonfirmasi' => 'Dikonfirmasi',
                            'siap_diambil' => 'Siap Diambil',
                            'sudah_diambil' => 'Sudah Diambil',
                            'dibatalkan_pembeli' => 'Dibatalkan Pembeli',
                            'dibatalkan_penjual' => 'Dibatalkan Penjual',
                            default => ucfirst($state),
                        };
                    })
                    ->color(function (string $state) {
                        return match ($state) {
                            'Menunggu' => 'gray',
                            'Dikonfirmasi' => 'blue',
                            'Siap Diambil' => 'amber',
                            'Sudah Diambi' => 'green',
                            'Dibatalkan Pembeli', 'Dibatalkan Penjual' => 'red',
                            default => 'gray',
                        };
                    }),
                TextColumn::make('order_date')
                    ->label('Tanggal Pesanan')
                    ->sortable()
                    ->searchable()
                    ->dateTime('d/m/Y H:i'),
                TextColumn::make('pickup_date')
                    ->label('Tanggal Ambil')
                    ->sortable()
                    ->searchable()
                    ->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('penjual_id', auth()->user()->penjual->id);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPesanans::route('/'),
            // 'create' => Pages\CreatePesanan::route('/create'),
            'edit' => Pages\EditPesanan::route('/{record}/edit'),
        ];
    }
}
