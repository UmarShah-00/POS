@extends('layout.app')

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
                                <td colspan="2" id="grand-total" class="fw-bold text-success fs-5">Rs. 0 /-</td>
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
<script>
    // 👇 Cart ko global rakho
    window.cart = [];

    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('barcode-input');
        const searchInput = document.getElementById('search-input');
        const searchResults = document.getElementById('search-results');
        const cartBody = document.getElementById('cart-body');
        const grandTotalEl = document.getElementById('grand-total');

        let typingTimer;
        const doneTypingInterval = 300;

        // ✅ Fetch product by barcode
        async function fetchProduct(barcode) {
            try {
                const res = await fetch("{{ route('products.find') }}?barcode=" + encodeURIComponent(barcode));
                if (!res.ok) throw new Error('Not found');
                const product = await res.json();
                addToCart(product);
            } catch (err) {
                alert('❌ Product not found');
            }
        }

        // ✅ Fetch products by name
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

        // ✅ Render search dropdown
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
                    addToCart(product);
                    searchResults.style.display = 'none';
                    searchInput.value = '';
                });
                searchResults.appendChild(item);
            });

            searchResults.style.display = 'block';
        }

        // ✅ Add product to cart
        function addToCart(product) {
            const existing = window.cart.find(item => item.id === product.id);
            if (existing) {
                existing.qty += 1;
            } else {
                window.cart.push({ ...product, qty: 1 });
            }
            renderCart();
        }

        // ✅ Render cart
        function renderCart() {
            cartBody.innerHTML = '';
            let total = 0;

            window.cart.forEach((item, idx) => {
                const lineTotal = item.qty * parseFloat(item.price_per_unit || item.price);
                total += lineTotal;

                const row = `
                    <tr>
                      <td>${item.name}</td>
                      <td>${item.barcode}</td>
                      <td><span class="text-dark fw-semibold">Rs. ${parseFloat(item.price_per_unit || item.price).toFixed(2)}</span></td>
                      <td>
                        <input type="number" min="1" value="${item.qty}" 
                               data-idx="${idx}" 
                               class="qty-input form-control form-control-sm text-center" 
                               style="width:70px;">
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

            // Qty update
            document.querySelectorAll('.qty-input').forEach(input => {
                input.addEventListener('change', (e) => {
                    const idx = e.target.dataset.idx;
                    window.cart[idx].qty = parseInt(e.target.value) || 1;
                    renderCart();
                });
            });

            // Remove item
            document.querySelectorAll('.remove-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const idx = e.target.dataset.idx;
                    window.cart.splice(idx, 1);
                    renderCart();
                });
            });
        }

        // ✅ Barcode input event
        input.addEventListener('input', function () {
            clearTimeout(typingTimer);
            if (input.value.trim()) {
                typingTimer = setTimeout(() => {
                    fetchProduct(input.value.trim());
                    input.value = '';
                }, doneTypingInterval);
            }
        });

        // ✅ Live search by name
        searchInput.addEventListener('input', function () {
            const query = this.value.trim();
            if (query.length > 1) {
                searchProducts(query);
            } else {
                searchResults.style.display = 'none';
            }
        });

        // ✅ Hide dropdown when clicked outside
        document.addEventListener('click', function (e) {
            if (!searchResults.contains(e.target) && e.target !== searchInput) {
                searchResults.style.display = 'none';
            }
        });

        // ✅ Checkout button
        document.getElementById('checkout-btn').addEventListener('click', async function () {
            if (window.cart.length === 0) {
                alert('Cart is empty');
                return;
            }

            const payloadCart = window.cart.map(item => ({
                id: item.id,
                qty: item.qty,
                price: item.price_per_unit || item.price
            }));

            if (!confirm('Confirm checkout?')) return;

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
                    alert('Error: ' + (data.message || 'Checkout failed'));
                }
            } catch (err) {
                console.error(err);
                alert('Checkout failed');
            }
        });
    });
</script>

<style>
    #search-results {
        z-index: 9999;
        max-height: 300px;
        overflow-y: auto;
    }
</style>

@endsection
