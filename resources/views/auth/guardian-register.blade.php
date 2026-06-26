@extends('layouts.main')
@section('title', 'Guardian Registration')
@section('content')

<section class="py-5 min-vh-100" style="background:linear-gradient(135deg,#1a5c2a 60%,#10316B 100%);">
<div class="container py-3">

    <div class="text-center text-white mb-4">
        <img src="{{ asset('images/OFA New Logo.jpg') }}" alt="OFA Logo"
             style="width:80px;height:80px;border-radius:50%;border:3px solid #ffc107;object-fit:cover;" class="mb-3 shadow">
        <h2 class="fw-bold">Parent / Guardian Registration</h2>
        <p class="opacity-75">Register to monitor your child's academy journey</p>
    </div>

    <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">

        <a href="{{ url('/register') }}" class="btn btn-sm btn-outline-light mb-3">
            <i class="bi bi-arrow-left me-1"></i>Back to Registration Options
        </a>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header fw-bold py-3 text-center fs-5 text-white" style="background:#1a5c2a;">
                <i class="bi bi-person-heart me-2"></i>Guardian Registration Form
            </div>
            <div class="card-body p-4 p-md-5">

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('guardian.register.submit') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    {{-- PERSONAL INFO --}}
                    <h6 class="fw-bold text-uppercase text-muted mb-3 border-bottom pb-2">
                        <i class="bi bi-person-fill me-1"></i>Guardian Personal Information
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="e.g. Mrs Adunola Obi" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="parent@email.com" required>
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
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Relationship to Player <span class="text-danger">*</span></label>
                            <select name="relationship" id="relationshipSelect" class="form-select form-select-lg @error('relationship') is-invalid @enderror" required>
                                <option value="" disabled {{ old('relationship') ? '' : 'selected' }}>Select relationship</option>
                                @foreach(['Father','Mother','Guardian','Uncle','Aunt','Other'] as $r)
                                    <option value="{{ $r }}" {{ old('relationship') === $r ? 'selected' : '' }}>{{ $r }}</option>
                                @endforeach
                            </select>
                            @error('relationship')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div id="relationshipOtherWrap" class="mt-2" style="display:{{ old('relationship')==='Other' ? 'block' : 'none' }};">
                                <input type="text" name="relationship_other" id="relationshipOther"
                                    class="form-control form-control-lg @error('relationship_other') is-invalid @enderror"
                                    placeholder="Please specify your relationship"
                                    value="{{ old('relationship_other') }}"
                                    maxlength="50">
                                @error('relationship_other')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Child's Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="child_name" class="form-control form-control-lg @error('child_name') is-invalid @enderror"
                                value="{{ old('child_name') }}" placeholder="Name of your child at OFA" required>
                            @error('child_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Passport Photograph</label>
                            <div class="card border-2 rounded-3" style="border-color:#1a5c2a;border-style:dashed;cursor:pointer;" id="gPhotoZone">
                                <div class="card-body p-4 text-center">
                                    <div id="gPhotoPreview" class="d-none mb-2">
                                        <img id="gPhotoImg" src="" alt="Preview" style="width:90px;height:90px;object-fit:cover;border-radius:50%;border:3px solid #1a5c2a;">
                                    </div>
                                    <div id="gPhotoPlaceholder">
                                        <i class="bi bi-person-circle fs-2 text-muted d-block mb-2"></i>
                                        <input type="file" id="gPhotoInput" name="profile_photo" accept="image/*" style="display:none;" class="@error('profile_photo') is-invalid @enderror">
                                        <label for="gPhotoInput" class="btn btn-sm btn-outline-success fw-bold" style="cursor:pointer;">
                                            <i class="bi bi-cloud-arrow-up me-1"></i>Upload Photo (JPG/PNG, max 2MB)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CONSENT FORM --}}
                    <h6 class="fw-bold text-uppercase text-muted mb-3 border-bottom pb-2">
                        <i class="bi bi-file-earmark-check-fill me-1"></i>Signed Consent Form <span class="text-danger">*</span>
                    </h6>
                    <div class="alert alert-warning d-flex gap-3 align-items-start mb-3">
                        <i class="bi bi-exclamation-triangle-fill fs-5 flex-shrink-0 mt-1"></i>
                        <div>
                            <strong>Required:</strong> You must download, print, sign, and upload the OFA Guardian Consent Form before completing registration.
                            <div class="mt-2">
                                <a href="{{ route('consent-form') }}" target="_blank"
                                   class="btn btn-sm btn-outline-dark fw-bold">
                                    <i class="bi bi-printer-fill me-1"></i>Open &amp; Print Consent Form
                                </a>
                                <span class="text-muted ms-2" style="font-size:.78rem;">Opens in new tab &rarr; click "Print / Save as PDF"</span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Upload Signed Consent Form (PDF, max 5MB) <span class="text-danger">*</span></label>
                        <div class="card border-2 rounded-3 @error('consent_form') border-danger @enderror" style="border-color:#1a5c2a;border-style:dashed;" id="consentZone">
                            <div class="card-body p-4 text-center">
                                <div id="consentPreview" class="d-none mb-2">
                                    <i class="bi bi-file-earmark-check-fill fs-2 text-success d-block mb-1"></i>
                                    <span id="consentFileName" class="fw-semibold text-success" style="font-size:.83rem;"></span>
                                </div>
                                <div id="consentPlaceholder">
                                    <i class="bi bi-file-earmark-pdf fs-2 text-muted d-block mb-2"></i>
                                    <input type="file" id="consentInput" name="consent_form" accept="application/pdf,.pdf" style="display:none;"
                                           class="@error('consent_form') is-invalid @enderror">
                                    <label for="consentInput" class="btn btn-sm btn-outline-success fw-bold" style="cursor:pointer;">
                                        <i class="bi bi-cloud-arrow-up me-1"></i>Upload Signed Consent Form (PDF only)
                                    </label>
                                    <p class="text-muted mt-2 mb-0" style="font-size:.75rem;">Max 5 MB &middot; PDF files only &middot; Must be signed</p>
                                </div>
                            </div>
                        </div>
                        @error('consent_form')<div class="text-danger mt-1" style="font-size:.82rem;">{{ $message }}</div>@enderror
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

                    <div class="alert alert-info small mb-4">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Guardian accounts require admin approval. You will receive an email notification within 48 hours. Once approved, you can access the Guardian Portal to monitor your child's academy progress.
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-lg fw-bold py-3" style="background:#1a5c2a;color:#fff;">
                            <i class="bi bi-person-heart me-2"></i>Register as OFA Guardian
                        </button>
                    </div>
                </form>

                <hr class="my-4">
                <p class="text-center text-muted mb-0 small">
                    Already have an account? <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color:#1a5c2a;">Log In Here</a>
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
// Show/hide "Other" relationship text field
var relSelect = document.getElementById('relationshipSelect');
var relOtherWrap = document.getElementById('relationshipOtherWrap');
var relOtherInput = document.getElementById('relationshipOther');
if (relSelect) {
    relSelect.addEventListener('change', function() {
        if (this.value === 'Other') {
            relOtherWrap.style.display = 'block';
            relOtherInput.setAttribute('required', 'required');
        } else {
            relOtherWrap.style.display = 'none';
            relOtherInput.removeAttribute('required');
            relOtherInput.value = '';
        }
    });
}

// Consent form upload preview
var consentInput = document.getElementById('consentInput');
var consentPreview = document.getElementById('consentPreview');
var consentFileName = document.getElementById('consentFileName');
var consentPlaceholder = document.getElementById('consentPlaceholder');
if (consentInput) {
    consentInput.addEventListener('change', function() {
        var file = this.files[0];
        if (file) {
            if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
                alert('Please upload a PDF file only.');
                this.value = '';
                return;
            }
            if (file.size > 5 * 1024 * 1024) {
                alert('File is too large. Maximum size is 5 MB.');
                this.value = '';
                return;
            }
            consentFileName.textContent = file.name;
            consentPreview.classList.remove('d-none');
            consentPlaceholder.classList.add('d-none');
        }
    });
    document.getElementById('consentZone').addEventListener('click', function(e) {
        if (!e.target.closest('label') && !e.target.closest('input')) consentInput.click();
    });
}

// Photo upload preview
var gInput = document.getElementById('gPhotoInput');
var gPreview = document.getElementById('gPhotoPreview');
var gImg = document.getElementById('gPhotoImg');
var gPlaceholder = document.getElementById('gPhotoPlaceholder');
var gZone = document.getElementById('gPhotoZone');
if (gInput) {
    gInput.addEventListener('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) { gImg.src = e.target.result; gPreview.classList.remove('d-none'); gPlaceholder.classList.add('d-none'); };
            reader.readAsDataURL(file);
        }
    });
    gZone.addEventListener('click', function() { gInput.click(); });
}
</script>
@endpush
