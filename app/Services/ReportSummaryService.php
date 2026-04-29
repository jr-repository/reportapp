<?php

namespace App\Services;

class ReportSummaryService
{
    public function build(array $bundle): string
    {
        $report   = $bundle['report'] ?? [];
        $location = $bundle['location'] ?? [];
        $material = $bundle['material'] ?? [];
        $tool     = $bundle['tool'] ?? [];
        $obstacle = $bundle['obstacle'] ?? [];
        $overtime = $bundle['overtime'] ?? [];
        $workerName = $bundle['worker']['full_name'] ?? ($report['worker_name'] ?? '-');

        // Ringkasan Realisasi
        $realizationItems = $bundle['realizationItems'] ?? [];
        if (count($realizationItems) > 0) {
            $realizationText = count($realizationItems) . ' item pekerjaan';
        } else {
            $realizationText = $this->value($report['realization_summary'] ?? '');
            if (mb_strlen($realizationText) > 80) {
                $realizationText = mb_substr($realizationText, 0, 77) . '...';
            }
        }

        // Ringkasan Pekerja
        $workerUpdates = $bundle['workerUpdates'] ?? [];
        $totalWorkers = array_sum(array_column($workerUpdates, 'quantity'));
        $workerText = $totalWorkers > 0 ? $totalWorkers . ' orang dari ' . count($workerUpdates) . ' posisi' : '-';

        // Ringkasan Alat Berat
        $heavyEquipment = $bundle['heavyEquipment'] ?? [];
        $totalHeavy = array_sum(array_column($heavyEquipment, 'quantity'));
        $heavyText = $totalHeavy > 0 ? $totalHeavy . ' unit dari ' . count($heavyEquipment) . ' jenis alat' : '-';

        // Ringkasan Alat Ringan
        $lightTools = $bundle['lightTools'] ?? [];
        if (count($lightTools) > 0) {
            $toolText = count($lightTools) . ' jenis alat kerja';
        } else {
            $toolText = $this->value($tool['summary_text'] ?? '');
            if (mb_strlen($toolText) > 80) {
                $toolText = mb_substr($toolText, 0, 77) . '...';
            }
        }

        // Ringkasan Material
        $materialText = $this->value($material['summary_text'] ?? '');
        if (mb_strlen($materialText) > 80) {
            $materialText = mb_substr($materialText, 0, 77) . '...';
        }

        // Ringkasan Kendala
        $obstacleText = $this->value($obstacle['obstacle_shape'] ?? '');
        if ($obstacleText === '-' || $obstacleText === '') {
            $obstacleText = 'Tidak ada';
        }

        $lines = [
            'Halo, ' . $workerName . ',',
            'Berikut ringkasan yang sudah Anda input:',
            '',
            'Lokasi Pekerjaan: ' . $this->value($location['area_label'] ?? '') . ' - ' . $this->value($location['current_location'] ?? ''),
            'Cuaca: ' . $this->value($report['weather_code'] ?? ''),
            'Realisasi Pekerjaan: ' . $realizationText,
            'Pekerja dan Posisi: ' . $workerText,
            'Alat Berat: ' . $heavyText,
            'Alat Ringan: ' . $toolText,
            'Material & Bahan: ' . $materialText,
            'Kendala: ' . $obstacleText,
            'Lembur: ' . ((int) ($overtime['is_enabled'] ?? 0) === 1 ? 'Ya (' . $this->value($overtime['start_time'] ?? '') . ' - ' . $this->value($overtime['end_time'] ?? '') . ')' : 'Tidak'),
        ];

        // Memasukkan Info Riwayat Edit jika Laporan di-update pasca submit Final
        if (!empty($report['edited_at'])) {
            $lines[] = '';
            $lines[] = '*(Catatan: Laporan ini telah diedit/diperbarui pada ' . date('d M Y H:i', strtotime($report['edited_at'])) . ')*';
        }

        return implode(PHP_EOL, array_filter($lines, static fn ($line): bool => $line !== null));
    }

    public function buildObstacleSummary(array $bundle): string
    {
        return trim(implode(' ', array_filter([
            'Bentuk: ' . $bundle['obstacle']['obstacle_shape'],
            'Penyebab: ' . $bundle['obstacle']['obstacle_cause'],
            'Dampak: ' . $bundle['obstacle']['obstacle_impact'],
            $bundle['obstacle']['additional_note'] !== '' ? 'Catatan: ' . $bundle['obstacle']['additional_note'] : null,
        ])));
    }

    private function value(?string $value): string
    {
        $value = trim((string) $value);

        return $value === '' ? '-' : $value;
    }
}