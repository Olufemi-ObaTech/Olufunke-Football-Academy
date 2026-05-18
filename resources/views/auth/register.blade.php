@extends('layouts.main')

@section('title', 'Player Registration')

@section('content')

<section class="py-5" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%); min-height:100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                {{-- Header --}}
                <div class="text-center text-white mb-4">
                    <img src="{{ asset('images/OFA New Logo.jpg') }}" alt="OFA Logo"
                         style="width:80px;height:80px;border-radius:50%;border:3px solid #ffc107;object-fit:cover;" class="mb-3 shadow">
                    <h2 class="fw-bold">Join Olufunke Football Academy</h2>
                    <p class="opacity-75">Register as a player to access training programs and football education.</p>
                </div>

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
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf

                            <h6 class="fw-bold text-uppercase text-muted mb-3 border-bottom pb-2">
                                <i class="bi bi-person-fill me-1"></i> Personal Information
                            </h6>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name"
                                           class="form-control form-control-lg @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}" placeholder="e.g. Chukwuemeka Obi" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email"
                                           class="form-control form-control-lg @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" placeholder="your@email.com" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" id="phone" name="phone"
                                           class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                           value="{{ old('phone') }}" placeholder="e.g. 09079917993" required>
                                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="nationality" class="form-label fw-semibold">Nationality <span class="text-danger">*</span></label>
                                    <input type="text" id="nationality" name="nationality"
                                           class="form-control form-control-lg @error('nationality') is-invalid @enderror"
                                           value="{{ old('nationality', 'Nigerian') }}" placeholder="e.g. Nigerian" required>
                                    @error('nationality')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label for="profile_photo" class="form-label fw-semibold">Profile Picture</label>
                                    <div class="card border-2 border-dashed rounded-3" style="border-color:#10316B;" id="photoDropZone">
                                        <div class="card-body p-4 text-center">
                                            <div id="photoPreview" class="d-none mb-3">
                                                <img id="photoImg" src="" alt="Profile preview" style="max-width:120px;height:120px;object-fit:cover;border-radius:50%;border:3px solid #10316B;">
                                            </div>
                                            <div id="photoPlaceholder">
                                                <i class="bi bi-image fs-2 text-muted d-block mb-2"></i>
                                                <input type="file" id="profile_photo" name="profile_photo"
                                                       class="form-control @error('profile_photo') is-invalid @enderror"
                                                       accept="image/*" style="display:none;">
                                                <label for="profile_photo" class="btn btn-sm btn-outline-primary fw-bold" style="cursor:pointer;">
                                                    <i class="bi bi-cloud-arrow-up me-1"></i>Choose Photo
                                                </label>
                                                <small class="d-block text-muted mt-2">JPG, PNG, GIF, WebP — Max 2MB</small>
                                            </div>
                                        </div>
                                    </div>
                                    @error('profile_photo')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <h6 class="fw-bold text-uppercase text-muted mb-3 border-bottom pb-2">
                                <i class="bi bi-dribbble me-1"></i> Football Profile
                            </h6>
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label for="position" class="form-label fw-semibold">Playing Position <span class="text-danger">*</span></label>
                                    <select id="position" name="position"
                                            class="form-select form-select-lg @error('position') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('position') ? '' : 'selected' }}>Select position</option>
                                        <option value="Goalkeeper"  {{ old('position') === 'Goalkeeper'  ? 'selected' : '' }}>Goalkeeper</option>
                                        <option value="Defender"    {{ old('position') === 'Defender'    ? 'selected' : '' }}>Defender</option>
                                        <option value="Midfielder"  {{ old('position') === 'Midfielder'  ? 'selected' : '' }}>Midfielder</option>
                                        <option value="Forward"     {{ old('position') === 'Forward'     ? 'selected' : '' }}>Forward</option>
                                        <option value="Winger"      {{ old('position') === 'Winger'      ? 'selected' : '' }}>Winger</option>
                                    </select>
                                    @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="age" class="form-label fw-semibold">Age <span class="text-danger">*</span></label>
                                    <input type="number" id="age" name="age"
                                           class="form-control form-control-lg @error('age') is-invalid @enderror"
                                           value="{{ old('age') }}" placeholder="e.g. 16" min="8" max="40" required>
                                    @error('age')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="age_group" class="form-label fw-semibold">Age Group <span class="text-danger">*</span></label>
                                    <select id="age_group" name="age_group"
                                            class="form-select form-select-lg @error('age_group') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('age_group') ? '' : 'selected' }}>Select group</option>
                                        <option value="U13"    {{ old('age_group') === 'U13'    ? 'selected' : '' }}>U13</option>
                                        <option value="U15"    {{ old('age_group') === 'U15'    ? 'selected' : '' }}>U15</option>
                                        <option value="U17"    {{ old('age_group') === 'U17'    ? 'selected' : '' }}>U17</option>
                                        <option value="U19"    {{ old('age_group') === 'U19'    ? 'selected' : '' }}>U19</option>
                                        <option value="Senior" {{ old('age_group') === 'Senior' ? 'selected' : '' }}>Senior</option>
                                    </select>
                                    @error('age_group')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <h6 class="fw-bold text-uppercase text-muted mb-3 border-bottom pb-2">
                                <i class="bi bi-lock-fill me-1"></i> Account Security
                            </h6>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                                    <input type="password" id="password" name="password"
                                           class="form-control form-control-lg @error('password') is-invalid @enderror"
                                           placeholder="Minimum 8 characters" required>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
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
                        <p class="text-center text-muted mb-0">
                            Already have an account?
                            <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color:#10316B;">Log In Here</a>
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
// Profile photo upload preview
const photoInput = document.getElementById('profile_photo');
const photoPreview = document.getElementById('photoPreview');
const photoImg = document.getElementById('photoImg');
const photoPlaceholder = document.getElementById('photoPlaceholder');
const photoDropZone = document.getElementById('photoDropZone');

if (photoInput) {
    photoInput.addEventListener('change', handlePhotoSelect);
    
    // Drag and drop support
    photoDropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        photoDropZone.style.borderColor = '#4CAF50';
        photoDropZone.style.backgroundColor = 'rgba(76, 175, 80, 0.1)';
    });
    
    photoDropZone.addEventListener('dragleave', () => {
        photoDropZone.style.borderColor = '#10316B';
        photoDropZone.style.backgroundColor = 'transparent';
    });
    
    photoDropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        photoDropZone.style.borderColor = '#10316B';
        photoDropZone.style.backgroundColor = 'transparent';
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            photoInput.files = files;
            handlePhotoSelect();
        }
    });
    
    photoDropZone.addEventListener('click', () => photoInput.click());
}

function handlePhotoSelect() {
    const file = photoInput.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            photoImg.src = e.target.result;
            photoPreview.classList.remove('d-none');
            photoPlaceholder.classList.add('d-none');
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
