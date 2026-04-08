<?= $this->extend('layout/shop_layout') ?>
<?= $this->section('content') ?>

<div class="card glass-card text-center p-5 animate-fade-up">
    <i class="fas fa-check-circle text-success fa-5x mb-4"></i>
    <h2 class="mb-3">Thank you for your order!</h2>
    <p>Your invoice number: <strong><?= esc($sale['invoice_no']) ?></strong></p>
    <p class="h4">Total amount: <strong>₱<?= number_format($sale['grand_total'], 2) ?></strong></p>
    <p>You will receive a confirmation email shortly.</p>
    <div class="mt-4">
        <a href="<?= base_url('/shop') ?>" class="btn btn-primary">Continue Shopping <i class="fas fa-arrow-right"></i></a>
    </div>
</div>

<?= $this->endSection() ?>