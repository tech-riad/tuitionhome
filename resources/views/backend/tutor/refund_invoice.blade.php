@extends('layouts.app')
@section('content')
<div class="box-title bg-white" style="color: black">
    <div class="row">
        <div class="d-flex gap-4 flex-column flex-md-row p-3 mb-2">
            <a class="text-decoration-none text-gray-800 " href="{{route('admin.tutor.trx.history',$id)}}">Payment
                Transction</a>
            <a class="text-decoration-none text-gray-800 "
                href="{{route('admin.tutor.payment.invoice',$id)}}">Invoice</a>

            <a class="text-decoration-none text-gray-800 "
                href="{{route('admin.tutor.membership.trx.history',$id)}}">Membership Transction</a>
            <a class="text-decoration-none text-gray-800 " href="{{route('admin.tutor.refund.trx.history',$id)}}">Refund
                Transction</a>
            <a class="text-decoration-none text-gray-800 active-border"
                href="{{route('admin.tutor.invoice.refund',$id)}}">Refund Invoice</a>

            <a class="text-decoration-none text-gray-800 " href="{{route('admin.tutor.payment.method',$id)}}">Payment
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
        @foreach ($refundData as $item)
        <div class="bg-white p-4 shadow-lg rounded-3 mb-4">
            <div class="d-flex justify-content-between">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="bg-primary py-1 px-2 rounded text-white">Invoice</div>
                    <h4 class="text-uppercase ms-2 mt-2">{{$item['invoiceNo']}}</h4>
                </div>
            </div>
            <div class="d-flex mt-4 flex-wrap">
                <p class="key mt-1" style="font-size: 15px;">Refund For:<span class="text-info ms-1">Tution Matching
                        Service Charge | Job ID : {{$item['jobId']}}</span></p>
                <div class="d-flex justify-content-center align-items-center" style="font-size: 0.7rem;">
                    <div class=" me-2">
                        <p class="fw-normal">Paid Date:</p>
                    </div>
                    <div class="bg-light border rounded-3 mb-3 shadow-none py-1 px-2 fw-light">{{$item['paidDate'] ?? 'N/A' }}</div>
                </div>
            </div>
            <div class="d-flex justify-content-between flex-wrap">
                <p class="fw-light"><span class="fw-semibold fs-5 me-1">{{$item['amount']}}</span>Taka</p>
                <div class="">
                    <div>
                        @if ($item['amount'] == $item['paymentAmount'] + $item['refundCoin'])
                            <button class="btn fw-500"
                                style="background-color: rgb(230, 238, 247); color: rgb(51, 120, 194); font-weight: bold; padding-left: 35px; padding-right: 35px;">
                                Paid
                            </button>
                        @else
                            <button class="btn fw-500"
                                style="background-color: rgb(230, 238, 247); color: rgb(51, 120, 194); font-weight: bold; padding-left: 35px; padding-right: 35px;">
                                Pending
                            </button>
                        @endif


                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>







@endsection
