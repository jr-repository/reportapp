<?php

namespace App\Services;

class ReportSummaryService
{
    public function build(array $bundle): string
    {
        $report = $bundle['report'] ?? [];
        $location = $bundle['location'] ?? [];
        $material = $bundle['material'] ?? [];
        $tool = $bundle['tool'] ?? [];
        $obstacle = $bundle['obstacle'] ?? [];
        $tomorrow = $bundle['tomorrow'] ?? [];
        $overtime = $bundle['overtime'] ?? [];
        $photos = $bundle['photos'] ?? [];

        $lines = [
            'TRACE - Laporan Harian',
            'Kode Laporan : ' . $this->value($report['report_code'] ?? ''),
            'Status : ' . $this->value($report['status'] ?? ''),
            'Tanggal Laporan : ' . $this->formatDate($report['report_date'] ?? ''),
            'Supervisor / Pelaksana : ' . $this->value($bundle['worker']['full_name'] ?? ''),
            'Dibuat Oleh : ' . $this->value($report['creator_name'] ?? ''),
            '',
            'LOKASI & CUACA',
            'Area : ' . $this->value($location['area_label'] ?? ''),
            'Lokasi Terkini : ' . $this->value($location['current_location'] ?? ''),
            'Reason / Keterangan Tambahan : ' . $this->value($location['reason'] ?? ''),
            'Kondisi Cuaca : ' . $this->value($report['weather_code'] ?? ''),
            '',
            'UPDATE PEKERJA',
            $this->buildListBlock($bundle['workerUpdates'] ?? [], 'category_label'),
            '',
            'REALISASI PEKERJAAN',
            $this->value($report['realization_summary'] ?? ''),
            '',
            'ALAT & MATERIAL',
            'Alat Berat :',
            $this->buildListBlock($bundle['heavyEquipment'] ?? [], 'equipment_label'),
            'Alat Kerja Ringan : ' . $this->value($tool['summary_text'] ?? ''),
            'Material & Bahan Kerja : ' . $this->value($material['summary_text'] ?? ''),
            '',
            'KENDALA',
            'Bentuk Kendala : ' . $this->value($obstacle['obstacle_shape'] ?? ''),
            'Penyebab Kendala : ' . $this->value($obstacle['obstacle_cause'] ?? ''),
            'Dampak Pekerjaan : ' . $this->value($obstacle['obstacle_impact'] ?? ''),
            'Penjelasan Tambahan : ' . $this->value($obstacle['additional_note'] ?? ''),
            '',
            'LEMBUR',
            'Status Lembur : ' . ((int) ($overtime['is_enabled'] ?? 0) === 1 ? 'Ya' : 'Tidak'),
            'Jam Mulai : ' . $this->value($overtime['start_time'] ?? ''),
            'Jam Selesai : ' . $this->value($overtime['end_time'] ?? ''),
            'Ringkasan Lembur : ' . $this->value($overtime['summary_text'] ?? ''),
            '',
            'RENCANA BESOK',
            $this->value($tomorrow['summary_text'] ?? ''),
            '',
            'DOKUMENTASI',
            'Total Foto : ' . count($photos) . ' file',
            $this->buildPhotoLines($photos),
        ];

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

    private function buildListBlock(array $items, string $labelKey): string
    {
        if ($items === []) {
            return '- Tidak ada data';
        }

        $lines = [];
        foreach ($items as $item) {
            $lines[] = '- ' . $this->value($item[$labelKey] ?? '') . ' : ' . (int) ($item['quantity'] ?? 0);
        }

        return implode(PHP_EOL, $lines);
    }

    private function buildPhotoLines(array $photos): string
    {
        if ($photos === []) {
            return '- Tidak ada foto';
        }

        $lines = [];
        foreach ($photos as $index => $photo) {
            $lines[] = '- Foto ' . ($index + 1) . ' : ' . $this->value($photo['file_name'] ?? '');
        }

        return implode(PHP_EOL, $lines);
    }

    private function formatDate(string $date): string
    {
        if ($date === '') {
            return '-';
        }

        $timestamp = strtotime($date);
        return $timestamp ? date('d F Y', $timestamp) : $date;
    }

    private function value(?string $value): string
    {
        $value = trim((string) $value);

        return $value === '' ? '-' : $value;
    }
}
