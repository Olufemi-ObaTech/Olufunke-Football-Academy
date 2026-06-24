@extends('layouts.main')
@section('title', 'Admin Dashboard')
@section('content')
<style>
/* ─── Reset & Shell ─────────────────────────────────────────────────────── */
*{box-sizing:border-box;}
.dash-wrap{display:flex;min-height:calc(100vh - 72px);background:#0d1117;}

/* ─── Sidebar ───────────────────────────────────────────────────────────── */
.dsb{width:256px;min-width:256px;background:linear-gradient(180deg,#0f1f3d 0%,#0a1628 100%);
  display:flex;flex-direction:column;position:sticky;top:0;
  height:calc(100vh - 72px);overflow-y:auto;overflow-x:hidden;
  box-shadow:4px 0 32px rgba(0,0,0,.5);transition:width .25s ease;scrollbar-width:thin;
  scrollbar-color:rgba(255,255,255,.1) transparent;}
.dsb::-webkit-scrollbar{width:4px;}
.dsb::-webkit-scrollbar-thumb{background:rgba(255,255,255,.1);border-radius:4px;}
.dsb-brand{padding:20px 18px 16px;border-bottom:1px solid rgba(255,255,255,.06);
  display:flex;align-items:center;gap:12px;}
.dsb-brand img{width:40px;height:40px;border-radius:10px;border:2px solid #fbbf24;object-fit:cover;}
.dsb-brand .bn{font-size:.72rem;font-weight:800;color:#fbbf24;letter-spacing:.08em;text-transform:uppercase;line-height:1.2;}
.dsb-brand .bs{font-size:.65rem;color:rgba(255,255,255,.35);margin-top:2px;}
.dsb-sec{padding:16px 16px 4px;font-size:.6rem;font-weight:800;color:rgba(255,255,255,.25);
  letter-spacing:.12em;text-transform:uppercase;}
.dsb-lnk{display:flex;align-items:center;gap:10px;padding:9px 18px;
  color:rgba(255,255,255,.55);text-decoration:none;font-size:.82rem;font-weight:500;
  border-left:3px solid transparent;transition:all .15s;white-space:nowrap;}
.dsb-lnk:hover,.dsb-lnk.on{background:rgba(255,255,255,.06);color:#fff;border-left-color:#fbbf24;}
.dsb-lnk .si{width:30px;height:30px;border-radius:8px;display:flex;align-items:center;
  justify-content:center;font-size:.9rem;flex-shrink:0;}
.dsb-lnk .sb{margin-left:auto;font-size:.62rem;padding:2px 7px;border-radius:20px;font-weight:700;}
.dsb-foot{margin-top:auto;padding:14px 12px;border-top:1px solid rgba(255,255,255,.06);}

/* ─── Main area ─────────────────────────────────────────────────────────── */
.dmain{flex:1;background:#f0f4f8;overflow-x:hidden;min-width:0;}
.dtop{background:#fff;padding:13px 24px;display:flex;align-items:center;
  justify-content:space-between;border-bottom:1px solid #e5eaf0;
  position:sticky;top:0;z-index:99;box-shadow:0 1px 6px rgba(0,0,0,.05);}
.dtop .pt{font-size:1.05rem;font-weight:800;color:#0d1117;}
.dtop .pm{font-size:.72rem;color:#64748b;margin-top:1px;}
.dbody{padding:22px 24px;}

/* ─── Glassmorphism stat cards ──────────────────────────────────────────── */
.gcard{border-radius:18px;padding:20px 18px;display:flex;align-items:center;gap:14px;
  position:relative;overflow:hidden;border:1px solid rgba(255,255,255,.18);
  backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);
  box-shadow:0 8px 32px rgba(0,0,0,.12),inset 0 1px 0 rgba(255,255,255,.2);
  transition:transform .18s,box-shadow .18s;}
.gcard:hover{transform:translateY(-4px);box-shadow:0 16px 40px rgba(0,0,0,.18);}
.gcard::before{content:'';position:absolute;top:-30px;right:-30px;width:100px;height:100px;
  border-radius:50%;background:rgba(255,255,255,.07);}
.gcard::after{content:'';position:absolute;bottom:-20px;left:-20px;width:70px;height:70px;
  border-radius:50%;background:rgba(255,255,255,.05);}
.gcard .gi{width:50px;height:50px;border-radius:14px;display:flex;align-items:center;
  justify-content:center;font-size:1.4rem;flex-shrink:0;background:rgba(255,255,255,.18);
  backdrop-filter:blur(8px);position:relative;z-index:1;}
.gcard .gv{font-size:2.2rem;font-weight:900;line-height:1;position:relative;z-index:1;}
.gcard .gl{font-size:.72rem;font-weight:600;opacity:.8;margin-top:3px;position:relative;z-index:1;}

/* ─── Quick-nav tiles ───────────────────────────────────────────────────── */
.qnt{display:flex;align-items:center;gap:12px;padding:14px 16px;border-radius:14px;
  border:1.5px solid #e5eaf0;background:#fff;text-decoration:none;
  transition:all .18s;box-shadow:0 2px 8px rgba(0,0,0,.04);}
.qnt:hover{border-color:#10316B;box-shadow:0 6px 20px rgba(16,49,107,.13);transform:translateY(-2px);}
.qnt .qi{width:42px;height:42px;border-radius:12px;display:flex;align-items:center;
  justify-content:center;font-size:1.15rem;flex-shrink:0;}
.qnt .qt{font-size:.84rem;font-weight:700;color:#0d1117;}
.qnt .qs{font-size:.7rem;color:#64748b;margin-top:1px;}

/* ─── Panels ────────────────────────────────────────────────────────────── */
.pnl{background:#fff;border-radius:16px;box-shadow:0 2px 16px rgba(0,0,0,.06);
  overflow:hidden;margin-bottom:22px;border:1px solid #f0f4f8;}
.pnl-h{padding:13px 18px;display:flex;align-items:center;justify-content:space-between;
  border-bottom:1px solid #f0f4f8;}
.pnl-h .ph{font-size:.88rem;font-weight:700;color:#0d1117;display:flex;align-items:center;gap:8px;}
.pnl-h .phi{width:28px;height:28px;border-radius:8px;display:flex;align-items:center;
  justify-content:center;font-size:.85rem;}

/* ─── Table ─────────────────────────────────────────────────────────────── */
.mtbl thead th{background:#f8fafc;font-size:.7rem;font-weight:800;text-transform:uppercase;
  letter-spacing:.06em;color:#64748b;border-bottom:2px solid #e5eaf0;padding:10px 12px;}
.mtbl tbody tr{transition:background .1s;}
.mtbl tbody tr:hover{background:#f8fafc;}
.mtbl td{vertical-align:middle;font-size:.83rem;border-color:#f0f4f8;padding:10px 12px;}

/* ─── Avatars ───────────────────────────────────────────────────────────── */
.av{width:34px;height:34px;border-radius:50%;object-fit:cover;border:2px solid #e5eaf0;}
.avi{width:34px;height:34px;border-radius:50%;display:flex;align-items:center;
  justify-content:center;font-size:.72rem;font-weight:800;color:#fff;flex-shrink:0;}

/* ─── Pills ─────────────────────────────────────────────────────────────── */
.pl{display:inline-flex;align-items:center;gap:3px;padding:3px 9px;border-radius:20px;
  font-size:.7rem;font-weight:700;}
.pl-g{background:#dcfce7;color:#15803d;}
.pl-y{background:#fef9c3;color:#a16207;}
.pl-r{background:#fee2e2;color:#b91c1c;}
.pl-b{background:#dbeafe;color:#1d4ed8;}
.pl-s{background:#f1f5f9;color:#475569;}

/* ─── Action buttons ────────────────────────────────────────────────────── */
.abtn{display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;
  border-radius:8px;border:none;cursor:pointer;font-size:.82rem;transition:all .15s;}
.abtn:hover{filter:brightness(.9);}

/* ─── Message rows ──────────────────────────────────────────────────────── */
.mrow{cursor:pointer;transition:background .1s;border-bottom:1px solid #f0f4f8;}
.mrow:hover{background:#f8fafc;}
.mrow.unread{background:#fffbeb;}

/* ─── Responsive ────────────────────────────────────────────────────────── */
@media(max-width:991px){
  .dsb{width:0;min-width:0;overflow:hidden;position:fixed;z-index:300;height:100vh;top:0;}
  .dsb.open{width:256px;min-width:256px;}
  .dsb-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:299;}
  .dsb-overlay.show{display:block;}
  .dmain{width:100%;}
  .dbody{padding:14px 16px;}
  .dtop{padding:11px 16px;}
}
@media(min-width:992px){.dsb-overlay{display:none!important;}}
</style>

<div class="dash-wrap">
<div class="dsb-overlay" id="sideOverlay" onclick="closeSidebar()"></div>

{{-- ══════════════ SIDEBAR ══════════════ --}}
<aside class="dsb" id="dashSidebar">
  <div class="dsb-brand">
    <img src="{{ asset('images/OFA New Logo.jpg') }}" alt="OFA">
    <div><div class="bn">OFA Admin</div><div class="bs">Management Panel</div></div>
  </div>

  <div class="dsb-sec">Overview</div>
  <a href="{{ route('admin.dashboard') }}" class="dsb-lnk on">
    <span class="si" style="background:rgba(99,102,241,.2);color:#a5b4fc;"><i class="bi bi-speedometer2"></i></span>Dashboard
  </a>

  <div class="dsb-sec">Players &amp; Guardians</div>
  <a href="#players" class="dsb-lnk" onclick="closeSidebar()">
    <span class="si" style="background:rgba(16,185,129,.2);color:#6ee7b7;"><i class="bi bi-people-fill"></i></span>
    Registered Players
    @if($counts['pending']>0)<span class="sb bg-warning text-dark">{{ $counts['pending'] }}</span>@endif
  </a>
  <a href="#guardians" class="dsb-lnk" onclick="closeSidebar()">
    <span class="si" style="background:rgba(26,92,42,.3);color:#86efac;"><i class="bi bi-person-heart-fill"></i></span>
    Guardians
    @if($counts['guardians_pending']>0)<span class="sb bg-warning text-dark">{{ $counts['guardians_pending'] }}</span>@endif
  </a>
  <a href="{{ route('admin.spotlight.index') }}" class="dsb-lnk">
    <span class="si" style="background:rgba(251,191,36,.2);color:#fde68a;"><i class="bi bi-person-badge-fill"></i></span>Player Spotlight
  </a>
  <a href="{{ route('admin.schedules.index') }}" class="dsb-lnk">
    <span class="si" style="background:rgba(59,130,246,.2);color:#93c5fd;"><i class="bi bi-calendar-check-fill"></i></span>Training Schedules
  </a>

  <div class="dsb-sec">Content</div>
  <a href="{{ route('admin.league.index') }}" class="dsb-lnk">
    <span class="si" style="background:rgba(251,191,36,.2);color:#fde68a;"><i class="bi bi-trophy-fill"></i></span>League Manager
  </a>
  <a href="{{ route('admin.news.index') }}" class="dsb-lnk">
    <span class="si" style="background:rgba(239,68,68,.2);color:#fca5a5;"><i class="bi bi-newspaper"></i></span>News &amp; Posts
  </a>
  <a href="{{ route('admin.about.index') }}" class="dsb-lnk">
    <span class="si" style="background:rgba(168,85,247,.2);color:#d8b4fe;"><i class="bi bi-info-circle-fill"></i></span>About Page
  </a>
  <a href="{{ route('admin.quiz.index') }}" class="dsb-lnk">
    <span class="si" style="background:rgba(20,184,166,.2);color:#5eead4;"><i class="bi bi-patch-question-fill"></i></span>Quiz Manager
  </a>

  <div class="dsb-sec">Communication</div>
  <a href="{{ route('admin.messages.index') }}" class="dsb-lnk">
    <span class="si" style="background:rgba(249,115,22,.2);color:#fdba74;"><i class="bi bi-chat-dots-fill"></i></span>
    Messages
    @if($counts['messages']>0)<span class="sb bg-danger text-white">{{ $counts['messages'] }}</span>@endif
  </a>

  <div class="dsb-foot">
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="dsb-lnk w-100 border-0 bg-transparent text-start" style="color:rgba(255,255,255,.4);">
        <span class="si" style="background:rgba(239,68,68,.15);color:#f87171;"><i class="bi bi-box-arrow-right"></i></span>Log Out
      </button>
    </form>
  </div>
</aside>

{{-- ══════════════ MAIN ══════════════ --}}
<div class="dmain">

  {{-- Topbar --}}
  <div class="dtop">
    <div class="d-flex align-items-center gap-3">
      <button class="btn btn-sm d-lg-none" style="background:#f0f4f8;border:none;border-radius:8px;width:36px;height:36px;"
              onclick="openSidebar()"><i class="bi bi-list fs-5"></i></button>
      <div>
        <div class="pt">Admin Dashboard</div>
        <div class="pm">{{ now()->format('l, d F Y') }}</div>
      </div>
    </div>
    <div class="d-flex align-items-center gap-3">
      @if(session('success'))
        <span class="pl pl-g px-3 py-2"><i class="bi bi-check-circle-fill me-1"></i>{{ Str::limit(session('success'),40) }}</span>
      @endif
      <div class="d-flex align-items-center gap-2">
        <div class="avi" style="background:linear-gradient(135deg,#10316B,#4CAF50);width:36px;height:36px;font-size:.8rem;">
          {{ strtoupper(substr(auth()->user()->name,0,1)) }}
        </div>
        <div class="d-none d-md-block">
          <div style="font-size:.8rem;font-weight:700;color:#0d1117;">{{ auth()->user()->name }}</div>
          <div style="font-size:.68rem;color:#64748b;">Administrator</div>
        </div>
      </div>
    </div>
  </div>

  <div class="dbody">

  {{-- ── Glassmorphism Stat Cards ─────────────────────────────────────────── --}}
  <div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
      <div class="gcard" style="background:linear-gradient(135deg,rgba(16,49,107,.9),rgba(30,77,183,.85));color:#fff;">
        <div class="gi"><i class="bi bi-people-fill"></i></div>
        <div><div class="gv">{{ $counts['total'] }}</div><div class="gl">Total Players</div></div>
      </div>
    </div>
    <div class="col-6 col-xl-3">
      <div class="gcard" style="background:linear-gradient(135deg,rgba(5,150,105,.9),rgba(16,185,129,.85));color:#fff;">
        <div class="gi"><i class="bi bi-check-circle-fill"></i></div>
        <div><div class="gv">{{ $counts['approved'] }}</div><div class="gl">Approved</div></div>
      </div>
    </div>
    <div class="col-6 col-xl-3">
      <div class="gcard" style="background:linear-gradient(135deg,rgba(217,119,6,.9),rgba(245,158,11,.85));color:#fff;">
        <div class="gi"><i class="bi bi-hourglass-split"></i></div>
        <div><div class="gv">{{ $counts['pending'] }}</div><div class="gl">Pending Approval</div></div>
      </div>
    </div>
    <div class="col-6 col-xl-3">
      <div class="gcard" style="background:linear-gradient(135deg,rgba(220,38,38,.9),rgba(239,68,68,.85));color:#fff;">
        <div class="gi"><i class="bi bi-envelope-fill"></i></div>
        <div><div class="gv">{{ $counts['messages'] }}</div><div class="gl">Unread Messages</div></div>
      </div>
    </div>
  </div>

  {{-- ── Quick Nav ────────────────────────────────────────────────────────── --}}
  <p style="font-size:.68rem;font-weight:800;letter-spacing:.1em;color:#94a3b8;text-transform:uppercase;margin-bottom:10px;">Content Management</p>
  <div class="row g-3 mb-4">
    <div class="col-6 col-sm-4 col-md-3 col-xl-auto" style="min-width:140px;">
      <a href="{{ route('admin.league.index') }}" class="qnt">
        <div class="qi" style="background:#fef3c7;"><i class="bi bi-trophy-fill" style="color:#d97706;"></i></div>
        <div><div class="qt">League</div><div class="qs">Results &amp; fixtures</div></div>
      </a>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-xl-auto" style="min-width:140px;">
      <a href="{{ route('admin.spotlight.index') }}" class="qnt">
        <div class="qi" style="background:#fef3c7;"><i class="bi bi-person-badge-fill" style="color:#d97706;"></i></div>
        <div><div class="qt">Spotlight</div><div class="qs">Player profiles</div></div>
      </a>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-xl-auto" style="min-width:140px;">
      <a href="{{ route('admin.news.index') }}" class="qnt">
        <div class="qi" style="background:#fee2e2;"><i class="bi bi-newspaper" style="color:#dc2626;"></i></div>
        <div><div class="qt">News</div><div class="qs">Posts &amp; reports</div></div>
      </a>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-xl-auto" style="min-width:140px;">
      <a href="{{ route('admin.about.index') }}" class="qnt">
        <div class="qi" style="background:#f3e8ff;"><i class="bi bi-info-circle-fill" style="color:#9333ea;"></i></div>
        <div><div class="qt">About</div><div class="qs">Mgmt team</div></div>
      </a>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-xl-auto" style="min-width:140px;">
      <a href="{{ route('admin.schedules.index') }}" class="qnt">
        <div class="qi" style="background:#dbeafe;"><i class="bi bi-calendar-check-fill" style="color:#2563eb;"></i></div>
        <div><div class="qt">Schedules</div><div class="qs">Training sessions</div></div>
      </a>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-xl-auto" style="min-width:140px;">
      <a href="{{ route('admin.quiz.index') }}" class="qnt">
        <div class="qi" style="background:#ccfbf1;"><i class="bi bi-patch-question-fill" style="color:#0d9488;"></i></div>
        <div><div class="qt">Quizzes</div><div class="qs">IQ manager</div></div>
      </a>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-xl-auto" style="min-width:140px;">
      <a href="{{ route('admin.messages.index') }}" class="qnt">
        <div class="qi" style="background:#ffedd5;"><i class="bi bi-chat-dots-fill" style="color:#ea580c;"></i></div>
        <div>
          <div class="qt">Messages</div>
          <div class="qs">@if($counts['messages']>0)<span style="color:#dc2626;font-weight:700;">{{ $counts['messages'] }} unread</span>@else Player inbox @endif</div>
        </div>
      </a>
    </div>
  </div>

  {{-- ── Broadcast + Contact Messages ────────────────────────────────────── --}}
  <div class="row g-4 mb-2">
    <div class="col-lg-4">
      <div class="pnl h-100">
        <div class="pnl-h">
          <div class="ph"><div class="phi" style="background:#fef3c7;"><i class="bi bi-megaphone-fill" style="color:#d97706;"></i></div>Broadcast</div>
          <a href="{{ route('admin.messages.index') }}" class="btn btn-sm fw-bold px-3"
             style="background:#10316B;color:#fff;border-radius:8px;font-size:.72rem;">
            <i class="bi bi-inbox-fill me-1"></i>Inbox
          </a>
        </div>
        <div class="p-4">
          <form action="{{ route('admin.messages.broadcast') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Target Group</label>
              <select name="age_group" class="form-select form-select-sm">
                <option value="All">All Approved Players</option>
                <option value="U13">U13</option><option value="U15">U15</option>
                <option value="U17">U17</option><option value="U19">U19</option>
                <option value="Senior">Senior</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Subject</label>
              <input type="text" name="subject" class="form-control form-control-sm" placeholder="e.g. Training Update">
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold" style="font-size:.78rem;">Message <span class="text-danger">*</span></label>
              <textarea name="body" class="form-control form-control-sm" rows="4" required placeholder="Type your message..."></textarea>
            </div>
            <button type="submit" class="btn btn-sm fw-bold w-100"
                    style="background:linear-gradient(135deg,#10316B,#1e4db7);color:#fff;border-radius:10px;padding:9px;">
              <i class="bi bi-send-fill me-1"></i>Send Broadcast
            </button>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-8">
      <div class="pnl h-100">
        <div class="pnl-h">
          <div class="ph"><div class="phi" style="background:#dcfce7;"><i class="bi bi-envelope-fill" style="color:#16a34a;"></i></div>Recent Contact Messages</div>
          <div class="d-flex align-items-center gap-2">
            @if($counts['messages']>0)<span class="pl pl-r">{{ $counts['messages'] }} new</span>@endif
            <a href="{{ route('admin.messages.index') }}" class="btn btn-sm fw-bold px-3"
               style="background:#f0f4f8;color:#0d1117;border-radius:8px;font-size:.72rem;">
              <i class="bi bi-chat-dots-fill me-1"></i>Player Messages
            </a>
          </div>
        </div>
        <div style="max-height:370px;overflow-y:auto;">
          @forelse($messages as $msg)
          <div class="mrow {{ !$msg->read ? 'unread' : '' }}" onclick="toggleCMsg(this,{{ $msg->id }})">
            <div class="d-flex align-items-start gap-3 p-3">
              <div class="avi flex-shrink-0" style="background:linear-gradient(135deg,#10316B,#4CAF50);">
                {{ strtoupper(substr($msg->name,0,1)) }}
              </div>
              <div class="flex-grow-1 min-w-0">
                <div class="d-flex justify-content-between align-items-start gap-2">
                  <div class="fw-semibold" style="font-size:.83rem;color:#0d1117;">
                    {{ $msg->name }}
                    @if(!$msg->read)<span class="pl pl-r ms-1">New</span>@endif
                  </div>
                  <small class="text-muted flex-shrink-0" style="font-size:.7rem;">{{ $msg->created_at->format('d M, g:i A') }}</small>
                </div>
                <div class="cmsg-prev text-muted" style="font-size:.76rem;margin-top:2px;">
                  <strong>{{ $msg->subject ?? 'No subject' }}</strong> — {{ Str::limit($msg->message,75) }}
                </div>
              </div>
              <i class="bi bi-chevron-down text-muted cmsg-chev flex-shrink-0" style="font-size:.75rem;"></i>
            </div>
            <div class="cmsg-full d-none px-3 pb-3">
              <div class="p-3 rounded-3 border-start border-4 border-success" style="background:#f8fafc;">
                <div class="row g-2 mb-3">
                  <div class="col-sm-6"><small class="text-muted d-block" style="font-size:.68rem;font-weight:800;letter-spacing:.06em;">FROM</small><span style="font-size:.83rem;">{{ $msg->name }}</span></div>
                  <div class="col-sm-6"><small class="text-muted d-block" style="font-size:.68rem;font-weight:800;letter-spacing:.06em;">EMAIL</small><a href="mailto:{{ $msg->email }}" style="font-size:.83rem;">{{ $msg->email }}</a></div>
                  @if($msg->phone)<div class="col-sm-6"><small class="text-muted d-block" style="font-size:.68rem;font-weight:800;">PHONE</small><a href="tel:{{ $msg->phone }}" style="font-size:.83rem;">{{ $msg->phone }}</a></div>@endif
                  <div class="col-sm-6"><small class="text-muted d-block" style="font-size:.68rem;font-weight:800;">SUBJECT</small><span style="font-size:.83rem;">{{ $msg->subject ?? '—' }}</span></div>
                </div>
                <p style="font-size:.83rem;line-height:1.8;white-space:pre-wrap;margin-bottom:12px;">{{ $msg->message }}</p>
                <div class="d-flex gap-2">
                  <a href="mailto:{{ $msg->email }}?subject=Re: {{ urlencode($msg->subject ?? 'Your enquiry') }}" class="btn btn-sm btn-success fw-bold"><i class="bi bi-reply-fill me-1"></i>Reply</a>
                  @if($msg->phone)<a href="tel:{{ $msg->phone }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-telephone-fill me-1"></i>Call</a>@endif
                </div>
              </div>
            </div>
          </div>
          @empty
          <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
            <p class="mb-0" style="font-size:.83rem;">No contact messages yet.</p>
          </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  {{-- ── Registered Players Table ─────────────────────────────────────────── --}}
  <div class="pnl" id="players">
    <div class="pnl-h">
      <div class="ph"><div class="phi" style="background:#dbeafe;"><i class="bi bi-people-fill" style="color:#2563eb;"></i></div>Registered Players</div>
      <span class="pl pl-y">{{ $counts['total'] }} total</span>
    </div>
    <div class="table-responsive">
      <table class="table mtbl mb-0">
        <thead><tr>
          <th class="ps-4" style="width:40px;">#</th>
          <th>Player</th>
          <th class="d-none d-md-table-cell">Position</th>
          <th class="d-none d-md-table-cell">Age / Group</th>
          <th class="d-none d-lg-table-cell">Joined</th>
          <th>Status</th>
          <th class="text-center pe-4">Actions</th>
        </tr></thead>
        <tbody>
          @forelse($players as $i => $player)
          <tr>
            <td class="ps-4 text-muted" style="font-size:.75rem;">{{ $i+1 }}</td>
            <td>
              <div class="d-flex align-items-center gap-2">
                @if($player->profile_photo)
                  <img src="{{ asset('storage/'.$player->profile_photo) }}" alt="{{ $player->name }}" class="av"
                       onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                  <div class="avi" style="background:linear-gradient(135deg,#10316B,#4CAF50);display:none;">{{ strtoupper(substr($player->name,0,1)) }}</div>
                @else
                  <div class="avi" style="background:linear-gradient(135deg,#10316B,#4CAF50);">{{ strtoupper(substr($player->name,0,1)) }}</div>
                @endif
                <div>
                  <div class="fw-semibold" style="font-size:.83rem;color:#0d1117;">{{ $player->name }}</div>
                  <div class="text-muted" style="font-size:.7rem;">{{ $player->email }}</div>
                </div>
              </div>
            </td>
            <td class="d-none d-md-table-cell">
              @if($player->position)<span class="pl pl-s">{{ $player->position }}</span>
              @else<span class="text-muted">—</span>@endif
            </td>
            <td class="d-none d-md-table-cell">
              <span class="fw-semibold" style="font-size:.83rem;">{{ $player->age ?? '—' }}</span>
              @if($player->age_group)<span class="pl pl-b ms-1">{{ $player->age_group }}</span>@endif
            </td>
            <td class="d-none d-lg-table-cell text-muted" style="font-size:.75rem;">{{ $player->created_at->format('d M Y') }}</td>
            <td>
              @if($player->status==='approved')<span class="pl pl-g"><i class="bi bi-check-circle-fill"></i> Approved</span>
              @elseif($player->status==='pending')<span class="pl pl-y"><i class="bi bi-hourglass-split"></i> Pending</span>
              @else<span class="pl pl-r"><i class="bi bi-x-circle-fill"></i> Rejected</span>@endif
            </td>
            <td class="text-center pe-4">
              <div class="d-flex gap-1 justify-content-center flex-wrap">
                <button class="abtn" title="View Profile" style="background:#f0f4f8;color:#0d1117;"
                        onclick="loadProfile({{ $player->id }},'{{ addslashes($player->name) }}')">
                  <i class="bi bi-eye-fill"></i></button>
                @if($player->status!=='approved')
                <form action="{{ route('admin.players.approve',$player) }}" method="POST" class="d-inline">@csrf
                  <button type="submit" class="abtn" title="Approve" style="background:#dcfce7;color:#15803d;"><i class="bi bi-check-lg"></i></button>
                </form>@endif
                @if($player->status!=='rejected')
                <form action="{{ route('admin.players.reject',$player) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Reject {{ addslashes($player->name) }}?')">@csrf
                  <button type="submit" class="abtn" title="Reject" style="background:#fee2e2;color:#b91c1c;"><i class="bi bi-x-lg"></i></button>
                </form>@endif
                <button class="abtn" title="Message" style="background:#dbeafe;color:#1d4ed8;"
                        onclick="openMsg({{ $player->id }},'{{ addslashes($player->name) }}')">
                  <i class="bi bi-chat-dots-fill"></i></button>
                <button class="abtn" title="Rate" style="background:#fef3c7;color:#a16207;"
                        onclick="openRate({{ $player->id }},'{{ addslashes($player->name) }}')">
                  <i class="bi bi-star-fill"></i></button>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="7" class="text-center text-muted py-5">
            <i class="bi bi-people fs-1 d-block mb-2 opacity-25"></i>No players registered yet.
          </td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- ── Registered Guardians Table ──────────────────────────────────────────── --}}
  <div class="pnl" id="guardians" style="margin-top:22px;">
    <div class="pnl-h">
      <div class="ph">
        <div class="phi" style="background:#dcfce7;"><i class="bi bi-person-heart-fill" style="color:#16a34a;"></i></div>
        Registered Guardians
        @if($counts['guardians_pending']>0)
          <span class="pl pl-y ms-2">{{ $counts['guardians_pending'] }} pending</span>
        @endif
      </div>
      <span class="pl pl-s">{{ $counts['guardians_total'] }} total</span>
    </div>
    <div class="table-responsive">
      <table class="table mtbl mb-0">
        <thead><tr>
          <th class="ps-4" style="width:40px;">#</th>
          <th>Guardian</th>
          <th class="d-none d-md-table-cell">Phone</th>
          <th class="d-none d-md-table-cell">Relationship / Child</th>
          <th class="d-none d-lg-table-cell">Registered</th>
          <th>Status</th>
          <th class="text-center pe-4">Actions</th>
        </tr></thead>
        <tbody>
          @forelse($guardians as $i => $guardian)
          <tr>
            <td class="ps-4 text-muted" style="font-size:.75rem;">{{ $i+1 }}</td>
            <td>
              <div class="d-flex align-items-center gap-2">
                @if($guardian->profile_photo)
                  <img src="{{ asset('storage/'.$guardian->profile_photo) }}" alt="{{ $guardian->name }}" class="av"
                       onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                  <div class="avi" style="background:linear-gradient(135deg,#1a5c2a,#4CAF50);display:none;">{{ strtoupper(substr($guardian->name,0,1)) }}</div>
                @else
                  <div class="avi" style="background:linear-gradient(135deg,#1a5c2a,#4CAF50);">{{ strtoupper(substr($guardian->name,0,1)) }}</div>
                @endif
                <div>
                  <div class="fw-semibold" style="font-size:.83rem;color:#0d1117;">{{ $guardian->name }}</div>
                  <div class="text-muted" style="font-size:.7rem;">{{ $guardian->email }}</div>
                </div>
              </div>
            </td>
            <td class="d-none d-md-table-cell">
              @if($guardian->phone)<span style="font-size:.82rem;">{{ $guardian->phone }}</span>
              @else<span class="text-muted">—</span>@endif
            </td>
            <td class="d-none d-md-table-cell">
              @if($guardian->position)
                <span class="pl pl-s" style="font-size:.72rem;">{{ $guardian->position }}</span>
              @else
                <span class="text-muted">—</span>
              @endif
            </td>
            <td class="d-none d-lg-table-cell text-muted" style="font-size:.75rem;">{{ $guardian->created_at->format('d M Y') }}</td>
            <td>
              @if($guardian->status==='approved')<span class="pl pl-g"><i class="bi bi-check-circle-fill"></i> Approved</span>
              @elseif($guardian->status==='pending')<span class="pl pl-y"><i class="bi bi-hourglass-split"></i> Pending</span>
              @else<span class="pl pl-r"><i class="bi bi-x-circle-fill"></i> Rejected</span>@endif
            </td>
            <td class="text-center pe-4">
              <div class="d-flex gap-1 justify-content-center flex-wrap">
                @if($guardian->status!=='approved')
                <form action="{{ route('admin.guardians.approve',$guardian) }}" method="POST" class="d-inline">@csrf
                  <button type="submit" class="abtn" title="Approve Guardian" style="background:#dcfce7;color:#15803d;">
                    <i class="bi bi-check-lg"></i>
                  </button>
                </form>
                @endif
                @if($guardian->status!=='rejected')
                <form action="{{ route('admin.guardians.reject',$guardian) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Reject guardian {{ addslashes($guardian->name) }}?')">@csrf
                  <button type="submit" class="abtn" title="Reject Guardian" style="background:#fee2e2;color:#b91c1c;">
                    <i class="bi bi-x-lg"></i>
                  </button>
                </form>
                @endif
                <a href="mailto:{{ $guardian->email }}" class="abtn" title="Email Guardian" style="background:#dbeafe;color:#1d4ed8;">
                  <i class="bi bi-envelope-fill"></i>
                </a>
                @if($guardian->phone)
                <a href="tel:{{ $guardian->phone }}" class="abtn" title="Call Guardian" style="background:#dcfce7;color:#15803d;">
                  <i class="bi bi-telephone-fill"></i>
                </a>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="7" class="text-center text-muted py-5">
            <i class="bi bi-person-heart fs-1 d-block mb-2 opacity-25"></i>No guardians registered yet.
          </td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  </div>{{-- /dbody --}}
</div>{{-- /dmain --}}
</div>{{-- /dash-wrap --}}

{{-- ══════════════ MODALS ══════════════ --}}
<div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg" style="border-radius:18px;overflow:hidden;">
      <div class="modal-header border-0 text-white" style="background:linear-gradient(135deg,#10316B,#1e4db7);">
        <h5 class="modal-title fw-bold"><i class="bi bi-person-badge-fill me-2"></i><span id="profileName">Player</span></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-0" id="profileBody">
        <div class="text-center py-5"><div class="spinner-border text-primary"></div><p class="mt-2 text-muted small">Loading...</p></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="msgModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius:18px;overflow:hidden;">
      <div class="modal-header border-0 text-white" style="background:linear-gradient(135deg,#10316B,#1e4db7);">
        <h5 class="modal-title fw-bold"><i class="bi bi-chat-dots-fill me-2"></i>Message — <span id="msgName"></span></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.messages.store') }}" method="POST">
        @csrf<input type="hidden" name="to_user_id" id="msgId">
        <div class="modal-body p-4">
          <div class="mb-3"><label class="form-label fw-semibold" style="font-size:.83rem;">Subject</label>
            <input type="text" name="subject" class="form-control" placeholder="e.g. Training Update"></div>
          <div class="mb-3"><label class="form-label fw-semibold" style="font-size:.83rem;">Message <span class="text-danger">*</span></label>
            <textarea name="body" class="form-control" rows="5" required placeholder="Type your message..."></textarea></div>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn fw-bold px-4" style="background:linear-gradient(135deg,#10316B,#1e4db7);color:#fff;border-radius:10px;">
            <i class="bi bi-send-fill me-1"></i>Send</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="rateModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg" style="border-radius:18px;overflow:hidden;">
      <div class="modal-header border-0 text-white" style="background:linear-gradient(135deg,#10316B,#1e4db7);">
        <h5 class="modal-title fw-bold"><i class="bi bi-star-fill me-2 text-warning"></i>Rate — <span id="rateName"></span></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.ratings.store') }}" method="POST">
        @csrf<input type="hidden" name="player_id" id="rateId">
        <div class="modal-body p-4">
          <div class="mb-3"><label class="form-label fw-semibold" style="font-size:.83rem;">Session Date <span class="text-danger">*</span></label>
            <input type="date" name="rated_for_date" class="form-control" value="{{ date('Y-m-d') }}" required></div>
          <div class="row g-3 mb-3">
            @foreach(['technical'=>'Technical','tactical'=>'Tactical','physical'=>'Physical','mental'=>'Mental','teamwork'=>'Teamwork','attitude'=>'Attitude'] as $field=>$label)
            <div class="col-6 col-md-4">
              <label class="form-label fw-semibold" style="font-size:.78rem;">{{ $label }} <span class="text-muted">(1–10)</span></label>
              <div class="d-flex align-items-center gap-2">
                <input type="range" name="{{ $field }}" class="form-range flex-grow-1" min="1" max="10" value="7"
                       oninput="document.getElementById('v_{{ $field }}').textContent=this.value">
                <span class="pl pl-b" id="v_{{ $field }}">7</span>
              </div>
            </div>
            @endforeach
          </div>
          <div><label class="form-label fw-semibold" style="font-size:.83rem;">Coach Comments</label>
            <textarea name="comments" class="form-control" rows="3" placeholder="Observations, strengths, areas to improve..."></textarea></div>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning fw-bold px-4" style="border-radius:10px;">
            <i class="bi bi-star-fill me-1"></i>Save Rating</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
@push('scripts')
<script>
function openSidebar(){document.getElementById('dashSidebar').classList.add('open');document.getElementById('sideOverlay').classList.add('show');}
function closeSidebar(){document.getElementById('dashSidebar').classList.remove('open');document.getElementById('sideOverlay').classList.remove('show');}

function toggleCMsg(el,id){
  const full=el.querySelector('.cmsg-full'),prev=el.querySelector('.cmsg-prev'),chev=el.querySelector('.cmsg-chev');
  if(full.classList.contains('d-none')){
    full.classList.remove('d-none');prev.classList.add('d-none');
    chev.classList.replace('bi-chevron-down','bi-chevron-up');
    el.classList.remove('unread');
    el.querySelector('.pl-r')?.remove();
    fetch('/admin/contact-messages/'+id+'/read',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'}});
  }else{full.classList.add('d-none');prev.classList.remove('d-none');chev.classList.replace('bi-chevron-up','bi-chevron-down');}
}
function openMsg(id,name){document.getElementById('msgId').value=id;document.getElementById('msgName').textContent=name;new bootstrap.Modal(document.getElementById('msgModal')).show();}
function openRate(id,name){document.getElementById('rateId').value=id;document.getElementById('rateName').textContent=name;new bootstrap.Modal(document.getElementById('rateModal')).show();}
function loadProfile(id,name){
  document.getElementById('profileName').textContent=name;
  document.getElementById('profileBody').innerHTML='<div class="text-center py-5"><div class="spinner-border text-primary"></div><p class="mt-2 text-muted small">Loading...</p></div>';
  new bootstrap.Modal(document.getElementById('profileModal')).show();
  fetch('/admin/players/'+id+'/profile',{headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'}})
    .then(r=>r.json()).then(renderProfile)
    .catch(()=>{document.getElementById('profileBody').innerHTML='<div class="text-center py-5 text-danger"><i class="bi bi-exclamation-triangle fs-1"></i><p>Failed to load.</p></div>';});
}
function renderProfile(d){
  const p=d.player,sc=p.status==='approved'?'pl-g':(p.status==='pending'?'pl-y':'pl-r');
  let rH='<p class="text-muted small">No ratings yet.</p>';
  if(d.ratings&&d.ratings.length){const r=d.ratings[0],ov=((r.technical+r.tactical+r.physical+r.mental+r.teamwork+r.attitude)/6).toFixed(1);
    rH=`<div class="p-3 rounded-3 mb-2" style="background:#f8fafc;"><div class="d-flex justify-content-between mb-3"><span class="fw-bold" style="font-size:.83rem;">Latest Rating</span><span class="pl pl-y">${ov}/10 Overall</span></div><div class="row g-2">${['technical','tactical','physical','mental','teamwork','attitude'].map(f=>`<div class="col-6 col-md-4"><div class="d-flex justify-content-between mb-1" style="font-size:.72rem;"><span class="text-muted text-capitalize">${f}</span><strong>${r[f]}/10</strong></div><div class="progress" style="height:4px;border-radius:4px;"><div class="progress-bar bg-primary" style="width:${r[f]*10}%"></div></div></div>`).join('')}</div>${r.comments?`<p class="small text-muted mt-2 mb-0"><i class="bi bi-chat-quote me-1"></i>${r.comments}</p>`:''}</div>`;}
  let sH='<p class="text-muted small">No sessions.</p>';
  if(d.schedules&&d.schedules.length)sH=d.schedules.map(s=>`<div class="d-flex align-items-center gap-2 py-2 border-bottom"><span class="pl pl-b" style="font-size:.68rem;">${s.type}</span><div><div class="fw-semibold" style="font-size:.8rem;">${s.title}</div><div class="text-muted" style="font-size:.7rem;">${s.session_date} · ${s.location}</div></div></div>`).join('');
  let mH='<p class="text-muted small">No messages.</p>';
  if(d.messages&&d.messages.length)mH=d.messages.map(m=>`<div class="p-2 rounded-3 mb-2 ${m.is_read?'':'border border-warning'}" style="background:#f8fafc;"><div class="d-flex justify-content-between"><span class="fw-semibold" style="font-size:.78rem;">${m.subject||'No subject'}</span><span class="text-muted" style="font-size:.68rem;">${m.created_at?m.created_at.substring(0,10):''}</span></div><p class="mb-0 text-muted" style="font-size:.76rem;">${m.body.substring(0,100)}${m.body.length>100?'...':''}</p></div>`).join('');
  document.getElementById('profileBody').innerHTML=`<div class="p-4"><div class="row g-4"><div class="col-md-4"><div class="text-center mb-3">${p.profile_photo?`<img src="{{ asset('storage') }}/${p.profile_photo}" class="rounded-circle shadow" style="width:80px;height:80px;object-fit:cover;border:3px solid #10316B;">`:`<div class="avi mx-auto" style="width:80px;height:80px;background:linear-gradient(135deg,#10316B,#4CAF50);font-size:2rem;">${p.name.charAt(0).toUpperCase()}</div>`}<h5 class="fw-bold mt-2 mb-1" style="font-size:.92rem;">${p.name}</h5><span class="pl ${sc}">${p.status.charAt(0).toUpperCase()+p.status.slice(1)}</span></div><table class="table table-sm table-borderless" style="font-size:.8rem;"><tr><td class="text-muted fw-semibold">Email</td><td>${p.email}</td></tr><tr><td class="text-muted fw-semibold">Phone</td><td>${p.phone||'—'}</td></tr><tr><td class="text-muted fw-semibold">Position</td><td>${p.position||'—'}</td></tr><tr><td class="text-muted fw-semibold">Age</td><td>${p.age||'—'}</td></tr><tr><td class="text-muted fw-semibold">Group</td><td>${p.age_group||'—'}</td></tr></table><div class="d-flex gap-2 mt-2"><button class="btn btn-sm fw-bold flex-grow-1" style="background:#dbeafe;color:#1d4ed8;border-radius:8px;" onclick="openMsg(${p.id},'${p.name.replace(/'/g,"\\'")}');bootstrap.Modal.getInstance(document.getElementById('profileModal')).hide();"><i class="bi bi-chat-dots-fill me-1"></i>Message</button><button class="btn btn-sm fw-bold flex-grow-1" style="background:#fef3c7;color:#a16207;border-radius:8px;" onclick="openRate(${p.id},'${p.name.replace(/'/g,"\\'")}');bootstrap.Modal.getInstance(document.getElementById('profileModal')).hide();"><i class="bi bi-star-fill me-1"></i>Rate</button></div></div><div class="col-md-8"><ul class="nav nav-tabs mb-3" style="font-size:.8rem;"><li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tr">⭐ Ratings</button></li><li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#ts">📅 Training</button></li><li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tm">💬 Messages</button></li></ul><div class="tab-content"><div class="tab-pane fade show active" id="tr">${rH}</div><div class="tab-pane fade" id="ts">${sH}</div><div class="tab-pane fade" id="tm">${mH}</div></div></div></div></div>`;
}
</script>
@endpush
