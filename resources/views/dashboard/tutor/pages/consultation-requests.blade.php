@extends('dashboard.tutor.layout')

@push('css')
<style>
    .t-consultation-note {
        align-items: flex-start;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        gap: 10px;
        justify-content: space-between;
        padding: 6px 0;
    }
    .t-consultation-note:last-child { border-bottom: 0; }
    .t-consultation-note-body { font-size: 13px; line-height: 1.4; overflow-wrap: anywhere; white-space: pre-wrap; }
    .t-consultation-note-meta { color: #6c757d; flex: 0 0 auto; font-size: 11px; white-space: nowrap; }
    @media (max-width: 576px) {
        .t-consultation-note { display: block; }
        .t-consultation-note-meta { display: block; margin-top: 3px; }
    }
</style>
@endpush

@section('content')
    <div class="t-dashboard-contant p-4" style="margin-left: 245px;">
        <div class="container-fluid">
            <h2 class="mb-4">Teacher Consultation</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Request a consultation</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('tutor.consultation-requests.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="message">What would you like to discuss?</label>
                            <textarea
                                id="message"
                                name="message"
                                class="form-control @error('message') is-invalid @enderror"
                                rows="4"
                                maxlength="5000"
                                required
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success">Submit request</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">My consultation requests</h5>
                </div>
                <div class="card-body">
                    @forelse($consultationRequests as $consultationRequest)
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start flex-wrap">
                                <h6>Consultation request</h6>
                                <span class="badge badge-secondary">{{ ucfirst($consultationRequest->status) }}</span>
                            </div>
                            <p class="mb-2">{{ $consultationRequest->message }}</p>
                            @if($consultationRequest->scheduled_at)
                                <div><small class="text-muted">Scheduled for {{ $consultationRequest->scheduled_at->format('M d, Y g:i A') }}</small></div>
                            @endif
                            @if($consultationRequest->notes->isNotEmpty())
                                <div class="mt-2">
                                    <small class="text-muted">Staff notes</small>
                            @foreach($consultationRequest->notes as $note)
                                    <div class="t-consultation-note">
                                        <span class="t-consultation-note-body">{{ $note->note }}</span>
                                        <small class="t-consultation-note-meta">{{ optional($note->user)->name ?? 'Former user' }} · {{ $note->created_at->format('M d, Y g:i A') }}</small>
                                    </div>
                            @endforeach
                                </div>
                            @endif
                            <div>
                                <small class="text-muted">Submitted {{ $consultationRequest->created_at->format('M d, Y g:i A') }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">You have not submitted any consultation requests yet.</p>
                    @endforelse

                    {{ $consultationRequests->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
