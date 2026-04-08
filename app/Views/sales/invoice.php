<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - <?= $sale['invoice_no'] ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .invoice-header { text-align: center; margin-bottom: 30px; }
        .invoice-details { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; }
        .text-right { text-align: right; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom:20px;">
        <button onclick="window.print()">Print Invoice</button>
        <button onclick="window.close()">Close</button>
    </div>
    <div class="invoice-header">
        <h2>Jasmine Sari Sari Store</h2>
        <p>123 Main Street, City</p>
        <p>Tel: 123-456-7890</p>
        <h3>SALES INVOICE</h3>
    </div>
    <div class="invoice-details">
        <p><strong>Invoice No:</strong> <?= $sale['invoice_no'] ?></p>
        <p><strong>Date:</strong> <?= date('F d, Y h:i A', strtotime($sale['created_at'])) ?></p>
        <p><strong>Cashier:</strong> <?= esc($sale['cashier'] ?? 'N/A') ?></p>
        <p><strong>Customer:</strong> <?= esc($sale['customer_name'] ?? 'Walk-in') ?></p>
    </div>
    <table>
        <thead>
            <tr><th>Product</th><th>Quantity</th><th>Price</th><th>Total</th></tr>
        </thead>
        <tbody>
            <?php foreach($items as $item): ?>
            <tr>
                <td><?= esc($item['product_name']) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td>₱<?= number_format($item['price'], 2) ?></td>
                <td>₱<?= number_format($item['total'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr><td colspan="3" class="text-right"><strong>Subtotal:</strong></td><td>₱<?= number_format($sale['total_amount'], 2) ?></td></tr>
            <tr><td colspan="3" class="text-right"><strong>Discount:</strong></td><td>₱<?= number_format($sale['discount'], 2) ?></td></tr>
            <tr><td colspan="3" class="text-right"><strong>Tax:</strong></td><td>₱<?= number_format($sale['tax'], 2) ?></td></tr>
            <tr><td colspan="3" class="text-right"><strong>GRAND TOTAL:</strong></td><td><strong>₱<?= number_format($sale['grand_total'], 2) ?></strong></td></tr>
        </tfoot>
    </table>
    <p style="margin-top:30px;">Thank you for your purchase!</p>
</body>
</html>