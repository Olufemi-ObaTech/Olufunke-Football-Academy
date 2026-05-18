@extends('layouts.main')
@section('title', 'Messages — Admin')
@section('content')
<section class="py-4" style="background:#f0f4ff; min-height:80vh;">
<div class="container">

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-2">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Header --}}
<div class="p-4 rounded-4 text-white mb-4 shadow" style="background:linear-gradient(135deg,#10316B 60%,#4CAF50 100%);">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-chat-dots-fill me-2"></i>Messages Centre</h2>
            <p class="opacity-75 mb-0">View messages from players and send replies</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm fw-bold" style="color:#10316B;">
            <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
        </a>
    </div>
</div>

<div class="row g-4">

    {{-- LEFT: Messages FROM Players ──────────────────────────────────────── --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header py-3 d-flex justify-content-between align-items-center fw-bold"
                 style="background:#10316B;color:#fff;">
                <span><i class="bi bi-inbox-fill me-2"></i>From Players</span>
                @if($unreadFromPlayers > 0)
                    <span class="badge bg-danger">{{ $unreadFromPlayers }} unread</span>
                @else
                    <span class="badge bg-success">All read</span>
                @endif
            </div>
            <div class="card-body p-0">
                @forelse($fromPlayers as $msg)
                <div class="p-3 border-bottom" style="cursor:pointer;" onclick="toggleMsg(this)">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 fw-bold text-white"
                                 style="width:36px;height:36px;background:#10316B;font-size:.85rem;">
                                {{ strtoupper(substr($msg->sender->name ?? 'P', 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold small">{{ $msg->sender->name ?? 'Player' }}</div>
                                <div class="text-muted" style="font-size:.75rem;">{{ $msg->subject ?? 'No subject' }}</div>
                            </div>
                        </div>
                        <div class="text-end">
                            <small class="text-muted">{{ $msg->created_at->format('d M Y') }}</small>
                            @if(!$msg->is_read)
                                <span class="badge bg-danger d-block mt-1">New</span>
                            @endif
                        </div>
                    </div>
                    {{-- Preview --}}
                    <p class="text-muted small mb-0 mt-2 msg-preview ps-5">{{ Str::limit($msg->body, 100) }}</p>
                    {{-- Full message --}}
                    <div class="msg-full d-none mt-2 ps-5">
                        <div class="p-3 bg-light rounded-3 small" style="line-height:1.8;">
                            {!! nl2br(e($msg->body)) !!}
                        </div>
                        {{-- Quick reply — stop propagation so clicking form doesn't collapse the message --}}
                        <form action="{{ route('admin.messages.store') }}" method="POST"
                              class="mt-3" onclick="event.stopPropagation()">
                            @csrf
                            <input type="hidden" name="to_user_id" value="{{ $msg->from_user_id }}">
                            <input type="hidden" name="subject" value="Re: {{ $msg->subject ?? 'Your message' }}">
                            <div class="mb-2">
                                <label class="form-label small fw-semibold text-muted mb-1">
                                    <i class="bi bi-reply-fill me-1"></i>Reply to {{ $msg->sender->name ?? 'player' }}
                                </label>
                                <textarea name="body" class="form-control form-control-sm" rows="3"
                                          placeholder="Type your reply..." required
                                          onclick="event.stopPropagation()"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm fw-bold px-4"
                                    onclick="event.stopPropagation()">
                                <i class="bi bi-send-fill me-1"></i>Send Reply
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>No messages from players yet.
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- RIGHT: Messages SENT to Players + Compose ────────────────────────── --}}
    <div class="col-lg-5">

        {{-- Compose --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header py-3 fw-bold" style="background:#4CAF50;color:#fff;">
                <i class="bi bi-pencil-fill me-2"></i>Send New Message
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.messages.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">To Player <span class="text-danger">*</span></label>
                        <select name="to_user_id" class="form-select form-select-sm" required>
                            <option value="">— Select Player —</option>
                            @foreach(\App\Models\User::where('role','player')->orderBy('name')->get() as $pl)
                                <option value="{{ $pl->id }}">{{ $pl->name }}
                                    @if($pl->age_group)({{ $pl->age_group }})@endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Subject</label>
                        <input type="text" name="subject" class="form-control form-control-sm" placeholder="e.g. Training Update">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Message <span class="text-danger">*</span></label>
                        <textarea name="body" class="form-control form-control-sm" rows="4" required
                                  placeholder="Type your message..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm fw-bold w-100">
                        <i class="bi bi-send-fill me-1"></i>Send Message
                    </button>
                </form>
            </div>
        </div>

        {{-- Sent Messages --}}
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header py-3 fw-bold" style="background:#10316B;color:#fff;">
                <i class="bi bi-send-fill me-2"></i>Sent to Players
                <span class="badge bg-warning text-dark ms-2">{{ $toPlayers->count() }}</span>
            </div>
            <div class="card-body p-0" style="max-height:400px;overflow-y:auto;">
                @forelse($toPlayers as $msg)
                <div class="p-3 border-bottom" style="cursor:pointer;" onclick="toggleMsg(this)">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fw-semibold small" style="color:#10316B;">
                                To: {{ $msg->recipient->name ?? 'Player' }}
                            </div>
                            <div class="text-muted" style="font-size:.75rem;">{{ $msg->subject ?? 'No subject' }}</div>
                        </div>
                        <small class="text-muted">{{ $msg->created_at->format('d M') }}</small>
                    </div>
                    <p class="text-muted small mb-0 mt-1 msg-preview">{{ Str::limit($msg->body, 80) }}</p>
                    <div class="msg-full d-none mt-2" onclick="event.stopPropagation()">
                        <div class="p-3 bg-light rounded-3 small" style="line-height:1.8;">
                            {!! nl2br(e($msg->body)) !!}
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted small">No sent messages yet.</div>
                @endforelse
            </div>
        </div>

    </div>
</div>

</div>
</section>

@push('scripts')
<script>
function toggleMsg(el) {
    const full    = el.querySelector('.msg-full');
    const preview = el.querySelector('.msg-preview');
    if (full.classList.contains('d-none')) {
        full.classList.remove('d-none');
        preview.classList.add('d-none');
    } else {
        full.classList.add('d-none');
        preview.classList.remove('d-none');
    }
}
</script>
@endpush
@endsection
