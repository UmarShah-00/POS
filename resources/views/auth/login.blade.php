@extends('auth.layouts.app')

@section('content')
<style>
.form-check-input:checked {
    background-color:#1c1f23;
}

/* Optional Styling for Typing Effect */
.typing-text {
    font-size: 70px;
    font-weight: 700;
    color: #fff;
}
.cursor {
    display: inline-block;
    background-color: #fff;
    width: 3px;
    margin-left: 3px;
    animation: blink 0.7s steps(1) infinite;
}
@keyframes blink {
    50% { opacity: 0; }
}
</style>

<!-- Section: Login Page -->
<section class="min-vh-100 d-flex align-items-center" style="background-color: #000;">
    <div class="container py-5">
        <div class="row align-items-center justify-content-between">
            
            <!-- Left Content -->
            <div class="col-lg-6 text-white mb-5 mb-lg-0">
                <h1 class="display-4 fw-bold typing-text">
                    <span id="typed"></span>
                </h1>
                <p class="mt-4 fs-5 text-secondary" style="font-size: 18px!important;">
                    Manage your inventory, track sales, and simplify billing — all in one place.  
                    Login to your POS dashboard and take control of your business today!
                </p>
            </div>

            <!-- Login Card -->
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5 bg-white" style="padding: 42px 26px !important;">
                        <h3 class="mb-4 text-center fw-bold text-dark">Sign In to POS</h3>

                        <form method="POST" action="{{ route('login.submit') }}" class="form-login form-has-password" style="padding: 25px 0px;">
                            @csrf

                            <!-- Email -->
                            <div class="form-outline mb-4" style="padding: 20px 0px;">
                                <label class="form-label text-dark" for="email">Email Address <span class="text-danger">*</span></label>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}"
                                       placeholder="Enter your email"
                                       required
                                       autofocus>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-outline mb-4 position-relative">
                                <label class="form-label text-dark" for="password">Password <span class="text-danger">*</span></label>
                                <input type="password"
                                       id="password"
                                       name="password"
                                       class="form-control input-password @error('password') is-invalid @enderror"
                                       placeholder="Enter your password"
                                       required>
                                <span class="position-absolute toggle-password"
                                      style="top: 68%; right: 15px; transform: translateY(-50%); cursor: pointer;">
                                    <i class="icon-eye-hide-line text-muted"></i>
                                </span>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check" style="padding: 17px 22px;">
                                    <input type="checkbox"
                                           class="form-check-input"
                                           name="remember"
                                           id="remember"
                                           {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember" style="padding: 0 10px;">
                                        Keep me signed in
                                    </label>
                                </div>

                                @if (Route::has('forget.password.get'))
                                    <a href="{{ route('forget.password.get') }}"
                                       class="text-decoration-none text-muted small">
                                       Forgot Password?
                                    </a>
                                @endif
                            </div>

                            <!-- Login Button -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-dark btn-lg" style="padding: 8px; font-size: 20px;">
                                    Access Dashboard
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@section('script')
<!-- Typed.js Script -->
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        new Typed("#typed", {
            strings: [
                "Smart POS",
                "Point of Sale System"
            ],
            typeSpeed: 80,
            backSpeed: 40,
            loop: true
        });
    });
</script>
@endsection
