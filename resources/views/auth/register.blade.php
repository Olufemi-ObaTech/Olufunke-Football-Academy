@extends('layouts.main')

@section('title', 'Register')

@section('content')

{{-- Role selector (shown by default; player form shown when Player is chosen) --}}
<section class="py-5 min-vh-100" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%);">
<div class="container py-3">

    {{-- Logo + heading --}}
    <div class="text-center text-white mb-4">
        <img src="{{ asset('images/OFA New Logo.jpg') }}" alt="OFA Logo"
             style="width:80px;height:80px;border-radius:50%;border:3px solid #ffc107;object-fit:cover;" class="mb-3 shadow">
        <h2 class="fw-bold">Join Olufunke Football Academy</h2>
        <p class="opacity-75" id="register-subtitle">Select how you are registering below</p>
    </div>

    {{-- ── STEP 0: Role Selector ── --}}
    <div id="role-selector" class="row justify-content-center g-4 mb-4">
        <div class="col-md-4 col-sm-10">
            <button onclick="chooseRole('player')"
                class="w-100 border-0 rounded-4 p-4 text-center role-card shadow"
                style="background:#fff;cursor:pointer;transition:all .2s;" data-color="#10316B">
                <div class="role-icon mb-3 mx-auto" style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,#10316B,#1e4db7);display:flex;align-items:center;justify-content:center;font-size:2rem;">⚽</div>
                <div class="fw-bold fs-5 mb-1" style="color:#10316B;">Player</div>
                <div class="text-muted small mb-2">I am a footballer joining the academy</div>
                <span class="badge" style="background:#10316B15;color:#10316B;font-size:.72rem;font-weight:700;padding:4px 12px;border-radius:20px;">Ages 8–26</span>
                <div class="mt-3 fw-bold" style="color:#10316B;">Register →</div>
            </button>
        </div>
        <div class="col-md-4 col-sm-10">
            <a href="{{ url('/guardian-register') }}" class="text-decoration-none">
                <div class="w-100 border-0 rounded-4 p-4 text-center role-card shadow"
                    style="background:#fff;cursor:pointer;transition:all .2s;" data-color="#1a5c2a">
                    <div class="role-icon mb-3 mx-auto" style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,#1a5c2a,#15803d);display:flex;align-items:center;justify-content:center;font-size:2rem;">👨‍👩‍👦</div>
                    <div class="fw-bold fs-5 mb-1" style="color:#1a5c2a;">Parent / Guardian</div>
                    <div class="text-muted small mb-2">I am registering on behalf of my child</div>
                    <span class="badge" style="background:#1a5c2a15;color:#1a5c2a;font-size:.72rem;font-weight:700;padding:4px 12px;border-radius:20px;">Parent / Guardian</span>
                    <div class="mt-3 fw-bold" style="color:#1a5c2a;">Register →</div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-sm-10">
            <a href="{{ url('/coach-register') }}" class="text-decoration-none">
                <div class="w-100 border-0 rounded-4 p-4 text-center role-card shadow"
                    style="background:#fff;cursor:pointer;transition:all .2s;" data-color="#7c3aed">
                    <div class="role-icon mb-3 mx-auto" style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,#7c3aed,#6d28d9);display:flex;align-items:center;justify-content:center;font-size:2rem;">🎓</div>
                    <div class="fw-bold fs-5 mb-1" style="color:#7c3aed;">Coach / Staff</div>
                    <div class="text-muted small mb-2">I am applying to join as a coach</div>
                    <span class="badge" style="background:#7c3aed15;color:#7c3aed;font-size:.72rem;font-weight:700;padding:4px 12px;border-radius:20px;">Professional</span>
                    <div class="mt-3 fw-bold" style="color:#7c3aed;">Register →</div>
                </div>
            </a>
        </div>
        <div class="col-12 text-center mt-2">
            <span class="text-white opacity-75 small">Already have an account?
                <a href="{{ route('login') }}" class="text-warning fw-bold text-decoration-none">Log In →</a>
            </span>
        </div>
    </div>

    {{-- ── STEP 1: Player Registration Form (hidden until Player is chosen) ── --}}
    <div id="player-form-wrap" class="row justify-content-center" style="display:none!important;">
        <div class="col-lg-8 col-md-10">

            <button type="button" onclick="showSelector()" class="btn btn-sm btn-outline-light mb-3">
                <i class="bi bi-arrow-left me-1"></i> Choose a different role
            </button>

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header text-white fw-bold py-3 text-center fs-5" style="background:#10316B;">
                    <i class="bi bi-person-plus-fill me-2"></i>Player Registration Form
                </div>
                <div class="card-body p-4 p-md-5">

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-1">
                                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf

                        {{-- PERSONAL INFO --}}
                        <h6 class="fw-bold text-uppercase text-muted mb-3 border-bottom pb-2">
                            <i class="bi bi-person-fill me-1"></i>Personal Information
                        </h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="e.g. Chukwuemeka Obi" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" placeholder="your@email.com" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}" placeholder="e.g. 09079917993" required>
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nationality <span class="text-danger">*</span></label>
                                <input type="text" name="nationality" class="form-control form-control-lg @error('nationality') is-invalid @enderror"
                                    value="{{ old('nationality', 'Nigerian') }}" placeholder="e.g. Nigerian" required>
                                @error('nationality')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Passport Photograph <span class="text-danger">*</span></label>
                                <div class="card border-2 border-dashed rounded-3" id="photoDropZone" style="border-color:#10316B;cursor:pointer;">
                                    <div class="card-body p-4 text-center">
                                        <div id="photoPreview" class="d-none mb-3">
                                            <img id="photoImg" src="" alt="Preview" style="max-width:100px;height:100px;object-fit:cover;border-radius:50%;border:3px solid #10316B;">
                                        </div>
                                        <div id="photoPlaceholder">
                                            <i class="bi bi-person-circle fs-2 text-muted d-block mb-2"></i>
                                            <input type="file" id="profile_photo" name="profile_photo"
                                                class="form-control @error('profile_photo') is-invalid @enderror"
                                                accept="image/*" style="display:none;">
                                            <label for="profile_photo" class="btn btn-sm btn-outline-primary fw-bold" style="cursor:pointer;">
                                                <i class="bi bi-cloud-arrow-up me-1"></i>Upload Photo (JPG/PNG, max 2MB)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @error('profile_photo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- FOOTBALL PROFILE --}}
                        <h6 class="fw-bold text-uppercase text-muted mb-3 border-bottom pb-2">
                            <i class="bi bi-dribbble me-1"></i>Football Profile
                        </h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Playing Position <span class="text-danger">*</span></label>
                                <select name="position" class="form-select form-select-lg @error('position') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('position') ? '' : 'selected' }}>Select position</option>
                                    @foreach(['Goalkeeper','Defender','Midfielder','Forward','Winger'] as $p)
                                        <option value="{{ $p }}" {{ old('position') === $p ? 'selected' : '' }}>{{ $p }}</option>
                                    @endforeach
                                </select>
                                @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Age <span class="text-danger">*</span></label>
                                <input type="number" name="age" class="form-control form-control-lg @error('age') is-invalid @enderror"
                                    value="{{ old('age') }}" placeholder="e.g. 16" min="8" max="40" required>
                                @error('age')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Age Group <span class="text-danger">*</span></label>
                                <select name="age_group" class="form-select form-select-lg @error('age_group') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('age_group') ? '' : 'selected' }}>Select group</option>
                                    @foreach(['U13','U15','U17','U19','Senior'] as $g)
                                        <option value="{{ $g }}" {{ old('age_group') === $g ? 'selected' : '' }}>{{ $g }}</option>
                                    @endforeach
                                </select>
                                @error('age_group')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- ACCOUNT SECURITY --}}
                        <h6 class="fw-bold text-uppercase text-muted mb-3 border-bottom pb-2">
                            <i class="bi bi-lock-fill me-1"></i>Account Security
                        </h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <input type="password" id="password" name="password"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        placeholder="Minimum 8 characters" required>
                                    <button type="button" onclick="togglePwd('password','eyeIcon1')"
                                        class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-2 text-muted p-0 border-0 bg-transparent">
                                        <i id="eyeIcon1" class="bi bi-eye-fill fs-5"></i>
                                    </button>
                                </div>
                                @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation"
                                    class="form-control form-control-lg"
                                    placeholder="Repeat your password" required>
                            </div>
                        </div>

                        <div class="d-grid mt-2">
                            <button type="submit" class="btn btn-success btn-lg fw-bold py-3">
                                <i class="bi bi-person-check-fill me-2"></i>Register as OFA Player
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">
                    <p class="text-center text-muted mb-0 small">
                        Already have an account?
                        <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color:#10316B;">Log In Here</a>
                        &nbsp;|&nbsp;
                        <a href="{{ url('/guardian-register') }}" class="fw-bold text-decoration-none text-success">Guardian Reg →</a>
                        &nbsp;|&nbsp;
                        <a href="{{ url('/coach-register') }}" class="fw-bold text-decoration-none" style="color:#7c3aed;">Coach Reg →</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
</section>

@endsection

@push('scripts')
<script>
function chooseRole(role) {
    if (role === 'player') {
        document.getElementById('role-selector').style.display = 'none';
        document.getElementById('player-form-wrap').style.removeProperty('display');
        document.getElementById('register-subtitle').textContent = 'Player Registration — Step 1 of 1';
    }
}
function showSelector() {
    document.getElementById('player-form-wrap').style.display = 'none';
    document.getElementById('role-selector').style.removeProperty('display');
    document.getElementById('register-subtitle').textContent = 'Select how you are registering below';
}

// If there are validation errors, auto-show the player form
@if($errors->any())
    chooseRole('player');
@endif

// Role card hover effects
document.querySelectorAll('.role-card').forEach(function(card) {
    var color = card.dataset.color;
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-6px)';
        this.style.border = '2px solid ' + color;
    });
    card.addEventListener('mouseleave', function() {
        this.style.transform = '';
        this.style.border = '';
    });
});

// Photo preview
var photoInput = document.getElementById('profile_photo');
var photoPreview = document.getElementById('photoPreview');
var photoImg = document.getElementById('photoImg');
var photoPlaceholder = document.getElementById('photoPlaceholder');
var photoDropZone = document.getElementById('photoDropZone');
if (photoInput) {
    photoInput.addEventListener('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                photoImg.src = e.target.result;
                photoPreview.classList.remove('d-none');
                photoPlaceholder.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        }
    });
    photoDropZone.addEventListener('click', function() { photoInput.click(); });
}

// Password toggle
function togglePwd(inputId, iconId) {
    var inp = document.getElementById(inputId);
    var icon = document.getElementById(iconId);
    if (inp.type === 'password') {
        inp.type = 'text';
        icon.className = 'bi bi-eye-slash-fill fs-5';
    } else {
        inp.type = 'password';
        icon.className = 'bi bi-eye-fill fs-5';
    }
}
</script>
@endpush
