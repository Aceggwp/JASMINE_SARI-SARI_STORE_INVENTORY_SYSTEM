<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Jasmine Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/shop') ?>">Jasmine Sari Sari Store</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Checkout</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5>Order Summary</h5>
                        <table class="table table-sm">
                            <?php foreach($cart as $item): ?>
                            <tr><td><?= esc($item['name']) ?> x<?= $item['quantity'] ?></td><td class="text-end">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td></tr>
                            <?php endforeach; ?>
                            <tr><th>Total</th><th class="text-end">₱<?= number_format($total, 2) ?></th></tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5>Customer Information</h5>
                        <form action="<?= base_url('/checkout/process') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label>Your Name *</label>
                                <input type="text" name="customer_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Payment Method</label>
                                <select name="payment_method" class="form-control">
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="online">Online</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Notes (optional)</label>
                                <textarea name="notes" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>