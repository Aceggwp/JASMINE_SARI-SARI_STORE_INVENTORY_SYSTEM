<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<h2><?= isset($product) ? 'Edit' : 'Add' ?> Product</h2>

<form action="<?= isset($product) ? base_url('/products/update/'.$product['id']) : base_url('/products/store') ?>" method="post">
    <?= csrf_field() ?>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label>Name *</label>
                <input type="text" name="name" class="form-control" value="<?= $product['name'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label>SKU</label>
                <input type="text" name="sku" class="form-control" value="<?= $product['sku'] ?? '' ?>">
            </div>
            <div class="mb-3">
                <label>Category</label>
                <select name="category_id" class="form-control">
                    <option value="">Select</option>
                    <?php foreach($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= (isset($product) && $product['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                        <?= esc($cat['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3"><?= $product['description'] ?? '' ?></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label>Price *</label>
                <input type="number" step="0.01" name="price" class="form-control" value="<?= $product['price'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label>Cost Price</label>
                <input type="number" step="0.01" name="cost_price" class="form-control" value="<?= $product['cost_price'] ?? '' ?>">
            </div>
            <?php if(!isset($product)): ?>
            <div class="mb-3">
                <label>Initial Stock</label>
                <input type="number" name="quantity" class="form-control" value="0">
            </div>
            <?php endif; ?>
            <div class="mb-3">
                <label>Reorder Level</label>
                <input type="number" name="reorder_level" class="form-control" value="<?= $product['reorder_level'] ?? 5 ?>">
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" <?= (isset($product) && $product['status']==1) ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= (isset($product) && $product['status']==0) ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="<?= base_url('/products') ?>" class="btn btn-secondary">Cancel</a>
</form>

<?= $this->endSection() ?>