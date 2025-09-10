@extends('layout.app')
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
@section('content')
    <!-- main-content -->
    <div class="main-content">
        <!-- main-content-inner -->
        <div class="main-content-inner">
            <form action="{{ route('admin.profile.update') }}" method="POST" class="form-user-profile">
                @csrf
                <div class="flex flex-wrap justify-between gap14 items-center mb-30">
                    <h4 class="heading">Profile Update</h4>
                    <button type="submit" class="tf-button text-btn-uppercase">
                        Save
                    </button>
                </div>

                <div class="wg-box p-40 reviews-details-wrap mb-30">
                    <!-- First Name + Email -->
                    <div class="form-cols">
                        <fieldset>
                            <div class="text-caption-1 mb-8">
                                 Name<span class="text-primary">*</span>
                            </div>
                            <input type="text" name="first_name" value="{{ old('first_name', $admin->name) }}" required>
                            @error('first_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </fieldset>

                        <fieldset>
                            <div class="text-caption-1 mb-8">
                                Email<span class="text-primary">*</span>
                            </div>
                            <input type="email" name="email" value="{{ old('email', $admin->email) }}" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </fieldset>
                    </div>

                    <!-- Password + Confirm Password -->
                    <div class="form-cols">
                        <fieldset style="position: relative;">
                            <div class="text-caption-1 mb-8">Password (leave blank to keep current)</div>
                            <input type="password" id="password" name="password">
                            <i class="fa fa-eye toggle-password" data-target="password"
                                style="position:absolute; right:10px; top:40px; cursor:pointer;"></i>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </fieldset>

                        <fieldset style="position: relative;">
                            <div class="text-caption-1 mb-8">Confirm Password</div>
                            <input type="password" id="password_confirmation" name="password_confirmation">
                            <i class="fa fa-eye toggle-password" data-target="password_confirmation"
                                style="position:absolute; right:10px; top:40px; cursor:pointer;"></i>
                        </fieldset>
                    </div>
                </div>
            </form>
        </div>
        <!-- /main-content-inner -->
    </div>
    <!-- /main-content -->

    <!-- ===================== SCRIPTS ===================== -->
    <!-- FontAwesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"
        integrity="sha512-pVJzZZzQW7U6U8WmWMCX9gE3D8Rm5Bz6VqN7Z5L4D8wJ7OHnXhX8aY6aIVRQ7zWqUFrYV6cBFKbcQ+TXxjz5xg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ✅ SweetAlert Success
            @if (session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif

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
@endsection
