<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart - Jasmine Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/shop') ?>">Jasmine Sari Sari Store</a>
            <a href="<?= base_url('/cart') ?>" class="btn btn-outline-light">
                <i class="fas fa-shopping-cart"></i> Cart
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Shopping Cart</h2>
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if(empty($cart)): ?>
            <div class="alert alert-info">Your cart is empty. <a href="<?= base_url('/shop') ?>">Continue shopping</a></div>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th></th></tr>
                </thead>
                <tbody>
                    <?php foreach($cart as $item): ?>
                    <tr>
                        <td><?= esc($item['name']) ?></td>
                        <td>₱<?= number_format($item['price'], 2) ?></td>
                        <td>
                            <form action="<?= base_url('/cart/update') ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>" style="width:70px">
                                <button type="submit" class="btn btn-sm btn-secondary">Update</button>
                            </form>
                        </td>
                        <td>₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                        <td><a href="<?= base_url('/cart/remove/'.$item['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Remove item?')">Remove</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr><th colspan="3" class="text-end">Total:</th><th>₱<?= number_format($total, 2) ?></th><th></th></tr>
                </tfoot>
            </table>
            <a href="<?= base_url('/checkout') ?>" class="btn btn-success">Proceed to Checkout</a>
            <a href="<?= base_url('/shop') ?>" class="btn btn-secondary">Continue Shopping</a>
        <?php endif; ?>
    </div>
</body>
</html>