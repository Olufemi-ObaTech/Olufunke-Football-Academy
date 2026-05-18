@extends('layouts.main')

@section('title', 'Login')

@section('content')

<section class="py-5 d-flex align-items-center" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%); min-height:90vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">

                <div class="text-center text-white mb-4">
                    <img src="{{ asset('images/OFA New Logo.jpg') }}" alt="OFA Logo"
                         style="width:90px;height:90px;border-radius:50%;border:3px solid #ffc107;object-fit:cover;" class="mb-3 shadow">
                    <h2 class="fw-bold">Welcome Back</h2>
                    <p class="opacity-75 small">Log in to access your OFA player portal</p>
                </div>

                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-header text-white fw-bold py-3 text-center" style="background:#10316B;">
                        <i class="bi bi-shield-lock-fill me-2"></i>Player / Admin Login
                    </div>
                    <div class="card-body p-4">

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show py-2">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show py-2">
                                <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('login') }}" method="POST" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                    <input type="email" id="email" name="email"
                                           class="form-control form-control-lg @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" placeholder="your@email.com" required autofocus>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" id="password" name="password"
                                           class="form-control form-control-lg @error('password') is-invalid @enderror"
                                           placeholder="Your password" required>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label small" for="remember">Remember me</label>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg fw-bold">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Log In
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">
                        <p class="text-center text-muted small mb-0">
                            New player?
                            <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color:#10316B;">Register Here</a>
                        </p>
                    </div>
                </div>

                <p class="text-center text-white opacity-75 small mt-3">
                    <i class="bi bi-info-circle me-1"></i>
                    Only registered &amp; approved players and admins can access Our Program and Football Education pages.
                </p>

            </div>
        </div>
    </div>
</section>

@endsection
