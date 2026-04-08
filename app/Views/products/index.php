<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between mb-3">
    <h2>Products</h2>
    <a href="<?= base_url('/products/create') ?>" class="btn btn-primary">Add Product</a>
</div>

<table class="table table-bordered datatable">
    <thead>
        <tr>
            <th>ID</th><th>Name</th><th>SKU</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($products as $product): ?>
        <tr>
            <td><?= $product['id'] ?></td>
            <td><?= esc($product['name']) ?></td>
            <td><?= esc($product['sku']) ?></td>
            <td><?= esc($product['category_name'] ?? 'Uncategorized') ?></td>
            <td>₱<?= number_format($product['price'], 2) ?></td>
            <td class="<?= ($product['quantity'] <= $product['reorder_level']) ? 'text-danger' : '' ?>">
                <?= $product['quantity'] ?>
            </td>
            <td><?= $product['status'] ? 'Active' : 'Inactive' ?></td>
            <td>
                <a href="<?= base_url('/products/edit/'.$product['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="<?= base_url('/products/delete/'.$product['id']) ?>" 
   class="btn btn-sm btn-danger" 
   onclick="return confirm('Delete product?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>