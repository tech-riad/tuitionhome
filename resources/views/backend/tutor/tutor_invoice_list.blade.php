@extends('layouts.app')
@section('content')

<style>
    .invoice-status-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin: 18px 0;
    }

    .invoice-status-filters .btn {
        border-radius: 20px;
    }

    .invoice-status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .invoice-status-pending {
        color: #a76400;
        background: #fff5df;
        border: 1px solid #f6d79a;
    }

    .invoice-status-paid {
        color: #188044;
        background: #e8f7ee;
        border: 1px solid #b6e6c8;
    }

    .invoice-status-overdue {
        color: #b42318;
        background: #fff0ef;
        border: 1px solid #f3c1bd;
    }

    .invoice-status-cancelled,
    .invoice-status-other {
        color: #606875;
        background: #f0f1f3;
        border: 1px solid #d8dbe0;
    }

    .rating i {
        font-size: 2rem;
        color: #ccc;
        cursor: pointer;
        transition: color 0.3s;
    }

    .rating i.selected {
        color: #ffbc0b;
    }

    .modal-footer button {
        font-weight: bold;
        padding: 10px;
        border-radius: 10px;
    }

</style>
<div class="box-title bg-white" style="color: black">
    <div class="row">
        <ul id="tab_nav" class="nav nav-pills">
            <li class="nav-item"> <a class="nav-link "
                    href="{{route('admin.tutor.tutorshow',$tutor->id)}}" role="tab" aria-controls="tutor-information" aria-selected="true">Tutor
                    Information</a></li>

            <li class="nav-item active-border"><a class="nav-link "
                    href="{{route('admin.tutor.invoice.list',$tutor->id)}}" aria-selected="true">
                    Invoice List</a></li>
        </ul>
    </div>
</div>

{{-- Tutor-details --}}
<br>

@php
    $invoiceFilters = [
        'all' => 'All',
        'pending' => 'Pending',
        'paid' => 'Paid',
        'overdue' => 'Overdue',
        'cancelled' => 'Cancelled',
    ];
@endphp

<div class="d-flex flex-wrap justify-content-between align-items-center">
    <div>
        <h4 class="mb-1">Invoices <span class="badge bg-primary">{{ $counts['all'] }}</span></h4>
        <p class="text-muted mb-0">All billing invoices for this tutor</p>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTutorInvoiceModal">
        Create Invoice
    </button>
</div>

@if (session('success'))
    <div class="alert alert-success mt-3" role="status">{{ session('success') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger mt-3" role="alert">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<div class="modal fade" id="createTutorInvoiceModal" tabindex="-1" aria-labelledby="createTutorInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.tutor.invoice.store', $tutor->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createTutorInvoiceModalLabel">Create Invoice for {{ $tutor->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tutor-invoice-type" class="form-label">Invoice Type <span class="text-danger">*</span></label>
                        <select id="tutor-invoice-type" name="invoice_type" class="form-select" required>
                            <option value="">Select type</option>
                            @foreach ($invoiceTypes as $invoiceType)
                                <option value="{{ $invoiceType }}" @if (old('invoice_type') === $invoiceType) selected @endif>
                                    {{ ucfirst(str_replace('_', ' ', $invoiceType)) }}
                                </option>
                            @endforeach
                            <option value="random" @if (old('invoice_type') === 'random') selected @endif>Random</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tutor-invoice-amount" class="form-label">Amount (BDT) <span class="text-danger">*</span></label>
                        <input id="tutor-invoice-amount" type="number" name="amount" class="form-control"
                            value="{{ old('amount') }}" min="0.01" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="tutor-invoice-payment-date" class="form-label">Payment Date <span class="text-danger">*</span></label>
                        <input id="tutor-invoice-payment-date" type="date" name="payment_date" class="form-control"
                            value="{{ old('payment_date', now()->addDays(7)->format('Y-m-d')) }}" required>
                    </div>
                    <p class="text-muted mb-0">Invoice number will be generated automatically.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Invoice</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="invoice-status-filters" aria-label="Filter invoices by status">
    @foreach ($invoiceFilters as $filter => $label)
        <a href="{{ route('admin.tutor.invoice.list', ['tutorId' => $tutor->id, 'status' => $filter]) }}"
            class="btn btn-sm {{ $status === $filter ? 'btn-primary' : 'btn-outline-primary' }}"
            @if ($status === $filter) aria-current="page" @endif>
            {{ $label }} <span class="ms-1">{{ $counts[$filter] }}</span>
        </a>
    @endforeach
</div>

<div class="table-responsive" id="confirmApplicationTable">
        <table class="table bg-white shadow-none border border-1" id="comfirmApplicationTable">
            <thead>
                <tr class="bg-light" style="border-bottom: 1px solid #dee2e6">
                    <th scope="col">Issue Date</th>
                    <th scope="col">Tutor Id</th>
                    <th scope="col">Payment Date</th>
                    <th scope="col">Invoice Number</th>
                    <th scope="col">Issued By </th>
                    <th scope="col">Owned By</th>
                    <th scope="col" class="text-nowrap">Job ID</th>
                    <th scope="col" class="text-nowrap">Type</th>
                    <th scope="col" class="text-nowrap">Status</th>
                    <th scope="col" class="text-nowrap">Amount</th>
                    <th scope="col" class="text-nowrap">Copy Link</th>

                    <th scope="col" class="text-nowrap">Action</th>
                    <th scope="col" class="text-nowrap">Notes</th>
                    <th scope="col" class="text-nowrap">Update Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice)

                <tr style="border-bottom: 1px solid #dee2e6">
                    <th scope="row" class="d-flex align-items-center gap-4 border-0">
                        <input class="form-check-input me-2" type="checkbox" value="" />
                        <p class="m-0 text-nowrap">{{ $invoice->issued_at ?? 'n/a' }}</p>
                    </th>

                    <td> {{$invoice->unique_id ?? 'n/a'}}</td>
                    <td> {{$invoice->payment_date ?? $invoice->new_payment_date ?? 'n/a'}}</td>
                    <td> {{$invoice->invoice_number ?? 'n/a'}}</td>
                    <td> {{$invoice->render->name ?? 'n/a'}}</td>
                    <td> {{$invoice->owner->name ?? 'n/a'}}</td>
                    <td> {{$invoice->job_number ?? 'n/a'}}</td>
                    <td> {{$invoice->invoice_type ?? 'n/a'}}</td>
                    <td>
                        @php
                            $invoiceStatus = strtolower($invoice->status ?? '');
                            $badgeStatus = in_array($invoiceStatus, ['cancel', 'cancelled'], true)
                                ? 'cancelled'
                                : ($invoiceStatus === 'pending' && $invoice->payment_date && \Carbon\Carbon::parse($invoice->payment_date)->lt(today())
                                    ? 'overdue'
                                    : $invoiceStatus);
                            $badgeClass = in_array($badgeStatus, ['pending', 'paid', 'overdue', 'cancelled'], true)
                                ? $badgeStatus
                                : 'other';
                        @endphp
                        <span class="invoice-status-badge invoice-status-{{ $badgeClass }}">
                            {{ $badgeStatus !== '' ? ucfirst($badgeStatus) : 'n/a' }}
                        </span>
                    </td>
                    <td> {{$invoice->amount ?? 'n/a'}}</td>
                    <td>
                        <button type="button"
                                class="btn btn-sm btn-outline-secondary"
                                title="Copy Invoice Link"
                                onclick="copyToClipboard('https://tuitionhome.xyz/invoices/{{ $invoice->tutor_id }}/{{ $invoice->id }}', this)">
                            <i class="fas fa-copy"></i>
                        </button>
                    </td>
                    {{-- {{ route('admin.invoice.show', $invoice->id) }} --}}
                    <td>
                        <button type="button"
                                class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#duplicateInvoiceModal{{ $invoice->id }}">
                            Duplicate
                        </button>

                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-primary invoice-notes-button"
                            data-notes-url="{{ route('admin.invoice.notes', $invoice->id) }}"
                            data-store-url="{{ route('admin.invoice.notes.store', $invoice->id) }}"
                            data-invoice-number="{{ $invoice->invoice_number }}"
                            data-note-count="{{ $invoice->notes_count }}">
                            Notes ({{ $invoice->notes_count }})
                        </button>
                    </td>
                    <td>
                        @if (in_array((int) Auth::user()->role_id, [1, 6], true))
                            @if ($invoiceStatus === 'paid')
                                <span class="text-muted">Paid (final)</span>
                            @else
                                <form action="{{ route('admin.tutor.invoice.status', ['tutorId' => $tutor->id, 'invoiceId' => $invoice->id]) }}"
                                    method="POST" class="invoice-status-update-form d-flex align-items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="filter" value="{{ $status }}">
                                    <select name="status" class="form-select form-select-sm"
                                        aria-label="Update status for invoice {{ $invoice->invoice_number }}">
                                        @if ($invoiceStatus === 'pending')
                                            <option value="pending" selected>Pending</option>
                                            <option value="paid">Paid</option>
                                            <option value="cancelled">Cancelled</option>
                                        @else
                                            <option value="cancelled" selected>Cancelled</option>
                                            <option value="pending">Reopen as pending</option>
                                        @endif
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary text-nowrap">Update</button>
                                </form>
                            @endif
                        @elseif ($invoiceStatus === 'pending')
                            <form action="{{ route('admin.tutor.invoice.status', ['tutorId' => $tutor->id, 'invoiceId' => $invoice->id]) }}"
                                method="POST" class="invoice-status-update-form">
                                @csrf
                                <input type="hidden" name="filter" value="{{ $status }}">
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Cancel</button>
                            </form>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>

                </tr>
                <div class="modal fade" id="duplicateInvoiceModal{{ $invoice->id }}" tabindex="-1"
                    aria-labelledby="duplicateInvoiceModalLabel{{ $invoice->id }}" aria-hidden="true">

                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="duplicateInvoiceModalLabel{{ $invoice->id }}">
                                    Duplicate Invoice
                                </h5>

                                <button type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>

                            <form action="{{ route('admin.taken_offer.invoice.duplicate', $invoice->id) }}"
                                method="POST">

                                @csrf

                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label class="form-label">
                                            Amount <span class="text-danger">*</span>
                                        </label>

                                        <input type="number"
                                            name="new_amount"
                                            class="form-control"
                                            value=""
                                            min="0"
                                            step="0.01"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">
                                           Due Payment Date <span class="text-danger">*</span>
                                        </label>

                                        <input type="date"
                                            name="new_payment_date"
                                            class="form-control"
                                            value="{{ $invoice->payment_date ? \Carbon\Carbon::parse($invoice->payment_date)->format('Y-m-d') : now()->format('Y-m-d') }}"
                                            required>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button"
                                            class="btn btn-secondary"
                                            data-bs-dismiss="modal">
                                        Cancel
                                    </button>

                                    <button type="submit" class="btn btn-primary">
                                        Duplicate Invoice
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                @endforeach

            </tbody>
        </table>

        <div class="d-flex justify-content-center align-items-center gap-2">

            {{ $invoices->links() }}

        </div>
</div>

<div class="modal fade" id="invoiceNotesModal" tabindex="-1" aria-labelledby="invoiceNotesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceNotesModalLabel">
                    Notes for invoice <span id="invoiceNotesNumber"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="invoiceNotesList" class="mb-3" aria-live="polite"></div>
                <form id="invoiceNoteForm">
                    <label for="invoiceNoteInput" class="form-label">Add Note</label>
                    <textarea id="invoiceNoteInput" name="note" class="form-control" rows="3" maxlength="5000"
                        required placeholder="Write your note here..."></textarea>
                    <div id="invoiceNoteError" class="text-danger small mt-1" role="alert"></div>
                    <div class="d-flex justify-content-end mt-2">
                        <button type="submit" id="saveInvoiceNote" class="btn btn-primary">Add Note</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection

@push('page_scripts')
@include('backend.tutor.js.swtdeleteMethod_js')

<script>
    document.querySelectorAll('.invoice-status-update-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            var status = form.querySelector('[name="status"]').value;
            var confirmation = status === 'cancelled'
                ? 'Cancel this pending invoice?'
                : (status === 'paid' ? 'Mark this invoice as paid? Revenue reports will be updated.' : '');

            if (confirmation && !window.confirm(confirmation)) {
                event.preventDefault();
            }
        });
    });

    function copyToClipboard(text, button) {
    navigator.clipboard.writeText(text).then(function () {
        button.innerHTML = '<i class="fas fa-check text-success"></i>';
        button.title = 'Copied!';

        setTimeout(function () {
            button.innerHTML = '<i class="fas fa-copy"></i>';
            button.title = 'Copy Invoice Link';
        }, 1500);
    }).catch(function () {
        alert('Copy failed!');
    });
}

    (function () {
        var modal = document.getElementById('invoiceNotesModal');
        var list = document.getElementById('invoiceNotesList');
        var form = document.getElementById('invoiceNoteForm');
        var noteInput = document.getElementById('invoiceNoteInput');
        var noteError = document.getElementById('invoiceNoteError');
        var saveButton = document.getElementById('saveInvoiceNote');
        var activeButton = null;
        var storeUrl = '';

        function showModal() {
            if (window.bootstrap && window.bootstrap.Modal) {
                window.bootstrap.Modal.getOrCreateInstance(modal).show();
            } else if (window.jQuery && typeof jQuery.fn.modal === 'function') {
                jQuery(modal).modal('show');
            }
        }

        function renderNotes(notes) {
            list.innerHTML = '';
            if (!notes.length) {
                list.textContent = 'No notes yet.';
                list.className = 'mb-3 text-muted';
                return;
            }

            list.className = 'mb-3';
            notes.forEach(function (note) {
                var item = document.createElement('div');
                item.className = 'border rounded p-2 mb-2';
                var body = document.createElement('p');
                body.className = 'mb-1';
                body.textContent = note.note;
                var creator = document.createElement('small');
                creator.className = 'text-muted d-block';
                creator.textContent = 'Added by: ' + note.created_by;
                var createdAt = document.createElement('small');
                createdAt.className = 'text-muted';
                createdAt.textContent = note.created_at;
                item.appendChild(body);
                item.appendChild(creator);
                item.appendChild(createdAt);
                list.appendChild(item);
            });
        }

        function loadNotes() {
            list.textContent = 'Loading notes...';
            list.className = 'mb-3 text-muted';
            jQuery.ajax({
                url: activeButton.dataset.notesUrl,
                type: 'GET',
                dataType: 'json',
                cache: false
            }).done(function (response) {
                if (response.status) renderNotes(response.data || []);
            }).fail(function () {
                list.textContent = 'Unable to load invoice notes.';
                list.className = 'mb-3 text-danger';
            });
        }

        jQuery(document).on('click', '.invoice-notes-button', function () {
            activeButton = this;
            storeUrl = this.dataset.storeUrl;
            document.getElementById('invoiceNotesNumber').textContent = this.dataset.invoiceNumber;
            noteInput.value = '';
            noteError.textContent = '';
            loadNotes();
            showModal();
        });

        jQuery(form).on('submit', function (event) {
            event.preventDefault();
            noteError.textContent = '';
            saveButton.disabled = true;

            jQuery.ajax({
                url: storeUrl,
                type: 'POST',
                data: jQuery(form).serialize(),
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            }).done(function (response) {
                if (response.status) {
                    noteInput.value = '';
                    activeButton.dataset.noteCount = response.count;
                    activeButton.textContent = 'Notes (' + response.count + ')';
                    loadNotes();
                }
            }).fail(function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    noteError.textContent = xhr.responseJSON.errors.note
                        ? xhr.responseJSON.errors.note[0]
                        : 'Please check the submitted note.';
                } else {
                    noteError.textContent = 'Unable to save the note. Please try again.';
                }
            }).always(function () {
                saveButton.disabled = false;
            });
        });
    })();
</script>

@endpush
