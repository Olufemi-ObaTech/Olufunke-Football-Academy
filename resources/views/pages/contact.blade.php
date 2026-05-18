@extends('layouts.main')

@section('title', 'Contact Us')

@section('content')

    {{-- Hero --}}
    <section class="py-5 text-white text-center" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%);">
        <div class="container">
            <h1 class="fw-bold display-5"><i class="bi bi-envelope-heart-fill me-2"></i>Contact Us</h1>
            <p class="lead opacity-75">We'd love to hear from you — reach out for trials, inquiries, or partnerships.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-5">

                {{-- Contact Info --}}
                <div class="col-md-5">
                    <h3 class="fw-bold mb-4" style="color:#10316B;">Get In Touch</h3>

                    <div class="d-flex align-items-start mb-4">
                        <div class="me-3 p-3 rounded-circle text-white" style="background:#10316B;min-width:50px;text-align:center;">
                            <i class="bi bi-telephone-fill fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Phone</h6>
                            <a href="tel:09079917993" class="text-decoration-none text-dark">09079917993</a>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <div class="me-3 p-3 rounded-circle text-white" style="background:#4CAF50;min-width:50px;text-align:center;">
                            <i class="bi bi-envelope-fill fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Email</h6>
                            <a href="mailto:Olufunkefootballacademy@gmail.com" class="text-decoration-none text-dark">Olufunkefootballacademy@gmail.com</a>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <div class="me-3 p-3 rounded-circle text-white" style="background:#ffc107;min-width:50px;text-align:center;">
                            <i class="bi bi-geo-alt-fill fs-5 text-dark"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Location</h6>
                            <p class="mb-0 text-muted">Lagos State, Nigeria</p>
                            <small class="text-muted">Training: Nathaniel Football Stadium, Ajegunle</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-4">
                        <div class="me-3 p-3 rounded-circle text-white" style="background:#dc3545;min-width:50px;text-align:center;">
                            <i class="bi bi-clock-fill fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Training Hours</h6>
                            <p class="mb-0 text-muted">Monday – Saturday</p>
                            <small class="text-muted">Morning &amp; Afternoon Sessions</small>
                        </div>
                    </div>

                    {{-- Social Links --}}
                    <h6 class="fw-bold mt-4 mb-3" style="color:#10316B;">Follow Us</h6>
                    <div class="d-flex gap-3">
                        <a href="https://www.youtube.com/@olufunkefootballacademy" target="_blank" rel="noopener"
                           class="btn btn-danger btn-sm" aria-label="YouTube">
                            <i class="bi bi-youtube fs-5"></i>
                        </a>
                        <a href="https://web.facebook.com/people/Olufunke-Football-Academy/61554694136830/" target="_blank" rel="noopener"
                           class="btn btn-primary btn-sm" aria-label="Facebook">
                            <i class="bi bi-facebook fs-5"></i>
                        </a>
                        <a href="https://www.instagram.com/olufunkefootballacademy" target="_blank" rel="noopener"
                           class="btn btn-sm" style="background:#E1306C;color:#fff;" aria-label="Instagram">
                            <i class="bi bi-instagram fs-5"></i>
                        </a>
                    </div>

                    {{-- Affiliations --}}
                    <div class="mt-4 p-3 bg-light rounded-3">
                        <h6 class="fw-bold mb-2" style="color:#10316B;">Affiliations</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-primary">FIFA TMS</span>
                            <span class="badge bg-success">Lagos State FA</span>
                            <span class="badge bg-warning text-dark">Nigeria Football Federation</span>
                            <span class="badge bg-secondary">RC-7147523</span>
                        </div>
                    </div>
                </div>

                {{-- Contact Form --}}
                <div class="col-md-7">
                    <div class="p-4 bg-white rounded-3 shadow">
                        <h3 class="fw-bold mb-4" style="color:#10316B;">Send Us a Message</h3>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('contact.submit') }}" method="POST" novalidate>
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}" placeholder="Your full name" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" placeholder="your@email.com" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-semibold">Phone Number</label>
                                    <input type="tel" id="phone" name="phone"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           value="{{ old('phone') }}" placeholder="e.g. 09079917993">
                                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="subject" class="form-label fw-semibold">Subject</label>
                                    <select id="subject" name="subject" class="form-select @error('subject') is-invalid @enderror">
                                        <option value="" disabled {{ old('subject') ? '' : 'selected' }}>Select a subject</option>
                                        <option value="Trial Registration" {{ old('subject') === 'Trial Registration' ? 'selected' : '' }}>Trial Registration</option>
                                        <option value="U19 Registration" {{ old('subject') === 'U19 Registration' ? 'selected' : '' }}>U19 Registration</option>
                                        <option value="Store / Merchandise" {{ old('subject') === 'Store / Merchandise' ? 'selected' : '' }}>Store / Merchandise</option>
                                        <option value="Partnership / Sponsorship" {{ old('subject') === 'Partnership / Sponsorship' ? 'selected' : '' }}>Partnership / Sponsorship</option>
                                        <option value="General Inquiry" {{ old('subject') === 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                    </select>
                                    @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label fw-semibold">Message <span class="text-danger">*</span></label>
                                    <textarea id="message" name="message" rows="5"
                                              class="form-control @error('message') is-invalid @enderror"
                                              placeholder="Tell us about yourself or your inquiry..." required>{{ old('message') }}</textarea>
                                    @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success btn-lg w-100 fw-bold">
                                        <i class="bi bi-send-fill me-2"></i>Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Book a Trial CTA --}}
    <section class="py-5" style="background:#f0f4ff;">
        <div class="container text-center">
            <h2 class="fw-bold mb-3" style="color:#10316B;">Ready to Book a Trial?</h2>
            <p class="text-muted mb-4">Call or email us directly to schedule your trial session at Olufunke Football Academy.</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="tel:09079917993" class="btn btn-success btn-lg fw-bold px-4">
                    <i class="bi bi-telephone-fill me-2"></i>Call: 09079917993
                </a>
                <a href="mailto:Olufunkefootballacademy@gmail.com" class="btn btn-outline-primary btn-lg fw-bold px-4">
                    <i class="bi bi-envelope-fill me-2"></i>Send Email
                </a>
            </div>
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
