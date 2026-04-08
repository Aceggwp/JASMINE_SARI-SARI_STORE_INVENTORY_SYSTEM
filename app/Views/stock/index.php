<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between mb-3">
    <h2>Stock Levels</h2>
    <a href="<?= base_url('/stock/adjust') ?>" class="btn btn-warning">Adjust Stock</a>
</div>

<table class="table table-bordered datatable">
    <thead>
        <tr>
            <th>Product</th>
            <th>Category</th>
            <th>Current Stock</th>
            <th>Reorder Level</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($products as $product): ?>
        <tr>
            <td><?= esc($product['name']) ?></td>
            <td><?= esc($product['category_name'] ?? 'Uncategorized') ?></td>
            <td class="<?= $product['quantity'] <= $product['reorder_level'] ? 'text-danger fw-bold' : '' ?>">
                <?= $product['quantity'] ?>
            </td>
            <td><?= $product['reorder_level'] ?></td>
            <td><?= $product['status'] ? 'Active' : 'Inactive' ?></td>
            <td>
                <a href="<?= base_url('/stock/adjust') ?>?product_id=<?= $product['id'] ?>" class="btn btn-sm btn-primary">Adjust</a>
                <a href="<?= base_url('/stock/logs') ?>?product_id=<?= $product['id'] ?>" class="btn btn-sm btn-info">Logs</a>
             </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>