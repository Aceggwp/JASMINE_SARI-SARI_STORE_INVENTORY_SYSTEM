<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between mb-3">
    <h2>Sales Transactions</h2>
    <a href="<?= base_url('/sales/create') ?>" class="btn btn-primary">New Sale</a>
</div>

<table class="table table-bordered datatable">
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
        <?php foreach($sales as $sale): ?>
        <tr>
            <td><?= esc($sale['invoice_no']) ?></td>
            <td><?= esc($sale['cashier'] ?? 'N/A') ?></td>
            <td><?= esc($sale['customer_name'] ?? 'Walk-in') ?></td>
            <td>₱<?= number_format($sale['total_amount'], 2) ?></td>
            <td>₱<?= number_format($sale['grand_total'], 2) ?></td>
            <td><?= ucfirst($sale['payment_method']) ?></td>
            <td><?= date('Y-m-d H:i', strtotime($sale['created_at'])) ?></td>
            <td>
                <a href="<?= base_url('/sales/'.$sale['id']) ?>" class="btn btn-sm btn-info">View</a>
                <a href="<?= base_url('/sales/invoice/'.$sale['id']) ?>" class="btn btn-sm btn-secondary" target="_blank">Invoice</a>
                <a href="<?= base_url('/sales/delete/'.$sale['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this sale?')">Delete</a>
             </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?><?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between mb-3">
    <h2>Sales Transactions</h2>
    <a href="<?= base_url('/sales/create') ?>" class="btn btn-primary">New Sale</a>
</div>

<table class="table table-bordered datatable">
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
        <?php foreach($sales as $sale): ?>
        <tr>
            <td><?= esc($sale['invoice_no']) ?></td>
            <td><?= esc($sale['cashier'] ?? 'N/A') ?></td>
            <td><?= esc($sale['customer_name'] ?? 'Walk-in') ?></td>
            <td>₱<?= number_format($sale['total_amount'], 2) ?></td>
            <td>₱<?= number_format($sale['grand_total'], 2) ?></td>
            <td><?= ucfirst($sale['payment_method']) ?></td>
            <td><?= date('Y-m-d H:i', strtotime($sale['created_at'])) ?></td>
            <td>
                <a href="<?= base_url('/sales/'.$sale['id']) ?>" class="btn btn-sm btn-info">View</a>
                <a href="<?= base_url('/sales/invoice/'.$sale['id']) ?>" class="btn btn-sm btn-secondary" target="_blank">Invoice</a>
                <a href="<?= base_url('/sales/delete/'.$sale['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this sale?')">Delete</a>
             </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>