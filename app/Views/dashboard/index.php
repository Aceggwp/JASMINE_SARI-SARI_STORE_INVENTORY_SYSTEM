<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="dashboard-header mb-4">
    <h2 class="fw-bold animate-slide-down">Dashboard</h2>
    <p class="text-muted animate-slide-down" style="animation-delay: 0.1s;">Welcome back, <?= session()->get('full_name') ?>!</p>
</div>

<div class="row g-4">
    <!-- Total Products Card -->
    <div class="col-md-6 col-lg-3">
        <div class="card glass-card h-100 animate-fade-up">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-muted mb-0">Total Products</h6>
                    <i class="fas fa-boxes fa-2x" style="color: #a8e6cf;"></i>
                </div>
                <h2 class="display-5 fw-bold counter" data-target="<?= $total_products ?>">0</h2>
                <div class="progress-bar-container mt-3">
                    <div class="progress-label small">Stock utilization</div>
                    <div class="progress bg-light rounded-pill" style="height: 8px;">
                        <div class="progress-bar bg-gradient-green rounded-pill" style="width: 78%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Card -->
    <div class="col-md-6 col-lg-3">
        <div class="card glass-card h-100 animate-fade-up" style="animation-delay: 0.05s;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-muted mb-0">Categories</h6>
                    <i class="fas fa-tags fa-2x" style="color: #ffd3b6;"></i>
                </div>
                <h2 class="display-5 fw-bold counter" data-target="<?= $total_categories ?>">0</h2>
                <div class="progress-bar-container mt-3">
                    <div class="progress-label small">Active categories</div>
                    <div class="progress bg-light rounded-pill" style="height: 8px;">
                        <div class="progress-bar bg-gradient-warning rounded-pill" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Today Card -->
    <div class="col-md-6 col-lg-3">
        <div class="card glass-card h-100 animate-fade-up" style="animation-delay: 0.1s;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-muted mb-0">Sales Today</h6>
                    <i class="fas fa-chart-line fa-2x" style="color: #b5ead7;"></i>
                </div>
                <h2 class="display-5 fw-bold counter" data-target="<?= $total_sales_today ?>">0</h2>
                <div class="progress-bar-container mt-3">
                    <div class="progress-label small">Daily target: 20</div>
                    <div class="progress bg-light rounded-pill" style="height: 8px;">
                        <div class="progress-bar bg-gradient-blue rounded-pill" style="width: <?= min(100, ($total_sales_today / 20) * 100) ?>%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Items Card -->
    <div class="col-md-6 col-lg-3">
        <div class="card glass-card h-100 animate-fade-up" style="animation-delay: 0.15s;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-muted mb-0">Low Stock Items</h6>
                    <i class="fas fa-exclamation-triangle fa-2x" style="color: #ffaaa5;"></i>
                </div>
                <h2 class="display-5 fw-bold counter text-warning" data-target="<?= $low_stock_products ?>">0</h2>
                <div class="progress-bar-container mt-3">
                    <div class="progress-label small">Needs attention</div>
                    <div class="progress bg-light rounded-pill" style="height: 8px;">
                        <div class="progress-bar bg-gradient-danger rounded-pill" style="width: <?= $low_stock_products > 0 ? min(100, ($low_stock_products / $total_products) * 100) : 0 ?>%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4 g-4">
    <!-- Recent Sales Table -->
    <div class="col-lg-7">
        <div class="card glass-card animate-fade-up" style="animation-delay: 0.2s;">
            <div class="card-header bg-transparent border-0 pt-3">
                <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Recent Sales</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr><th>Invoice</th><th>Amount</th><th>Date</th></tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recent_sales)): ?>
                                <?php foreach($recent_sales as $sale): ?>
                                <tr class="animate-fade-in">
                                    <td class="fw-semibold"><?= esc($sale['invoice_no']) ?></td>
                                    <td>₱<?= number_format($sale['grand_total'], 2) ?></td>
                                    <td><small><?= date('M d, H:i', strtotime($sale['created_at'])) ?></small></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="3" class="text-center text-muted">No sales yet</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products Card -->
    <div class="col-lg-5">
        <div class="card glass-card animate-fade-up" style="animation-delay: 0.25s;">
            <div class="card-header bg-transparent border-0 pt-3">
                <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Top Selling Products</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($top_products)): ?>
                    <?php foreach($top_products as $index => $product): ?>
                    <div class="mb-3 animate-slide-right" style="animation-delay: <?= 0.3 + $index * 0.05 ?>s;">
                        <div class="d-flex justify-content-between mb-1">
                            <span><?= esc($product['name']) ?></span>
                            <span class="fw-bold"><?= $product['total_sold'] ?> units</span>
                        </div>
                        <div class="progress bg-light rounded-pill" style="height: 6px;">
                            <div class="progress-bar bg-gradient-green rounded-pill" style="width: <?= min(100, ($product['total_sold'] / max(array_column($top_products, 'total_sold'))) * 100) ?>%;"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center">No sales data yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>