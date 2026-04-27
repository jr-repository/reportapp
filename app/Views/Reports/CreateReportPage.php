<?= $this->extend('Layouts/MobileLayout') ?>

<?= $this->section('content') ?>
<?php
$workerUpdates    = $formData['workerUpdates'] ?? [];
$heavyEquipment   = $formData['heavyEquipment'] ?? [];
$existingPhotos   = $reportBundle['photos'] ?? [];
$currentStep      = (int) old('currentStep', $formData['currentStep'] ?? 1);
$realizationItems = old('realizationItems', $formData['realizationItems'] ?? []);
$workerCustomRows = old('workerCustomRows', $formData['workerCustomRows'] ?? []);
$heavyCustomRows  = old('heavyCustomRows', $formData['heavyCustomRows'] ?? []);
$lightTools       = old('lightTools', $formData['lightTools'] ?? []);

$realizationItems = is_array($realizationItems) && $realizationItems !== [] ? $realizationItems : [['work_item' => '', 'unit' => '', 'plan_text' => '', 'realization_text' => '', 'deviation_text' => '', 'partner' => '']];
$workerCustomRows = is_array($workerCustomRows) && $workerCustomRows !== [] ? $workerCustomRows : [['label' => '', 'quantity' => '']];
$heavyCustomRows  = is_array($heavyCustomRows) && $heavyCustomRows !== [] ? $heavyCustomRows : [['label' => '', 'quantity' => '', 'volume' => '', 'unit' => 'unit']];
$lightTools       = is_array($lightTools) && $lightTools !== [] ? $lightTools : [['tool_label' => '', 'volume' => '', 'unit' => '']];
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

<form method="post" action="<?= base_url('reports/save-draft') ?>" enctype="multipart/form-data" class="StackForm" id="ReportWizardForm" data-step="<?= esc((string) max(1, min(7, $currentStep))) ?>" data-draft-key="<?= esc('trace-report-draft:' . ($currentUser['id'] ?? 'guest') . ':' . ($formData['reportId'] ?? 'new')) ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="reportId" value="<?= esc((string) ($formData['reportId'] ?? '')) ?>">
    <input type="hidden" name="currentStep" id="CurrentStepInput" value="<?= esc((string) max(1, min(7, $currentStep))) ?>">

    <div class="WizardProgress">
        <button type="button" class="WizardChip" data-wizard-jump="1">1. Identitas</button>
        <button type="button" class="WizardChip" data-wizard-jump="2">2. Lokasi</button>
        <button type="button" class="WizardChip" data-wizard-jump="3">3. Realisasi</button>
        <button type="button" class="WizardChip" data-wizard-jump="4">4. Pekerja</button>
        <button type="button" class="WizardChip" data-wizard-jump="5">5. Alat Berat</button>
        <button type="button" class="WizardChip" data-wizard-jump="6">6. Alat Ringan</button>
        <button type="button" class="WizardChip" data-wizard-jump="7">7. Kendala</button>
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

      <style>
.StickyActionBar.isWizard {
    display: flex;
    justify-content: space-between; /* ⬅️ ini kuncinya */
    align-items: center;
    padding: 12px;
}

.StickyActionBar .GhostButton,
.StickyActionBar .PrimaryButton {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 14px;
    font-size: 14px;
    border-radius: 10px;
    min-height: 44px;
    flex-shrink: 0; /* biar gak ketarik */
}

.StickyActionBar .GhostButton {
    background: #f1f1f1;
    color: #333;
}

.StickyActionBar .PrimaryButton {
    background: linear-gradient(135deg, #2c3e70, #c0392b);
    color: #fff;
}

.StickyActionBar svg {
    width: 16px;
    height: 16px;
}
</style>

<div class="StickyActionBar isWizard">
    <a href="<?= base_url('/') ?>" 
       class="GhostButton">
        <?= trace_icon('back') ?>
        <span>Back</span>
    </a>

    <button type="button" 
            class="PrimaryButton" 
            data-wizard-next>
        <span>Next</span>
        <?= trace_icon('next') ?>
    </button>
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
            <select name="areaCode" id="AreaCodeSelect" required>
                <option value="">Pilih area</option>
                <?php foreach ($formOptions['areas'] as $area) : ?>
                    <option value="<?= esc($area['code']) ?>" <?= old('areaCode', $formData['areaCode'] ?? '') === $area['code'] ? 'selected' : '' ?>>
                        <?= esc($area['label']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label class="FieldBlock" id="LocationReasonField">
            <span>Reason / Keterangan Tambahan</span>
            <textarea name="locationReason" rows="3" placeholder="Tambahkan keterangan lokasi bila perlu"><?= esc(old('locationReason', $formData['locationReason'] ?? '')) ?></textarea>
        </label>

        <div class="UploadCard" id="section-photo">
            <strong>Dokumentasi Pekerjaan</strong>
            <p>Upload bisa dari galeri atau ambil foto langsung dari device.</p>
            <input type="file" name="photos[]" id="PhotoInput" accept="image/*" multiple>
            <div id="PhotoPreview" class="PhotoPreviewGrid"></div>
            <?php if ($existingPhotos !== []) : ?>
                <div class="PhotoPreviewGrid">
                    <?php foreach ($existingPhotos as $photo) : ?>
                        <img src="<?= base_url($photo['file_path']) ?>" alt="Dokumentasi tersimpan">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <label class="FieldBlock">
            <span>Keterangan Cuaca</span>
        </label>
        <div class="WeatherOptions">
            <?php foreach ($formOptions['weatherOptions'] as $weather) : ?>
                <label class="ChoiceChip">
                    <input type="radio" name="weatherCode" value="<?= esc($weather) ?>" <?= old('weatherCode', $formData['weatherCode'] ?? '') === $weather ? 'checked' : '' ?> required>
                    <span><?= esc($weather) ?></span>
                </label>
            <?php endforeach; ?>
        </div>

        <div class="StickyActionBar isWizard">
            <button type="button" class="GhostButton" data-wizard-prev aria-label="Kembali ke langkah sebelumnya" title="Kembali ke langkah sebelumnya"><?= trace_icon('back') ?><span>Back</span></button>
            <button type="button" class="PrimaryButton" data-wizard-next aria-label="Lanjut ke langkah berikutnya" title="Lanjut ke langkah berikutnya"><span>Next</span><?= trace_icon('next') ?></button>
        </div>
    </section>

    <section class="FormSectionCard WizardStep" id="section-realization" data-wizard-step="3">
        <div class="CardHeading">
            <h2>3. Realisasi Pekerjaan</h2>
            <span>Detail sesuai template</span>
        </div>

        <div class="DynamicRows" data-dynamic-rows="realizationItems">
            <?php foreach ($realizationItems as $index => $item) : ?>
                <div class="DynamicRow" data-dynamic-row>
                    <label class="FieldBlock">
                        <span>Item Pekerjaan</span>
                        <input type="text" name="realizationItems[<?= esc((string) $index) ?>][work_item]" value="<?= esc($item['work_item'] ?? '') ?>" placeholder="Item pekerjaan">
                    </label>
                    <label class="FieldBlock">
                        <span>Satuan</span>
                        <input type="text" name="realizationItems[<?= esc((string) $index) ?>][unit]" value="<?= esc($item['unit'] ?? '') ?>" placeholder="m / m2 / unit">
                    </label>
                    <label class="FieldBlock">
                        <span>Rencana</span>
                        <input type="text" name="realizationItems[<?= esc((string) $index) ?>][plan_text]" value="<?= esc($item['plan_text'] ?? '') ?>" placeholder="Rencana">
                    </label>
                    <label class="FieldBlock">
                        <span>Realisasi</span>
                        <input type="text" name="realizationItems[<?= esc((string) $index) ?>][realization_text]" value="<?= esc($item['realization_text'] ?? '') ?>" placeholder="Realisasi">
                    </label>
                    <label class="FieldBlock">
                        <span>Deviasi</span>
                        <input type="text" name="realizationItems[<?= esc((string) $index) ?>][deviation_text]" value="<?= esc($item['deviation_text'] ?? '') ?>" placeholder="Deviasi">
                    </label>
                    <label class="FieldBlock">
                        <span>Rekanan</span>
                        <input type="text" name="realizationItems[<?= esc((string) $index) ?>][partner]" value="<?= esc($item['partner'] ?? '') ?>" placeholder="Rekanan">
                    </label>
                    <button type="button" class="GhostButton DynamicRemoveButton" data-remove-row>Hapus</button>
                </div>
            <?php endforeach; ?>
            <button type="button" class="PrimaryButton DynamicAddButton" data-add-row>Tambah Baris</button>
        </div>

        <div class="StickyActionBar isWizard">
            <button type="button" class="GhostButton" data-wizard-prev><?= trace_icon('back') ?><span>Back</span></button>
            <button type="button" class="PrimaryButton" data-wizard-next><span>Next</span><?= trace_icon('next') ?></button>
        </div>
    </section>

    <section class="FormSectionCard WizardStep" id="section-worker" data-wizard-step="4">
        <div class="CardHeading">
            <h2>4. Update Pekerja</h2>
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

        <div class="DynamicRows" data-dynamic-rows="workerCustomRows">
            <p class="AccordionGroupTitle">Tambahan Posisi dan Jumlah</p>
            <?php foreach ($workerCustomRows as $index => $item) : ?>
                <div class="DynamicRow isTwoColumn" data-dynamic-row>
                    <label class="FieldBlock">
                        <span>Tambahan Posisi</span>
                        <input type="text" name="workerCustomRows[<?= esc((string) $index) ?>][label]" value="<?= esc($item['label'] ?? '') ?>" placeholder="Isi disini jika tidak ada pilihan">
                    </label>
                    <label class="FieldBlock">
                        <span>Jumlah</span>
                        <input type="number" min="0" name="workerCustomRows[<?= esc((string) $index) ?>][quantity]" value="<?= esc($item['quantity'] ?? '') ?>" placeholder="0">
                    </label>
                    <button type="button" class="GhostButton DynamicRemoveButton" data-remove-row>Hapus</button>
                </div>
            <?php endforeach; ?>
            <button type="button" class="PrimaryButton DynamicAddButton" data-add-row>Tambah Posisi</button>
        </div>

        <div class="StickyActionBar isWizard">
            <button type="button" class="GhostButton" data-wizard-prev><?= trace_icon('back') ?><span>Back</span></button>
            <button type="button" class="PrimaryButton" data-wizard-next><span>Next</span><?= trace_icon('next') ?></button>
        </div>
    </section>

    <section class="FormSectionCard WizardStep" id="section-heavy" data-wizard-step="5">
        <div class="CardHeading">
            <h2>5. Alat Berat</h2>
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

        <div class="DynamicRows" data-dynamic-rows="heavyCustomRows">
            <p class="AccordionGroupTitle">Alat Berat Tambahan</p>
            <?php foreach ($heavyCustomRows as $index => $item) : ?>
                <div class="DynamicRow" data-dynamic-row>
                    <label class="FieldBlock">
                        <span>Nama Alat</span>
                        <input type="text" name="heavyCustomRows[<?= esc((string) $index) ?>][label]" value="<?= esc($item['label'] ?? '') ?>" placeholder="Isi disini jika tidak ada pilihan">
                    </label>
                    <label class="FieldBlock">
                        <span>Jumlah</span>
                        <input type="number" min="0" name="heavyCustomRows[<?= esc((string) $index) ?>][quantity]" value="<?= esc($item['quantity'] ?? '') ?>" placeholder="0">
                    </label>
                    <label class="FieldBlock">
                        <span>Volume</span>
                        <input type="text" name="heavyCustomRows[<?= esc((string) $index) ?>][volume]" value="<?= esc($item['volume'] ?? '') ?>" placeholder="Volume">
                    </label>
                    <label class="FieldBlock">
                        <span>Satuan</span>
                        <input type="text" name="heavyCustomRows[<?= esc((string) $index) ?>][unit]" value="<?= esc($item['unit'] ?? 'unit') ?>" placeholder="unit">
                    </label>
                    <button type="button" class="GhostButton DynamicRemoveButton" data-remove-row>Hapus</button>
                </div>
            <?php endforeach; ?>
            <button type="button" class="PrimaryButton DynamicAddButton" data-add-row>Tambah Alat Berat</button>
        </div>

        <div class="StickyActionBar isWizard">
            <button type="button" class="GhostButton" data-wizard-prev aria-label="Kembali ke langkah sebelumnya" title="Kembali ke langkah sebelumnya"><?= trace_icon('back') ?><span>Back</span></button>
            <button type="button" class="PrimaryButton" data-wizard-next aria-label="Lanjut ke langkah berikutnya" title="Lanjut ke langkah berikutnya"><span>Next</span><?= trace_icon('next') ?></button>
        </div>
    </section>

    <section class="FormSectionCard WizardStep" id="section-light-tool" data-wizard-step="6">
        <div class="CardHeading">
            <h2>6. Alat Kerja Ringan & Material</h2>
            <span>Volume dan satuan alat ringan</span>
        </div>

        <div class="DynamicRows" data-dynamic-rows="lightTools">
            <p class="AccordionGroupTitle">Alat Kerja Ringan</p>
            <?php foreach ($lightTools as $index => $item) : ?>
                <div class="DynamicRow isThreeColumn" data-dynamic-row>
                    <label class="FieldBlock">
                        <span>Nama Alat</span>
                        <input type="text" name="lightTools[<?= esc((string) $index) ?>][tool_label]" value="<?= esc($item['tool_label'] ?? '') ?>" placeholder="Nama alat">
                    </label>
                    <label class="FieldBlock">
                        <span>Volume</span>
                        <input type="text" name="lightTools[<?= esc((string) $index) ?>][volume]" value="<?= esc($item['volume'] ?? '') ?>" placeholder="Volume">
                    </label>
                    <label class="FieldBlock">
                        <span>Satuan</span>
                        <input type="text" name="lightTools[<?= esc((string) $index) ?>][unit]" value="<?= esc($item['unit'] ?? '') ?>" placeholder="pcs / unit">
                    </label>
                    <button type="button" class="GhostButton DynamicRemoveButton" data-remove-row>Hapus</button>
                </div>
            <?php endforeach; ?>
            <button type="button" class="PrimaryButton DynamicAddButton" data-add-row>Tambah Alat Ringan</button>
        </div>

        <label class="FieldBlock" id="section-material">
            <span>Material & Bahan Kerja</span>
            <textarea name="materialSummary" rows="4" placeholder="Contoh: menggunakan Material XXX dan Bahan ZZZ untuk pekerjaan AAA" required><?= esc(old('materialSummary', $formData['materialSummary'] ?? '')) ?></textarea>
        </label>

        <div class="StickyActionBar isWizard">
            <button type="button" class="GhostButton" data-wizard-prev><?= trace_icon('back') ?><span>Back</span></button>
            <button type="button" class="PrimaryButton" data-wizard-next><span>Next</span><?= trace_icon('next') ?></button>
        </div>
    </section>

    <section class="FormSectionCard WizardStep" id="section-obstacle" data-wizard-step="7">
        <div class="CardHeading">
            <h2>7. Kendala, Rencana Esok & Lembur</h2>
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
            <button type="button" class="GhostButton" data-wizard-prev aria-label="Kembali ke langkah sebelumnya" title="Kembali ke langkah sebelumnya"><?= trace_icon('back') ?><span>Back</span></button>
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
