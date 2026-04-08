<?= $this->extend('layout/shop_layout') ?>
<?= $this->section('content') ?>

<h2 class="animate-slide-down">Our Products</h2>
<div class="row g-4 mt-2">
    <?php foreach($products as $product): ?>
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="card glass-card h-100 animate-fade-up product-card">
            <div class="card-body">
                <h5 class="card-title"><?= esc($product['name']) ?></h5>
                <p class="card-text text-muted">₱<?= number_format($product['price'], 2) ?></p>
                <div class="progress mb-3" style="height: 6px;">
                    <div class="progress-bar bg-gradient-green" style="width: <?= min(100, ($product['quantity'] / ($product['reorder_level']+10)) * 100) ?>%"></div>
                </div>
                <p class="small">Stock: <?= $product['quantity'] ?> units</p>
                <form action="<?= base_url('/cart/add') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <div class="input-group">
                        <input type="number" name="quantity" value="1" min="1" max="<?= $product['quantity'] ?>" class="form-control" style="border-radius: 40px 0 0 40px;">
                        <button type="submit" class="btn btn-primary" style="border-radius: 0 40px 40px 0;" <?= $product['quantity'] <= 0 ? 'disabled' : '' ?>>
                            <i class="fas fa-cart-plus"></i> Add
                        </button>
                    </div>
                </form>
            </div>
            <?php if($product['quantity'] <= 0): ?>
                <div class="card-footer bg-transparent border-0 pb-3">
                    <span class="badge bg-danger">Out of Stock</span>
                </div>
            <?php elseif($product['quantity'] <= 5): ?>
                <div class="card-footer bg-transparent border-0 pb-3">
                    <span class="badge bg-warning text-dark">Low Stock</span>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>