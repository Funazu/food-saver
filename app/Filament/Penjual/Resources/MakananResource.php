<?php

namespace App\Filament\Penjual\Resources;

use App\Filament\Penjual\Resources\MakananResource\Pages;
use App\Filament\Penjual\Resources\MakananResource\RelationManagers;
use App\Models\Makanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MakananResource extends Resource
{
    protected static ?string $model = Makanan::class;

    protected static ?string $navigationLabel = 'Makanan';
    protected static ?string $navigationGroup = 'Manajemen Produk';

    protected static ?string $pluralModelLabel = 'Makanan';

    protected static ?string $navigationIcon = 'heroicon-o-cake';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kategori_id')
                    ->relationship('kategori', 'nama')
                    ->required()
                    ->label('Kategori'),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description'),

                Forms\Components\TextInput::make('original_price')
                    ->numeric()
                    ->prefix('Rp')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->label('Harga Normal'),

                Forms\Components\TextInput::make('discounted_price')
                    ->numeric()
                    ->prefix('Rp')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->label('Harga Diskon'),

                Forms\Components\TextInput::make('first_stock')
                    ->numeric()
                    ->label('Stok Awal'),

                Forms\Components\TextInput::make('current_stock')
                    ->numeric()
                    ->label('Stok Sekarang'),

                Forms\Components\TimePicker::make('start_time')->label('Jam Mulai'),
                Forms\Components\TimePicker::make('end_time')->label('Jam Selesai'),

                Forms\Components\DatePicker::make('date_upload')->label('Tanggal Upload'),

                Forms\Components\Select::make('status')
                    ->options([
                        'available' => 'Tersedia',
                        'unavailable' => 'Tidak Tersedia',
                        'inactive' => 'Nonaktif',
                        'expired' => 'Kedaluwarsa',
                    ])
                    ->default('inactive')
                    ->hidden(),
                Forms\Components\Hidden::make('penjual_id')
                    ->default(auth()->user()->penjual->id),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->label('Gambar Makanan')
                    ->directory('makanans')
                    ->disk('public'), // gunakan disk 'public' agar file disimpan di folder public/storage/makanans
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
                Tables\Columns\TextColumn::make('kategori.nama')->label('Kategori'),
                Tables\Columns\TextColumn::make('discounted_price')->money('IDR'),
                Tables\Columns\TextColumn::make('current_stock')->label('Stok'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
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
            'create' => Pages\CreateMakanan::route('/create'),
            'edit' => Pages\EditMakanan::route('/{record}/edit'),
        ];
    }
}
