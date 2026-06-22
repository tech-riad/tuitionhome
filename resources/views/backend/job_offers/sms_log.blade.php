@extends('layouts.app')
@push('page_css')
@endpush


@section('content')
<main class="container-custom">
    @php
    $sms_pushup = App\Models\JobSms::where('sms_method','pushup')->count();
    $sms_pullup = App\Models\JobSms::where('sms_method','pullup')->count();
    // dd($sms_pullup);
    @endphp

    <div class="col-md-9 ms-sm-auto col-lg-12" style="">
        <!-- main content section starts here -->
        <div class="ps-3 py-4" style="padding-right: 13px">
            <div class="row row-cols-2 row-cols-lg-4 gap-0 gap-lg-4 gx-0 mb-3">
                <div>
                    <div
                        class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                        <p class="fw-bold fs-5 mb-1 mt-3">{{$sms_pullup}}</p>
                        <p class="">Pullup</p>
                    </div>
                </div>
                <div class="ps-2 ps-lg-0">
                    <div
                        class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                        <p class="fw-bold fs-5 mb-1 mt-3">{{$sms_pushup}}</p>
                        <p class="">Pushup</p>
                    </div>
                </div>
            </div>
            <div class="">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="bi bi-sliders2 me-1"></i>Filter
                </button>
            </div>
            <div class="mt-4">
                <div class="pt-2 shadow-lg rounded-3 bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover bg-white shadow-none" style="border-collapse: collapse">
                            <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                                <tr>
                                    <th scope="col" class="text-nowrap ps-4">SL</th>
                                    <th scope="col" class="text-nowrap">Job ID</th>
                                    <th scope="col" class="text-nowrap">Sender Name</th>
                                    <th scope="col" class="text-nowrap">Sender Id</th>
                                    <th scope="col" class="text-nowrap">sms Title</th>
                                    <th scope="col" class="text-nowrap">Tutor Id</th>

                                    <th scope="col" class="text-nowrap">Tutor Phone</th>

                                    <th scope="col" class="text-nowrap">Created At</th>
                                    <th scope="col" class="text-nowrap ps-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($job_sms as $sms)

                                    <tr class="" style="vertical-align: middle">
                                        <td scope="row " class="text-center text-nowrap" style="padding: 30px 18px">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="">{{ $sms->job_id }}</td>

                                        <td class="text-nowrap">{{ $sms->sender_name }}</td>

                                        <td class="">{{ $sms->sender_id }}</td>
                                        <td class="text-nowrap">
                                            {{ Str::limit($sms->sms_body, 30) }}
                                        </td>
                                        <td class="text-wrap">{{ $sms->tutor_id }}</td>
                                        <td class="text-nowrap">{{ $sms->tutor_phone }}</td>

                                        @php
                                        $input = $sms->created_at;
                                        $format1 = 'd-m-Y';
                                        $format2 = 'H:i:s';
                                        $date = Carbon\Carbon::parse($input)->format($format1);
                                        $time = Carbon\Carbon::parse($input)->format($format2);
                                        @endphp

                                        <td class="text-nowrap">
                                            <p class="mb-0">{{ $date }}</p>
                                            <p class="mb-0 text-muted">{{ $time }}</p>
                                        </td>

                                        <td class="d-flex p-4 gap-1">
                                            <a class="btn btn-primary py-1 px-2"
                                                href="{{ route('admin.job.sms-view',$sms->id) }}">
                                                View
                                            </a>

                                            <button class="btn btn-info py-1 px-2 text-nowrap"
                                            onclick="prepareResend('{{ $sms->job_id }}', '{{ $sms->tutor_id }}',
                                             '{{ $sms->tutor_phone }}','{{ $sms->sms_body }}','{{ $sms->sms_title }}',
                                             '{{ $sms->sms_method }}')">
                                                Resend
                                            </button>
                                            <form action="{{ route('admin.job.tutor.resend.sms') }}" method="post" id="tutorSendSms">
                                                @csrf
                                                <input type="hidden" id="sms_job_ids" name="sms_job_ids">
                                                <input type="hidden" id="tutor_ids" name="tutor_ids">
                                                <input type="hidden" id="tutor_phones" name="tutor_phones">
                                                <input type="hidden" id="sms_bodies" name="sms_bodies">
                                                <input type="hidden" id="sms_titles" name="sms_titles">
                                                <input type="hidden" id="sms_methods" name="sms_methods">
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center align-items-center gap-2 pt-4 pb-5">
                        {{$job_sms->links()}}
                    </div>
                </div>
            </div>
        </div>

        <!-- main content section ends here -->
        <!-- Filter model starts here -->
        <div class="modal fade font-pop" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered px-3" style="max-width: 1100px">
                <div class="modal-content pt-4 pb-4 ps-2">
                    <div class="modal-header pe-5" style="padding-left: 40px">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                            Filter
                            <span class="text-muted fw-light" style="font-size: 12">
                            </span>
                        </h1>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-0">
                        <div class="row row-cols-2 row-cols-lg-4 pb-2 ps-4 pt-2">
                            <div class="d-flex">
                                <div>
                                    <div class="pb-3">
                                        <label for="en" class="form-label">Employee Name</label>

                                        <select id="en" class="shadow rounded-2 form-select"
                                            aria-label="Default select example">
                                            <option selected>Select Employee Name</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                    <div class="pb-3">
                                        <label for="eid" class="form-label">Employee ID</label>

                                        <input type="text" class="form-control shadow rounded-2" id="eid"
                                            placeholder="123567" />
                                    </div>
                                </div>
                                <div class="mb-3 ms-4" style="
                                    margin-top: 34px;
                                    width: 1px;
                                    background-color: #f0f1f2;
                                    ">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="flex-grow-1">
                                    <div class="pb-3">
                                        <label for="rn" class="form-label">Received Number</label>
                                        <input type="phone" class="form-control shadow rounded-2" id="rn" />
                                    </div>
                                    <div class="pb-3">
                                        <label for="smsbody" class="form-label">SMS Body</label>

                                        <input type="text" class="form-control shadow rounded-2" id="smsbody"
                                            placeholder="SMS Body" />
                                    </div>
                                </div>
                                <div class="mb-3 ms-4" style="
                                    margin-top: 34px;
                                    width: 1px;
                                    background-color: #f0f1f2;
                                    ">
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <div class="pb-3">
                                        <label for="caf" class="form-label">Created At From</label>
                                        <input type="date" class="form-control shadow rounded-2" id="caf" />
                                    </div>
                                    <div class="pb-3">
                                        <label for="cat" class="form-label">Created At To</label>
                                        <input type="date" class="form-control shadow rounded-2" id="cat" />
                                    </div>
                                </div>
                                <div class="mb-3 ms-4" style="
                                    margin-top: 34px;
                                    width: 1px;
                                    background-color: #f0f1f2;
                                    ">
                                </div>
                            </div>
                            <div class="d-flex justify-content-start ">
                                <div class="flex-grow-1 " style="padding-right: 30px;">
                                    <div class="mb-3">
                                        <label for="smsm" class="form-label">SMS Method</label>

                                        <select id="smsm" class="shadow rounded-2 form-select"
                                            aria-label="Default select example">
                                            <option selected>Pullup</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="other" class="form-label">Other</label>

                                        <select id="other" class="shadow rounded-2 form-select"
                                            aria-label="Default select example">
                                            <option selected>Other</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Dont remove this unnessary wrapper flex div -->
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-end align-items-center me-3">
                            <div>
                                <button type="button" class="btn btn-danger py-1 me-2">
                                    Clear
                                </button>
                                <button type="button" class="btn btn-primary py-1">
                                    Apply
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Filter Model ends here -->
    </div>
</main>
@endsection

@push('page_scripts')
<script>
    function prepareResend(jobId, tutorId, tutorPhone, smsBody, smsTitle, smsMethod) {
        $("#sms_job_ids").val(jobId);
        $("#tutor_ids").val(tutorId);
        $("#tutor_phones").val(tutorPhone);
        $("#sms_bodies").val(smsBody);
        $("#sms_titles").val(smsTitle);
        $("#sms_methods").val(smsMethod);

        $("#tutorSendSms").submit();
    }
</script>
@endpush
