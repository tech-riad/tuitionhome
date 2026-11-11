@extends('layouts.app')

@section('title', 'Teacher Consultation Requests')

@push('page_css')
<style>
    .consultation-page { background: #f4f7fb; min-height: calc(100vh - 60px); padding: 28px 20px; }
    .consultation-note { align-items: flex-start; border-bottom: 1px solid #edf1f5; display: flex; gap: 12px; justify-content: space-between; margin: 0; padding: 7px 2px; }
    .consultation-note:last-child { border-bottom: 0; }
    .consultation-note-body { color: #394b60; font-size: 13px; line-height: 1.4; overflow-wrap: anywhere; white-space: pre-wrap; }
    .consultation-note-meta { color: #8290a0; flex: 0 0 auto; font-size: 11px; text-align: right; white-space: nowrap; }
    .consultation-message-preview { display: block; max-width: 260px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .consultation-ajax-feedback { display: none; }
    @media (max-width: 576px) {
        .consultation-note { display: block; }
        .consultation-note-meta { display: block; margin-top: 3px; text-align: left; }
    }
</style>
@endpush

@section('content')
<main class="consultation-page">
    <div class="container-fluid">
        <h1 class="h3 mb-4">Teacher Consultation Requests</h1>

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

        <form class="form-inline mb-3" method="GET" action="{{ route('admin.consultation-requests.index') }}">
            <label class="mr-2" for="status-filter">Status</label>
            <select class="form-control mr-2" id="status-filter" name="status">
                <option value="">All statuses</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ $selectedStatus === $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
            <label class="mr-2" for="scheduled-date-filter">Scheduled date</label>
            <input
                class="form-control mr-2"
                id="scheduled-date-filter"
                name="scheduled_date"
                type="date"
                value="{{ $selectedScheduledDate }}"
            >
            <label class="mr-2" for="tutor-phone-filter">Tutor phone</label>
            <input
                class="form-control mr-2"
                id="tutor-phone-filter"
                name="tutor_phone"
                type="search"
                maxlength="30"
                placeholder="Search phone number"
                value="{{ $selectedTutorPhone }}"
            >
            <button class="btn btn-primary" type="submit">Filter</button>
            @if($selectedStatus || $selectedScheduledDate || $selectedTutorPhone)
                <a class="btn btn-outline-secondary ml-2" href="{{ route('admin.consultation-requests.index') }}">Clear</a>
            @endif
        </form>
        <form id="consultationSmsForm" class="mt-3" method="POST" action="{{ route('admin.consultation-requests.sms.editor.select') }}">
            @csrf
            <input type="hidden" name="status" value="{{ $selectedStatus }}">
            <button type="submit" class="btn btn-outline-dark">Send Bulk SMS</button>
            <small class="text-muted ml-2">Select up to 20 requests. Tutors with SMS disabled cannot be selected.</small>
        </form>
        <br>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAllConsultationRequests" aria-label="Select all requests on this page"></th>
                            <th>Request</th>
                            <th>Teacher</th>
                            <th>Message</th>
                            <th>Request status</th>
                            <th>Scheduled</th>
                            <th>Payment</th>
                            <th>Invoice</th>
                            <th>Submitted</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consultationRequests as $consultationRequest)
                            <tr id="consultation-row-{{ $consultationRequest->id }}">
                                <td>
                                    <input
                                        class="consultation-request-checkbox"
                                        type="checkbox"
                                        name="consultation_request_ids[]"
                                        value="{{ $consultationRequest->id }}"
                                        form="consultationSmsForm"
                                        {{ !$consultationRequest->tutor || (int) $consultationRequest->tutor->is_sms !== 1 ? 'disabled' : '' }}
                                        aria-label="Select consultation request {{ $consultationRequest->id }}"
                                    >
                                </td>
                                <td>#{{ $consultationRequest->id }}</td>
                                <td>
                                    @if($consultationRequest->tutor)
                                    <a href="{{ route('admin.tutor.tutorshow', $consultationRequest->tutor->id) }}" target="_blank">
                                        {{ optional($consultationRequest->tutor)->name ?? 'Tutor account unavailable' }}
                                    </a>
                                    @else
                                        Tutor account unavailable
                                    @endif
                                    @if(optional($consultationRequest->tutor)->phone)
                                        <small class="d-block text-muted">{{ $consultationRequest->tutor->phone }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="consultation-message-preview" data-request-message title="{{ $consultationRequest->message }}">
                                        {{ $consultationRequest->message }}
                                    </span>
                                </td>
                                <td><span class="badge badge-info" data-request-status>{{ ucfirst($consultationRequest->status) }}</span></td>
                                <td class="text-nowrap" data-request-scheduled>
                                    {{ $consultationRequest->scheduled_at ? $consultationRequest->scheduled_at->format('M d, Y g:i A') : '—' }}
                                </td>
                                <td><span class="badge {{ $consultationRequest->payment_status === 'paid' ? 'badge-success' : 'badge-warning' }}" data-payment-status>{{ ucfirst($consultationRequest->payment_status) }}</span></td>
                                <td class="text-nowrap" data-invoice-summary data-invoice-number="{{ $consultationRequest->invoice ? $consultationRequest->invoice->invoice_number : '' }}">
                                    @if($consultationRequest->invoice)
                                        {{ $consultationRequest->invoice->invoice_number }}
                                        <small class="d-block text-muted">{{ ucfirst($consultationRequest->invoice->status) }}</small>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="text-nowrap">{{ $consultationRequest->created_at->format('M d, Y') }}</td>
                                <td class="text-nowrap">
                                    <button
                                        class="btn btn-sm btn-outline-primary"
                                        type="button"
                                        data-toggle="modal"
                                        data-target="#consultation-modal-{{ $consultationRequest->id }}"
                                    >Manage</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">No consultation requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">{{ $consultationRequests->links() }}</div>
        </div>



        @foreach($consultationRequests as $consultationRequest)
            <div class="modal fade" id="consultation-modal-{{ $consultationRequest->id }}" tabindex="-1" role="dialog" aria-labelledby="consultation-modal-title-{{ $consultationRequest->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <h5 class="modal-title" id="consultation-modal-title-{{ $consultationRequest->id }}">Manage request #{{ $consultationRequest->id }}</h5>
                                <small class="text-muted">{{ optional($consultationRequest->tutor)->name ?? 'Tutor account unavailable' }}</small>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" data-consultation-ajax action="{{ route('admin.consultation-requests.update', ['consultationRequest' => $consultationRequest->id, 'status' => $selectedStatus, 'page' => $consultationRequests->currentPage()]) }}">
                                @csrf
                                @method('PATCH')

                                <div class="form-group">
                                    <label for="message-{{ $consultationRequest->id }}">Message</label>
                                    <textarea class="form-control" id="message-{{ $consultationRequest->id }}" name="message" rows="3" maxlength="5000" required>{{ $consultationRequest->message }}</textarea>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="status-{{ $consultationRequest->id }}">Status</label>
                                        <select class="form-control" id="status-{{ $consultationRequest->id }}" name="status">
                                            @foreach($statuses as $status)
                                                <option value="{{ $status }}" {{ $consultationRequest->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="scheduled-at-{{ $consultationRequest->id }}">Scheduled date and time</label>
                                        <input
                                            class="form-control"
                                            id="scheduled-at-{{ $consultationRequest->id }}"
                                            name="scheduled_at"
                                            type="datetime-local"
                                            value="{{ $consultationRequest->scheduled_at ? $consultationRequest->scheduled_at->format('Y-m-d\TH:i') : '' }}"
                                        >
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Save request details</button>
                                <div class="consultation-ajax-feedback alert mt-2 mb-0" role="status"></div>
                            </form>

                            <hr>
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <strong>Payment:</strong>
                                    <span class="badge {{ $consultationRequest->payment_status === 'paid' ? 'badge-success' : 'badge-warning' }}" data-modal-payment-status>{{ ucfirst($consultationRequest->payment_status) }}</span>
                                    <div class="small text-muted" data-modal-invoice-summary>
                                        @if($consultationRequest->invoice)
                                            Invoice {{ $consultationRequest->invoice->invoice_number }} · {{ $consultationRequest->invoice->currency }} {{ number_format((float) $consultationRequest->invoice->amount, 2) }} · {{ ucfirst($consultationRequest->invoice->status) }}
                                        @else
                                            No invoice created
                                        @endif
                                    </div>
                                </div>
                                @if($consultationRequest->invoice)
                                    @if(!in_array(strtolower($consultationRequest->invoice->status), ['cancel', 'cancelled'], true))
                                        <form method="POST" data-consultation-ajax action="{{ route('admin.consultation-requests.payment-status', $consultationRequest->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="input-group input-group-sm">
                                                <select class="form-control" name="payment_status" aria-label="Payment status" {{ strtolower($consultationRequest->invoice->status) === 'paid' ? 'disabled' : '' }}>
                                                    <option value="unpaid" {{ $consultationRequest->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                                    <option value="paid" {{ $consultationRequest->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                                </select>
                                                @if(strtolower($consultationRequest->invoice->status) !== 'paid')
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-primary" type="submit">Update</button>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="consultation-ajax-feedback alert mt-2 mb-0" role="status"></div>
                                        </form>
                                    @endif
                                    @if(!in_array(strtolower($consultationRequest->invoice->status), ['paid', 'cancel', 'cancelled'], true))
                                        <form method="POST" data-consultation-ajax data-cancel-invoice action="{{ route('admin.consultation-requests.invoice.cancel', $consultationRequest->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Cancel invoice</button>
                                            <div class="consultation-ajax-feedback alert mt-2 mb-0" role="status"></div>
                                        </form>
                                    @endif
                                @endif
                            </div>

                            @unless($consultationRequest->invoice)
                                <form class="form-inline mt-3" method="POST" data-consultation-ajax action="{{ route('admin.consultation-requests.invoice.create', $consultationRequest->id) }}">
                                    @csrf
                                    <label class="sr-only" for="package-{{ $consultationRequest->id }}">Package</label>
                                    <select class="form-control form-control-sm mr-2" id="package-{{ $consultationRequest->id }}" name="package_amount_id" required>
                                        <option value="">Select package / amount</option>
                                        @foreach($packageAmounts as $packageAmount)
                                            <option value="{{ $packageAmount->id }}">
                                                {{ ucfirst(str_replace('_', ' ', $packageAmount->package_name)) }} · {{ $packageAmount->currency }} {{ number_format((float) $packageAmount->amount, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-sm btn-outline-success" type="submit">Create invoice</button>
                                    <div class="consultation-ajax-feedback alert mt-2 mb-0" role="status"></div>
                                </form>
                            @endunless

                            <hr>
                            <h6 class="mb-1">Notes <small class="text-muted" data-note-count>({{ $consultationRequest->notes->count() }})</small></h6>
                            <div data-notes-list>
                            @forelse($consultationRequest->notes as $note)
                                <div class="consultation-note">
                                    <span class="consultation-note-body">{{ $note->note }}</span>
                                    <small class="consultation-note-meta">{{ optional($note->user)->name ?? 'Former user' }} · {{ $note->created_at->format('M d, Y g:i A') }}</small>
                                </div>
                            @empty
                                <p class="text-muted">No notes yet.</p>
                            @endforelse
                            </div>

                            <form method="POST" data-consultation-ajax action="{{ route('admin.consultation-requests.notes.store', ['consultationRequest' => $consultationRequest->id, 'status' => $selectedStatus, 'page' => $consultationRequests->currentPage()]) }}">
                                @csrf
                                <div class="form-group">
                                    <label for="note-{{ $consultationRequest->id }}">Add a note</label>
                                    <textarea class="form-control" id="note-{{ $consultationRequest->id }}" name="note" rows="2" maxlength="5000" required></textarea>
                                </div>
                                <button class="btn btn-outline-primary" type="submit">Add note</button>
                                <div class="consultation-ajax-feedback alert mt-2 mb-0" role="status"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</main>
@endsection

@push('page_scripts')
<script>
    (function () {
        var selectAll = document.getElementById('selectAllConsultationRequests');
        if (!selectAll) {
            return;
        }

        var checkboxes = document.querySelectorAll('.consultation-request-checkbox:not(:disabled)');
        selectAll.addEventListener('change', function () {
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = selectAll.checked;
            });
        });

        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                var checkedCount = document.querySelectorAll('.consultation-request-checkbox:checked').length;
                selectAll.checked = checkedCount === checkboxes.length;
                selectAll.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
            });
        });
    })();
</script>
@endpush

@push('page_scripts')
<script>
    (function () {
        function showFeedback(form, message, isError) {
            var feedback = form.querySelector('.consultation-ajax-feedback');
            if (!feedback) {
                feedback = document.createElement('div');
                feedback.className = 'consultation-ajax-feedback alert mt-2 mb-0';
                form.appendChild(feedback);
            }
            feedback.className = 'consultation-ajax-feedback alert mt-2 mb-0 ' + (isError ? 'alert-danger' : 'alert-success');
            feedback.textContent = message;
            feedback.style.display = 'block';
        }

        function updatePaymentDisplay(requestId, paymentStatus) {
            var row = document.getElementById('consultation-row-' + requestId);
            var modal = document.getElementById('consultation-modal-' + requestId);
            [row && row.querySelector('[data-payment-status]'), modal && modal.querySelector('[data-modal-payment-status]')].forEach(function (badge) {
                if (!badge) return;
                badge.textContent = paymentStatus.charAt(0).toUpperCase() + paymentStatus.slice(1);
                badge.className = 'badge ' + (paymentStatus === 'paid' ? 'badge-success' : 'badge-warning');
            });
            if (paymentStatus === 'paid' && modal) {
                var paymentSelect = modal.querySelector('[name="payment_status"]');
                if (paymentSelect) {
                    paymentSelect.disabled = true;
                    var updateButton = paymentSelect.closest('form').querySelector('button[type="submit"]');
                    if (updateButton) updateButton.remove();
                }
                var cancelForm = modal.querySelector('[data-cancel-invoice]');
                if (cancelForm) cancelForm.remove();
            }
        }

        function updateInvoiceDisplay(requestId, invoice) {
            var row = document.getElementById('consultation-row-' + requestId);
            var modal = document.getElementById('consultation-modal-' + requestId);
            if (modal) {
                modal.querySelector('[data-modal-invoice-summary]').textContent =
                    'Invoice ' + invoice.invoice_number + ' · ' + invoice.currency + ' ' +
                    Number(invoice.amount).toFixed(2) + ' · ' + invoice.status.charAt(0).toUpperCase() + invoice.status.slice(1);
            }
            if (row) {
                var invoiceCell = row.querySelector('[data-invoice-summary]');
                invoiceCell.dataset.invoiceNumber = invoice.invoice_number;
                invoiceCell.textContent = invoice.invoice_number + ' · ' + invoice.status.charAt(0).toUpperCase() + invoice.status.slice(1);
            }
        }

        document.querySelectorAll('[data-consultation-ajax]').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                if (form.hasAttribute('data-cancel-invoice') && !window.confirm('Are you sure you want to cancel this invoice?')) {
                    return;
                }
                var button = form.querySelector('button[type="submit"]');
                if (button) button.disabled = true;

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: new FormData(form)
                }).then(function (response) {
                    return response.json().then(function (data) {
                        if (!response.ok) {
                            var errors = data.errors ? Object.values(data.errors).flat().join(' ') : data.message;
                            throw new Error(errors || 'Request failed.');
                        }
                        return data;
                    });
                }).then(function (data) {
                    var modal = form.closest('.modal');
                    var requestId = modal.id.replace('consultation-modal-', '');
                    var row = document.getElementById('consultation-row-' + requestId);

                    if (form.querySelector('[name="package_amount_id"]')) {
                        form.remove();
                        updateInvoiceDisplay(requestId, data.invoice);
                        var paymentArea = modal.querySelector('[data-modal-payment-status]').parentElement;
                        var paymentForm = document.createElement('form');
                        paymentForm.method = 'POST';
                        paymentForm.action = "{{ route('admin.consultation-requests.payment-status', ['consultationRequest' => '__ID__']) }}".replace('__ID__', requestId);
                        paymentForm.setAttribute('data-consultation-ajax', '');
                        paymentForm.innerHTML =
                            '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                            '<input type="hidden" name="_method" value="PATCH">' +
                            '<div class="input-group input-group-sm"><select class="form-control" name="payment_status" aria-label="Payment status">' +
                            '<option value="unpaid" selected>Unpaid</option><option value="paid">Paid</option></select>' +
                            '<div class="input-group-append"><button class="btn btn-outline-primary" type="submit">Update</button></div></div>' +
                            '<div class="consultation-ajax-feedback alert mt-2 mb-0" role="status"></div>';
                        paymentArea.appendChild(paymentForm);
                        bindForm(paymentForm);
                        var cancelForm = document.createElement('form');
                        cancelForm.method = 'POST';
                        cancelForm.action = "{{ route('admin.consultation-requests.invoice.cancel', ['consultationRequest' => '__ID__']) }}".replace('__ID__', requestId);
                        cancelForm.setAttribute('data-consultation-ajax', '');
                        cancelForm.setAttribute('data-cancel-invoice', '');
                        cancelForm.innerHTML =
                            '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                            '<input type="hidden" name="_method" value="PATCH">' +
                            '<button class="btn btn-sm btn-outline-danger" type="submit">Cancel invoice</button>' +
                            '<div class="consultation-ajax-feedback alert mt-2 mb-0" role="status"></div>';
                        paymentArea.appendChild(cancelForm);
                        bindForm(cancelForm);
                        updatePaymentDisplay(requestId, 'unpaid');
                        if (row) row.querySelector('[data-payment-status]').textContent = 'Unpaid';
                    } else if (form.hasAttribute('data-cancel-invoice')) {
                        updatePaymentDisplay(requestId, 'unpaid');
                        updateInvoiceDisplay(requestId, data.invoice);
                        var paymentForm = modal.querySelector('form[data-consultation-ajax] [name="payment_status"]');
                        if (paymentForm) paymentForm.closest('form').remove();
                        form.remove();
                    } else if (form.querySelector('[name="payment_status"]')) {
                        updatePaymentDisplay(requestId, data.payment_status);
                        updateInvoiceDisplay(requestId, data.invoice);
                    } else if (form.querySelector('[name="note"]')) {
                        var list = modal.querySelector('[data-notes-list]');
                        var emptyMessage = list.querySelector('.text-muted');
                        if (emptyMessage && emptyMessage.textContent.trim() === 'No notes yet.') emptyMessage.remove();
                        var note = document.createElement('div');
                        note.className = 'consultation-note';
                        var body = document.createElement('span');
                        body.className = 'consultation-note-body';
                        body.textContent = data.note.note;
                        var meta = document.createElement('small');
                        meta.className = 'consultation-note-meta';
                        meta.textContent = data.note.author + ' · ' + data.note.created_at;
                        note.appendChild(body);
                        note.appendChild(meta);
                        list.appendChild(note);
                        modal.querySelector('[data-note-count]').textContent = '(' + data.notes_count + ')';
                        form.querySelector('textarea[name="note"]').value = '';
                        showFeedback(form, data.message, false);
                    } else if (data.request && row) {
                        row.querySelector('[data-request-message]').textContent = data.request.message;
                        row.querySelector('[data-request-message]').title = data.request.message;
                        row.querySelector('[data-request-status]').textContent = data.request.status.charAt(0).toUpperCase() + data.request.status.slice(1);
                        row.querySelector('[data-request-scheduled]').textContent = data.request.scheduled_at || '—';
                        showFeedback(form, data.message, false);
                    }
                }).catch(function (error) {
                    showFeedback(form, error.message, true);
                }).finally(function () {
                    if (button) button.disabled = false;
                });
            });
        });

        function bindForm(form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                if (form.hasAttribute('data-cancel-invoice') && !window.confirm('Are you sure you want to cancel this invoice?')) {
                    return;
                }
                var button = form.querySelector('button[type="submit"]');
                if (button) button.disabled = true;
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: new FormData(form)
                }).then(function (response) {
                    return response.json().then(function (data) {
                        if (!response.ok) throw new Error(data.message || 'Unable to update payment status.');
                        return data;
                    });
                }).then(function (data) {
                    var modal = form.closest('.modal');
                    var requestId = modal.id.replace('consultation-modal-', '');
                    if (form.hasAttribute('data-cancel-invoice')) {
                        updatePaymentDisplay(requestId, 'unpaid');
                        updateInvoiceDisplay(requestId, data.invoice);
                        var paymentForm = modal.querySelector('form[data-consultation-ajax] [name="payment_status"]');
                        if (paymentForm) paymentForm.closest('form').remove();
                        form.remove();
                    } else {
                        updatePaymentDisplay(requestId, data.payment_status);
                        updateInvoiceDisplay(requestId, data.invoice);
                        showFeedback(form, data.message, false);
                    }
                }).catch(function (error) {
                    showFeedback(form, error.message, true);
                }).finally(function () {
                    if (button) button.disabled = false;
                });
            });
        }
    })();
</script>
@endpush
