@extends('layouts.app')
@section('content')
<div class="box-title bg-white" style="color: black">
    <div class="row">
        <div class="d-flex gap-4 flex-column flex-md-row p-3 mb-2">
            <a class="text-decoration-none text-gray-800 "
                href="{{route('admin.tutor.trx.history',$id)}}">Payment Transction</a>
            <a class="text-decoration-none text-gray-800 active-border" href="{{route('admin.tutor.membership.trx.history',$id)}}">Membership Transction</a>
            <a class="text-decoration-none text-gray-800" href="{{route('admin.tutor.refund.trx.history',$id)}}">Refund Transction</a>
            <a class="text-decoration-none text-gray-800" href="{{route('admin.tutor.payment.method',$id)}}">Payment Method</a>

            {{-- <a class="text-decoration-none text-gray-800" href="{{route('admin.tutor.verified')}}">Verified Tutor</a> --}}

            {{-- <a class="text-decoration-none text-gray-800 " href="{{route('admin.boost.featured')}}">Boost Tutor</a> --}}

        </div>
    </div>
</div>

<div class="bg-white shadow-lg rounded-3 p-2 my-4">
    <div class="bg-white pb-4 mb-b">
        <div class="table-responsive">
            <table class="table table-sm table-hover bg-white shadow-none" style="border-collapse: collapse">
                <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                    <tr>
                        <th scope="col" class="text-nowrap">
                            #SL
                        </th>
                        <th scope="col" class="text-nowrap">Payment Method</th>
                        <th scope="col" class="text-nowrap">Payment Amount</th>
                        <th scope="col" class="text-nowrap">Sender Number</th>
                        <th scope="col" class="text-nowrap">Transaction ID</th>
                        <th scope="col" class="text-nowrap">Payment For</th>
                        <th scope="col" class="text-nowrap">Date</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($transctions as $item)
                        <tr class="" style="vertical-align: middle">
                            <td class="">{{ $loop->iteration ?? 'n/a'}}</td>
                            <td class="">{{ $item->payment_method ?? 'n/a'}}</td>
                            <td class="">{{ $item->received_amount ?? 'n/a'}}</td>
                            <td class="">{{ $item->received_number ?? 'n/a'}}</td>
                            <td class="">{{ $item->trx_id ?? 'n/a'}}</td>
                            <td class="">{{ $item->service_category ?? 'n/a'}}</td>
                            <td class="">{{ $item->created_at->toDateString() ?? 'n/a'}}</td>
                        </tr>


                    @endforeach

                </tbody>

            </table>
        </div>
        <!-- pagination starts here -->
        <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
            {{ $transctions->appends(request()->query())->links() }}
        </div>
        <!-- pagination ends here -->
    </div>
</div>


@endsection
