@extends('layouts.main')

@section('title', 'Our Store')

@section('content')

    {{-- Hero --}}
    <section class="py-5 text-white text-center" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%);">
        <div class="container">
            <h1 class="fw-bold display-5"><i class="bi bi-shop-window me-2"></i>OFA Store &amp; Booking</h1>
            <p class="lead opacity-75">Shop official gear and book training packages securely.</p>
            <span class="badge bg-warning text-dark fs-6 px-3 py-2">🚀 Coming Soon — Full Online Checkout</span>
        </div>
    </section>

    {{-- Merchandise --}}
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold mb-4" style="color:#10316B;"><i class="bi bi-bag-heart-fill text-warning me-2"></i>Official Merchandise</h2>
            <div class="row g-4">
                @foreach($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden product-card">
                        <div style="height:200px;overflow:hidden;">
                            <img src="{{ asset($product->image_path) }}"
                                 alt="{{ $product->name }}"
                                 class="w-100 h-100"
                                 style="object-fit:cover;transition:transform .3s;"
                                 onmouseover="this.style.transform='scale(1.05)'"
                                 onmouseout="this.style.transform='scale(1)'">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h6 class="fw-bold mb-1" style="color:#10316B;">{{ $product->name }}</h6>
                            <p class="text-muted small flex-grow-1">{{ $product->description }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="fw-bold text-success fs-5">₦{{ number_format($product->price, 0) }}</span>
                                <button class="btn btn-sm btn-outline-primary" disabled title="Coming Soon">
                                    <i class="bi bi-cart-plus"></i> Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Booking Packages --}}
    <section class="py-5" style="background:#f0f4ff;">
        <div class="container">
            <h2 class="fw-bold mb-2" style="color:#10316B;"><i class="bi bi-calendar-check-fill text-success me-2"></i>Booking Packages</h2>
            <p class="text-muted mb-4">Choose a training package and secure your spot at Olufunke Football Academy.</p>
            <div class="row g-4">
                @foreach($packages as $pkg)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow rounded-3 overflow-hidden">
                        <div class="card-header text-white fw-bold text-center py-3" style="background:#10316B;">
                            {{ $pkg->name }}
                        </div>
                        <div class="card-body text-center d-flex flex-column">
                            <div class="display-6 fw-bold text-success my-3">₦{{ number_format($pkg->price, 0) }}</div>
                            <p class="text-muted flex-grow-1">{{ $pkg->description }}</p>
                            @if($pkg->duration)
                                <p class="small"><i class="bi bi-clock text-primary"></i> Duration: <strong>{{ $pkg->duration }}</strong></p>
                            @endif
                            @if($pkg->group_size)
                                <p class="small"><i class="bi bi-people text-success"></i> Group: <strong>{{ $pkg->group_size }}</strong></p>
                            @endif
                            <a href="{{ route('contact') }}" class="btn btn-success mt-2 fw-bold">
                                <i class="bi bi-calendar2-check"></i> Book &amp; Pay
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Payment note --}}
    <section class="py-4 bg-white">
        <div class="container text-center">
            <p class="text-muted mb-2">Secure payments powered by</p>
            <div class="d-flex justify-content-center gap-4 align-items-center flex-wrap">
                <span class="badge bg-success fs-6 px-4 py-2">Paystack</span>
                <span class="badge bg-primary fs-6 px-4 py-2">Flutterwave</span>
            </div>
            <p class="text-muted small mt-3">For orders and inquiries: <a href="mailto:Olufunkefootballacademy@gmail.com">Olufunkefootballacademy@gmail.com</a> | 📞 09079917993</p>
        </div>
    </section>

    <div class="py-3 text-center">
        <a href="#top" class="btn btn-outline-dark btn-sm"><i class="bi bi-arrow-up-circle"></i> Back to Top</a>
    </div>

@endsection
