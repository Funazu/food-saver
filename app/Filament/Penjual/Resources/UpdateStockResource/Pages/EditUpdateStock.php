<?php

namespace App\Filament\Penjual\Resources\UpdateStockResource\Pages;

use App\Filament\Penjual\Resources\UpdateStockResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditUpdateStock extends EditRecord
{
    protected static string $resource = UpdateStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
            Action::make('resetStok')
                ->label('Reset Stok')
                ->color('warning')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->current_stock = 0;
                    $this->record->first_stock = 0;
                    $this->record->status = 'unavailable'; // Reset status makanan
                    $this->record->save();

                    Notification::make()
                        ->title('Stok berhasil direset')
                        ->success()
                        ->body('Stok awal dan stok sekarang telah direset ke 0.')
                        ->send();
                }),
        ];
    }
}
