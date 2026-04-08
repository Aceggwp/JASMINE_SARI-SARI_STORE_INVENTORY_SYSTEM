<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>

<div class="card auth-card">
    <div class="card-header text-center">
        <h4><i class="fas fa-user-plus me-2"></i>Create Account</h4>
        <p class="text-muted">Join our store inventory system</p>
    </div>
    <div class="card-body p-4">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if (isset($errors) && is_array($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach($errors as $err): ?>
                    <div><?= $err ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form action="<?= base_url('/auth/register') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent"><i class="fas fa-id-card"></i></span>
                    <input type="text" class="form-control" id="full_name" name="full_name" value="<?= old('full_name') ?>" placeholder="Enter full name" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" id="username" name="username" value="<?= old('username') ?>" placeholder="Choose username" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" placeholder="you@example.com" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Minimum 6 characters" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent"><i class="fas fa-check-circle"></i></span>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Repeat password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2">Register</button>
            <hr>
            <div class="text-center">
                <small>Already have an account? <a href="<?= base_url('/login') ?>">Login here</a></small>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>