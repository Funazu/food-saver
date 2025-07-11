<?php

namespace App\Filament\Penjual\Resources\UpdateStockResource\Pages;

use App\Filament\Penjual\Resources\UpdateStockResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUpdateStocks extends ListRecords
{
    protected static string $resource = UpdateStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
