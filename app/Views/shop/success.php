<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Success - Jasmine Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5 text-center">
        <div class="card shadow p-5">
            <i class="fas fa-check-circle text-success fa-5x mb-3"></i>
            <h2>Thank you for your order!</h2>
            <p>Your invoice number: <strong><?= esc($sale['invoice_no']) ?></strong></p>
            <p>Total amount: <strong>₱<?= number_format($sale['grand_total'], 2) ?></strong></p>
            <p>You will receive a confirmation email shortly.</p>
            <a href="<?= base_url('/shop') ?>" class="btn btn-primary">Continue Shopping</a>
        </div>
    </div>
</body>
</html>