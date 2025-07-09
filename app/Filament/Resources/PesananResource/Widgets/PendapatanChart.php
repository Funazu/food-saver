<?php

namespace App\Filament\Resources\PesananResource\Widgets;

use App\Models\Pesanan;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class PendapatanChart extends ChartWidget
{
    protected static ?string $heading = 'Pendapatan 7 Hari Terakhir';

    protected function getData(): array
    {
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('d M');

            $totalPendapatan = Pesanan::whereDate('order_date', $date)
                ->where('status', '!=', 'dibatalkan_pembeli')
                ->where('status', '!=', 'dibatalkan_penjual')
                ->sum('total_price');

            $data[] = $totalPendapatan;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan',
                    'data' => $data,
                    'borderColor' => '#16a34a', // warna hijau
                    'backgroundColor' => 'rgba(22, 163, 74, 0.2)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public function getColumnSpan(): array|string|int
    {
        return '1/2';
    }
}
