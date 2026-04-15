<?= $this->extend('layout/auth') ?>
<?= $this->section('content') ?>

<style>
    .admin-hidden {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease-out;
    }
    .admin-hidden.show {
        max-height: 500px;
        transition: max-height 0.5s ease-in;
    }
    .secret-click {
        cursor: pointer;
        display: inline-block;
    }
    .separator {
        text-align: center;
        margin: 20px 0;
        position: relative;
    }
    .separator::before,
    .separator::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 45%;
        height: 1px;
        background: var(--border-color);
    }
    .separator::before { left: 0; }
    .separator::after { right: 0; }
    .separator span {
        background: var(--card-bg);
        padding: 0 15px;
        font-size: 12px;
        color: var(--text-secondary);
    }
    .google-btn {
        background: #fff;
        color: #757575;
        border: 1px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.2s;
    }
    .google-btn:hover {
        background: #f5f5f5;
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .google-btn img {
        width: 20px;
        height: 20px;
    }
    body.dark .google-btn {
        background: #2d3748;
        color: #e2e8f0;
        border-color: #4a5568;
    }
    body.dark .google-btn:hover {
        background: #374151;
    }
    .form-toggle {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        border-bottom: 2px solid var(--border-color);
    }
    .form-toggle button {
        background: none;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        font-weight: 500;
        color: var(--text-secondary);
        transition: all 0.2s;
    }
    .form-toggle button.active {
        color: var(--btn-primary-bg);
        border-bottom: 2px solid var(--btn-primary-bg);
        margin-bottom: -2px;
    }
    .form-panel {
        display: none;
    }
    .form-panel.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="card auth-card">
    <div class="card-header text-center">
        <h4 class="secret-click" onclick="toggleAdminLogin()">
            <i class="fas fa-store"></i> Jasmine Sari Sari Store
        </h4>
        <p class="text-muted" id="modeText">Welcome! Please login</p>
    </div>
    <div class="card-body p-4">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <!-- Toggle Buttons -->
        <div class="form-toggle">
            <button id="loginTab" class="active" onclick="showPanel('login')">Login</button>
            <button id="registerTab" onclick="showPanel('register')">Register</button>
        </div>

        <!-- Login Panel (Visible by default) -->
        <div id="loginPanel" class="form-panel active">
            <form action="<?= base_url('/customer/auth') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label>Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="customer@example.com" required autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="••••••" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <!-- Google Login Button -->
            <div class="separator mt-4 mb-3">
                <span>OR</span>
            </div>
            
            <a href="<?= base_url('/google-login') ?>" class="btn google-btn w-100 py-2">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google">
                Continue with Google
            </a>
        </div>

        <!-- Register Panel (Hidden by default) -->
        <div id="registerPanel" class="form-panel">
            <form action="<?= base_url('/customer/register') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label>Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent"><i class="fas fa-user"></i></span>
                        <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="customer@example.com" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent"><i class="fas fa-check-circle"></i></span>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Repeat password" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success w-100">Register</button>
            </form>
            
            <div class="separator mt-4 mb-3">
                <span>OR</span>
            </div>
            
            <a href="<?= base_url('/google-login') ?>" class="btn google-btn w-100 py-2">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google">
                Sign up with Google
            </a>
        </div>

        <!-- Hidden Admin Login Panel -->
        <div id="adminLogin" class="admin-hidden mt-4">
            <div class="alert alert-info small mb-3">
                <i class="fas fa-shield-alt"></i> Staff/Admin Access Only
            </div>
            <form action="<?= base_url('/admin/auth') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label>Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent"><i class="fas fa-user-tie"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="admin username">
                    </div>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent"><i class="fas fa-key"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="••••••">
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary w-100">Login as Staff/Admin</button>
            </form>
            
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
</div>

<script>
    // Toggle between Login and Register panels
    function showPanel(panel) {
        // Hide all panels
        document.getElementById('loginPanel').classList.remove('active');
        document.getElementById('registerPanel').classList.remove('active');
        
        // Show selected panel
        document.getElementById(panel + 'Panel').classList.add('active');
        
        // Update tab active state
        const loginTab = document.getElementById('loginTab');
        const registerTab = document.getElementById('registerTab');
        
        if (panel === 'login') {
            loginTab.classList.add('active');
            registerTab.classList.remove('active');
            document.getElementById('modeText').textContent = 'Login to your account';
        } else {
            registerTab.classList.add('active');
            loginTab.classList.remove('active');
            document.getElementById('modeText').textContent = 'Create new account';
        }
    }
    
    // Hidden Admin Login (5 clicks on logo)
    let clickCount = 0;
    let timeout;
    
    function toggleAdminLogin() {
        clickCount++;
        clearTimeout(timeout);
        timeout = setTimeout(() => { clickCount = 0; }, 1000);
        
        if (clickCount >= 5) {
            const adminPanel = document.getElementById('adminLogin');
            adminPanel.classList.toggle('show');
            clickCount = 0;
        }
    }
    
    // Keyboard shortcut: Type "ADMIN" to reveal admin panel
    let keySequence = [];
    const adminCode = ['a', 'd', 'm', 'i', 'n'];
    
    document.addEventListener('keydown', function(e) {
        keySequence.push(e.key.toLowerCase());
        if (keySequence.length > adminCode.length) keySequence.shift();
        
        if (JSON.stringify(keySequence) === JSON.stringify(adminCode)) {
            const adminPanel = document.getElementById('adminLogin');
            adminPanel.classList.toggle('show');
            keySequence = [];
        }
    });
</script>

<?= $this->endSection() ?>