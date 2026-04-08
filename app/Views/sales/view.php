<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3>Sale Details - <?= esc($sale['invoice_no']) ?></h3>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Invoice No:</strong> <?= $sale['invoice_no'] ?></p>
                <p><strong>Cashier:</strong> <?= esc($sale['cashier'] ?? 'N/A') ?></p>
                <p><strong>Customer:</strong> <?= esc($sale['customer_name'] ?? 'Walk-in') ?></p>
                <p><strong>Sale Date:</strong> <?= date('F d, Y h:i A', strtotime($sale['created_at'])) ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Payment Method:</strong> <?= ucfirst($sale['payment_method']) ?></p>
                <p><strong>Status:</strong> <?= ucfirst($sale['payment_status']) ?></p>
               
            </div>
        </div>

        <h4>Items</h4>
        <table class="table table-bordered">
            <thead>
                <tr><th>Product</th><th>Quantity</th><th>Price</th><th>Total</th></tr>
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
                <tr><th colspan="3" class="text-end">Grand Total:</th><th>₱<?= number_format($sale['grand_total'], 2) ?></th></tr>
            </tfoot>
        </table>

        <a href="<?= base_url('/sales/invoice/'.$sale['id']) ?>" class="btn btn-primary" target="_blank">Print Invoice</a>
        <a href="<?= base_url('/sales') ?>" class="btn btn-secondary">Back</a>
    </div>
</div>

<?= $this->endSection() ?>