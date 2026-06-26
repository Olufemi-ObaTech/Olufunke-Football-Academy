@extends('layouts.main')
@section('title', 'My Dashboard')
@section('content')
<style>
*{box-sizing:border-box;}
/* ─── Shell ─────────────────────────────────────────────────────────────── */
.pdash{background:#f0f4f8;min-height:calc(100vh - 72px);}

/* ─── Hero banner ───────────────────────────────────────────────────────── */
.phero{background:linear-gradient(135deg,#0f1f3d 0%,#10316B 50%,#1a5c2a 100%);
  padding:28px 24px;position:relative;overflow:hidden;}
.phero::before{content:'';position:absolute;top:-60px;right:-60px;width:220px;height:220px;
  border-radius:50%;background:rgba(255,255,255,.04);}
.phero::after{content:'';position:absolute;bottom:-40px;left:30%;width:160px;height:160px;
  border-radius:50%;background:rgba(76,175,80,.08);}
.phero-av{width:68px;height:68px;border-radius:18px;object-fit:cover;
  border:3px solid #fbbf24;flex-shrink:0;position:relative;z-index:1;}
.phero-av-init{width:68px;height:68px;border-radius:18px;display:flex;align-items:center;
  justify-content:center;font-size:1.8rem;font-weight:900;color:#fff;flex-shrink:0;
  background:linear-gradient(135deg,#fbbf24,#f59e0b);position:relative;z-index:1;}

/* ─── Glassmorphism stat cards ──────────────────────────────────────────── */
.pgcard{border-radius:16px;padding:18px 16px;display:flex;align-items:center;gap:12px;
  position:relative;overflow:hidden;border:1px solid rgba(255,255,255,.2);
  backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px);
  box-shadow:0 6px 24px rgba(0,0,0,.1),inset 0 1px 0 rgba(255,255,255,.15);
  transition:transform .18s,box-shadow .18s;text-decoration:none;}
.pgcard:hover{transform:translateY(-3px);box-shadow:0 12px 32px rgba(0,0,0,.15);}
.pgcard::before{content:'';position:absolute;top:-20px;right:-20px;width:70px;height:70px;
  border-radius:50%;background:rgba(255,255,255,.07);}
.pgcard .pgi{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;
  justify-content:center;font-size:1.2rem;flex-shrink:0;background:rgba(255,255,255,.18);
  position:relative;z-index:1;}
.pgcard .pgv{font-size:1.6rem;font-weight:900;line-height:1;position:relative;z-index:1;}
.pgcard .pgl{font-size:.7rem;font-weight:600;opacity:.8;margin-top:2px;position:relative;z-index:1;}

/* ─── Panels ────────────────────────────────────────────────────────────── */
.ppnl{background:#fff;border-radius:16px;box-shadow:0 2px 16px rgba(0,0,0,.06);
  overflow:hidden;margin-bottom:20px;border:1px solid #e8edf2;}
.ppnl-h{padding:13px 18px;display:flex;align-items:center;justify-content:space-between;
  border-bottom:1px solid #f0f4f8;}
.ppnl-h .ph{font-size:.88rem;font-weight:700;color:#0d1117;display:flex;align-items:center;gap:8px;}
.ppnl-h .phi{width:28px;height:28px;border-radius:8px;display:flex;align-items:center;
  justify-content:center;font-size:.85rem;}

/* ─── Quick-access tiles ────────────────────────────────────────────────── */
.pqt{display:flex;flex-direction:column;align-items:center;justify-content:center;
  gap:8px;padding:18px 12px;border-radius:14px;border:1.5px solid #e8edf2;
  background:#fff;text-decoration:none;transition:all .18s;
  box-shadow:0 2px 8px rgba(0,0,0,.04);text-align:center;}
.pqt:hover{border-color:#10316B;box-shadow:0 6px 20px rgba(16,49,107,.12);transform:translateY(-2px);}
.pqt .pqi{width:46px;height:46px;border-radius:14px;display:flex;align-items:center;
  justify-content:center;font-size:1.3rem;}
.pqt .pqt-lbl{font-size:.78rem;font-weight:700;color:#0d1117;}

/* ─── Pills ─────────────────────────────────────────────────────────────── */
.pl{display:inline-flex;align-items:center;gap:3px;padding:3px 9px;border-radius:20px;font-size:.7rem;font-weight:700;}
.pl-g{background:#dcfce7;color:#15803d;}
.pl-y{background:#fef9c3;color:#a16207;}
.pl-r{background:#fee2e2;color:#b91c1c;}
.pl-b{background:#dbeafe;color:#1d4ed8;}

/* ─── Message items ─────────────────────────────────────────────────────── */
.pmsg{cursor:pointer;transition:background .1s;border-bottom:1px solid #f0f4f8;}
.pmsg:hover{background:#f8fafc;}
.pmsg.unread{background:#fffbeb;}

/* ─── Progress bar ──────────────────────────────────────────────────────── */
.pbar{height:6px;border-radius:6px;background:#e8edf2;overflow:hidden;}
.pbar-fill{height:100%;border-radius:6px;transition:width .4s ease;}

/* ─── Training date badge ───────────────────────────────────────────────── */
.tdate{min-width:50px;text-align:center;border-radius:12px;padding:8px 6px;
  background:linear-gradient(135deg,#10316B,#1e4db7);color:#fff;}
.tdate .td{font-size:1.1rem;font-weight:900;line-height:1;}
.tdate .tm{font-size:.62rem;font-weight:700;opacity:.8;text-transform:uppercase;}

/* ─── Pending state ─────────────────────────────────────────────────────── */
.pending-card{background:linear-gradient(135deg,#0f1f3d,#10316B);border-radius:20px;
  padding:48px 32px;text-align:center;color:#fff;position:relative;overflow:hidden;}
.pending-card::before{content:'⚽';position:absolute;font-size:8rem;opacity:.04;
  top:50%;left:50%;transform:translate(-50%,-50%);}
</style>

<div class="pdash">

  {{-- ── Hero Banner ──────────────────────────────────────────────────────── --}}
  <div class="phero">
    <div class="container-fluid px-3 px-md-4">
      @foreach(['success','info','error'] as $flash)
        @if(session($flash))
        <div class="alert alert-{{ $flash==='error'?'warning':$flash }} alert-dismissible fade show mb-3">
          {{ session($flash) }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
      @endforeach

      <div class="d-flex align-items-center gap-4 flex-wrap">
        {{-- Avatar --}}
        @if($user->profile_photo)
          <img src="{{ asset('storage/'.$user->profile_photo) }}" alt="{{ $user->name }}" class="phero-av"
               onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
          <div class="phero-av-init" style="display:none;">{{ strtoupper(substr($user->name,0,1)) }}</div>
        @else
          <div class="phero-av-init">{{ strtoupper(substr($user->name,0,1)) }}</div>
        @endif

        {{-- Info --}}
        <div class="flex-grow-1" style="position:relative;z-index:1;">
          <h2 class="fw-bold text-white mb-1" style="font-size:1.4rem;">Welcome back, {{ explode(' ',$user->name)[0] }}! ⚽</h2>
          <div class="d-flex flex-wrap gap-2 align-items-center">
            @if($user->position)<span class="pl" style="background:rgba(255,255,255,.15);color:#fff;">{{ $user->position }}</span>@endif
            @if($user->age_group)<span class="pl" style="background:rgba(251,191,36,.2);color:#fde68a;">{{ $user->age_group }}</span>@endif
            @if($user->age)<span class="pl" style="background:rgba(255,255,255,.1);color:rgba(255,255,255,.7);">Age {{ $user->age }}</span>@endif
            @if($user->status==='approved')
              <span class="pl pl-g"><i class="bi bi-check-circle-fill"></i> Approved</span>
            @elseif($user->status==='pending')
              <span class="pl pl-y"><i class="bi bi-hourglass-split"></i> Pending</span>
            @else
              <span class="pl pl-r"><i class="bi bi-x-circle-fill"></i> Rejected</span>
            @endif
          </div>
        </div>

        {{-- Unread badge --}}
        @if($unreadCount>0)
        <div style="position:relative;z-index:1;">
          <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3"
               style="background:rgba(239,68,68,.2);border:1px solid rgba(239,68,68,.3);">
            <i class="bi bi-envelope-fill text-danger"></i>
            <span class="text-white fw-bold" style="font-size:.83rem;">{{ $unreadCount }} new message{{ $unreadCount>1?'s':'' }}</span>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>

  <div class="container-fluid px-3 px-md-4 py-4">

  @if($user->isApproved())

  {{-- ── Glassmorphism Quick-Access Cards ────────────────────────────────── --}}
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <a href="{{ route('program') }}" class="pgcard" style="background:linear-gradient(135deg,rgba(16,49,107,.9),rgba(30,77,183,.85));color:#fff;">
        <div class="pgi"><i class="bi bi-trophy-fill"></i></div>
        <div><div class="pgv" style="font-size:1rem;margin-top:2px;">Program</div><div class="pgl">Training &amp; drills</div></div>
      </a>
    </div>
    <div class="col-6 col-md-3">
      <a href="{{ route('football-education') }}" class="pgcard" style="background:linear-gradient(135deg,rgba(5,150,105,.9),rgba(16,185,129,.85));color:#fff;">
        <div class="pgi"><i class="bi bi-mortarboard-fill"></i></div>
        <div><div class="pgv" style="font-size:1rem;margin-top:2px;">E-Learning</div><div class="pgl">Courses &amp; lessons</div></div>
      </a>
    </div>
    <div class="col-6 col-md-3">
      <a href="{{ route('quiz.index') }}" class="pgcard" style="background:linear-gradient(135deg,rgba(124,58,237,.9),rgba(139,92,246,.85));color:#fff;">
        <div class="pgi"><i class="bi bi-patch-question-fill"></i></div>
        <div><div class="pgv" style="font-size:1rem;margin-top:2px;">IQ Quiz</div><div class="pgl">Test your knowledge</div></div>
      </a>
    </div>
    <div class="col-6 col-md-3">
      <a href="{{ route('store') }}" class="pgcard" style="background:linear-gradient(135deg,rgba(220,38,38,.9),rgba(239,68,68,.85));color:#fff;">
        <div class="pgi"><i class="bi bi-shop-window"></i></div>
        <div><div class="pgv" style="font-size:1rem;margin-top:2px;">OFA Store</div><div class="pgl">Gear &amp; booking</div></div>
      </a>
    </div>
  </div>

  {{-- ── Main Content Grid ────────────────────────────────────────────────── --}}
  <div class="row g-4">

    {{-- LEFT COLUMN ──────────────────────────────────────────────────────── --}}
    <div class="col-lg-4">

      {{-- Profile Card --}}
      <div class="ppnl">
        <div class="ppnl-h">
          <div class="ph"><div class="phi" style="background:#dbeafe;"><i class="bi bi-person-badge-fill" style="color:#2563eb;"></i></div>My Profile</div>
        </div>
        <div class="p-4">
          <div class="text-center mb-4">
            @if($user->profile_photo)
              <img src="{{ asset('storage/'.$user->profile_photo) }}" alt="{{ $user->name }}"
                   class="rounded-circle shadow" style="width:72px;height:72px;object-fit:cover;border:3px solid #10316B;">
            @else
              <div class="rounded-circle d-inline-flex align-items-center justify-content-center fw-bold text-white shadow"
                   style="width:72px;height:72px;background:linear-gradient(135deg,#10316B,#4CAF50);font-size:1.8rem;">
                {{ strtoupper(substr($user->name,0,1)) }}
              </div>
            @endif
            <div class="fw-bold mt-2" style="font-size:.95rem;color:#0d1117;">{{ $user->name }}</div>
            <div class="text-muted" style="font-size:.75rem;">{{ $user->email }}</div>
          </div>
          <div class="row g-2">
            @if($user->role === 'guardian')
              @php
                $guardianFields = [
                    ['Phone',        $user->phone ?? '—'],
                    ["Child's Name", $user->child_name ?? (str_replace('Guardian of: ', '', $user->position ?? '') ?: '—')],
                    ['Relationship', $user->relationship_to_player ?? '—'],
                    ['Nationality',  $user->nationality ?? '—'],
                    ['Member Since', $user->created_at->format('d M Y')],
                ];
              @endphp
              @foreach($guardianFields as [$lbl,$val])
              <div class="col-6">
                <div style="background:#f8fafc;border-radius:10px;padding:10px 12px;">
                  <div style="font-size:.65rem;font-weight:800;letter-spacing:.06em;color:#94a3b8;text-transform:uppercase;">{{ $lbl }}</div>
                  <div style="font-size:.82rem;font-weight:600;color:#0d1117;margin-top:2px;">{{ $val }}</div>
                </div>
              </div>
              @endforeach
            @else
              @foreach([['Phone',$user->phone??'—'],['Position',$user->position??'—'],['Age',$user->age??'—'],['Nationality',$user->nationality??'—'],['Member Since',$user->created_at->format('d M Y')]] as [$lbl,$val])
              <div class="col-6">
                <div style="background:#f8fafc;border-radius:10px;padding:10px 12px;">
                  <div style="font-size:.65rem;font-weight:800;letter-spacing:.06em;color:#94a3b8;text-transform:uppercase;">{{ $lbl }}</div>
                  <div style="font-size:.82rem;font-weight:600;color:#0d1117;margin-top:2px;">{{ $val }}</div>
                </div>
              </div>
              @endforeach
            @endif
          </div>
        </div>
      </div>

      {{-- Latest Performance Rating --}}
      @if($latestRating)
      @php $overall=round(($latestRating->technical+$latestRating->tactical+$latestRating->physical+$latestRating->mental+$latestRating->teamwork+$latestRating->attitude)/6,1); @endphp
      <div class="ppnl">
        <div class="ppnl-h">
          <div class="ph"><div class="phi" style="background:#fef3c7;"><i class="bi bi-star-fill" style="color:#d97706;"></i></div>Performance Rating</div>
          <span class="pl pl-y">{{ $latestRating->rated_for_date->format('d M Y') }}</span>
        </div>
        <div class="p-4">
          <div class="text-center mb-4">
            <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#10316B,#4CAF50);
                        display:inline-flex;align-items:center;justify-content:center;flex-direction:column;
                        box-shadow:0 4px 16px rgba(16,49,107,.3);">
              <div style="font-size:1.5rem;font-weight:900;color:#fff;line-height:1;">{{ $overall }}</div>
              <div style="font-size:.6rem;color:rgba(255,255,255,.7);font-weight:700;">/10</div>
            </div>
            <div class="text-muted mt-2" style="font-size:.72rem;">Overall · by {{ $latestRating->rater->name??'Coach' }}</div>
          </div>
          @foreach(['technical'=>'Technical','tactical'=>'Tactical','physical'=>'Physical','mental'=>'Mental','teamwork'=>'Teamwork','attitude'=>'Attitude'] as $field=>$label)
          @php $val=$latestRating->$field; $col=$val>=8?'#15803d':($val>=5?'#d97706':'#b91c1c'); @endphp
          <div class="mb-2">
            <div class="d-flex justify-content-between mb-1" style="font-size:.75rem;">
              <span class="text-muted">{{ $label }}</span>
              <strong style="color:{{ $col }};">{{ $val }}/10</strong>
            </div>
            <div class="pbar"><div class="pbar-fill" style="width:{{ $val*10 }}%;background:{{ $col }};"></div></div>
          </div>
          @endforeach
          @if($latestRating->comments)
          <div class="mt-3 p-3 rounded-3" style="background:#f8fafc;border-left:3px solid #fbbf24;">
            <div style="font-size:.68rem;font-weight:800;letter-spacing:.06em;color:#94a3b8;text-transform:uppercase;margin-bottom:4px;">Coach Notes</div>
            <p class="mb-0 text-muted" style="font-size:.8rem;line-height:1.6;">{{ $latestRating->comments }}</p>
          </div>
          @endif
        </div>
      </div>
      @endif

    </div>{{-- /col-lg-4 --}}

    {{-- RIGHT COLUMN ─────────────────────────────────────────────────────── --}}
    <div class="col-lg-8">

      {{-- Messages from Coach --}}
      <div class="ppnl">
        <div class="ppnl-h">
          <div class="ph"><div class="phi" style="background:#dcfce7;"><i class="bi bi-chat-dots-fill" style="color:#16a34a;"></i></div>Messages from Coach</div>
          @if($unreadCount>0)<span class="pl pl-r">{{ $unreadCount }} unread</span>@endif
        </div>
        <div style="max-height:280px;overflow-y:auto;">
          @forelse($messages as $msg)
          <div class="pmsg {{ !$msg->is_read?'unread':'' }}" data-id="{{ $msg->id }}" onclick="togglePMsg(this)">
            <div class="d-flex align-items-start gap-3 p-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0"
                   style="width:34px;height:34px;background:linear-gradient(135deg,#10316B,#4CAF50);font-size:.75rem;">
                {{ strtoupper(substr($msg->sender->name??'C',0,1)) }}
              </div>
              <div class="flex-grow-1 min-w-0">
                <div class="d-flex justify-content-between align-items-start gap-2">
                  <div class="fw-semibold" style="font-size:.83rem;color:#0d1117;">
                    {{ $msg->subject??'Message from Coach' }}
                    @if(!$msg->is_read)<span class="pl pl-r ms-1">New</span>@endif
                  </div>
                  <small class="text-muted flex-shrink-0" style="font-size:.7rem;">{{ $msg->created_at->format('d M Y') }}</small>
                </div>
                <div class="pmsg-prev text-muted" style="font-size:.76rem;margin-top:2px;">{{ Str::limit($msg->body,80) }}</div>
                <div class="pmsg-full d-none mt-2 p-3 rounded-3" style="background:#f8fafc;font-size:.82rem;line-height:1.7;">
                  <strong>From:</strong> {{ $msg->sender->name??'OFA Coach' }}<br>
                  {!! nl2br(e($msg->body)) !!}
                </div>
              </div>
              <i class="bi bi-chevron-down text-muted pmsg-chev flex-shrink-0" style="font-size:.75rem;"></i>
            </div>
          </div>
          @empty
          <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
            <p class="mb-0" style="font-size:.83rem;">No messages yet.</p>
          </div>
          @endforelse
        </div>
        <div class="p-3 border-top" style="background:#f8fafc;">
          <button class="btn btn-sm fw-bold w-100 mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#replyForm"
                  style="background:#10316B;color:#fff;border-radius:10px;">
            <i class="bi bi-reply-fill me-1"></i>Send Message to Coach
          </button>
          <div class="collapse" id="replyForm">
            <form action="{{ route('messages.reply') }}" method="POST" class="mt-2">
              @csrf
              <input type="text" name="subject" class="form-control form-control-sm mb-2" placeholder="Subject (optional)">
              <textarea name="body" class="form-control form-control-sm mb-2" rows="3" required placeholder="Type your message..."></textarea>
              <button type="submit" class="btn btn-success btn-sm fw-bold w-100" style="border-radius:8px;">
                <i class="bi bi-send-fill me-1"></i>Send to Coach
              </button>
            </form>
          </div>
        </div>
      </div>

      {{-- Upcoming Training Sessions --}}
      <div class="ppnl">
        <div class="ppnl-h">
          <div class="ph"><div class="phi" style="background:#ccfbf1;"><i class="bi bi-calendar-check-fill" style="color:#0d9488;"></i></div>Upcoming Training Sessions</div>
          <span class="pl" style="background:#f0f4f8;color:#64748b;">{{ $schedules->count() }} sessions</span>
        </div>
        <div class="p-3">
          @forelse($schedules as $s)
          <div class="d-flex align-items-start gap-3 p-3 rounded-3 mb-2" style="background:#f8fafc;border:1px solid #e8edf2;">
            <div class="tdate flex-shrink-0">
              <div class="td">{{ $s->session_date->format('d') }}</div>
              <div class="tm">{{ $s->session_date->format('M') }}</div>
            </div>
            <div class="flex-grow-1">
              <div class="fw-bold" style="font-size:.88rem;color:#0d1117;">{{ $s->title }}</div>
              <div class="d-flex flex-wrap gap-2 mt-1 align-items-center">
                <span class="pl pl-b" style="font-size:.68rem;">{{ ucfirst($s->type) }}</span>
                <span class="pl" style="background:#f1f5f9;color:#475569;font-size:.68rem;">{{ $s->age_group }}</span>
                <span class="text-muted" style="font-size:.72rem;"><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($s->session_time)->format('g:i A') }} · {{ $s->duration_minutes }}m</span>
              </div>
              <div class="text-muted mt-1" style="font-size:.75rem;"><i class="bi bi-geo-alt-fill me-1"></i>{{ $s->location }}</div>
              @if($s->notes)
              <div class="mt-2 p-2 rounded-2" style="background:#fff;border-left:3px solid #fbbf24;font-size:.75rem;color:#64748b;">
                <i class="bi bi-info-circle me-1"></i>{{ $s->notes }}
              </div>
              @endif
            </div>
          </div>
          @empty
          <div class="text-center py-4 text-muted">
            <i class="bi bi-calendar-x fs-1 d-block mb-2 opacity-25"></i>
            <p class="mb-0" style="font-size:.83rem;">No upcoming training sessions.</p>
          </div>
          @endforelse
        </div>
      </div>

      {{-- Learning Progress --}}
      <div class="ppnl">
        <div class="ppnl-h">
          <div class="ph"><div class="phi" style="background:#f3e8ff;"><i class="bi bi-mortarboard-fill" style="color:#9333ea;"></i></div>My Learning Progress</div>
          @php
            $completedCount=$progress->where('status','completed')->count();
            $totalCourses=$courses->count();
            $overallPct=$totalCourses>0?round(($completedCount/$totalCourses)*100):0;
          @endphp
          <span class="pl" style="background:#f3e8ff;color:#9333ea;">{{ $overallPct }}% done</span>
        </div>
        <div class="p-4">
          {{-- Overall bar --}}
          <div class="p-3 rounded-3 mb-4" style="background:linear-gradient(135deg,rgba(16,49,107,.06),rgba(76,175,80,.06));border:1px solid #e8edf2;">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="fw-semibold" style="font-size:.82rem;color:#0d1117;">Overall Completion</span>
              <span class="fw-bold" style="color:#15803d;font-size:.88rem;">{{ $completedCount }}/{{ $totalCourses }} courses</span>
            </div>
            <div class="pbar" style="height:10px;">
              <div class="pbar-fill" style="width:{{ $overallPct }}%;background:linear-gradient(90deg,#10316B,#4CAF50);"></div>
            </div>
          </div>
          {{-- Per-course --}}
          @foreach($courses as $course)
          @php
            $cp=$progress->get($course->id);
            $cpPct=$cp?$cp->progress_percent:0;
            $cpStatus=$cp?$cp->status:'not_started';
            $cpColor=$cpStatus==='completed'?'#15803d':($cpStatus==='in_progress'?'#d97706':'#94a3b8');
            $cpBg=$cpStatus==='completed'?'#dcfce7':($cpStatus==='in_progress'?'#fef9c3':'#f1f5f9');
            $cpLabel=$cp?ucfirst(str_replace('_',' ',$cp->status)):'Not Started';
          @endphp
          <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <a href="{{ route('course.view',$course) }}" class="fw-semibold text-decoration-none" style="font-size:.83rem;color:#0d1117;">
                {{ $course->title }}
              </a>
              <span class="pl" style="background:{{ $cpBg }};color:{{ $cpColor }};font-size:.68rem;">{{ $cpLabel }}</span>
            </div>
            <div class="pbar">
              <div class="pbar-fill" style="width:{{ $cpPct }}%;background:{{ $cpColor }};"></div>
            </div>
          </div>
          @endforeach
          <a href="{{ route('football-education') }}" class="btn btn-sm fw-bold w-100 mt-2"
             style="background:linear-gradient(135deg,#10316B,#1e4db7);color:#fff;border-radius:10px;padding:9px;">
            <i class="bi bi-play-fill me-1"></i>Continue Learning
          </a>
        </div>
      </div>

    </div>{{-- /col-lg-8 --}}
  </div>{{-- /row --}}

  @else
  {{-- ── Pending State ────────────────────────────────────────────────────── --}}
  <div class="row justify-content-center">
    <div class="col-md-7 col-lg-5">
      <div class="pending-card">
        <div style="width:80px;height:80px;border-radius:50%;background:rgba(251,191,36,.15);
                    border:2px solid rgba(251,191,36,.3);display:inline-flex;align-items:center;
                    justify-content:center;font-size:2rem;margin-bottom:20px;">⏳</div>
        <h4 class="fw-bold mb-2">Account Pending Approval</h4>
        <p class="opacity-75 mb-4" style="font-size:.88rem;">Your registration is under review by the OFA management team. You'll get full access once approved.</p>
        <div class="d-flex flex-column gap-2 align-items-center">
          <a href="tel:09079917993" class="btn btn-sm fw-bold px-4"
             style="background:rgba(76,175,80,.2);color:#6ee7b7;border:1px solid rgba(76,175,80,.3);border-radius:10px;">
            <i class="bi bi-telephone-fill me-1"></i>09079917993
          </a>
          <a href="mailto:Olufunkefootballacademy@gmail.com" class="btn btn-sm fw-bold px-4"
             style="background:rgba(59,130,246,.2);color:#93c5fd;border:1px solid rgba(59,130,246,.3);border-radius:10px;">
            <i class="bi bi-envelope-fill me-1"></i>Email Us
          </a>
        </div>
      </div>
    </div>
  </div>
  @endif

  {{-- Logout --}}
  <div class="text-center mt-4 pb-4">
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
      @csrf
      <button type="submit" class="btn btn-sm fw-bold px-4"
              style="background:#fee2e2;color:#b91c1c;border-radius:10px;border:none;">
        <i class="bi bi-box-arrow-right me-1"></i>Log Out
      </button>
    </form>
  </div>

  </div>{{-- /container-fluid --}}
</div>{{-- /pdash --}}

@endsection
@push('scripts')
<script>
function togglePMsg(el){
  const full=el.querySelector('.pmsg-full'),prev=el.querySelector('.pmsg-prev'),chev=el.querySelector('.pmsg-chev');
  const id=el.dataset.id;
  if(full.classList.contains('d-none')){
    full.classList.remove('d-none');prev.classList.add('d-none');
    chev.classList.replace('bi-chevron-down','bi-chevron-up');
    el.classList.remove('unread');
    el.querySelector('.pl-r')?.remove();
    fetch('/messages/'+id+'/read',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'}});
  }else{
    full.classList.add('d-none');prev.classList.remove('d-none');
    chev.classList.replace('bi-chevron-up','bi-chevron-down');
  }
}
</script>
@endpush
