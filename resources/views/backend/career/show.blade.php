@extends($shared ? 'layouts.career-share' : 'layouts.app')

@section('title', $careerPlan->title)

@push('page_css')
<style>
    .career-detail-page { background:#f4f7fb; min-height:calc(100vh - 60px); padding:32px 20px 48px; }
    .career-detail-wrap { margin:0 auto; max-width:1080px; }
    .career-detail-back { color:#1680f8; display:inline-flex; font-size:13px; font-weight:600; margin-bottom:18px; text-decoration:none; }
    .career-detail-back:hover { color:#0871e1; text-decoration:none; }
    .career-detail-hero,
    .career-detail-section {
        background:#fff;
        border:1px solid #e6ecf3;
        border-radius:12px;
        box-shadow:0 8px 26px rgba(34,58,86,.045);
    }
    .career-detail-hero { padding:26px 30px; }
    .career-detail-kicker { color:#8794a3; font-size:12px; margin-bottom:8px; }
    .career-detail-title { color:#26394d; font-size:26px; font-weight:700; line-height:1.3; margin:0; }
    .career-detail-subtitle { color:#748296; font-size:13px; margin-top:10px; }
    .career-detail-status { background:#e9f8ef; border-radius:20px; color:#21834b; display:inline-block; font-size:11px; font-weight:700; margin-top:16px; padding:6px 11px; text-transform:capitalize; }
    .career-detail-status.is-draft { background:#fff5df; color:#a66a00; }
    .career-detail-status.is-closed { background:#fff0f0; color:#c34242; }
    .career-detail-highlights { display:grid; gap:12px; grid-template-columns:repeat(4,1fr); margin-top:24px; }
    .career-highlight { background:#f7f9fc; border:1px solid #edf1f6; border-radius:8px; padding:13px 15px; }
    .career-highlight-label { color:#8390a0; display:block; font-size:10px; margin-bottom:5px; text-transform:uppercase; }
    .career-highlight-value { color:#34475c; font-size:13px; font-weight:650; }
    .career-detail-section { margin-top:16px; padding:22px 26px; }
    .career-detail-section h2 { border-bottom:1px solid #edf1f6; color:#293d52; font-size:16px; font-weight:700; margin:0 0 17px; padding-bottom:13px; }
    .career-detail-grid { display:grid; gap:18px 26px; grid-template-columns:repeat(2,minmax(0,1fr)); }
    .career-detail-item { min-width:0; }
    .career-detail-label { color:#8290a0; display:block; font-size:11px; margin-bottom:5px; }
    .career-detail-value { color:#394b60; font-size:13px; line-height:1.6; overflow-wrap:anywhere; }
    .career-detail-copy { color:#394b60; font-size:13px; line-height:1.75; overflow-wrap:anywhere; white-space:normal; }
    .career-detail-copy p { margin:0 0 8px; }
    .career-detail-copy[hidden] { display:none; }
    .career-question { background:#f8fafc; border:1px solid #edf1f6; border-radius:8px; margin-top:11px; padding:14px 15px; }
    .career-question:first-of-type { margin-top:0; }
    .career-question-title { color:#34475c; font-size:13px; font-weight:650; }
    .career-question-meta { color:#8290a0; font-size:11px; margin-top:6px; }
    .career-detail-share { background:#1680f8; border:0; border-radius:7px; color:#fff; cursor:pointer; font-size:12px; font-weight:600; padding:10px 15px; }
    .career-detail-share:hover { background:#0871e1; }
    .career-detail-share-status { color:#21834b; font-size:12px; margin-left:10px; }
    @media(max-width:720px) {
        .career-detail-page { padding:22px 12px 32px; }
        .career-detail-hero { padding:22px 18px; }
        .career-detail-title { font-size:22px; }
        .career-detail-highlights { grid-template-columns:repeat(2,1fr); }
        .career-detail-section { padding:19px 17px; }
        .career-detail-grid { gap:15px; grid-template-columns:1fr; }
    }
    @media(max-width:380px) { .career-detail-highlights { grid-template-columns:1fr; } }
</style>
@endpush

@section('content')
@php
    $applicationDeadline = !empty($data['application_deadline'])
        ? \Illuminate\Support\Carbon::parse($data['application_deadline'])->format('F d, Y')
        : 'Not specified';
    $salary = !empty($data['salary_negotiable'])
        ? 'Negotiable'
        : (isset($data['salary_min'], $data['salary_max'])
            ? 'TK. ' . number_format((int) $data['salary_min']) . ' - ' . number_format((int) $data['salary_max'])
            : 'Not specified');
    $responsibilities = preg_replace('/<\/(p|div|li|h[1-6])>/i', "\n", $data['responsibilities'] ?? '');
    $responsibilities = preg_replace('/<br\s*\/?>/i', "\n", $responsibilities);
    $responsibilities = trim(html_entity_decode(strip_tags($responsibilities), ENT_QUOTES, 'UTF-8'));
    $requirements = preg_replace('/<\/(p|div|li|h[1-6])>/i', "\n", $data['requirements'] ?? '');
    $requirements = preg_replace('/<br\s*\/?>/i', "\n", $requirements);
    $requirements = trim(html_entity_decode(strip_tags($requirements), ENT_QUOTES, 'UTF-8'));
    $companyWebsite = $data['company_website'] ?? '';
    $companyWebsiteUrl = preg_match('/^https?:\/\//i', $companyWebsite) ? $companyWebsite : null;
    $matchingLabels = [
        'education' => 'Education match',
        'experience' => 'Experience match',
        'skills' => 'Skills match',
        'location' => 'Location match',
        'age' => 'Age criteria',
        'gender' => 'Gender criteria',
    ];
@endphp
<main class="career-detail-page">
    <div class="career-detail-wrap">
        @if($shared)
            <a class="career-detail-back" href="{{ url('/') }}">Shared job posting</a>
        @else
            <a class="career-detail-back" href="{{ route('admin.career.index') }}">← Back to Job Post</a>
        @endif

        <section class="career-detail-hero">
            <div class="career-detail-kicker">Job #{{ $careerPlan->id }} · Posted {{ $careerPlan->created_at->format('F d, Y') }}</div>
            <h1 class="career-detail-title">{{ $careerPlan->title }}</h1>
            <div class="career-detail-subtitle">
                {{ $data['job_category'] ?? 'Category not specified' }}
                @if(!empty($data['department'])) · {{ $data['department'] }} @endif
            </div>
            <span class="career-detail-status {{ $careerPlan->status === 'draft' ? 'is-draft' : ($careerPlan->status === 'closed' ? 'is-closed' : '') }}">{{ $careerPlan->status }}</span>
            <div class="career-detail-highlights">
                <div class="career-highlight"><span class="career-highlight-label">Vacancies</span><span class="career-highlight-value">{{ !empty($data['vacancies_open']) ? 'Open positions' : ($data['vacancies'] ?? 'Not specified') }}</span></div>
                <div class="career-highlight"><span class="career-highlight-label">Salary</span><span class="career-highlight-value">{{ $salary }}</span></div>
                <div class="career-highlight"><span class="career-highlight-label">Deadline</span><span class="career-highlight-value">{{ $applicationDeadline }}</span></div>
                <div class="career-highlight"><span class="career-highlight-label">Location</span><span class="career-highlight-value">{{ !empty($data['area_names']) ? implode(', ', $data['area_names']) : 'Not specified' }}</span></div>
            </div>
        </section>

        <section class="career-detail-section">
            <h2>Job Information</h2>
            <div class="career-detail-grid">
                <div class="career-detail-item"><span class="career-detail-label">Job title</span><div class="career-detail-value">{{ $careerPlan->title }}</div></div>
                <div class="career-detail-item"><span class="career-detail-label">Category</span><div class="career-detail-value">{{ $data['job_category'] ?? 'Not specified' }}</div></div>
                <div class="career-detail-item"><span class="career-detail-label">Vacancies</span><div class="career-detail-value">{{ $data['vacancies'] ?? 'Not specified' }}{{ !empty($data['vacancies_open']) ? ' (Open positions)' : '' }}</div></div>
                <div class="career-detail-item"><span class="career-detail-label">Application deadline</span><div class="career-detail-value">{{ $applicationDeadline }}</div></div>
                <div class="career-detail-item"><span class="career-detail-label">Salary range</span><div class="career-detail-value">{{ $salary }}</div></div>
                <div class="career-detail-item"><span class="career-detail-label">Location type</span><div class="career-detail-value">{{ ucfirst($data['location_type'] ?? 'Not specified') }}</div></div>
                <div class="career-detail-item"><span class="career-detail-label">Divisions</span><div class="career-detail-value">{{ !empty($data['division_names']) ? implode(', ', $data['division_names']) : 'Not specified' }}</div></div>
                <div class="career-detail-item"><span class="career-detail-label">Areas / districts</span><div class="career-detail-value">{{ !empty($data['area_names']) ? implode(', ', $data['area_names']) : 'Not specified' }}</div></div>
                <div class="career-detail-item"><span class="career-detail-label">Employment type</span><div class="career-detail-value">{{ $data['employment_type'] ?? 'Not specified' }}</div></div>
                <div class="career-detail-item"><span class="career-detail-label">Workplace type</span><div class="career-detail-value">{{ $data['workplace_type'] ?? 'Not specified' }}</div></div>
                <div class="career-detail-item"><span class="career-detail-label">Department</span><div class="career-detail-value">{{ $data['department'] ?? 'Not specified' }}</div></div>
                <div class="career-detail-item"><span class="career-detail-label">Benefits</span><div class="career-detail-value">{{ $data['benefits'] ?? 'Not specified' }}</div></div>
                <div class="career-detail-item"><span class="career-detail-label">Company website</span><div class="career-detail-value">@if($companyWebsiteUrl)<a href="{{ $companyWebsiteUrl }}" target="_blank" rel="noopener noreferrer">{{ $companyWebsite }}</a>@elseif($companyWebsite){{ $companyWebsite }}@else Not specified @endif</div></div>
            </div>
        </section>

        <section class="career-detail-section">
            <h2>Job Responsibilities</h2>
            <div class="career-detail-copy">{!! $responsibilities !== '' ? nl2br(e($responsibilities)) : 'Not provided' !!}</div>
        </section>

        <section class="career-detail-section">
            <h2>Candidate Requirements</h2>
            <div class="career-detail-grid">
                <div class="career-detail-item"><span class="career-detail-label">Gender</span><div class="career-detail-value">{{ ucfirst($data['gender'] ?? 'Not specified') }}</div></div>
                <div class="career-detail-item"><span class="career-detail-label">CV required</span><div class="career-detail-value">{{ !empty($data['cv_required']) ? 'Yes' : 'No' }}</div></div>
                <div class="career-detail-item"><span class="career-detail-label">Education</span><div class="career-detail-value">{{ $data['education'] ?? 'Not specified' }}</div></div>
                <div class="career-detail-item"><span class="career-detail-label">Experience</span><div class="career-detail-value">{{ $data['experience'] ?? 'Not specified' }}</div></div>
                <div class="career-detail-item"><span class="career-detail-label">Age range</span><div class="career-detail-value">{{ isset($data['age_min'], $data['age_max']) ? $data['age_min'] . ' - ' . $data['age_max'] . ' years' : 'Not specified' }}</div></div>
                <div class="career-detail-item"><span class="career-detail-label">Matching criteria</span><div class="career-detail-value">
                    @php($criteria = collect($data['matching_criteria'] ?? [])->map(function ($criterion) use ($matchingLabels) { return $matchingLabels[$criterion] ?? null; })->filter()->all())
                    {{ $criteria ? implode(', ', $criteria) : 'Not specified' }}
                </div></div>
            </div>
            @if($requirements !== '')
                <h3 class="career-detail-label" style="font-size:12px;margin:20px 0 8px">Additional requirements</h3>
                <div class="career-detail-copy">{!! nl2br(e($requirements)) !!}</div>
            @endif
        </section>

        <section class="career-detail-section">
            <h2>Application Questions</h2>
            @forelse($data['questions'] ?? [] as $question)
                <div class="career-question">
                    <div class="career-question-title">{{ $question['question'] ?? 'Untitled question' }}</div>
                    <div class="career-question-meta">
                        Answer type: {{ str_replace('_', ' ', ucfirst($question['type'] ?? 'text')) }}
                        · {{ !empty($question['required']) ? 'Required' : 'Optional' }}
                        @if(!empty(array_filter($question['options'] ?? [])))
                            · Options: {{ implode(', ', array_filter($question['options'])) }}
                        @endif
                    </div>
                </div>
            @empty
                <div class="career-detail-value">No screening questions added.</div>
            @endforelse
        </section>

        @unless($shared)
            @unless($shared)
                <section class="career-detail-section">
                    <h2>Applications</h2>
                    <p class="career-detail-value">Review applicants and update their application status.</p>
                    <a class="career-detail-share" href="{{ route('admin.career.applications', $careerPlan) }}">
                        View applications ({{ $applicationsCount }})
                    </a>
                </section>
            @endunless

        @if(!$shared && $careerPlan->status === 'published')
            <section class="career-detail-section">
                <button type="button" class="career-detail-share" data-share-url="{{ \Illuminate\Support\Facades\URL::signedRoute('career.share', ['careerPlan' => $careerPlan->id]) }}">Share job</button>
                <span class="career-detail-share-status" role="status" aria-live="polite"></span>
            </section>
        @endif
    </div>
</main>
@endsection

@push('page_scripts')
<script>
    (function () {
        const button = document.querySelector('[data-share-url]');
        if (!button) return;

        button.addEventListener('click', async function () {
            const status = document.querySelector('.career-detail-share-status');
            let copied = false;

            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(button.dataset.shareUrl);
                    copied = true;
                } else {
                    const input = document.createElement('textarea');
                    input.value = button.dataset.shareUrl;
                    input.setAttribute('readonly', '');
                    input.style.position = 'fixed';
                    input.style.opacity = '0';
                    document.body.appendChild(input);
                    input.select();
                    copied = document.execCommand('copy');
                    input.remove();
                }
            } catch (error) {
                copied = false;
            }

            status.textContent = copied ? 'Share link copied.' : 'Copy this link: ' + button.dataset.shareUrl;
        });
    })();
</script>
@endpush
