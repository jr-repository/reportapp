<?php

namespace App\Controllers;

use App\Services\DailyReportService;
use App\Services\ReportPdfService;

class DailyReportController extends BaseController
{
    public function __construct(
        private readonly DailyReportService $dailyReportService = new DailyReportService(),
        private readonly ReportPdfService $reportPdfService = new ReportPdfService(),
    ) {
    }

    public function create(): string
    {
        return $this->page('Reports/CreateReportPage', [
            'pageTitle'   => 'Input Laporan',
            'formOptions' => $this->dailyReportService->getFormOptions(),
            'formData'    => [
                'reportDate'       => date('Y-m-d'),
                'workerUserId'     => $this->authService->currentUser()['id'] ?? '',
                'overtimeEnabled'  => '0',
                'overtimeStart'    => '18:00',
                'overtimeEnd'      => '24:00',
            ],
            'reportBundle' => null,
        ]);
    }

    public function edit(int $reportId)
    {
        $bundle = $this->dailyReportService->getReportBundle($reportId);
        if ($bundle === null) {
            return redirect()->to(base_url('/'))->with('error', 'Draft laporan tidak ditemukan.');
        }

        if (! $this->authService->canManageReport($this->authService->currentUser(), $bundle['report'])) {
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke laporan ini.');
        }

        return $this->page('Reports/CreateReportPage', [
            'pageTitle'   => 'Edit Laporan',
            'formOptions' => $this->dailyReportService->getFormOptions(),
            'formData'    => $this->mapBundleToFormData($bundle),
            'reportBundle'=> $bundle,
        ]);
    }

    public function saveDraft()
    {
        $payload          = $this->request->getPost();
        $payload['reportId'] = $this->request->getPost('reportId');
        $files            = $this->request->getFiles();
        $actor            = $this->authService->currentUser();

        $result = $this->dailyReportService->saveDraftFromRequest($payload, $files, $actor);

        if (! $result['success']) {
            return redirect()->back()->withInput()->with('errors', $result['errors']);
        }

        return redirect()->to(base_url('reports/review/' . $result['reportId']))->with('success', 'Draft laporan berhasil disimpan.');
    }

    public function review(int $reportId)
    {
        $bundle = $this->dailyReportService->getReportBundle($reportId);

        if ($bundle === null) {
            return redirect()->to(base_url('/'))->with('error', 'Laporan tidak ditemukan.');
        }

        if (! $this->authService->canManageReport($this->authService->currentUser(), $bundle['report'])) {
            return redirect()->to(base_url('/'))->with('error', 'Akses ditolak.');
        }

        return $this->page('Reports/ReviewReportPage', [
            'pageTitle' => 'Review & Submit',
            'bundle'    => $bundle,
            'summary'   => $this->dailyReportService->buildChecklistSummary($reportId),
        ]);
    }

    public function submit(int $reportId)
    {
        $result = $this->dailyReportService->submit($reportId, $this->authService->currentUser());

        if (! $result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->to(base_url('reports/detail/' . $reportId))->with('success', 'Laporan final berhasil dikirim.');
    }

    public function detail(int $reportId)
    {
        $bundle = $this->dailyReportService->getReportBundle($reportId);

        if ($bundle === null) {
            return redirect()->to(base_url('/'))->with('error', 'Laporan tidak ditemukan.');
        }

        if (! $this->authService->canManageReport($this->authService->currentUser(), $bundle['report'])) {
            return redirect()->to(base_url('/'))->with('error', 'Akses ditolak.');
        }

        return $this->page('Reports/DetailReportPage', [
            'pageTitle' => 'Detail Laporan',
            'bundle'    => $bundle,
        ]);
    }

    public function pdf(int $reportId)
    {
        $bundle = $this->dailyReportService->getReportBundle($reportId);

        if ($bundle === null) {
            return redirect()->to(base_url('/'))->with('error', 'Laporan tidak ditemukan.');
        }

        if (! $this->authService->canManageReport($this->authService->currentUser(), $bundle['report'])) {
            return redirect()->to(base_url('/'))->with('error', 'Akses ditolak.');
        }

        $binary = $this->reportPdfService->render($bundle);

        return $this->response
            ->setContentType('application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="Laporan-' . $bundle['report']['report_code'] . '.pdf"')
            ->setBody($binary);
    }

    private function mapBundleToFormData(array $bundle): array
    {
        $workerUpdates = [];
        foreach ($bundle['workerUpdates'] as $item) {
            if ($item['worker_category_id'] !== null) {
                $workerUpdates[$item['worker_category_id']] = $item['quantity'];
            }
        }

        $heavyEquipment = [];
        foreach ($bundle['heavyEquipment'] as $item) {
            if ($item['heavy_equipment_category_id'] !== null) {
                $heavyEquipment[$item['heavy_equipment_category_id']] = $item['quantity'];
            }
        }

        $customWorker = array_values(array_filter($bundle['workerUpdates'], static fn (array $item): bool => $item['worker_category_id'] === null));
        $customHeavy  = array_values(array_filter($bundle['heavyEquipment'], static fn (array $item): bool => $item['heavy_equipment_category_id'] === null));

        return [
            'reportId'           => $bundle['report']['id'],
            'reportDate'         => $bundle['report']['report_date'],
            'workerUserId'       => $bundle['report']['worker_user_id'],
            'currentLocation'    => $bundle['location']['current_location'],
            'areaCode'           => $bundle['location']['area_code'],
            'locationReason'     => $bundle['location']['reason'],
            'weatherCode'        => $bundle['report']['weather_code'],
            'workerUpdates'      => $workerUpdates,
            'workerCustomLabel'  => $customWorker[0]['category_label'] ?? '',
            'workerCustomQuantity'=> $customWorker[0]['quantity'] ?? '',
            'realizationSummary' => $bundle['report']['realization_summary'],
            'heavyEquipment'     => $heavyEquipment,
            'heavyCustomLabel'   => $customHeavy[0]['equipment_label'] ?? '',
            'heavyCustomQuantity'=> $customHeavy[0]['quantity'] ?? '',
            'lightToolSummary'   => $bundle['tool']['summary_text'],
            'materialSummary'    => $bundle['material']['summary_text'],
            'obstacleShape'      => $bundle['obstacle']['obstacle_shape'],
            'obstacleCause'      => $bundle['obstacle']['obstacle_cause'],
            'obstacleImpact'     => $bundle['obstacle']['obstacle_impact'],
            'obstacleNote'       => $bundle['obstacle']['additional_note'],
            'tomorrowPlan'       => $bundle['tomorrow']['summary_text'],
            'overtimeEnabled'    => (string) $bundle['overtime']['is_enabled'],
            'overtimeStart'      => $bundle['overtime']['start_time'],
            'overtimeEnd'        => $bundle['overtime']['end_time'],
            'overtimeSummary'    => $bundle['overtime']['summary_text'],
        ];
    }
}
