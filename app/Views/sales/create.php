<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<h2>New Sale</h2>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Cart Items</h5>
            </div>
            <div class="card-body">
                <table class="table" id="cart-table">
                    <thead>
                        <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th>Action</th></tr>
                    </thead>
                    <tbody id="cart-body"></tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Sale Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label>Customer Name</label>
                    <input type="text" id="customer_name" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Payment Method</label>
                    <select id="payment_method" class="form-control">
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                        <option value="online">Online</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Discount</label>
                    <input type="number" id="discount" class="form-control" value="0">
                </div>
                <div class="mb-3">
                    <label>Tax</label>
                    <input type="number" id="tax" class="form-control" value="0">
                </div>
                <hr>
                <div class="mb-3">
                    <strong>Subtotal: ₱<span id="subtotal">0.00</span></strong>
                </div>
                <div class="mb-3">
                    <strong>Grand Total: ₱<span id="grand_total">0.00</span></strong>
                </div>
                <button type="button" class="btn btn-success w-100" onclick="submitSale()">Complete Sale</button>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Add Product</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <select id="product_id" class="form-control">
                            <option value="">Select Product</option>
                            <?php foreach($products as $product): ?>
                            <option value="<?= $product['id'] ?>" data-price="<?= $product['price'] ?>" data-stock="<?= $product['quantity'] ?>">
                                <?= $product['name'] ?> (Stock: <?= $product['quantity'] ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" id="quantity" class="form-control" placeholder="Quantity" min="1">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary" onclick="addToCart()">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="sale-form" action="<?= base_url('/sales/store') ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="cart" id="cart-input">
    <input type="hidden" name="customer_name" id="customer_name_input">
    <input type="hidden" name="payment_method" id="payment_method_input">
    <input type="hidden" name="discount" id="discount_input">
    <input type="hidden" name="tax" id="tax_input">
</form>

<script>
let cart = [];

function addToCart() {
    const productSelect = document.getElementById('product_id');
    const productId = productSelect.value;
    const productName = productSelect.options[productSelect.selectedIndex]?.text;
    const price = parseFloat(productSelect.options[productSelect.selectedIndex]?.dataset.price);
    const stock = parseInt(productSelect.options[productSelect.selectedIndex]?.dataset.stock);
    const quantity = parseInt(document.getElementById('quantity').value);
    
    if (!productId || !quantity || quantity <= 0) {
        alert('Please select product and valid quantity');
        return;
    }
    
    if (quantity > stock) {
        alert('Insufficient stock! Available: ' + stock);
        return;
    }
    
    const existingItem = cart.find(item => item.product_id == productId);
    if (existingItem) {
        const newQty = existingItem.quantity + quantity;
        if (newQty > stock) {
            alert('Total quantity exceeds stock!');
            return;
        }
        existingItem.quantity = newQty;
        existingItem.total = existingItem.quantity * existingItem.price;
    } else {
        cart.push({
            product_id: productId,
            name: productName.split('(')[0],
            price: price,
            quantity: quantity,
            total: price * quantity
        });
    }
    
    updateCartDisplay();
    document.getElementById('quantity').value = '';
    productSelect.value = '';
}

function updateCartDisplay() {
    const tbody = document.getElementById('cart-body');
    tbody.innerHTML = '';
    let subtotal = 0;
    
    cart.forEach((item, index) => {
        subtotal += item.total;
        const row = tbody.insertRow();
        row.insertCell(0).innerHTML = item.name;
        row.insertCell(1).innerHTML = '₱' + item.price.toFixed(2);
        row.insertCell(2).innerHTML = `
            <input type="number" value="${item.quantity}" min="1" style="width:70px" onchange="updateQuantity(${index}, this.value)">
        `;
        row.insertCell(3).innerHTML = '₱' + item.total.toFixed(2);
        row.insertCell(4).innerHTML = `<button class="btn btn-sm btn-danger" onclick="removeFromCart(${index})">Remove</button>`;
    });
    
    document.getElementById('subtotal').innerHTML = subtotal.toFixed(2);
    updateGrandTotal();
}

function updateQuantity(index, newQuantity) {
    newQuantity = parseInt(newQuantity);
    if (newQuantity > 0) {
        cart[index].quantity = newQuantity;
        cart[index].total = cart[index].price * newQuantity;
        updateCartDisplay();
    }
}

function removeFromCart(index) {
    cart.splice(index, 1);
    updateCartDisplay();
}

function updateGrandTotal() {
    const subtotal = parseFloat(document.getElementById('subtotal').innerHTML);
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const tax = parseFloat(document.getElementById('tax').value) || 0;
    const grandTotal = subtotal - discount + tax;
    document.getElementById('grand_total').innerHTML = grandTotal.toFixed(2);
}

document.getElementById('discount').addEventListener('input', updateGrandTotal);
document.getElementById('tax').addEventListener('input', updateGrandTotal);

function submitSale() {
    if (cart.length === 0) {
        alert('Cart is empty');
        return;
    }
    
    document.getElementById('cart-input').value = JSON.stringify(cart);
    document.getElementById('customer_name_input').value = document.getElementById('customer_name').value;
    document.getElementById('payment_method_input').value = document.getElementById('payment_method').value;
    document.getElementById('discount_input').value = document.getElementById('discount').value;
    document.getElementById('tax_input').value = document.getElementById('tax').value;
    
    document.getElementById('sale-form').submit();
}
</script>

<?= $this->endSection() ?>