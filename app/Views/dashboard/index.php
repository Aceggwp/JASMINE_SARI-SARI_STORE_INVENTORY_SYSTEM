<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<h2>Dashboard</h2>

<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Products</h5>
                <h3><?= $total_products ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Categories</h5>
                <h3><?= $total_categories ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Sales Today</h5>
                <h3><?= $total_sales_today ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body">
                <h5 class="card-title">Low Stock Items</h5>
                <h3><?= $low_stock_products ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Recent Sales</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr><th>Invoice</th><th>Amount</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($recent_sales as $sale): ?>
                        <tr>
                            <td><?= $sale['invoice_no'] ?></td>
                            <td>₱<?= number_format($sale['grand_total'], 2) ?></td>
                            <td><?= date('Y-m-d H:i', strtotime($sale['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Top Selling Products</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr><th>Product</th><th>Units Sold</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($top_products as $product): ?>
                        <tr>
                            <td><?= $product['name'] ?></td>
                            <td><?= $product['total_sold'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>