<?php

namespace App\Filament\Penjual\Resources\PesananResource\Pages;

use App\Filament\Penjual\Resources\PesananResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPesanan extends EditRecord
{
    protected static string $resource = PesananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (
            $this->record->status !== 'dikonfirmasi' &&
            $data['status'] === 'dikonfirmasi'
        ) {
            $makanan = $this->record->makanan;

            if ($makanan && $makanan->current_stock >= $this->record->quantity) {
                $makanan->current_stock -= $this->record->quantity;
                $makanan->save();
            } else {
                throw new \Exception('Stok tidak mencukupi untuk mengonfirmasi pesanan.');
            }
        }

        return $data;
    }
}
