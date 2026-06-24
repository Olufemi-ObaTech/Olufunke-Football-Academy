import Head from 'next/head';
import NavBar from '../components/NavBar';
import Footer from '../components/Footer';
import { useState, useEffect } from 'react';

export default function PSAReport() {
  const [printDate, setPrintDate] = useState('');

  useEffect(() => {
    setPrintDate(new Date().toLocaleDateString('en-GB', {
      timeZone: 'Africa/Lagos', day: '2-digit', month: 'long', year: 'numeric'
    }));
  }, []);

  return (
    <>
      <Head>
        <title>PSA Documentation Report | Olufunke Football Academy</title>
        <style>{`
          @media print {
            .no-print, nav, footer, .top-bar { display: none !important; }
            .psa-page { padding: 0 !important; background: #fff !important; }
            .psa-card { box-shadow: none !important; border: 1px solid #ccc !important; }
            .page-break { page-break-before: always; }
            body { font-size: 11pt; }
            h1 { font-size: 16pt; }
            h2 { font-size: 13pt; }
            h3 { font-size: 11pt; }
          }
          .psa-page { min-height: 100vh; background: #f0f4f8; padding: 24px 16px; font-family: 'Montserrat', Arial, sans-serif; }
          .psa-card { max-width: 900px; margin: 0 auto; background: #fff; border-radius: 16px; box-shadow: 0 8px 32px rgba(0,0,0,.09); overflow: hidden; }
          .psa-cover { background: linear-gradient(135deg, #10316B 0%, #1e4db7 60%, #4CAF50 100%); color: #fff; padding: 48px 40px; text-align: center; }
          .psa-body { padding: 36px 40px; line-height: 1.85; color: #1a1a2e; font-size: .91rem; }
          .psa-body h2 { color: #10316B; font-weight: 800; font-size: 1.15rem; margin: 36px 0 12px; border-left: 4px solid #4CAF50; padding-left: 12px; }
          .psa-body h3 { color: #1e4db7; font-weight: 700; font-size: 1rem; margin: 20px 0 8px; }
          .psa-body h4 { color: #374151; font-weight: 700; font-size: .93rem; margin: 16px 0 6px; }
          .psa-table { width: 100%; border-collapse: collapse; margin: 14px 0; font-size: .85rem; }
          .psa-table th, .psa-table td { border: 1px solid #d1d5db; padding: 8px 12px; text-align: left; }
          .psa-table th { background: #10316B; color: #fff; font-weight: 700; }
          .psa-table tr:nth-child(even) { background: #f8fafc; }
          .psa-table .center { text-align: center; }
          .psa-section-rule { border: none; border-top: 2px solid #e5eaf0; margin: 32px 0; }
          .page-label { background: #10316B; color: #fff; display: inline-block; padding: 2px 10px; border-radius: 4px; font-size: .72rem; font-weight: 700; margin-bottom: 8px; }
          .highlight-box { background: #eff6ff; border-left: 4px solid #1e4db7; border-radius: 0 8px 8px 0; padding: 12px 16px; margin: 12px 0; font-size: .87rem; color: #1d4ed8; }
          .warning-box { background: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 0 8px 8px 0; padding: 12px 16px; margin: 12px 0; font-size: .87rem; color: #92400e; }
          .success-box { background: #f0fdf4; border-left: 4px solid #4CAF50; border-radius: 0 8px 8px 0; padding: 12px 16px; margin: 12px 0; font-size: .87rem; color: #15803d; }
          .code-block { background: #1e293b; color: #e2e8f0; border-radius: 8px; padding: 14px 18px; font-family: 'Courier New', monospace; font-size: .78rem; line-height: 1.6; overflow-x: auto; margin: 10px 0; }
        `}</style>
      </Head>

      <div className="no-print"><NavBar /></div>

      <div className="psa-page">

        {/* Action bar */}
        <div className="no-print" style={{ maxWidth: 900, margin: '0 auto 20px', display: 'flex', flexWrap: 'wrap', gap: 10, justifyContent: 'space-between', alignItems: 'center' }}>
          <span style={{ color: '#10316B', fontWeight: 700, fontSize: '.9rem' }}>
            <i className="bi bi-file-earmark-text-fill me-2 text-primary"></i>PSA Documentation Report — 15 Pages
          </span>
          <div style={{ display: 'flex', gap: 10 }}>
            <button onClick={() => window.print()} style={{ padding: '10px 24px', background: 'linear-gradient(135deg,#10316B,#1e4db7)', color: '#fff', border: 'none', borderRadius: 10, fontWeight: 700, cursor: 'pointer', fontSize: '.88rem', display: 'flex', alignItems: 'center', gap: 8 }}>
              <i className="bi bi-printer-fill"></i> Print / Save as PDF
            </button>
          </div>
        </div>

        <div className="psa-card">

          {/* ── COVER PAGE ── */}
          <div className="psa-cover">
            <div style={{ display: 'inline-block', background: 'rgba(255,255,255,.1)', borderRadius: 16, padding: '10px 24px', marginBottom: 20, fontSize: '.82rem', fontWeight: 700, letterSpacing: 2 }}>
              PROJECT-BASED SKILLS ASSESSMENT (PSA)
            </div>
            <h1 style={{ fontSize: '1.5rem', fontWeight: 800, lineHeight: 1.4, margin: '0 0 16px' }}>
              Olufunke Football Academy<br />Comprehensive Web Platform with<br />Integrated Player Development System
            </h1>
            <div style={{ width: 80, height: 3, background: '#ffc107', margin: '0 auto 24px', borderRadius: 2 }}></div>
            <table style={{ margin: '0 auto', borderCollapse: 'collapse', fontSize: '.88rem', textAlign: 'left' }}>
              <tbody>
                {[
                  ['Institution', 'Lincoln College of Science Management and Technology'],
                  ['Student', 'Olufemi Emmanuel Olugbodi'],
                  ['Department', 'Computer Software Engineering'],
                  ['Semester', 'Semester 4'],
                  ['Student ID', 'LCSMT-NGA-005-ADM-1001393'],
                  ['Submission Date', '18 June 2026'],
                  ['Supervisor', 'Mr. Ibrahim Isiaka'],
                ].map(([k, v]) => (
                  <tr key={k}>
                    <td style={{ padding: '4px 16px 4px 0', opacity: .75, fontWeight: 600 }}>{k}:</td>
                    <td style={{ padding: '4px 0', fontWeight: 700, color: '#fbbf24' }}>{v}</td>
                  </tr>
                ))}
              </tbody>
            </table>
            <div style={{ marginTop: 28, fontSize: '.75rem', opacity: .6 }}>Live site: olufunkefootballacademy.com &nbsp;|&nbsp; Generated: {printDate}</div>
          </div>

          <div className="psa-body">

            {/* ── PAGE 1: ABSTRACT ── */}
            <div className="page-break">
              <span className="page-label">PAGE 1 — ABSTRACT</span>
              <h2>1. Abstract</h2>
              <p>This Project-Based Skills Assessment (PSA) report documents the complete design, development, and deployment of a comprehensive web-based platform for <strong>Olufunke Football Academy (OFA)</strong> — a FIFA TMS-registered, LSFA-affiliated football academy based in Lagos, Nigeria. Founded September 2023 under RC-7147523, the academy required a modern, enterprise-grade digital infrastructure to support its growing operations.</p>
              <p>The project applies full-stack web development techniques to address six critical real-world challenges: digital invisibility, administrative inefficiency, poor guardian communication, absence of a remote registration portal, lack of structured player education, and an unprofessional institutional image.</p>
              <p>The resulting platform features a <strong>Role-Based Access Control (RBAC) system</strong> covering four distinct user roles (Admin, Coach, Player, Guardian), a <strong>Guardian Portal</strong> for remote child enrolment and progress monitoring, a <strong>Football Education Hub</strong> with shared courses and five exclusive Guardian-only courses blocked from players, an interactive <strong>weekly Football IQ Quiz</strong> with live Lagos time display, and a comprehensive <strong>document management workflow</strong> requiring consent forms and passport photographs.</p>
              <p>Technology stack: <strong>Next.js 14 + React 18</strong> (frontend), <strong>Laravel 10/PHP 8.1</strong> (backend API), <strong>Supabase/PostgreSQL</strong> (database, auth, file storage), <strong>Netlify</strong> (hosting, serverless functions), <strong>GitHub Actions</strong> (CI/CD). Deployed at <strong>olufunkefootballacademy.com</strong>.</p>
              <div className="success-box"><strong>Key Achievement:</strong> Full production deployment with zero-downtime continuous deployment, enterprise security controls (AES-256 PII encryption, bcrypt-12 passwords, JWT with HTTP-only cookies, RLS policies, rate limiting), and a live Lagos WAT clock displayed across all platform pages.</div>
            </div>

            <hr className="psa-section-rule" />

            {/* ── PAGE 2: BACKGROUND ── */}
            <span className="page-label">PAGE 2 — BACKGROUND OF THE STUDY</span>
            <h2>2. Background of the Study</h2>
            <h3>2.1 Context and Motivation</h3>
            <p>Digital transformation is no longer optional for organisations seeking credibility, operational efficiency, and sustainable growth. Olufunke Football Academy operated entirely on manual processes prior to this project — paper forms, phone calls, informal notice boards, and word-of-mouth communication. These constraints limited the academy's reach, stunted administrative efficiency, frustrated guardians, and prevented structured player education beyond on-field sessions.</p>
            <h3>2.2 Skills Acquired During PCA Phase</h3>
            <ul>
              <li><strong>Frontend development</strong> — responsive UI with Next.js, React, Bootstrap 5, custom CSS</li>
              <li><strong>Backend development</strong> — RESTful APIs with Laravel MVC and Netlify serverless functions</li>
              <li><strong>Database management</strong> — PostgreSQL schema design, RLS policies, Supabase integration</li>
              <li><strong>Authentication &amp; authorisation</strong> — Supabase Auth, JWT management, role-based guards</li>
              <li><strong>File storage</strong> — Supabase Storage buckets for consent PDFs and passport photographs</li>
              <li><strong>Security engineering</strong> — CSP headers, XSS protection, rate limiting, AES-256 encryption</li>
              <li><strong>DevOps &amp; CI/CD</strong> — GitHub Actions pipeline, Netlify auto-deploy, environment management</li>
            </ul>

            <hr className="psa-section-rule" />

            {/* ── PAGE 3: PROBLEM STATEMENT ── */}
            <div className="page-break">
              <span className="page-label">PAGE 3 — PROBLEM STATEMENT</span>
              <h2>3. Problem Statement</h2>
              <h3>3.1 Identified Problems</h3>
              <table className="psa-table">
                <thead><tr><th>#</th><th>Problem</th><th>Impact</th></tr></thead>
                <tbody>
                  {[
                    ['1', 'Limited Digital Visibility', 'Could not attract players, sponsors, or scouts beyond local area'],
                    ['2', 'Administrative Inefficiency', 'Paper forms + phone calls caused errors, delays, lost records'],
                    ['3', 'Poor Guardian Communication', 'No digital channel for schedule updates or progress reports'],
                    ['4', 'No Remote Registration', 'Guardians had to visit physically to enrol their children'],
                    ['5', 'No Player Education System', 'Zero digital resources for football theory, nutrition, or career guidance'],
                    ['6', 'Unprofessional Image', 'No website hindered sponsorship, affiliation, and recruitment'],
                  ].map(([n,p,i])=>(
                    <tr key={n}><td className="center"><strong>{n}</strong></td><td><strong>{p}</strong></td><td>{i}</td></tr>
                  ))}
                </tbody>
              </table>
              <h3>3.2 Proposed Solution</h3>
              <p>A comprehensive, secure web platform providing: automated online registration with document verification; a dedicated Guardian Portal with remote enrolment and progress monitoring; a Football Education Hub with shared and Guardian-exclusive courses; a weekly interactive Football IQ Quiz; a protected administrative dashboard; and a professional, fully responsive website at <strong>olufunkefootballacademy.com</strong>.</p>
            </div>

            <hr className="psa-section-rule" />

            {/* ── PAGE 4: OBJECTIVES ── */}
            <span className="page-label">PAGE 4 — OBJECTIVES</span>
            <h2>4. Objectives</h2>
            <h3>4.1 General Objective</h3>
            <p>Design, develop, and deploy a secure, scalable, role-based web platform for Olufunke Football Academy that eliminates manual processes, provides a professional online presence, educates players and guardians digitally, and enables remote self-service registration and progress monitoring.</p>
            <h3>4.2 Specific Objectives</h3>
            <ol>
              <li>Create a professional, fully responsive website at <strong>olufunkefootballacademy.com</strong></li>
              <li>Build a secure 4-step player registration with consent PDF + passport photo upload</li>
              <li>Implement a dedicated Coach registration portal</li>
              <li>Develop a full Guardian Portal: registration, dashboard, schedule, finances, consent management</li>
              <li>Build a Football Education Hub with role-gated content (5 Guardian-exclusive courses blocked from players)</li>
              <li>Create an interactive weekly Football IQ Quiz with live Lagos, Nigeria time display</li>
              <li>Enforce strict RBAC with 4 roles: Admin, Coach, Player, Guardian</li>
              <li>Implement enterprise-grade security: bcrypt-12, AES-256 PII, JWT HTTP-only cookies, RLS, rate limiting</li>
              <li>Display live Lagos, Nigeria (WAT) date and time on all platform pages</li>
              <li>Generate comprehensive PSA documentation as a printable 15-page report</li>
            </ol>

            <hr className="psa-section-rule" />

            {/* ── PAGE 5: USER ROLES & PERMISSIONS ── */}
            <div className="page-break">
              <span className="page-label">PAGE 5 — USER ROLES AND PERMISSIONS</span>
              <h2>5. User Roles and Permissions (RBAC)</h2>
              <h3>5.1 Access Control Matrix</h3>
              <table className="psa-table">
                <thead>
                  <tr><th>Feature / Page</th><th className="center">Admin</th><th className="center">Coach</th><th className="center">Player</th><th className="center">Guardian</th></tr>
                </thead>
                <tbody>
                  {[
                    ['Admin Dashboard',                   '✅ Full',     '❌',            '❌',            '❌'],
                    ['Player Dashboard (Performance)',     '✅ Full',     '✅ Full',        '✅ Full',        '❌ Redirect'],
                    ['Football IQ Quiz',                  '✅ Full',     '✅ Full',        '✅ Full',        '✅ Full'],
                    ['Existing Education Hub',            '✅ Full',     '✅ Full',        '✅ Full',        '✅ Read-Only'],
                    ['5 Guardian-Exclusive Courses',      '✅ Full',     '❌ Blocked',     '❌ Strictly Blocked', '✅ Full'],
                    ['Guardian Portal (Dashboard)',        '✅ Full',     '❌',            '❌',            '✅ Full'],
                    ['Guardian Schedule View',            '✅ Full',     '❌',            '❌',            '✅ View-Only'],
                    ['Guardian Consent Manager',          '✅ Full',     '❌',            '❌',            '✅ Full'],
                    ['Guardian Financials',               '✅ Full',     '❌',            '❌',            '✅ Full'],
                    ['Register Players',                  '✅',          '✅',            '✅ (self)',      '✅ (child)'],
                    ['System Settings',                   '✅',          '❌',            '❌',            '❌'],
                  ].map(([f,a,c,p,g])=>(
                    <tr key={f}><td><strong>{f}</strong></td><td className="center">{a}</td><td className="center">{c}</td><td className="center">{p}</td><td className="center">{g}</td></tr>
                  ))}
                </tbody>
              </table>

              <h3>5.2 Role Descriptions</h3>
              <h4>Admin</h4>
              <p>Full system access. Manages all content, users, schedules, courses, quizzes, and system settings. Reviews uploaded documents (consent PDFs, passport photos). Approves/rejects all registrations. Only role with access to audit logs and system configuration.</p>
              <h4>Coach</h4>
              <p>Can post training schedules, publish match reports and news, manage course content and quiz questions. Has full access to Football Education Hub and Player dashboards for performance monitoring. Cannot access Guardian Portal financials or system settings.</p>
              <h4>Player</h4>
              <p>Self-registers via 4-step form (Personal Info → Football Profile → Documents → Account Security). Documents required: signed consent PDF (max 5MB) + passport photograph (JPG/PNG, max 3MB). Can access Education Hub, take quizzes, and view own dashboard. <strong>Strictly blocked from Guardian-exclusive courses.</strong></p>
              <h4>Guardian</h4>
              <p>Registers children via 4-step Guardian Registration (Guardian Info → Player Details → Documents → Account Security). Documents: signed consent PDF + guardian passport photograph. Gets <strong>read-only</strong> access to Player Education Hub with "Parent Viewing Mode" badge. Gets <strong>full access</strong> to 5 exclusive Guardian-only courses. Guardian Portal provides: schedule view, consent management, financials, and communication tools.</p>
            </div>

            <hr className="psa-section-rule" />

            {/* ── PAGE 6: CONSENT & DOCUMENTS ── */}
            <span className="page-label">PAGE 6 — CONSENT FORM AND DOCUMENT REQUIREMENTS</span>
            <h2>6. Consent Form and Document Requirements</h2>
            <h3>6.1 Seven Consent Declarations</h3>
            <table className="psa-table">
              <thead><tr><th>#</th><th>Declaration</th><th>Description</th></tr></thead>
              <tbody>
                {[
                  ['1','Participation Consent','Permission for the child to participate in all academy activities'],
                  ['2','Medical Consent','Authorisation for first-aid and emergency medical care'],
                  ['3','Photography & Media','Permission for photos/videos for promotional use'],
                  ['4','Code of Conduct','Agreement to abide by all academy rules and policies'],
                  ['5','Data Protection','Consent for data collection under applicable privacy laws'],
                  ['6','Liability Acknowledgement','Understanding of inherent physical risks in football'],
                  ['7','Financial Obligations','Agreement to fulfil all fee and equipment requirements'],
                ].map(([n,d,desc])=>(
                  <tr key={n}><td className="center"><strong>{n}</strong></td><td><strong>{d}</strong></td><td>{desc}</td></tr>
                ))}
              </tbody>
            </table>
            <h3>6.2 Document Upload Requirements</h3>
            <table className="psa-table">
              <thead><tr><th>Role</th><th>Document</th><th>Format</th><th>Max Size</th><th>Storage Bucket</th></tr></thead>
              <tbody>
                {[
                  ['Player','Signed Consent Form','PDF','5MB','consent-forms'],
                  ['Player','Passport Photograph','JPG/PNG/WebP','3MB','player-photos'],
                  ['Guardian','Signed Consent Form','PDF','5MB','consent-forms'],
                  ['Guardian','Guardian Passport Photo','JPG/PNG/WebP','3MB','player-photos'],
                ].map(([r,d,f,s,b])=>(
                  <tr key={r+d}><td><strong>{r}</strong></td><td>{d}</td><td>{f}</td><td>{s}</td><td><code>{b}</code></td></tr>
                ))}
              </tbody>
            </table>

            <hr className="psa-section-rule" />

            {/* ── PAGE 7: CLIENT REQUIREMENTS ── */}
            <div className="page-break">
              <span className="page-label">PAGE 7 — CLIENT AND SYSTEM REQUIREMENTS</span>
              <h2>7. Client and System Requirements</h2>
              <h3>7.1 Supported Platforms</h3>
              <table className="psa-table">
                <thead><tr><th>Platform</th><th>Browser</th><th>Min Version</th></tr></thead>
                <tbody>
                  {[
                    ['Desktop (Win/Mac/Linux)','Chrome, Firefox, Safari, Edge','Latest 2 major'],
                    ['Android','Chrome, Samsung Internet','Android 8.0+'],
                    ['iPhone/iPad','Safari, Chrome','iOS 14+'],
                  ].map(([p,b,v])=><tr key={p}><td>{p}</td><td>{b}</td><td>{v}</td></tr>)}
                </tbody>
              </table>
              <h3>7.2 Server Requirements</h3>
              <table className="psa-table">
                <thead><tr><th>Component</th><th>Technology</th><th>Purpose</th></tr></thead>
                <tbody>
                  {[
                    ['Frontend','Next.js 14 (React 18)','SSR/CSR, routing, interactive UI'],
                    ['Backend API','Laravel 10 / PHP 8.1','RESTful APIs, MVC, business logic'],
                    ['Serverless','Netlify Functions (Node.js)','Quiz, guardian API, contact, auth callback'],
                    ['Database','PostgreSQL via Supabase','Relational data, RLS policies'],
                    ['Auth','Supabase Auth','JWT, email/password, magic link, OAuth'],
                    ['File Storage','Supabase Storage','Consent PDFs, passport photos'],
                    ['Hosting','Netlify (CDN)','Frontend deployment, custom domain'],
                    ['CI/CD','GitHub Actions','Auto-build and deploy on push to main'],
                    ['Domain','olufunkefootballacademy.com','Custom domain with HTTPS (HSTS)'],
                  ].map(([c,t,p])=><tr key={c}><td><strong>{c}</strong></td><td>{t}</td><td>{p}</td></tr>)}
                </tbody>
              </table>
              <h3>7.3 Responsive Breakpoints</h3>
              <p>Tested and verified at: 320px (mobile small), 375px (iPhone SE), 768px (tablet), 1024px (laptop), 1440px (desktop), 1920px (large screen). All images use <code>max-width: 100%</code> and <code>object-fit: cover</code>. All card images constrained with <code>.card-img-top</code> styles.</p>
            </div>

            <hr className="psa-section-rule" />

            {/* ── PAGE 8: METHODOLOGY ── */}
            <span className="page-label">PAGE 8 — METHODOLOGY</span>
            <h2>8. Methodology</h2>
            <p>The project followed an <strong>iterative, phased development approach</strong> combining structured planning with continuous client feedback cycles:</p>
            <table className="psa-table">
              <thead><tr><th>Phase</th><th>Activity</th><th>Deliverable</th></tr></thead>
              <tbody>
                {[
                  ['1','Requirements Analysis & Planning','Feature list, project timeline, client sign-off'],
                  ['2','System Architecture Design','Architecture diagram, wireframes, DB schema plan'],
                  ['3','Database Design','15-table PostgreSQL schema with RLS policies'],
                  ['4','Backend Development','Laravel APIs + 4 Netlify serverless functions'],
                  ['5','Frontend Development','21 Next.js pages including Guardian Portal (4 pages)'],
                  ['6','Content Creation','3 courses, 15 player lessons, 5 guardian courses, 20 guardian lessons, 120 quiz questions'],
                  ['7','Integration & Testing','End-to-end testing across all 4 user roles and 3 devices'],
                  ['8','User Acceptance Testing','Client demo, feedback collection, final adjustments'],
                  ['9','Deployment & Training','Netlify production deploy, staff training, user manual'],
                ].map(([p,a,d])=><tr key={p}><td className="center"><strong>{p}</strong></td><td>{a}</td><td>{d}</td></tr>)}
              </tbody>
            </table>

            <hr className="psa-section-rule" />

            {/* ── PAGE 9: SYSTEM DESIGN ── */}
            <div className="page-break">
              <span className="page-label">PAGE 9 — SYSTEM DESIGN AND ARCHITECTURE</span>
              <h2>9. System Design and Architecture</h2>
              <h3>9.1 Architecture Overview</h3>
              <p>The platform follows a modern <strong>decoupled (headless) architecture</strong>:</p>
              <div className="code-block">{`Browser
  ├── Netlify CDN → Next.js Frontend (SSR/CSR)
  │       ├── Supabase Auth  (login, JWT, sessions)
  │       ├── Supabase DB    (real-time queries, RLS)
  │       ├── Supabase Storage (consent PDFs, photos)
  │       └── Netlify Functions
  │               ├── guardian-api.js   (Guardian Portal)
  │               ├── education.js      (Course + role filter)
  │               ├── quiz.js           (Quiz engine)
  │               ├── contact.js        (Contact form)
  │               └── auth-handler.js   (OAuth callback)
  └── Laravel Backend (PHP)
          └── MySQL Database`}
              </div>
              <h3>9.2 Guardian Portal Architecture</h3>
              <p>The Guardian Portal is a dedicated section of the Next.js app at <code>/guardian/*</code>. All routes are protected by a client-side role check that redirects non-guardians immediately. Server-side, the Netlify function <code>guardian-api.js</code> validates the Supabase JWT and verifies <code>role === 'guardian'</code> before serving any data. Guardians cannot reach player performance endpoints; players cannot reach guardian portal endpoints.</p>
              <h3>9.3 Education Hub Access Control</h3>
              <div className="warning-box">
                <strong>Strict Enforcement:</strong> Courses flagged <code>is_guardian_only: true</code> in the database are filtered out for Player and Coach roles at the API level. A player attempting to access <code>/api/education/courses/guardian-lesson/[id]</code> receives HTTP 403 Forbidden. The frontend additionally renders a lock icon and redirect for any guardian-only URL that a player might manually enter.
              </div>
            </div>

            <hr className="psa-section-rule" />

            {/* ── PAGE 10: DATABASE SCHEMA ── */}
            <span className="page-label">PAGE 10 — DATABASE SCHEMA</span>
            <h2>10. Database Schema</h2>
            <h3>10.1 Core Tables</h3>
            <table className="psa-table">
              <thead><tr><th>Table</th><th>Key Fields</th><th>Purpose</th></tr></thead>
              <tbody>
                {[
                  ['profiles','id (UUID), role, status, full_name, phone_encrypted, address_encrypted','Extended user profiles with role and approval status'],
                  ['players','id, full_name, position, age, goals, assists, matches, photo_url','Public player spotlight profiles'],
                  ['guardian_children','id, guardian_id, player_id, linked_at','Links guardians to their children (player accounts)'],
                  ['guardian_invoices','id, guardian_id, player_id, amount, due_date, status, pdf_url','Financial records and invoice management'],
                  ['guardian_tickets','id, guardian_id, type, subject, message, status','Support tickets from guardians to admin'],
                  ['guardian_call_requests','id, guardian_id, status, scheduled_at, notes','Coach call request scheduling'],
                  ['announcements','id, author_role, title, body, target_roles[]','Broadcast messages from admin/coach'],
                  ['courses','id, title, description, level, is_guardian_only, is_active','Educational courses (player + guardian)'],
                  ['lessons','id, course_id, title, content, order_index','Individual lessons within courses'],
                  ['quiz_weeks','id, title, theme, is_active, passing_score','Weekly quiz metadata'],
                  ['quiz_attempts','id, quiz_week_id, user_id, score, total_questions','Player quiz attempt records'],
                  ['audit_logs','id, admin_id, action, target_type, target_id, created_at','Admin action audit trail'],
                ].map(([t,f,p])=><tr key={t}><td><strong><code>{t}</code></strong></td><td style={{fontSize:'.78rem'}}>{f}</td><td>{p}</td></tr>)}
              </tbody>
            </table>

            <hr className="psa-section-rule" />

            {/* ── PAGE 11: GUARDIAN COURSES ── */}
            <div className="page-break">
              <span className="page-label">PAGE 11 — 5 EXCLUSIVE GUARDIAN COURSES</span>
              <h2>11. The 5 Exclusive Guardian Courses (20 Lessons)</h2>
              <div className="highlight-box"><strong>Access Rule:</strong> These courses have <code>is_guardian_only: true</code> in the database. Players and Coaches are blocked at the API level (HTTP 403) and redirected at the frontend level. Admins have full access for management.</div>
              <table className="psa-table">
                <thead><tr><th>#</th><th>Course Title</th><th>Lessons</th><th>Key Topics</th></tr></thead>
                <tbody>
                  {[
                    ['1','Youth Football Development Pathway','4','LTAD models, age-phase milestones, school-training balance, realistic expectations'],
                    ['2','Match-Day & Training Nutrition for Young Athletes','4','Pre-training meals, half-time snacks, post-recovery window, hydration science'],
                    ['3','Mental Resilience & Sideline Etiquette','4','Growth mindset, managing anxiety, silent sideline rules, handling rejection/benching'],
                    ['4','Injury Prevention, Recovery & Safeguarding','4','Warm-up protocols, ACL/ankle awareness, sleep hygiene, recognising burnout and abuse'],
                    ['5','Navigating Trials, Scouts & Football Scholarships','4','How scouts evaluate, highlight reel tips, NCAA/UK pathways, understanding academy contracts'],
                  ].map(([n,t,l,k])=>(
                    <tr key={n}><td className="center"><strong>{n}</strong></td><td><strong>{t}</strong></td><td className="center">{l}</td><td style={{fontSize:'.82rem'}}>{k}</td></tr>
                  ))}
                </tbody>
              </table>
              <p><em>Total: 5 courses × 4 lessons = <strong>20 lessons</strong>. Each lesson includes: learning objectives, key takeaways (3–5 points), and suggested multimedia resources.</em></p>
            </div>

            <hr className="psa-section-rule" />

            {/* ── PAGE 12: IMPLEMENTATION BACKEND ── */}
            <span className="page-label">PAGE 12 — BACKEND IMPLEMENTATION</span>
            <h2>12. Implementation Details: Backend</h2>
            <h3>12.1 Auth Middleware (Role Guards)</h3>
            <div className="code-block">{`// netlify/functions/_shared/auth-middleware.js
async function requireRole(event, supabase, ...allowedRoles) {
  const token = event.headers.authorization?.replace('Bearer ', '');
  if (!token) return { error: 'No token', status: 401 };
  const { data: { user }, error } = await supabase.auth.getUser(token);
  if (error || !user) return { error: 'Invalid token', status: 401 };
  const { data: profile } = await supabase
    .from('profiles').select('role,status').eq('id', user.id).single();
  if (!profile || !allowedRoles.includes(profile.role))
    return { error: 'Forbidden', status: 403 };
  return { user, profile };
}`}
            </div>
            <h3>12.2 Guardian API Endpoints</h3>
            <table className="psa-table">
              <thead><tr><th>Method</th><th>Endpoint</th><th>Auth</th><th>Purpose</th></tr></thead>
              <tbody>
                {[
                  ['POST','/api/auth/guardian/register','Public','Register new guardian account'],
                  ['POST','/api/auth/guardian/login','Public','Guardian login (rate-limited)'],
                  ['GET','/api/guardian/dashboard/:id','Guardian','Dashboard data (schedule, consent, invoices)'],
                  ['POST','/api/guardian/consent/sign','Guardian','E-sign and submit consent form'],
                  ['GET','/api/guardian/schedule/:childId','Guardian','Child schedule + attendance'],
                  ['GET','/api/guardian/invoices','Guardian','Invoice list with PDF links'],
                  ['POST','/api/guardian/tickets','Guardian','Submit support ticket to admin'],
                  ['POST','/api/guardian/call-request','Guardian','Request 15-min coach call'],
                  ['GET','/api/education/courses','Authenticated','Course list (filters guardian-only for players)'],
                  ['GET','/api/education/guardian-lesson/:id','Guardian only','Guardian-exclusive lesson content'],
                ].map(([m,e,a,p])=>(
                  <tr key={e}><td><strong style={{color:m==='GET'?'#15803d':'#1d4ed8'}}>{m}</strong></td><td><code style={{fontSize:'.78rem'}}>{e}</code></td><td>{a}</td><td>{p}</td></tr>
                ))}
              </tbody>
            </table>

            <hr className="psa-section-rule" />

            {/* ── PAGE 13: IMPLEMENTATION FRONTEND ── */}
            <div className="page-break">
              <span className="page-label">PAGE 13 — FRONTEND IMPLEMENTATION</span>
              <h2>13. Implementation Details: Frontend</h2>
              <h3>13.1 Full Page Directory</h3>
              <table className="psa-table">
                <thead><tr><th>Route</th><th>File</th><th>Access</th></tr></thead>
                <tbody>
                  {[
                    ['/','index.js','Public'],
                    ['/about','about.js','Public'],
                    ['/contact','contact.js','Public'],
                    ['/program','program.js','Members'],
                    ['/register','register.js','Public — 4-step (Player/Coach/Guardian selector)'],
                    ['/coach-register','coach-register.js','Public — Coach credentials form'],
                    ['/guardian-register','guardian-register.js','Public — 4-step Guardian form'],
                    ['/consent-form','consent-form.js','Public — Printable PDF form'],
                    ['/psa-report','psa-report.js','Public — This 15-page PSA document'],
                    ['/login','login.js','Public'],
                    ['/dashboard','dashboard.js','Player/Coach/Admin'],
                    ['/football-education','football-education.js','Player/Coach + Guardian read-only'],
                    ['/quiz','/quiz/index.js','Public — Live Lagos time clock'],
                    ['/quiz/[id]/take','/quiz/[id]/take.js','Public'],
                    ['/guardian/dashboard','/guardian/dashboard.js','Guardian + Admin'],
                    ['/guardian/schedule','/guardian/schedule.js','Guardian + Admin'],
                    ['/guardian/finances','/guardian/finances.js','Guardian + Admin'],
                    ['/guardian/learn','/guardian/learn.js','Guardian only — 5 exclusive courses'],
                    ['/admin','/admin/index.js','Admin only'],
                  ].map(([r,f,a])=>(
                    <tr key={r}><td><code style={{fontSize:'.78rem'}}>{r}</code></td><td style={{fontSize:'.78rem'}}>{f}</td><td>{a}</td></tr>
                  ))}
                </tbody>
              </table>

              <h3>13.2 Live Lagos Time Implementation</h3>
              <div className="code-block">{`// In NavBar.js — appears on ALL pages
useEffect(() => {
  const tick = () => {
    const now = new Date();
    setLiveTime(now.toLocaleTimeString('en-GB', {
      timeZone: 'Africa/Lagos', hour: '2-digit',
      minute: '2-digit', second: '2-digit', hour12: true
    }));
    setLiveDate(now.toLocaleDateString('en-GB', {
      timeZone: 'Africa/Lagos', weekday: 'short',
      day: 'numeric', month: 'short', year: 'numeric'
    }));
  };
  tick();
  const timer = setInterval(tick, 1000); // Updates every second
  return () => clearInterval(timer);
}, []);`}
              </div>
              <p>The time bar is rendered in the NavBar component which wraps every page, ensuring the live Lagos WAT clock appears universally. A separate identical clock is rendered in the Football IQ Quiz hero section.</p>
            </div>

            <hr className="psa-section-rule" />

            {/* ── PAGE 14: SECURITY ── */}
            <span className="page-label">PAGE 14 — SECURITY AND TESTING</span>
            <h2>14. Security, Testing and Deployment</h2>
            <h3>14.1 Security Controls</h3>
            <table className="psa-table">
              <thead><tr><th>Control</th><th>Implementation</th><th>Standard</th></tr></thead>
              <tbody>
                {[
                  ['Password hashing','bcrypt with salt factor 12 (Supabase default)','OWASP'],
                  ['JWT management','Short-lived access tokens (15–30 min) + refresh tokens in HTTP-only cookies','RFC 7519'],
                  ['PII encryption','AES-256-CBC for phone, address, birth certificate fields at application level','NIST'],
                  ['Input validation','Sanitisation on all inputs (strip HTML, encode special chars, max-length cap)','OWASP Top 10'],
                  ['SQL injection','Supabase PostgREST parameterised queries + Laravel Eloquent ORM','CWE-89'],
                  ['XSS protection','Input sanitise + CSP headers + X-XSS-Protection header','CWE-79'],
                  ['CORS','Origin whitelist validation on all Netlify functions','OWASP'],
                  ['Rate limiting','5 auth attempts / 15 min per IP; 10 API calls / min per IP','OWASP'],
                  ['RLS policies','Row Level Security on all Supabase tables (role-aware)','PostgreSQL'],
                  ['Audit logging','Admin actions logged with timestamp, action, target ID','SOC 2'],
                  ['HTTPS','HSTS header: max-age=63072000; includeSubDomains; preload','RFC 6797'],
                  ['Env variables','All secrets in .env / Netlify env — never hardcoded','12-Factor App'],
                ].map(([c,i,s])=><tr key={c}><td><strong>{c}</strong></td><td style={{fontSize:'.82rem'}}>{i}</td><td><code>{s}</code></td></tr>)}
              </tbody>
            </table>
            <h3>14.2 Testing Summary</h3>
            <ul>
              <li><strong>Unit testing:</strong> security.js sanitisation, form validation logic, quiz scoring algorithm</li>
              <li><strong>Integration testing:</strong> Full registration flows for all 4 roles, quiz submission, guardian portal modules</li>
              <li><strong>Role guard testing:</strong> Player attempts to access guardian courses → HTTP 403 confirmed; Guardian attempts to access player performance → HTTP 403 confirmed</li>
              <li><strong>Security testing:</strong> XSS payloads blocked, SQL injection blocked, rate limits enforced, CORS disallowed for unlisted origins</li>
              <li><strong>Cross-browser:</strong> Chrome 126, Firefox 127, Safari 17, Edge 126</li>
              <li><strong>Responsive:</strong> Verified at 320px, 375px, 768px, 1024px, 1440px, 1920px</li>
            </ul>

            <hr className="psa-section-rule" />

            {/* ── PAGE 15: CONCLUSION ── */}
            <div className="page-break">
              <span className="page-label">PAGE 15 — CONCLUSION AND REFERENCES</span>
              <h2>15. Conclusion</h2>
              <h3>15.1 Summary of Achievements</h3>
              <table className="psa-table">
                <thead><tr><th>Problem</th><th>Solution Delivered</th><th>Status</th></tr></thead>
                <tbody>
                  {[
                    ['No digital presence','Professional website at olufunkefootballacademy.com','✅ Complete'],
                    ['Manual registration','4-step digital registration with document upload','✅ Complete'],
                    ['No guardian portal','Full Guardian Portal: dashboard, schedule, finances, learn','✅ Complete'],
                    ['No player education','Education Hub + 5 Guardian-exclusive courses (20 lessons)','✅ Complete'],
                    ['No time display','Live Lagos WAT clock on ALL pages via NavBar','✅ Complete'],
                    ['Weak security','bcrypt-12, AES-256, JWT HTTP-only, RLS, rate limiting','✅ Complete'],
                    ['No role control','Strict RBAC: Admin/Coach/Player/Guardian with middleware guards','✅ Complete'],
                  ].map(([p,s,st])=><tr key={p}><td>{p}</td><td>{s}</td><td className="center">{st}</td></tr>)}
                </tbody>
              </table>

              <h3>15.2 Testimonials</h3>
              <div className="success-box">
                <strong>Mr. Austin (Team Manager):</strong> <em>"The website has given our academy a face and a voice online. The registration module is a huge relief from our old paper system. The Guardian Portal is exactly what our parents needed."</em>
              </div>
              <div className="highlight-box">
                <strong>Mrs. Chidimma Ngozi (Guardian):</strong> <em>"I registered my son in minutes from my phone, uploaded the consent form and my photo easily, and now I can check training schedules anytime. The guardian-only courses are very educational for parents like me."</em>
              </div>

              <h3>15.3 Future Enhancements</h3>
              <ul>
                <li>React Native mobile app for players and guardians</li>
                <li>Online payment integration for registration fees</li>
                <li>Video analysis tools with coach annotation</li>
                <li>Guardian-to-coach secure messaging</li>
                <li>Push notifications for schedule changes</li>
                <li>FIFA TMS integration for official registration exchange</li>
                <li>Advanced analytics dashboard for scouts and coaches</li>
              </ul>

              <h3>15.4 References</h3>
              <ul style={{ fontSize: '.87rem', lineHeight: 2 }}>
                <li>Laravel Documentation (2024). <em>Laravel — The PHP Framework for Web Artisans.</em> https://laravel.com/docs</li>
                <li>Next.js Documentation (2024). <em>Next.js by Vercel.</em> https://nextjs.org/docs</li>
                <li>Supabase Documentation (2024). <em>Supabase — Open Source Firebase Alternative.</em> https://supabase.com/docs</li>
                <li>Netlify Documentation (2024). <em>Netlify — Modern Web Development Platform.</em> https://docs.netlify.com</li>
                <li>OWASP Foundation (2024). <em>OWASP Top Ten Web Application Security Risks.</em> https://owasp.org/www-project-top-ten</li>
                <li>FIFA (2024). <em>Football Education and Development Resources.</em> https://www.fifa.com/development</li>
                <li>Bootstrap Documentation (2024). <em>Bootstrap 5.</em> https://getbootstrap.com/docs</li>
                <li>Duckett, J. (2018). <em>HTML & CSS: Design and Build Websites.</em> Wiley.</li>
                <li>Flanagan, D. (2020). <em>JavaScript: The Definitive Guide.</em> O'Reilly Media.</li>
                <li>NIST (2023). <em>Digital Identity Guidelines.</em> SP 800-63B.</li>
              </ul>

              <div style={{ textAlign: 'center', marginTop: 36, padding: '20px', borderTop: '2px solid #e5eaf0' }}>
                <p style={{ fontSize: '.85rem', color: '#374151', margin: 0, lineHeight: 1.8 }}>
                  <strong>Olufemi Emmanuel Olugbodi</strong><br />
                  Computer Software Engineering — Semester 4<br />
                  Lincoln College of Science Management and Technology<br />
                  Student ID: LCSMT-NGA-005-ADM-1001393 | Supervisor: Mr. Ibrahim Isiaka<br />
                  Date: 18 June 2026
                </p>
                <div style={{ marginTop: 16, fontSize: '.75rem', color: '#94a3b8' }}>
                  © 2026 Olufunke Football Academy — olufunkefootballacademy.com | 09079917993<br />
                  Nathaniel Idowu Football Field, Oregie, Ajegunle, Lagos State, Nigeria
                </div>
              </div>
            </div>

          </div>{/* end psa-body */}
        </div>{/* end psa-card */}
      </div>{/* end psa-page */}

      <div className="no-print"><Footer /></div>
    </>
  );
}
