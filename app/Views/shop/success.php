<?= $this->extend('layout/shop_layout') ?>
<?= $this->section('content') ?>

<div class="card glass-card animate-fade-up">
    <div class="card-body p-4">
        <div class="text-center mb-4">
            <i class="fas fa-check-circle text-success fa-5x mb-3"></i>
            <h2 class="mb-2">Thank you for your order!</h2>
            <p>Your order has been placed successfully.</p>
        </div>

        <!-- Receipt Section -->
        <div class="receipt border rounded p-3 mb-4 bg-white bg-opacity-10">
            <div class="text-center">
                <h5>Jasmine Sari Sari Store</h5>
                <p class="small mb-0">123 Main Street, City</p>
                <p class="small">Tel: 123-456-7890</p>
                <hr>
                <h6>SALES RECEIPT</h6>
                <p class="small">Invoice: <?= esc($sale['invoice_no']) ?><br>
                Date: <?= date('F d, Y h:i A', strtotime($sale['created_at'])) ?></p>
            </div>
            <table class="table table-sm">
                <thead>
                    <tr><th>Item</th><th>Qty</th><th>Price</th><th>Total</th></tr>
                </thead>
                <tbody>
                    <?php foreach($items as $item): ?>
                    <tr>
                        <td><?= esc($item['product_name']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>₱<?= number_format($item['price'], 2) ?></td>
                        <td>₱<?= number_format($item['total'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr><th colspan="3" class="text-end">Subtotal:</th><th>₱<?= number_format($sale['total_amount'], 2) ?></th></tr>
                    <tr><th colspan="3" class="text-end">Discount:</th><th>₱<?= number_format($sale['discount'], 2) ?></th></tr>
                    <tr><th colspan="3" class="text-end">Tax:</th><th>₱<?= number_format($sale['tax'], 2) ?></th></tr>
                    <tr class="table-active"><th colspan="3" class="text-end">GRAND TOTAL:</th><th>₱<?= number_format($sale['grand_total'], 2) ?></th></tr>
                </tfoot>
            </table>
            <div class="text-center mt-3">
                <p class="small">Payment Method: <?= ucfirst($sale['payment_method']) ?><br>
                Thank you for shopping with us!</p>
            </div>
        </div>

        <div class="d-flex justify-content-between gap-3">
            <button onclick="window.print()" class="btn btn-secondary flex-grow-1">
                <i class="fas fa-print"></i> Print Receipt
            </button>
            <a href="<?= base_url('/shop') ?>" class="btn btn-primary flex-grow-1">
                <i class="fas fa-shopping-cart"></i> Continue Shopping
            </a>
        </div>
    </div>
</div>

<style>
@media print {
    .navbar, .theme-toggle, .btn, footer, .no-print { display: none !important; }
    .receipt { box-shadow: none; border: 1px solid #ddd; }
    body { background: white; }
    .glass-card { background: white !important; backdrop-filter: none; box-shadow: none; }
}
</style>

<?= $this->endSection() ?>