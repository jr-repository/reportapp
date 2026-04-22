<?php

namespace App\Services;

class ReportSummaryService
{
    public function build(array $bundle): string
    {
        $workerLines = [];
        foreach ($bundle['workerUpdates'] as $item) {
            $workerLines[] = $item['category_label'] . ' : ' . (int) $item['quantity'];
        }

        $equipmentLines = [];
        foreach ($bundle['heavyEquipment'] as $item) {
            $equipmentLines[] = $item['equipment_label'] . ' : ' . (int) $item['quantity'];
        }

        $lines = [
            'Nama Supervisor : ' . $bundle['worker']['full_name'],
            'Tanggal : ' . date('d F Y', strtotime($bundle['report']['report_date'])),
            'Update Pekerja :',
            $workerLines === [] ? '- Tidak ada update pekerja' : implode(PHP_EOL, $workerLines),
            'Lokasi Pekerjaan : ' . trim($bundle['location']['area_label'] . ' - ' . $bundle['location']['current_location'], ' -'),
            'Resume Realisasi Pekerjaan : ' . $bundle['report']['realization_summary'],
            'Kondisi Cuaca : ' . $bundle['report']['weather_code'],
            'Material & Bahan : ' . $bundle['material']['summary_text'],
            'Alat Berat :',
            $equipmentLines === [] ? '- Tidak ada alat berat dipakai' : implode(PHP_EOL, $equipmentLines),
            'Alat Kerja : ' . $bundle['tool']['summary_text'],
            'Kendala Pekerjaan : ' . $this->buildObstacleSummary($bundle),
        ];

        if ((int) $bundle['overtime']['is_enabled'] === 1) {
            $lines[] = 'Jika Ada Lembur : ' . trim($bundle['overtime']['start_time'] . ' - ' . $bundle['overtime']['end_time']);
        }

        $lines[] = 'Rencana Pekerjaan Esok : ' . $bundle['tomorrow']['summary_text'];

        return implode(PHP_EOL, $lines);
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
}
