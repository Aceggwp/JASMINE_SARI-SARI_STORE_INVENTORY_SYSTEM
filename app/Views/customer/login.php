<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>

<div class="card auth-card">
    <hr>
<div class="text-center">
    <small>New customer? <a href="<?= base_url('/customer/register') ?>">Register as Customer</a></small>
</div>
<div class="text-center mt-2">
    <small>Staff login? <a href="<?= base_url('/login') ?>">Staff Login</a></small>
</div>
    <div class="card-body p-4">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <form action="<?= base_url('/customer/login') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
            <hr>
            <div class="text-center">
                <small>New customer? <a href="<?= base_url('/customer/register') ?>">Register here</a></small>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>