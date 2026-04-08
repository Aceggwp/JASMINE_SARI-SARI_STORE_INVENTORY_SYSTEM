<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<h2><?= isset($product) ? 'Edit' : 'Add' ?> Product</h2>

<form action="<?= isset($product) ? base_url('/products/update/'.$product['id']) : base_url('/products/store') ?>" method="post">
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name *</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $product['name'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="sku" class="form-label">SKU</label>
                <input type="text" class="form-control" id="sku" name="sku" value="<?= $product['sku'] ?? '' ?>">
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-control" id="category_id" name="category_id">
                    <option value="">Select Category</option>
                    <?php foreach($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= (isset($product) && $product['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                        <?= esc($cat['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= $product['description'] ?? '' ?></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="price" class="form-label">Selling Price *</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= $product['price'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="cost_price" class="form-label">Cost Price</label>
                <input type="number" step="0.01" class="form-control" id="cost_price" name="cost_price" value="<?= $product['cost_price'] ?? '' ?>">
            </div>
            <?php if(!isset($product)): ?>
            <div class="mb-3">
                <label for="quantity" class="form-label">Initial Stock</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="0">
            </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="reorder_level" class="form-label">Reorder Level</label>
                <input type="number" class="form-control" id="reorder_level" name="reorder_level" value="<?= $product['reorder_level'] ?? 5 ?>">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="1" <?= (isset($product) && $product['status'] == 1) ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= (isset($product) && $product['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="<?= base_url('/products') ?>" class="btn btn-secondary">Cancel</a>
</form>

<?= $this->endSection() ?><?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<h2><?= isset($product) ? 'Edit' : 'Add' ?> Product</h2>

<form action="<?= isset($product) ? base_url('/products/update/'.$product['id']) : base_url('/products/store') ?>" method="post">
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name *</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $product['name'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="sku" class="form-label">SKU</label>
                <input type="text" class="form-control" id="sku" name="sku" value="<?= $product['sku'] ?? '' ?>">
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-control" id="category_id" name="category_id">
                    <option value="">Select Category</option>
                    <?php foreach($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= (isset($product) && $product['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                        <?= esc($cat['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= $product['description'] ?? '' ?></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="price" class="form-label">Selling Price *</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= $product['price'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="cost_price" class="form-label">Cost Price</label>
                <input type="number" step="0.01" class="form-control" id="cost_price" name="cost_price" value="<?= $product['cost_price'] ?? '' ?>">
            </div>
            <?php if(!isset($product)): ?>
            <div class="mb-3">
                <label for="quantity" class="form-label">Initial Stock</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="0">
            </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="reorder_level" class="form-label">Reorder Level</label>
                <input type="number" class="form-control" id="reorder_level" name="reorder_level" value="<?= $product['reorder_level'] ?? 5 ?>">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="1" <?= (isset($product) && $product['status'] == 1) ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= (isset($product) && $product['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="<?= base_url('/products') ?>" class="btn btn-secondary">Cancel</a>
</form>

<?= $this->endSection() ?><?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<h2><?= isset($product) ? 'Edit' : 'Add' ?> Product</h2>

<form action="<?= isset($product) ? base_url('/products/update/'.$product['id']) : base_url('/products/store') ?>" method="post">
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name *</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $product['name'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="sku" class="form-label">SKU</label>
                <input type="text" class="form-control" id="sku" name="sku" value="<?= $product['sku'] ?? '' ?>">
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-control" id="category_id" name="category_id">
                    <option value="">Select Category</option>
                    <?php foreach($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= (isset($product) && $product['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                        <?= esc($cat['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= $product['description'] ?? '' ?></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="price" class="form-label">Selling Price *</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= $product['price'] ?? '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="cost_price" class="form-label">Cost Price</label>
                <input type="number" step="0.01" class="form-control" id="cost_price" name="cost_price" value="<?= $product['cost_price'] ?? '' ?>">
            </div>
            <?php if(!isset($product)): ?>
            <div class="mb-3">
                <label for="quantity" class="form-label">Initial Stock</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="0">
            </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="reorder_level" class="form-label">Reorder Level</label>
                <input type="number" class="form-control" id="reorder_level" name="reorder_level" value="<?= $product['reorder_level'] ?? 5 ?>">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="1" <?= (isset($product) && $product['status'] == 1) ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= (isset($product) && $product['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="<?= base_url('/products') ?>" class="btn btn-secondary">Cancel</a>
</form>

<?= $this->endSection() ?>