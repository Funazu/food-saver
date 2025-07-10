<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtikelResource\Pages;
use App\Filament\Resources\ArtikelResource\RelationManagers;
use App\Models\Artikel;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArtikelResource extends Resource
{
    protected static ?string $model = Artikel::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Artikel';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?string $pluralModelLabel = 'Artikel';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Judul Artikel')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('date')
                    ->label('Tanggal Artikel')
                    ->required()
                    ->default(now()),
                TextInput::make('source')
                    ->label('Sumber Artikel')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('image')
                    ->label('Gambar Artikel')
                    ->image()
                    ->disk('public')
                    ->directory('artikel_images')
                    ->nullable(),
                Forms\Components\RichEditor::make('content')
                    ->label('Konten Artikel')
                    ->required()
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'link',
                        'bulletList',
                        'numberedList',
                        'blockquote',
                        'codeBlock',
                        'undo',
                        'redo',
                        'clearFormatting',
                        'insertTable',
                        'insertImage',
                        'insertVideo',
                        'insertHorizontalRule',
                        'fullscreen',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Artikel')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal Artikel')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('source')
                    ->label('Sumber Artikel')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar Artikel')
                    ->disk('public')
                    ->size(50),
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
            'index' => Pages\ListArtikels::route('/'),
            'create' => Pages\CreateArtikel::route('/create'),
            'edit' => Pages\EditArtikel::route('/{record}/edit'),
        ];
    }
}
