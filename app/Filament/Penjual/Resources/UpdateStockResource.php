<?php

namespace App\Filament\Penjual\Resources;

use App\Filament\Penjual\Resources\UpdateStockResource\Pages;
use App\Filament\Penjual\Resources\UpdateStockResource\RelationManagers;
use App\Models\Makanan;
use App\Models\UpdateStock;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UpdateStockResource extends Resource
{
    protected static ?string $model = Makanan::class;

    protected static ?string $navigationLabel = 'Update Stok';
    protected static ?string $navigationGroup = 'Manajemen Produk';
    protected static ?string $pluralModelLabel = 'Update Stok Makanan';
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_stock')
                    ->numeric()
                    ->label('Stok Awal')
                    ->required()
                    ->minValue(0)
                    ->default(0),
                TextInput::make('current_stock')
                    ->numeric()
                    ->label('Stok Saat Ini')
                    ->required()
                    ->minValue(0)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Foto')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Makanan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kategori.nama')->label('Kategori'),
                Tables\Columns\TextColumn::make('first_stock')
                    ->label('Stok Awal')
                    ->sortable(),
                Tables\Columns\TextColumn::make('current_stock')
                    ->label('Stok Saat Ini')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'available' => 'success',
                        'unavailable' => 'danger',
                        'inactive' => 'gray',
                        'expired' => 'warning',
                        default => 'secondary',
                    }),
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
            'index' => Pages\ListUpdateStocks::route('/'),
            'create' => Pages\CreateUpdateStock::route('/create'),
            'edit' => Pages\EditUpdateStock::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('penjual_id', auth()->user()->penjual->id);
    }

    public static function canCreate(): bool
    {
        return false; // disable tombol Create
    }
}
