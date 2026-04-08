<?= $this->extend('layout/shop_layout') ?>
<?= $this->section('content') ?>

<h2>Shopping Cart</h2>
<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if(empty($cart)): ?>
    <div class="card glass-card text-center p-5">
        <i class="fas fa-shopping-cart fa-4x mb-3 opacity-50"></i>
        <h4>Your cart is empty</h4>
        <a href="<?= base_url('/shop') ?>" class="btn btn-primary mt-3">Continue Shopping</a>
    </div>
<?php else: ?>
    <div class="card glass-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th></th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($cart as $item): ?>
                        <tr class="animate-fade-in">
                            <td><?= esc($item['name']) ?></td>
                            <td>₱<?= number_format($item['price'], 2) ?></td>
                            <td>
                                <form action="<?= base_url('/cart/update') ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>" class="form-control" style="width:80px; display:inline-block;">
                                    <button type="submit" class="btn btn-sm btn-outline-primary ms-2">Update</button>
                                </form>
                            </td>
                            <td>₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                            <td><a href="<?= base_url('/cart/remove/'.$item['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove item?')">Remove</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="table-active">
                            <th colspan="3" class="text-end">Total:</th>
                            <th>₱<?= number_format($total, 2) ?></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="d-flex justify-content-between mt-3">
                <a href="<?= base_url('/shop') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
                <a href="<?= base_url('/checkout') ?>" class="btn btn-success">Proceed to Checkout <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>