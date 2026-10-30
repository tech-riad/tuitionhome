@extends('layouts.app')

@section('title', 'SMS Editor - ' . $careerPlan->title)

@push('page_css')
<style>
    .career-sms-editor-page { background:#f4f7fb; min-height:calc(100vh - 60px); padding:32px 20px 48px; }
    .career-sms-editor-wrap { margin:0 auto; max-width:860px; }
    .career-sms-editor-card { background:#fff; border:1px solid #e6ecf3; border-radius:12px; box-shadow:0 8px 26px rgba(34,58,86,.045); padding:26px; }
    .career-sms-editor-back { color:#1680f8; display:inline-block; font-size:12px; font-weight:600; margin-bottom:16px; text-decoration:none; }
    .career-sms-editor-title { color:#243447; font-size:24px; font-weight:700; margin:0 0 7px; }
    .career-sms-editor-subtitle { color:#7d8998; font-size:13px; margin-bottom:22px; }
    .career-sms-editor-recipients { border-bottom:1px solid #edf1f6; margin-bottom:20px; padding-bottom:18px; }
    .career-sms-editor-recipients h2 { color:#34475c; font-size:14px; font-weight:650; margin:0 0 10px; }
    .career-sms-editor-recipient { background:#edf5ff; border-radius:18px; color:#3e5e80; display:inline-block; font-size:11px; margin:0 5px 6px 0; padding:6px 10px; }
    .career-sms-editor-input { border:1px solid #dfe6ee; border-radius:7px; color:#394b60; display:block; font-size:13px; min-height:140px; padding:12px; resize:vertical; width:100%; }
    .career-sms-editor-input:focus { border-color:#1680f8; outline:0; }
    .career-sms-editor-meta { color:#8290a0; display:flex; flex-wrap:wrap; font-size:11px; gap:15px; justify-content:flex-end; margin-top:8px; }
    .career-sms-editor-error { color:#c34242; font-size:12px; margin-top:8px; }
    .career-sms-editor-actions { display:flex; gap:9px; justify-content:flex-end; margin-top:20px; }
    .career-sms-editor-actions a { align-items:center; border:1px solid #dfe6ee; border-radius:6px; color:#526276; display:inline-flex; font-size:12px; padding:0 14px; text-decoration:none; }
    .career-sms-editor-actions button { background:#1680f8; border:0; border-radius:6px; color:#fff; cursor:pointer; font-size:12px; font-weight:600; padding:11px 17px; }
    @media(max-width:600px) {
        .career-sms-editor-page { padding:22px 12px 32px; }
        .career-sms-editor-card { padding:20px 16px; }
        .career-sms-editor-title { font-size:21px; }
    }
</style>
@endpush

@section('content')
<main class="career-sms-editor-page">
    <div class="career-sms-editor-wrap">
        <a class="career-sms-editor-back" href="{{ route('admin.career.applications', $careerPlan) }}">← Back to Applications</a>
        <section class="career-sms-editor-card">
            <h1 class="career-sms-editor-title">SMS Editor</h1>
            <div class="career-sms-editor-subtitle">Job #{{ $careerPlan->id }} · {{ $careerPlan->title }}</div>

            <div class="career-sms-editor-recipients">
                <h2>To ({{ $applications->count() }})</h2>
                @foreach($applications as $application)
                    <span class="career-sms-editor-recipient">{{ $application->tutor->name }} · {{ $application->tutor->phone }}</span>
                @endforeach
            </div>

            <form action="{{ route('admin.career.applications.sms.send', $careerPlan) }}" method="POST">
                @csrf
                @foreach($applications as $application)
                    <input type="hidden" name="application_ids[]" value="{{ $application->id }}">
                @endforeach
                <label for="careerSmsBody" class="form-label">SMS Body</label>
                <textarea id="careerSmsBody" name="message" maxlength="300" required class="career-sms-editor-input">{{ old('message') }}</textarea>
                @error('message')
                    <div class="career-sms-editor-error">{{ $message }}</div>
                @enderror
                <div class="career-sms-editor-meta">
                    <span><span id="careerSmsCharacters">0</span>/300 characters</span>
                    <span>Estimated SMS: <span id="careerSmsSegments">0</span></span>
                </div>
                <div class="career-sms-editor-actions">
                    <a href="{{ route('admin.career.applications', $careerPlan) }}">Cancel</a>
                    <button type="submit">Queue SMS</button>
                </div>
            </form>
        </section>
    </div>
</main>
@endsection

@push('page_scripts')
<script>
    (function () {
        var input = document.getElementById('careerSmsBody');
        var characters = document.getElementById('careerSmsCharacters');
        var segments = document.getElementById('careerSmsSegments');

        function updateSmsCount() {
            characters.textContent = input.value.length;
            segments.textContent = input.value.length ? Math.ceil(input.value.length / 150) : 0;
        }

        input.addEventListener('input', updateSmsCount);
        updateSmsCount();
    })();
</script>
@endpush
