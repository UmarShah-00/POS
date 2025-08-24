@extends('layouts.custom-master'))
@section('content')
    <main class="login-form d-flex align-items-center min-vh-100 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card shadow-lg rounded-3 border-0">

                        <!-- Header -->
                        <div class="card-header text-center fs-5 fw-bold" style="background-color: #906ae2 !important; color: white;">
                            🔐 Reset Password
                        </div>

                        <!-- Body -->
                        <div class="card-body p-4">
                            <form action="{{ route('reset.password.post') }}" method="POST">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email_address" class="form-label fw-semibold">E-Mail Address</label>
                                    <input type="email" id="email_address"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">New Password</label>
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-3">
                                    <label for="password-confirm" class="form-label fw-semibold">Confirm Password</label>
                                    <input type="password" id="password-confirm"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" required>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Button -->
                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary fw-bold">
                                        Reset Password
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Footer -->
                        <div class="card-footer text-center small text-muted">
                            Make sure your new password is strong and secure
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
