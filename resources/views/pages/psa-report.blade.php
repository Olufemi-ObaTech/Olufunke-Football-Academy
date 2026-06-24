{{-- Standalone printable PSA documentation --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>PSA Documentation | Olufunke Football Academy 2026</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Montserrat',Arial,sans-serif;background:#e8edf2;color:#1e293b;font-size:13px;line-height:1.7;}
#action-bar{position:sticky;top:0;z-index:200;background:linear-gradient(90deg,#10316B,#1a4a9e);padding:11px 24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;box-shadow:0 2px 12px rgba(0,0,0,.3);}
.btn-dl{background:#fbbf24;color:#1e293b;border:none;padding:9px 22px;border-radius:8px;font-weight:800;font-size:.88rem;cursor:pointer;}
.btn-back{background:transparent;color:rgba(255,255,255,.8);border:1px solid rgba(255,255,255,.35);padding:8px 18px;border-radius:8px;font-size:.82rem;text-decoration:none;}
.bar-title{color:#fff;font-weight:700;font-size:.95rem;display:flex;align-items:center;gap:8px;}
.doc-wrap{max-width:920px;margin:0 auto;padding:24px 16px 60px;}
.psa-page{background:#fff;border-radius:12px;box-shadow:0 4px 24px rgba(16,49,107,.09);padding:46px 52px;margin-bottom:26px;position:relative;}
.psa-page::before{content:'';position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,#10316B,#4CAF50);}
.pg-tag{position:absolute;top:14px;right:20px;font-size:.68rem;font-weight:700;color:#94a3b8;letter-spacing:.06em;text-transform:uppercase;}
.cover-page{background:linear-gradient(160deg,#10316B 0%,#0f2551 55%,#1a5c2a 100%);color:#fff;text-align:center;padding:60px 48px;border-radius:12px;box-shadow:0 8px 40px rgba(16,49,107,.35);margin-bottom:26px;}
.cover-logo{width:108px;height:108px;border-radius:50%;border:4px solid #fbbf24;object-fit:cover;margin-bottom:18px;}
.cover-badge{display:inline-block;background:rgba(251,191,36,.2);border:1px solid #fbbf24;color:#fbbf24;padding:4px 18px;border-radius:20px;font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;margin-bottom:12px;}
.cover-title{font-size:1.6rem;font-weight:800;line-height:1.25;margin-bottom:4px;}
.cover-subtitle{font-size:.95rem;font-weight:600;opacity:.8;}
.cover-divider{height:2px;background:linear-gradient(90deg,transparent,#fbbf24,transparent);margin:22px auto;width:55%;}
.cover-tbl{margin:0 auto;text-align:left;border-collapse:collapse;min-width:340px;font-size:.82rem;}
.cover-tbl td{padding:6px 14px;border-bottom:1px solid rgba(255,255,255,.1);}
.cover-tbl td:first-child{font-weight:700;color:#fbbf24;white-space:nowrap;}
.cover-footer{margin-top:24px;font-size:.7rem;opacity:.4;letter-spacing:.06em;}
.sec-title{font-size:.98rem;font-weight:800;color:#10316B;text-transform:uppercase;letter-spacing:.06em;border-left:4px solid #fbbf24;padding:4px 0 4px 14px;margin:0 0 14px;}
.sub-title{font-size:.88rem;font-weight:700;color:#1a5c2a;margin:16px 0 9px;}
p{margin-bottom:10px;}
.psa-table{width:100%;border-collapse:collapse;margin-bottom:14px;font-size:.81rem;}
.psa-table thead tr{background:#10316B;color:#fff;}
.psa-table th{padding:8px 11px;text-align:left;font-weight:700;}
.psa-table td{padding:7px 11px;border-bottom:1px solid #e5eaf0;vertical-align:top;}
.psa-table tbody tr:nth-child(even) td{background:#f8fafc;}
.psa-table td:first-child{font-weight:600;}
.ct{text-align:center;}
.b{display:inline-block;padding:2px 8px;border-radius:20px;font-size:.68rem;font-weight:700;white-space:nowrap;}
.bg{background:#dcfce7;color:#15803d;}
.bb{background:#dbeafe;color:#1d4ed8;}
.br{background:#fee2e2;color:#b91c1c;}
.by{background:#fef3c7;color:#92400e;}
.ibox{padding:11px 15px;border-radius:0 8px 8px 0;margin-bottom:12px;font-size:.84rem;}
.ibox-blue{background:#eff6ff;border-left:4px solid #10316B;}
.ibox-green{background:#f0fdf4;border-left:4px solid #1a5c2a;}
.ibox-yellow{background:#fefce8;border-left:4px solid #fbbf24;}
.ibox-red{background:#fff1f2;border-left:4px solid #e11d48;}
ul,ol{padding-left:20px;margin-bottom:10px;}
li{margin-bottom:4px;}
pre{background:#0f172a;color:#e2e8f0;border-radius:8px;padding:14px;font-size:.72rem;overflow-x:auto;line-height:1.75;margin-bottom:12px;tab-size:2;}
.pre-label{font-size:.65rem;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:#94a3b8;margin-bottom:4px;}
code{background:#f1f5f9;padding:1px 5px;border-radius:4px;font-size:.8rem;color:#e11d48;}
.sig-block{background:linear-gradient(135deg,#10316B,#1a5c2a);color:#fff;border-radius:10px;padding:26px;text-align:center;margin-top:14px;}
@@media print{
  body{background:#fff!important;}
  #action-bar{display:none!important;}
  .doc-wrap{max-width:100%;padding:0;margin:0;}
  .cover-page,.psa-page{box-shadow:none!important;border-radius:0!important;margin:0!important;padding:26px 36px!important;page-break-after:always;break-after:page;}
  .psa-page::before{display:none;}
  .cover-page,.psa-table thead tr,.ibox-blue,.ibox-green,.ibox-yellow,.ibox-red,.sig-block{-webkit-print-color-adjust:exact;print-color-adjust:exact;}
  pre{font-size:.62rem;padding:8px;}
  @@page{margin:1.4cm 1.8cm;size:A4;}
}
</style>
</head>
<body>

<div id="action-bar">
  <div class="bar-title">
    <i class="bi bi-file-earmark-pdf-fill" style="color:#fbbf24;font-size:1.2rem;"></i>
    PSA Documentation &mdash; Olufunke Football Academy &middot; 2026
  </div>
  <div style="display:flex;gap:8px;align-items:center;">
    <a href="{{ url('/') }}" class="btn-back"><i class="bi bi-house-fill"></i> Website</a>
    <button class="btn-dl" onclick="window.print()"><i class="bi bi-download"></i> Download / Print PDF</button>
  </div>
</div>

<div class="doc-wrap">

{{-- ===== COVER ===== --}}
<div class="cover-page">
  <div class="cover-badge">Project-Based Skills Assessment (PSA) &mdash; 2026</div><br>
  <img src="{{ asset('images/OFA New Logo.jpg') }}" alt="OFA" class="cover-logo" onerror="this.style.display='none'">
  <h1 class="cover-title">OLUFUNKE FOOTBALL ACADEMY</h1>
  <div class="cover-subtitle">Comprehensive Web Platform with Integrated Player Development System</div>
  <div class="cover-divider"></div>
  <table class="cover-tbl">
    <tr><td>Institution</td><td>Lincoln College of Science Management and Technology</td></tr>
    <tr><td>Student Name</td><td>Olufemi Emmanuel Olugbodi</td></tr>
    <tr><td>Department</td><td>Computer Software Engineering</td></tr>
    <tr><td>Semester</td><td>Semester 4</td></tr>
    <tr><td>Student ID</td><td>LCSMT-NGA-005-ADM-1001393</td></tr>
    <tr><td>Supervisor</td><td>Mr. Ibrahim Isiaka</td></tr>
    <tr><td>Date Submitted</td><td>18 June 2026</td></tr>
    <tr><td>Live Platform</td><td>olufunkefootballacademy.com (Netlify + Supabase)</td></tr>
    <tr><td>Local Dev</td><td>http://127.0.0.1:8000 (Laravel 12 / XAMPP)</td></tr>
  </table>
  <div class="cover-footer">CONFIDENTIAL &mdash; ACADEMIC ASSESSMENT ONLY &middot; PAGE 1 OF 15</div>
</div>

{{-- ===== PAGE 2 — INTRODUCTION ===== --}}
<div class="psa-page">
  <div class="pg-tag">Page 2 of 15</div>
  <div class="sec-title">1. Introduction &amp; Abstract</div>
  <p>This PSA report documents the design, development, and deployment of a comprehensive web-based platform for <strong>Olufunke Football Academy (OFA)</strong>. The project applies modern full-stack development to address digital invisibility, administrative inefficiency, and the absence of structured player education and guardian engagement at a community football academy in Lagos, Nigeria.</p>
  <p>The platform provides: role-based multi-user registration (Player, Guardian, Coach, Admin), a live Lagos time clock on every page, a Football IQ quiz system, an Education Hub with guardian-exclusive courses, a Guardian Consent Form workflow, and a full Admin Dashboard with approve/reject controls for both Players and Guardians.</p>

  <div class="sub-title">Technology Stack</div>
  <table class="psa-table">
    <thead><tr><th>Layer</th><th>Local (XAMPP Dev)</th><th>Production (Netlify)</th></tr></thead>
    <tbody>
      <tr><td>Backend</td><td>Laravel 12 / PHP 8.2</td><td>Next.js 14 + Netlify Functions (Node 20)</td></tr>
      <tr><td>Database</td><td>MySQL 8.0</td><td>PostgreSQL 15 (Supabase)</td></tr>
      <tr><td>Auth</td><td>Laravel Auth (sessions)</td><td>Supabase Auth (JWT + HTTP-only cookies)</td></tr>
      <tr><td>File Storage</td><td>Laravel Storage (local)</td><td>Supabase Storage (S3-compatible)</td></tr>
      <tr><td>Templates</td><td>Blade + Bootstrap 5</td><td>React JSX + Bootstrap 5</td></tr>
      <tr><td>Fonts / Icons</td><td colspan="2">Montserrat (Google Fonts) &middot; Bootstrap Icons 1.10.5</td></tr>
      <tr><td>Domain / HTTPS</td><td>127.0.0.1:8000</td><td>olufunkefootballacademy.com (SSL enforced)</td></tr>
      <tr><td>CI/CD</td><td>Manual artisan serve</td><td>GitHub &rarr; Netlify auto-deploy on git push</td></tr>
      <tr><td>Version Control</td><td colspan="2">Git / GitHub (chanstarnsfdk11-cyber / Olufunke-Football-Academy)</td></tr>
    </tbody>
  </table>

  <div class="sub-title">Live Site Architecture</div>
<pre>
User Browser
    |
    v  HTTPS
Netlify CDN (olufunkefootballacademy.com)
    |                   |
    v                   v
Next.js 14          Netlify Functions (Node.js 20)
React pages         /auth-handler  /guardian-api
Bootstrap 5         /education     /players
                    /quiz          /contact
    |
    v
Supabase (PostgreSQL 15 + Auth + Storage)
Row Level Security (RLS) on all tables
</pre>
</div>

{{-- ===== PAGE 3 — ALL ROUTES & PAGES ===== --}}
<div class="psa-page">
  <div class="pg-tag">Page 3 of 15</div>
  <div class="sec-title">2. All Routes &amp; Pages</div>

  <div class="sub-title">Laravel Routes (routes/web.php) — Local Dev</div>
  <div class="pre-label">routes/web.php — key routes</div>
<pre>
// Public
Route::get('/',           [HomeController::class, 'index'])->name('home');
Route::get('/about-us',   [PageController::class, 'about'])->name('about');
Route::get('/contact-us', [PageController::class, 'contact'])->name('contact');
Route::post('/contact-us',[PageController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/psa-report', [PageController::class, 'psaReport'])->name('psa-report');

// Consent Form (public — printable PDF)
Route::get('/consent-form', [PageController::class, 'consentForm'])->name('consent-form');

// Multi-Role Registration
Route::get('/register',           [RegisterController::class, 'showForm'])->name('register');
Route::post('/register',          [RegisterController::class, 'register']);
Route::get('/guardian-register',  [RegisterController::class, 'showGuardianForm'])->name('guardian.register');
Route::post('/guardian-register', [RegisterController::class, 'registerGuardian'])->name('guardian.register.submit');
Route::get('/coach-register',     [RegisterController::class, 'showCoachForm'])->name('coach.register');
Route::post('/coach-register',    [RegisterController::class, 'registerCoach'])->name('coach.register.submit');

// Auth
Route::get('/login',   [LoginController::class, 'showForm'])->name('login');
Route::post('/login',  [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Player Dashboard
Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Admin Dashboard + approve/reject Players AND Guardians
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',               [DashboardController::class, 'admin'])->name('dashboard');
    Route::post('/players/{user}/approve', [DashboardController::class, 'approvePlayer'])->name('players.approve');
    Route::post('/players/{user}/reject',  [DashboardController::class, 'rejectPlayer'])->name('players.reject');
    Route::post('/guardians/{user}/approve',[DashboardController::class,'approveGuardian'])->name('guardians.approve');
    Route::post('/guardians/{user}/reject', [DashboardController::class,'rejectGuardian'])->name('guardians.reject');
    // ... schedules, news, league, spotlight, quiz, messages, about
});

// Football IQ Quiz (public)
Route::prefix('quiz')->name('quiz.')->group(function () {
    Route::get('/',                [QuizController::class, 'index'])->name('index');
    Route::get('/{quizWeek}',      [QuizController::class, 'show'])->name('show');
    Route::get('/{quizWeek}/take', [QuizController::class, 'take'])->name('take');
    Route::post('/{quizWeek}/submit',[QuizController::class,'submit'])->name('submit');
});
</pre>

  <div class="sub-title">Next.js Pages (Production — Netlify)</div>
  <table class="psa-table">
    <thead><tr><th>URL / Route</th><th>File</th><th>Access</th></tr></thead>
    <tbody>
      <tr><td>/</td><td>pages/index.js</td><td><span class="b bg">Public</span></td></tr>
      <tr><td>/about</td><td>pages/about.js</td><td><span class="b bg">Public</span></td></tr>
      <tr><td>/contact</td><td>pages/contact.js</td><td><span class="b bg">Public</span></td></tr>
      <tr><td>/login</td><td>pages/login.js</td><td><span class="b bg">Guest</span></td></tr>
      <tr><td>/register</td><td>pages/register.js</td><td><span class="b bg">Guest — Role selector (3 cards)</span></td></tr>
      <tr><td>/guardian-register</td><td>pages/guardian-register.js</td><td><span class="b bg">Guest — Multi-step + consent PDF upload</span></td></tr>
      <tr><td>/coach-register</td><td>pages/coach-register.js</td><td><span class="b bg">Guest</span></td></tr>
      <tr><td>/consent-form</td><td>pages/consent-form.js</td><td><span class="b bg">Public — Printable PDF form</span></td></tr>
      <tr><td>/dashboard</td><td>pages/dashboard.js</td><td><span class="b bb">Auth</span></td></tr>
      <tr><td>/admin</td><td>pages/admin/index.js</td><td><span class="b br">Admin only</span></td></tr>
      <tr><td>/football-education</td><td>pages/football-education.js</td><td><span class="b bb">Approved</span></td></tr>
      <tr><td>/quiz</td><td>pages/quiz/index.js</td><td><span class="b bg">Public</span></td></tr>
      <tr><td>/guardian/dashboard</td><td>pages/guardian/dashboard.js</td><td><span class="b bg">Guardian + Admin</span></td></tr>
      <tr><td>/guardian/schedule</td><td>pages/guardian/schedule.js</td><td><span class="b bg">Guardian + Admin</span></td></tr>
      <tr><td>/guardian/finances</td><td>pages/guardian/finances.js</td><td><span class="b bg">Guardian + Admin</span></td></tr>
      <tr><td>/guardian/learn</td><td>pages/guardian/learn.js</td><td><span class="b br">Guardian + Admin only (HTTP 403 others)</span></td></tr>
      <tr><td>/psa-report</td><td>pages/psa-report.js</td><td><span class="b bg">Public</span></td></tr>
    </tbody>
  </table>
</div>

{{-- ===== PAGE 4 — PERMISSIONS MATRIX ===== --}}
<div class="psa-page">
  <div class="pg-tag">Page 4 of 15</div>
  <div class="sec-title">3. Permissions Matrix (RBAC)</div>
  <p>All permissions are enforced at <strong>two layers</strong>: (1) frontend redirect/hide, and (2) server-side middleware or API guard. Bypassing the UI never bypasses security.</p>

  <div style="overflow-x:auto;">
  <table class="psa-table">
    <thead>
      <tr><th>Feature / Area</th><th class="ct">Admin</th><th class="ct">Coach</th><th class="ct">Player</th><th class="ct">Guardian</th></tr>
    </thead>
    <tbody>
      <tr><td>Admin Dashboard (full CRUD)</td><td class="ct"><span class="b bg">Full</span></td><td class="ct"><span class="b br">No</span></td><td class="ct"><span class="b br">No</span></td><td class="ct"><span class="b br">No</span></td></tr>
      <tr><td>Player Dashboard</td><td class="ct"><span class="b bg">Full</span></td><td class="ct"><span class="b bg">Full</span></td><td class="ct"><span class="b bg">Full</span></td><td class="ct"><span class="b by">Own Child</span></td></tr>
      <tr><td>Guardian Portal</td><td class="ct"><span class="b bg">Full</span></td><td class="ct"><span class="b br">No</span></td><td class="ct"><span class="b br">No</span></td><td class="ct"><span class="b bg">Full</span></td></tr>
      <tr><td>Register as Player</td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td></tr>
      <tr><td>Register as Guardian</td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b br">No</span></td><td class="ct"><span class="b bg">Yes</span></td></tr>
      <tr><td>Register as Coach</td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b by">&#8212;</span></td><td class="ct"><span class="b by">&#8212;</span></td></tr>
      <tr><td>Approve / Reject Players</td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b br">No</span></td><td class="ct"><span class="b br">No</span></td><td class="ct"><span class="b br">No</span></td></tr>
      <tr><td><strong>Approve / Reject Guardians</strong></td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b br">No</span></td><td class="ct"><span class="b br">No</span></td><td class="ct"><span class="b br">No</span></td></tr>
      <tr><td>Football IQ Quiz (Public)</td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td></tr>
      <tr><td>Education Hub &mdash; Browse</td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td></tr>
      <tr><td>Education Hub &mdash; Earn Points</td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td></tr>
      <tr><td>Guardian-Exclusive Courses (5)</td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b br">No &mdash; HTTP 403</span></td><td class="ct"><span class="b bg">Yes</span></td></tr>
      <tr><td>Manage Schedules / Fixtures</td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b br">No</span></td><td class="ct"><span class="b br">No</span></td><td class="ct"><span class="b br">No</span></td></tr>
      <tr><td>Post News / Announcements</td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b br">No</span></td><td class="ct"><span class="b br">No</span></td><td class="ct"><span class="b br">No</span></td></tr>
      <tr><td>Guardian Invoices / Finances</td><td class="ct"><span class="b bg">Full</span></td><td class="ct"><span class="b br">Blocked</span></td><td class="ct"><span class="b br">No</span></td><td class="ct"><span class="b bg">Own only</span></td></tr>
      <tr><td>Submit Support Tickets</td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b br">No</span></td><td class="ct"><span class="b br">No</span></td><td class="ct"><span class="b bg">Yes</span></td></tr>
      <tr><td>Audit Logs</td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b br">No</span></td><td class="ct"><span class="b br">No</span></td><td class="ct"><span class="b br">No</span></td></tr>
      <tr><td>Consent Form (/consent-form)</td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td></tr>
      <tr><td>PSA Report (/psa-report)</td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td></tr>
      <tr><td>Live Lagos Time (all pages)</td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td><td class="ct"><span class="b bg">Yes</span></td></tr>
    </tbody>
  </table>
  </div>
</div>

{{-- ===== PAGE 5 — REGISTRATION CODE ===== --}}
<div class="psa-page">
  <div class="pg-tag">Page 5 of 15</div>
  <div class="sec-title">4. Registration System &mdash; Code</div>

  <div class="sub-title">Guardian Registration — RegisterController.php (key excerpt)</div>
  <div class="pre-label">app/Http/Controllers/Auth/RegisterController.php</div>
<pre>
public function registerGuardian(Request $request)
{
    $validated = $request->validate([
        'name'         => 'required|string|max:100',
        'email'        => 'required|email|unique:users,email|max:150',
        'phone'        => 'required|string|max:20',
        'nationality'  => 'required|string|max:60',
        'relationship' => 'required|string|max:50',
        'child_name'   => 'required|string|max:100',
        'password'     => 'required|string|min:8|confirmed',
        'profile_photo'=> 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'consent_form' => 'required|file|mimes:pdf|max:5120', // signed PDF mandatory
    ]);

    $profilePhotoPath = null;
    if ($request->hasFile('profile_photo')) {
        $file     = $request->file('profile_photo');
        $filename = 'guardian_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $stored   = $file->storeAs('guardians', $filename, 'public');
        $profilePhotoPath = 'storage/' . $stored;
    }

    if ($request->hasFile('consent_form')) {
        $pdf      = $request->file('consent_form');
        $filename = 'consent_' . time() . '_' . uniqid() . '.pdf';
        $pdf->storeAs('consent-forms', $filename, 'public');
    }

    $user = User::create([
        'name'         => $validated['name'],
        'email'        => $validated['email'],
        'phone'        => $validated['phone'],
        'nationality'  => $validated['nationality'],
        'position'     => 'Guardian of: ' . $validated['child_name'],
        'age'          => 0,
        'age_group'    => 'N/A',
        'password'     => Hash::make($validated['password']),
        'role'         => 'guardian',
        'status'       => 'pending',         // requires admin approval
        'profile_photo'=> $profilePhotoPath,
    ]);

    Auth::login($user);
    return redirect()->route('dashboard')
        ->with('info', 'Guardian account created! Pending admin approval within 48 hours.');
}
</pre>

  <div class="sub-title">ENUM Migration for Guardian &amp; Coach Roles</div>
  <div class="pre-label">database/migrations/2026_06_23_..._add_guardian_coach_roles_to_users.php</div>
<pre>
public function up(): void
{
    // Expand role ENUM to include coach and guardian
    DB::statement("ALTER TABLE users MODIFY COLUMN role
        ENUM('player','admin','coach','guardian') NOT NULL DEFAULT 'player'");

    // Expand age_group ENUM to allow 'N/A' for non-player accounts
    DB::statement("ALTER TABLE users MODIFY COLUMN age_group
        ENUM('U13','U15','U17','U19','Senior','N/A') NULL");
}
</pre>
</div>

{{-- ===== PAGE 6 — ADMIN DASHBOARD CODE ===== --}}
<div class="psa-page">
  <div class="pg-tag">Page 6 of 15</div>
  <div class="sec-title">5. Admin Dashboard &mdash; Guardian Approval Code</div>

  <div class="sub-title">DashboardController.php — admin() &amp; guardian approve/reject</div>
  <div class="pre-label">app/Http/Controllers/DashboardController.php</div>
<pre>
public function admin()
{
    $courses  = Course::withCount('lessons')->get();
    $players  = User::where('role', 'player')
                    ->with(['progress.course', 'latestRating', 'trainingSchedules'])
                    ->latest()->get();

    // Load guardians for admin approval panel
    $guardians = User::where('role', 'guardian')->latest()->get();

    $messages = ContactMessage::latest()->take(20)->get();
    $counts   = [
        'total'             => User::where('role','player')->count(),
        'approved'          => User::where('role','player')->where('status','approved')->count(),
        'pending'           => User::where('role','player')->where('status','pending')->count(),
        'rejected'          => User::where('role','player')->where('status','rejected')->count(),
        'messages'          => ContactMessage::where('read', false)->count(),
        'guardians_total'   => User::where('role','guardian')->count(),
        'guardians_pending' => User::where('role','guardian')->where('status','pending')->count(),
    ];

    return view('dashboard.admin', compact('players','guardians','messages','counts','courses'));
}

// Approve Guardian
public function approveGuardian(User $user)
{
    $user->update(['status' => 'approved']);
    return back()->with('success', $user->name . ' (Guardian) approved — can now access Guardian Portal.');
}

// Reject Guardian
public function rejectGuardian(User $user)
{
    $user->update(['status' => 'rejected']);
    return back()->with('success', $user->name . ' (Guardian) rejected.');
}
</pre>

  <div class="sub-title">Admin Dashboard Routes — routes/web.php</div>
  <div class="pre-label">routes/web.php (admin group excerpt)</div>
<pre>
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',                   [DashboardController::class, 'admin'])->name('dashboard');
    // Players
    Route::post('/players/{user}/approve',     [DashboardController::class, 'approvePlayer'])->name('players.approve');
    Route::post('/players/{user}/reject',      [DashboardController::class, 'rejectPlayer'])->name('players.reject');
    // Guardians (NEW)
    Route::post('/guardians/{user}/approve',   [DashboardController::class, 'approveGuardian'])->name('guardians.approve');
    Route::post('/guardians/{user}/reject',    [DashboardController::class, 'rejectGuardian'])->name('guardians.reject');
    // ... training, news, league, quiz, messages, spotlight, about
});
</pre>

  <div class="sub-title">Admin Dashboard View — Guardians Table (admin.blade.php)</div>
  <div class="pre-label">resources/views/dashboard/admin.blade.php (guardians panel)</div>
<pre>
&lt;div class="pnl" id="guardians"&gt;
  &lt;div class="pnl-h"&gt;
    Registered Guardians
    @if($counts['guardians_pending']&gt;0)
      &lt;span class="pl pl-y"&gt;{{ $counts['guardians_pending'] }} pending&lt;/span&gt;
    @endif
  &lt;/div&gt;
  @forelse($guardians as $guardian)
  &lt;tr&gt;
    &lt;td&gt;{{ $guardian->name }} — {{ $guardian->email }}&lt;/td&gt;
    &lt;td&gt;{{ $guardian->position }}&lt;/td&gt;
    &lt;td&gt;
      @if($guardian->status !== 'approved')
      &lt;form action="{{ route('admin.guardians.approve',$guardian) }}" method="POST"&gt;
        @csrf &lt;button type="submit"&gt;Approve&lt;/button&gt;
      &lt;/form&gt;
      @endif
      @if($guardian->status !== 'rejected')
      &lt;form action="{{ route('admin.guardians.reject',$guardian) }}" method="POST"&gt;
        @csrf &lt;button type="submit"&gt;Reject&lt;/button&gt;
      &lt;/form&gt;
      @endif
    &lt;/td&gt;
  &lt;/tr&gt;
  @endforelse
&lt;/div&gt;
</pre>
</div>

{{-- ===== PAGE 7 — CONSENT FORM CODE ===== --}}
<div class="psa-page">
  <div class="pg-tag">Page 7 of 15</div>
  <div class="sec-title">6. Guardian Consent Form &mdash; Code &amp; Workflow</div>

  <div class="sub-title">Consent Form Route &amp; Controller</div>
  <div class="pre-label">routes/web.php + PageController.php</div>
<pre>
// routes/web.php
Route::get('/consent-form', [PageController::class, 'consentForm'])->name('consent-form');

// app/Http/Controllers/PageController.php
public function consentForm()
{
    return view('pages.consent-form');  // standalone printable HTML (no @extends)
}
</pre>

  <div class="sub-title">Consent Form Upload (guardian-register.blade.php excerpt)</div>
  <div class="pre-label">resources/views/auth/guardian-register.blade.php</div>
<pre>
{{-- Download link --}}
&lt;div class="alert alert-warning"&gt;
  &lt;strong&gt;Required:&lt;/strong&gt; Download, print, sign, then upload the consent form.
  &lt;a href="{{ route('consent-form') }}" target="_blank" class="btn btn-sm btn-outline-dark"&gt;
    Open &amp; Print Consent Form
  &lt;/a&gt;
&lt;/div&gt;

{{-- Upload field --}}
&lt;input type="file" name="consent_form" accept="application/pdf,.pdf"&gt;
{{-- Validated: required|file|mimes:pdf|max:5120 --}}
</pre>

  <div class="sub-title">Consent Form — Seven Declarations Implemented</div>
  <table class="psa-table">
    <thead><tr><th>#</th><th>Declaration Title</th><th>Key Coverage</th></tr></thead>
    <tbody>
      <tr><td>1</td><td><strong>Participation Consent</strong></td><td>All training, matches, competitions, travel within/outside Lagos</td></tr>
      <tr><td>2</td><td><strong>Medical Consent</strong></td><td>First aid + emergency treatment authorisation if guardian unreachable</td></tr>
      <tr><td>3</td><td><strong>Photography &amp; Media</strong></td><td>Website, Facebook, Instagram, YouTube promotional use; no third-party sale</td></tr>
      <tr><td>4</td><td><strong>Code of Conduct</strong></td><td>Academy rules, guardian positive sideline behaviour commitment</td></tr>
      <tr><td>5</td><td><strong>Data Protection</strong></td><td>NDPB-compliant storage of child's personal data; no third-party sharing</td></tr>
      <tr><td>6</td><td><strong>Liability Acknowledgement</strong></td><td>Inherent football risks understood; reasonable care provision confirmed</td></tr>
      <tr><td>7</td><td><strong>Financial Obligations</strong></td><td>Fee payment agreement; non-refundable terms once season commences</td></tr>
    </tbody>
  </table>

  <div class="sub-title">Consent Form Validation (Server-side)</div>
  <div class="pre-label">RegisterController.php — validation rules</div>
<pre>
$request->validate([
    // ... other fields ...
    'consent_form' => 'required|file|mimes:pdf|max:5120',
    // PDF only, max 5 MB, required — registration blocked without it
]);
</pre>
</div>

{{-- ===== PAGE 8 — LIVE TIME & GUARDIAN PORTAL CODE ===== --}}
<div class="psa-page">
  <div class="pg-tag">Page 8 of 15</div>
  <div class="sec-title">7. Live Lagos Time &amp; Guardian Portal</div>

  <div class="sub-title">Live Lagos Time Clock — main.blade.php</div>
  <div class="pre-label">resources/views/layouts/main.blade.php</div>
<pre>
{{-- HTML -- above the navbar --}}
&lt;div id="ofa-time-bar"&gt;
  &lt;span&gt;&lt;i class="bi bi-geo-alt-fill"&gt;&lt;/i&gt; Lagos, Nigeria&lt;/span&gt;
  &lt;span&gt;|&lt;/span&gt;
  &lt;span id="ofa-live-date"&gt;&lt;/span&gt;
  &lt;span&gt;|&lt;/span&gt;
  &lt;span id="ofa-live-time" style="font-weight:700;color:#fbbf24;"&gt;&lt;/span&gt;
  &lt;span style="opacity:.5;"&gt;WAT (UTC+1)&lt;/span&gt;
&lt;/div&gt;

{{-- JavaScript -- before &lt;/body&gt; --}}
&lt;script&gt;
(function() {
  var dateEl = document.getElementById('ofa-live-date');
  var timeEl = document.getElementById('ofa-live-time');
  function tick() {
    var now = new Date();
    dateEl.textContent = now.toLocaleDateString('en-GB', {
      timeZone: 'Africa/Lagos',
      weekday:'short', day:'numeric', month:'short', year:'numeric'
    });
    timeEl.textContent = now.toLocaleTimeString('en-GB', {
      timeZone: 'Africa/Lagos',
      hour:'2-digit', minute:'2-digit', second:'2-digit', hour12:true
    });
  }
  tick();
  setInterval(tick, 1000);  // updates every second, every page
})();
&lt;/script&gt;
</pre>

  <div class="sub-title">Guardian Portal — Netlify Function (guardian-api.js)</div>
  <div class="pre-label">netlify-supabase/netlify/functions/guardian-api.js (excerpt)</div>
<pre>
const { isGuardian } = require('./_shared/auth-middleware');

exports.handler = async (event) => {
  const authCheck = await isGuardian(event);
  if (authCheck.error) return { statusCode: 403, body: JSON.stringify({ error: authCheck.error }) };

  const { supabase, user } = authCheck;
  const path = event.path.replace('/.netlify/functions/guardian-api', '');

  if (path === '/dashboard' &amp;&amp; event.httpMethod === 'GET') {
    const [children, invoices, schedules, announcements] = await Promise.all([
      supabase.from('guardian_children').select('*').eq('guardian_id', user.id),
      supabase.from('guardian_invoices').select('*').eq('guardian_id', user.id).limit(5),
      supabase.from('training_schedules').select('*').gte('date', new Date().toISOString()),
      supabase.from('announcements').select('*').order('created_at', { ascending: false }).limit(5),
    ]);
    return { statusCode: 200, body: JSON.stringify({ children, invoices, schedules, announcements }) };
  }
  // POST /tickets, POST /call-request, POST /consent/sign ...
};
</pre>

  <div class="sub-title">Guardian-Exclusive Course Block (education.js)</div>
  <div class="pre-label">netlify-supabase/netlify/functions/education.js (key security check)</div>
<pre>
const { blockPlayersFromGuardianCourse } = require('./_shared/auth-middleware');

// When player or coach tries to access a guardian-only course:
const blockResult = await blockPlayersFromGuardianCourse(event, courseId);
if (blockResult) {
  return {
    statusCode: 403,
    body: JSON.stringify({
      error: 'Access denied',
      code: 'GUARDIAN_ONLY_CONTENT',
      message: 'This course is exclusively for registered guardians/parents.'
    })
  };
}
</pre>
</div>

{{-- ===== PAGE 9 — SECURITY ===== --}}
<div class="psa-page">
  <div class="pg-tag">Page 9 of 15</div>
  <div class="sec-title">8. Security Implementation</div>

  <div class="sub-title">Netlify Security Headers (netlify.toml)</div>
  <div class="pre-label">netlify-supabase/netlify.toml</div>
<pre>
[[headers]]
  for = "/*"
  [headers.values]
    X-Frame-Options = "SAMEORIGIN"
    X-Content-Type-Options = "nosniff"
    X-XSS-Protection = "1; mode=block"
    Referrer-Policy = "strict-origin-when-cross-origin"
    Permissions-Policy = "camera=(), microphone=(), geolocation=()"
    Content-Security-Policy = "default-src 'self'; script-src 'self' 'unsafe-inline' cdn.jsdelivr.net fonts.googleapis.com; style-src 'self' 'unsafe-inline' cdn.jsdelivr.net fonts.googleapis.com; img-src 'self' data: *.supabase.co; font-src 'self' fonts.gstatic.com cdn.jsdelivr.net;"
    Strict-Transport-Security = "max-age=31536000; includeSubDomains; preload"
</pre>

  <div class="sub-title">Auth Middleware — auth-middleware.js</div>
  <div class="pre-label">netlify-supabase/netlify/functions/_shared/auth-middleware.js (key exports)</div>
<pre>
const { createClient } = require('@supabase/supabase-js');

async function isAuthenticated(event) { /* verify JWT from cookie */ }
async function isAdmin(event)         { /* role === 'admin' check */ }
async function isGuardian(event)      { /* role === 'guardian' check */ }
async function isPlayer(event)        { /* role === 'player' check */ }
async function blockPlayersFromGuardianCourse(event, courseId) {
  const auth = await isAuthenticated(event);
  if (!auth.error &amp;&amp; ['player','coach'].includes(auth.user.role)) {
    const { data } = await auth.supabase
      .from('courses').select('is_guardian_only').eq('id', courseId).single();
    if (data?.is_guardian_only) return true; // returns 403
  }
  return false;
}
module.exports = { isAuthenticated, isAdmin, isGuardian, isPlayer, blockPlayersFromGuardianCourse };
</pre>

  <div class="sub-title">Rate Limiting &amp; Sanitisation — security.js</div>
  <div class="pre-label">netlify-supabase/netlify/functions/_shared/security.js (excerpt)</div>
<pre>
const rateLimitStore = new Map();

function checkRateLimit(ip, action = 'api', max = 10, windowMs = 60000) {
  const key = `${ip}:${action}`;
  const now = Date.now();
  const record = rateLimitStore.get(key) || { count: 0, reset: now + windowMs };
  if (now > record.reset) { record.count = 0; record.reset = now + windowMs; }
  record.count++;
  rateLimitStore.set(key, record);
  return { allowed: record.count &lt;= max, remaining: Math.max(0, max - record.count) };
}

function sanitizeInput(str) {
  return String(str).replace(/[&lt;&gt;&amp;"'`]/g, c =&gt; ({
    '&lt;':'&amp;lt;', '&gt;':'&amp;gt;', '&amp;':'&amp;amp;', '"':'&amp;quot;', "'":'&amp;#39;', '`':'&amp;#96;'
  })[c]);
}
module.exports = { checkRateLimit, sanitizeInput };
</pre>
</div>

{{-- ===== PAGE 10 — DATABASE SCHEMA ===== --}}
<div class="psa-page">
  <div class="pg-tag">Page 10 of 15</div>
  <div class="sec-title">9. Database Schema (20 Tables)</div>
  <table class="psa-table">
    <thead><tr><th>Table</th><th>Key Columns</th><th>Purpose</th></tr></thead>
    <tbody>
      <tr><td><strong>users</strong></td><td><code>id, name, email, password, role [admin|coach|player|guardian], status [pending|approved|rejected], phone, position, age, age_group, nationality, profile_photo</code></td><td>All accounts — all 4 roles</td></tr>
      <tr><td><strong>courses</strong></td><td><code>id, title, level, is_active, is_guardian_only (bool), sort_order</code></td><td>Education hub courses</td></tr>
      <tr><td><strong>lessons</strong></td><td><code>id, course_id, title, content, order_index, duration_minutes</code></td><td>Lesson content units</td></tr>
      <tr><td><strong>player_progress</strong></td><td><code>id, user_id, course_id, status, progress_percent, completed_at</code></td><td>Course progress per user</td></tr>
      <tr><td><strong>lesson_progress</strong></td><td><code>id, user_id, lesson_id, completed_at</code></td><td>Lesson-level completion</td></tr>
      <tr><td><strong>quiz_weeks</strong></td><td><code>id, title, theme, week_start, week_end, is_active</code></td><td>Weekly quiz scheduling</td></tr>
      <tr><td><strong>quiz_questions</strong></td><td><code>id, quiz_week_id, question, options (JSON), correct_index, difficulty_level</code></td><td>120 questions / 7 levels</td></tr>
      <tr><td><strong>quiz_attempts</strong></td><td><code>id, quiz_week_id, user_id, score, total, time_taken, completed_at</code></td><td>Every submission recorded</td></tr>
      <tr><td><strong>match_results</strong></td><td><code>id, week_label, match_date, opponent, result_badge, competition, venue</code></td><td>League history</td></tr>
      <tr><td><strong>next_fixtures</strong></td><td><code>id, fixture_date, home_team, away_team, kick_off_time, is_active</code></td><td>Upcoming fixtures</td></tr>
      <tr><td><strong>standings</strong></td><td><code>id, team_name, played, won, drawn, lost, gf, ga, points, position</code></td><td>League table</td></tr>
      <tr><td><strong>posts</strong></td><td><code>id, title, body, author_id, image, category, published_at</code></td><td>News / announcements</td></tr>
      <tr><td><strong>training_schedules</strong></td><td><code>id, title, date, time, location, type, notes, created_by</code></td><td>Training calendar</td></tr>
      <tr><td><strong>guardian_children</strong></td><td><code>id, guardian_id, player_name, player_age, player_position, player_age_group</code></td><td>Guardian-to-child link</td></tr>
      <tr><td><strong>guardian_invoices</strong></td><td><code>id, guardian_id, description, amount, due_date, status [unpaid|paid|overdue|waived]</code></td><td>Fee invoices</td></tr>
      <tr><td><strong>guardian_tickets</strong></td><td><code>id, guardian_id, type [billing|absence|general|safeguarding], subject, message, status</code></td><td>Support tickets</td></tr>
      <tr><td><strong>announcements</strong></td><td><code>id, title, body, audience, created_by, created_at</code></td><td>Academy-wide notices</td></tr>
      <tr><td><strong>contact_messages</strong></td><td><code>id, name, email, phone, message, read, created_at</code></td><td>Contact form inbox</td></tr>
      <tr><td><strong>audit_logs</strong></td><td><code>id, admin_id, action, target_type, target_id, details (JSON), created_at</code></td><td>Admin audit trail</td></tr>
      <tr><td><strong>management_team</strong></td><td><code>id, name, title, bio, photo, sort_order</code></td><td>About page team</td></tr>
    </tbody>
  </table>

  <div class="sub-title">Supabase RLS Policy Example</div>
  <div class="pre-label">supabase/guardian_portal.sql — Row Level Security</div>
<pre>
-- Guardians can only see their own data
ALTER TABLE guardian_invoices ENABLE ROW LEVEL SECURITY;
CREATE POLICY "guardian_own_invoices" ON guardian_invoices
  FOR ALL USING (guardian_id = auth.uid());

-- Admins bypass RLS
CREATE POLICY "admin_full_access" ON guardian_invoices
  FOR ALL USING (
    EXISTS (SELECT 1 FROM profiles WHERE id = auth.uid() AND role = 'admin')
  );
</pre>
</div>

{{-- ===== PAGE 11 — DEPLOYMENT CODE ===== --}}
<div class="psa-page">
  <div class="pg-tag">Page 11 of 15</div>
  <div class="sec-title">10. Deployment &mdash; Netlify CI/CD &amp; GitHub</div>

  <div class="sub-title">Netlify Build Configuration</div>
  <div class="pre-label">netlify-supabase/netlify.toml</div>
<pre>
[build]
  base    = "netlify-supabase"
  command = "npm run build"
  publish = ".next"

[build.environment]
  NODE_VERSION = "20"

[[plugins]]
  package = "@netlify/plugin-nextjs"

[[redirects]]
  from   = "/api/*"
  to     = "/.netlify/functions/:splat"
  status = 200
</pre>

  <div class="sub-title">GitHub Actions Workflow</div>
  <div class="pre-label">.github/workflows/netlify-deploy.yml</div>
<pre>
name: Deploy to Netlify
on:
  push:
    branches: [ main ]
jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: actions/setup-node@v4
        with: { node-version: '20' }
      - run: cd netlify-supabase &amp;&amp; npm ci
      - run: cd netlify-supabase &amp;&amp; npm run build
      - uses: netlify/actions/cli@master
        with:
          args: deploy --prod --dir=netlify-supabase/.next
        env:
          NETLIFY_AUTH_TOKEN: ${{ secrets.NETLIFY_AUTH_TOKEN }}
          NETLIFY_SITE_ID:    ${{ secrets.NETLIFY_SITE_ID }}
</pre>

  <div class="sub-title">Deployment Steps</div>
  <table class="psa-table">
    <thead><tr><th>#</th><th>Step</th><th>Command</th></tr></thead>
    <tbody>
      <tr><td>1</td><td>Start local Laravel server</td><td><code>php artisan serve</code></td></tr>
      <tr><td>2</td><td>Run database migrations</td><td><code>php artisan migrate</code></td></tr>
      <tr><td>3</td><td>Seed demo accounts</td><td><code>php artisan db:seed --class=AdminSeeder</code></td></tr>
      <tr><td>4</td><td>Link storage</td><td><code>php artisan storage:link</code></td></tr>
      <tr><td>5</td><td>Stage all changes</td><td><code>git add .</code></td></tr>
      <tr><td>6</td><td>Commit</td><td><code>git commit -m "message"</code></td></tr>
      <tr><td>7</td><td>Push to GitHub &rarr; Netlify auto-deploys</td><td><code>git push origin main</code></td></tr>
      <tr><td>8</td><td>Run Supabase SQL migrations</td><td>Supabase Dashboard &rarr; SQL Editor</td></tr>
    </tbody>
  </table>

  <div class="sub-title">Demo Accounts (AdminSeeder)</div>
  <div class="pre-label">database/seeders/AdminSeeder.php</div>
<pre>
User::updateOrCreate(['email' => 'admin@olufunkefa.com'],    ['name'=>'OFA Admin',    'password'=>Hash::make('OFA@admin2025'), 'role'=>'admin',    'status'=>'approved']);
User::updateOrCreate(['email' => 'player@olufunkefa.com'],   ['name'=>'Demo Player',  'password'=>Hash::make('Player@2025'),   'role'=>'player',   'status'=>'approved','position'=>'Midfielder','age'=>17,'age_group'=>'U17']);
User::updateOrCreate(['email' => 'guardian@olufunkefa.com'], ['name'=>'Demo Guardian','password'=>Hash::make('Guardian@2025'), 'role'=>'guardian', 'status'=>'approved','position'=>'Parent/Guardian','age'=>0,'age_group'=>'N/A']);
</pre>
</div>

{{-- ===== PAGE 12 — NEXT.JS GUARDIAN REGISTER CODE ===== --}}
<div class="psa-page">
  <div class="pg-tag">Page 12 of 15</div>
  <div class="sec-title">11. Next.js Frontend Code &mdash; Key Pages</div>

  <div class="sub-title">Guardian Registration — pages/guardian-register.js (structure)</div>
  <div class="pre-label">netlify-supabase/src/pages/guardian-register.js</div>
<pre>
import { useState, useEffect } from 'react';
import { useSupabaseClient, useSession } from '@supabase/auth-helpers-react';
import { checkRateLimit, sanitizeForm, validateEmail, validatePassword } from '../lib/security';

export default function GuardianRegister() {
  const supabase = useSupabaseClient();
  const [step, setStep] = useState(1);   // 4-step form
  const [form, setForm] = useState({
    name:'', email:'', phone:'', nationality:'', relationship:'',
    childName:'', consentFile: null, password:'', passwordConfirm:''
  });

  // Step 1: Guardian info
  // Step 2: Child info
  // Step 3: Consent form download + PDF upload (required)
  // Step 4: Password + submit

  const handleSubmit = async () => {
    if (!checkRateLimit('registration', 3, 300000).allowed)
      return setError('Too many attempts. Please wait 5 minutes.');

    const sanitized = sanitizeForm(form);
    const { error } = await supabase.auth.signUp({
      email: sanitized.email,
      password: sanitized.password,
      options: { data: { name: sanitized.name, role: 'guardian', status: 'pending' } }
    });
    if (!error) {
      // Upload consent PDF to Supabase Storage
      await supabase.storage.from('consent-forms')
        .upload(`consent_${Date.now()}.pdf`, form.consentFile);
      router.push('/dashboard');
    }
  };
  // ...
}
</pre>

  <div class="sub-title">Consent Form — pages/consent-form.js (structure)</div>
  <div class="pre-label">netlify-supabase/src/pages/consent-form.js</div>
<pre>
import Head from 'next/head';

export default function ConsentForm() {
  return (
    &lt;&gt;
      &lt;Head&gt;&lt;title&gt;Guardian Consent Form | OFA&lt;/title&gt;&lt;/Head&gt;
      &lt;!-- Action bar with Print PDF button --&gt;
      &lt;div id="action-bar"&gt;
        &lt;button onClick={() =&gt; window.print()}&gt;Print / Save as PDF&lt;/button&gt;
      &lt;/div&gt;
      &lt;!-- Section A: Guardian Info --&gt;
      &lt;!-- Section B: Player Info --&gt;
      &lt;!-- Section C: 7 Consent Declarations --&gt;
      &lt;!-- Section D: Emergency Contact --&gt;
      &lt;!-- Section E: Guardian Signature --&gt;
    &lt;/&gt;
  );
}
</pre>

  <div class="sub-title">NavBar — Live Lagos Time (NavBar.js)</div>
  <div class="pre-label">netlify-supabase/src/components/NavBar.js (time bar excerpt)</div>
<pre>
import { useState, useEffect } from 'react';

export default function NavBar() {
  const [liveTime, setLiveTime] = useState('');
  const [liveDate, setLiveDate] = useState('');

  useEffect(() => {
    const tick = () => {
      const now = new Date();
      setLiveDate(now.toLocaleDateString('en-GB', {
        timeZone:'Africa/Lagos', weekday:'short', day:'numeric', month:'short', year:'numeric'
      }));
      setLiveTime(now.toLocaleTimeString('en-GB', {
        timeZone:'Africa/Lagos', hour:'2-digit', minute:'2-digit', second:'2-digit', hour12:true
      }));
    };
    tick();
    const id = setInterval(tick, 1000);
    return () => clearInterval(id);
  }, []);

  return (
    &lt;&gt;
      &lt;div id="ofa-time-bar"&gt;
        Lagos, Nigeria | {liveDate} | &lt;strong&gt;{liveTime}&lt;/strong&gt; WAT
      &lt;/div&gt;
      &lt;nav&gt;{/* ... navigation */}&lt;/nav&gt;
    &lt;/&gt;
  );
}
</pre>
</div>

{{-- ===== PAGE 13 — METHODOLOGY & TESTING ===== --}}
<div class="psa-page">
  <div class="pg-tag">Page 13 of 15</div>
  <div class="sec-title">12. Methodology &amp; Testing</div>

  <table class="psa-table">
    <thead><tr><th>#</th><th>Phase</th><th>Deliverables</th></tr></thead>
    <tbody>
      <tr><td><span class="b bb">1</span></td><td><strong>Requirements</strong></td><td>Stakeholder meetings; RBAC matrix; user stories; Guardian portal spec; Consent Form workflow</td></tr>
      <tr><td><span class="b bb">2</span></td><td><strong>Architecture</strong></td><td>Decoupled Laravel + Next.js design; wireframes; ERD; security model</td></tr>
      <tr><td><span class="b bb">3</span></td><td><strong>Database Design</strong></td><td>20 tables; MySQL migrations; PostgreSQL Supabase schema with RLS; ENUM expansions for guardian/coach roles</td></tr>
      <tr><td><span class="b bb">4</span></td><td><strong>Backend (Laravel)</strong></td><td>MVC; auth; RBAC middleware; RegisterController (Player + Guardian + Coach); DashboardController (approve/reject Players &amp; Guardians); PageController (consent-form, psa-report)</td></tr>
      <tr><td><span class="b bb">5</span></td><td><strong>Frontend (Next.js)</strong></td><td>All 17 pages; Guardian Registration multi-step form; Consent Form printable page; Admin Dashboard; Guardian Portal (dashboard, schedule, finances, learn); Quiz engine</td></tr>
      <tr><td><span class="b bb">6</span></td><td><strong>Content</strong></td><td>3 player courses (15 lessons); 5 guardian courses (20 lessons); 120 quiz questions / 7 levels; match results; league standings</td></tr>
      <tr><td><span class="b bb">7</span></td><td><strong>Integration &amp; Testing</strong></td><td>All registration flows; role blocks; HTTP 403 guardian course guard; consent form upload; admin guardian approve/reject; live time on all pages</td></tr>
      <tr><td><span class="b bb">8</span></td><td><strong>UAT</strong></td><td>Academy representative review; guardian testimonials; demo accounts verified</td></tr>
      <tr><td><span class="b bb">9</span></td><td><strong>Deployment</strong></td><td>git push origin main &rarr; Netlify CI/CD; Supabase SQL migrations; custom domain + HTTPS; AdminSeeder run</td></tr>
    </tbody>
  </table>

  <div class="sub-title">Test Results</div>
  <table class="psa-table">
    <thead><tr><th>Test Case</th><th>Result</th></tr></thead>
    <tbody>
      <tr><td>Guardian registers — consent PDF required, blocks without it</td><td><span class="b bg">Pass</span></td></tr>
      <tr><td>Admin approves Guardian — status changes to approved</td><td><span class="b bg">Pass</span></td></tr>
      <tr><td>Admin rejects Guardian — status changes to rejected</td><td><span class="b bg">Pass</span></td></tr>
      <tr><td>Player tries guardian course URL — HTTP 403 returned</td><td><span class="b bg">Pass</span></td></tr>
      <tr><td>Coach tries guardian course URL — HTTP 403 returned</td><td><span class="b bg">Pass</span></td></tr>
      <tr><td>Guardian accesses guardian courses — full access granted</td><td><span class="b bg">Pass</span></td></tr>
      <tr><td>Consent form prints cleanly (no navbar/action bar)</td><td><span class="b bg">Pass</span></td></tr>
      <tr><td>PSA report prints cleanly (no navbar/action bar)</td><td><span class="b bg">Pass</span></td></tr>
      <tr><td>Live Lagos time updates every second on every page</td><td><span class="b bg">Pass</span></td></tr>
      <tr><td>All 4 roles login and redirect to correct dashboard</td><td><span class="b bg">Pass</span></td></tr>
      <tr><td>Guardian dashboard shows "Own Child" view only</td><td><span class="b bg">Pass</span></td></tr>
      <tr><td>Register as Player — all 4 roles can access the form</td><td><span class="b bg">Pass</span></td></tr>
      <tr><td>git push triggers Netlify auto-deploy successfully</td><td><span class="b bg">Pass</span></td></tr>
      <tr><td>HTTPS enforced on olufunkefootballacademy.com</td><td><span class="b bg">Pass</span></td></tr>
      <tr><td>RLS policies block cross-user data access in Supabase</td><td><span class="b bg">Pass</span></td></tr>
    </tbody>
  </table>
</div>

{{-- ===== PAGE 14 — CONCLUSION ===== --}}
<div class="psa-page">
  <div class="pg-tag">Page 14 of 15</div>
  <div class="sec-title">13. Conclusion &amp; Achievements</div>

  <p>The Olufunke Football Academy platform is a fully functional, deployed, production-grade web application that solves every identified problem. It is live at <strong>olufunkefootballacademy.com</strong> with HTTPS, Supabase PostgreSQL with RLS, Netlify CDN, and Git-triggered CI/CD — all the hallmarks of a professional deployment.</p>

  <div class="sub-title">Key Achievements</div>
  <ul>
    <li><strong>Multi-role registration</strong> — unified /register page with 3 role cards, each routing to a dedicated form; Guardian registration requires a signed PDF consent form upload</li>
    <li><strong>Admin approve/reject</strong> — for both Players AND Guardians from the Admin Dashboard</li>
    <li><strong>Guardian Portal</strong> — exclusive courses (5), dashboard, schedule, finances, support tickets; all guarded server-side</li>
    <li><strong>HTTP 403 course block</strong> — Players and Coaches cannot access guardian-exclusive courses even via direct URL</li>
    <li><strong>Live Lagos time</strong> — West Africa Time (UTC+1) displayed on every single page, updating every second</li>
    <li><strong>Printable documents</strong> — Consent Form (/consent-form) and PSA Report (/psa-report) both print cleanly to PDF via window.print()</li>
    <li><strong>Security</strong> — bcrypt, CSRF, rate limiting, CSP headers, RLS policies, input sanitisation, audit logs</li>
    <li><strong>CI/CD</strong> — git push origin main triggers automatic Netlify build and deploy</li>
  </ul>

  <div class="ibox ibox-blue">
    <em><i class="bi bi-chat-quote-fill me-2"></i><strong>Mr. Austin (Team Manager):</strong> "The website has given our academy a face online. The registration module, guardian portal, and education system are exactly what we needed. This is a truly professional solution."</em>
  </div>
  <div class="ibox ibox-green">
    <em><i class="bi bi-chat-quote-fill me-2"></i><strong>Mrs. Chidimma Ngozi (Guardian):</strong> "I registered my son in minutes from my phone. The consent form was easy to print and upload. Now I can check his training schedule any time without calling the coach."</em>
  </div>

  <div class="sub-title">Future Enhancements</div>
  <ul>
    <li>Mobile app (React Native) with push notifications</li>
    <li>Online payment integration (Paystack / Flutterwave) for academy fee invoices</li>
    <li>Video lesson streaming for Education Hub</li>
    <li>Guardian-to-coach messaging system</li>
    <li>Player performance analytics with radar charts</li>
    <li>Multi-language support (Yoruba, Pidgin English)</li>
  </ul>
</div>

{{-- ===== PAGE 15 — REFERENCES & SIGNATURE ===== --}}
<div class="psa-page">
  <div class="pg-tag">Page 15 of 15</div>
  <div class="sec-title">14. References</div>
  <ol style="font-size:.82rem;line-height:2.2;">
    <li>Laravel Documentation. (2024). <em>Laravel 12 &mdash; The PHP Framework for Web Artisans</em>. laravel.com/docs</li>
    <li>Next.js Documentation. (2024). <em>Next.js by Vercel</em>. nextjs.org/docs</li>
    <li>Supabase Documentation. (2024). <em>Supabase &mdash; Open Source Firebase Alternative</em>. supabase.com/docs</li>
    <li>Netlify Documentation. (2024). <em>Netlify &mdash; Modern Web Development Platform</em>. docs.netlify.com</li>
    <li>React Documentation. (2024). <em>React 18 &mdash; A JavaScript Library for Building User Interfaces</em>. react.dev</li>
    <li>Bootstrap Documentation. (2024). <em>Bootstrap 5.3 &mdash; Build fast, responsive sites</em>. getbootstrap.com/docs</li>
    <li>MySQL Documentation. (2024). <em>MySQL 8.0 Reference Manual</em>. dev.mysql.com/doc</li>
    <li>OWASP. (2024). <em>OWASP Top 10 Web Application Security Risks</em>. owasp.org/Top10</li>
    <li>Nigeria Data Protection Bureau. (2024). <em>NDPB Guidelines for Data Controllers</em>. ndpb.gov.ng</li>
    <li>FIFA. (2024). <em>Football Education and Development Resources</em>. fifa.com/development</li>
    <li>Duckett, J. (2018). <em>HTML &amp; CSS: Design and Build Websites</em>. Wiley.</li>
    <li>Flanagan, D. (2020). <em>JavaScript: The Definitive Guide, 7th Edition</em>. O'Reilly Media.</li>
  </ol>

  <div class="sig-block">
    <div style="font-size:1.1rem;font-weight:800;margin-bottom:6px;">Olufemi Emmanuel Olugbodi</div>
    <div style="opacity:.8;font-size:.88rem;">Computer Software Engineering &mdash; Semester 4</div>
    <div style="opacity:.8;font-size:.88rem;">Lincoln College of Science Management and Technology</div>
    <div style="opacity:.6;font-size:.8rem;margin-top:8px;">Student ID: LCSMT-NGA-005-ADM-1001393 &nbsp;&middot;&nbsp; Date: 18 June 2026 &nbsp;&middot;&nbsp; Supervisor: Mr. Ibrahim Isiaka</div>
    <div style="margin-top:16px;font-size:.75rem;opacity:.4;letter-spacing:.06em;">OLUFUNKE FOOTBALL ACADEMY &middot; PSA DOCUMENTATION v3.0 &middot; PAGE 15 OF 15</div>
  </div>
</div>

</div>{{-- .doc-wrap --}}
</body>
</html>
