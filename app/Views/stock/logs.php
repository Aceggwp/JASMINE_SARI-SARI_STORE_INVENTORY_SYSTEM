<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<h2>Stock Movement Logs</h2>

<table class="table table-bordered datatable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>User</th>
            <th>Change</th>
            <th>Previous Qty</th>
            <th>New Qty</th>
            <th>Type</th>
            <th>Reason</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($logs as $log): ?>
        <tr>
            <td><?= $log['id'] ?></td>
            <td><?= esc($log['product_name']) ?></td>
            <td><?= esc($log['user_name'] ?? 'System') ?></td>
            <td class="<?= $log['quantity_change'] < 0 ? 'text-danger' : 'text-success' ?>">
                <?= ($log['quantity_change'] > 0 ? '+' : '') . $log['quantity_change'] ?>
            </td>
            <td><?= $log['previous_quantity'] ?></td>
            <td><?= $log['new_quantity'] ?></td>
            <td><?= ucfirst($log['type']) ?></td>
            <td><?= esc($log['reason']) ?></td>
            <td><?= date('Y-m-d H:i:s', strtotime($log['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>