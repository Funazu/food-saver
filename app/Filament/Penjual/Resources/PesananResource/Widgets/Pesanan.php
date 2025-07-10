<?php

namespace App\Filament\Penjual\Resources\PesananResource\Widgets;

use App\Models\Artikel;
use App\Models\Pesanan as ModelsPesanan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Pesanan extends BaseWidget
{
    protected function getCards(): array
    {
        $penjualId = auth()->user()->penjual->id;

        $totalPenjualan = ModelsPesanan::where('penjual_id', $penjualId)
            ->whereIn('status', [
                'dikonfirmasi',
                'siap_diambil',
                'sudah_diambil'
            ])
            ->sum('total_price');

        $totalPesanan = ModelsPesanan::where('penjual_id', $penjualId)->count();

        return [
            Stat::make('Total Penjualan', 'Rp ' . number_format($totalPenjualan, 0, ',', '.'))
                ->description('Total dari semua pesanan valid')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'),

            Stat::make('Total Pesanan', $totalPesanan)
                ->description('Jumlah total pesanan yang telah dibuat')
                ->descriptionIcon('heroicon-o-shopping-cart')
                ->color('primary'),
        ];
    }
}
