<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="relative min-h-screen bg-gray-50 dark:bg-slate-900 pb-20">
    <!-- Cart Overlay -->
    <div id="cartOverlay" onclick="toggleCart()" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[2040] hidden transition-opacity duration-300"></div>

    <!-- Floating Cart Toggle -->
    <button id="cartToggleButton" onclick="toggleCart()" class="fixed right-8 bottom-24 w-16 h-16 rounded-full bg-emerald-500 text-white shadow-lg shadow-emerald-500/40 z-[2060] flex items-center justify-center hover:scale-110 active:scale-95 transition-all duration-300">
        <i class="fas fa-shopping-cart text-2xl"></i>
        <div id="cartBadge" class="absolute -top-1 -right-1 min-w-[24px] h-6 px-1.5 bg-red-500 text-white text-xs font-bold rounded-full border-2 border-white flex items-center justify-center shadow-sm">
            <?= array_sum(array_column($cart, 'quantity')) ?>
        </div>
    </button>

    <!-- Main Content -->
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white flex items-center gap-3">
                    <div class="p-2 bg-emerald-500 rounded-lg text-white">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    Point of Sale
                </h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Manage orders and process payments</p>
            </div>
            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="relative flex-grow md:min-w-[400px]">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400"></i>
                    </div>
                    <input type="text" id="searchProduct" 
                        class="block w-full pl-10 pr-3 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl leading-5 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all sm:text-sm" 
                        placeholder="Search products by name or barcode...">
                </div>
                <button onclick="location.reload()" class="p-2.5 text-slate-500 hover:text-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 rounded-xl transition-all">
                    <i class="fas fa-sync-alt text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6" id="productsGrid">
            <?php foreach($products as $product): ?>
            <div class="product-item group">
                <div class="bg-white/80 dark:bg-slate-800/50 backdrop-blur-md rounded-3xl border border-white/20 dark:border-slate-700/50 overflow-hidden hover:shadow-2xl hover:shadow-emerald-500/10 dark:hover:shadow-none hover:-translate-y-1.5 transition-all duration-500 flex flex-col h-full">
                    <div class="aspect-square relative overflow-hidden bg-white dark:bg-slate-900/40 m-2 rounded-2xl">
                        <?php if(isset($product['image']) && $product['image']): ?>
                            <img src="<?= base_url('uploads/products/'.$product['image']) ?>" 
                                 alt="<?= esc($product['name']) ?>"
                                 class="w-full h-full object-contain p-4 group-hover:scale-110 transition-transform duration-500 mix-blend-multiply dark:mix-blend-normal">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-slate-200 dark:text-slate-700">
                                <i class="fas fa-box text-5xl"></i>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($product['quantity'] <= 5): ?>
                            <div class="absolute top-3 right-3 px-2 py-1 bg-red-500/90 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-wider rounded-lg shadow-sm">
                                Low Stock
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="mb-3">
                            <h3 class="font-bold text-slate-800 dark:text-slate-100 text-lg line-clamp-1 group-hover:text-emerald-500 transition-colors">
                                <?= esc($product['name']) ?>
                            </h3>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="w-1.5 h-1.5 rounded-full <?= $product['quantity'] > 5 ? 'bg-emerald-500' : 'bg-red-500' ?>"></span>
                                <p class="text-sm font-medium text-slate-500 dark:text-slate-400"><?= $product['quantity'] ?> units available</p>
                            </div>
                        </div>
                        
                        <div class="mt-auto pt-4">
                            <div class="flex flex-col mb-4">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-tight">Price</span>
                                <span class="text-2xl font-black text-emerald-500 tracking-tight">₱<?= number_format($product['price'], 2) ?></span>
                            </div>
                            <button onclick="addToCart(<?= $product['id'] ?>, '<?= addslashes($product['name']) ?>', <?= $product['price'] ?>, <?= $product['quantity'] ?>)"
                                    class="w-full py-3 bg-slate-900 dark:bg-emerald-500 text-white rounded-2xl hover:bg-emerald-600 hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-300 flex items-center justify-center gap-2 font-bold group/btn">
                                <i class="fas fa-cart-plus group-hover/btn:scale-110 transition-transform"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Cart Modal -->
    <div id="cartPanel" class="fixed inset-0 z-[2050] hidden items-center justify-center p-4">
        <div id="cartModal" class="bg-slate-900/98 backdrop-blur-2xl w-full max-w-2xl max-h-[95vh] rounded-[3rem] shadow-[0_0_50px_rgba(0,0,0,0.5)] border border-slate-700/50 flex flex-col overflow-hidden scale-95 opacity-0 transition-all duration-300">
            <!-- Modal Header -->
            <div class="px-8 py-6 border-b border-slate-800 flex items-center justify-between bg-slate-900/50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-shopping-cart text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-white uppercase tracking-tight">Review Cart</h2>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-0.5">Finalize transaction</p>
                    </div>
                </div>
                <button onclick="toggleCart()" class="w-10 h-10 flex items-center justify-center text-slate-500 hover:text-white hover:bg-slate-800 rounded-full transition-all">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Cart Items Section -->
            <div class="flex-grow overflow-y-auto px-8 py-2 custom-scrollbar min-h-[120px] max-h-[40vh]">
                <div id="cartItems" class="space-y-2">
                    <?php foreach($cart as $item): ?>
                    <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-800/40 border border-slate-700/30 group transition-all hover:bg-slate-800/60" data-id="<?= $item['id'] ?>">
                        <div class="flex-grow">
                            <h4 class="font-bold text-slate-100 text-sm mb-0.5"><?= esc($item['name']) ?></h4>
                            <p class="text-[10px] font-black text-emerald-500 uppercase tracking-tighter">₱<?= number_format($item['price'], 2) ?> per unit</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex items-center bg-slate-950 rounded-lg border border-slate-700 p-0.5 shadow-inner">
                                <button onclick="updateQuantity(<?= $item['id'] ?>, -1)" class="w-6 h-6 flex items-center justify-center text-slate-400 hover:text-white transition-colors font-black text-xs">-</button>
                                <span class="px-2 text-[10px] font-black text-white min-w-[30px] text-center"><?= $item['quantity'] ?></span>
                                <button onclick="updateQuantity(<?= $item['id'] ?>, 1)" class="w-6 h-6 flex items-center justify-center text-slate-400 hover:text-white transition-colors font-black text-xs">+</button>
                            </div>
                            <div class="text-right min-w-[70px]">
                                <p class="font-black text-white tracking-tighter text-sm">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></p>
                            </div>
                            <button onclick="removeItem(<?= $item['id'] ?>)" class="w-7 h-7 flex items-center justify-center text-slate-600 hover:text-red-500 transition-all">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Footer Summary -->
            <div id="cartSummary" class="p-8 bg-slate-950/50 border-t border-slate-800" <?= empty($cart) ? 'style="display:none"' : '' ?>>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left: Inputs -->
                    <div class="space-y-5">
                        <div class="space-y-4">
                            <div class="relative group">
                                <div class="absolute -top-2.5 left-4 px-2 bg-slate-900 text-[10px] font-black text-slate-500 uppercase tracking-widest transition-colors group-focus-within:text-emerald-500">Customer Name</div>
                                <input type="text" id="customerName" value="Walk-in Customer" 
                                    class="block w-full px-5 py-3.5 bg-slate-900/50 border border-slate-700 rounded-2xl text-white font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm placeholder-slate-600">
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="relative group">
                                    <div class="absolute -top-2.5 left-4 px-2 bg-slate-900 text-[10px] font-black text-slate-500 uppercase tracking-widest transition-colors group-focus-within:text-emerald-500">Payment</div>
                                    <select id="paymentMethod" class="block w-full px-5 py-3.5 bg-slate-900/50 border border-slate-700 rounded-2xl text-white font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm appearance-none cursor-pointer">
                                        <option value="cash">💵 Cash</option>
                                        <option value="card">💳 Card</option>
                                        <option value="online">📱 Online</option>
                                    </select>
                                </div>
                                <div class="relative group">
                                    <div class="absolute -top-2.5 left-4 px-2 bg-slate-900 text-[10px] font-black text-slate-500 uppercase tracking-widest transition-colors group-focus-within:text-emerald-500">Paid Amount</div>
                                    <input type="number" id="paidAmount" value="0" step="1" 
                                        class="block w-full px-5 py-3.5 bg-slate-900/50 border border-slate-700 rounded-2xl text-white font-black focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm">
                                </div>
                            </div>
                        </div>

                        <div id="changeDisplay" class="relative overflow-hidden p-6 rounded-[2rem] bg-slate-900 border border-slate-800 flex flex-col gap-1 shadow-inner group transition-all duration-500">
                            <div class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Change Due</div>
                            <div class="text-3xl font-black text-white tracking-tighter">₱0.00</div>
                            <!-- Background decoration -->
                            <div class="absolute -right-4 -bottom-4 text-white opacity-[0.02] text-7xl rotate-12">
                                <i class="fas fa-coins"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Calculations & Action -->
                    <div class="flex flex-col justify-between">
                        <div class="bg-slate-900/80 p-6 rounded-[2.5rem] border border-slate-800 space-y-4">
                            <div class="flex justify-between items-center px-2">
                                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Subtotal</span>
                                <span class="font-bold text-slate-300">₱<span id="subtotal">0.00</span></span>
                            </div>
                            <div class="flex justify-between items-center px-2">
                                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Discount</span>
                                <div class="relative w-28">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-600 font-black text-[10px]">₱</span>
                                    <input type="number" id="discount" value="0" step="10" 
                                        class="block w-full pl-7 pr-3 py-1 bg-slate-950 border border-slate-800 rounded-lg text-right font-black text-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition-all">
                                </div>
                            </div>
                            <div class="flex justify-between items-center px-2 pb-2">
                                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Tax (12%)</span>
                                <span class="font-bold text-slate-300">₱<span id="tax">0.00</span></span>
                            </div>
                            <div class="pt-5 border-t border-slate-800 flex justify-between items-end px-2">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-emerald-500/50 uppercase tracking-[0.2em] mb-1">Total Due</span>
                                    <span class="text-4xl font-black text-emerald-500 tracking-tighter leading-none">₱<span id="grandTotal">0.00</span></span>
                                </div>
                            </div>
                        </div>

                        <button onclick="checkout()" class="w-full mt-6 py-5 bg-emerald-500 hover:bg-emerald-400 text-white font-black text-xl rounded-[2rem] shadow-[0_10px_40px_rgba(16,185,129,0.2)] transition-all transform active:scale-[0.98] flex items-center justify-center gap-4 group/btn overflow-hidden relative">
                            <span class="relative z-10 flex items-center gap-3">
                                <i class="fas fa-check-circle text-2xl group-hover/btn:scale-110 transition-transform"></i>
                                COMPLETE SALE
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-emerald-400 opacity-0 group-hover/btn:opacity-100 transition-opacity"></div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 5px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(15, 23, 42, 0.3);
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #10b981;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #34d399;
    }
</style>

<script>
let cart = <?= json_encode(array_values($cart)) ?>;

function toggleCart() {
    const panel = document.getElementById('cartPanel');
    const modal = document.getElementById('cartModal');
    const overlay = document.getElementById('cartOverlay');
    const toggleBtn = document.getElementById('cartToggleButton');
    const isActive = !panel.classList.contains('hidden');
    
    if (isActive) {
        modal.classList.add('scale-95', 'opacity-0');
        modal.classList.remove('scale-100', 'opacity-100');
        overlay.classList.add('opacity-0');
        overlay.classList.remove('opacity-100');
        
        setTimeout(() => {
            panel.classList.add('hidden');
            panel.classList.remove('flex');
            overlay.classList.add('hidden');
            toggleBtn.classList.remove('opacity-0', 'pointer-events-none');
        }, 300);
    } else {
        panel.classList.remove('hidden');
        panel.classList.add('flex');
        overlay.classList.remove('hidden');
        toggleBtn.classList.add('opacity-0', 'pointer-events-none');
        
        setTimeout(() => {
            modal.classList.remove('scale-95', 'opacity-0');
            modal.classList.add('scale-100', 'opacity-100');
            overlay.classList.remove('opacity-0');
            overlay.classList.add('opacity-100');
        }, 10);
    }
}

function addToCart(id, name, price, stock) {
    const existing = cart.find(item => item.id === id);
    if (existing) {
        if (existing.quantity + 1 > stock) {
            showToast(`Insufficient stock for ${name}!`, 'error');
            return;
        }
        existing.quantity++;
    } else {
        cart.push({ id, name, price, quantity: 1, stock });
    }
    
    updateCartDisplay();
    syncCartToSession();
    showToast(`Added ${name} to cart`, 'success');
}

function updateQuantity(id, change) {
    const item = cart.find(item => item.id === id);
    if (item) {
        const newQty = item.quantity + change;
        if (newQty < 1) {
            removeItem(id);
        } else if (newQty > item.stock) {
            showToast('Insufficient stock!', 'error');
            return;
        } else {
            item.quantity = newQty;
            updateCartDisplay();
            syncCartToSession();
        }
    }
}

function removeItem(id) {
    cart = cart.filter(item => item.id !== id);
    updateCartDisplay();
    syncCartToSession();
}

let currentCsrfHash = '<?= csrf_hash() ?>';

function syncCartToSession() {
    $.ajax({
        url: '<?= base_url("/pos/update-cart-session") ?>',
        method: 'POST',
        data: { cart: JSON.stringify(cart) },
        success: function(response) {
            if (response.csrf_hash) {
                currentCsrfHash = response.csrf_hash;
                $('meta[name="csrf-token"]').attr('content', response.csrf_hash);
            }
        }
    });
}

function updateCartDisplay() {
    const cartDiv = document.getElementById('cartItems');
    const summaryDiv = document.getElementById('cartSummary');
    const badge = document.getElementById('cartBadge');
    
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    badge.innerText = totalItems;
    
    if (cart.length === 0) {
        cartDiv.innerHTML = `
            <div class="flex flex-col items-center justify-center py-12 text-slate-600">
                <i class="fas fa-shopping-basket text-5xl mb-4 opacity-20"></i>
                <p class="font-bold uppercase tracking-widest text-sm">Cart is empty</p>
            </div>
        `;
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
            <div class="flex items-center gap-3 p-2.5 rounded-xl bg-slate-800/40 border border-slate-700/30 group transition-all hover:bg-slate-800/60" data-id="${item.id}">
                <div class="flex-grow">
                    <h4 class="font-bold text-slate-100 text-xs mb-0.5">${escapeHtml(item.name)}</h4>
                    <p class="text-[9px] font-black text-emerald-500 uppercase tracking-tighter">₱${item.price.toFixed(2)} per unit</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center bg-slate-950 rounded-lg border border-slate-700 p-0.5 shadow-inner">
                        <button onclick="updateQuantity(${item.id}, -1)" class="w-5 h-5 flex items-center justify-center text-slate-400 hover:text-white transition-colors font-black text-[10px]">-</button>
                        <span class="px-2 text-[9px] font-black text-white min-w-[25px] text-center">${item.quantity}</span>
                        <button onclick="updateQuantity(${item.id}, 1)" class="w-5 h-5 flex items-center justify-center text-slate-400 hover:text-white transition-colors font-black text-[10px]">+</button>
                    </div>
                    <div class="text-right min-w-[60px]">
                        <p class="font-black text-white tracking-tighter text-xs">₱${total.toFixed(2)}</p>
                    </div>
                    <button onclick="removeItem(${item.id})" class="w-6 h-6 flex items-center justify-center text-slate-600 hover:text-red-500 transition-all">
                        <i class="fas fa-trash-alt text-[10px]"></i>
                    </button>
                </div>
            </div>
        `;
    });
    
    cartDiv.innerHTML = html;
    
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const taxAmount = subtotal * 0.12;
    const grandTotal = subtotal - discount + taxAmount;
    
    document.getElementById('subtotal').innerText = subtotal.toFixed(2);
    document.getElementById('tax').innerText = taxAmount.toFixed(2);
    document.getElementById('grandTotal').innerText = grandTotal.toFixed(2);
    
    const paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;
    const change = paidAmount - grandTotal;
    
    const changeDisplay = document.getElementById('changeDisplay');
    const changeAmount = changeDisplay.querySelector('.text-3xl');
    changeAmount.innerText = `₱${change.toFixed(2)}`;
    
    if (paidAmount > 0) {
        if (change >= 0) {
            changeDisplay.className = 'relative overflow-hidden p-6 rounded-[2rem] bg-emerald-500/10 border border-emerald-500/30 flex flex-col gap-1 shadow-[0_0_20px_rgba(16,185,129,0.1)] group transition-all duration-500 scale-[1.02]';
            changeAmount.className = 'text-3xl font-black text-emerald-500 tracking-tighter';
        } else {
            changeDisplay.className = 'relative overflow-hidden p-6 rounded-[2rem] bg-red-500/10 border border-red-500/30 flex flex-col gap-1 shadow-inner group transition-all duration-500';
            changeAmount.className = 'text-3xl font-black text-red-500 tracking-tighter';
        }
    } else {
        changeDisplay.className = 'relative overflow-hidden p-6 rounded-[2rem] bg-slate-900 border border-slate-800 flex flex-col gap-1 shadow-inner group transition-all duration-500';
        changeAmount.className = 'text-3xl font-black text-white tracking-tighter';
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed bottom-8 left-8 px-6 py-3 rounded-2xl shadow-2xl z-[3000] transform transition-all duration-300 translate-y-20 flex items-center gap-3 font-medium ${
        type === 'success' ? 'bg-emerald-500 text-white' : 'bg-red-500 text-white'
    }`;
    toast.innerHTML = `
        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
        ${message}
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.classList.remove('translate-y-20'), 10);
    setTimeout(() => {
        toast.classList.add('translate-y-20');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

document.getElementById('discount').addEventListener('input', updateCartDisplay);
document.getElementById('paidAmount').addEventListener('input', updateCartDisplay);

document.getElementById('searchProduct').addEventListener('keyup', function(e) {
    const search = e.target.value.toLowerCase();
    document.querySelectorAll('.product-item').forEach(item => {
        const text = item.innerText.toLowerCase();
        item.style.display = text.includes(search) ? '' : 'none';
    });
});

function checkout() {
    if (cart.length === 0) {
        showToast('Cart is empty', 'error');
        return;
    }
    
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const paymentMethod = document.getElementById('paymentMethod').value;
    const customerName = document.getElementById('customerName').value;
    const paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;
    
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const grandTotal = subtotal - discount + (subtotal * 0.12);
    
    if (paidAmount < grandTotal) {
        showToast('Insufficient payment amount!', 'error');
        return;
    }
    
    if (confirm(`Complete sale for ₱${grandTotal.toFixed(2)}?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url("/pos/checkout") ?>';
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '<?= csrf_token() ?>';
        csrf.value = currentCsrfHash;
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

// Initialize display
updateCartDisplay();
</script>

<?= $this->endSection() ?>
