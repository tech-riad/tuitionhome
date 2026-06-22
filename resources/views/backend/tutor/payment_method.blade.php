@extends('layouts.app')
@section('content')
<div class="box-title bg-white" style="color: black">
    <div class="row">
        <div class="d-flex gap-4 flex-column flex-md-row p-3 mb-2">
            <a class="text-decoration-none text-gray-800 " href="{{route('admin.tutor.trx.history',$id)}}">Payment
                Transction</a>
            <a class="text-decoration-none text-gray-800 "
                href="{{route('admin.tutor.membership.trx.history',$id)}}">Membership Transction</a>
            <a class="text-decoration-none text-gray-800" href="{{route('admin.tutor.refund.trx.history',$id)}}">Refund
                Transction</a>
            <a class="text-decoration-none text-gray-800 active-border"
                href="{{route('admin.tutor.payment.method',$id)}}">Payment Method</a>
            {{-- <a class="text-decoration-none text-gray-800" href="{{route('admin.tutor.verified')}}">Verified
            Tutor</a> --}}

            {{-- <a class="text-decoration-none text-gray-800 " href="{{route('admin.boost.featured')}}">Boost Tutor</a>
            --}}

        </div>
    </div>
</div>


<div class="row row-cols-1 row-cols-xl-2 align-items-center pt-5">
    <div>
        <div class="bg-white rounded-3 p-4 shadow-lg mb-4 mb-xl-0">
            <div class="d-flex justify-content-between align-itesm-center mb-3">
                <p class="fw-semibold m-0">Bank Account</p>
                <div class="d-flex gap-3"><img src="https://tuitionterminal.com.bd/assets/dbbl-8123f9e7.svg"><img
                        src="https://tuitionterminal.com.bd/assets/ibbl-0d3d1844.svg">
                </div>
            </div>
            <div class="mb-1">
                <p class="text-info mb-1 fs-14">Account Name</p>
                <p class="text-capitalize">{{$tutorAccount->tutor->name ?? ''}}</p>
            </div>
            <div class="mb-1">
                <p class="text-info mb-1 fs-14">Bank Name</p>
                <p class="text-capitalize">{{$tutorAccount->b_account_name ?? ''}}</p>
            </div>
            <div class="mb-1">
                <p class="text-info mb-1 fs-14 ">Branch Name</p>
                <p class="text-capitalize">{{$tutorAccount->b_branch_name ?? ''}}</p>
            </div>
            <div class="mb-1">
                <p class="text-info mb-1 fs-14">Account Type</p>
                <p>{{$tutorAccount->b_account_type ?? ''}}</p>
            </div>
            <div class="">
                <p class="text-info mb-1 fs-14">Ac/No</p>
                <p>{{$tutorAccount->b_account_number ?? ''}}</p>
            </div>
            <div class="d-flex justify-content-end"><button class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#baccount">Edit</button></div>
        </div>
    </div>
    <div>
        <div class="bg-white rounded-3 p-4 shadow-lg"><img
                src="https://tuitionterminal.com.bd/assets/bkash-ef005c28.svg">
            <div class="mb-5">
                <p class="text-info mb-1 fs-14">Account Name</p>
                <p class="text-capitalize">{{$tutorAccount->tutor->name ?? ''}}</p>
            </div>
            <div class="mb-5">
                <p class="text-info mb-1 fs-14">Account Type</p>
                <p>{{$tutorAccount->account_type ?? ''}}</p>
            </div>
            <div class="">
                <p class="text-info mb-1 fs-14">Account Number</p>
                <p>{{$tutorAccount->number ?? ''}}</p>
            </div>
            <div class="d-flex justify-content-end"><button class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#maccount">Edit</button></div>
        </div>
    </div>
</div>
<!-- Mobile Banking Account Modal -->
<div class="modal fade" id="maccount" tabindex="-1" aria-labelledby="maccount" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-2">
            <button type="hidden" class="d-none" data-bs-dismiss="modal">close</button>
            <div class="modal-body">
                <form id="mobileBankingForm">
                    <input type="hidden" name="provider" value="mobile_banking">
                    <div class="mb-3">
                        <label class="form-label dark-semibold-label">Account Name</label>
                        <input type="text" class="form-control rounded shadow-none" name="account_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label dark-semibold-label">Account Type</label>
                        <select class="form-select rounded shadow-none" name="account_type" required>
                            <option value="Personal">Personal</option>
                            <option value="Marchant">Marchant</option>
                            <option value="Agent">Agent</option>
                        </select>
                    </div>
                    <div class="">
                        <label class="form-label dark-semibold-label">Account Number</label>
                        <input type="text" class="form-control rounded shadow-none" name="number" required>
                    </div>
                    <div class="modal-footer p-0 pt-4">
                        <button class="btn btn-primary" type="submit">Apply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bank Account Modal -->
<div class="modal fade" id="baccount" tabindex="-1" aria-labelledby="baccount" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-2">
            <button type="hidden" class="d-none" data-bs-dismiss="modal">close</button>
            <div class="modal-body">
                <form id="bankForm">
                    <input type="hidden" name="provider" value="bank">
                    <div class="mb-3">
                        <label class="form-label dark-semibold-label">Account Name</label>
                        <input type="text" class="form-control rounded shadow-none" name="b_account_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label dark-semibold-label">Branch Name</label>
                        <input type="text" class="form-control rounded shadow-none" name="b_branch_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label dark-semibold-label">Account Type</label>
                        <select class="form-select rounded shadow-none" name="b_account_type" required>
                            <option value="Savings">Savings</option>
                            <option value="Current">Current</option>
                            <option value="Deposit">Deposit</option>
                        </select>
                    </div>
                    <div class="">
                        <label class="form-label dark-semibold-label">Account Number</label>
                        <input type="text" class="form-control rounded shadow-none" name="b_account_number" required>
                    </div>
                    <div class="modal-footer p-0 pt-4">
                        <button class="btn btn-primary" type="submit">Apply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

    $('#mobileBankingForm').on('submit', function (e) {
        e.preventDefault();

        let formData = $(this).serialize();
        let tutorId = {{$id}};

        $.ajax({
            url: `/admin/tutor/account-add/${tutorId}`,
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (response) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Account updated successfully",
                    showConfirmButton: false,
                    timer: 1000,
                });
                $('#maccount').modal('hide');
                location.reload();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('An error occurred. Please try again.');
            }
        });
    });


    $('#bankForm').on('submit', function (e) {
        e.preventDefault();

        let formData = $(this).serialize();
        let tutorId = {{$id}};

        $.ajax({
            url: `/admin/tutor/account-add/${tutorId}`,
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (response) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Account updated successfully",
                    showConfirmButton: false,
                    timer: 1000,
                });
                $('#baccount').modal('hide'); // Close modal
                location.reload(); // Reload page
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('An error occurred. Please try again.');
            }
        });
    });
});

</script>


@endsection
