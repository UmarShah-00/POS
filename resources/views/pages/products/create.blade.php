@extends('layout.app')

{{-- Custom Styles --}}
@push('styles')
    <style>
        .fa {
            line-height: 2 !important;
        }

        .swal2-confirm {
            background-color: #181818 !important;
            border-radius: 0.25rem !important;
            color: #fff !important;
        }
    </style>
@endpush

@section('content')
    <!-- main-content -->
    <div class="main-content">
        <!-- main-content-inner -->
        <div class="main-content-inner">
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data"
                class="form-product-create form-type-3" id="product-form">
                @csrf
                <div class="flex flex-wrap justify-between gap14 items-center mb-30">
                    <h4 class="heading">Create Product</h4>
                    <button type="submit" class="tf-button text-btn-uppercase">
                        Save
                    </button>
                </div>

                <div class="wg-box p-40">
                    <div class="row">

                        {{-- Upload Image --}}
                        <fieldset class="col-6 mb-4">
                            <div class="text-caption-1 mb-8">Product Image</div>
                            <div class="upload-image style-2">
                                <div class="upload-img">
                                    {{-- Preview Image --}}
                                    <img src="{{ asset('images/categories/categories-img-1.jpg') }}" id="preview-image"
                                        alt="Preview" style="max-width: 200px; border-radius: 6px;">
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
                            <div class="flex items-center gap-2">
                                <input type="text" placeholder="Enter Barcode" class="form-control" name="barcode"
                                    id="barcode" value="{{ old('barcode') }}">

                            </div>
                            <small class="text-secondary">Check the box to auto-generate barcode</small>
                        </fieldset>

                        {{-- Name --}}
                        <fieldset class="col-6 mb-4">
                            <div class="text-caption-1 mb-8">Product Name <span class="text-primary">*</span></div>
                            <input type="text" placeholder="Enter product name" class="form-control" name="name"
                                value="{{ old('name') }}" required>
                        </fieldset>

                        {{-- Category --}}
                        <fieldset class="col-6 mb-4">
                            <div class="text-caption-1 mb-8">Category <span class="text-primary">*</span></div>
                            <select class="form-control" name="category_id" required style="height: 47px; font-size: 15px;">
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </fieldset>

                        {{-- Price --}}
                        <fieldset class="col-6 mb-4">
                            <div class="text-caption-1 mb-8">Price Per Product <span class="text-primary">*</span></div>
                            <input type="number" step="0.01" placeholder="Enter price" class="form-control"
                                name="price_per_unit" value="{{ old('price_per_unit') }}" required>
                        </fieldset>

                        {{-- Stock --}}
                        <fieldset class="col-6 mb-4">
                            <div class="text-caption-1 mb-8">Stock <span class="text-primary">*</span></div>
                            <input type="number" placeholder="Enter stock quantity" class="form-control" name="stock"
                                value="{{ old('stock') }}" required>
                        </fieldset>

                        {{-- Unit --}}
                        <fieldset class="col mb-4">
                            <div class="text-caption-1 mb-8">
                                Unit <span class="text-primary">*</span>
                            </div>
                            <select name="unit" class="form-control" required style="height: 47px; font-size: 15px;">
                                <option value="">-- Select Unit --</option>
                                <option value="piece">Piece</option>
                                <option value="packet">Packet</option>
                                <option value="kg">Kg</option>
                                <option value="litre">Litre</option>
                            </select>
                            <small class="text-secondary">
                                👉 For <b>Piece</b> and <b>Packet</b> → Enter stock as normal count (e.g., 50 pieces).<br>
                                👉 For <b>Kg</b> → Always enter stock in <b>grams</b>. Example: <code>5000</code> = 5
                                Kg.<br>
                                👉 For <b>Litre</b> → Always enter stock in <b>millilitres</b>. Example: <code>2000</code> =
                                2 Litres.
                            </small>
                        </fieldset>
                    </div>
                </div>
            </form>

        </div>
        <!-- /main-content-inner -->
    </div>
    <!-- /main-content -->
@endsection

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("product-form");

        form.addEventListener("submit", async function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            try {
                const response = await fetch("{{ route('product.store') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                        "Accept": "application/json"
                    },
                    body: formData
                });

                // Try parsing JSON safely
                let data;
                try {
                    data = await response.json();
                } catch (err) {
                    console.error("❌ JSON Parse Error:", err);
                    throw new Error("Invalid JSON response");
                }

                console.log("✅ Response:", data);

                if (response.ok && data.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: data.message,
                        confirmButtonColor: "#181818"
                    }).then(() => {
                        if (data.redirect) {
                            window.location.href = data
                                .redirect; // ✅ Redirect after OK click
                        }
                    });
                    form.reset();
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
    document.addEventListener("DOMContentLoaded", function() {
        const checkbox = document.getElementById("auto-barcode");
        const barcodeInput = document.getElementById("barcode");

        checkbox.addEventListener("change", function() {
            if (this.checked) {
                // ✅ 13 digit random number
                let barcode = Math.floor(Math.random() * 10000000000000)
                    .toString()
                    .padStart(13, '0');
                barcodeInput.value = barcode;
                barcodeInput.readOnly = true; // lock field when auto
            } else {
                barcodeInput.value = "";
                barcodeInput.readOnly = false; // allow manual typing
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('myFile');
        const previewImage = document.getElementById('preview-image');

        // ✅ Preview selected image
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImage.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
