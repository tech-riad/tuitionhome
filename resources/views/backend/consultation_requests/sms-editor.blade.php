@extends('layouts.app')

@section('title', 'Consultation SMS Editor')

@push('page_css')
<style>
    .consultation-sms-page { background: #f4f7fb; min-height: calc(100vh - 60px); padding: 32px 20px 48px; }
    .consultation-sms-card { background: #fff; border: 1px solid #e6ecf3; border-radius: 12px; margin: 0 auto; max-width: 860px; padding: 26px; }
    .consultation-sms-recipient { background: #edf5ff; border-radius: 18px; color: #3e5e80; display: inline-block; font-size: 11px; margin: 0 5px 6px 0; padding: 6px 10px; }
    .consultation-sms-body { min-height: 140px; resize: vertical; }
</style>
@endpush

@section('content')
<main class="consultation-sms-page">
    <section class="consultation-sms-card">
        <a href="{{ route('admin.consultation-requests.index') }}">Back to consultation requests</a>
        <h1 class="h3 mt-3">SMS Editor</h1>

        @if($errors->any())
            <div class="alert alert-danger mt-3" role="alert">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="border-bottom mb-3 pb-3">
            <h2 class="h6">Recipients ({{ $consultationRequests->unique('tutor_id')->count() }})</h2>
            @foreach($consultationRequests->unique('tutor_id') as $consultationRequest)
                <span class="consultation-sms-recipient">
                    {{ $consultationRequest->tutor->name }} · {{ $consultationRequest->tutor->phone }}
                </span>
            @endforeach
        </div>

        <form method="POST" action="{{ route('admin.consultation-requests.sms.send') }}">
            @csrf
            @foreach($consultationRequests as $consultationRequest)
                <input type="hidden" name="consultation_request_ids[]" value="{{ $consultationRequest->id }}">
            @endforeach
            <label for="consultationSmsMessage">SMS Body</label>
            <textarea id="consultationSmsMessage" class="form-control consultation-sms-body" name="message" maxlength="300" required>{{ old('message') }}</textarea>
            <div class="d-flex justify-content-end text-muted small mt-2">
                <span><span id="consultationSmsCharacters">0</span>/300 characters · Estimated SMS: <span id="consultationSmsSegments">0</span></span>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <a class="btn btn-outline-secondary mr-2" href="{{ route('admin.consultation-requests.index') }}">Cancel</a>
                <button class="btn btn-primary" type="submit">Queue SMS</button>
            </div>
        </form>
    </section>
</main>
@endsection

@push('page_scripts')
<script>
    (function () {
        var input = document.getElementById('consultationSmsMessage');
        var characters = document.getElementById('consultationSmsCharacters');
        var segments = document.getElementById('consultationSmsSegments');

        function updateSmsCount() {
            characters.textContent = input.value.length;
            segments.textContent = input.value.length ? Math.ceil(input.value.length / 150) : 0;
        }

        input.addEventListener('input', updateSmsCount);
        updateSmsCount();
    })();
</script>
@endpush
