@extends('layouts.main')

@section('title', 'About Us')

@section('content')

    {{-- Hero --}}
    <section class="py-5 text-white" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%);">
        <div class="container text-center">
            <img src="{{ asset('images/OFA New Logo.jpg') }}" alt="OFA Logo"
                 style="width:100px;height:100px;border-radius:50%;border:3px solid #ffc107;object-fit:cover;" class="mb-3 shadow">
            <h1 class="fw-bold display-5">About Olufunke Football Academy</h1>
            <p class="lead opacity-75">Reshaping Nigerian football — blending elite sports development with academic, health, and character education.</p>
        </div>
    </section>

    {{-- History --}}
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-md-6">
                    <h2 class="fw-bold mb-3" style="color:#10316B;">History of Olufunke Football Academy</h2>
                    <p>Olufunke Football Academy <strong>(OFA)</strong> is duly Registered and Affiliated with <strong>FIFA TMS</strong>, <strong>Lagos State Football Association</strong>, and the <strong>Nigeria Football Federation</strong>.</p>
                    <p>Incorporated in <strong>September 2023</strong>, OFA is focused on discovering young, talented footballers and making them better people in society. Based in the vibrant city of Lagos, OFA is registered under <strong>RC-7147523</strong>.</p>
                    <p>The academy emerged from the conviction that Nigeria's footballing future depends not only on athletic prowess but also on strong ethical foundations, academic achievement, and community engagement. Inspired by global models, we have built a home where football dreams ignite and lifelong skills are cultivated.</p>
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <span class="badge fs-6 px-3 py-2" style="background:#10316B;">FIFA TMS Registered</span>
                        <span class="badge fs-6 px-3 py-2 bg-success">LSFA Affiliated</span>
                        <span class="badge fs-6 px-3 py-2 bg-warning text-dark">NFF Member</span>
                        <span class="badge fs-6 px-3 py-2 bg-secondary">RC-7147523</span>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('images/OFA2.jpg') }}" alt="OFA Team" class="img-fluid rounded-3 shadow" style="max-height:380px;object-fit:cover;width:100%;">
                </div>
            </div>
        </div>
    </section>

    {{-- Vision & Mission --}}
    <section class="py-5" style="background:#f0f4ff;">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-4 rounded-3 shadow-sm h-100 bg-white border-start border-4 border-primary">
                        <h3 class="fw-bold mb-3" style="color:#10316B;"><i class="bi bi-eye-fill text-warning me-2"></i>Our Vision</h3>
                        <p class="mb-0">To become <strong>Africa's most prestigious football academy</strong>, setting benchmarks in player development, education, and responsible citizenship — inspiring hope across the continent and beyond.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 rounded-3 shadow-sm h-100 bg-white border-start border-4 border-success">
                        <h3 class="fw-bold mb-3" style="color:#10316B;"><i class="bi bi-bullseye text-success me-2"></i>Our Mission</h3>
                        <ul class="mb-0 ps-3">
                            <li class="mb-2">Nurture young footballers into champions and role models, equipped for success on and off the field.</li>
                            <li class="mb-2">Blend technical mastery with holistic education, health awareness, and social responsibility.</li>
                            <li class="mb-2">Foster a culture of integrity, teamwork, resilience, and lifelong learning.</li>
                            <li>Promote diversity, gender equality, and inclusivity in Nigerian sport.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Core Values --}}
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-5" style="color:#10316B;">Our Core Values</h2>
            <div class="row g-4 text-center">
                <div class="col-6 col-md-3">
                    <div class="p-4 rounded-3 shadow-sm bg-white h-100">
                        <div class="fs-1 mb-2">🏆</div>
                        <h5 class="fw-bold" style="color:#10316B;">Excellence</h5>
                        <p class="text-muted small mb-0">Continuous pursuit of high standards.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-4 rounded-3 shadow-sm bg-white h-100">
                        <div class="fs-1 mb-2">⚖️</div>
                        <h5 class="fw-bold" style="color:#10316B;">Integrity</h5>
                        <p class="text-muted small mb-0">Doing what's right, even when unseen.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-4 rounded-3 shadow-sm bg-white h-100">
                        <div class="fs-1 mb-2">🤝</div>
                        <h5 class="fw-bold" style="color:#10316B;">Teamwork</h5>
                        <p class="text-muted small mb-0">Wins are built on unity and collaboration.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-4 rounded-3 shadow-sm bg-white h-100">
                        <div class="fs-1 mb-2">🎯</div>
                        <h5 class="fw-bold" style="color:#10316B;">Discipline</h5>
                        <p class="text-muted small mb-0">Dedication and respect at every stage.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Leadership --}}
    <section class="py-5" style="background:#f0f4ff;">
        <div class="container">
            <h2 class="fw-bold text-center mb-5" style="color:#10316B;">Leadership &amp; Commitment</h2>

            {{-- President Feature Card --}}
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5">
                <div class="row g-0">
                    <div class="col-md-5" style="min-height:340px;overflow:hidden;background:#10316B;">
                        <img src="{{ asset('images/Olufunke Football Academy president.jpg') }}"
                             alt="Adeshina Akintayo Peter — Founder & President"
                             style="width:100%;height:100%;object-fit:cover;object-position:center top;display:block;">
                    </div>
                    <div class="col-md-7 d-flex align-items-center">
                        <div class="p-4 p-md-5">
                            <span class="badge mb-3 px-3 py-2" style="background:#ffc107;color:#0d1117;font-size:.78rem;">
                                <i class="bi bi-star-fill me-1"></i>Founder &amp; President
                            </span>
                            <h3 class="fw-bold mb-2" style="color:#10316B;">Adeshina Akintayo Peter</h3>
                            <div class="mb-3" style="width:48px;height:4px;background:linear-gradient(90deg,#10316B,#4CAF50);border-radius:2px;"></div>
                            <p class="text-muted mb-3" style="line-height:1.8;">
                                Under the stewardship of <strong>Adeshina Akintayo Peter</strong>, OFA cultivates
                                the next generation of leaders — not just athletes. Every program is guided by a
                                dedicated team of licensed coaches, health educators, and community mentors,
                                delivering world-class football development and life skills.
                            </p>
                            <p class="text-muted mb-0" style="line-height:1.8;">
                                Incorporated in <strong>September 2023</strong>, OFA is registered under
                                <strong>RC-7147523</strong> and affiliated with FIFA TMS, the Lagos State
                                Football Association, and the Nigeria Football Federation.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Management Team --}}
            <h3 class="fw-bold text-center mb-2" style="color:#10316B;">Our Management Team</h3>
            <p class="text-center text-muted mb-4">The dedicated people who run Olufunke Football Academy</p>
            <div class="row g-4 justify-content-center">
                @php
                    $roleColors = [
                        'Founder & President'        => ['bg'=>'#10316B','light'=>'#dbeafe'],
                        'Vice Chairman'              => ['bg'=>'#1a5c2a','light'=>'#dcfce7'],
                        'Sporting Director'          => ['bg'=>'#7c3aed','light'=>'#ede9fe'],
                        'Technical Adviser'          => ['bg'=>'#b45309','light'=>'#fef3c7'],
                        'Team and Marketing Manager' => ['bg'=>'#be185d','light'=>'#fce7f3'],
                    ];
                @endphp
                @foreach($team as $member)
                @php
                    $colors = $roleColors[$member->role] ?? ['bg'=>'#64748b','light'=>'#f1f5f9'];
                    $initials = collect(explode(' ', $member->name))->take(2)->map(fn($w)=>strtoupper(substr($w,0,1)))->join('');
                @endphp
                <div class="col-6 col-md-4 col-lg-2dot4">
                    <div class="text-center p-3 bg-white rounded-4 shadow-sm h-100 border-0"
                         style="border-top:4px solid {{ $colors['bg'] }} !important;border:1px solid #e8edf2;">
                        {{-- Initials avatar --}}
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 fw-bold text-white"
                             style="width:68px;height:68px;font-size:1.35rem;background:linear-gradient(135deg,{{ $colors['bg'] }},{{ $colors['bg'] }}cc);
                                    box-shadow:0 4px 14px {{ $colors['bg'] }}40;">
                            {{ $initials }}
                        </div>
                        <h6 class="fw-bold mb-1" style="color:#0d1117;font-size:.88rem;">{{ $member->name }}</h6>
                        <span class="badge rounded-pill mb-3 px-3" style="background:{{ $colors['light'] }};color:{{ $colors['bg'] }};font-size:.72rem;font-weight:700;">
                            {{ $member->role }}
                        </span>
                        @if($member->email)
                            <div>
                                <a href="mailto:{{ $member->email }}"
                                   class="btn btn-sm fw-semibold px-3"
                                   style="background:{{ $colors['light'] }};color:{{ $colors['bg'] }};border:none;font-size:.75rem;">
                                    <i class="bi bi-envelope-fill me-1"></i>Email
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="mailto:Olufunkefootballacademy@gmail.com" class="btn btn-outline-dark px-4">
                    <i class="bi bi-envelope-fill me-2"></i>Contact Full Management Team
                </a>
            </div>
        </div>
    </section>

    <style>
    .col-lg-2dot4 { width: 20%; }
    @media (max-width: 991px) { .col-lg-2dot4 { width: auto; } }
    </style>

    {{-- Programs Overview --}}
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-5" style="color:#10316B;">Our Unique Programs</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="p-4 rounded-3 shadow-sm bg-white h-100 text-center">
                        <div class="fs-1 mb-3">🎓</div>
                        <h5 class="fw-bold" style="color:#10316B;">Football Education</h5>
                        <p class="text-muted">Modular video courses on technical skills, tactical theory, and sports psychology. Includes gamified challenges and AI-driven player matching.</p>
                        <a href="{{ route('football-education') }}" class="btn btn-sm btn-primary">Explore E-Learning</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 rounded-3 shadow-sm bg-white h-100 text-center">
                        <div class="fs-1 mb-3">⚽</div>
                        <h5 class="fw-bold" style="color:#10316B;">Technical Training</h5>
                        <p class="text-muted">Individual and group sessions focusing on ball mastery, tactical awareness, game intelligence, and physical fitness.</p>
                        <a href="{{ route('program') }}" class="btn btn-sm btn-success">View Program</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 rounded-3 shadow-sm bg-white h-100 text-center">
                        <div class="fs-1 mb-3">🛒</div>
                        <h5 class="fw-bold" style="color:#10316B;">Academy Store &amp; Booking</h5>
                        <p class="text-muted">Buy official jerseys, gear, and book training packages securely via Paystack or Flutterwave.</p>
                        <a href="{{ route('store') }}" class="btn btn-sm btn-warning text-dark">Visit Store</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 rounded-3 shadow-sm bg-white h-100 text-center">
                        <div class="fs-1 mb-3">🏥</div>
                        <h5 class="fw-bold" style="color:#10316B;">Health Education</h5>
                        <p class="text-muted">Nutrition, mental health, and injury prevention counseling led by certified professionals.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 rounded-3 shadow-sm bg-white h-100 text-center">
                        <div class="fs-1 mb-3">🌱</div>
                        <h5 class="fw-bold" style="color:#10316B;">Environmental Initiatives</h5>
                        <p class="text-muted">"Green Goal" campaigns teaching sustainability and stewardship of local playing fields and environments.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 rounded-3 shadow-sm bg-white h-100 text-center">
                        <div class="fs-1 mb-3">🤲</div>
                        <h5 class="fw-bold" style="color:#10316B;">Community Engagement</h5>
                        <p class="text-muted">Volunteering, mentorship and outreach programs foster inclusivity and a sense of giving back.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FIFA --}}
    <section class="bg-light py-5">
        <div class="container text-center">
            <h2 class="fw-bold">🌍 FIFA Talent Development</h2>
            <p class="text-muted">We align with global standards through FIFA's Training Centre and international partnerships.</p>
            <a href="https://www.fifatrainingcentre.com" target="_blank" rel="noopener" class="btn btn-outline-primary px-4">Visit FIFA Training Centre</a>
        </div>
    </section>
    {{-- Weekly Football IQ Quiz CTA --}}
    <section class="py-5" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%);">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-md-8 text-white">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span style="font-size:3rem;">🧠⚽</span>
                        <div>
                            <h2 class="fw-bold mb-1">Weekly Football IQ Quiz</h2>
                            <p class="opacity-75 mb-0">Think you know football? Prove it! Open to everyone — no login required.</p>
                        </div>
                    </div>
                    <div class="d-flex gap-3 flex-wrap">
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                            <i class="bi bi-lightning-fill me-1"></i>New Quiz Every Week
                        </span>
                        <span class="badge bg-white text-dark fs-6 px-3 py-2">
                            <i class="bi bi-trophy-fill me-1 text-warning"></i>Live Leaderboard
                        </span>
                        <span class="badge bg-success fs-6 px-3 py-2">
                            <i class="bi bi-people-fill me-1"></i>Free for Everyone
                        </span>
                    </div>
                </div>
                <div class="col-md-4 text-center text-md-end">
                    <a href="{{ route('quiz.index') }}" class="btn btn-warning btn-lg fw-bold px-5 shadow">
                        <i class="bi bi-play-fill me-2"></i>Take the Quiz
                    </a>
                </div>
            </div>
        </div>
    </section>


    <div class="py-3 text-center bg-white">
        <a href="#top" class="btn btn-outline-dark btn-sm"><i class="bi bi-arrow-up-circle"></i> Back to Top</a>
    </div>

@endsection
