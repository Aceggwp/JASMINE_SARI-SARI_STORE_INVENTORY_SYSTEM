<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt - <?= $sale['invoice_no'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @media print {
            .no-print { display: none; }
            body { margin: 0; padding: 0; }
            .receipt-container { margin: 0; padding: 10px; }
        }
        body {
            background: #f5f5f5;
            font-family: 'Courier New', monospace;
        }
        .receipt-container {
            max-width: 350px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .receipt-header {
            text-align: center;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .receipt-footer {
            text-align: center;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
            margin-top: 10px;
            font-size: 12px;
        }
        table { width: 100%; font-size: 12px; }
        td { padding: 4px 0; }
        .text-end { text-align: right; }
        .fw-bold { font-weight: bold; }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <h4>Jasmine Sari Sari Store</h4>
            <p>123 Main Street, City<br>
            Tel: 123-456-7890</p>
            <h5>SALES RECEIPT</h5>
            <p><strong>Invoice:</strong> <?= $sale['invoice_no'] ?><br>
            <strong>Date:</strong> <?= date('Y-m-d H:i:s', strtotime($sale['created_at'])) ?><br>
            <strong>Cashier:</strong> <?= esc($sale['cashier'] ?? 'System') ?><br>
            <strong>Customer:</strong> <?= esc($sale['customer_name'] ?? 'Walk-in') ?></p>
        </div>
        
        <table>
            <thead>
                <tr><th>Item</th><th>Qty</th><th>Price</th><th>Total</th></tr>
            </thead>
            <tbody>
                <?php foreach($items as $item): ?>
                <tr>
                    <td><?= esc($item['product_name']) ?></td>
                    <td class="text-end"><?= $item['quantity'] ?></td>
                    <td class="text-end">₱<?= number_format($item['price'], 2) ?></td>
                    <td class="text-end">₱<?= number_format($item['total'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="mt-3">
            <div class="d-flex justify-content-between">
                <span>Subtotal:</span>
                <span>₱<?= number_format($sale['total_amount'], 2) ?></span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Discount:</span>
                <span>₱<?= number_format($sale['discount'], 2) ?></span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Tax (12%):</span>
                <span>₱<?= number_format($sale['tax'], 2) ?></span>
            </div>
            <div class="d-flex justify-content-between fw-bold mt-2 pt-2 border-top">
                <span>GRAND TOTAL:</span>
                <span>₱<?= number_format($sale['grand_total'], 2) ?></span>
            </div>
        </div>
        
        <div class="receipt-footer">
            <p>Thank you for your purchase!<br>
            Please come again</p>
        </div>
        
        <div class="no-print text-center mt-3">
            <button class="btn btn-primary btn-sm" onclick="window.print()">
                <i class="fas fa-print"></i> Print Receipt
            </button>
            <button class="btn btn-secondary btn-sm" onclick="window.location.href='<?= base_url('/pos') ?>'">
                <i class="fas fa-arrow-left"></i> New Sale
            </button>
        </div>
    </div>
</body>
</html>