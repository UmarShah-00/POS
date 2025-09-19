@extends('layout.app')

@push('styles')
<style>
    .fa { line-height: 2 !important; }
    .swal2-confirm {
        background-color: #181818 !important;
        border-radius: 0.25rem !important;
        color: #fff !important;
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <div class="main-content-inner">
        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data"
              class="form-product-edit form-type-3" id="product-form">
            @csrf

            <div class="flex flex-wrap justify-between gap14 items-center mb-30">
                <h4 class="heading">Edit Product</h4>
                <button type="submit" class="tf-button text-btn-uppercase">
                    Update
                </button>
            </div>

            <div class="wg-box p-40">
                <div class="row">

                    {{-- Upload Image --}}
                    <fieldset class="col-6 mb-4">
                        <div class="text-caption-1 mb-8">Product Image</div>
                        <div class="upload-image style-2">
                            <div class="upload-img">
                                <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/categories/categories-img-1.jpg') }}"
                                    id="preview-image" alt="Preview" style="max-width: 200px; border-radius: 6px;">
                            </div>
                            <label class="uploadfile" for="image">
                                <input type="file" id="image" name="image" accept="image/*"
                                       onchange="document.getElementById('preview-image').src = window.URL.createObjectURL(this.files[0])">
                                <div class="upload-btn text-button font-instrument fw-6">Choose File</div>
                                <div class="text-caption-1 font-instrument text-secondary">Upload file</div>
                            </label>
                        </div>
                    </fieldset>

                    {{-- Barcode --}}
                    <fieldset class="col-6 mb-4">
                        <label class="flex items-center gap-1">
                            <input type="checkbox" id="auto-barcode"> Auto-generate code
                        </label>
                        <div class="text-caption-1 mb-8 mt-3">Barcode</div>
                        <input type="text" placeholder="Enter Barcode" class="form-control"
                               name="barcode" id="barcode" value="{{ old('barcode', $product->barcode) }}">
                        <small class="text-secondary">Check the box to auto-generate barcode</small>
                    </fieldset>

                    {{-- Name --}}
                    <fieldset class="col-6 mb-4">
                        <div class="text-caption-1 mb-8">Product Name <span class="text-primary">*</span></div>
                        <input type="text" placeholder="Enter product name" class="form-control"
                               name="name" value="{{ old('name', $product->name) }}" required>
                    </fieldset>

                    {{-- Category --}}
                    <fieldset class="col-6 mb-4">
                        <div class="text-caption-1 mb-8">Category <span class="text-primary">*</span></div>
                        <select class="form-control" name="category_id" required style="height: 47px; font-size: 15px;">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </fieldset>

                    {{-- Price --}}
                    <fieldset class="col-6 mb-4">
                        <div class="text-caption-1 mb-8">Price <span class="text-primary">*</span></div>
                        <input type="number" step="0.01" placeholder="Enter price" class="form-control"
                               name="price" value="{{ old('price', $product->price) }}" required>
                    </fieldset>

                    {{-- Stock --}}
                    <fieldset class="col-6 mb-4">
                        <div class="text-caption-1 mb-8">Stock <span class="text-primary">*</span></div>
                        <input type="number" placeholder="Enter stock quantity" class="form-control"
                               name="stock" value="{{ old('stock', $product->stock) }}" required>
                    </fieldset>

                    {{-- Unit --}}
                    <fieldset class="col-6 mb-4">
                        <div class="text-caption-1 mb-8">Unit</div>
                        <input type="text" placeholder="e.g. kg, liter, pcs" class="form-control"
                               name="unit" value="{{ old('unit', $product->unit) }}">
                    </fieldset>

                    {{-- Expiry Date --}}
                    <fieldset class="col-6 mb-4">
                        <div class="text-caption-1 mb-8">Expiry Date</div>
                        <input type="date" class="form-control" name="expiry_date"
                               value="{{ old('expiry_date', $product->expiry_date) }}">
                    </fieldset>

                </div>
            </div>
        </form>
    </div>
</div>
@endsection

{{-- JS --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("product-form");

        form.addEventListener("submit", async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const action = this.getAttribute("action"); // ✅ route se action pick karega
            const method = this.querySelector('input[name="_method"]')?.value || this.method;

            try {
                const response = await fetch(action, {
                    method: method, // "PUT" ya "POST"
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                        "Accept": "application/json"
                    },
                    body: formData
                });

                let data;
                try {
                    data = await response.json();
                } catch (err) {
                    console.error("❌ JSON Parse Error:", err);
                    throw new Error("Invalid JSON response");
                }

                if (response.ok && data.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: data.message,
                        confirmButtonColor: "#181818"
                    }).then(() => {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: data.message || "Something went wrong."
                    });
                }
            } catch (error) {
                console.error("❌ Fetch Error:", error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Request failed. Check console for details."
                });
            }
        });
    });
</script>
<script>
    // ✅ Auto Barcode Checkbox
    document.addEventListener("DOMContentLoaded", function () {
        const checkbox = document.getElementById("auto-barcode");
        const barcodeInput = document.getElementById("barcode");

        checkbox.addEventListener("change", function () {
            if (this.checked) {
                let barcode = Math.floor(Math.random() * 10000000000000)
                    .toString()
                    .padStart(13, '0');
                barcodeInput.value = barcode;
                barcodeInput.readOnly = true;
            } else {
                barcodeInput.readOnly = false;
            }
        });
    });
</script>
