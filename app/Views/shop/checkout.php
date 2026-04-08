<?= $this->extend('layout/shop_layout') ?>
<?= $this->section('content') ?>

<h2>Checkout</h2>
<div class="row g-4">
    <div class="col-md-6">
        <div class="card glass-card">
            <div class="card-header bg-transparent">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Order Summary</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <?php foreach($cart as $item): ?>
                        <tr>
                            <td><?= esc($item['name']) ?> x<?= $item['quantity'] ?></td>
                            <td class="text-end">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="table-active">
                            <th>Total</th>
                            <th class="text-end">₱<?= number_format($total, 2) ?></th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card glass-card">
            <div class="card-header bg-transparent">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Customer Information</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/checkout/process') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Your Name *</label>
                        <input type="text" name="customer_name" class="form-control" value="<?= session()->get('customer_name') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-select">
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="online">Online</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes (optional)</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100 py-2">Place Order <i class="fas fa-check-circle"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>