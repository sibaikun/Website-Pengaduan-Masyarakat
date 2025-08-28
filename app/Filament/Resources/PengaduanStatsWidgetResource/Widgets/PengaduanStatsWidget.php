<?php

namespace App\Filament\Widgets;

use App\Models\Complaint; // Ganti dari Pengaduan ke Complaint
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PengaduanStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pengaduan', Complaint::count()) // Ganti ke Complaint
                ->color('danger'),
            Stat::make('Sedang Diproses', Complaint::where('status', 'processing')->count()) // Sesuaikan status
                ->color('warning'),
            Stat::make('Telah Selesai', Complaint::where('status', 'resolved')->count()) // Sesuaikan status
                ->color('success'),
            Stat::make('Rata-rata Hari', $this->getAverageProcessingDays())
                ->color('primary'),
        ];
    }

    private function getAverageProcessingDays()
    {
        // Sesuaikan dengan model Complaint
        return Complaint::where('status', 'resolved')
            ->selectRaw('AVG(DATEDIFF(updated_at, created_at)) as avg_days')
            ->value('avg_days') ?? 7; // Default 7 hari jika null
    }
}