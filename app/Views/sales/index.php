<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between mb-3">
    <h2>Sales Transactions</h2>
    <a href="<?= base_url('/pos') ?>" class="btn btn-primary">New Sale</a>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>Invoice No</th>
                        <th>Cashier</th>
                        <th>Customer</th>
                        <th>Total Amount</th>
                        <th>Grand Total</th>
                        <th>Payment Method</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($sales)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No sales transactions found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($sales as $sale): ?>
                        <tr>
                            <td class="fw-bold text-primary"><?= esc($sale['invoice_no']) ?></td>
                            <td><?= esc($sale['cashier'] ?? 'N/A') ?></td>
                            <td><?= esc($sale['customer_name'] ?? 'Walk-in') ?></td>
                            <td>₱<?= number_format($sale['total_amount'], 2) ?></td>
                            <td><span class="badge bg-success">₱<?= number_format($sale['grand_total'], 2) ?></span></td>
                            <td><span class="badge bg-info"><?= ucfirst($sale['payment_method']) ?></span></td>
                            <td><?= date('Y-m-d H:i', strtotime($sale['created_at'])) ?></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= base_url('/sales/'.$sale['id']) ?>" class="btn btn-outline-info" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('/pos/receipt/'.$sale['id']) ?>" class="btn btn-outline-secondary" target="_blank" title="Print Receipt">
                                        <i class="fas fa-receipt"></i>
                                    </a>
                                    <a href="<?= base_url('/sales/delete/'.$sale['id']) ?>" class="btn btn-outline-danger" onclick="return confirm('Delete this sale?')" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
