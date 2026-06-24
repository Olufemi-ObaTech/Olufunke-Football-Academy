{{-- Standalone printable consent form --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Guardian Consent Form | Olufunke Football Academy</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Montserrat',Arial,sans-serif;background:#e8edf2;color:#1e293b;font-size:13px;line-height:1.6;}
#action-bar{position:sticky;top:0;z-index:200;background:linear-gradient(90deg,#10316B,#1a4a9e);padding:11px 24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;box-shadow:0 2px 12px rgba(0,0,0,.3);}
.btn-dl{background:#fbbf24;color:#1e293b;border:none;padding:9px 22px;border-radius:8px;font-weight:800;font-size:.88rem;cursor:pointer;}
.btn-back{background:transparent;color:rgba(255,255,255,.8);border:1px solid rgba(255,255,255,.35);padding:8px 18px;border-radius:8px;font-size:.82rem;cursor:pointer;text-decoration:none;}
.bar-title{color:#fff;font-weight:700;font-size:.95rem;display:flex;align-items:center;gap:8px;}

.doc-wrap{max-width:860px;margin:0 auto;padding:24px 16px 56px;}
.cf-page{background:#fff;border-radius:12px;box-shadow:0 4px 24px rgba(16,49,107,.09);padding:44px 52px;margin-bottom:24px;position:relative;}
.cf-page::before{content:'';position:absolute;top:0;left:0;right:0;height:4px;background:linear-gradient(90deg,#10316B,#4CAF50);}

/* Header */
.cf-header{display:flex;align-items:center;justify-content:space-between;border-bottom:3px solid #10316B;padding-bottom:16px;margin-bottom:20px;gap:16px;}
.cf-header-logo{display:flex;align-items:center;gap:14px;}
.cf-header-logo img{width:72px;height:72px;border-radius:50%;border:3px solid #fbbf24;object-fit:cover;}
.cf-header-text h1{font-size:1.15rem;font-weight:800;color:#10316B;margin-bottom:2px;}
.cf-header-text p{font-size:.75rem;color:#475569;margin:0;}
.cf-header-stamp{text-align:right;}
.cf-header-stamp .doc-no{font-size:.7rem;font-weight:700;color:#94a3b8;letter-spacing:.08em;text-transform:uppercase;}

/* Photo box */
.photo-box{width:110px;height:130px;border:2px dashed #94a3b8;border-radius:8px;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#94a3b8;font-size:.65rem;text-align:center;padding:6px;flex-shrink:0;}

/* Section titles */
.sec-title{font-size:.78rem;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:#fff;background:#10316B;padding:6px 14px;border-radius:4px;margin:18px 0 12px;}

/* Form fields */
.field-row{display:flex;gap:12px;margin-bottom:10px;flex-wrap:wrap;}
.field-item{flex:1;min-width:180px;}
.field-item label{display:block;font-size:.67rem;font-weight:800;text-transform:uppercase;letter-spacing:.06em;color:#64748b;margin-bottom:3px;}
.field-item .fl{border:none;border-bottom:1.5px solid #cbd5e1;padding:4px 2px;width:100%;font-size:.82rem;font-family:inherit;background:transparent;outline:none;}
.field-item .fl:focus{border-bottom-color:#10316B;}

/* Declarations */
.decl-item{display:flex;align-items:flex-start;gap:12px;padding:10px 14px;border-radius:8px;margin-bottom:8px;border:1px solid #e5eaf0;}
.decl-item:nth-child(odd){background:#f8fafc;}
.decl-cb{width:18px;height:18px;border:2px solid #10316B;border-radius:3px;flex-shrink:0;margin-top:2px;}
.decl-num{font-size:.7rem;font-weight:800;background:#10316B;color:#fff;width:20px;height:20px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.decl-text{flex:1;}
.decl-text strong{display:block;font-size:.8rem;margin-bottom:2px;}
.decl-text span{font-size:.76rem;color:#475569;}

/* Signature row */
.sig-row{display:flex;gap:24px;margin-top:16px;flex-wrap:wrap;}
.sig-cell{flex:1;min-width:200px;}
.sig-cell label{font-size:.67rem;font-weight:800;text-transform:uppercase;letter-spacing:.06em;color:#64748b;display:block;margin-bottom:6px;}
.sig-line{border-bottom:1.5px solid #1e293b;height:36px;}

.notice-box{background:#fefce8;border:1px solid #fbbf24;border-radius:8px;padding:12px 16px;font-size:.78rem;margin-bottom:14px;}
.notice-box strong{color:#92400e;}

.footer-strip{background:#10316B;color:#fff;text-align:center;padding:10px;border-radius:0 0 8px 8px;font-size:.7rem;opacity:.7;letter-spacing:.05em;}

@@media print{
  body{background:#fff!important;}
  #action-bar{display:none!important;}
  .doc-wrap{max-width:100%;padding:0;margin:0;}
  .cf-page{box-shadow:none!important;border-radius:0!important;margin:0!important;padding:28px 36px!important;page-break-after:always;break-after:page;}
  .cf-page::before{display:none;}
  .cf-header,.sec-title{-webkit-print-color-adjust:exact;print-color-adjust:exact;}
  .decl-item{-webkit-print-color-adjust:exact;print-color-adjust:exact;}
  @@page{margin:1.4cm 1.8cm;size:A4;}
}
</style>
</head>
<body>

<div id="action-bar">
  <div class="bar-title">
    <i class="bi bi-file-earmark-check-fill" style="color:#fbbf24;font-size:1.2rem;"></i>
    Guardian Consent Form &mdash; Olufunke Football Academy
  </div>
  <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
    <a href="{{ url('/guardian-register') }}" class="btn-back"><i class="bi bi-person-heart"></i> Back to Registration</a>
    <a href="{{ url('/register') }}" class="btn-back"><i class="bi bi-house-fill"></i> Register</a>
    <button class="btn-dl" onclick="window.print()">
      <i class="bi bi-printer-fill"></i> Print / Save as PDF
    </button>
  </div>
</div>

<div class="doc-wrap">

{{-- ===== PAGE 1 ===== --}}
<div class="cf-page">

  {{-- Header --}}
  <div class="cf-header">
    <div class="cf-header-logo">
      <img src="{{ asset('images/OFA New Logo.jpg') }}" alt="OFA Logo" onerror="this.style.display='none'">
      <div class="cf-header-text">
        <h1>OLUFUNKE FOOTBALL ACADEMY</h1>
        <p>Guardian &amp; Player Participation Consent Form</p>
        <p>Lagos State, Nigeria &nbsp;&middot;&nbsp; olufunkefootballacademy.com</p>
      </div>
    </div>
    <div class="cf-header-stamp">
      <div class="doc-no">Form Ref: OFA-CONSENT-2026</div>
      <div class="doc-no" style="margin-top:4px;">Version: 2.0</div>
    </div>
  </div>

  <div class="notice-box">
    <strong><i class="bi bi-info-circle-fill me-2"></i>Instructions:</strong>
    Please print this form, complete all sections in <strong>BLOCK CAPITALS</strong>, sign and date it, then scan or photograph it as a PDF and upload it during your Guardian Registration at <strong>olufunkefootballacademy.com/guardian-register</strong>. All fields marked <strong>*</strong> are mandatory.
  </div>

  {{-- SECTION A: GUARDIAN INFO --}}
  <div class="sec-title"><i class="bi bi-person-fill me-2"></i>Section A &mdash; Guardian / Parent Information</div>

  <div style="display:flex;gap:20px;align-items:flex-start;">
    <div style="flex:1;">
      <div class="field-row">
        <div class="field-item" style="flex:2;min-width:240px;">
          <label>Full Name *</label>
          <div class="fl">&nbsp;</div>
        </div>
        <div class="field-item">
          <label>Title (Mr/Mrs/Ms/Dr)</label>
          <div class="fl">&nbsp;</div>
        </div>
      </div>
      <div class="field-row">
        <div class="field-item" style="flex:2;">
          <label>Email Address *</label>
          <div class="fl">&nbsp;</div>
        </div>
        <div class="field-item">
          <label>Phone Number *</label>
          <div class="fl">&nbsp;</div>
        </div>
      </div>
      <div class="field-row">
        <div class="field-item">
          <label>Nationality *</label>
          <div class="fl">&nbsp;</div>
        </div>
        <div class="field-item">
          <label>State of Origin</label>
          <div class="fl">&nbsp;</div>
        </div>
        <div class="field-item">
          <label>Relationship to Child *</label>
          <div class="fl">&nbsp;</div>
        </div>
      </div>
      <div class="field-row">
        <div class="field-item" style="flex:2;">
          <label>Home / Residential Address *</label>
          <div class="fl">&nbsp;</div>
        </div>
        <div class="field-item">
          <label>Alternate Phone</label>
          <div class="fl">&nbsp;</div>
        </div>
      </div>
    </div>
    <div>
      <div class="photo-box">
        <i class="bi bi-person-bounding-box" style="font-size:2rem;margin-bottom:6px;"></i>
        <div>Guardian<br>Passport<br>Photo<br>(Paste here)</div>
      </div>
    </div>
  </div>

  {{-- SECTION B: PLAYER INFO --}}
  <div class="sec-title"><i class="bi bi-person-badge-fill me-2"></i>Section B &mdash; Player (Child) Information</div>

  <div style="display:flex;gap:20px;align-items:flex-start;">
    <div style="flex:1;">
      <div class="field-row">
        <div class="field-item" style="flex:2;">
          <label>Player's Full Name *</label>
          <div class="fl">&nbsp;</div>
        </div>
        <div class="field-item">
          <label>Date of Birth *</label>
          <div class="fl">&nbsp;</div>
        </div>
        <div class="field-item">
          <label>Age *</label>
          <div class="fl">&nbsp;</div>
        </div>
      </div>
      <div class="field-row">
        <div class="field-item">
          <label>Nationality</label>
          <div class="fl">&nbsp;</div>
        </div>
        <div class="field-item">
          <label>Gender</label>
          <div class="fl">&nbsp;</div>
        </div>
        <div class="field-item">
          <label>Preferred Position</label>
          <div class="fl">&nbsp;</div>
        </div>
      </div>
      <div class="field-row">
        <div class="field-item">
          <label>School / Education Level</label>
          <div class="fl">&nbsp;</div>
        </div>
        <div class="field-item" style="flex:2;">
          <label>Known Medical Conditions / Allergies</label>
          <div class="fl">&nbsp;</div>
        </div>
      </div>
      <div class="field-row">
        <div class="field-item">
          <label>Blood Group</label>
          <div class="fl">&nbsp;</div>
        </div>
        <div class="field-item">
          <label>GP / Doctor Name</label>
          <div class="fl">&nbsp;</div>
        </div>
        <div class="field-item">
          <label>Doctor Phone</label>
          <div class="fl">&nbsp;</div>
        </div>
      </div>
    </div>
    <div>
      <div class="photo-box">
        <i class="bi bi-person-bounding-box" style="font-size:2rem;margin-bottom:6px;"></i>
        <div>Player<br>Passport<br>Photo<br>(Paste here)</div>
      </div>
    </div>
  </div>

</div>

{{-- ===== PAGE 2 — DECLARATIONS ===== --}}
<div class="cf-page">

  <div class="cf-header" style="margin-bottom:16px;">
    <div class="cf-header-text">
      <h1 style="font-size:1rem;">OLUFUNKE FOOTBALL ACADEMY &mdash; Guardian Consent Form (Page 2)</h1>
      <p>Guardian Name: _____________________________________ &nbsp;&nbsp; Date: _______________</p>
    </div>
  </div>

  {{-- SECTION C: CONSENT DECLARATIONS --}}
  <div class="sec-title"><i class="bi bi-shield-fill-check me-2"></i>Section C &mdash; Consent Declarations</div>
  <p style="font-size:.78rem;color:#475569;margin-bottom:12px;">
    I, the undersigned guardian/parent, hereby confirm the following declarations. Please check each box to indicate your agreement and understanding.
  </p>

  <div class="decl-item">
    <div class="decl-cb"></div>
    <div class="decl-num">1</div>
    <div class="decl-text">
      <strong>Participation Consent</strong>
      <span>I give full permission for my child named above to participate in all Olufunke Football Academy training sessions, matches, competitions, tours, and related activities. I understand this includes travel within and outside Lagos State.</span>
    </div>
  </div>

  <div class="decl-item">
    <div class="decl-cb"></div>
    <div class="decl-num">2</div>
    <div class="decl-text">
      <strong>Medical Consent &amp; Emergency Treatment</strong>
      <span>I authorise the academy coaching staff and designated first aiders to administer first aid and seek emergency medical treatment on behalf of my child if I cannot be reached in time. I confirm the medical information provided above is accurate to the best of my knowledge.</span>
    </div>
  </div>

  <div class="decl-item">
    <div class="decl-cb"></div>
    <div class="decl-num">3</div>
    <div class="decl-text">
      <strong>Photography &amp; Media Rights</strong>
      <span>I give consent for photographs, videos, and media content featuring my child to be used by Olufunke Football Academy for promotional purposes including the official website (olufunkefootballacademy.com), social media channels (Facebook, Instagram, YouTube), and printed materials. Content will not be sold to third parties.</span>
    </div>
  </div>

  <div class="decl-item">
    <div class="decl-cb"></div>
    <div class="decl-num">4</div>
    <div class="decl-text">
      <strong>Code of Conduct</strong>
      <span>I agree that my child will abide by the Olufunke Football Academy Code of Conduct at all times. I also commit to supporting the academy's values — respect, discipline, teamwork, and fair play — and to maintaining positive and respectful behaviour on sidelines during matches and training.</span>
    </div>
  </div>

  <div class="decl-item">
    <div class="decl-cb"></div>
    <div class="decl-num">5</div>
    <div class="decl-text">
      <strong>Data Protection &amp; Privacy</strong>
      <span>I consent to the collection, storage, and processing of my child's personal data (name, date of birth, contact details, medical information, performance records, photos) by Olufunke Football Academy for academy management purposes, in accordance with Nigeria's National Data Protection Bureau (NDPB) guidelines. Data will not be shared with third parties without consent.</span>
    </div>
  </div>

  <div class="decl-item">
    <div class="decl-cb"></div>
    <div class="decl-num">6</div>
    <div class="decl-text">
      <strong>Liability Acknowledgement</strong>
      <span>I acknowledge that participation in football carries inherent physical risks including injury. I confirm that my child is physically fit to participate and that the academy will take reasonable precautions for their safety. I agree not to hold Olufunke Football Academy, its coaches, or staff liable for any accidental injury arising from normal participation, provided reasonable care was taken.</span>
    </div>
  </div>

  <div class="decl-item">
    <div class="decl-cb"></div>
    <div class="decl-num">7</div>
    <div class="decl-text">
      <strong>Financial Obligations</strong>
      <span>I understand and agree to fulfil the academy's fee payment requirements for my child's registration, training, kit, and any additional programmes enrolled in. I acknowledge that fees are non-refundable once a training season has commenced, except in exceptional circumstances approved by the Academy Director.</span>
    </div>
  </div>

  {{-- SECTION D: EMERGENCY CONTACT --}}
  <div class="sec-title" style="margin-top:18px;"><i class="bi bi-telephone-fill me-2"></i>Section D &mdash; Emergency Contact (Other than Guardian above)</div>
  <div class="field-row">
    <div class="field-item" style="flex:2;">
      <label>Full Name *</label>
      <div class="fl">&nbsp;</div>
    </div>
    <div class="field-item">
      <label>Relationship</label>
      <div class="fl">&nbsp;</div>
    </div>
    <div class="field-item">
      <label>Phone Number *</label>
      <div class="fl">&nbsp;</div>
    </div>
  </div>

  {{-- SECTION E: SIGNATURE --}}
  <div class="sec-title" style="margin-top:18px;"><i class="bi bi-pen-fill me-2"></i>Section E &mdash; Guardian Signature &amp; Declaration</div>
  <p style="font-size:.78rem;color:#475569;margin-bottom:14px;">
    By signing below, I confirm that I am the legal parent or guardian of the named player, that all information provided is true and accurate, and that I have read, understood, and agree to all seven declarations in Section C above.
  </p>

  <div class="sig-row">
    <div class="sig-cell">
      <label>Guardian Signature *</label>
      <div class="sig-line"></div>
    </div>
    <div class="sig-cell">
      <label>Print Name *</label>
      <div class="sig-line"></div>
    </div>
    <div class="sig-cell" style="max-width:160px;">
      <label>Date *</label>
      <div class="sig-line"></div>
    </div>
  </div>

  <div style="margin-top:18px;padding:12px 16px;border:2px solid #10316B;border-radius:8px;display:flex;gap:20px;flex-wrap:wrap;align-items:flex-start;">
    <div style="flex:1;">
      <div style="font-size:.7rem;font-weight:800;color:#10316B;letter-spacing:.06em;text-transform:uppercase;margin-bottom:8px;">For Academy Use Only</div>
      <div class="field-row" style="margin-bottom:6px;">
        <div class="field-item">
          <label>Received by</label>
          <div class="fl">&nbsp;</div>
        </div>
        <div class="field-item">
          <label>Date Received</label>
          <div class="fl">&nbsp;</div>
        </div>
      </div>
      <div class="field-row">
        <div class="field-item">
          <label>Registration Approved?&nbsp; YES / NO</label>
          <div class="fl">&nbsp;</div>
        </div>
        <div class="field-item">
          <label>Academy Ref No</label>
          <div class="fl">&nbsp;</div>
        </div>
      </div>
    </div>
    <div>
      <div style="font-size:.7rem;font-weight:800;color:#10316B;letter-spacing:.06em;text-transform:uppercase;margin-bottom:8px;">Academy Officer Signature</div>
      <div class="sig-line" style="width:180px;border-bottom:1.5px solid #1e293b;height:40px;"></div>
    </div>
  </div>

  <div class="footer-strip" style="margin-top:20px;">
    OLUFUNKE FOOTBALL ACADEMY &nbsp;&middot;&nbsp; Lagos, Nigeria &nbsp;&middot;&nbsp; olufunkefootballacademy.com &nbsp;&middot;&nbsp; Form OFA-CONSENT-2026 v2.0
  </div>

</div>

</div>{{-- .doc-wrap --}}
</body>
</html>
