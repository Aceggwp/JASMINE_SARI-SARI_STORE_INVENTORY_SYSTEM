<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>

<div class="card auth-card shadow-lg border-0 rounded-4 overflow-hidden">
    <div class="card-header bg-transparent border-0 text-center pt-4">
        <div class="mb-3">
            <i class="fas fa-user-plus fa-3x" style="color: var(--btn-primary-bg);"></i>
        </div>
        <h3 class="fw-bold mb-1">Create Account</h3>
        <p class="text-muted small">Join our store management system</p>
    </div>
    <div class="card-body p-4 pt-0">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (isset($errors) && is_array($errors)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php foreach($errors as $err): ?>
                    <div><?= $err ?></div>
                <?php endforeach; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <form action="<?= base_url('/auth/register') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="form-floating mb-3">
                <input type="text" class="form-control rounded-3" id="full_name" name="full_name" placeholder="Full Name" value="<?= old('full_name') ?>" required>
                <label for="full_name"><i class="fas fa-id-card me-2"></i>Full Name</label>
            </div>
            
            <div class="form-floating mb-3">
                <input type="text" class="form-control rounded-3" id="username" name="username" placeholder="Username" value="<?= old('username') ?>" required>
                <label for="username"><i class="fas fa-user me-2"></i>Username</label>
            </div>
            
            <div class="form-floating mb-3">
                <input type="email" class="form-control rounded-3" id="email" name="email" placeholder="Email" value="<?= old('email') ?>" required>
                <label for="email"><i class="fas fa-envelope me-2"></i>Email Address</label>
            </div>
            
            <div class="form-floating mb-3">
                <input type="password" class="form-control rounded-3" id="password" name="password" placeholder="Password" required>
                <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
            </div>
            
            <div class="form-floating mb-3">
                <input type="password" class="form-control rounded-3" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                <label for="confirm_password"><i class="fas fa-check-circle me-2"></i>Confirm Password</label>
            </div>
            
            <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-semibold">Register</button>
            
            <hr class="my-4">
            
            <div class="text-center">
                <small class="text-muted">Already have an account? <a href="<?= base_url('/login') ?>" class="text-decoration-none">Sign in</a></small>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>