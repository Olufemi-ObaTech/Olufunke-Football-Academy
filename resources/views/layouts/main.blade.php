@php
use Illuminate\Support\Str;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olufunke Football Academy | @yield('title', 'Official Website')</title>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background: #f9f9f9;
            color: #222831;
        }
        .hero-section {
            background: linear-gradient(rgba(16,49,107,0.8),rgba(16,49,107,0.7)), url('{{ asset("images/OFA 1.jpg") }}') center/cover no-repeat;
            color: #fff;
            min-height: 450px;
            display: flex;
            align-items: center;
            position: relative;
        }
        .hero-overlay {
            background: rgba(16, 49, 107, 0.66);
            padding: 50px 0;
            border-radius: 0 0 40px 40px;
        }
        .scoreboard-table {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 16px rgba(16,49,107,0.09);
            overflow: hidden;
        }
        .player-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(16,49,107,0.06);
            margin-bottom: 24px;
            transition: transform 0.18s;
        }
        .player-card:hover {
            transform: translateY(-4px) scale(1.02);
        }
        .profile-img {
            max-width: 100px;
            border-radius: 50%;
        }
        .cta-banner {
            background: linear-gradient(90deg, #4CAF50 42%, #10316B 100%);
            color: #fff;
            border-radius: 14px;
            box-shadow: 0 6px 24px rgba(16,49,107,0.11);
            padding: 36px;
            text-align: center;
        }
        .value-icon {
            font-size: 2rem;
            color: #4CAF50;
        }
        img { max-width: 100%; height: auto; }
        img[src=""], img:not([src]) { background: #e9ecef; }
        .card-img-top { width: 100%; object-fit: cover; }
        .news-card .card-img-top { background: #e9ecef; min-height: 200px; }
        /* Lagos time bar */
        #ofa-time-bar {
            background: linear-gradient(90deg,#10316B,#1a4a9e);
            color:#fff; font-size:.78rem; padding:5px 0;
            display:flex; align-items:center; justify-content:center;
            gap:16px; flex-wrap:wrap; letter-spacing:.01em;
        }
        #ofa-time-bar .time-sep { opacity:.35; }
        @media print {
            #ofa-time-bar { display:none; }
        }
        .profile-img-fallback {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: linear-gradient(135deg,#10316B,#4CAF50);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 2.5rem;
            border: 3px solid #4CAF50;
        }
        /* Social icon brand colours */
        .text-youtube   { color: #FF0000; transition: opacity .2s; }
        .text-facebook  { color: #1877F2; transition: opacity .2s; }
        .text-instagram { color: #E1306C; transition: opacity .2s; }
        .text-youtube:hover, .text-facebook:hover, .text-instagram:hover { opacity: .75; }
    </style>
</head>
<body>
    <!-- Lagos Live Time Bar -->
    <div id="ofa-time-bar">
        <span><i class="bi bi-geo-alt-fill me-1" style="color:#fbbf24;"></i>Lagos, Nigeria</span>
        <span class="time-sep">|</span>
        <span id="ofa-live-date"></span>
        <span class="time-sep">|</span>
        <span id="ofa-live-time" style="font-weight:700;color:#fbbf24;"></span>
        <span style="color:rgba(255,255,255,.5);font-size:.72rem;">WAT (UTC+1)</span>
    </div>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 sticky-top shadow">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ url('/') }}">
                <img src="{{ asset('images/OFA New Logo.jpg') }}" alt="OFA Logo" width="48" height="48" class="rounded-circle border border-warning border-2" style="object-fit:cover;">
                <span class="text-warning">OLUFUNKE FOOTBALL ACADEMY</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto align-items-lg-center">

                    {{-- Always visible public links --}}
                    <li class="nav-item"><a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ Request::is('about-us') ? 'active' : '' }}" href="{{ url('/about-us') }}">About Us</a></li>
                    <!-- <li class="nav-item"><a class="nav-link {{ Request::is('our-store') ? 'active' : '' }}" href="{{ url('/our-store') }}">Our Store</a></li> -->
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('quiz*') ? 'active' : '' }}" href="{{ route('quiz.index') }}">
                            🧠 Football IQ Quiz
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link {{ Request::is('contact-us') ? 'active' : '' }}" href="{{ url('/contact-us') }}">Contact Us</a></li>

                    {{-- Auth-aware section --}}
                    @auth
                        {{-- Logged-in: show member pages inside dropdown --}}
                        <li class="nav-item dropdown ms-lg-2">
                            <a class="nav-link dropdown-toggle fw-semibold text-warning d-flex align-items-center gap-1"
                               href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-5"></i>
                                <span>{{ Str::words(auth()->user()->name, 1, '') }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="min-width:220px;">

                                {{-- Dashboard link --}}
                                @if(auth()->user()->isAdmin())
                                    <li>
                                        <a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-shield-fill-check me-2 text-primary"></i>Admin Dashboard
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a class="dropdown-item py-2" href="{{ route('dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2 text-success"></i>My Dashboard
                                        </a>
                                    </li>
                                @endif

                                <li><hr class="dropdown-divider my-1"></li>

                                {{-- Member-only pages (approved players + admin) --}}
                                @if(auth()->user()->isAdmin() || auth()->user()->isApproved())
                                    <li>
                                        <span class="dropdown-header small text-uppercase text-muted px-3 py-1">
                                            <i class="bi bi-lock-fill me-1 text-success"></i>Members Area
                                        </span>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 {{ Request::is('our-program') ? 'active' : '' }}"
                                           href="{{ route('program') }}">
                                            <i class="bi bi-trophy-fill me-2 text-warning"></i>Our Program
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 {{ Request::is('football-education') ? 'active' : '' }}"
                                           href="{{ route('football-education') }}">
                                            <i class="bi bi-mortarboard-fill me-2 text-primary"></i>Football Education
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                @endif

                                {{-- Logout --}}
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Log Out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        {{-- Guest: Login + Register buttons --}}
                        <li class="nav-item ms-lg-2">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item ms-lg-1">
                            <a class="btn btn-warning btn-sm fw-bold px-3 py-2" href="{{ route('register') }}">
                                <i class="bi bi-person-plus-fill me-1"></i>Register
                            </a>
                        </li>
                    @endauth

                </ul>
            </div>
        </div>
    </nav>

    <!-- Content Placeholder -->
    @yield('content')

    <!-- Footer -->
    <footer class="bg-dark text-light pt-4 pb-2 mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-12 col-md-4 text-center text-md-start mb-3 mb-md-0">
                    <a href="{{ url('/') }}" class="d-inline-flex align-items-center link-light text-decoration-none">
                        <img src="{{ asset('images/OFA New Logo.jpg') }}" alt="Olufunke Football Academy Logo" width="48" height="48" class="me-2" loading="lazy">
                        <span class="fs-5 fw-bold">Olufunke Football Academy</span>
                    </a>
                    <p class="small mt-2 mb-0">Nurturing football talent for the future.</p>
                    <p class="small mt-2 mb-0">Proud member of Lagos State Football Association, and Nigeria Football Federation.</p>
                </div>
                <div class="col-md-4 d-none d-md-block">
                    <ul class="nav justify-content-center">
                        <li class="nav-item"><a href="{{ url('/') }}" class="nav-link px-2 text-light">Home</a></li>
                        <li class="nav-item"><a href="{{ url('/about-us') }}" class="nav-link px-2 text-light">About Us</a></li>
                        <li class="nav-item"><a href="{{ url('/contact-us') }}" class="nav-link px-2 text-light">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-sm-12 col-md-4 text-center text-md-end">
                    <ul class="list-unstyled d-flex justify-content-center justify-content-md-end mb-0">
                        <li class="ms-3">
                            <a class="text-youtube" href="https://www.youtube.com/@olufunkefootballacademy" target="_blank" rel="noopener noreferrer" aria-label="Visit our YouTube channel">
                                <i class="bi bi-youtube fs-3" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="ms-3">
                            <a class="text-facebook" href="https://web.facebook.com/people/Olufunke-Football-Academy/61554694136830/" target="_blank" rel="noopener noreferrer" aria-label="Visit our Facebook page">
                                <i class="bi bi-facebook fs-3" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="ms-3">
                            <a class="text-instagram" href="https://www.instagram.com/olufunkefootballacademy?igsh=YjBoZGtxc2VxbzE5" target="_blank" rel="noopener noreferrer" aria-label="Visit our Instagram profile">
                                <i class="bi bi-instagram fs-3" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center mt-3">
                    <small>&copy; {{ date('Y') }} Olufunke Football Academy. All rights reserved.</small> <br>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Live Lagos Time Clock -->
    <script>
    (function() {
        var dateEl = document.getElementById('ofa-live-date');
        var timeEl = document.getElementById('ofa-live-time');
        function tick() {
            var now = new Date();
            if (dateEl) dateEl.textContent = now.toLocaleDateString('en-GB', {
                timeZone: 'Africa/Lagos', weekday: 'short', day: 'numeric', month: 'short', year: 'numeric'
            });
            if (timeEl) timeEl.textContent = now.toLocaleTimeString('en-GB', {
                timeZone: 'Africa/Lagos', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true
            });
        }
        tick();
        setInterval(tick, 1000);
    })();
    </script>

    @stack('scripts')
</body>
</html>