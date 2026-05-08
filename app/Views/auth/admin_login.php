<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>

<div class="card auth-card shadow-lg border-0 rounded-4 overflow-hidden">
    <div class="card-header text-center pt-4 pb-3">
        <h4 class="fw-bold"><i class="fas fa-store me-2"></i>Jasmine Store</h4>
        <p class="text-muted small">Welcome back! Please sign in.</p>
    </div>
    <div class="card-body p-4 pt-2">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <form action="<?= base_url('/admin/auth') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
            <div class="text-center">
                <p class="text-muted small mb-0">Don't have an account?</p>
                <a href="<?= base_url('/register') ?>" class="text-decoration-none">Create Account</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>