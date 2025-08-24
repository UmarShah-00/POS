@extends('layouts.custom-master')
@section('styles')
@endsection
@section('content')
<main class="login-form d-flex align-items-center min-vh-100 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg rounded-3 border-0">
                    <div class="card-header text-center fs-5 fw-bold" style="background-color: #906ae2 !important; color: white;">
                        🔑 Reset Password
                    </div>
                    <div class="card-body p-4">

                        @if (Session::has('message'))
                            <div class="alert alert-success text-center" role="alert">
                                {{ Session::get('message') }}
                            </div>
                        @endif

                        <form action="{{ route('forget.password.post') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email_address" class="form-label fw-semibold">E-Mail Address</label>
                                <input type="email" id="email_address" class="form-control" name="email"
                                    placeholder="Enter your email" required autofocus>
                                @if ($errors->has('email'))
                                    <small class="text-danger">{{ $errors->first('email') }}</small>
                                @endif
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary fw-bold">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center small text-muted">
                        Enter your registered email to receive reset instructions
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
