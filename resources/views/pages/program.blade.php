@extends('layouts.main')

@section('title', 'Our Program')

@section('content')

    {{-- Hero --}}
    <section class="py-5 text-white" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%);">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-md-7">
                    <h1 class="fw-bold display-5">Our Program</h1>
                    <p class="lead opacity-75">A holistic football development pathway — from grassroots to elite competition — built on technical excellence, education, and character.</p>
                    <a href="{{ route('contact') }}" class="btn btn-warning btn-lg fw-bold shadow">Book a Trial</a>
                </div>
                <div class="col-md-5 text-center d-none d-md-block">
                    <img src="{{ asset('images/OFA.jpg') }}" alt="OFA Training"
                         class="img-fluid rounded-3 shadow" style="max-height:300px;object-fit:cover;width:100%;">
                </div>
            </div>
        </div>
    </section>

    {{-- Technical Training --}}
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-md-6">
                    <img src="{{ asset('images/training ground.jpg') }}" alt="Technical Training"
                         class="img-fluid rounded-3 shadow" style="max-height:340px;object-fit:cover;width:100%;">
                </div>
                <div class="col-md-6">
                    <h2 class="fw-bold mb-3" style="color:#10316B;"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Technical Training</h2>
                    <p>Individual and group sessions focusing on <strong>ball mastery, tactical awareness, game intelligence, and physical fitness</strong>. Our licensed coaches deliver structured drills that mirror elite-level training environments.</p>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Ball control &amp; dribbling mastery</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Passing, shooting &amp; set-piece training</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Tactical positioning &amp; game intelligence</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Physical conditioning &amp; fitness</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Video analysis &amp; performance review</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Team Formation --}}
    <section class="py-5" style="background:#f0f4ff;">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-md-6 order-md-2">
                    <img src="{{ asset('images/studium.jpg') }}" alt="Team Formation"
                         class="img-fluid rounded-3 shadow" style="max-height:340px;object-fit:cover;width:100%;">
                </div>
                <div class="col-md-6 order-md-1">
                    <h2 class="fw-bold mb-3" style="color:#10316B;"><i class="bi bi-people-fill text-primary me-2"></i>Team Formation</h2>
                    <p>Structured teams by age and skill level, with regular intra-academy matches and participation in tournaments and leagues. We develop players within a competitive but supportive team environment.</p>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Age-group squads: U13, U15, U17, U19</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Regular intra-academy matches</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Lagos State League participation</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>National tournament exposure</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Tournaments --}}
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-md-6">
                    <img src="{{ asset('images/cele1.jpg') }}" alt="Tournaments"
                         class="img-fluid rounded-3 shadow" style="max-height:340px;object-fit:cover;width:100%;">
                </div>
                <div class="col-md-6">
                    <h2 class="fw-bold mb-3" style="color:#10316B;"><i class="bi bi-trophy-fill text-warning me-2"></i>Tournaments &amp; Competitions</h2>
                    <p>Active involvement in local, regional, and national competitions, driving exposure and experience for our players. OFA has already proven its competitive edge at the highest grassroots level.</p>
                    <div class="row g-3 mt-2">
                        <div class="col-6">
                            <div class="p-3 bg-white rounded-3 shadow-sm text-center">
                                <div class="fw-bold fs-4 text-success">🏆</div>
                                <small class="fw-semibold">Lagos State U17 Champions</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-white rounded-3 shadow-sm text-center">
                                <div class="fw-bold fs-4 text-primary">⚽</div>
                                <small class="fw-semibold">Lagos State League Finalists</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-white rounded-3 shadow-sm text-center">
                                <div class="fw-bold fs-4 text-warning">🥇</div>
                                <small class="fw-semibold">Unbeaten Tournament Run</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-white rounded-3 shadow-sm text-center">
                                <div class="fw-bold fs-4">🌍</div>
                                <small class="fw-semibold">FIFA TMS Registered</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Health & Community --}}
    <section class="py-5" style="background:#f0f4ff;">
        <div class="container">
            <h2 class="fw-bold text-center mb-5" style="color:#10316B;">Beyond the Pitch</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded-3 shadow-sm h-100 text-center">
                        <div class="fs-1 mb-3">🏥</div>
                        <h5 class="fw-bold" style="color:#10316B;">Health Education</h5>
                        <p class="text-muted">Nutrition, mental health, and injury prevention counseling led by certified professionals. We ensure every player is physically and mentally equipped.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded-3 shadow-sm h-100 text-center">
                        <div class="fs-1 mb-3">🌱</div>
                        <h5 class="fw-bold" style="color:#10316B;">Environmental Initiatives</h5>
                        <p class="text-muted">"Green Goal" campaigns teaching sustainability and stewardship of local playing fields and environments. Football as a force for the planet.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded-3 shadow-sm h-100 text-center">
                        <div class="fs-1 mb-3">🤲</div>
                        <h5 class="fw-bold" style="color:#10316B;">Community Engagement</h5>
                        <p class="text-muted">Volunteering, mentorship and outreach programs foster inclusivity and a sense of giving back. OFA graduates lead in their communities.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-5">
        <div class="container">
            <div class="p-5 rounded-3 text-white text-center shadow"
                 style="background:linear-gradient(90deg,#4CAF50 40%,#10316B 100%);">
                <h2 class="fw-bold mb-3">Ready to Join OFA?</h2>
                <p class="lead mb-4">OFA graduates are not only ready for elite competitions, but are also prepared for leadership in their communities and beyond.</p>
                <a href="{{ route('contact') }}" class="btn btn-warning btn-lg fw-bold px-5">Contact Us Now</a>
            </div>
        </div>
    </section>

    <div class="py-3 text-center bg-white">
        <a href="#top" class="btn btn-outline-dark btn-sm"><i class="bi bi-arrow-up-circle"></i> Back to Top</a>
    </div>

@endsection
