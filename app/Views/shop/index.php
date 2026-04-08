<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Jasmine Sari Sari Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
    <style>
        .product-card { transition: transform 0.2s; margin-bottom: 20px; }
        .product-card:hover { transform: translateY(-5px); }
        .stock-badge { position: absolute; top: 10px; right: 10px; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/shop') ?>">Jasmine Sari Sari Store</a>
            <a href="<?= base_url('/cart') ?>" class="btn btn-outline-light">
                <i class="fas fa-shopping-cart"></i> Cart
                <span class="badge bg-danger" id="cart-count"><?= count(session()->get('cart') ?? []) ?></span>
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Our Products</h2>
        <div class="row">
            <?php foreach($products as $product): ?>
            <div class="col-md-4 col-lg-3">
                <div class="card product-card h-100 position-relative">
                    <div class="card-body">
                        <h5 class="card-title"><?= esc($product['name']) ?></h5>
                        <p class="card-text text-muted">₱<?= number_format($product['price'], 2) ?></p>
                        <p class="small">Stock: <?= $product['quantity'] ?></p>
                        <form action="<?= base_url('/cart/add') ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <div class="input-group">
                                <input type="number" name="quantity" value="1" min="1" max="<?= $product['quantity'] ?>" class="form-control">
                                <button type="submit" class="btn btn-primary" <?= $product['quantity'] <= 0 ? 'disabled' : '' ?>>
                                    <i class="fas fa-cart-plus"></i> Add
                                </button>
                            </div>
                        </form>
                    </div>
                    <?php if($product['quantity'] <= 0): ?>
                        <span class="badge bg-danger stock-badge">Out of Stock</span>
                    <?php elseif($product['quantity'] <= 5): ?>
                        <span class="badge bg-warning stock-badge">Low Stock</span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>