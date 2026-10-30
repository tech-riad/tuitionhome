{{-- resources/views/employer/jobs/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Post a New Job', 'content')

@push('page_css')
<style>
    .job-create-page { background:#f4f7fb; min-height:100vh; padding:28px 18px; color:#172b3a; }
    .job-create-wrap { max-width:1240px; margin:0 auto; }
    .job-heading { font-size:28px; font-weight:700; margin:0 0 8px; }
    .job-breadcrumb { color:#7b8794; margin-bottom:22px; }
    .job-breadcrumb span { color:#087bea; }
    .job-card { background:#fff; border:1px solid #e7ebf0; border-radius:4px; padding:22px 28px 28px; box-shadow:0 1px 2px rgba(20,40,60,.025); }
    .job-card-title { font-size:18px; font-weight:500; margin-bottom:34px; }
    .job-card-title a { color:#172b3a; text-decoration:none; }
    .job-steps { display:flex; align-items:flex-start; max-width:850px; margin:0 auto 52px; }
    .job-step { flex:1; text-align:center; position:relative; color:#89939e; font-size:11px; }
    .job-step:not(:last-child):after { content:""; position:absolute; height:2px; background:#e6e9ed; left:50%; right:-50%; top:11px; z-index:0; }
    .job-step.done:not(:last-child):after, .job-step.active:not(:last-child):after { background:#1680f8; }
    .job-step-circle { width:22px; height:22px; border-radius:50%; background:#bfc3c7; color:#fff; display:flex; align-items:center; justify-content:center; margin:0 auto 9px; position:relative; z-index:1; font-size:11px; font-weight:600; }
    .job-step.active .job-step-circle, .job-step.done .job-step-circle { background:#1680f8; }
    .job-step.active, .job-step.done { color:#273747; }
    .required-note { font-size:13px; margin-bottom:18px; color:#111; }
    .required-note b, .field-label .required { color:#f04452; }
    .job-grid { display:grid; grid-template-columns:1fr 1fr; column-gap:24px; row-gap:22px; }
    .job-field { display:grid; grid-template-columns: minmax(130px, 34%) 1fr; gap:14px; align-items:start; }
    .field-label { color:#087bea; font-size:15px; font-weight:500; line-height:1.3; padding-top:5px; }
    .field-help { color:#6f7882; display:block; font-size:10px; line-height:1.45; margin-top:4px; font-weight:400; }
    .job-control, .job-select { width:100%; height:40px; border:1px solid #dfe3e8; border-radius:5px; padding:8px 11px; font-size:13px; color:#334155; background:#fff; outline:none; }
    .job-control:focus, .job-select:focus, .job-textarea:focus { border-color:#1680f8; box-shadow:0 0 0 2px rgba(22,128,248,.08); }
    .job-textarea { width:100%; min-height:180px; border:1px solid #dfe3e8; border-radius:0 0 5px 5px; padding:12px; font-size:13px; resize:vertical; outline:none; }
    .editor-toolbar { height:42px; border:1px solid #dfe3e8; border-bottom:0; border-radius:5px 5px 0 0; display:flex; align-items:center; gap:13px; padding:0 12px; color:#354252; font-size:14px; }
    .editor-toolbar button { border:0; background:none; color:inherit; padding:2px; cursor:pointer; }
    .editor-toolbar .ai-btn { margin-left:auto; background:#087bea; color:#fff; border-radius:4px; padding:5px 10px; font-size:11px; font-weight:600; }
    .editor-count { border:1px solid #dfe3e8; border-top:0; border-radius:0 0 5px 5px; padding:3px 8px; text-align:right; color:#84909c; font-size:10px; }
    .job-wide { grid-column:1 / -1; }
    .salary-inputs { display:flex; gap:10px; max-width:310px; margin-top:8px; }
    .salary-inputs input { width:50%; }
    .range-row { display:flex; gap:10px; align-items:center; }
    .range-row input[type=range] { width:100%; accent-color:#888; }
    .switch-line { display:flex; align-items:center; gap:10px; margin-top:8px; color:#626d78; font-size:12px; }
    .switch-line input { accent-color:#087bea; }
    .location-radio { display:flex; gap:16px; align-items:center; min-height:40px; font-size:13px; }
    .location-radio label { margin:0; }
    .section-toggle { border-top:1px solid #eef0f3; margin-top:26px; padding-top:22px; }
    .section-toggle summary { cursor:pointer; list-style:none; font-size:18px; color:#172b3a; }
    .section-toggle summary::-webkit-details-marker { display:none; }
    .section-toggle summary:after { content:"›"; font-size:23px; margin-left:9px; }
    .section-toggle[open] summary:after { content:"⌄"; }
    .optional-content { padding-top:20px; }
    .criteria-box { border:1px solid #e7ebf0; border-radius:5px; padding:18px; margin-top:18px; }
    .criteria-title { font-size:16px; margin:0 0 15px; }
    .question-card { border:1px solid #e2e7ed; border-radius:6px; padding:16px; margin-bottom:14px; background:#fff; }
    .question-head { display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; }
    .question-number { font-weight:600; color:#263747; }
    .remove-question { border:0; background:#fff1f1; color:#d33; border-radius:4px; padding:5px 9px; font-size:12px; }
    .question-options { margin-top:12px; }
    .question-option-row { display:flex; gap:8px; margin:7px 0; }
    .question-option-row input { flex:1; }
    .add-option { border:0; background:none; color:#087bea; font-size:12px; padding:5px 0; }
    .job-actions { display:flex; justify-content:flex-end; gap:18px; border-top:1px solid #f0f2f5; padding-top:22px; margin-top:28px; }
    .btn-job { border:1px solid #1680f8; background:#1680f8; color:#fff; border-radius:6px; padding:10px 23px; font-size:12px; min-width:112px; }
    .btn-job.secondary { color:#1680f8; background:#fff; }
    .btn-job:disabled { opacity:.45; cursor:not-allowed; }
    .step-panel { display:none; }
    .step-panel.active { display:block; }
    .matching-checks { display:grid; grid-template-columns:repeat(2,1fr); gap:12px; font-size:13px; }
    .matching-checks label { color:#43515e; }
    @media(max-width:900px) { .job-grid { grid-template-columns:1fr; } .job-wide { grid-column:auto; } .job-card { padding:18px 15px; } .job-field { grid-template-columns:1fr; gap:5px; } .job-steps { margin-bottom:35px; } }
    @media(max-width:520px) { .job-create-page { padding:15px 8px; } .job-heading { font-size:23px; } .job-step { font-size:9px; } .job-actions { gap:8px; } .btn-job { min-width:0; padding:9px 14px; } .matching-checks { grid-template-columns:1fr; } }

    .job-create-page {
        box-sizing:border-box;
        background:
            radial-gradient(ellipse at 12% 0%, rgba(22,128,248,.08), transparent 34%),
            #f5f8fc;
        padding:42px 24px 56px;
    }
    .job-create-page *,
    .job-create-page *:before,
    .job-create-page *:after { box-sizing:border-box; }
    .job-create-wrap { max-width:1120px; }
    .job-heading { color:#172b3a; font-size:30px; letter-spacing:-.7px; margin-bottom:5px; }
    .job-breadcrumb { font-size:12px; margin-bottom:24px; }
    .job-card {
        border:1px solid #e6ecf3;
        border-radius:16px;
        padding:30px 34px 32px;
        box-shadow:0 14px 40px rgba(34,58,86,.07);
    }
    .job-card-title {
        border-bottom:1px solid #edf1f6;
        color:#243b53;
        font-size:17px;
        font-weight:600;
        margin:-2px 0 25px;
        padding-bottom:18px;
    }
    .job-card-title a { align-items:center; display:inline-flex; }
    .job-card-title a:hover { color:#087bea; }
    .job-steps {
        background:#f7f9fc;
        border:1px solid #edf1f6;
        border-radius:12px;
        margin-bottom:30px;
        max-width:780px;
        padding:18px 12px 14px;
    }
    .job-step { color:#8a97a6; font-size:12px; font-weight:500; }
    .job-step:not(:last-child):after { background:#dce4ee; top:14px; }
    .job-step.done:not(:last-child):after,
    .job-step.active:not(:last-child):after { background:#1680f8; }
    .job-step-circle {
        background:#d4dce6;
        box-shadow:0 0 0 4px #f7f9fc;
        height:28px;
        margin-bottom:10px;
        width:28px;
    }
    .job-step.active .job-step-circle,
    .job-step.done .job-step-circle { background:#1680f8; }
    .job-step.active { color:#1e3a5f; font-weight:700; }
    .required-note {
        background:#f5f9ff;
        border:1px solid #e4efff;
        border-left:3px solid #1680f8;
        border-radius:7px;
        color:#617287;
        font-size:12px;
        margin-bottom:22px;
        padding:11px 14px;
    }
    .job-grid { column-gap:30px; row-gap:24px; }
    .job-field { align-items:center; }
    .field-label { color:#34495e; font-size:13px; font-weight:600; }
    .field-help { color:#8290a0; font-size:11px; }
    .job-control,
    .job-select {
        background-color:#fff;
        border:1px solid #dce4ed;
        border-radius:8px;
        color:#25364a;
        font-size:13px;
        height:44px;
        transition:border-color .18s ease, box-shadow .18s ease;
    }
    .job-control:hover,
    .job-select:hover { border-color:#b9c9dc; }
    .job-control:focus,
    .job-select:focus,
    .job-textarea:focus {
        border-color:#1680f8;
        box-shadow:0 0 0 3px rgba(22,128,248,.12);
    }
    .job-control::placeholder { color:#a0acb9; }
    .range-row input[type=range] { accent-color:#1680f8; }
    .switch-line { color:#64748b; font-size:12px; }
    .switch-line input,
    .location-radio input,
    .matching-checks input { accent-color:#1680f8; }
    .location-radio { color:#526275; }
    .location-radio label { cursor:pointer; }
    .location-picker { position:relative; }
    .location-picker-toggle { align-items:center; cursor:pointer; display:flex; justify-content:space-between; text-align:left; }
    .picker-count { color:#8290a0; font-size:11px; margin-left:8px; white-space:nowrap; }
    .location-picker-panel {
        background:#fff;
        border:1px solid #dce4ed;
        border-radius:8px;
        box-shadow:0 10px 24px rgba(34,58,86,.12);
        left:0;
        max-height:220px;
        overflow:auto;
        padding:8px;
        position:absolute;
        right:0;
        top:calc(100% + 5px);
        z-index:5;
    }
    .location-picker-panel[hidden],
    .location-picker-panel label[hidden] { display:none; }
    .location-picker-panel label {
        align-items:center;
        border-radius:5px;
        color:#526275;
        cursor:pointer;
        display:flex;
        font-size:12px;
        gap:8px;
        margin:0;
        padding:7px 8px;
    }
    .location-picker-panel label:hover { background:#f3f8ff; }
    .location-picker-panel input { accent-color:#1680f8; margin:0; }
    .location-picker-panel .location-picker-search { accent-color:auto; height:36px; margin-bottom:5px; }
    .location-picker-error { color:#d33; display:block; font-size:11px; margin-top:5px; }
    .job-textarea {
        background:#fff;
        border-color:#dce4ed;
        border-radius:0 0 8px 8px;
        color:#334155;
        line-height:1.6;
        min-height:180px;
    }
    .job-textarea[aria-invalid="true"] { border-color:#d33; box-shadow:0 0 0 2px rgba(211,51,51,.1); }
    .editor-toolbar {
        background:#f8fafc;
        border-color:#dce4ed;
        border-radius:8px 8px 0 0;
        color:#526275;
    }
    .editor-toolbar button:not(.ai-btn):hover { color:#087bea; }
    .editor-count {
        background:#f8fafc;
        border-color:#dce4ed;
        border-radius:0 0 8px 8px;
        color:#8290a0;
        padding:6px 10px;
    }
    .section-toggle {
        background:#fbfcfe;
        border:1px solid #e8edf4;
        border-radius:10px;
        margin-top:28px;
        padding:17px 18px;
    }
    .section-toggle summary {
        color:#2b4056;
        font-size:14px;
        font-weight:600;
    }
    .section-toggle summary:after { color:#1680f8; float:right; }
    .optional-content { padding-top:22px; }
    .criteria-box {
        background:#f8fafc;
        border-color:#e5ebf2;
        border-radius:9px;
    }
    .job-card [role="status"] { background:#f0fbf4; border-color:#ccebd7; color:#17683a; }
    .job-card [role="alert"] { background:#fff6f6; border-color:#f5d6d6; color:#842029; }
    .criteria-title { color:#2b4056; font-size:14px; font-weight:600; }
    .matching-checks { color:#526275; }
    .matching-checks label { cursor:pointer; }
    .question-card {
        background:#fbfcfe;
        border-color:#e3eaf2;
        border-radius:10px;
        padding:20px;
    }
    .question-number { color:#2b4056; font-size:14px; }
    .remove-question { cursor:pointer; padding:7px 11px; transition:background .18s ease; }
    .remove-question:hover { background:#ffe3e3; }
    .question-options { border-top:1px solid #e8edf4; padding-top:14px; }
    .add-option { cursor:pointer; font-weight:600; }
    .job-actions {
        background:linear-gradient(180deg, rgba(255,255,255,0), #fff 20%);
        border-top-color:#e9eef4;
        gap:10px;
        margin-top:30px;
        padding-top:20px;
    }
    .btn-job {
        border-radius:8px;
        cursor:pointer;
        font-size:13px;
        font-weight:600;
        min-height:42px;
        transition:background .18s ease, border-color .18s ease, box-shadow .18s ease, transform .18s ease;
    }
    .btn-job:not(:disabled):hover {
        box-shadow:0 5px 12px rgba(22,128,248,.18);
        transform:translateY(-1px);
    }
    .btn-job.secondary { border-color:#d7e1ed; color:#40566e; }
    .btn-job.secondary:hover { background:#f5f9ff; border-color:#b7d4f7; color:#087bea; }
    .step-panel { animation:job-panel-in .2s ease-out; }
    @keyframes job-panel-in {
        from { opacity:.55; transform:translateY(4px); }
        to { opacity:1; transform:translateY(0); }
    }
    @media(max-width:900px) {
        .job-create-page { padding:30px 18px 40px; }
        .job-card { padding:24px 22px; }
        .job-grid { row-gap:20px; }
    }
    @media(max-width:520px) {
        .job-create-page { padding:22px 10px 32px; }
        .job-heading { font-size:25px; }
        .job-card { border-radius:12px; padding:20px 14px; }
        .job-card-title { margin-bottom:20px; }
        .job-steps { padding:15px 5px 12px; }
        .job-step { font-size:10px; }
        .job-step-circle { height:25px; width:25px; }
        .job-actions { flex-wrap:wrap; justify-content:stretch; }
        .job-actions .btn-job { flex:1 1 calc(50% - 8px); }
        .question-card { padding:14px; }
    }
</style>
@endpush

@section('content')
<div class="job-create-page">
    <div class="job-create-wrap">
        <h1 class="job-heading">Job Post</h1>
        <div class="job-breadcrumb">Home&nbsp; / &nbsp;<span>Job Post</span></div>

        <div class="job-card">
            <div class="job-card-title"><a href="{{ url()->previous() }}">←&nbsp; Post A New Job</a></div>

            @if(session('success'))
                <div class="criteria-box" role="status">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="criteria-box" role="alert">
                    <strong>Please review the following fields:</strong>
                    <ul style="margin:8px 0 0;padding-left:20px">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="job-steps" aria-label="Job posting progress">
                <div class="job-step active" data-step-indicator="1"><div class="job-step-circle">1</div>Job Information</div>
                <div class="job-step" data-step-indicator="2"><div class="job-step-circle">2</div>Candidate Requirements</div>
                <div class="job-step" data-step-indicator="3"><div class="job-step-circle">3</div>Add Questions</div>
            </div>

            <form id="jobPostForm" method="POST" action="{{ route('admin.career.store') }}">
                @csrf

                {{-- STEP 1 --}}
                <section class="step-panel active" data-step="1">
                    <div class="required-note"><b>*</b> Indicates a required field</div>
                    <div class="job-grid">
                        <div class="job-field">
                            <div class="field-label">Job Title <span class="required">*</span><small class="field-help">Add position name</small></div>
                            <input class="job-control" name="title" value="{{ old('title') }}" maxlength="125" placeholder="e.g. Sales Executive" required>
                        </div>
                        <div class="job-field">
                            <div class="field-label">Application Deadline <span class="required">*</span><small class="field-help">Select date from calendar</small></div>
                            <input class="job-control" type="date" name="application_deadline" min="{{ date('Y-m-d') }}" value="{{ old('application_deadline') }}" required>
                        </div>
                        <div class="job-field">
                            <div class="field-label">No of Vacancies <span class="required">*</span><small class="field-help">Mention number of applicants going to be hired</small></div>
                            <div>
                                <input class="job-control" type="number" name="vacancies" min="1" max="100" value="{{ old('vacancies', 0) }}" required>
                                <label class="switch-line"><input type="checkbox" name="vacancies_open" value="1" {{ old('vacancies_open') ? 'checked' : '' }}> Show vacancies as Open positions</label>
                            </div>
                        </div>
                        <div class="job-field">
                            <div class="field-label">Job Category <span class="required">*</span><small class="field-help">Choose job category from dropdown</small></div>
                            <select class="job-select" name="job_category" required>
                                <option value="">Select Job Type</option>
                                @foreach($jobCategories as $category)
                                    <option value="{{ $category }}" {{ old('job_category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="job-field">
                            <div class="field-label">Salary <span class="required">*</span><small class="field-help">Use slider or insert amount in the box</small></div>
                            <div>
                                <div class="range-row"><input type="range" id="salaryMinRange" min="1000" max="500000" step="500" value="{{ old('salary_min', 1000) }}"><input type="range" id="salaryMaxRange" min="1000" max="500000" step="500" value="{{ old('salary_max', 200000) }}"></div>
                                <div class="salary-inputs">
                                    <input class="job-control" type="number" id="salaryMin" name="salary_min" min="1000" max="500000" step="500" value="{{ old('salary_min', 1000) }}" required>
                                    <input class="job-control" type="number" id="salaryMax" name="salary_max" min="1000" max="500000" step="500" value="{{ old('salary_max', 200000) }}" required>
                                </div>
                                <label class="switch-line"><input type="checkbox" name="salary_negotiable" value="1" {{ old('salary_negotiable') ? 'checked' : '' }}> Show salary as Negotiable</label>
                            </div>
                        </div>
                        <div class="job-field job-wide">
                            <div class="field-label">Job Responsibilities <span class="required">*</span><small class="field-help">Add job responsibilities</small></div>
                            <div>
                                <div class="editor-toolbar"><button type="button" data-command="bold"><b>B</b></button><button type="button" data-command="italic"><i>I</i></button><button type="button" data-command="underline"><u>U</u></button><button type="button" data-command="strikeThrough">S</button><button type="button" data-command="insertUnorderedList">☷</button><button type="button" data-command="insertOrderedList">☷</button><button type="button" class="ai-btn" onclick="alert('AI writing assistant can be connected here.')">Generate with AI ✨</button></div>
                                <div class="job-textarea" contenteditable="true" data-editor="responsibilities" data-required="true" role="textbox" aria-label="Job Responsibilities" aria-multiline="true" style="min-height:260px"></div>
                                <div class="editor-count"><span data-count="responsibilities">0</span> words</div>
                                <span class="location-picker-error" data-editor-error="responsibilities" hidden>Job responsibilities are required.</span>
                                <textarea name="responsibilities" id="responsibilities" hidden>{{ old('responsibilities') }}</textarea>
                            </div>
                        </div>
                        <div class="job-field">
                            <div class="field-label">Location Type<small class="field-help">Choose an option</small></div>
                            <div class="location-radio">
                                <label><input type="radio" name="location_type" value="local" {{ old('location_type', 'local') === 'local' ? 'checked' : '' }}> Local</label>
                                <label><input type="radio" name="location_type" value="overseas" {{ old('location_type') === 'overseas' ? 'checked' : '' }}> Overseas</label>
                            </div>
                        </div>
                        <div></div>
                        <div class="job-field">
                            <div class="field-label">Job Location Division <span class="required">*</span><small class="field-help">Choose division from dropdown</small></div>
                            <div class="location-picker" data-location-picker="division">
                                <button type="button" class="job-select location-picker-toggle" aria-expanded="false">
                                    <span data-picker-label>Select Division</span><span class="picker-count" data-picker-count>0/5</span>
                                </button>
                                <div class="location-picker-panel" hidden>
                                    <input type="search" class="job-control location-picker-search" placeholder="Search divisions..." aria-label="Search divisions">
                                    @foreach($divisions as $division)
                                        <label><input type="checkbox" name="division_names[]" value="{{ $division }}" {{ in_array($division, (array) old('division_names', []), true) ? 'checked' : '' }}> {{ $division }}</label>
                                    @endforeach
                                </div>
                                <span class="location-picker-error" data-location-error hidden>Select at least one division (up to 5).</span>
                            </div>
                        </div>
                        <div class="job-field">
                            <div class="field-label">Job Location Area <span class="required">*</span><small class="field-help">Choose area from dropdown</small></div>
                            <div class="location-picker" data-location-picker="area">
                                <button type="button" class="job-select location-picker-toggle" aria-expanded="false">
                                    <span data-picker-label>Select Area</span><span class="picker-count" data-picker-count>0/5</span>
                                </button>
                                <div class="location-picker-panel" hidden>
                                    <input type="search" class="job-control location-picker-search" placeholder="Search areas..." aria-label="Search areas">
                                    @foreach($areas as $area)
                                        <label data-division="{{ $area->division_name }}"><input type="checkbox" name="area_ids[]" value="{{ $area->id }}" {{ in_array($area->id, (array) old('area_ids', [])) ? 'checked' : '' }}> {{ $area->name }}</label>
                                    @endforeach
                                </div>
                                <span class="location-picker-error" data-location-error hidden>Select at least one area (up to 5).</span>
                            </div>
                        </div>
                    </div>

                    <details class="section-toggle">
                        <summary>Optional Information</summary>
                        <div class="optional-content job-grid">
                            <div class="job-field"><div class="field-label">Department</div><input class="job-control" name="department" value="{{ old('department') }}" placeholder="e.g. Sales"></div>
                            <div class="job-field"><div class="field-label">Employment Type</div><select class="job-select" name="employment_type"><option value="">Select employment type</option><option {{ old('employment_type') === 'Full-time' ? 'selected' : '' }}>Full-time</option><option {{ old('employment_type') === 'Part-time' ? 'selected' : '' }}>Part-time</option><option {{ old('employment_type') === 'Contractual' ? 'selected' : '' }}>Contractual</option><option {{ old('employment_type') === 'Internship' ? 'selected' : '' }}>Internship</option><option {{ old('employment_type') === 'Temporary' ? 'selected' : '' }}>Temporary</option></select></div>
                            <div class="job-field"><div class="field-label">Workplace Type</div><select class="job-select" name="workplace_type"><option value="">Select workplace type</option><option {{ old('workplace_type') === 'On-site' ? 'selected' : '' }}>On-site</option><option {{ old('workplace_type') === 'Remote' ? 'selected' : '' }}>Remote</option><option {{ old('workplace_type') === 'Hybrid' ? 'selected' : '' }}>Hybrid</option></select></div>
                            <div class="job-field"><div class="field-label">Benefits</div><input class="job-control" name="benefits" value="{{ old('benefits') }}" placeholder="e.g. Festival bonus, insurance"></div>
                            <div class="job-field"><div class="field-label">Company Website</div><input class="job-control" type="url" name="company_website" value="{{ old('company_website') }}" placeholder="https://"></div>
                        </div>
                    </details>
                </section>

                {{-- STEP 2 --}}
                <section class="step-panel" data-step="2">
                    <div class="required-note"><b>*</b> Indicates a required field</div>
                    <div class="job-grid">
                        <div class="job-field"><div class="field-label">Gender <span class="required">*</span><small class="field-help">Choose gender from dropdown</small></div><select class="job-select" name="gender" required><option value="both" {{ old('gender', 'both') === 'both' ? 'selected' : '' }}>Both</option><option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option><option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option><option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other</option></select></div>
                        <div class="job-field"><div class="field-label">Is CV Required? <span class="required">*</span><small class="field-help">Choose an option</small></div><div class="location-radio"><label><input type="radio" name="cv_required" value="1" {{ old('cv_required', '1') === '1' ? 'checked' : '' }}> Yes</label><label><input type="radio" name="cv_required" value="0" {{ old('cv_required') === '0' ? 'checked' : '' }}> No</label></div></div>
                        <div class="job-field"><div class="field-label">Education <span class="required">*</span><small class="field-help">Minimum educational qualification</small></div><select class="job-select" name="education" required><option value="">Select Education</option><option {{ old('education') === 'Below SSC' ? 'selected' : '' }}>Below SSC</option><option {{ old('education') === 'SSC' ? 'selected' : '' }}>SSC</option><option {{ old('education') === 'HSC' ? 'selected' : '' }}>HSC</option><option {{ old('education') === 'Diploma' ? 'selected' : '' }}>Diploma</option><option {{ old('education') === "Bachelor's" ? 'selected' : '' }}>Bachelor's</option><option {{ old('education') === "Master's" ? 'selected' : '' }}>Master's</option><option {{ old('education') === 'PhD' ? 'selected' : '' }}>PhD</option></select></div>
                        <div class="job-field"><div class="field-label">Years of Experience <span class="required">*</span><small class="field-help">Minimum work experience needed for this position</small></div><select class="job-select" name="experience" required><option value="">Select Experience</option><option {{ old('experience') === 'Freshers' ? 'selected' : '' }}>Freshers</option><option {{ old('experience') === 'Less than 1 year' ? 'selected' : '' }}>Less than 1 year</option><option {{ old('experience') === '1-2 years' ? 'selected' : '' }}>1-2 years</option><option {{ old('experience') === '3-5 years' ? 'selected' : '' }}>3-5 years</option><option {{ old('experience') === '5-8 years' ? 'selected' : '' }}>5-8 years</option><option {{ old('experience') === '8+ years' ? 'selected' : '' }}>8+ years</option></select></div>
                        <div class="job-field"><div class="field-label">Age <span class="required">*</span><small class="field-help">Use slider or insert amount in the box</small></div><div><div class="range-row"><input type="range" id="ageMinRange" min="14" max="70" value="{{ old('age_min', 18) }}"><input type="range" id="ageMaxRange" min="14" max="70" value="{{ old('age_max', 65) }}"></div><div class="salary-inputs"><input class="job-control" type="number" id="ageMin" name="age_min" min="14" max="70" value="{{ old('age_min', 18) }}" required><input class="job-control" type="number" id="ageMax" name="age_max" min="14" max="70" value="{{ old('age_max', 65) }}" required></div></div></div>
                        <div class="job-field job-wide"><div class="field-label">Requirements<small class="field-help">Mention good to have requirements e.g. presentation skills, Problem-Solving Skills, etc.</small></div><div><div class="editor-toolbar"><button type="button" data-command="bold"><b>B</b></button><button type="button" data-command="italic"><i>I</i></button><button type="button" data-command="underline"><u>U</u></button><button type="button" data-command="insertUnorderedList">☷</button><button type="button" class="ai-btn" onclick="alert('AI writing assistant can be connected here.')">Generate with AI ✨</button></div><div class="job-textarea" contenteditable="true" data-editor="requirements" style="min-height:260px"></div><div class="editor-count"><span data-count="requirements">0</span> words</div><textarea name="requirements" id="requirements" hidden>{{ old('requirements') }}</textarea></div></div>
                    </div>

                    <details class="section-toggle">
                        <summary>Applicant Matching Criteria</summary>
                        <div class="criteria-box">
                            <p class="criteria-title">Select criteria to help match applicants with this job</p>
                            <div class="matching-checks">
                                <label><input type="checkbox" name="matching_criteria[]" value="education" {{ in_array('education', (array) old('matching_criteria', []), true) ? 'checked' : '' }}> Education match</label>
                                <label><input type="checkbox" name="matching_criteria[]" value="experience" {{ in_array('experience', (array) old('matching_criteria', []), true) ? 'checked' : '' }}> Experience match</label>
                                <label><input type="checkbox" name="matching_criteria[]" value="skills" {{ in_array('skills', (array) old('matching_criteria', []), true) ? 'checked' : '' }}> Skills match</label>
                                <label><input type="checkbox" name="matching_criteria[]" value="location" {{ in_array('location', (array) old('matching_criteria', []), true) ? 'checked' : '' }}> Location match</label>
                                <label><input type="checkbox" name="matching_criteria[]" value="age" {{ in_array('age', (array) old('matching_criteria', []), true) ? 'checked' : '' }}> Age criteria</label>
                                <label><input type="checkbox" name="matching_criteria[]" value="gender" {{ in_array('gender', (array) old('matching_criteria', []), true) ? 'checked' : '' }}> Gender criteria</label>
                            </div>
                        </div>
                    </details>
                </section>

                {{-- STEP 3 --}}
                <section class="step-panel" data-step="3">
                    <div class="required-note">Add screening questions to understand whether applicants meet the job requirements. These questions will appear in the application form.</div>
                    <div id="questionList">
                        @php($formQuestions = old('questions') ?: [['question' => '', 'type' => 'text', 'required' => '1', 'options' => ['', '']]])
                        @foreach($formQuestions as $index => $question)
                            @php($question = is_array($question) ? $question : [])
                            <div class="question-card" data-question data-index="questions[{{ $index }}]">
                                <div class="question-head"><span class="question-number">Question {{ $loop->iteration }}</span><button type="button" class="remove-question" data-remove-question>Remove</button></div>
                                <div class="job-grid">
                                    <div class="job-field job-wide"><div class="field-label">Question <span class="required">*</span><small class="field-help">Write a question for the applicant</small></div><input class="job-control" name="questions[{{ $index }}][question]" value="{{ $question['question'] ?? '' }}" placeholder="e.g. How many years of relevant experience do you have?" required></div>
                                    <div class="job-field"><div class="field-label">Answer Type <span class="required">*</span></div><select class="job-select" name="questions[{{ $index }}][type]" data-question-type><option value="text" {{ ($question['type'] ?? 'text') === 'text' ? 'selected' : '' }}>Short answer</option><option value="textarea" {{ ($question['type'] ?? '') === 'textarea' ? 'selected' : '' }}>Long answer</option><option value="yes_no" {{ ($question['type'] ?? '') === 'yes_no' ? 'selected' : '' }}>Yes / No</option><option value="single_choice" {{ ($question['type'] ?? '') === 'single_choice' ? 'selected' : '' }}>Single choice</option><option value="multiple_choice" {{ ($question['type'] ?? '') === 'multiple_choice' ? 'selected' : '' }}>Multiple choice</option><option value="number" {{ ($question['type'] ?? '') === 'number' ? 'selected' : '' }}>Number</option></select></div>
                                    <div class="job-field"><div class="field-label">Required?</div><div class="location-radio"><label><input type="checkbox" name="questions[{{ $index }}][required]" value="1" {{ !empty($question['required']) ? 'checked' : '' }}> Applicant must answer</label></div></div>
                                </div>
                                @php($questionOptions = is_array($question['options'] ?? null) ? $question['options'] : ['', ''])
                                @if(count($questionOptions) < 2)
                                    @php($questionOptions = array_pad($questionOptions, 2, ''))
                                @endif
                                <div class="question-options" {{ !in_array($question['type'] ?? 'text', ['single_choice', 'multiple_choice']) ? 'hidden' : '' }}>
                                    <label class="field-label">Answer Options</label>
                                    <div class="question-option-list">
                                        @foreach($questionOptions as $option)
                                            <div class="question-option-row"><input class="job-control" name="questions[{{ $index }}][options][]" value="{{ $option }}" placeholder="Option {{ $loop->iteration }}"></div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="add-option">+ Add option</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn-job secondary" id="addQuestion">+ Add Another Question</button>
                    <div class="criteria-box" style="margin-top:22px">
                        <p class="criteria-title">Application form preview</p>
                        <p style="font-size:13px;color:#687482;margin:0">Applicants will see your job details, CV requirement and the screening questions configured above when they apply.</p>
                    </div>
                </section>

                <div class="job-actions">
                    <button type="button" class="btn-job secondary" id="previousStep" style="display:none">Back</button>
                    <button type="button" class="btn-job secondary" id="cancelJob" onclick="window.history.back()">Cancel</button>
                    <button type="button" class="btn-job" id="nextStep">Save &amp; Continue</button>
                    <button type="submit" class="btn-job" id="publishJob" style="display:none">Submit Job</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('page_scripts')
<script>
(function () {
    const form = document.getElementById('jobPostForm');
    if (!form) return;
    let currentStep = 1;
    const panels = [...document.querySelectorAll('.step-panel')];
    const indicators = [...document.querySelectorAll('[data-step-indicator]')];
    const next = document.getElementById('nextStep');
    const previous = document.getElementById('previousStep');
    const publish = document.getElementById('publishJob');
    form.noValidate = true;

    function showStep(step) {
        currentStep = step;
        panels.forEach(panel => panel.classList.toggle('active', Number(panel.dataset.step) === step));
        indicators.forEach(item => {
            const n = Number(item.dataset.stepIndicator);
            item.classList.toggle('active', n === step);
            item.classList.toggle('done', n < step);
            item.querySelector('.job-step-circle').textContent = n < step ? '✓' : n;
        });
        previous.style.display = step === 1 ? 'none' : 'inline-block';
        next.style.display = step === 3 ? 'none' : 'inline-block';
        publish.style.display = step === 3 ? 'inline-block' : 'none';
        document.querySelector('.job-card').scrollIntoView({behavior:'smooth', block:'start'});
    }
    function syncEditors() {
        document.querySelectorAll('[data-editor]').forEach(editor => {
            const name = editor.dataset.editor;
            const hidden = document.getElementById(name);
            if (hidden) hidden.value = editor.innerHTML;
            const text = editor.innerText.trim();
            const words = text ? text.split(/\s+/).length : 0;
            const counter = document.querySelector('[data-count="' + name + '"]');
            if (counter) counter.textContent = words;
            if (text) {
                editor.setAttribute('aria-invalid', 'false');
                const error = document.querySelector('[data-editor-error="' + name + '"]');
                if (error) error.hidden = true;
            }
        });
    }
    document.querySelectorAll('[data-editor]').forEach(editor => {
        editor.addEventListener('input', syncEditors);
        const hidden = document.getElementById(editor.dataset.editor);
        if (hidden && hidden.value) editor.innerHTML = hidden.value;
    });
    syncEditors();
    document.querySelectorAll('[data-command]').forEach(button => {
        button.addEventListener('click', () => {
            const editor = button.closest('.job-field').querySelector('[data-editor]');
            if (editor) { editor.focus(); document.execCommand(button.dataset.command, false, null); syncEditors(); }
        });
    });

    function updateRangeValidity() {
        const salaryMin = document.getElementById('salaryMin');
        const salaryMax = document.getElementById('salaryMax');
        const ageMin = document.getElementById('ageMin');
        const ageMax = document.getElementById('ageMax');
        salaryMin.setCustomValidity(Number(salaryMin.value) > Number(salaryMax.value)
            ? 'Start salary must be between 1000 and less than or equal to end salary.'
            : '');
        ageMin.setCustomValidity(Number(ageMin.value) > Number(ageMax.value)
            ? 'Minimum age must be less than or equal to maximum age.'
            : '');
    }
    ['salaryMin', 'salaryMax', 'ageMin', 'ageMax'].forEach(id => {
        document.getElementById(id).addEventListener('input', updateRangeValidity);
    });

    const divisionPicker = document.querySelector('[data-location-picker="division"]');
    const areaPicker = document.querySelector('[data-location-picker="area"]');
    function selectedPickerValues(picker) {
        return [...picker.querySelectorAll('input[type="checkbox"]:checked')].map(input => input.value);
    }
    function filterPickerOptions(picker) {
        const search = picker.querySelector('.location-picker-search').value.trim().toLowerCase();
        const divisionNames = selectedPickerValues(divisionPicker);
        picker.querySelectorAll('.location-picker-panel label').forEach(label => {
            const matchesDivision = picker !== areaPicker
                || !divisionNames.length
                || divisionNames.includes(label.dataset.division);
            const matchesSearch = label.textContent.toLowerCase().includes(search);
            label.hidden = !matchesDivision || !matchesSearch;
        });
    }
    function updatePicker(picker) {
        const selected = [...picker.querySelectorAll('input[type="checkbox"]:checked')];
        const label = picker.querySelector('[data-picker-label]');
        const count = picker.querySelector('[data-picker-count]');
        const error = picker.querySelector('[data-location-error]');
        label.textContent = selected.length
            ? selected.length === 1 ? selected[0].parentElement.textContent.trim() : selected[0].parentElement.textContent.trim() + ' +' + (selected.length - 1)
            : picker.dataset.locationPicker === 'division' ? 'Select Division' : 'Select Area';
        count.textContent = selected.length + '/5';
        if (selected.length) {
            error.hidden = true;
        } else {
            error.textContent = picker.dataset.locationPicker === 'division'
                ? 'Select at least one division (up to 5).'
                : 'Select at least one area (up to 5).';
        }
    }
    function refreshAreas() {
        const divisionNames = selectedPickerValues(divisionPicker);
        areaPicker.querySelectorAll('.location-picker-panel label').forEach(label => {
            const available = !divisionNames.length || divisionNames.includes(label.dataset.division);
            if (!available) label.querySelector('input').checked = false;
        });
        filterPickerOptions(areaPicker);
        updatePicker(areaPicker);
    }
    function bindPicker(picker, onChange) {
        const toggle = picker.querySelector('.location-picker-toggle');
        const panel = picker.querySelector('.location-picker-panel');
        toggle.addEventListener('click', () => {
            panel.hidden = !panel.hidden;
            toggle.setAttribute('aria-expanded', String(!panel.hidden));
        });
        picker.querySelector('.location-picker-search').addEventListener('input', () => filterPickerOptions(picker));
        picker.querySelector('.location-picker-search').addEventListener('keydown', event => {
            if (event.key === 'Enter') event.preventDefault();
        });
        picker.querySelectorAll('input[type="checkbox"]').forEach(input => {
            input.addEventListener('change', () => {
                const selected = picker.querySelectorAll('input[type="checkbox"]:checked');
                if (selected.length > 5) {
                    input.checked = false;
                    const error = picker.querySelector('[data-location-error]');
                    error.textContent = 'You can select up to five options.';
                    updatePicker(picker);
                    error.hidden = false;
                    if (onChange) onChange();
                    return;
                }
                updatePicker(picker);
                if (onChange) onChange();
            });
        });
        filterPickerOptions(picker);
        updatePicker(picker);
    }
    bindPicker(divisionPicker, refreshAreas);
    bindPicker(areaPicker);
    refreshAreas();
    document.addEventListener('click', event => {
        document.querySelectorAll('.location-picker').forEach(picker => {
            if (!picker.contains(event.target)) {
                picker.querySelector('.location-picker-panel').hidden = true;
                picker.querySelector('.location-picker-toggle').setAttribute('aria-expanded', 'false');
            }
        });
    });

    function validatePanel(panel, focusInvalid) {
        const required = [...panel.querySelectorAll('input[required], select[required], textarea[required]')];
        for (const field of required) {
            if (!field.checkValidity()) {
                if (focusInvalid !== false) field.reportValidity();
                return false;
            }
        }
        for (const editor of panel.querySelectorAll('[data-editor][data-required="true"]')) {
            if (!editor.innerText.trim()) {
                if (focusInvalid !== false) {
                    editor.setAttribute('aria-invalid', 'true');
                    const error = document.querySelector('[data-editor-error="' + editor.dataset.editor + '"]');
                    if (error) error.hidden = false;
                    editor.focus();
                }
                return false;
            }
        }
        for (const picker of panel.querySelectorAll('[data-location-picker]')) {
            if (!selectedPickerValues(picker).length) {
                if (focusInvalid !== false) {
                    picker.querySelector('[data-location-error]').hidden = false;
                    picker.querySelector('.location-picker-toggle').focus();
                }
                return false;
            }
        }
        return true;
    }

    next.addEventListener('click', () => {
        updateRangeValidity();
        const panel = document.querySelector('.step-panel[data-step="' + currentStep + '"]');
        if (!validatePanel(panel)) return;
        syncEditors();
        showStep(Math.min(3, currentStep + 1));
    });
    previous.addEventListener('click', () => showStep(Math.max(1, currentStep - 1)));
    form.addEventListener('submit', event => {
        syncEditors();
        updateRangeValidity();
        for (const panel of panels) {
            if (!validatePanel(panel, false)) {
                event.preventDefault();
                showStep(Number(panel.dataset.step));
                validatePanel(panel);
                return;
            }
        }
    });

    function bindRange(rangeId, inputId) {
        const range = document.getElementById(rangeId), input = document.getElementById(inputId);
        range.value = input.value;
        range.addEventListener('input', () => {
            input.value = range.value;
            updateRangeValidity();
        });
        input.addEventListener('input', () => {
            const min = Number(input.min || range.min), max = Number(input.max || range.max);
            range.value = Math.max(min, Math.min(max, Number(input.value || min)));
            updateRangeValidity();
        });
    }
    bindRange('salaryMinRange', 'salaryMin'); bindRange('salaryMaxRange', 'salaryMax');
    bindRange('ageMinRange', 'ageMin'); bindRange('ageMaxRange', 'ageMax');

    let questionIndex = Math.max(0, ...[...document.querySelectorAll('[data-question]')].map(card => {
        const match = card.dataset.index.match(/\d+/);
        return match ? Number(match[0]) + 1 : 0;
    }));
    function bindQuestion(card) {
        const type = card.querySelector('[data-question-type]');
        const options = card.querySelector('.question-options');
        type.addEventListener('change', () => {
            options.hidden = !['single_choice', 'multiple_choice'].includes(type.value);
        });
        card.querySelector('[data-remove-question]').addEventListener('click', () => {
            if (document.querySelectorAll('[data-question]').length > 1) { card.remove(); renumberQuestions(); }
        });
        card.querySelector('.add-option').addEventListener('click', () => {
            const list = card.querySelector('.question-option-list');
            const count = list.querySelectorAll('.question-option-row').length + 1;
            const row = document.createElement('div');
            row.className = 'question-option-row';
            row.innerHTML = '<input class="job-control" placeholder="Option ' + count + '">';
            list.appendChild(row);
            row.querySelector('input').name = card.dataset.index + '[options][]';
        });
    }
    function renumberQuestions() {
        document.querySelectorAll('[data-question]').forEach((card, i) => {
            card.querySelector('.question-number').textContent = 'Question ' + (i + 1);
        });
    }
    bindQuestion(document.querySelector('[data-question]'));
    document.getElementById('addQuestion').addEventListener('click', () => {
        const index = questionIndex++;
        const card = document.createElement('div');
        card.className = 'question-card'; card.dataset.question = ''; card.dataset.index = 'questions[' + index + ']';
        card.innerHTML = `
            <div class="question-head"><span class="question-number">Question ${index + 1}</span><button type="button" class="remove-question" data-remove-question>Remove</button></div>
            <div class="job-grid">
                <div class="job-field job-wide"><div class="field-label">Question <span class="required">*</span></div><input class="job-control" name="questions[${index}][question]" placeholder="Write your question" required></div>
                <div class="job-field"><div class="field-label">Answer Type <span class="required">*</span></div><select class="job-select" name="questions[${index}][type]" data-question-type><option value="text">Short answer</option><option value="textarea">Long answer</option><option value="yes_no">Yes / No</option><option value="single_choice">Single choice</option><option value="multiple_choice">Multiple choice</option><option value="number">Number</option></select></div>
                <div class="job-field"><div class="field-label">Required?</div><div class="location-radio"><label><input type="checkbox" name="questions[${index}][required]" value="1" checked> Applicant must answer</label></div></div>
            </div>
            <div class="question-options" hidden><label class="field-label">Answer Options</label><div class="question-option-list"><div class="question-option-row"><input class="job-control" name="questions[${index}][options][]" placeholder="Option 1"></div><div class="question-option-row"><input class="job-control" name="questions[${index}][options][]" placeholder="Option 2"></div></div><button type="button" class="add-option">+ Add option</button></div>`;
        document.getElementById('questionList').appendChild(card);
        bindQuestion(card); renumberQuestions();
    });
    showStep(1);
})();
</script>
@endpush
