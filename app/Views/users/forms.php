<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<h2><?= isset($user) ? 'Edit' : 'Add' ?> User</h2>

<form action="<?= isset($user) ? base_url('/users/update/'.$user['id']) : base_url('/users/store') ?>" method="post">
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="username" class="form-label">Username *</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $user['username'] ?? '' ?>" <?= isset($user) ? 'readonly' : 'required' ?>>
            </div>
            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name *</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="<?= $user['full_name'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email *</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?? '' ?>" required>
            </div>
            <?php if(!isset($user)): ?>
            <div class="mb-3">
                <label for="password" class="form-label">Password *</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <?php else: ?>
            <div class="mb-3">
                <label for="password" class="form-label">New Password (leave blank to keep current)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="role" class="form-label">Role *</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="staff" <?= (isset($user) && $user['role'] == 'staff') ? 'selected' : '' ?>>Staff</option>
                    <option value="admin" <?= (isset($user) && $user['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="is_active" class="form-label">Status</label>
                <select class="form-control" id="is_active" name="is_active">
                    <option value="1" <?= (isset($user) && $user['is_active'] == 1) ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= (isset($user) && $user['is_active'] == 0) ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="<?= base_url('/users') ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>

<?= $this->endSection() ?>