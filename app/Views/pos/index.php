<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .pos-container {
        display: flex;
        gap: 20px;
        min-height: calc(100vh - 200px);
    }
    .products-panel {
        flex: 2;
        background: var(--card-bg);
        border-radius: 20px;
        padding: 20px;
        box-shadow: var(--shadow-sm);
    }
    .cart-panel {
        flex: 1.2;
        background: var(--card-bg);
        border-radius: 20px;
        padding: 20px;
        box-shadow: var(--shadow-sm);
        position: sticky;
        top: 20px;
        height: fit-content;
        max-height: calc(100vh - 100px);
        overflow-y: auto;
    }
    .product-card {
        cursor: pointer;
        transition: all 0.2s;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 10px;
        background: var(--bg-secondary);
    }
    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        border-color: var(--btn-primary-bg);
    }
    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid var(--border-color);
    }
    .quantity-control {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .quantity-control button {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: none;
        background: var(--btn-primary-bg);
        cursor: pointer;
        font-weight: bold;
    }
    .total-row {
        font-size: 1.2rem;
        font-weight: bold;
        padding: 15px 0;
        border-top: 2px solid var(--border-color);
    }
    .search-box {
        margin-bottom: 20px;
    }
    .badge-low-stock {
        background: #ffaaa5;
        color: #fff;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 10px;
    }
    .product-price {
        font-size: 1.2rem;
        font-weight: bold;
        color: var(--btn-primary-bg);
    }
    .receipt-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
    }
</style>

<div class="pos-container">
    <!-- Products Panel -->
    <div class="products-panel">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><i class="fas fa-box"></i> Products</h4>
            <button class="btn btn-sm btn-outline-secondary" onclick="loadProducts()">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
        </div>
        
        <div class="search-box">
            <input type="text" id="searchProduct" class="form-control" placeholder="Search products by name...">
        </div>
        
        <div class="row" id="productsGrid">
            <?php foreach($products as $product): ?>
            <div class="col-md-6 col-lg-4">
                <div class="product-card" onclick="addToCart(<?= $product['id'] ?>, '<?= addslashes($product['name']) ?>', <?= $product['price'] ?>, <?= $product['quantity'] ?>)">
                    <h6 class="mb-1"><?= esc($product['name']) ?></h6>
                    <p class="product-price mb-1">₱<?= number_format($product['price'], 2) ?></p>
                    <small class="text-muted">Stock: <?= $product['quantity'] ?></small>
                    <?php if($product['quantity'] <= 5): ?>
                        <span class="badge-low-stock ms-2">Low Stock</span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Cart Panel -->
    <div class="cart-panel">
        <h4><i class="fas fa-shopping-cart"></i> Cart</h4>
        <div id="cartItems">
            <?php if(empty($cart)): ?>
                <p class="text-muted text-center">No items in cart</p>
            <?php else: ?>
                <?php foreach($cart as $item): ?>
                <div class="cart-item" data-id="<?= $item['id'] ?>">
                    <div class="flex-grow-1">
                        <strong><?= esc($item['name']) ?></strong><br>
                        <small>₱<?= number_format($item['price'], 2) ?> x <?= $item['quantity'] ?></small>
                    </div>
                    <div>
                        <div class="quantity-control">
                            <button onclick="updateQuantity(<?= $item['id'] ?>, -1)">-</button>
                            <span><?= $item['quantity'] ?></span>
                            <button onclick="updateQuantity(<?= $item['id'] ?>, 1)">+</button>
                            <button class="btn btn-sm btn-danger ms-2" onclick="removeItem(<?= $item['id'] ?>)">×</button>
                        </div>
                        <div class="text-end mt-1 fw-bold">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div id="cartSummary" <?= empty($cart) ? 'style="display:none"' : '' ?>>
            <div class="total-row">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span>₱<span id="subtotal"><?= number_format($cartTotal, 2) ?></span></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Discount:</span>
                    <input type="number" id="discount" class="form-control form-control-sm" style="width: 120px;" value="0" step="10">
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Tax (12%):</span>
                    <span>₱<span id="tax">0.00</span></span>
                </div>
                <div class="d-flex justify-content-between mt-2 pt-2 border-top">
                    <strong>Grand Total:</strong>
                    <strong>₱<span id="grandTotal"><?= number_format($cartTotal, 2) ?></span></strong>
                </div>
            </div>
            
            <div class="mt-3">
                <label>Customer Name</label>
                <input type="text" id="customerName" class="form-control mb-2" placeholder="Walk-in Customer">
                
                <label>Payment Method</label>
                <select id="paymentMethod" class="form-control mb-2">
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                    <option value="online">Online</option>
                </select>
                
                <label>Amount Paid</label>
                <input type="number" id="paidAmount" class="form-control mb-2" value="0" step="1">
                
                <div class="alert alert-info small" id="changeDisplay">Change: ₱0.00</div>
                
                <button class="btn btn-success w-100" onclick="checkout()">
                    <i class="fas fa-check-circle"></i> Complete Sale
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let cart = <?= json_encode(array_values($cart)) ?>;

function addToCart(id, name, price, stock) {
    const existing = cart.find(item => item.id === id);
    if (existing) {
        if (existing.quantity + 1 > stock) {
            alert('Insufficient stock!');
            return;
        }
        existing.quantity++;
    } else {
        cart.push({ id, name, price, quantity: 1, stock });
    }
    updateCartDisplay();
}

function updateQuantity(id, change) {
    const item = cart.find(item => item.id === id);
    if (item) {
        const newQty = item.quantity + change;
        if (newQty < 1) {
            cart = cart.filter(i => i.id !== id);
        } else if (newQty > item.stock) {
            alert('Insufficient stock!');
            return;
        } else {
            item.quantity = newQty;
        }
        updateCartDisplay();
    }
}

function removeItem(id) {
    cart = cart.filter(item => item.id !== id);
    updateCartDisplay();
}

function updateCartDisplay() {
    const cartDiv = document.getElementById('cartItems');
    const summaryDiv = document.getElementById('cartSummary');
    
    if (cart.length === 0) {
        cartDiv.innerHTML = '<p class="text-muted text-center">No items in cart</p>';
        summaryDiv.style.display = 'none';
        return;
    }
    
    summaryDiv.style.display = 'block';
    let html = '';
    let subtotal = 0;
    
    cart.forEach(item => {
        const total = item.price * item.quantity;
        subtotal += total;
        html += `
            <div class="cart-item" data-id="${item.id}">
                <div class="flex-grow-1">
                    <strong>${escapeHtml(item.name)}</strong><br>
                    <small>₱${item.price.toFixed(2)} x ${item.quantity}</small>
                </div>
                <div>
                    <div class="quantity-control">
                        <button onclick="updateQuantity(${item.id}, -1)">-</button>
                        <span>${item.quantity}</span>
                        <button onclick="updateQuantity(${item.id}, 1)">+</button>
                        <button class="btn btn-sm btn-danger ms-2" onclick="removeItem(${item.id})">×</button>
                    </div>
                    <div class="text-end mt-1 fw-bold">₱${total.toFixed(2)}</div>
                </div>
            </div>
        `;
    });
    
    cartDiv.innerHTML = html;
    
    // Update totals
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const taxAmount = subtotal * 0.12;
    const grandTotal = subtotal - discount + taxAmount;
    
    document.getElementById('subtotal').innerText = subtotal.toFixed(2);
    document.getElementById('tax').innerText = taxAmount.toFixed(2);
    document.getElementById('grandTotal').innerText = grandTotal.toFixed(2);
    
    // Update change
    const paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;
    const change = paidAmount - grandTotal;
    document.getElementById('changeDisplay').innerHTML = `Change: ₱${change.toFixed(2)}`;
    if (change >= 0) {
        document.getElementById('changeDisplay').className = 'alert alert-success small';
    } else {
        document.getElementById('changeDisplay').className = 'alert alert-danger small';
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

document.getElementById('discount').addEventListener('input', updateCartDisplay);
document.getElementById('paidAmount').addEventListener('input', updateCartDisplay);

document.getElementById('searchProduct').addEventListener('keyup', function(e) {
    const search = e.target.value.toLowerCase();
    document.querySelectorAll('.product-card').forEach(card => {
        const text = card.innerText.toLowerCase();
        card.closest('.col-md-6').style.display = text.includes(search) ? '' : 'none';
    });
});

function checkout() {
    if (cart.length === 0) {
        alert('Cart is empty');
        return;
    }
    
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const paymentMethod = document.getElementById('paymentMethod').value;
    const customerName = document.getElementById('customerName').value;
    const paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;
    
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const grandTotal = subtotal - discount + (subtotal * 0.12);
    
    if (paidAmount < grandTotal) {
        alert('Insufficient payment amount!');
        return;
    }
    
    if (confirm(`Complete sale for ₱${grandTotal.toFixed(2)}?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url("/pos/checkout") ?>';
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '<?= csrf_token() ?>';
        csrf.value = '<?= csrf_hash() ?>';
        form.appendChild(csrf);
        
        const cartInput = document.createElement('input');
        cartInput.type = 'hidden';
        cartInput.name = 'cart_data';
        cartInput.value = JSON.stringify(cart);
        form.appendChild(cartInput);
        
        const fields = { customer_name: customerName, payment_method: paymentMethod, discount: discount, paid_amount: paidAmount };
        for (let [key, value] of Object.entries(fields)) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            form.appendChild(input);
        }
        
        document.body.appendChild(form);
        form.submit();
    }
}

function loadProducts() {
    location.reload();
}
</script>

<?= $this->endSection() ?>