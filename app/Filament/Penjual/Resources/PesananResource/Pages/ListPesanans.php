<?php

namespace App\Filament\Penjual\Resources\PesananResource\Pages;

use App\Filament\Penjual\Resources\PesananResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPesanans extends ListRecords
{
    protected static string $resource = PesananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
