<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenjualResource\Pages;
use App\Filament\Resources\PenjualResource\RelationManagers;
use App\Models\Penjual;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenjualResource extends Resource
{
    protected static ?string $model = Penjual::class;

    protected static ?string $navigationLabel = 'Penjual';
    protected static ?string $navigationGroup = 'Manajemen User';
    protected static ?string $pluralModelLabel = 'Daftar Penjual';

    protected static ?string $navigationIcon = 'heroicon-s-building-storefront';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->label('User')
                ->searchable()
                ->required()
                ->disabled()
                ->dehydrated(false),

            Forms\Components\TextInput::make('nama_toko')
                ->label('Nama Toko')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),

            Forms\Components\TextInput::make('alamat_toko')
                ->label('Alamat Toko')
                ->required()
                ->maxLength(500),

            Forms\Components\Select::make('assign_roles')
                ->label('Peran User')
                ->multiple()
                ->preload()
                ->options(fn() => \Spatie\Permission\Models\Role::all()->pluck('name', 'name'))
                ->loadStateFromRelationshipsUsing(
                    fn($component, $record) =>
                    $component->state($record?->user?->roles->pluck('name')->toArray() ?? [])
                )
                ->afterStateUpdated(function ($state, $set, $get, $component) {
                    // Optionally handle update here
                })
                ->disabledOn('create')
                ->afterStateHydrated(function (Select $component, $state) {
                    $component->state($state); // agar terisi saat edit
                })
                ->afterStateUpdated(function ($state, $component, $record) {
                    if ($record && $record->user) {
                        $record->user->syncRoles($state);
                    }
                })
                ->dehydrated(true), // biar ikut disimpan ke controller resource



        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Penjual')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_toko')
                    ->label('Nama Toko')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat_toko')
                    ->label('Alamat Toko')
                    ->limit(50)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email Penjual')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListPenjuals::route('/'),
            'create' => Pages\CreatePenjual::route('/create'),
            'edit' => Pages\EditPenjual::route('/{record}/edit'),
        ];
    }
}
