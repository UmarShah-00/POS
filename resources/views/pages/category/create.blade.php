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
            <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data"
                class="form-categories-create form-type-3" id="category-form">
                @csrf
                <div class="flex flex-wrap justify-between gap14 items-center mb-30">
                    <h4 class="heading">Create Category</h4>
                    <button type="submit" class="tf-button text-btn-uppercase">
                        Save
                    </button>
                </div>
                <div class="wg-box p-40">
                    <div class="">
                        {{-- Upload Image --}}
                        <fieldset>
                            <div class="text-caption-1 mb-8">Category Image <span class="text-primary">*</span></div>
                            <div class="upload-image style-2">
                                <div class="upload-img">
                                    {{-- Preview Image --}}
                                    <img src="{{ asset('images/categories/categories-img-1.jpg') }}" id="preview-image"
                                        alt="Preview" style="max-width: 200px; border-radius: 6px;">
                                </div>
                                <label class="uploadfile" for="myFile">
                                    <input type="file" id="myFile" name="filename" accept="image/*">
                                    <div class="upload-btn text-button font-instrument fw-6">Choose File</div>
                                    <div class="text-caption-1 font-instrument text-secondary">Upload file</div>
                                </label>
                            </div>
                        </fieldset>

                        {{-- Name & Slug (side by side col-6) --}}
                        <div class="row mt-5">
                            <fieldset class="col-12">
                                <div class="text-caption-1 mb-8">Name <span class="text-primary">*</span></div>
                                <input type="text" placeholder="Enter category name" class="form-control" name="name"
                                    value="" required id="category-name">
                            </fieldset>
                        </div>
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
        const form = document.getElementById("category-form");

        form.addEventListener("submit", async function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            try {
                const response = await fetch("{{ route('category.store') }}", {
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
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('category-name');
        const slugInput = document.getElementById('category-slug');
        const fileInput = document.getElementById('myFile');
        const previewImage = document.getElementById('preview-image');

        // ✅ Slug auto-generate from name
        nameInput.addEventListener('input', function() {
            const slug = slugify(this.value);
            slugInput.value = slug;
        });

        function slugify(text) {
            return text.toString().toLowerCase().trim()
                .replace(/\s+/g, '-') // space to dash
                .replace(/[^\w\-]+/g, '') // remove special chars
                .replace(/\-\-+/g, '-') // multiple dash -> one
                .replace(/^-+/, '') // trim start
                .replace(/-+$/, ''); // trim end
        }

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
