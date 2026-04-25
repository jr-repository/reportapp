<?= $this->extend('Layouts/MobileLayout') ?>

<?= $this->section('content') ?>
<?php
$workerUpdates    = $formData['workerUpdates'] ?? [];
$heavyEquipment   = $formData['heavyEquipment'] ?? [];
$existingPhotos   = $reportBundle['photos'] ?? [];
$currentStep      = (int) old('currentStep', $formData['currentStep'] ?? 1);
?>

<?= view('Components/PageHeader', [
    'eyebrow' => 'Input Laporan Harian',
    'title' => $pageTitle ?? 'Input Laporan',
    'subtitle' => 'Satu form lengkap untuk seluruh aktivitas pekerjaan harian lapangan.',
]) ?>

<?= view('Components/AutoSendWAToggle', [
    'toggleId' => 'CreateAutoSendWaToggle',
    'hint'     => 'Preferensi ini dipakai saat Anda submit final laporan dari halaman review/detail.',
]) ?>

<form method="post" action="<?= base_url('reports/save-draft') ?>" enctype="multipart/form-data" class="StackForm" id="ReportWizardForm" data-step="<?= esc((string) max(1, min(5, $currentStep))) ?>" data-draft-key="<?= esc('trace-report-draft:' . ($currentUser['id'] ?? 'guest') . ':' . ($formData['reportId'] ?? 'new')) ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="reportId" value="<?= esc((string) ($formData['reportId'] ?? '')) ?>">
    <input type="hidden" name="currentStep" id="CurrentStepInput" value="<?= esc((string) max(1, min(5, $currentStep))) ?>">

    <div class="WizardProgress">
        <button type="button" class="WizardChip" data-wizard-jump="1">1. Identitas</button>
        <button type="button" class="WizardChip" data-wizard-jump="2">2. Lokasi</button>
        <button type="button" class="WizardChip" data-wizard-jump="3">3. Pekerja</button>
        <button type="button" class="WizardChip" data-wizard-jump="4">4. Alat</button>
        <button type="button" class="WizardChip" data-wizard-jump="5">5. Kendala</button>
    </div>

    <section class="FormSectionCard WizardStep" id="section-identity" data-wizard-step="1">
        <div class="CardHeading">
            <h2>1. Identitas Laporan</h2>
            <span>Wajib diisi dulu</span>
        </div>
        <div class="FieldGrid">
            <label class="FieldBlock">
                <span>Tanggal Laporan</span>
                <input type="date" name="reportDate" value="<?= esc(old('reportDate', $formData['reportDate'] ?? '')) ?>" required>
            </label>

            <label class="FieldBlock">
                <span>Supervisor / Pelaksana</span>
                <select name="workerUserId" required>
                    <option value="">Pilih user</option>
                    <?php foreach ($formOptions['workerUsers'] as $user) : ?>
                        <option value="<?= esc((string) $user['id']) ?>" <?= (string) old('workerUserId', $formData['workerUserId'] ?? '') === (string) $user['id'] ? 'selected' : '' ?>>
                            <?= esc($user['full_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <div class="StickyActionBar isWizard">
            <a href="<?= base_url('/') ?>" class="GhostButton isArrowOnly" aria-label="Kembali ke dashboard" title="Kembali ke dashboard"><?= trace_icon('back') ?></a>
            <button type="button" class="PrimaryButton isArrowOnly" data-wizard-next aria-label="Lanjut ke langkah berikutnya" title="Lanjut ke langkah berikutnya"><?= trace_icon('next') ?></button>
        </div>
    </section>

    <section class="FormSectionCard WizardStep" id="section-location" data-wizard-step="2">
        <div class="CardHeading">
            <h2>2. Lokasi, Foto & Cuaca</h2>
            <span>Lokasi aktual pekerjaan</span>
        </div>
        <label class="FieldBlock">
            <span>Lokasi Terkini</span>
            <input type="text" name="currentLocation" value="<?= esc(old('currentLocation', $formData['currentLocation'] ?? '')) ?>" placeholder="Contoh: Jl. Soekarno Hatta, 82 Bandung" required>
        </label>

        <label class="FieldBlock">
            <span>Pilih Area</span>
            <select name="areaCode" required>
                <option value="">Pilih area</option>
                <?php foreach ($formOptions['areas'] as $area) : ?>
                    <option value="<?= esc($area['code']) ?>" <?= old('areaCode', $formData['areaCode'] ?? '') === $area['code'] ? 'selected' : '' ?>>
                        <?= esc($area['label']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label class="FieldBlock">
            <span>Reason / Keterangan Tambahan</span>
            <textarea name="locationReason" rows="3" placeholder="Tambahkan keterangan lokasi bila perlu"><?= esc(old('locationReason', $formData['locationReason'] ?? '')) ?></textarea>
        </label>

        <div class="UploadCard" id="section-photo">
            <strong>Dokumentasi Pekerjaan</strong>
            <p>Upload bisa dari galeri atau ambil foto langsung dari device.</p>
            <input type="file" name="photos[]" id="PhotoInput" accept="image/*" capture="environment" multiple>
            <div id="PhotoPreview" class="PhotoPreviewGrid"></div>
            <?php if ($existingPhotos !== []) : ?>
                <div class="PhotoPreviewGrid">
                    <?php foreach ($existingPhotos as $photo) : ?>
                        <img src="<?= base_url($photo['file_path']) ?>" alt="Dokumentasi tersimpan">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="WeatherOptions">
            <?php foreach ($formOptions['weatherOptions'] as $weather) : ?>
                <label class="ChoiceChip">
                    <input type="radio" name="weatherCode" value="<?= esc($weather) ?>" <?= old('weatherCode', $formData['weatherCode'] ?? '') === $weather ? 'checked' : '' ?> required>
                    <span><?= esc($weather) ?></span>
                </label>
            <?php endforeach; ?>
        </div>

        <div class="StickyActionBar isWizard">
            <button type="button" class="GhostButton isArrowOnly" data-wizard-prev aria-label="Kembali ke langkah sebelumnya" title="Kembali ke langkah sebelumnya"><?= trace_icon('back') ?></button>
            <button type="button" class="PrimaryButton isArrowOnly" data-wizard-next aria-label="Lanjut ke langkah berikutnya" title="Lanjut ke langkah berikutnya"><?= trace_icon('next') ?></button>
        </div>
    </section>

    <section class="FormSectionCard WizardStep" id="section-worker" data-wizard-step="3">
        <div class="CardHeading">
            <h2>3. Update Pekerja & Realisasi</h2>
            <span>Isi jumlah tenaga kerja yang hadir</span>
        </div>
        <div class="CounterGrid">
            <?php foreach ($formOptions['workerCategories'] as $category) : ?>
                <label class="CounterField">
                    <span><?= esc($category['name']) ?></span>
                    <input type="number" min="0" name="workerUpdates[<?= esc((string) $category['id']) ?>]" value="<?= esc((string) old('workerUpdates.' . $category['id'], $workerUpdates[$category['id']] ?? '')) ?>" placeholder="0">
                </label>
            <?php endforeach; ?>
        </div>

        <div class="FieldGrid">
            <label class="FieldBlock">
                <span>Tambahan Posisi</span>
                <input type="text" name="workerCustomLabel" value="<?= esc(old('workerCustomLabel', $formData['workerCustomLabel'] ?? '')) ?>" placeholder="Isi disini jika tidak ada pilihan">
            </label>
            <label class="FieldBlock">
                <span>Jumlah</span>
                <input type="number" min="0" name="workerCustomQuantity" value="<?= esc(old('workerCustomQuantity', $formData['workerCustomQuantity'] ?? '')) ?>" placeholder="0">
            </label>
        </div>

        <label class="FieldBlock">
            <span>Realisasi Pekerjaan</span>
            <textarea name="realizationSummary" rows="7" class="LargeTextarea" placeholder="Tuliskan progres pekerjaan, volume, dan keterangan penting lain" required><?= esc(old('realizationSummary', $formData['realizationSummary'] ?? '')) ?></textarea>
        </label>

        <div class="StickyActionBar isWizard">
            <button type="button" class="GhostButton isArrowOnly" data-wizard-prev aria-label="Kembali ke langkah sebelumnya" title="Kembali ke langkah sebelumnya"><?= trace_icon('back') ?></button>
            <button type="button" class="PrimaryButton isArrowOnly" data-wizard-next aria-label="Lanjut ke langkah berikutnya" title="Lanjut ke langkah berikutnya"><?= trace_icon('next') ?></button>
        </div>
    </section>

    <section class="FormSectionCard WizardStep" id="section-heavy" data-wizard-step="4">
        <div class="CardHeading">
            <h2>4. Alat Berat, Alat Ringan & Material</h2>
            <span>Input operasional hari ini</span>
        </div>
        <div class="CounterGrid">
            <?php foreach ($formOptions['heavyCategories'] as $category) : ?>
                <label class="CounterField">
                    <span><?= esc($category['name']) ?></span>
                    <input type="number" min="0" name="heavyEquipment[<?= esc((string) $category['id']) ?>]" value="<?= esc((string) old('heavyEquipment.' . $category['id'], $heavyEquipment[$category['id']] ?? '')) ?>" placeholder="0">
                </label>
            <?php endforeach; ?>
        </div>

        <div class="FieldGrid">
            <label class="FieldBlock">
                <span>Alat Berat Tambahan</span>
                <input type="text" name="heavyCustomLabel" value="<?= esc(old('heavyCustomLabel', $formData['heavyCustomLabel'] ?? '')) ?>" placeholder="Isi disini jika tidak ada pilihan">
            </label>
            <label class="FieldBlock">
                <span>Jumlah</span>
                <input type="number" min="0" name="heavyCustomQuantity" value="<?= esc(old('heavyCustomQuantity', $formData['heavyCustomQuantity'] ?? '')) ?>" placeholder="0">
            </label>
        </div>

        <label class="FieldBlock">
            <span>Alat Kerja Ringan</span>
            <textarea name="lightToolSummary" rows="4" placeholder="Contoh: menggunakan alat kerja XXX untuk pekerjaan AAA" required><?= esc(old('lightToolSummary', $formData['lightToolSummary'] ?? '')) ?></textarea>
        </label>

        <label class="FieldBlock" id="section-material">
            <span>Material & Bahan Kerja</span>
            <textarea name="materialSummary" rows="4" placeholder="Contoh: menggunakan Material XXX dan Bahan ZZZ untuk pekerjaan AAA" required><?= esc(old('materialSummary', $formData['materialSummary'] ?? '')) ?></textarea>
        </label>

        <div class="StickyActionBar isWizard">
            <button type="button" class="GhostButton isArrowOnly" data-wizard-prev aria-label="Kembali ke langkah sebelumnya" title="Kembali ke langkah sebelumnya"><?= trace_icon('back') ?></button>
            <button type="button" class="PrimaryButton isArrowOnly" data-wizard-next aria-label="Lanjut ke langkah berikutnya" title="Lanjut ke langkah berikutnya"><?= trace_icon('next') ?></button>
        </div>
    </section>

    <section class="FormSectionCard WizardStep" id="section-obstacle" data-wizard-step="5">
        <div class="CardHeading">
            <h2>5. Kendala, Rencana Esok & Lembur</h2>
            <span>Lengkapi penutup laporan</span>
        </div>

        <div class="FieldGrid">
            <label class="FieldBlock">
                <span>Bentuk Kendala</span>
                <input type="text" name="obstacleShape" value="<?= esc(old('obstacleShape', $formData['obstacleShape'] ?? '')) ?>" required>
            </label>
            <label class="FieldBlock">
                <span>Penyebab Kendala</span>
                <input type="text" name="obstacleCause" value="<?= esc(old('obstacleCause', $formData['obstacleCause'] ?? '')) ?>" required>
            </label>
        </div>

        <label class="FieldBlock">
            <span>Dampak Pekerjaan</span>
            <input type="text" name="obstacleImpact" value="<?= esc(old('obstacleImpact', $formData['obstacleImpact'] ?? '')) ?>" required>
        </label>

        <label class="FieldBlock">
            <span>Penjelasan Tambahan</span>
            <textarea name="obstacleNote" rows="3" placeholder="Bila diperlukan"><?= esc(old('obstacleNote', $formData['obstacleNote'] ?? '')) ?></textarea>
        </label>

        <label class="FieldBlock">
            <span>Rencana Pekerjaan Esok</span>
            <textarea name="tomorrowPlan" rows="5" placeholder="Contoh: Besok melanjutkan sisa pekerjaan..." required><?= esc(old('tomorrowPlan', $formData['tomorrowPlan'] ?? '')) ?></textarea>
        </label>

        <div class="FieldGrid">
            <label class="FieldBlock">
                <span>Apakah Ada Lembur?</span>
                <select name="overtimeEnabled" id="OvertimeToggle">
                    <option value="0" <?= old('overtimeEnabled', $formData['overtimeEnabled'] ?? '0') === '0' ? 'selected' : '' ?>>Tidak</option>
                    <option value="1" <?= old('overtimeEnabled', $formData['overtimeEnabled'] ?? '0') === '1' ? 'selected' : '' ?>>Ya</option>
                </select>
            </label>
            <label class="FieldBlock">
                <span>Ringkasan Lembur</span>
                <input type="text" name="overtimeSummary" value="<?= esc(old('overtimeSummary', $formData['overtimeSummary'] ?? '')) ?>" placeholder="Opsional">
            </label>
        </div>

        <div class="FieldGrid" id="OvertimeFields">
            <label class="FieldBlock">
                <span>Jam Mulai</span>
                <input type="time" name="overtimeStart" value="<?= esc(old('overtimeStart', $formData['overtimeStart'] ?? '18:00')) ?>">
            </label>
            <label class="FieldBlock">
                <span>Jam Selesai</span>
                <input type="text" name="overtimeEnd" value="<?= esc(old('overtimeEnd', $formData['overtimeEnd'] ?? '24:00')) ?>" placeholder="24:00">
            </label>
        </div>

        <div class="StickyActionBar isWizard">
            <button type="button" class="GhostButton isArrowOnly" data-wizard-prev aria-label="Kembali ke langkah sebelumnya" title="Kembali ke langkah sebelumnya"><?= trace_icon('back') ?></button>
            <button type="submit" class="PrimaryButton">Simpan Draft & Review</button>
        </div>
    </section>
</form>

<div class="ReportDraftPrompt" id="ReportDraftPrompt" hidden>
    <div class="ReportDraftDialog">
        <strong>Simpan draft?</strong>
        <p>Data yang sudah Anda ketik akan disimpan sebagai draft di perangkat ini sebelum keluar dari halaman.</p>
        <div class="ReportDraftActions">
            <button type="button" class="PrimaryButton" data-draft-save-exit>Simpan Draft</button>
            <button type="button" class="GhostButton" data-draft-stay>Lanjut</button>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
