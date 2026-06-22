@extends('layouts.app')

@push ('page_css')

  @endpush


@section('content')

<main class="container-custom">
    <div class="col-md-9 ms-sm-auto col-lg-12" style="">
      <!-- main content section starts here -->
      <div class="py-4 ps-3" style="padding-right: 13px">
        <div class="bg-white rounded-3 shadow-lg px-4 pt-4 pb-2">
          <div class="row row-cols-1 row-cols-md-2">
            <div>
              <div class="border-end">
                <div class="row row-cols-2 mb-3 g-0">
                  <p class="fw-semibold">Job ID</p>
                  <p class=" ">{{$sms_content->job_id ?? ''}}</p>
                </div>
                <div class="row row-cols-2 mb-3 g-0">
                  <p class="fw-semibold">Sender Name</p>
                  <p class=" ">{{$sms_content->sender_name ?? ''}}</p>
                </div>
                <div class="row row-cols-2 mb-3 g-0">
                  <p class="fw-semibold">Sender ID</p>
                  <p class=" ">{{$sms_content->sender_id ?? ''}}</p>
                </div>
              </div>
            </div>
            <div>
                @php
                                                $input = $sms_content->created_at;
                                                $format1 = 'd-m-Y';
                                                $format2 = 'H:i:s';
                                                $date = Carbon\Carbon::parse($input)->format($format1);
                                                $time = Carbon\Carbon::parse($input)->format($format2);
                                            @endphp
              <div class="">
                <div class="row row-cols-2 mb-3 g-0">
                  <p class="fw-semibold">SMS Method</p>
                  <p class="">{{$sms_content->sms_method ?? ''}}</p>
                </div>
                <div class="row row-cols-2 g-0">
                  <p class="fw-semibold">Received Number</p>
                  <p class=" ">{{$sms_content->tutor_phone ?? ''}}</p>
                </div>
                <div class="row row-cols-2 align-items-center mb-3 g-0">
                  <p class="fw-semibold mt-3">Created At</p>
                  <div class=" ">
                    <p class="mb-0">{{$date ?? ''}}</p>
                    <p class="mb-0 text-muted">{{ $time  ?? ''}}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-12 col-lg-3 fw-semibold">
              <p>SMS Title</p>
            </div>
            <div class="col-12 col-lg-9">
              <p class="border p-3 border-info rounded">
                {{ $sms_content->sms_body }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- main content section ends here -->
    </div>
  </main>




@endsection

@push('page_scripts')


@endpush
