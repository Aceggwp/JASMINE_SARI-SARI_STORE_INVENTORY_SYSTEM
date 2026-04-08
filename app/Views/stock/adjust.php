<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<h2>Adjust Stock</h2>

<form action="<?= base_url('/stock/adjust-store') ?>" method="post">
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="product_id" class="form-label">Product *</label>
                <select class="form-control" id="product_id" name="product_id" required>
                    <option value="">Select Product</option>
                    <?php foreach($products as $product): ?>
                    <option value="<?= $product['id'] ?>" <?= (isset($_GET['product_id']) && $_GET['product_id'] == $product['id']) ? 'selected' : '' ?>>
                        <?= esc($product['name']) ?> (Current: <?= $product['quantity'] ?>)
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Adjustment Type *</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="add">Add Stock</option>
                    <option value="remove">Remove Stock</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity *</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required min="1">
            </div>
            <div class="mb-3">
                <label for="reason" class="form-label">Reason</label>
                <textarea class="form-control" id="reason" name="reason" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Adjustment</button>
            <a href="<?= base_url('/stock') ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>

<?= $this->endSection() ?>