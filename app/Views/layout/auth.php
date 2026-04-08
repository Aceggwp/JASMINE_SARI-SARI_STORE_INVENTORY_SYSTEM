<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Login' ?> - Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
    <style>
        /* Additional auth-specific overrides */
        .auth-card {
            background-color: var(--card-bg);
            border-radius: 24px;
            box-shadow: var(--shadow-md);
            animation: fadeInUp 0.5s ease;
        }
        .auth-card .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem 1.5rem 0.5rem;
        }
        .form-floating > label {
            color: var(--text-secondary);
        }
    </style>
</head>
<body class="<?= service('uri')->getSegment(1) === 'login' ? 'login-page' : '' ?>">
<body class="bg-light">
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-md-5">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <!-- Theme Toggle Button -->
    <div class="theme-toggle" id="themeToggle">
        <i id="themeIcon" class="fas fa-moon"></i>
        <span id="themeText">Dark Mode</span>
    </div>

    <div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
    <div class="col-md-6 col-lg-5">
        <?= $this->renderSection('content') ?>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('js/custom.js') ?>"></script>
</body>
</html>