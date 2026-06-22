@extends('layouts.app')
@section('content')
<div class="box-title bg-white" style="color: black">
    <div class="row">
        <div class="d-flex gap-4 flex-column flex-md-row p-3 mb-2">
            <a class="text-decoration-none text-gray-800 " href="#">Payment
                Transction</a>
            <a class="text-decoration-none text-gray-800 active-border"
                href="#">Invoice</a>

            <a class="text-decoration-none text-gray-800 "
                href="#">Membership Transction</a>
            <a class="text-decoration-none text-gray-800" href="#">Refund
                Transction</a>
            <a class="text-decoration-none text-gray-800 " href="#">Payment
                Method</a>
            {{-- <a class="text-decoration-none text-gray-800" href="{{route('admin.tutor.verified')}}">Verified
            Tutor</a> --}}

            {{-- <a class="text-decoration-none text-gray-800 " href="{{route('admin.boost.featured')}}">Boost Tutor</a>
            --}}

        </div>
    </div>
</div>

<div class="row align-items-center pt-5">
    <div class="col-lg-12">
        <div class="bg-white shadow-lg rounded p-4"
            style="background-image: url(&quot;/assets/bg-6de72e9e.svg&quot;); background-repeat: no-repeat; background-position: center center;">
            <div class="d-flex gap-md-4 gap-lg-0 flex-column flex-md-row justify-content-between pb-2"
                style="border-bottom: 3px dashed rgb(137, 142, 153);">
                <div class="mb-4 mb-md-0"><img class="img-fluid" src="https://tuitionterminal.com.bd/assets/logo-50a5eec0.svg" height="60" alt="logo">
                </div>
                <div class="lh-kom">
                    <h5>Tuition Terminal</h5>
                    <p>Corporate Head Office Flat D-4,</p>
                    <p>House-10/5, TolarbaghR/A</p>
                    <p>Section-1, Mirpur, Dhaka-1216</p>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row justify-content-start pb-2">
                <div class="lh-kom  pt-5">
                    <p>Date : {{$invoiceData['createdDate']}}</p>
                    <h5>Invoice To : {{$invoiceData['tutorName']}}</h5>
                    <p class="text-nowrap">Email : {{$invoiceData['tutorEmail']}}</p>
                    <p>Tutor ID : {{$invoiceData['tutorId']}}</p>
                </div>
                <div class="pt-4 mt-3" style="padding-left: 380px;">Invoice No - {{$invoiceData['invoiceNo']}}</div>
            </div>
            <div class="mt-5">
                <div class="table-responsive">
                    <table class="table table-striped shadow-none " style="border: 1px solid rgb(240, 241, 242);">
                        <thead>
                            <tr class="" style="background-color: rgb(59, 60, 61);">
                                <th scope="col" class=" text-white text-nowrap"
                                    style="width: 20%; font-size: 16px; font-weight: 300;">SL NO</th>
                                <th scope="col" class=" text-white text-nowrap"
                                    style="width: 30%; font-size: 16px; font-weight: 300;"><span
                                        class="d-none d-md-inline">Payment</span>Date</th>
                                <th scope="col" class=" text-white text-nowrap"
                                    style="width: 30%; font-size: 16px; font-weight: 300;">Job ID</th>
                                <th scope="col" class=" text-white text-nowrap"
                                    style="font-size: 16px; font-weight: 300;">Net <span
                                        class="d-none d-md-inline">Amount Received</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">01</th>
                                <td>{{$invoiceData['createdDate']}}</td>
                                <td>{{$invoiceData['jobId']}}</td>
                                <td>{{$invoiceData['amount']}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-1"
                style="line-height: 0.5; color: rgb(59, 60, 61); font-weight: 500;">
                <p class="mt-2"><span class="me-4 ">Total Paid :</span>{{$invoiceData['amount']}} TK</p>
            </div>
            <div class="d-flex flex-column-reverse flex-md-row pt-5 justify-content-between pb-2">
                <div class=" w-75">
                    <h6>THANKS</h6>
                    <p class="fs-16">for the transactions with us. Wishing you a flamboyant future as we are very happy
                        to get a prospect like you.</p>
                </div>
            </div>
            <div style="width: 100%; height: 300px;"></div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="d-flex justify-content-center align-items-center gap-0 gap-md-4 flex-wrap w-75">
                    <p><i class="bi bi-telephone-fill me-2"></i>09678 444477</p>
                    <p> <i class="bi bi-telephone-fill me-2"></i>01757 444477</p>
                    <p><i class="bi bi-envelope-fill me-2"></i>info@tuionterminal.com.bd</p>
                    <p><i class="bi bi-globe me-2"></i>tuionterminal.com.bd</p>
                </div>
            </div>
        </div>
    </div>

</div>







@endsection
