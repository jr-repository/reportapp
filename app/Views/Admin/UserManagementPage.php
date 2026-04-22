<?= $this->extend('Layouts/MobileLayout') ?>

<?= $this->section('content') ?>
<?= view('Components/PageHeader', [
    'eyebrow' => 'Admin Panel',
    'title' => 'Kelola User',
    'subtitle' => 'Tambah, edit, dan aktif/nonaktifkan akun pengguna.',
]) ?>

<section class="InfoCard">
    <div class="CardHeading">
        <h2><?= $editUser ? 'Edit User' : 'Tambah User' ?></h2>
        <span><?= $editUser ? esc($editUser['full_name']) : 'User baru' ?></span>
    </div>
    <form method="post" action="<?= base_url('admin/users/save') ?>" class="StackForm">
        <?= csrf_field() ?>
        <input type="hidden" name="userId" value="<?= esc((string) ($editUser['id'] ?? '')) ?>">

        <label class="FieldBlock">
            <span>Nama Lengkap</span>
            <input type="text" name="fullName" value="<?= esc(old('fullName', $editUser['full_name'] ?? '')) ?>" required>
        </label>

        <div class="FieldGrid">
            <label class="FieldBlock">
                <span>Email</span>
                <input type="email" name="email" value="<?= esc(old('email', $editUser['email'] ?? '')) ?>" required>
            </label>
            <label class="FieldBlock">
                <span>Username</span>
                <input type="text" name="username" value="<?= esc(old('username', $editUser['username'] ?? '')) ?>" required>
            </label>
        </div>

        <div class="FieldGrid">
            <label class="FieldBlock">
                <span>Role</span>
                <select name="roleId" required>
                    <?php foreach ($roles as $role) : ?>
                        <option value="<?= esc((string) $role['id']) ?>" <?= (string) old('roleId', $editUser['role_id'] ?? '') === (string) $role['id'] ? 'selected' : '' ?>>
                            <?= esc($role['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label class="FieldBlock">
                <span>Status</span>
                <select name="status" required>
                    <option value="Active" <?= old('status', $editUser['status'] ?? 'Active') === 'Active' ? 'selected' : '' ?>>Active</option>
                    <option value="Inactive" <?= old('status', $editUser['status'] ?? 'Active') === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </label>
        </div>

        <label class="FieldBlock">
            <span>Nomor HP</span>
            <input type="text" name="phone" value="<?= esc(old('phone', $editUser['phone'] ?? '')) ?>">
        </label>

        <label class="FieldBlock">
            <span>Password <?= $editUser ? '(kosongkan jika tidak diubah)' : '' ?></span>
            <input type="password" name="password" <?= $editUser ? '' : 'required' ?>>
        </label>

        <button type="submit" class="PrimaryButton"><?= $editUser ? 'Simpan Perubahan' : 'Tambah User' ?></button>
    </form>
</section>

<section class="InfoCard">
    <div class="CardHeading">
        <h2>Daftar User</h2>
        <span><?= esc((string) count($users)) ?> akun</span>
    </div>
    <div class="StatusList">
        <?php foreach ($users as $user) : ?>
            <div class="UserCard">
                <div>
                    <strong><?= esc($user['full_name']) ?></strong>
                    <p><?= esc($user['role_name']) ?> • <?= esc($user['email']) ?></p>
                </div>
                <div class="InlineActions">
                    <span class="StatusBadge <?= $user['status'] === 'Active' ? 'isDone' : 'isPending' ?>"><?= esc($user['status']) ?></span>
                    <a href="<?= base_url('admin/users?edit=' . $user['id']) ?>" class="InlineAction">Edit</a>
                    <a href="<?= base_url('admin/users/toggle/' . $user['id']) ?>" class="InlineAction">Toggle</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?= $this->endSection() ?>
