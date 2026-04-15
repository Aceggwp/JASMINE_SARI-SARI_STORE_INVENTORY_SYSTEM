<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>

<div class="card auth-card">
    <div class="card-header text-center">
        <h4><i class="fas fa-user-plus"></i> Customer Registration</h4>
        <p class="text-muted">Create an account to shop</p>
    </div>
    <div class="card-body p-4">
        <?php if(isset($errors) && is_array($errors)): ?>
            <div class="alert alert-danger"><?= implode('<br>', $errors) ?></div>
        <?php endif; ?>
        <form action="<?= base_url('/customer/register') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" value="<?= old('name') ?>" required>
            </div>
            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
            </div>
            <div class="mb-3">
                <label>Password (min 6 characters)</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
            <hr>
            <div class="text-center">
                <small>Already have an account? <a href="<?= base_url('/customer/login') ?>">Login here</a></small>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>