<div class="sidebar">
    <div class="sidebar-header">
        <h5><i class="fas fa-store"></i> Inventory System</h5>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/dashboard') ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/categories') ?>">
                <i class="fas fa-tags"></i> Categories
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/products') ?>">
                <i class="fas fa-box"></i> Products
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/sales') ?>">
                <i class="fas fa-shopping-cart"></i> Sales
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/stock') ?>">
                <i class="fas fa-warehouse"></i> Stock
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/logs') ?>">
                <i class="fas fa-history"></i> Logs
            </a>
        </li>
        <?php if (session()->get('role') == 'admin'): ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/users') ?>">
                <i class="fas fa-users"></i> Users
            </a>
        </li>
        <?php endif; ?>
    </ul>
</div>