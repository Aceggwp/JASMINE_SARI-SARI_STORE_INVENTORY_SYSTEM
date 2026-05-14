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
            <div class="form-floating mb-3">
                <input type="text" name="username" class="form-control" id="username" placeholder=" " required autofocus>
                <label for="username">Username</label>
            </div>
            <div class="form-floating mb-4">
                <input type="password" name="password" class="form-control" id="password" placeholder=" " required>
                <label for="password">Password</label>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold mb-3 shadow-sm">
                Login <i class="fas fa-arrow-right ms-2"></i>
            </button>
            <div class="text-center mt-4">
                <p class="text-muted small mb-1">Don't have an account?</p>
                <a href="<?= base_url('/register') ?>" class="text-success fw-bold text-decoration-none">
                    Create Account
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>