<?php

namespace App\Filament\Resources\PesananResource\Widgets;

use App\Models\Pesanan;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class PesananChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Pesanan 7 Hari Terakhir';

    protected function getData(): array
    {
        $labels = [];
        $data = [];

        // Ambil 7 hari terakhir dari hari ini
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('d M');

            $jumlahPesanan = Pesanan::whereDate('order_date', $date)->count();
            $data[] = $jumlahPesanan;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pesanan',
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
