<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>

<div class="card auth-card">
    <div class="card-header text-center">
        <h4><i class="fas fa-store"></i> Jasmine Store</h4>
        <p class="text-muted">Sign In</p>
    </div>
    <div class="card-body p-4">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
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
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>