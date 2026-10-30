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
                    <th scope="col" class="text-nowrap">Status</th>
                    <th scope="col" class="text-nowrap">Amount</th>
                    <th scope="col" class="text-nowrap">Copy Link</th>

                    <th scope="col" class="text-nowrap">Action</th>
                    <th scope="col"></th>
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
                        @if ($invoice->job_id != null)
                        <button type="button"
                                class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#duplicateInvoiceModal{{ $invoice->id }}">
                            Duplicate
                        </button>

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



@endsection

@push('page_scripts')
@include('backend.tutor.js.swtdeleteMethod_js')

<script>
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
</script>

@endpush
