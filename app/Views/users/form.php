<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<?php 
// Ensure $user is always an array
$user = $user ?? [];
?>

<h2><?= isset($user['id']) ? 'Edit User' : 'Add User' ?></h2>

<form action="<?= isset($user['id']) ? base_url('/users/update/'.$user['id']) : base_url('/users/store') ?>" method="post">
    <?= csrf_field() ?>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?= $user['username'] ?? '' ?>" <?= isset($user['id']) ? 'readonly' : 'required' ?>>
            </div>
            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="full_name" class="form-control" value="<?= $user['full_name'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= $user['email'] ?? '' ?>" required>
            </div>
            <?php if(!isset($user['id'])): ?>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <?php else: ?>
            <div class="mb-3">
                <label>New Password (leave blank to keep current)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <?php endif; ?>
            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="staff" <?= (isset($user['role']) && $user['role'] == 'staff') ? 'selected' : '' ?>>Staff</option>
                    <option value="admin" <?= (isset($user['role']) && $user['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="is_active" class="form-control">
                    <option value="1" <?= (isset($user['is_active']) && $user['is_active'] == 1) ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= (isset($user['is_active']) && $user['is_active'] == 0) ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= base_url('/users') ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>

<?= $this->endSection() ?>