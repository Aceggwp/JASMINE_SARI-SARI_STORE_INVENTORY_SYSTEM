<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="dashboard-header mb-4">
    <h2 class="fw-bold">Dashboard Overview</h2>
    <p class="text-secondary">Welcome back, <?= session()->get('full_name') ?>! Here's what's happening today.</p>
</div>

<div class="row g-4 mb-4">
    <!-- Sales Chart -->
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-chart-bar me-2"></i>Sales Performance</span>
                <select class="form-select form-select-sm glass-input" style="width: 120px;">
                    <option>Last 7 Days</option>
                    <option>This Month</option>
                </select>
            </div>
            <div class="card-body">
                <div style="height: 300px;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="col-lg-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="card" style="background: linear-gradient(135deg, rgba(72, 187, 120, 0.2) 0%, rgba(56, 161, 105, 0.1) 100%);">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 me-3" style="background: rgba(72, 187, 120, 0.2);">
                            <i class="fas fa-shopping-cart text-success fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-secondary mb-0">Total Products</h6>
                            <h3 class="fw-bold mb-0 counter" data-target="<?= $total_products ?>">0</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card" style="background: linear-gradient(135deg, rgba(66, 153, 225, 0.2) 0%, rgba(49, 130, 206, 0.1) 100%);">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 me-3" style="background: rgba(66, 153, 225, 0.2);">
                            <i class="fas fa-money-bill-wave text-primary fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-secondary mb-0">Sales Today</h6>
                            <h3 class="fw-bold mb-0">₱<span class="counter" data-target="<?= $revenue_today ?>">0</span></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card" style="background: linear-gradient(135deg, rgba(245, 101, 101, 0.2) 0%, rgba(229, 62, 62, 0.1) 100%);">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle p-3 me-3" style="background: rgba(245, 101, 101, 0.2);">
                            <i class="fas fa-exclamation-circle text-danger fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-secondary mb-0">Low Stock</h6>
                            <h3 class="fw-bold mb-0 text-danger counter" data-target="<?= $low_stock_products ?>">0</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Sales -->
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-history me-2"></i>Recent Transactions
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr><th>Invoice</th><th>Grand Total</th><th>Date</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach($recent_sales as $sale): ?>
                            <tr>
                                <td class="fw-bold"><?= $sale['invoice_no'] ?></td>
                                <td>₱<?= number_format($sale['grand_total'], 2) ?></td>
                                <td><?= date('M d, Y', strtotime($sale['created_at'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products -->
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-star me-2"></i>Top Products
            </div>
            <div class="card-body">
                <?php foreach($top_products as $product): ?>
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-secondary"><?= $product['name'] ?></span>
                        <span class="fw-bold"><?= $product['total_sold'] ?> Sold</span>
                    </div>
                    <div class="progress" style="height: 8px; background: rgba(0,0,0,0.05);">
                        <div class="progress-bar" style="width: <?= min(100, ($product['total_sold'] / 50) * 100) ?>%; background: var(--btn-primary-bg); border-radius: 10px;"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('salesChart').getContext('2d');
    
    // Gradient for the bars
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(72, 187, 120, 0.8)');
    gradient.addColorStop(1, 'rgba(72, 187, 120, 0.2)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= $chart_labels ?>,
            datasets: [{
                label: 'Sales (₱)',
                data: <?= $chart_data ?>,
                backgroundColor: gradient,
                borderRadius: 12,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { display: false },
                    ticks: { color: '#94a3b8' }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8' }
                }
            }
        }
    });
});
</script>

<?= $this->endSection() ?>