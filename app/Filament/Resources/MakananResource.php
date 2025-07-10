<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MakananResource\Pages;
use App\Filament\Resources\MakananResource\RelationManagers;
use App\Models\Makanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MakananResource extends Resource
{
    protected static ?string $model = Makanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-cake';
 
    protected static ?string $pluralModelLabel = 'Makanan';
    protected static ?string $navigationLabel = 'Makanan';
    protected static ?string $navigationGroup = 'Manajemen Produk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'available' => 'Tersedia',
                        'unavailable' => 'Tidak Tersedia',
                        'inactive' => 'Nonaktif',
                        'expired' => 'Kedaluwarsa',
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Foto')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('penjual.nama_toko')->label('Nama Toko'),
                Tables\Columns\TextColumn::make('kategori.nama')->label('Kategori'),
                Tables\Columns\TextColumn::make('discounted_price')->money('IDR'),
                Tables\Columns\TextColumn::make('current_stock')->label('Stok'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'available' => 'success',
                        'unavailable' => 'danger',
                        'inactive' => 'gray',
                        'expired' => 'warning',
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('date_upload')->date('d M Y'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMakanans::route('/'),
            // 'create' => Pages\CreateMakanan::route('/create'),
            'edit' => Pages\EditMakanan::route('/{record}/edit'),
        ];
    }
}
