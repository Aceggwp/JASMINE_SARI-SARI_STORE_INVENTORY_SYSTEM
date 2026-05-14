<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>

<div class="card auth-card">
    <div class="card-header text-center">
        <h4><i class="fas fa-user"></i> Customer Login</h4>
        <p class="text-muted">Login to shop</p>
    </div>
    <div class="card-body p-4">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <form action="<?= base_url('/customer/login') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="customer_email" placeholder="customer@example.com" required>
                <label for="customer_email"><i class="fas fa-envelope me-2"></i>Email Address</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="customer_password" placeholder="Password" required>
                <label for="customer_password"><i class="fas fa-lock me-2"></i>Password</label>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mb-3">Login</button>
            <div class="text-center mt-3 pt-2 border-top">
                <p class="small text-muted mb-0">New customer? <a href="<?= base_url('/customer/register') ?>" class="text-decoration-none fw-bold">Register here</a></p>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>