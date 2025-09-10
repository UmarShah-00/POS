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
    <!-- Main Content -->
    <div class="main-content">
        <div class="main-content-inner">

            <!-- Profile/Staff Form -->
            <form action="{{ route('staff.store') }}" method="POST" class="form-user-profile" id="staff-form">
                @csrf

                <!-- Header -->
                <div class="flex flex-wrap justify-between gap-4 items-center mb-30">
                    <h4 class="heading">Create User</h4>
                    <button type="submit" class="tf-button text-btn-uppercase">
                        Save
                    </button>
                </div>

                <!-- Form Wrapper -->
                <div class="wg-box p-6 reviews-details-wrap mb-6">

                    <!-- Name & Email & Role -->
                    <div class="form-cols mb-20">
                        <!-- Name -->
                        <fieldset>
                            <label class="text-caption-1 mb-2">
                                Name <span class="text-primary">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </fieldset>

                        <!-- Email -->
                        <fieldset>
                            <label class="text-caption-1 mb-2">
                                Email <span class="text-primary">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </fieldset>

                        <!-- Role -->
                        <fieldset>
                            <label class="text-caption-1 mb-2">
                                Role <span class="text-primary">*</span>
                            </label>
                            <select name="role" class="form-control" required style="height: 47px; font-size: 15px;">
                                <option value="">-- Select Role --</option>
                                <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>
                                    Admin</option>
                                <option value="cashier"
                                    {{ old('role', $user->role ?? '') === 'cashier' ? 'selected' : '' }}>Cashier</option>
                            </select>
                            @error('role')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </fieldset>
                    </div>

                    <!-- Password & Confirm Password -->
                    <div class="form-cols">
                        <!-- Password -->
                        <fieldset class="relative">
                            <label class="text-caption-1 mb-2">Password</label>
                            <input type="password" id="password" name="password">
                            <i class="fa fa-eye toggle-password" data-target="password"
                                style="position:absolute; right:15px; top:40px; cursor:pointer;"></i>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </fieldset>

                        <!-- Confirm Password -->
                        <fieldset class="relative">
                            <label class="text-caption-1 mb-2">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation">
                            <i class="fa fa-eye toggle-password" data-target="password_confirmation"
                                style="position:absolute; right:15px; top:40px; cursor:pointer;"></i>
                        </fieldset>
                    </div>

                </div>
                <!-- /Form Wrapper -->
            </form>
            <!-- /Profile/Staff Form -->

        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("staff-form");

        form.addEventListener("submit", async function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            try {
                const response = await fetch("{{ route('staff.store') }}", {
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
        // ✅ Password Toggle
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);

                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            });
        });
    });
</script>
