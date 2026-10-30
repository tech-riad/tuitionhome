@extends('layouts.app')

@section('title', 'Applications - ' . $careerPlan->title)

@push('page_css')
<style>
    .career-applications-page {
        background: #f4f7fb;
        min-height: calc(100vh - 60px);
        padding: 32px 20px 48px;
    }

    .career-applications-wrap {
        margin: 0 auto;
        max-width: 1180px;
    }

    .career-applications-header {
        align-items: flex-start;
        display: flex;
        gap: 20px;
        justify-content: space-between;
        margin-bottom: 22px;
    }

    .career-applications-title {
        color: #243447;
        font-size: 25px;
        font-weight: 700;
        margin: 0 0 7px;
    }

    .career-applications-subtitle {
        color: #7d8998;
        font-size: 13px;
    }

    .career-applications-back {
        color: #1680f8;
        display: inline-block;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 12px;
        text-decoration: none;
    }

    .career-applications-card {
        background: #fff;
        border: 1px solid #e6ecf3;
        border-radius: 12px;
        box-shadow: 0 8px 26px rgba(34, 58, 86, .045);
        overflow: hidden;
    }

    .career-applications-toolbar {
        align-items: center;
        border-bottom: 1px solid #edf1f6;
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        justify-content: space-between;
        padding: 16px 20px;
    }

    .career-applications-toolbar h2 {
        color: #26394d;
        font-size: 15px;
        font-weight: 650;
        margin: 0;
    }

    .career-applications-count {
        background: #edf5ff;
        border-radius: 20px;
        color: #1680f8;
        font-size: 11px;
        margin-left: 6px;
        padding: 4px 9px;
    }

    .career-applications-filter {
        align-items: center;
        display: flex;
        gap: 8px;
    }

    .career-applications-filter select,
    .career-applications-action select {
        background: #fff;
        border: 1px solid #dfe6ee;
        border-radius: 6px;
        color: #42546a;
        font-size: 12px;
        min-height: 36px;
        padding: 7px 10px;
    }

    .career-applications-filter button,
    .career-applications-action button {
        background: #1680f8;
        border: 0;
        border-radius: 6px;
        color: #fff;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        min-height: 36px;
        padding: 0 13px;
    }

    .career-applications-table-wrap {
        overflow-x: auto;
    }

    .career-applications-table {
        border-collapse: collapse;
        min-width: 820px;
        width: 100%;
    }

    .career-applications-table th,
    .career-applications-table td {
        border-bottom: 1px solid #edf1f6;
        color: #394b60;
        font-size: 12px;
        padding: 13px 15px;
        text-align: left;
        vertical-align: middle;
    }

    .career-applications-table th {
        background: #fbfcfe;
        color: #8290a0;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .career-applications-tutor {
        color: #293d52;
        font-weight: 650;
    }

    .career-applications-muted {
        color: #8290a0;
        display: block;
        font-size: 11px;
        margin-top: 4px;
    }

    .career-applications-status {
        background: #fff5df;
        border-radius: 20px;
        color: #a66a00;
        display: inline-block;
        font-size: 10px;
        font-weight: 700;
        padding: 5px 9px;
        text-transform: capitalize;
    }

    .career-applications-status.is-reviewing,
    .career-applications-status.is-interview {
        background: #edf5ff;
        color: #1680f8;
    }

    .career-applications-status.is-shortlisted {
        background: #f0eefe;
        color: #6954bb;
    }

    .career-applications-status.is-hired {
        background: #e9f8ef;
        color: #21834b;
    }

    .career-applications-status.is-rejected {
        background: #fff0f0;
        color: #c34242;
    }

    .career-applications-action {
        align-items: center;
        display: flex;
        gap: 7px;
    }

    .career-applications-action select {
        min-width: 125px;
    }

    .career-application-notes-button {
        background: #edf5ff;
        border: 1px solid #dceaff;
        border-radius: 6px;
        color: #1680f8;
        cursor: pointer;
        font-family: inherit;
        font-size: 12px;
        font-weight: 600;
        padding: 8px 11px;
    }

    .career-application-notes-button:hover {
        background: #e2efff;
    }

    .career-notes-modal .modal-content {
        border: 0;
        border-radius: 14px;
        box-shadow: 0 18px 55px rgba(27, 45, 70, .2);
        overflow: hidden;
    }

    .career-notes-modal .modal-dialog {
        max-width: 600px;
    }

    .career-notes-modal .modal-content {
        padding: 8px;
    }

    .career-notes-modal .modal-body {
        margin-top: 8px;
        padding: 8px 16px 16px;
    }

    .career-notes-modal .modal-title {
        color: #243447;
        font-size: 17px;
        font-weight: 700;
    }

    .career-notes-list {
        max-height: 340px;
        min-height: 60px;
        overflow-y: auto;
        padding: 0 2px 2px 0;
    }

    .career-application-note-item {
        background: #f8fafc;
        border: 1px solid #e9eff6;
        border-radius: 10px;
        color: #394b60;
        font-size: 13px;
        line-height: 1.6;
        margin-bottom: 10px;
        padding: 13px 15px;
        white-space: pre-wrap;
    }

    .career-application-note-meta {
        color: #8290a0;
        display: block;
        font-size: 11px;
        margin-top: 7px;
    }

    .career-application-note-form textarea {
        border: 1px solid #dbe4ef;
        border-radius: 9px;
        display: block;
        font-size: 13px;
        min-height: 115px;
        padding: 11px 13px;
        resize: vertical;
        transition: border-color .15s, box-shadow .15s;
        width: 100%;
    }

    .career-application-note-form textarea:focus {
        border-color: #1680f8;
        box-shadow: 0 0 0 3px rgba(22, 128, 248, .1);
        outline: 0;
    }

    .career-application-note-form button {
        background: #1680f8;
        border: 0;
        border-radius: 7px;
        color: #fff;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        padding: 8px 14px;
    }

    .career-application-note-form button:disabled {
        cursor: wait;
        opacity: .65;
    }

    .career-notes-empty,
    .career-notes-loading {
        color: #8290a0;
        font-size: 13px;
        padding: 20px 10px;
        text-align: center;
    }

    .career-notes-error {
        color: #c34242;
        font-size: 12px;
        margin-top: 8px;
    }

    .career-application-notes-empty {
        color: #8290a0;
        font-size: 13px;
        padding: 16px 0;
    }

    .career-applications-empty {
        color: #7d8998;
        font-size: 13px;
        padding: 55px 20px;
        text-align: center;
    }

    .career-applications-pagination {
        padding: 14px 20px;
    }

    .career-applications-pagination nav {
        display: flex;
        justify-content: flex-end;
    }

    @media(max-width:640px) {
        .career-applications-page {
            padding: 22px 12px 32px;
        }

        .career-applications-header {
            flex-direction: column;
            gap: 12px;
        }

        .career-applications-title {
            font-size: 21px;
        }

        .career-applications-toolbar {
            align-items: flex-start;
            flex-direction: column;
            padding: 14px;
        }
    }

</style>
@endpush

@section('content')
<main class="career-applications-page">
    <div class="career-applications-wrap">
        <a class="career-applications-back" href="{{ route('admin.career.index') }}">← Back to Job Post</a>
        <header class="career-applications-header">
            <div>
                <h1 class="career-applications-title">Applications</h1>
                <div class="career-applications-subtitle text-bold font-weight-bold">#{{ $careerPlan->id }} · {{ $careerPlan->title }}</div>
            </div>
        </header>

        @if(session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        <section class="career-applications-card">
            <div class="career-applications-toolbar">
                <h2>Applicants <span class="career-applications-count">{{ $applications->total() }}</span></h2>
                <form class="career-applications-filter" method="GET"
                    action="{{ route('admin.career.applications', $careerPlan) }}">
                    <label class="sr-only" for="applicationStatusFilter">Filter by status</label>
                    <select id="applicationStatusFilter" name="status">
                        <option value="">All statuses</option>
                        @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ $selectedStatus === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <button type="submit">Filter</button>
                </form>
            </div>

            @if($applications->count())
            <div class="d-flex justify-content-start p-3">
                <button class="btn btn-outline-dark" id="sendSms">Send Bulk SMS</button>
            </div>

            <div class="career-applications-table-wrap">
                <table class="career-applications-table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAllApplications"
                                    aria-label="Select all applicants on this page"></th>
                            <th>Tutor</th>
                            <th>Tutor ID</th>
                            <th>Profile</th>
                            <th>Phone</th>
                            <th>Applied at</th>
                            <th>Status</th>
                            <th>Update status</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                        <tr>
                            <td>
                                <input class="checkboxx" type="checkbox" name="ids" id="{{ $application->tutor_id }}"
                                    value="{{ $application->tutor_id }}" /> </td>
                            <td>
                                <span
                                    class="career-applications-tutor">{{ optional($application->tutor)->name ?? 'Tutor account unavailable' }}</span>
                                @if(optional($application->tutor)->email)
                                <span class="career-applications-muted">{{ $application->tutor->email }}</span>
                                @endif
                                @if($application->tutor && (int) $application->tutor->is_sms !== 1)
                                <span class="career-applications-muted">SMS disabled</span>
                                @endif
                            </td>
                            <td>#{{ $application->tutor_id }}</td>
                            <td>
                                @if($application->tutor)
                                <a href="{{ route('admin.tutor.tutorshow', ['tutor' => $application->tutor->id]) }}">View
                                    Profile</a>
                                @else
                                —
                                @endif
                            </td>
                            <td>{{ optional($application->tutor)->phone ?? '—' }}</td>
                            <td>{{ $application->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <span
                                    class="career-applications-status is-{{ $application->status }}">{{ ucfirst($application->status) }}</span>
                            </td>
                            <td>
                                <form class="career-applications-action" method="POST"
                                    action="{{ route('admin.career.applications.status', ['careerPlan' => $careerPlan, 'application' => $application, 'status' => $selectedStatus ?: null]) }}">
                                    @csrf
                                    <select name="status"
                                        aria-label="New status for application #{{ $application->id }}">
                                        @foreach($statuses as $status)
                                        <option value="{{ $status }}"
                                            {{ $application->status === $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit">Save</button>
                                </form>
                            </td>
                            <td>
                                <button type="button" class="career-application-notes-button"
                                    data-toggle="modal" data-target="#applicationNotesModal"
                                    data-application-id="{{ $application->id }}"
                                    data-application-name="{{ optional($application->tutor)->name ?? 'Tutor account unavailable' }}"
                                    data-notes-url="{{ route('admin.career.applications.notes', [$careerPlan, $application]) }}"
                                    data-store-url="{{ route('admin.career.applications.notes.store', [$careerPlan, $application]) }}"
                                    data-note-count="{{ $application->notes->count() }}">
                                    {{ $application->notes->count() ? 'View / add (' . $application->notes->count() . ')' : 'Add note' }}
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="modal fade career-notes-modal" id="applicationNotesModal" tabindex="-1" role="dialog"
                    aria-labelledby="applicationNotesModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="modal-title mb-1" id="applicationNotesModalTitle">Notes for <span id="applicationNotesTutor"></span></h5>
                                        <small class="text-muted">Application #<span id="applicationNotesApplicationId"></span></small>
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form class="career-application-note-form" id="applicationNoteForm">
                                    <input type="hidden" name="application_id" id="note_application_id">
                                    <label for="applicationNoteInput" class="font-weight-bold">Add Note</label>
                                    <textarea id="applicationNoteInput" name="note" maxlength="5000" required
                                        placeholder="Write your note here..."></textarea>
                                    <span class="career-notes-error" id="applicationNotesFeedback" role="alert"></span>
                                    <div class="d-flex justify-content-end align-items-center mt-2">
                                        <button type="submit" id="saveApplicationNote">Create</button>
                                    </div>
                                </form>
                                <div class="career-notes-list mt-4" id="applicationNotesList" aria-live="polite">
                                    <div class="career-notes-loading">Loading notes...</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif

            @if($applications->count())
            @if($applications->hasPages())
            <div class="career-applications-pagination">{{ $applications->links() }}</div>
            @endif
            @else
            <div class="career-applications-empty">
                {{ $selectedStatus ? 'No applications with this status.' : 'No applications received yet.' }}
            </div>
            @endif
        </section>
    </div>
</main>
<form style="display: none" action="{{ route('admin.tutor.sms-editor') }}" method="POST" id="smsForm">
    @csrf
    <input type="hidden" id="var1" name="all_id" value="" />
</form>
@endsection

@push('page_scripts')
<script>
    (function () {
        var list = document.getElementById('applicationNotesList');
        var form = document.getElementById('applicationNoteForm');
        var input = document.getElementById('applicationNoteInput');
        var feedback = document.getElementById('applicationNotesFeedback');
        var saveButton = document.getElementById('saveApplicationNote');
        var currentTrigger = null;
        var notesUrl = '';
        var storeUrl = '';
        var notesRequest = null;

        function appendNotes(notes) {
            list.innerHTML = '';
            if (!notes.length) {
                list.innerHTML = '<p class="text-muted">No notes found.</p>';
                return;
            }

            notes.forEach(function (note) {
                var item = $('<div>', { class: 'border rounded p-2 mb-2' });
                $('<p>', { class: 'mb-1' }).text(note.body || '').appendTo(item);
                $('<small>', { class: 'text-muted d-block' })
                    .text('Created By: ' + (note.created_by || ''))
                    .appendTo(item);
                $('<small>', { class: 'text-muted' })
                    .text('Created: ' + (note.created_at || ''))
                    .appendTo(item);
                $(list).append(item);
            });
        }

        function loadNotes() {
            list.innerHTML = '<div class="career-notes-loading">Loading notes...</div>';

            if (notesRequest) notesRequest.abort();
            notesRequest = $.ajax({
                url: notesUrl,
                type: 'GET',
                dataType: 'json',
                cache: false,
                success: function (response) {
                    if (currentTrigger && response.status) appendNotes(response.data || []);
                },
                error: function (xhr) {
                    if (xhr.statusText === 'abort') return;
                    list.innerHTML = '<p class="text-danger">Unable to load notes.</p>';
                }
            });
        }

        $(document).on('click', '.career-application-notes-button', function () {
            currentTrigger = this;
            notesUrl = currentTrigger.dataset.notesUrl;
            storeUrl = currentTrigger.dataset.storeUrl;
            document.getElementById('applicationNotesTutor').textContent = currentTrigger.dataset.applicationName;
            document.getElementById('applicationNotesApplicationId').textContent = currentTrigger.dataset.applicationId;
            document.getElementById('note_application_id').value = currentTrigger.dataset.applicationId;
            input.value = '';
            feedback.textContent = '';
            loadNotes();
        });

        $(form).on('submit', function (event) {
            event.preventDefault();
            feedback.textContent = '';
            saveButton.disabled = true;

            $.ajax({
                url: storeUrl,
                type: 'POST',
                data: $(form).serialize(),
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status) {
                        input.value = '';
                        loadNotes();
                        currentTrigger.dataset.noteCount = response.count;
                        currentTrigger.textContent = response.count
                            ? 'View / add (' + response.count + ')'
                            : 'Add note';
                        if (typeof toastr !== 'undefined') toastr.success(response.message);
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON && xhr.responseJSON.errors
                            ? xhr.responseJSON.errors
                            : {};
                        feedback.textContent = errors.note
                            ? errors.note[0]
                            : 'Please check the submitted information.';
                    } else {
                        alert('Note save failed. Please try again.');
                    }
                },
                complete: function () {
                    saveButton.disabled = false;
                }
            });
        });
    })();

    $(function () {
        var $selectAll = $('#selectAllApplications');
        var $applicationCheckboxes = $('.checkboxx');

        $selectAll.on('change', function () {
            $applicationCheckboxes.prop('checked', this.checked);
            $selectAll.prop('indeterminate', false);
        });

        $applicationCheckboxes.on('change', function () {
            var checkedCount = $applicationCheckboxes.filter(':checked').length;
            $selectAll
                .prop('checked', checkedCount === $applicationCheckboxes.length)
                .prop('indeterminate', checkedCount > 0 && checkedCount < $applicationCheckboxes.length);
        });

        $("#sendSms").click(function (e) {
            e.preventDefault();
            var all_ids = [];

            $('input:checkbox[name=ids]:checked').each(function () {
                all_ids.push($(this).val());
            });

            $("#var1").val(all_ids);
            if (all_ids == '') {
                alert("please select atleast one tutor");
            } else {
                $("#smsForm").submit();
            }
        });

    });

</script>
@endpush
