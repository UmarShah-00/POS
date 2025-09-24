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

        // ✅ SweetAlert Style (confirm = default, cancel = custom)
        const swalWithDarkBtn = Swal.mixin({
            customClass: {
                cancelButton: 'swal2-cancel'
            },
            buttonsStyling: true
        });

        // ✅ Format weight nicely (0.125 → 125, 1.25 → 1250)
        function formatWeight(qty) {
            if (isNaN(qty) || qty <= 0) return "0";
            return Math.round(qty * 1000); // convert kg/litre → g/ml
        }

        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('barcode-input');
            const searchInput = document.getElementById('search-input');
            const searchResults = document.getElementById('search-results');
            const cartBody = document.getElementById('cart-body');
            const grandTotalEl = document.getElementById('grand-total');

            let typingTimer;
            const doneTypingInterval = 300;

            // ✅ Fetch Product by barcode
            async function fetchProduct(barcode) {
                try {
                    const res = await fetch("{{ route('products.find') }}?barcode=" + encodeURIComponent(
                        barcode));
                    if (!res.ok) throw new Error('Not found');
                    const product = await res.json();
                    handleProduct(product);
                } catch (err) {
                    swalWithDarkBtn.fire('❌ Error', 'Product not found', 'error');
                }
            }

            // ✅ Handle Product by unit
            function handleProduct(product) {
                const unit = product.unit ? product.unit.toLowerCase() : '';

                if (unit === 'piece' || unit === 'packet') {
                    addToCart(product, 1);
                } else if (unit === 'kg' || unit === 'litre') {
                    swalWithDarkBtn.fire({
                        title: `Enter ${product.unit} or Amount`,
                        html: `
                            <p class="text-muted small">
                              Example: 0.125 = 125 grams, 0.25 = 250 grams <br>
                              Or enter total amount in Rs.
                            </p>
                            <input id="weight" class="swal2-input" placeholder="Weight in ${product.unit}">
                            <input id="amount" class="swal2-input" placeholder="Amount in Rs">
                        `,
                        focusConfirm: false,
                        showCancelButton: true,
                        confirmButtonText: 'Add to Cart',
                        cancelButtonText: 'Cancel',
                        preConfirm: () => {
                            const weightVal = document.getElementById('weight').value.trim();
                            const amountVal = document.getElementById('amount').value.trim();

                            const weight = weightVal ? parseFloat(weightVal) : null;
                            const amount = amountVal ? parseFloat(amountVal) : null;

                            if ((!weight && !amount) || (isNaN(weight) && isNaN(amount))) {
                                Swal.showValidationMessage('⚠ Please enter weight or amount');
                                return false;
                            }

                            if (weight && !isNaN(weight)) {
                                return {
                                    mode: 'weight',
                                    value: weight
                                };
                            }
                            if (amount && !isNaN(amount)) {
                                return {
                                    mode: 'amount',
                                    value: amount
                                };
                            }
                        }
                    }).then((result) => {
                        if (!result.isConfirmed) return;

                        const price = parseFloat(product.price_per_unit || product.price) || 0;

                        if (result.value.mode === 'weight') {
                            addToCart(product, result.value.value); // qty = weight (kg)
                        } else {
                            const amount = result.value.value;
                            const qty = price > 0 ? (amount / price) : 0;

                            if (isNaN(qty) || qty <= 0) {
                                swalWithDarkBtn.fire('❌ Error', 'Invalid amount entered', 'error');
                                return;
                            }
                            addToCart(product, qty);
                        }
                    });
                } else {
                    swalWithDarkBtn.fire('⚠ Unknown Unit', 'This product has an unsupported unit type', 'warning');
                }
            }

            // ✅ Add to Cart
            function addToCart(product, qty) {
                qty = parseFloat(qty) || 0;
                if (qty <= 0) return;

                const existing = window.cart.find(item => item.id === product.id);
                if (existing) {
                    existing.qty += qty;
                } else {
                    window.cart.push({
                        ...product,
                        qty: qty
                    });
                }
                renderCart();
            }

            // ✅ Render Cart
            function renderCart() {
                cartBody.innerHTML = '';
                let total = 0;

                window.cart.forEach((item, idx) => {
                    const price = parseFloat(item.price_per_unit || item.price) || 0;
                    const qty = parseFloat(item.qty) || 0;
                    const lineTotal = qty * price;
                    total += lineTotal;

                    let displayQty;
                    const unit = item.unit ? item.unit.toLowerCase() : '';
                    let unitLabel = '';
                    if (unit === 'kg') {
                        displayQty = formatWeight(qty);
                        unitLabel = 'g';
                    } else if (unit === 'litre') {
                        displayQty = formatWeight(qty);
                        unitLabel = 'ml';
                    } else {
                        displayQty = Number.isInteger(qty) ? qty : qty;
                        unitLabel = 'pcs';
                    }

                    const row = `
                        <tr>
                          <td>${item.name}</td>
                          <td>${item.barcode}</td>
                          <td><span class="text-dark fw-semibold">Rs. ${price.toFixed(2)}</span></td>
                          <td>
                            <div class="d-flex align-items-center justify-content-center" style="gap:4px; width:140px;">
                              <div class="d-flex align-items-center justify-content-center" style="gap:6px; width:160px;">
  <button class="btn btn-sm dec-btn" data-idx="${idx}" 
          style="width:50px; height:28px; background:gray; color:white; font-size:15px; border-radius:4px;">
    –
  </button>

  <span class="qty-display d-inline-block text-center border rounded px-2 fw-bold" 
        data-idx="${idx}" 
        style="min-width:60px; background:#f8f9fa; line-height:26px;">
    ${displayQty} ${unitLabel}
  </span>

  <button class="btn btn-sm inc-btn" data-idx="${idx}" 
          style="width:50px; height:28px; background:gray; color:white; font-size:15px; border-radius:4px;">
    +
  </button>
</div>

                            </div>
                          </td>
                          <td><span class="fw-bold text-success">Rs. ${lineTotal.toFixed(2)}</span></td>
                          <td>
                            <button class="btn btn-sm btn-danger remove-btn" data-idx="${idx}">X</button>
                          </td>
                        </tr>
                    `;
                    cartBody.insertAdjacentHTML('beforeend', row);
                });

                grandTotalEl.innerHTML = `<strong class="text-success fs-5">Rs. ${total.toFixed(2)} /-</strong>`;
                document.getElementById('cart-count').textContent =
                    window.cart.length + (window.cart.length === 1 ? " Item" : " Items");

                // ✅ Qty Update
                document.querySelectorAll('.qty-input').forEach(input => {
                    input.addEventListener('change', (e) => {
                        const idx = e.target.dataset.idx;
                        let newQty = parseFloat(e.target.value);

                        const unit = window.cart[idx].unit ? window.cart[idx].unit.toLowerCase() :
                            '';
                        if (unit === 'kg' || unit === 'litre') {
                            newQty = (isNaN(newQty) || newQty <= 0) ? 0.001 : newQty / 1000;
                        } else {
                            newQty = (isNaN(newQty) || newQty <= 0) ? 1 : newQty;
                        }

                        window.cart[idx].qty = newQty;
                        renderCart();
                    });
                });

                // ✅ Increment
                document.querySelectorAll('.inc-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const idx = e.target.dataset.idx;
                        const unit = window.cart[idx].unit.toLowerCase();
                        if (unit === 'kg' || unit === 'litre') {
                            window.cart[idx].qty += 0.001; // 1g/ml
                        } else {
                            window.cart[idx].qty += 1;
                        }
                        renderCart();
                    });
                });

                // ✅ Decrement
                document.querySelectorAll('.dec-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const idx = e.target.dataset.idx;
                        const unit = window.cart[idx].unit.toLowerCase();
                        if (unit === 'kg' || unit === 'litre') {
                            window.cart[idx].qty = Math.max(0.001, window.cart[idx].qty - 0.001);
                        } else {
                            window.cart[idx].qty = Math.max(1, window.cart[idx].qty - 1);
                        }
                        renderCart();
                    });
                });

                // ✅ Remove Item
                document.querySelectorAll('.remove-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const idx = e.target.dataset.idx;
                        window.cart.splice(idx, 1);
                        renderCart();
                    });
                });
            }

            // ✅ Barcode Scanner
            input.addEventListener('input', function() {
                clearTimeout(typingTimer);
                if (input.value.trim()) {
                    typingTimer = setTimeout(() => {
                        fetchProduct(input.value.trim());
                        input.value = '';
                    }, doneTypingInterval);
                }
            });

            // ✅ Search Input
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                if (query.length > 1) {
                    searchProducts(query);
                } else {
                    searchResults.style.display = 'none';
                }
            });

            // ✅ Search Products
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

            // ✅ Render Search Dropdown
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
            document.getElementById('checkout-btn').addEventListener('click', async function() {
                if (window.cart.length === 0) {
                    swalWithDarkBtn.fire('⚠ Empty', 'Cart is empty', 'warning');
                    return;
                }

                const payloadCart = window.cart.map(item => ({
                    id: item.id,
                    qty: item.qty,
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
                        body: JSON.stringify({
                            cart: payloadCart
                        })
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
