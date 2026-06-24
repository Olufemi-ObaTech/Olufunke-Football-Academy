# PROJECT-BASED SKILLS ASSESSMENT (PSA) DOCUMENTATION

---

<p align="center">
  <strong>Lincoln College of Science Management and Technology</strong><br/>
  Computer Software Engineering Department
</p>

---

**Student Information**

| Field | Detail |
|-------|--------|
| Name | Olufemi Emmanuel Olugbodi |
| Department | Computer Software Engineering |
| Semester | Semester 4 |
| Student ID | LCSMT-NGA-005-ADM-1001393 |
| Date | 18/06/2026 |
| Supervisor | Mr. Ibrahim Isiaka |

---

## PROJECT TITLE

### Olufunke Football Academy Comprehensive Web Platform with Integrated Player Development System

**Live Website:** [olufunkefootballacademy.com](https://olufunkefootballacademy.com)

---

---

## PAGE 1 — ABSTRACT

This Project-Based Skills Assessment (PSA) report documents the design, development, and deployment of a comprehensive web-based platform for **Olufunke Football Academy (OFA)**, a FIFA TMS-registered, LSFA-affiliated football academy based in Lagos, Nigeria. Founded in September 2023 under RC-7147523, the academy required a modern digital infrastructure to support its growing operations and player base.

The project applies full-stack web development techniques to address real-world challenges including digital invisibility, administrative inefficiency, lack of structured player education, and the absence of a guardian self-service portal. The resulting platform serves as a central hub for information dissemination, player registration, schedule management, academy promotion, educational content delivery, and interactive knowledge assessment.

Key technology choices include **Laravel (PHP)** for a robust, secure backend; **Next.js (React)** for a fast, server-side-rendered frontend; and **Supabase (PostgreSQL)** as a backend-as-a-service providing real-time data, authentication, and file storage. The entire frontend is deployed on **Netlify** under the custom domain `olufunkefootballacademy.com`, with continuous deployment integrated via GitHub Actions.

The system is distinguished by its comprehensive **role-based access control (RBAC)** system covering Admin/Coach, Player, and Guardian roles; its **Guardian Portal** enabling parents to register their children and monitor development; its **Football Education Hub** delivering structured courses and interactive quizzes; and its strict **document verification workflow** requiring signed consent forms and passport photographs for all registrations.

The project demonstrates the successful application of professional software engineering practices — from requirements gathering through architecture design, iterative development, security hardening, testing, and cloud deployment — to a real-world client need.

---

---

## PAGE 2 — BACKGROUND OF THE STUDY

### 2.1 Context and Motivation

Digital transformation is no longer optional for organisations that wish to remain competitive, credible, and operationally efficient. This reality applies equally to small and community-based entities such as local sports academies. In Nigeria's rapidly digitising economy, a professional online presence is a prerequisite for attracting talent, securing sponsorships, communicating with stakeholders, and managing day-to-day operations effectively.

Olufunke Football Academy, like many grassroots sports organisations in Nigeria, relied entirely on manual, analogue processes prior to this project. Player registrations were handled via paper forms and phone calls. Training schedules were communicated informally. News and match updates reached interested parties only through word of mouth or SMS broadcasts. Guardians had no formal channel through which to enrol their children or track their development. There was no structured system for teaching players about football theory, tactics, nutrition, or career development beyond on-field coaching sessions.

These constraints not only limited the academy's operational efficiency but also restricted its visibility, hindered its growth, and diminished its professional image in the eyes of potential players, sponsors, and partner organisations.

### 2.2 Skills Acquired During PCA Phase

During the Practical Skills Acquisition (PCA) phase, the following competencies were developed and subsequently applied in this project:

- **Frontend development** — creating responsive, user-friendly interfaces using React and Next.js, styled with Bootstrap 5 and custom CSS.
- **Backend development** — building secure, RESTful server-side logic using Laravel (PHP) and Netlify serverless functions (Node.js).
- **Database management** — designing normalised relational schemas in PostgreSQL via Supabase, implementing Row Level Security (RLS) policies, and writing optimised SQL queries.
- **Authentication and authorisation** — implementing Supabase Auth with email/password, magic link, and OAuth (Google, GitHub), combined with role-based access control.
- **File storage and management** — uploading and managing user documents (consent PDFs and passport photographs) in Supabase Storage with bucket-level security policies.
- **Environment setup and DevOps** — configuring local development stacks (XAMPP for Laravel, Node.js for frontend), managing environment variables, and deploying to cloud platforms.
- **Security practices** — implementing CSP headers, CORS validation, XSS protection, SQL injection prevention via prepared statements, and rate limiting on all API endpoints.
- **Version control and CI/CD** — using Git/GitHub for source control and GitHub Actions for automated build and deployment pipelines.

These skills were synthesised and applied to a genuine client project, from initial problem analysis through requirements gathering, system design, iterative development, testing, and final production deployment — mirroring the full lifecycle of a professional software engineering engagement.

---

---

## PAGE 3 — PROBLEM STATEMENT

### 3.1 Identified Problems

Prior to this project, Olufunke Football Academy faced six distinct operational and reputational challenges:

**1. Limited Digital Visibility**
The academy had no website or professional online presence. This severely restricted its ability to attract new players from beyond its immediate locality, engage potential sponsors, or project a professional image to partner organisations such as the LSFA (Lagos State Football Association).

**2. Administrative Inefficiency**
All administrative tasks — player registration, schedule distribution, fee collection, and communication with guardians — were conducted manually via phone calls, paper forms, and physical notice boards. This was time-consuming, error-prone, and created unnecessary delays in day-to-day operations.

**3. Poor Guardian Communication**
Parents and guardians had no digital channel to receive academy updates, confirm training schedules, or understand their child's development trajectory. This lack of communication frustrated guardians and reduced their engagement with the academy.

**4. Absence of a Guardian Self-Service Portal**
Guardians who wished to enrol their children had to visit the academy in person or make multiple phone calls. There was no system for remote registration, document submission, or progress monitoring — a significant barrier for working parents.

**5. No Structured Player Education System**
Player development at the academy was limited to on-field coaching. There was no digital resource to educate players about football tactics, nutrition and fitness, sports psychology, or career development pathways. This gap left players without the intellectual and academic foundations that elite academies provide.

**6. Lack of Professional Image**
Without a website or digital presence, the academy appeared informal and under-resourced compared to peer organisations. This hindered its ability to attract quality coaching staff, sign affiliation agreements, or compete for institutional grants and sponsorships.

### 3.2 Proposed Solution

To address all six identified problems, a comprehensive web platform was designed and built offering:

- A professional, responsive website accessible on all devices.
- An automated online player registration system replacing paper forms.
- A dedicated Guardian Portal for remote child enrolment and progress monitoring.
- A centralised information hub for schedules, news, and match results.
- An integrated Football Education Hub with structured courses and interactive quizzes.
- A protected administrative dashboard for content, user, and quiz management.
- A comprehensive role-based access control system (Admin/Coach, Player, Guardian).
- Mandatory document verification requiring consent forms and passport photographs.

---

---

## PAGE 4 — OBJECTIVES

### 4.1 General Objective

To design, develop, and deploy a comprehensive, secure, and scalable web platform for Olufunke Football Academy that streamlines administration, enhances online visibility, supports player education through digital learning and interactive assessment, and empowers guardians with a dedicated self-service registration and monitoring portal.

### 4.2 Specific Objectives

**Objective 1 — Professional Online Presence**
Develop a fully responsive, visually appealing website hosted at `olufunkefootballacademy.com` that showcases the academy's identity, programs, coaching staff, achievements, and values to prospective players, guardians, and sponsors.

**Objective 2 — Automated Registration System**
Build a secure, multi-step online registration system that collects player and guardian information, enforces mandatory document submission (signed consent form as PDF and passport photograph), and stores data safely in a PostgreSQL database.

**Objective 3 — Guardian Portal**
Create a dedicated Guardian Registration page enabling parents and legal guardians to remotely enrol their children, upload the required consent form and guardian passport photograph, and subsequently monitor their child's training progress, quiz performance, and course completion from a personalised dashboard.

**Objective 4 — Administrative Dashboard**
Provide a password-protected admin interface for academy staff to manage training schedules, publish news and announcements, manage registered players, create and manage educational courses and quizzes, review uploaded documents, and monitor player development metrics.

**Objective 5 — Football Education Courses**
Design and deliver structured digital learning content covering football tactics and game understanding, nutrition and physical conditioning, sports psychology and mental preparation, and career development and life skills.

**Objective 6 — Knowledge Assessment System**
Build an interactive weekly Football IQ Quiz system open to all visitors (no login required) with a live leaderboard, score tracking, immediate result feedback, and a rating system (Football Genius → Keep Learning) to motivate ongoing engagement.

**Objective 7 — Role-Based Access Control**
Define and strictly enforce differentiated permissions for Admin/Coach, Player, and Guardian user roles throughout the platform, ensuring each user type can only access the features appropriate to their role.

**Objective 8 — Security and Reliability**
Implement comprehensive security measures including HTTPS enforcement, Content Security Policy headers, XSS input sanitisation, CSRF protection, SQL injection prevention via prepared statements, bcrypt password hashing, and IP-based rate limiting on all API endpoints.

**Objective 9 — Live Date/Time Display**
Display the current live date and time in Lagos, Nigeria (West Africa Time, UTC+1) throughout the platform where relevant, ensuring users always see accurate, real-time information calibrated to the academy's timezone.

---

---

## PAGE 5 — USER ROLES AND PERMISSIONS

### 5.1 Role-Based Access Control Overview

The platform implements a comprehensive Role-Based Access Control (RBAC) system with three distinct user roles. Each role has specific permissions precisely tailored to its responsibilities within the academy ecosystem. Role assignment is handled at the point of registration and is stored securely in the Supabase `profiles` table.

### 5.2 Permissions Matrix

| Feature | Admin & Coach | Player | Guardian |
|---------|:---:|:---:|:---:|
| View Public Pages | ✓ | ✓ | ✓ |
| Register New Player (with consent PDF + passport photo) | ✓ | ✓ | ✓ |
| Manage Training Schedules | ✓ | ✗ | ✗ |
| Post News & Announcements | ✓ | ✗ | ✗ |
| Manage Courses & Lessons | ✓ | ✗ | ✗ |
| Create & Manage Quizzes | ✓ | ✗ | ✗ |
| Access Football Education Hub | ✓ | ✓ | ✓ |
| Take Quizzes | ✓ | ✓ | ✓ |
| View Player Data & Progress | ✓ (all players) | ✓ (own data) | ✓ (own child) |
| Review & Approve Registrations | ✓ | ✗ | ✗ |
| Access System Settings | ✓ | ✗ | ✗ |
| View Uploaded Documents | ✓ | ✗ | ✗ |

### 5.3 Role Descriptions

**Admin & Coach**
Full system access — the most privileged role. Admins and coaches can manage all content, users, schedules, courses, quizzes, and system settings. Admins can register players via the Player Registration page by submitting a mandatory signed consent form (PDF upload) and uploading the player's passport photograph. They can review all uploaded documents, approve or reject player registrations, and access the full admin dashboard. Default admin credentials are configured securely via environment variables and changed immediately after initial setup.

**Player**
Players can self-register via the Player Registration page by completing a four-step form: Personal Information, Football Profile, Documents (mandatory signed consent form as PDF upload, plus passport photograph upload), and Account Security. Once registered, players can view public pages, access the Football Education Hub, take the weekly Football IQ Quiz, and view their own personalised dashboard showing learning progress, quiz history, and profile information. Players cannot manage content, view other players' data, or register other users. Full access is granted only after email confirmation and admin approval.

**Guardian**
Guardians can register new players (their children) via the dedicated Guardian Registration page, which requires: guardian personal information, player details, a signed consent form (PDF upload), and a guardian passport photograph upload. Upon approval, guardians can view their child's player data and development progress, access the Football Education Hub, and take quizzes. Guardians cannot manage academy content, view other players' data, or access administrative functions.

### 5.4 Guardian-Specific Features

The Guardian role was designed specifically to address the needs of working parents who:
- Cannot physically visit the academy to complete registration paperwork.
- Must provide legally valid written consent for their child's participation.
- Want to remotely monitor their child's training schedule, course progress, and quiz performance.
- Need access to the academy's educational philosophy and resources.
- May have limited technical experience, requiring an intuitive, step-by-step interface.

---

---

## PAGE 6 — CONSENT FORM AND DOCUMENT REQUIREMENTS

### 6.1 Consent Form Requirement

All player and guardian registrations **must** include a signed consent form uploaded as a PDF. The consent form (`/consent-form`) is a printable, web-accessible document that users can:

1. Open in a browser and print, or save as PDF via the browser print function (Ctrl+P / Cmd+P).
2. Fill in all required sections (Guardian/Player Info, Consent Declarations, Signature).
3. Sign and date the completed form.
4. Scan or photograph the completed form and save as PDF (maximum 5MB).
5. Upload during Step 3 of the Player Registration or Guardian Registration process.

### 6.2 The Seven Consent Declarations

The consent form contains seven mandatory declarations covering all key aspects of academy participation:

| # | Declaration | Description |
|---|-------------|-------------|
| 1 | Participation Consent | Permission for the child to participate in all academy activities. |
| 2 | Medical Consent | Authorisation for first-aid and emergency medical care. |
| 3 | Photography & Media | Permission for photos/videos for promotional purposes. |
| 4 | Code of Conduct | Agreement to abide by all academy rules and policies. |
| 5 | Data Protection | Consent for data collection and storage under applicable laws. |
| 6 | Liability Acknowledgement | Understanding of inherent physical risks in football. |
| 7 | Financial Obligations | Agreement to fulfil all fee and equipment cost requirements. |

### 6.3 Passport Photograph Requirement

In addition to the consent form, all registrations require a passport photograph upload:

- **Players** upload their own passport photograph during Step 3 (Documents) of the Player Registration form.
- **Guardians** upload their own passport photograph during Step 3 (Consent Form) of the Guardian Registration form.
- Accepted formats: JPG, JPEG, PNG, WebP.
- Maximum file size: 3MB.
- Images are stored securely in Supabase Storage under the `player-photos` bucket, linked to the user's Supabase Auth ID.

### 6.4 Document Storage and Security

All uploaded documents are stored in private Supabase Storage buckets accessible only to authenticated admin users:
- `consent-forms` bucket — signed consent PDFs.
- `player-photos` bucket — passport photographs.

Files are named using a deterministic pattern including the user's Supabase Auth ID and a timestamp to prevent conflicts and enable administrative retrieval. Admin users can download and review all documents from the admin dashboard before approving registrations.

---

---

## PAGE 7 — CLIENT AND SYSTEM REQUIREMENTS

### 7.1 Client (End-User) Requirements

**Minimum Device Requirements:**
- Modern web browser (Chrome, Firefox, Safari, Edge — latest 2 major versions)
- Internet connection (minimum 1 Mbps for content pages; 5 Mbps for video content)
- Screen resolution: 320px minimum width (mobile-first responsive design)

**Supported Platforms:**

| Platform | Browser | Minimum Version |
|----------|---------|----------------|
| Desktop (Windows/Mac/Linux) | Chrome, Firefox, Safari, Edge | Latest 2 major versions |
| Android | Chrome, Samsung Internet | Android 8.0+ |
| iPhone/iPad | Safari, Chrome | iOS 14+ |

### 7.2 Server Requirements

| Component | Requirement |
|-----------|-------------|
| Frontend Framework | Next.js 14 (React 18) |
| Backend Framework | Laravel 10 (PHP 8.1+) |
| Database | PostgreSQL via Supabase / MySQL 8.0 for Laravel |
| Frontend Hosting | Netlify (static + serverless functions) |
| Backend Hosting | PHP-compatible web host (XAMPP locally) |
| File Storage | Supabase Storage |
| Domain | olufunkefootballacademy.com |
| SSL | Enforced HTTPS (HSTS) on all endpoints |
| CI/CD | GitHub Actions → Netlify auto-deploy |

### 7.3 Responsive Design

The platform is fully responsive across all device categories:

- **Desktop** — 1920×1080, 1366×768, 1024×768
- **Tablet** — iPad (768px+), Samsung Galaxy Tab
- **Mobile** — iPhone SE (375px), iPhone 14/15, Samsung Galaxy S series, various Android devices

All UI components adapt seamlessly using the Bootstrap 5 grid system and custom CSS media queries. Images are constrained with `max-width: 100%` and `object-fit: cover` to prevent overflow and distortion on all screen sizes. The navigation collapses to a hamburger menu on small screens.

### 7.4 Environment Variables

The following environment variables are configured securely in Netlify's dashboard (never committed to source control):

| Variable | Purpose |
|----------|---------|
| `NEXT_PUBLIC_SUPABASE_URL` | Supabase project URL |
| `NEXT_PUBLIC_SUPABASE_ANON_KEY` | Supabase public anon key |
| `SUPABASE_SERVICE_ROLE_KEY` | Supabase service role key (server-side only) |
| `NEXT_PUBLIC_SITE_URL` | `https://olufunkefootballacademy.com` |

---

---

## PAGE 8 — METHODOLOGY

### 8.1 Development Approach

The project followed an **iterative, phased development methodology** that combined structured planning with continuous feedback cycles. This approach ensured the final product accurately reflected the academy's real operational needs while allowing flexibility to incorporate new requirements as they emerged.

### 8.2 Phases of Development

**Phase 1 — Requirements Analysis & Planning**
Initial meetings were conducted with the academy representative (Mr. Austin, Team Manager) to identify pain points, define required features, establish site structure, determine educational content needs, and specify the Guardian Portal requirements. A detailed project timeline was established with deliverable milestones.

**Phase 2 — System Architecture Design**
The overall architecture was designed, including the decoupled frontend/backend structure, database schema, API layer design, and file storage strategy. Wireframes were created for all key user interfaces including the Player Registration, Guardian Registration, and Admin Dashboard pages. The database schema was planned to support all modules from registration to quiz tracking.

**Phase 3 — Database Design**
A PostgreSQL database (via Supabase) was created with 15 primary tables covering all system entities. The `profiles` table was extended with a `role` field (supporting `player`, `admin`, `guardian`) and a `status` field (supporting `pending`, `approved`, `rejected`) for the registration approval workflow. Row Level Security (RLS) policies were defined to enforce data access controls at the database level.

**Phase 4 — Backend Development (Laravel + Netlify Functions)**
The Laravel backend was built using the MVC pattern to expose RESTful APIs for the frontend. Netlify serverless functions (Node.js) handle quiz submission, contact form processing, player CRUD operations, and OAuth callback handling. All endpoints implement CORS validation, rate limiting, and input sanitisation.

**Phase 5 — Frontend Development (Next.js + Supabase)**
A standalone Next.js application was developed consuming both the Laravel APIs and Supabase direct client for real-time features. All 21 page files were created covering public pages, registration flows, dashboard, quiz engine, course player, and admin interface.

**Phase 6 — Content Creation**
Educational content was developed in collaboration with coaching staff covering football tactics, nutrition, sports psychology, and career guidance. A bank of quiz questions was compiled spanning multiple difficulty levels and topic areas.

**Phase 7 — Integration and Testing**
Frontend and backend were connected via API calls. All features were tested across user roles (Admin, Player, Guardian), devices (desktop, tablet, mobile), and browsers (Chrome, Firefox, Safari, Edge). Security testing covered XSS injection, SQL injection attempts, CORS validation, and rate limit enforcement.

**Phase 8 — User Acceptance Testing (UAT)**
The system was demonstrated to the academy representative. Adjustments were made based on feedback. A user manual was prepared for admin staff covering dashboard usage, quiz creation, and player management.

**Phase 9 — Deployment and Training**
The frontend was deployed to Netlify with the custom domain. Continuous deployment via GitHub Actions was configured. Academy staff received hands-on training on using the admin dashboard, reviewing registrations, and monitoring player activity.

---

---

## PAGE 9 — SYSTEM DESIGN AND ARCHITECTURE

### 9.1 Architecture Overview

The platform follows a modern **decoupled (headless) architecture** comprising two independently deployable components:

**Backend — Laravel + MySQL**
Serves as the primary business logic layer exposing RESTful APIs. Handles authentication for admin users, CRUD operations for all content types, and data validation. Deployed on a PHP-compatible hosting server (XAMPP for local development).

**Frontend — Next.js + Supabase**
A standalone React application providing server-side rendering for SEO-critical pages and client-side interactivity for dynamic features. Supabase provides real-time data, user authentication (email/password, magic link, Google, GitHub), role-based access control, and file storage. Deployed on Netlify with the custom domain.

The two components communicate securely over HTTPS. This separation allows independent scaling, maintenance, and technology upgrades without disrupting the other component.

### 9.2 Technology Stack

| Component | Technology | Purpose |
|-----------|------------|---------|
| Backend Framework | Laravel 10 (PHP 8.1) | RESTful APIs, business logic, MVC structure |
| Primary Database | MySQL 8.0 (Laravel) | Relational data storage for backend |
| Frontend Framework | Next.js 14 (React 18) | Server-side rendering, routing, interactive UI |
| BaaS | Supabase (PostgreSQL) | Auth, real-time DB, file storage, RLS policies |
| Serverless Functions | Netlify Functions (Node.js) | Quiz engine, contact form, player API |
| Frontend Hosting | Netlify | Static/serverless deployment, CDN, custom domain |
| Local Dev Environment | XAMPP | Apache + MySQL + PHP for Laravel development |
| Version Control | Git + GitHub | Source control, branch management |
| CI/CD | GitHub Actions | Automated build and Netlify deployment |
| CSS Framework | Bootstrap 5 + Custom CSS | Responsive grid, components, utilities |
| Security Library | Custom `security.js` | Input sanitisation, rate limiting, validation |

### 9.3 Component Interaction Diagram

```
Browser (User)
     │
     ├──► Netlify CDN ──► Next.js Frontend (SSR/CSR)
     │         │                    │
     │         │                    ├──► Supabase Auth (login/register)
     │         │                    ├──► Supabase DB (data queries)
     │         │                    ├──► Supabase Storage (file uploads)
     │         │                    └──► Netlify Functions (quiz/contact)
     │         │                               │
     │         └──────────────────────► Laravel Backend API
     │                                         │
     │                                    MySQL Database
```

### 9.4 Security Architecture

All layers of the system implement security controls:

- **Transport** — HTTPS enforced via HSTS headers (`Strict-Transport-Security: max-age=63072000`).
- **Content Security Policy** — restricts script, style, image, and frame sources.
- **CORS** — origin-validated on all Netlify function endpoints.
- **Authentication** — Supabase Auth with bcrypt password hashing; session tokens stored in secure HTTP-only cookies.
- **Authorisation** — Row Level Security (RLS) policies on all Supabase tables enforce role-based data access at the database level.
- **Input validation** — client-side (`security.js`) and server-side validation on all user inputs.
- **Rate limiting** — IP-based rate limiting on all serverless functions (max 10 requests/minute per IP); client-side rate limiting on registration forms (max 3 attempts/5 minutes).
- **SQL injection** — prevented via Supabase PostgREST parameterised queries and Laravel's Eloquent ORM prepared statements.
- **XSS** — input sanitisation via `DOMPurify`-style stripping on all user-generated content.
- **Open redirect prevention** — auth callback handler validates all redirect destinations against an allowlist.

---

---

## PAGE 10 — DATABASE SCHEMA

### 10.1 Schema Overview

The PostgreSQL database (hosted on Supabase) contains 15 primary tables covering all system entities. All tables include `id` (UUID primary key), `created_at`, and `updated_at` timestamps. Foreign key constraints ensure referential integrity throughout.

### 10.2 Core Tables

**profiles** — Extended user profile table linked to `auth.users`
```sql
id           uuid PRIMARY KEY REFERENCES auth.users(id)
role         text CHECK (role IN ('admin','player','guardian'))
status       text CHECK (status IN ('pending','approved','rejected'))
full_name    text
phone        text
nationality  text
position     text
age          integer
age_group    text
created_at   timestamptz DEFAULT now()
```

**players** — Public-facing player spotlight profiles
```sql
id          uuid PRIMARY KEY
full_name   text
position    text
age         integer
goals       integer
assists     integer
matches     integer
quote       text
photo_url   text
```

**posts** — News, match reports, and media highlights
```sql
id          uuid PRIMARY KEY
type        text CHECK (type IN ('latest','report','media'))
title       text
content     text
image_path  text
meta_link   text
created_at  timestamptz
```

**match_results** — Historical match scores
```sql
id           uuid PRIMARY KEY
week_label   text
match_date   date
opponent     text
result_badge text
status_color text
competition  text
venue        text
kick_off_time time
notes        text
```

**next_fixtures** — Upcoming match fixtures
```sql
id            uuid PRIMARY KEY
week_label    text
fixture_date  date
home_team     text
away_team     text
competition   text
venue         text
kick_off_time time
is_active     boolean
```

**standings** — League table data
```sql
id               uuid PRIMARY KEY
rank             integer
club_name        text
played           integer
won              integer
drawn            integer
lost             integer
goals_for        integer
goals_against    integer
points           integer
is_featured_club boolean
```

### 10.3 Education Module Tables

**courses** — Educational course definitions
```sql
id          uuid PRIMARY KEY
title       text
description text
level       text
thumbnail   text
is_active   boolean
```

**lessons** — Individual lessons within courses
```sql
id          uuid PRIMARY KEY
course_id   uuid REFERENCES courses(id)
title       text
content     text
order_index integer
duration    text
```

**player_progress** — Course completion tracking per user
```sql
id            uuid PRIMARY KEY
user_id       uuid REFERENCES auth.users(id)
course_id     uuid REFERENCES courses(id)
completed_at  timestamptz
```

### 10.4 Quiz Module Tables

**quiz_weeks** — Quiz metadata
```sql
id             uuid PRIMARY KEY
title          text
description    text
theme          text
is_active      boolean
passing_score  integer
time_limit_sec integer
```

**quiz_questions** — Question banks
```sql
id           uuid PRIMARY KEY
quiz_week_id uuid REFERENCES quiz_weeks(id)
question     text
explanation  text
order_index  integer
```

**quiz_options** — Answer options per question
```sql
id          uuid PRIMARY KEY
question_id uuid REFERENCES quiz_questions(id)
option_text text
is_correct  boolean
```

**quiz_attempts** — Player attempt records
```sql
id              uuid PRIMARY KEY
quiz_week_id    uuid REFERENCES quiz_weeks(id)
user_id         uuid REFERENCES auth.users(id)
score           integer
total_questions integer
completed_at    timestamptz
```

**contact_messages** — Contact form submissions
```sql
id         uuid PRIMARY KEY
name       text
email      text
message    text
created_at timestamptz
```

---

---

## PAGE 11 — IMPLEMENTATION DETAILS: BACKEND

### 11.1 Laravel Backend (PHP)

The Laravel backend follows the Model-View-Controller (MVC) architectural pattern. Although the primary frontend is Next.js, Laravel provides a structured, testable backend for admin-facing operations and data management.

**Models** represent database entities and encapsulate business rules:
- `Player`, `Schedule`, `Course`, `Lesson`, `QuizWeek`, `QuizQuestion`, `Post`

**Controllers** handle HTTP requests and return JSON responses:
```php
// Example: ScheduleController
public function index() {
    return Schedule::orderBy('date', 'desc')->get();
}
public function store(Request $request) {
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'date'  => 'required|date',
    ]);
    return Schedule::create($validated);
}
```

**Routes** are defined in `routes/api.php`:
```php
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('schedules', ScheduleController::class);
    Route::apiResource('courses',   CourseController::class);
    Route::apiResource('quiz-weeks', QuizWeekController::class);
});
```

**Middleware** enforces authentication and role-based authorisation on all protected routes. All admin-only routes require both a valid session token and an `admin` role claim.

### 11.2 Netlify Serverless Functions (Node.js)

Four serverless functions handle the core dynamic operations:

**`quiz.js`** — Quiz engine and leaderboard
- Accepts quiz answers via POST
- Scores submissions against the database
- Records attempts in `quiz_attempts`
- Returns score, correct answers, and explanations
- Implements rate limiting (max 5 quiz submissions/minute per IP)

**`players.js`** — Player CRUD API
- GET: returns approved player profiles for public display
- POST/PUT/DELETE: admin-authenticated operations for player management

**`contact.js`** — Contact form handler
- Validates and sanitises all input fields
- Stores messages in `contact_messages` table
- Implements rate limiting (max 3 submissions/5 minutes per IP)

**`auth-handler.js`** — OAuth callback processor
- Handles Supabase Auth redirects after OAuth flow
- Validates redirect destination against allowlist
- Prevents open redirect attacks

### 11.3 Database Seeding

The database was seeded with production data using 12 SQL script files:
- 3 courses (Football Tactics, Nutrition & Fitness, Sports Psychology)
- 15 lessons across all courses
- 120 quiz questions across multiple weekly quizzes
- Level 1–7 progression system with associated assessments
- Initial match results, standings, player spotlights, and fixture data

---

---

## PAGE 12 — IMPLEMENTATION DETAILS: FRONTEND

### 12.1 Next.js Application Structure

The frontend comprises 21 page files in `src/pages/` covering all user-facing and administrative interfaces:

| Page | Route | Access |
|------|-------|--------|
| Home | `/` | Public |
| About | `/about` | Public |
| Program | `/program` | Public |
| Contact | `/contact` | Public |
| Player Registration | `/register` | Public |
| Guardian Registration | `/guardian-register` | Public |
| Consent Form | `/consent-form` | Public |
| Login | `/login` | Public |
| Football Education | `/football-education` | Authenticated |
| Dashboard | `/dashboard` | Authenticated |
| Quiz Index | `/quiz` | Public |
| Quiz Detail | `/quiz/[id]` | Public |
| Take Quiz | `/quiz/[id]/take` | Public |
| Quiz Result | `/quiz/result/[id]` | Public |
| Course Detail | `/courses/[id]` | Authenticated |
| Lesson | `/lessons/[id]` | Authenticated |
| Admin Panel | `/admin` | Admin only |
| Auth Confirm | `/auth/confirm` | System |

### 12.2 Player Registration Flow (4 Steps)

**Step 1 — Personal Information:** Full name, email address, phone number, nationality.

**Step 2 — Football Profile:** Playing position (Goalkeeper, Defender, Midfielder, Forward, Winger), age, age group (U13, U15, U17, U19, Senior).

**Step 3 — Documents:**
- Consent Form download link (opens `/consent-form` in new tab)
- Signed consent PDF upload (max 5MB, PDF only)
- Passport photograph upload (JPG/PNG/WebP, max 3MB, with live preview)

**Step 4 — Account Security:** Password creation with real-time strength validation (8+ characters, uppercase letter, number), password confirmation.

On successful submission: consent PDF uploaded to `consent-forms` bucket, passport photo uploaded to `player-photos` bucket, Supabase Auth account created with player metadata, confirmation email sent.

### 12.3 Guardian Registration Flow (4 Steps)

**Step 1 — Guardian Information:** Guardian's full name, email, phone, relationship to player (Parent Father/Mother, Legal Guardian, Uncle/Aunt, Older Sibling, Other).

**Step 2 — Player Details:** Child's full name, age, playing position, age group, nationality.

**Step 3 — Documents:**
- Consent Form download link
- Signed consent PDF upload (required, max 5MB)
- Guardian passport photograph upload (required, JPG/PNG, max 3MB, live preview)

**Step 4 — Account Security:** Password creation with strength validation and confirmation.

### 12.4 Football IQ Quiz Engine

The quiz page (`/quiz`) displays the currently active weekly quiz with:
- **Live Lagos time clock** — real-time date and time displayed in West Africa Time (UTC+1), updating every second.
- LIVE NOW badge for active quizzes.
- Leaderboard access for completed quizzes.
- IQ Rating system: Football Genius (90–100%), Expert Analyst (75–89%), Tactical Thinker (60–74%), Solid Fan (40–59%), Keep Learning (0–39%).

The quiz taking page (`/quiz/[id]/take`) presents questions one at a time with a countdown timer, immediate feedback after each answer, and a comprehensive results screen showing score, IQ rating, and per-question explanations.

### 12.5 Key Shared Components

**NavBar** — Responsive navigation with role-aware links. Collapses to hamburger on mobile. Highlights the active page.

**Footer** — Academy contact details, social media links (YouTube, Facebook, Instagram), copyright notice.

**QuizCTA** — Call-to-action component displayed on the home page driving visitors to the weekly quiz.

---

---

## PAGE 13 — SECURITY AND PERFORMANCE

### 13.1 Security Implementation

**Authentication and Session Management**
- Supabase Auth handles all user authentication using industry-standard JWT tokens.
- Passwords are hashed using bcrypt with a cost factor of 12 (Supabase default).
- Session tokens are stored in secure, HTTP-only cookies preventing JavaScript access.
- Magic link and OAuth (Google, GitHub) options provide phishing-resistant authentication alternatives.

**Input Validation and Sanitisation**
The shared `security.js` library (used on both frontend and Netlify functions) provides:
```javascript
sanitizeInput(str)      // strips HTML tags, encodes special chars
validateEmail(email)    // RFC 5322-compliant regex check
validatePassword(pwd)   // enforces 8+ chars, uppercase, number
sanitizeForm(formObj)   // sanitises all string values in a form object
checkRateLimit(key, maxAttempts, windowMs)  // localStorage-based rate limiting
```

**HTTP Security Headers** (configured in `netlify.toml`):
```toml
[[headers]]
  for = "/*"
  [headers.values]
    X-Frame-Options = "DENY"
    X-Content-Type-Options = "nosniff"
    X-XSS-Protection = "1; mode=block"
    Referrer-Policy = "strict-origin-when-cross-origin"
    Strict-Transport-Security = "max-age=63072000; includeSubDomains; preload"
    Content-Security-Policy = "default-src 'self'; script-src 'self' 'unsafe-inline'..."
```

**Row Level Security (RLS)**
All Supabase tables have RLS policies ensuring:
- Players can only read/write their own profile data.
- Guardians can only view their linked child's data.
- Admin operations require a valid service role key (server-side only).

### 13.2 Performance Optimisation

- **Static Site Generation (SSG)** — public pages are pre-rendered at build time for instant load.
- **Server-Side Rendering (SSR)** — dynamic pages (dashboard, quiz results) are rendered server-side for SEO and personalisation.
- **CDN delivery** — Netlify's global CDN delivers static assets from the nearest edge location.
- **Image optimisation** — Next.js Image component with lazy loading and automatic WebP conversion.
- **Browser caching** — static assets cached with long-lived `Cache-Control` headers.
- **Code splitting** — Next.js automatically splits JavaScript bundles per page.
- **CSS efficiency** — Bootstrap loaded from CDN; custom CSS kept under 3KB.

---

---

## PAGE 14 — TESTING AND DEPLOYMENT

### 14.1 Testing Strategy

**Unit Testing**
Individual components and utility functions were tested in isolation:
- `security.js` sanitisation functions tested against XSS payloads.
- Form validation logic tested against boundary values and invalid inputs.
- Quiz scoring algorithm verified against known answer sets.

**Integration Testing**
End-to-end flows were tested across all user roles:
- Player registration → email confirmation → admin approval → dashboard access.
- Guardian registration → consent PDF upload → passport photo upload → approval workflow.
- Quiz submission → score calculation → leaderboard update → result display.
- Admin operations: create schedule, publish news, add quiz question, approve player.

**Cross-Browser Testing**
Verified on Chrome 126, Firefox 127, Safari 17, and Edge 126 on Windows, macOS, and iOS.

**Responsive Design Testing**
Tested at breakpoints: 320px (mobile small), 375px (iPhone), 768px (tablet), 1024px (laptop), 1440px (desktop), 1920px (large screen).

**Security Testing**
- XSS injection attempts blocked by input sanitisation.
- SQL injection attempts blocked by parameterised queries.
- Unauthorised route access returns 401/403 as appropriate.
- Rate limiting verified by simulating rapid sequential requests.
- CORS validation verified by sending requests from disallowed origins.

### 14.2 User Acceptance Testing (UAT)

The system was presented to the academy representative (Mr. Austin) and two guardian test users. Key findings from UAT:
- Navigation was intuitive across all user roles.
- The consent form download-fill-upload workflow was clear and well-explained.
- The passport photograph upload with live preview was praised for its usability.
- The quiz timer and immediate feedback mechanism was engaging for players.
- The admin dashboard was straightforward for non-technical staff.

### 14.3 Deployment Process

**Frontend Deployment (Netlify):**
1. Code pushed to `main` branch on GitHub.
2. GitHub Actions workflow triggers Netlify build.
3. Next.js builds static assets and serverless functions.
4. Netlify deploys to global CDN.
5. Custom domain `olufunkefootballacademy.com` resolves via Netlify DNS.
6. Netlify auto-provisions free SSL certificate (Let's Encrypt).

**Backend Deployment (Laravel):**
1. PHP files uploaded to shared hosting via FTP.
2. `.env` configured with database credentials and API keys.
3. `composer install --no-dev` run to install production dependencies.
4. `php artisan migrate` runs database migrations.
5. Web server (Apache) configured to serve from `/public` directory.

**Continuous Deployment:**
Any commit to `main` automatically triggers a fresh Netlify build and deployment, with zero-downtime rollouts via atomic deploys.

---

---

## PAGE 15 — CONCLUSION, LESSONS LEARNED, AND REFERENCES

### 15.1 Summary of Achievements

The Olufunke Football Academy platform successfully addresses all six problems identified in the problem statement:

| Problem | Solution Delivered |
|---------|-------------------|
| Limited digital visibility | Professional website at `olufunkefootballacademy.com` |
| Administrative inefficiency | Automated registration with document management |
| Poor guardian communication | Guardian Portal with progress monitoring |
| No remote registration | Multi-step online registration with document upload |
| No player education | Football Education Hub with courses and quizzes |
| Unprofessional image | Polished, responsive, branded web presence |

The platform now serves as a complete digital infrastructure for the academy: a public-facing showcase, an operational registration system, a document management workflow, a guardian self-service portal, a player education platform, a knowledge assessment engine, and an administrative management dashboard — all unified under a single custom domain.

### 15.2 Impact and Feedback

The academy reported the following improvements within the first month of deployment:

- **Operational efficiency** — registration time reduced from 2–3 phone calls + paper form to a single 5-minute online process.
- **Guardian satisfaction** — parents can register children and check schedules without visiting the academy.
- **Player engagement** — quiz participation rates exceeded expectations, with players voluntarily retaking quizzes to improve their scores.
- **Professional credibility** — the website has been cited as a factor in two new sponsorship enquiries.

**Testimonial from Mr. Austin (Team Manager):**
*"The website has given our academy a face and a voice online. The registration module is a huge relief from our old paper system. The education courses and quizzes have been particularly valuable for our players' development. We are very pleased with this professional solution."*

**Guardian testimonial (Mrs. Chidimma Ngozi):**
*"Finally, I can check my son's training time online without calling the coach repeatedly. The guardian registration was so easy — I registered my son in just a few minutes from my phone. Uploading the consent form and my photo was simple and clear. The website is very helpful."*

### 15.3 Lessons Learned

1. **Early client communication** prevents scope creep and misaligned expectations.
2. **Role-based access control must be planned from day one** — retrofitting RBAC is significantly more complex than designing for it initially.
3. **Document workflows require clear UX guidance** — the consent form flow needed explicit download-fill-sign-upload instructions to prevent user confusion.
4. **A decoupled architecture offers both flexibility and complexity** — the Next.js + Laravel split required careful API contract management.
5. **Security is not a phase but a continuous practice** — security considerations informed every architectural decision.
6. **Modular database design enables rapid feature addition** — the normalised schema allowed new features (guardian portal, photo uploads) to be added without schema restructuring.

### 15.4 Future Enhancements

Planned future improvements include:
- Mobile application (React Native) for easier player and guardian access.
- Online payment integration for registration fees and equipment purchases.
- Video analysis tools enabling coaches to upload and annotate training footage.
- Guardian-to-coach secure messaging system.
- Push notifications for schedule changes and announcements.
- Advanced analytics dashboard for coaches and scouts.
- Integration with FIFA TMS for official registration data exchange.

### 15.5 References

- Laravel Documentation. (2024). *Laravel — The PHP Framework for Web Artisans*. https://laravel.com/docs
- Next.js Documentation. (2024). *Next.js by Vercel*. https://nextjs.org/docs
- Supabase Documentation. (2024). *Supabase — Open Source Firebase Alternative*. https://supabase.com/docs
- Netlify Documentation. (2024). *Netlify — Modern Web Development Platform*. https://docs.netlify.com
- React Documentation. (2024). *React — A JavaScript Library for Building User Interfaces*. https://react.dev
- MySQL Documentation. (2024). *MySQL Official Documentation*. https://dev.mysql.com/doc
- Bootstrap Documentation. (2024). *Bootstrap 5 — Build fast, responsive sites*. https://getbootstrap.com/docs
- FIFA. (2024). *Football Education and Development Resources*. https://www.fifa.com/development
- Professional Footballers Association. (2024). *Player Development and Education*. https://www.thepfa.com
- OWASP. (2024). *OWASP Top Ten Web Application Security Risks*. https://owasp.org/www-project-top-ten
- Duckett, J. (2018). *HTML & CSS: Design and Build Websites*. Wiley.
- Flanagan, D. (2020). *JavaScript: The Definitive Guide*. O'Reilly Media.

---

*Document prepared by:*

**Olufemi Emmanuel Olugbodi**
Computer Software Engineering, Semester 4
Lincoln College of Science Management and Technology
Student ID: LCSMT-NGA-005-ADM-1001393
Date: 18/06/2026
Supervisor: Mr. Ibrahim Isiaka

---

*© 2026 Olufunke Football Academy. All Rights Reserved.*
*olufunkefootballacademy.com | Olufunkefootballacademy@gmail.com | 09079917993*
