@extends('layout.app')

@push('styles')
    <style>
        /* Keep only cancel button style */
        .swal2-cancel {
            background-color: #6c757d !important;
            border-radius: 0.25rem !important;
            color: #fff !important;
            padding: 8px 25px !important;
        }
    </style>
@endpush

@section('content')
    <div class="main-content">
        <div class="main-content-inner">

            <!-- 🔹 POS Heading -->
            <div class="wg-box">
                <div class="d-flex">
                    <div class="col-6">
                        <h4 class="heading">ShopEase Billing</h4>
                    </div>
                    <!-- Barcode Input -->
                    <div class="col-6">
                        <input type="text" id="barcode-input" class="form-control mb-3" placeholder="Scan barcode"
                            autocomplete="off" autofocus>
                    </div>
                </div>

                <!-- Search Input -->
                <div class="position-relative">
                    <input type="text" id="search-input" class="form-control" placeholder="Search product by name..."
                        autocomplete="off">
                    <!-- Search Results Dropdown -->
                    <div id="search-results" class="list-group position-absolute w-100 mt-1" style="display:none;"></div>
                </div>
            </div>

            <!-- Cart Table -->
            <div class="wg-box mt-4">
                <div class="mt-16">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <h4 class="fw-bold text-dark mb-0">Cart</h4>
                        <span class="badge bg-dark fs-5" id="cart-count">0 Items</span>
                    </div>

                    <table class="table table-bordered mt-2">
                        <thead>
                            <tr>
                                <th class="fw-bold">Name</th>
                                <th class="fw-bold">Barcode</th>
                                <th class="fw-bold">Price</th>
                                <th class="fw-bold">Qty</th>
                                <th class="fw-bold">Total</th>
                                <th class="fw-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody id="cart-body"></tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Grand Total:</strong></td>
                                <td colspan="2" id="grand-total" class="fw-bold text-success fs-5">Rs. 0.00 /-</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="text-end mt-3">
                <button id="checkout-btn" class="btn btn-dark btn-lg">
                    <i class="fa fa-check"></i> Checkout
                </button>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
<!-- ✅ SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.cart = [];

    const swalWithDarkBtn = Swal.mixin({
        customClass: { cancelButton: 'swal2-cancel' },
        buttonsStyling: true
    });

    // ✅ Format Qty for display
    function formatQty(qty, unit) {
        if (unit === 'kg') {
            return qty + ' g';
        } else if (unit === 'litre') {
            return qty + ' ml';
        } else {
            return qty + ' pcs';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('barcode-input');
        const searchInput = document.getElementById('search-input');
        const searchResults = document.getElementById('search-results');
        const cartBody = document.getElementById('cart-body');
        const grandTotalEl = document.getElementById('grand-total');
        let typingTimer;
        const doneTypingInterval = 300;

        // ✅ Fetch product
        async function fetchProduct(barcode) {
            try {
                const res = await fetch("{{ route('products.find') }}?barcode=" + encodeURIComponent(barcode));
                if (!res.ok) throw new Error('Not found');
                const product = await res.json();
                handleProduct(product);
            } catch {
                swalWithDarkBtn.fire('❌ Error', 'Product not found', 'error');
            }
        }

        // ✅ Handle product add
        function handleProduct(product) {
            const unit = product.unit ? product.unit.toLowerCase() : '';

            if (unit === 'piece' || unit === 'packet') {
                addToCart(product, 1);
            } else if (unit === 'kg' || unit === 'litre') {
                swalWithDarkBtn.fire({
                    title: `Enter ${product.unit} or Amount`,
                    html: `
                        <p class="text-muted small">
                          Example: 125 = 125 grams/ml, 250 = 250 grams/ml <br>
                          Or enter total amount in Rs.
                        </p>
                        <input id="weight" class="swal2-input" placeholder="Weight in grams/ml">
                        <input id="amount" class="swal2-input" placeholder="Amount in Rs">
                    `,
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: 'Add to Cart',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        const weightVal = document.getElementById('weight').value.trim();
                        const amountVal = document.getElementById('amount').value.trim();
                        const weight = weightVal ? parseInt(weightVal) : null; // ✅ grams/ml direct
                        const amount = amountVal ? parseFloat(amountVal) : null;

                        if ((!weight && !amount) || (isNaN(weight) && isNaN(amount))) {
                            Swal.showValidationMessage('⚠ Please enter weight or amount');
                            return false;
                        }

                        if (weight && !isNaN(weight)) {
                            return { mode: 'weight', value: weight };
                        }
                        if (amount && !isNaN(amount)) {
                            return { mode: 'amount', value: amount };
                        }
                    }
                }).then((result) => {
                    if (!result.isConfirmed) return;
                    const price = parseFloat(product.price_per_unit || product.price) || 0;

                    if (result.value.mode === 'weight') {
                        addToCart(product, result.value.value); // ✅ stored as grams/ml
                    } else {
                        const amount = result.value.value;
                        const qty = price > 0 ? (amount / price) * 1000 : 0; // Rs → grams/ml
                        if (isNaN(qty) || qty <= 0) {
                            swalWithDarkBtn.fire('❌ Error', 'Invalid amount entered', 'error');
                            return;
                        }
                        addToCart(product, Math.round(qty));
                    }
                });

            } else {
                swalWithDarkBtn.fire('⚠ Unknown Unit', 'This product has an unsupported unit type', 'warning');
            }
        }

        // ✅ Add to cart
        function addToCart(product, qty) {
            qty = parseInt(qty) || 0;
            if (qty <= 0) return;

            const existing = window.cart.find(item => item.id === product.id);
            if (existing) {
                existing.qty += qty;
            } else {
                window.cart.push({ ...product, qty: qty });
            }
            renderCart();
        }

        // ✅ Render cart
        function renderCart() {
            cartBody.innerHTML = '';
            let total = 0;

            window.cart.forEach((item, idx) => {
                const price = parseFloat(item.price_per_unit || item.price) || 0;
                let qty = parseInt(item.qty) || 0;
                let lineTotal = 0;
                const unit = item.unit ? item.unit.toLowerCase() : '';

                if (unit === 'kg' || unit === 'litre') {
                    lineTotal = (qty / 1000) * price;
                } else {
                    lineTotal = qty * price;
                }
                total += lineTotal;

                const row = `
                    <tr>
                      <td>${item.name}</td>
                      <td>${item.barcode}</td>
                      <td>Rs. ${price.toFixed(2)}</td>
                      <td>
                        <div class="d-flex align-items-center justify-content-center" style="gap:6px;">
                          <button class="btn btn-sm dec-btn" data-idx="${idx}" 
                                  style="width:40px; height:28px; background:gray; color:white;">–</button>
                          <span class="qty-display fw-bold border rounded px-2 bg-light" 
                                style="min-width:60px; text-align:center;">
                            ${formatQty(qty, unit)}
                          </span>
                          <button class="btn btn-sm inc-btn" data-idx="${idx}" 
                                  style="width:40px; height:28px; background:gray; color:white;">+</button>
                        </div>
                      </td>
                      <td><span class="fw-bold text-success">Rs. ${lineTotal.toFixed(2)}</span></td>
                      <td><button class="btn btn-sm btn-danger remove-btn" data-idx="${idx}">X</button></td>
                    </tr>
                `;
                cartBody.insertAdjacentHTML('beforeend', row);
            });

            grandTotalEl.innerHTML = `<strong class="text-success fs-5">Rs. ${total.toFixed(2)} /-</strong>`;
            document.getElementById('cart-count').textContent =
                window.cart.length + (window.cart.length === 1 ? " Item" : " Items");

            // ✅ Increment
            document.querySelectorAll('.inc-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const idx = e.target.dataset.idx;
                    window.cart[idx].qty += 1; // +1 gram/ml/piece
                    renderCart();
                });
            });

            // ✅ Decrement
            document.querySelectorAll('.dec-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const idx = e.target.dataset.idx;
                    if (window.cart[idx].qty > 1) {
                        window.cart[idx].qty -= 1; // -1 gram/ml/piece
                    }
                    renderCart();
                });
            });

            // ✅ Remove
            document.querySelectorAll('.remove-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const idx = e.target.dataset.idx;
                    window.cart.splice(idx, 1);
                    renderCart();
                });
            });
        }

        // ✅ Barcode input
        input.addEventListener('input', function () {
            clearTimeout(typingTimer);
            if (input.value.trim()) {
                typingTimer = setTimeout(() => {
                    fetchProduct(input.value.trim());
                    input.value = '';
                }, doneTypingInterval);
            }
        });

        // ✅ Search
        searchInput.addEventListener('input', function () {
            const query = this.value.trim();
            if (query.length > 1) {
                searchProducts(query);
            } else {
                searchResults.style.display = 'none';
            }
        });

        async function searchProducts(query) {
            try {
                const res = await fetch("{{ route('products.search') }}?name=" + encodeURIComponent(query));
                if (!res.ok) throw new Error('Search failed');
                const products = await res.json();
                renderSearchResults(products);
            } catch (err) {
                console.error(err);
            }
        }

        function renderSearchResults(products) {
            searchResults.innerHTML = '';
            if (products.length === 0) {
                searchResults.style.display = 'none';
                return;
            }
            products.forEach(product => {
                const item = document.createElement('div');
                item.className = 'list-group-item list-group-item-action d-flex align-items-center';
                item.style.cursor = 'pointer';
                item.innerHTML = `
                    <img src="${product.image}" alt="${product.name}" class="me-2 rounded"
                         style="width:40px; height:40px; object-fit:cover;">
                    <div>
                      <div class="fw-bold">${product.name}</div>
                      <small class="text-muted">Barcode: ${product.barcode}</small>
                    </div>
                `;
                item.addEventListener('click', () => {
                    handleProduct(product);
                    searchResults.style.display = 'none';
                    searchInput.value = '';
                });
                searchResults.appendChild(item);
            });
            searchResults.style.display = 'block';
        }

        // ✅ Checkout
        document.getElementById('checkout-btn').addEventListener('click', async function () {
            if (window.cart.length === 0) {
                swalWithDarkBtn.fire('⚠ Empty', 'Cart is empty', 'warning');
                return;
            }

            const payloadCart = window.cart.map(item => ({
                id: item.id,
                qty: parseInt(item.qty), // ✅ always in grams/ml/pieces
                price: item.price_per_unit || item.price
            }));

            const confirm = await swalWithDarkBtn.fire({
                title: 'Confirm Checkout?',
                text: 'Are you sure you want to checkout?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Checkout',
                cancelButtonText: 'Cancel'
            });

            if (!confirm.isConfirmed) return;

            try {
                const res = await fetch("{{ route('checkout') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ cart: payloadCart })
                });

                const data = await res.json();

                if (data.status === 'success') {
                    window.cart = [];
                    renderCart();
                    window.location.href = "/invoice/" + data.sale_id;
                } else {
                    swalWithDarkBtn.fire('❌ Error', data.message || 'Checkout failed', 'error');
                }
            } catch (err) {
                console.error(err);
                swalWithDarkBtn.fire('❌ Error', 'Checkout failed', 'error');
            }
        });
    });
</script>
@endsection

