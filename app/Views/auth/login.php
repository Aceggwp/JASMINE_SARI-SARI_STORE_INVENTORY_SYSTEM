<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>

<div class="card auth-card shadow-lg border-0 rounded-4 overflow-hidden">
<hr>
<div class="text-center">
    <small>Don't have a staff account? <a href="<?= base_url('/register') ?>">Register as Staff</a></small>
</div>
<div class="text-center mt-2">
    <small>Are you a customer? <a href="<?= base_url('/customer/login') ?>">Customer Login</a></small>
</div>
    <div class="card-body p-4 pt-0">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <form action="<?= base_url('/auth/attempt') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="form-floating mb-3">
                <input type="text" class="form-control rounded-3" id="username" name="username" placeholder="username" required autofocus>
                <label for="username"><i class="fas fa-user me-2"></i>Username or Email</label>
            </div>
            
            <div class="form-floating mb-3">
                <input type="password" class="form-control rounded-3" id="password" name="password" placeholder="password" required>
                <label for="password"><i class="fas fa-lock me-2"></i>Password </label>
            </div>

            
            
            <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-semibold">Login</button>
            
            <hr class="my-4">
            
            <div class="text-center">
                <small class="text-muted">Don't have an account? <a href="<?= base_url('/register') ?>" class="text-decoration-none">Create one</a></small>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>