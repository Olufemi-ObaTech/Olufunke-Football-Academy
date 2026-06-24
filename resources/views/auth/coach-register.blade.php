@extends('layouts.main')
@section('title', 'Coach Registration')
@section('content')

<section class="py-5 min-vh-100" style="background:linear-gradient(135deg,#7c3aed 60%,#10316B 100%);">
<div class="container py-3">

    <div class="text-center text-white mb-4">
        <img src="{{ asset('images/OFA New Logo.jpg') }}" alt="OFA Logo"
             style="width:80px;height:80px;border-radius:50%;border:3px solid #ffc107;object-fit:cover;" class="mb-3 shadow">
        <h2 class="fw-bold">Coach / Staff Registration</h2>
        <p class="opacity-75">Apply to join the OFA coaching team</p>
    </div>

    <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">

        <a href="{{ url('/register') }}" class="btn btn-sm btn-outline-light mb-3">
            <i class="bi bi-arrow-left me-1"></i>Back to Registration Options
        </a>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header fw-bold py-3 text-center fs-5 text-white" style="background:#7c3aed;">
                <i class="bi bi-person-video2 me-2"></i>Coach Application Form
            </div>
            <div class="card-body p-4 p-md-5">

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('coach.register.submit') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    {{-- PERSONAL INFO --}}
                    <h6 class="fw-bold text-uppercase text-muted mb-3 border-bottom pb-2">
                        <i class="bi bi-person-fill me-1"></i>Personal Information
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="e.g. Coach Emeka Johnson" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="coach@email.com" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}" placeholder="e.g. 09079917993" required>
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nationality</label>
                            <input type="text" name="nationality" class="form-control form-control-lg"
                                value="{{ old('nationality', 'Nigerian') }}">
                        </div>
                    </div>

                    {{-- COACHING PROFILE --}}
                    <h6 class="fw-bold text-uppercase text-muted mb-3 border-bottom pb-2">
                        <i class="bi bi-person-video2 me-1"></i>Coaching Profile
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Coaching Role <span class="text-danger">*</span></label>
                            <select name="coaching_role" class="form-select form-select-lg @error('coaching_role') is-invalid @enderror" required>
                                <option value="" disabled {{ old('coaching_role') ? '' : 'selected' }}>Select your role</option>
                                @foreach(['Head Coach','Assistant Coach','Goalkeeper Coach','Fitness & Conditioning Coach','Youth Development Coach','Scout'] as $r)
                                    <option value="{{ $r }}" {{ old('coaching_role') === $r ? 'selected' : '' }}>{{ $r }}</option>
                                @endforeach
                            </select>
                            @error('coaching_role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Years of Experience <span class="text-danger">*</span></label>
                            <input type="number" name="experience_years" class="form-control form-control-lg @error('experience_years') is-invalid @enderror"
                                value="{{ old('experience_years') }}" placeholder="e.g. 5" min="0" max="50" required>
                            @error('experience_years')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Qualifications / Licences</label>
                            <input type="text" name="qualifications" class="form-control form-control-lg"
                                value="{{ old('qualifications') }}" placeholder="e.g. CAF C Licence, FIFA Coaching Certificate">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Passport Photograph</label>
                            <div class="card border-2 rounded-3" style="border-color:#7c3aed;border-style:dashed;cursor:pointer;" id="cPhotoZone">
                                <div class="card-body p-4 text-center">
                                    <div id="cPhotoPreview" class="d-none mb-2">
                                        <img id="cPhotoImg" src="" alt="Preview" style="width:90px;height:90px;object-fit:cover;border-radius:50%;border:3px solid #7c3aed;">
                                    </div>
                                    <div id="cPhotoPlaceholder">
                                        <i class="bi bi-person-circle fs-2 text-muted d-block mb-2"></i>
                                        <input type="file" id="cPhotoInput" name="profile_photo" accept="image/*" style="display:none;">
                                        <label for="cPhotoInput" class="btn btn-sm btn-outline-secondary fw-bold" style="cursor:pointer;">
                                            <i class="bi bi-cloud-arrow-up me-1"></i>Upload Passport Photo (JPG/PNG, max 2MB)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ACCOUNT SECURITY --}}
                    <h6 class="fw-bold text-uppercase text-muted mb-3 border-bottom pb-2">
                        <i class="bi bi-lock-fill me-1"></i>Account Security
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                                placeholder="Minimum 8 characters" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control form-control-lg"
                                placeholder="Repeat your password" required>
                        </div>
                    </div>

                    <div class="alert alert-warning small mb-4">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        All coach applications are reviewed by the Academy Director within 48 hours. You will be contacted via the email provided.
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-lg fw-bold py-3 text-white" style="background:#7c3aed;">
                            <i class="bi bi-person-video2 me-2"></i>Submit Coach Application
                        </button>
                    </div>
                </form>

                <hr class="my-4">
                <p class="text-center text-muted mb-0 small">
                    Already have an account? <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color:#7c3aed;">Log In Here</a>
                    &nbsp;|&nbsp; Registering a player? <a href="{{ url('/register') }}" class="fw-bold text-decoration-none" style="color:#10316B;">Player Reg →</a>
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
var cInput = document.getElementById('cPhotoInput');
var cPreview = document.getElementById('cPhotoPreview');
var cImg = document.getElementById('cPhotoImg');
var cPlaceholder = document.getElementById('cPhotoPlaceholder');
var cZone = document.getElementById('cPhotoZone');
if (cInput) {
    cInput.addEventListener('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) { cImg.src = e.target.result; cPreview.classList.remove('d-none'); cPlaceholder.classList.add('d-none'); };
            reader.readAsDataURL(file);
        }
    });
    cZone.addEventListener('click', function() { cInput.click(); });
}
</script>
@endpush
