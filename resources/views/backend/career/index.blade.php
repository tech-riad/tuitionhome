@extends('layouts.app')

@section('title', 'Job Post')

@push('page_css')
<style>
    .career-index {
        background:#f4f7fb;
        color:#243447;
        min-height:calc(100vh - 60px);
        padding:32px 24px 48px;
    }
    .career-index,
    .career-index * { box-sizing:border-box; }
    .career-index-wrap { margin:0 auto; max-width:1180px; }
    .career-index-header {
        align-items:center;
        display:flex;
        justify-content:space-between;
        margin-bottom:22px;
    }
    .career-index-title { color:#243447; font-size:26px; font-weight:700; margin:0 0 7px; }
    .career-breadcrumb { color:#8a97a6; font-size:13px; }
    .career-breadcrumb span { color:#1680f8; }
    .career-create-link {
        align-items:center;
        background:#1680f8;
        border:1px solid #1680f8;
        border-radius:7px;
        color:#fff;
        display:inline-flex;
        font-size:13px;
        font-weight:600;
        gap:8px;
        padding:11px 16px;
        text-decoration:none;
        transition:background .18s ease, box-shadow .18s ease;
    }
    .career-create-link:hover { background:#0871e1; box-shadow:0 5px 14px rgba(22,128,248,.2); color:#fff; }
    .career-list-card {
        background:#fff;
        border:1px solid #e6ecf3;
        border-radius:12px;
        box-shadow:0 8px 26px rgba(34,58,86,.045);
        overflow:hidden;
    }
    .career-list-toolbar {
        align-items:center;
        border-bottom:1px solid #edf1f6;
        display:flex;
        flex-wrap:wrap;
        gap:14px;
        justify-content:space-between;
        padding:17px 22px;
    }
    .career-list-heading { color:#26394d; font-size:16px; font-weight:650; margin:0; }
    .career-job-count {
        background:#edf5ff;
        border-radius:20px;
        color:#1680f8;
        font-size:11px;
        font-weight:600;
        margin-left:8px;
        padding:4px 9px;
        vertical-align:middle;
    }
    .career-search {
        background:#fff;
        border:1px solid #dfe6ee;
        border-radius:7px;
        color:#334155;
        font-size:13px;
        height:38px;
        max-width:270px;
        outline:none;
        padding:8px 12px;
        width:100%;
    }
    .career-search:focus { border-color:#1680f8; box-shadow:0 0 0 3px rgba(22,128,248,.1); }
    .career-job-list { padding:0 22px; }
    .career-job {
        border-bottom:1px solid #edf1f6;
        padding:19px 0;
    }
    .career-job:last-child { border-bottom:0; }
    .career-job-top {
        align-items:flex-start;
        display:flex;
        gap:16px;
        justify-content:space-between;
    }
    .career-job-main { min-width:0; }
    .career-job-actions { align-items:center; display:flex; gap:9px; position:relative; }
    .career-job-menu-toggle {
        align-items:center;
        background:#fff;
        border:1px solid #e1e7ef;
        border-radius:7px;
        color:#65758a;
        cursor:pointer;
        display:flex;
        font-size:19px;
        height:34px;
        justify-content:center;
        line-height:1;
        padding:0;
        width:38px;
    }
    .career-job-menu-toggle:hover,
    .career-job-menu-toggle[aria-expanded="true"] { background:#f4f8fd; border-color:#cddced; color:#1680f8; }
    .career-job-menu {
        background:#fff;
        border:1px solid #e5eaf0;
        border-radius:8px;
        box-shadow:0 10px 24px rgba(34,58,86,.14);
        min-width:150px;
        padding:5px;
        position:absolute;
        right:0;
        top:calc(100% + 6px);
        z-index:10;
    }
    .career-job-menu[hidden] { display:none; }
    .career-job-menu a,
    .career-job-menu button {
        background:none;
        border:0;
        border-radius:5px;
        color:#42546a;
        cursor:pointer;
        display:block;
        font:inherit;
        font-size:12px;
        padding:9px 10px;
        text-align:left;
        text-decoration:none;
        width:100%;
    }
    .career-job-menu a:hover,
    .career-job-menu button:hover { background:#f2f7fd; color:#087bea; }
    .career-share-status { color:#21834b; display:none; font-size:11px; margin-top:7px; text-align:right; }
    .career-job-title {
        color:#26394d;
        font-size:15px;
        font-weight:650;
        line-height:1.45;
        margin:0;
    }
    .career-job-id { color:#8794a3; font-size:11px; font-weight:500; margin-right:5px; }
    .career-job-status {
        background:#e9f8ef;
        border-radius:20px;
        color:#21834b;
        flex:0 0 auto;
        font-size:11px;
        font-weight:600;
        padding:5px 10px;
        text-transform:capitalize;
    }
    .career-job-status.is-draft { background:#fff5df; color:#a66a00; }
    .career-job-status.is-closed { background:#fff0f0; color:#c34242; }
    .career-job-meta {
        align-items:center;
        color:#728094;
        display:flex;
        flex-wrap:wrap;
        font-size:12px;
        gap:8px 18px;
        margin-top:12px;
    }
    .career-job-meta span { align-items:center; display:inline-flex; gap:6px; }
    .career-job-meta strong { color:#47586b; font-weight:600; }
    .career-job-footer {
        align-items:center;
        border-top:1px solid #f1f4f7;
        color:#8491a0;
        display:flex;
        flex-wrap:wrap;
        font-size:11px;
        gap:12px 20px;
        justify-content:space-between;
        margin-top:15px;
        padding-top:12px;
    }
    .career-job-footer a { color:#1680f8; font-weight:600; text-decoration:none; }
    .career-empty {
        padding:62px 20px;
        text-align:center;
    }
    .career-empty-icon {
        align-items:center;
        background:#edf5ff;
        border-radius:50%;
        color:#1680f8;
        display:flex;
        font-size:26px;
        height:58px;
        justify-content:center;
        margin:0 auto 15px;
        width:58px;
    }
    .career-empty h2 { color:#26394d; font-size:17px; font-weight:650; margin:0 0 7px; }
    .career-empty p { color:#7d8998; font-size:13px; margin:0 auto 18px; max-width:380px; }
    .career-no-results { color:#7d8998; display:none; font-size:13px; padding:30px 12px; text-align:center; }
    .career-pagination { border-top:1px solid #edf1f6; padding:14px 22px; }
    .career-pagination nav { display:flex; justify-content:flex-end; }
    @media(max-width:640px) {
        .career-index { padding:22px 12px 32px; }
        .career-index-header { align-items:flex-start; flex-direction:column; gap:15px; }
        .career-create-link { justify-content:center; width:100%; }
        .career-list-toolbar { align-items:stretch; padding:15px; }
        .career-search { max-width:none; }
        .career-job-list { padding:0 15px; }
        .career-job-top { flex-direction:column; gap:9px; }
        .career-pagination { padding:12px 15px; }
    }
</style>
@endpush

@section('content')
<main class="career-index">
    <div class="career-index-wrap">
        <header class="career-index-header">
            <div>
                <h1 class="career-index-title">Job Post</h1>
                <div class="career-breadcrumb">Home <span>/ &nbsp;Job Post</span></div>
            </div>
            <a class="career-create-link" href="{{ route('admin.career.create') }}">
                <span aria-hidden="true">+</span> Post A New Job
            </a>
        </header>

        @if(session('success'))
            <div class="alert alert-success" role="status">{{ session('success') }}</div>
        @endif

        <section class="career-list-card" aria-labelledby="career-list-heading">
            <div class="career-list-toolbar">
                <h2 class="career-list-heading" id="career-list-heading">
                    Job List <span class="career-job-count">{{ $careerPlans->total() }}</span>
                </h2>
                <input class="career-search" type="search" id="careerJobSearch" placeholder="Search jobs..." aria-label="Search jobs">
            </div>

            @if($careerPlans->count())
                <div class="career-job-list" id="careerJobList">
                    @foreach($careerPlans as $careerPlan)
                        @php($data = $careerPlan->display_data)
                        <article class="career-job" data-career-job>
                            <div class="career-job-top">
                                <div class="career-job-main">
                                    <h3 class="career-job-title">
                                        <span class="career-job-id">#{{ $careerPlan->id }}</span>
                                        {{ $careerPlan->title }}
                                    </h3>
                                    <div class="career-job-meta">
                                        <span><strong>{{ $data['vacancies'] ?? 0 }}</strong> vacancies</span>
                                        <span>{{ $data['job_category'] ?? 'Category not specified' }}</span>
                                        @if(count($data['area_names']))
                                            <span>{{ implode(', ', $data['area_names']) }}</span>
                                        @else
                                            <span>Location not specified</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="career-job-actions">
                                    <span class="career-job-status {{ $careerPlan->status === 'draft' ? 'is-draft' : ($careerPlan->status === 'closed' ? 'is-closed' : '') }}">{{ $careerPlan->status }}</span>
                                    <button type="button" class="career-job-menu-toggle" aria-label="Job actions" aria-expanded="false" aria-haspopup="true" data-job-menu-toggle>⋯</button>
                                    <div class="career-job-menu" role="menu" hidden>
                                        <a href="{{ route('admin.career.show', $careerPlan) }}" role="menuitem">View details</a>
                                        @if($careerPlan->status === 'published')
                                            <button type="button" role="menuitem" data-share-url="{{ $careerPlan->share_url }}">Share</button>
                                        @endif
                                        <form method="POST" action="{{ route('admin.career.status', $careerPlan) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="{{ $careerPlan->status === 'published' ? 'closed' : 'published' }}">
                                            <button type="submit" role="menuitem">{{ $careerPlan->status === 'published' ? 'Turn off job' : 'Turn on job' }}</button>
                                        </form>
                                    </div>
                                    <div class="career-share-status" role="status" aria-live="polite"></div>
                                </div>
                            </div>
                            <div class="career-job-footer">
                                <span>
                                    @if(isset($data['salary_min'], $data['salary_max']))
                                        TK. {{ number_format((int) $data['salary_min']) }}-{{ number_format((int) $data['salary_max']) }}
                                    @else
                                        Salary not specified
                                    @endif
                                </span>
                                <span>
                                    Application deadline:
                                    {{ !empty($data['application_deadline']) ? \Illuminate\Support\Carbon::parse($data['application_deadline'])->format('F d, Y') : 'Not specified' }}
                                </span>
                                <a href="{{ route('admin.career.applications', $careerPlan) }}">
                                    Applicants ({{ $careerPlan->applications_count }})
                                </a>
                                <span>Posted {{ $careerPlan->created_at->format('M d, Y') }}</span>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="career-no-results" id="careerNoResults">No jobs match your search.</div>
                @if($careerPlans->hasPages())
                    <div class="career-pagination">{{ $careerPlans->links() }}</div>
                @endif
            @else
                <div class="career-empty">
                    <div class="career-empty-icon" aria-hidden="true">+</div>
                    <h2>No jobs posted yet</h2>
                    <p>Create your first job post and it will appear here for you to manage.</p>
                    <a class="career-create-link" href="{{ route('admin.career.create') }}">Post A New Job</a>
                </div>
            @endif
        </section>
    </div>
</main>
@endsection

@push('page_scripts')
<script>
    (function () {
        const search = document.getElementById('careerJobSearch');
        const jobs = [...document.querySelectorAll('[data-career-job]')];
        const noResults = document.getElementById('careerNoResults');

        if (search) {
            search.addEventListener('input', function () {
                const query = this.value.trim().toLowerCase();
                let visibleCount = 0;

                jobs.forEach(function (job) {
                    const matches = job.textContent.toLowerCase().includes(query);
                    job.hidden = !matches;
                    if (matches) visibleCount++;
                });

                if (noResults) noResults.style.display = visibleCount ? 'none' : 'block';
            });
        }

        document.querySelectorAll('[data-job-menu-toggle]').forEach(function (toggle) {
            toggle.addEventListener('click', function () {
                const menu = toggle.parentElement.querySelector('.career-job-menu');
                const opening = menu.hidden;

                document.querySelectorAll('.career-job-menu').forEach(function (otherMenu) {
                    otherMenu.hidden = true;
                    otherMenu.parentElement.querySelector('[data-job-menu-toggle]').setAttribute('aria-expanded', 'false');
                });

                menu.hidden = !opening;
                toggle.setAttribute('aria-expanded', String(opening));
            });
        });

        document.querySelectorAll('.career-job-menu [data-share-url]').forEach(function (button) {
            button.addEventListener('click', async function () {
                const status = button.closest('.career-job-actions').querySelector('.career-share-status');
                const shareUrl = button.dataset.shareUrl;
                let copied = false;

                try {
                    if (navigator.clipboard && window.isSecureContext) {
                        await navigator.clipboard.writeText(shareUrl);
                        copied = true;
                    } else {
                        const input = document.createElement('textarea');
                        input.value = shareUrl;
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

                status.textContent = copied ? 'Share link copied.' : 'Copy this link: ' + shareUrl;
                status.style.display = 'block';
                button.closest('.career-job-menu').hidden = true;
                button.closest('.career-job-actions').querySelector('[data-job-menu-toggle]').setAttribute('aria-expanded', 'false');
            });
        });

        document.addEventListener('click', function (event) {
            if (event.target.closest('.career-job-actions')) return;
            document.querySelectorAll('.career-job-menu').forEach(function (menu) {
                menu.hidden = true;
                menu.parentElement.querySelector('[data-job-menu-toggle]').setAttribute('aria-expanded', 'false');
            });
        });

        document.addEventListener('keydown', function (event) {
            if (event.key !== 'Escape') return;
            document.querySelectorAll('.career-job-menu').forEach(function (menu) {
                menu.hidden = true;
                menu.parentElement.querySelector('[data-job-menu-toggle]').setAttribute('aria-expanded', 'false');
            });
        });
    })();
</script>
@endpush
