@extends('layouts.app')
@section('content')

<style>
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
            <li class="nav-item"> <a class="nav-link " id="tutor-information" data-toggle="pill"
                    href="#tutor-information" role="tab" aria-controls="tutor-information" aria-selected="true">Tutor
                    Information</a></li>
            <li class="nav-item"><a class="nav-link " id="tutor-login" data-toggle="pill" href="#tutor-login" role="tab"
                    aria-controls="tutor-login" aria-selected="true">Login</a></li>
            {{-- <li class="nav-item"><a href="#" class="nav-link">Present Pending</a></li> --}}
            <li class="nav-item"><a class="nav-link " id="tutor-history-details" data-toggle="pill"
                    href="#tutor-history-details" role="tab" aria-controls="tutor-history-details" aria-selected="true">
                    History</a></li>
            <li class="nav-item"><a class="nav-link " id="present-pending" data-toggle="pill" href="#present-pending"
                    role="tab" aria-controls="present-pending" aria-selected="true">
                    Present Pending</a></li>
            <li class="nav-item"><a class="nav-link " id="sms-log" data-toggle="pill" href="#sms-log" role="tab"
                    aria-controls="sms-log" aria-selected="true">
                    Sms Log</a></li>
            <li class="nav-item"><a class="nav-link " target="_blank"
                    href="{{route('admin.tutor.trx.history',$tutor->id)}}" aria-selected="true">
                    Transction History</a></li>
        </ul>
    </div>
</div>

{{-- Tutor-details --}}
<br>
<div class="tab-pane fade card-header" id="tutor-details" role="tabpanel" aria-labelledby="tutor-details">
    <div class="row">
        <div class="col-md-3">

            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                    </div>
                    @if (@$tutor->is_active == 1)
                    <div class="text-center" style="border: 1px solid rgba(167, 161, 167, 0.667) ; max-width:35%; ">
                        Active <i style="color:#34f52a" class="fas fa-circle"></i>
                    </div>
                    @endif
                    @if (@$tutor->is_active == 0)
                    <div class="text-center" style="border: 1px solid rgba(167, 161, 167, 0.667) ; max-width:35%; ">
                        Inactive <i style="color:#f5422a" class="fas fa-circle"></i>
                    </div>
                    @endif

                    @if ($tutor->image != null)
                    {{-- <div class="t-user-details mx-auto text-center my-4"><img
                            src="https://hellott.xyz/storage/tutor-images/{{$tutor->image}}"
                    loading="lazy" alt="image" class="profile-img"
                    style="width: 70px; min-height: 80px; object-fit: cover; margin-top: 16px;">

                </div> --}}
                <div class="t-user-details mx-auto text-center my-4" data-bs-toggle="modal"
                    data-bs-target="#zoomProfileImage" style="cursor: pointer;"><img
                        src="https://hellott.xyz/storage/tutor-images/{{$tutor->image}}" alt="image" class="profile-img"
                        style="width: 80px; height: 90px; object-fit: cover; margin-top: 16px;">
                    <div class="modal fade" id="zoomProfileImage" tabindex="-1" aria-labelledby="zoomProfileImage"
                        style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body d-flex justify-content-center flex-column align-items-center">
                                    <img src="https://hellott.xyz/storage/tutor-images/{{$tutor->image}}" alt="image"
                                        class="rounded"
                                        style="min-height: 400px; object-fit: cover; height: 500px; width: 100%; border: 1px solid rgb(222, 226, 230);"><button
                                        type="button" class="btn-close d-none" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                    <h4 class="mb-0 mt-3 text-capitalize one-line">{{$tutor->name}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="t-user-details mx-auto text-center my-4"><img
                        src="https://banner2.cleanpng.com/20180329/zue/kisspng-computer-icons-user-profile-person-5abd85306ff7f7.0592226715223698404586.jpg"
                        loading="lazy" alt="image" class="profile-img"
                        style="width: 70px; min-height: 80px; object-fit: cover; margin-top: 16px;">

                </div>

                @endif

                <h3 class="profile-username text-center">

                    {{@$tutor->name}}

                    @if(@$tutor->is_premium == 1)
                    <img height="30px" src="https://tuitionterminal.com.bd/assets/premium-regular-9c7ea3fd.svg" alt="">
                    @endif
                    @if(@$tutor->is_premium_pro == 1)
                    <img height="30px" src="https://tuitionterminal.com.bd/assets/premium-pro-fc790c7d.svg" alt="">
                    @endif
                    @if(@$tutor->is_premium_advance == 1)
                    <img height="30px" src="https://tuitionterminal.com.bd/assets/premium-advance-4b8e47d2.svg" alt="">
                    @endif
                    @if(@$tutor->is_verified == 1)
                    <i style="color:#007BFF" class="far fa-check-circle"></i>
                    @endif
                    @if(@$tutor->is_internal_verify == 1 && $tutor->is_verified == 0)
                    <i style="color:#ed228b" class="far fa-check-circle"></i>
                    @endif
                    @if(@$tutor->is_featured == 1)
                    <img height="30px" src="https://tuitionterminal.com.bd/assets/featured-icon-0c358655.svg" alt="">

                    @endif
                    @if(@$tutor->is_boost == 1)
                    <img height="30px" src="https://tuitionterminal.com.bd/assets/boost-icon-d47ce3c5.svg" alt="">

                    @endif
                </h3>



                </h3>
                <p class="text-muted text-center">Phone: {{@$tutor->phone}}</p>
                <p class="text-muted text-center">ID: {{@$tutor->unique_id}}</p>
                <p class="text-muted text-center"> Email: {{@$tutor->email}}</p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Tutor Balances </b>
                        <h3 class="float-right text-bg-danger">{{$tutor->balances ?? 0}}</h3>
                    </li>
                    <li class="list-group-item">
                        <b>Verified</b>
                        <a class="float-right">
                            {{@$tutor->is_verified ?? ''}}
                            @if ($tutor->is_verified != null)
                            ({{$tutor->verifier->name ?? ''}})
                            @endif
                        </a>
                    </li>
                    <li class="list-group-item">
                        <b>Internal Verify</b>
                        <a class="float-right">
                            {{@$tutor->is_internal_verify ?? ''}}
                            @if ($tutor->is_internal_verify != 0)
                            ({{$tutor->verifier->name ?? ''}})
                            @endif
                        </a>
                    </li>
                    <li class="list-group-item">
                        <b>Fetured</b>
                        <a class="float-right">
                            {{$tutor->is_featured ?? ''}}
                            @if ($tutor->is_featured != null)
                            ({{$tutor->feature->name ?? ''}})
                            @endif
                        </a>
                    </li>
                    <li class="list-group-item">
                        @if ($tutor->is_premium == 1)
                        <b>Premium</b>
                        @elseif($tutor->is_premium_pro == 1)
                        <b>Premium Pro</b>
                        @elseif($tutor->is_premium_advance == 1)
                        <b>Premium Advance</b>
                        @endif

                        <a class="float-right">
                            @if ($tutor->is_premium == 1)
                            {{$tutor->is_premium ?? ''}}
                            @elseif($tutor->is_premium_pro == 1)
                            {{$tutor->is_premium_pro ?? ''}}
                            @elseif($tutor->is_premium_advance == 1)
                            {{$tutor->is_premium_advance ?? ''}}
                            @endif

                            @if ($tutor->is_premium != null || $tutor->is_premium_pro != null ||
                            $tutor->is_premium_advance != null)
                            ({{$tutor->premire->name ?? ''}})
                            @endif
                        </a>
                    </li>
                    <li class="list-group-item">
                        <b>Premium From - To</b>
                        <a class="float-right">
                            {{ $tutor->premium_date ? \Carbon\Carbon::parse($tutor->premium_date)->format('Y-m-d') : '' }}
                            <br>
                            {{ $tutor->premium_expire ? \Carbon\Carbon::parse($tutor->premium_expire)->format('Y-m-d') : '' }}
                        </a>
                    </li>

                </ul>
            </div>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">About Me here</h3>
            </div>


            <div class="card-body">
                <strong> <i class="far fa-file-alt mr-1"></i> Education</strong>

                @foreach($tutor->tutor_education ?? [] as $tutor_edu)
                <p class="text-muted text-capitalize">
                    <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                    {{$tutor_edu->degree_name}} {{ data_get($tutor_edu->curriculam, 'title', '') }}

                    @if ($tutor_edu->departments)
                    -> {{$tutor_edu->departments->title}}
                    @endif
                    @if ($tutor_edu->education_board)
                    -> {{$tutor_edu->education_board}}
                    @endif
                    @if ($tutor_edu->group_or_major)
                    -> {{$tutor_edu->group_or_major}}
                    @endif
                    @if ($tutor_edu->passing_year)
                    -> {{$tutor_edu->passing_year}}
                    @endif
                    @if ($tutor_edu->gpa)
                    -> {{$tutor_edu->gpa}}
                    @endif
                    <br>
                    :::: {{$tutor_edu->institutes->title ?? ''}}
                </p>
                <hr>
                @endforeach

                <br>

                <strong><i class="far fa-file-alt mr-1"></i>Location</strong>

                <p class="text-muted">
                    @if (@$tutor->tutor_personal_info->country)
                    {{ $tutor->tutor_personal_info->country->name ?? ''}}
                    @endif
                    @if (@$tutor->tutor_personal_info->city)
                    -> {{ $tutor->tutor_personal_info->city->name ?? ''}}
                    @endif
                    @if (@$tutor->tutor_personal_info->location)
                    -> {{ $tutor->tutor_personal_info->location->name ?? ''}}
                    @endif
                </p>

                <hr>
                <strong><i class="far fa-file-alt mr-1"></i> Preferable Tutoring Locations</strong>
                <p class="text-muted">

                    @foreach($tutor->tutor_prefered_locations ?? [] as $pl)
                    <span class="badge badge-success">{{$pl->name}}</span>
                    @endforeach


                </p>
                <hr>
                <strong><i class="far fa-file-alt mr-1"></i> Preferred Tutoring Category</strong>
                <p class="text-muted">

                    @foreach($tutor->tutor_categories ?? [] as $tc)
                    <span class="badge badge-success">{{$tc->name}}</span>

                    @endforeach


                </p>
                <hr>
                <strong><i class="far fa-file-alt mr-1"></i> Preferred Tutoring Courses/Classes</strong>
                <p class="text-muted">
                    @foreach($tutor->tutor_course ?? [] as $course)
                    <span class="badge badge-success">{{ $course->name }}</span>
                    @endforeach
                </p>
                <hr>
                <strong><i class="far fa-file-alt mr-1"></i> Preferred Tutoring Subjects</strong>
                <br>
                @if ($tutor->course_subjects != null)
                @foreach ($tutor->course_subjects as $otcs)
                <span class="badge badge-success">
                    {{ $otcs->subject->title ?? 'N/A' }}
                    @if (@$otcs->subject->tutor_course != null)
                    @foreach ($otcs->subject->tutor_course as $course)
                    ({{ $course->name ?? 'N/A' }})
                    @endforeach
                    @endif
                </span>
                @endforeach
                @endif
                <hr>
                <strong><i class="far fa-file-alt mr-1"></i> Tutoring Experience</strong>
                <br>
                <h6 class="mt-1 ml-4">
                    @if ($tutor->tutor_personal_info)
                    {{$tutor->tutor_personal_info->tutoring_experience ?? ''}}
                    @if ($tutor->tutor_personal_info->tutoring_experience != null)
                    Years
                    @endif
                    @endif
                </h6>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Available Day</strong>
                <br>
                @foreach($tutor->tutor_days ?? [] as $day)
                <span class="badge badge-success">{{$day->title}}</span>
                @endforeach
                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Available Time</strong>
                <br>
                <h6 class="mt-1 ml-4">
                    @if (isset($tutor->tutor_personal_info->available_from) &&
                    isset($tutor->tutor_personal_info->available_to))
                    @if (\Carbon\Carbon::hasFormat($tutor->tutor_personal_info->available_from, 'Y-m-d\TH:i:s.u\Z')
                    && \Carbon\Carbon::hasFormat($tutor->tutor_personal_info->available_to, 'Y-m-d\TH:i:s.u\Z'))
                    {{ \Carbon\Carbon::parse($tutor->tutor_personal_info->available_from)->format('g:i A') }} to
                    {{ \Carbon\Carbon::parse($tutor->tutor_personal_info->available_to)->format('g:i A') }}
                    @elseif (!empty($tutor->tutor_personal_info->available_from) &&
                    !empty($tutor->tutor_personal_info->available_to) && preg_match('/^\d{1,2}:\d{2}$/',
                    $tutor->tutor_personal_info->available_from) && preg_match('/^\d{1,2}:\d{2}$/',
                    $tutor->tutor_personal_info->available_to))
                    {{ \Carbon\Carbon::parse($tutor->tutor_personal_info->available_from)->format('g A') }} to
                    {{ \Carbon\Carbon::parse($tutor->tutor_personal_info->available_to)->format('g A') }}
                    @else
                    N/A
                    @endif
                    @else
                    N/A
                    @endif
                </h6>







                <hr>
                <strong><i class="far fa-file-alt mr-1"></i> Tutoring Methods</strong>
                <br>
                @foreach($tutor->teaching_method ?? [] as $teaching_method)
                <span class="badge badge-success">{{$teaching_method->name}}</span>
                @endforeach
                <hr>
                <strong><i class="far fa-file-alt mr-1"></i> Expected Salary</strong>
                <br>
                <p class="text-muted">{{$tutor->tutor_personal_info->expected_salary ?? 'N/A'}}</p>

            </div>
        </div>


        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Tutor Profile</h3>
            </div>

            <div class="card-body">
                <a href="https://tuitionterminal.com.bd/hub/tutor-details/{{$tutor->unique_id}}" target="_blank"
                    class="btn btn-success btn-block">Visit Profile</a>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-success btn-block" data-bs-toggle="modal"
                    data-bs-target="#premiumModal_{{$tutor->id}}">
                    Make Premium
                </button>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-success btn-block" data-bs-toggle="modal"
                    data-bs-target="#verifyModal_{{$tutor->id}}">
                    Make Verify
                </button>
            </div>
            <div class="card-body">
                @if ($tutor->is_internal_verify == 0)
                <form  id="verifyTutor{{ $tutor->id }}"
                    action="{{ route('admin.tutor.verify', ['tutor' => $tutor->id]) }}" method="POST">
                    @csrf
                    <button id="{{ $tutor->id }}" type="button" class="btn btn-block btn-success"
                        onclick="verifyTutor(this, this.id)">Internal Verify</button>
                </form>
                @elseif($tutor->is_internal_verify == 1)
                <button type="button" class="btn btn-block btn-danger">Internal Verify complete</button>

                @endif
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-success btn-block" data-bs-toggle="modal"
                    data-bs-target="#boostModal_{{$tutor->id}}">
                    Make Boost
                </button>
            </div>

            <div class="card-body text-center">
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#reviewModal">
                    Make a Review
                </button>
            </div>
        </div>


        <!-- Review Modal -->
        <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form id="reviewForm" class="w-100">
                    @csrf
                    <input type="hidden" id="tutor_id" name="tutor_id" value="{{$tutor->id}}">
                    <div class="modal-content p-4">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reviewModalLabel">Rate Your Experience</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body py-0">
                            <div class="text-center mb-3">
                                <span class="rating">
                                    <i class="fas fa-star" data-value="1"></i>
                                    <i class="fas fa-star" data-value="2"></i>
                                    <i class="fas fa-star" data-value="3"></i>
                                    <i class="fas fa-star" data-value="4"></i>
                                    <i class="fas fa-star" data-value="5"></i>
                                </span>
                                <input type="hidden" id="ratingValue" name="rating" value="0">
                            </div>

                            <div class="mb-3">
                                <label for="reviewText" class="form-label fs-5 text-dark" style="font-weight: 500;">
                                    Describe Your Review in Detail
                                </label>
                                <textarea class="form-control rounded-3 shadow-none" id="reviewText" name="description" rows="4"
                                    required minlength="20" placeholder="Write your review here..."></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary w-100">Submit Review</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        {{-- Fnf Card --}}
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">FnF Referral</h3>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-success btn-block" data-bs-toggle="modal"
                    data-bs-target="#refferModal_{{ $tutor->id }}">
                    Make Referral
                </button>

                <table class="table table-responsive table-hover bg-white shadow-none"
                    style="border-collapse: collapse">
                    <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                        <tr>

                            <th scope="col" style="width: 10px" class="text-nowrap">Tutor ID</th>

                            <th scope="col" class="text-nowrap">Job Id</th>
                            <th scope="col" class="text-nowrap">Added By</th>
                            <th scope="col" class="text-nowrap">Date</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if (@$reffers)
                        @foreach ($reffers as $item)
                        <tr class="" style="vertical-align: middle">
                            <td class="text-nowrap">
                                <a target="_blank"
                                    href="{{route('admin.tutor.tutorshow' , ['tutor' => $item->reffer->id])}}"
                                    class="p-1 rounded text-info text-decoration-none"
                                    style="background-color: #e6eef7">{{$item->reffer->unique_id ?? ''}}</a>

                            </td>
                            <td class="text-nowrap">
                                @if (!empty($item->job_id))
                                <a target="_blank" href="{{ route('admin.job-details', ['job' => $item->job_id]) }}"
                                    class="p-1 rounded text-info text-decoration-none"
                                    style="background-color: #e6eef7;">
                                    {{ $item->job_id }}
                                </a>
                                @else
                                <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>{{$item->user->name ?? ''}}</td>
                            <td class="text-nowrap">
                                {{$item->created_at}}
                            </td>
                        </tr>
                        @endforeach

                        @endif




                    </tbody>
                </table>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-success btn-block" data-bs-toggle="modal" data-bs-target="#">
                    Reffered By
                </button>

                <table class="table table-responsive table-hover bg-white shadow-none"
                    style="border-collapse: collapse">
                    <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                        <tr>

                            <th scope="col" style="width: 10px" class="text-nowrap">Tutor ID</th>

                            <th scope="col" class="text-nowrap">Job Id</th>
                            <th scope="col" class="text-nowrap">Added By</th>
                            <th scope="col" class="text-nowrap">Date</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if (@$refferedBy)
                        @foreach ($refferedBy as $item)
                        <tr class="" style="vertical-align: middle">
                            <td class="text-nowrap">
                                <a target="_blank"
                                    href="{{route('admin.tutor.tutorshow' , ['tutor' => $item->tutor_id])}}"
                                    class="p-1 rounded text-info text-decoration-none"
                                    style="background-color: #e6eef7">{{$item->tutor->unique_id ?? $item->tutor}}</a>

                            </td>
                            <td class="text-nowrap">
                                @if (!empty($item->job_id))
                                <a target="_blank" href="{{ route('admin.job-details', ['job' => $item->job_id]) }}"
                                    class="p-1 rounded text-info text-decoration-none"
                                    style="background-color: #e6eef7;">
                                    {{ $item->job_id }}
                                </a>
                                @else
                                <span class="text-muted">N/A</span>
                                @endif



                            </td>
                            <td>{{$item->user->name ?? ''}}</td>
                            <td class="text-nowrap">
                                {{$item->created_at}}
                            </td>
                        </tr>
                        @endforeach

                        @endif




                    </tbody>
                </table>
            </div>
        </div>

        <!-- Referral Modal -->
        <div class="modal fade" id="refferModal_{{ $tutor->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Grant Referral</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="refferForm_{{ $tutor->id }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="transaction_id_{{ $tutor->id }}" class="form-label required">Reffer
                                    Tutor Phone</label>
                                <input required name="tutor_id" type="text" class="form-control rounded-3 shadow-none"
                                    id="transaction_id_{{ $tutor->id }}" placeholder="Enter tutor id"
                                    style="padding: 14px 18px">
                                <span class="text-danger error-text tutor_id_error"></span>
                            </div>
                            <div class="mb-3">
                                <label for="amount_{{ $tutor->id }}" class="form-label ">Job Id</label>
                                <input name="job_id" type="text" class="form-control rounded-3 shadow-none"
                                    id="amount_{{ $tutor->id }}" placeholder="Enter Amount" style="padding: 14px 18px">
                                <span class="text-danger error-text job_id_error"></span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {

                $('form[id^="refferForm_"]').on('submit', function (e) {
                    e.preventDefault();

                    let form = $(this);
                    let tutorId = form.attr('id').split('_')[1];
                    let formData = form.serialize();

                    $.ajax({
                        url: `/admin/tutor/reffer-add/${tutorId}`,
                        type: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Referral added successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#refferModal_' + tutorId).modal('hide');
                            location.reload();
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            alert('An error occurred. Please try again.');
                        }
                    });
                });
            });

        </script>


        <!-- Modal -->
        <div class="modal fade" id="premiumModal_{{$tutor->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Grant Modal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('tutor.make.premium')}}" method="post">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="grant_id" value="{{$tutor->id}}">

                            <div class="mb-3">
                                <label for="transction_id" class="form-label required">Transction
                                    ID</label>
                                <input required name="transction_id" type="text"
                                    class="form-control rounded-3 shadow-none" id="transction_id" value=""
                                    placeholder="" style="padding: 14px 18px" />
                                <span class="text-danger error-text transction_id_error"></span>

                            </div>
                            <div class="pb-3">
                                <label for="crby" class="form-label">Package Name</label>
                                <select name="package_name" class="form-select rounded-3 shadow-none select2"
                                    aria-label="Default select" id="package_name">
                                    <option value="">Select Package Name</option>
                                    <option @if ($tutor->is_premium == 1) selected @endif value="regular">Regular
                                    </option>
                                    <option @if ($tutor->is_premium_pro == 1) selected @endif value="pro">Pro
                                    </option>
                                    <option @if ($tutor->is_premium_advance == 1) selected @endif
                                        value="advance">Advance</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="taka" class="form-label required">Taka</label>
                                <input required name="taka" type="text" class="form-control rounded-3 shadow-none"
                                    id="taka" placeholder="" value="" style="padding: 14px 18px" />
                                <span class="text-danger error-text taka_error"></span>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="verifyModal_{{$tutor->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Grant Modal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('admin.tutor.verify',$tutor->id)}}" method="post">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="grant_id" value="{{$tutor->id}}">

                            <div class="mb-3">
                                <label for="transction_id" class="form-label required">Transction
                                    ID</label>
                                <input required name="transction_id" type="text"
                                    class="form-control rounded-3 shadow-none" id="transction_id" value=""
                                    placeholder="" style="padding: 14px 18px" />
                                <span class="text-danger error-text transction_id_error"></span>

                            </div>

                            <div class="mb-3">
                                <label for="taka" class="form-label required">Taka</label>
                                <input required name="taka" type="text" class="form-control rounded-3 shadow-none"
                                    id="taka" placeholder="" value="" style="padding: 14px 18px" />
                                <span class="text-danger error-text taka_error"></span>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Boost Modal --}}
        <div class="modal fade" id="boostModal_{{$tutor->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Grant Modal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('admin.tutor.boost',$tutor->id)}}" method="post">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="grant_id" value="{{$tutor->id}}">

                            <div class="mb-3">
                                <label for="transction_id" class="form-label required">Transction
                                    ID</label>
                                <input required name="transction_id" type="text"
                                    class="form-control rounded-3 shadow-none" id="transction_id" value=""
                                    placeholder="" style="padding: 14px 18px" />
                                <span class="text-danger error-text transction_id_error"></span>

                            </div>

                            <div class="mb-3">
                                <label for="taka" class="form-label required">Taka</label>
                                <input required name="taka" type="text" class="form-control rounded-3 shadow-none"
                                    id="taka" placeholder="" value="" style="padding: 14px 18px" />
                                <span class="text-danger error-text taka_error"></span>
                            </div>

                            <div class="pb-3">
                                <label for="crby" class="form-label">Package Name</label>
                                <select name="boost_package" class="form-select rounded-3 shadow-none select2"
                                    aria-label="Default select" id="boost_package">
                                    <option value="">Select Package Name</option>
                                    <option  value="1">1 Month
                                    </option>
                                    <option value="3">3 Months
                                    </option>
                                    <option
                                        value="6">6 Months</option>
                                    <option
                                        value="12">12 Months</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Cv here</h3>
                </div>

                <div class="card-body">
                    <a href="{{route('admin.tutor.cv-pdf', ['tutor' => $tutor->id ?? 0])}}" target="_blank"
        class="btn btn-success btn-block">Download CV</a>
    </div>

</div> --}}



{{-- <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Invoice here</h3>
                </div>

                <div class="card-body">
                    <a href="" class="btn btn-success btn-block">Invoice Download</a>
                </div>

            </div> --}}
</div>




<div class="col-md-9">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header p-2">
                    Personal Information
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <strong><i class="fas fa-gender-alt mr-1"></i>Date of Birth</strong>
                        {{-- <p class="text-muted">{{ $tutor->tutor_personal_info->date_of_birth ? \Carbon\Carbon::parse($tutor->tutor_personal_info->date_of_birth)->toDateString() : 'N/A' }}
                        --}}
                        </p>
                        <hr>
                        <strong><i class="fas fa-gender-alt mr-1"></i> Blood Group</strong>
                        <p class="text-muted">{{$tutor->tutor_personal_info->blood_group ?? 'N/A'}}</p>
                        <hr>
                        <strong><i class="fas fa-gender-alt mr-1"></i> Gender</strong>
                        <p class="text-muted">{{$tutor->gender ?? 'N/A'}}</p>
                        <hr>
                        <strong><i class="fas fa-gender-alt mr-1"></i> Riligion</strong>
                        <p class="text-muted">{{$tutor->tutor_personal_info->religion ?? 'N/A'}}</p>
                        <hr>
                        <strong><i class="fas fa-map-alt mr-1"></i> Nationality</strong>
                        <p class="text-muted">{{@$tutor->tutor_personal_info->nationality ?? 'N/A'}}</p>
                        <hr>
                        <strong><i class="fas fa-map-alt mr-1"></i> NID Number</strong>
                        <p class="text-muted">{{$tutor->tutor_personal_info->nid_number ?? 'N/A'}}</p>
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Present Address</strong>
                        <p class="text-muted">{{$tutor->tutor_personal_info->full_address ?? 'N/A'}}</p>
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i>Permanent Full Address</strong>
                        <p class="text-muted">{{$tutor->tutor_personal_info->permanent_full_address ?? 'N/A'}}
                        </p>
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i>Additional Phone Number</strong>
                        <p class="text-muted">{{$tutor->tutor_personal_info->additional_phone ?? 'N/A'}}</p>
                        <hr>

                    </div>

                </div>
                <div class="card-body">
                    <div class="card-body">
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i>About</strong>
                        <p class="text-muted">{{$tutor->tutor_personal_info->about_yourself ?? 'N/A'}}</p>
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i>Reasons For Getting Hired</strong>
                        <p class="text-muted">{{$tutor->tutor_personal_info->reason_hired ?? 'N/A'}}</p>
                        <hr>

                        <strong><i class="fas fa-map-marker-alt mr-1"></i>Personal Opinion</strong>
                        <p class="text-muted">{{$tutor->tutor_personal_info->personal_opinion ?? 'N/A'}}</p>
                        <hr>

                        <strong><i class="fas fa-map-marker-alt mr-1"></i>Tution Job Experience</strong>
                        <p class="text-muted">
                            {{$tutor->tutor_personal_info->tutoring_experience_details ?? 'N/A'}}</p>
                        <hr>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header p-2">
                            Parent's Information
                        </div>
                        <div class="card-body">
                            <div class="card-body">
                                <strong><i class="fas fa-gender-alt mr-1"></i>Father's Name</strong>
                                <p class="text-muted">{{$tutor->tutor_personal_info->fathers_name ?? 'N/A'}}</p>
                                <hr>
                                <strong><i class="fas fa-gender-alt mr-1"></i>Father's Phone Number</strong>
                                <p class="text-muted">{{$tutor->tutor_personal_info->fathers_phone ?? 'N/A'}}
                                </p>
                                <hr>
                                <strong><i class="fas fa-gender-alt mr-1"></i>Mother's Name</strong>
                                <p class="text-muted">{{$tutor->tutor_personal_info->mothers_name ?? 'N/A'}}</p>
                                <hr>
                                <strong><i class="fas fa-gender-alt mr-1"></i>Mother's Phone Number</strong>
                                <p class="text-muted">{{$tutor->tutor_personal_info->mothers_phone ?? 'N/A'}}
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header p-2">
                            Emergency Information
                        </div>
                        <div class="card-body">
                            <div class="card-body">
                                <strong>Emergency Contact Name</strong>
                                <p class="text-muted">{{$tutor->tutor_personal_info->emergency_name?? 'N/A'}}
                                </p>
                                <hr>
                                <strong>Emergency Contact Number</strong>
                                <p class="text-muted">{{$tutor->tutor_personal_info->emergency_phone ?? 'N/A'}}
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header p-2">
                            Social Media Info
                        </div>
                        <div class="card-body">
                            <div class="card-body">
                                <strong>Facebook</strong>
                                <p class="text-muted"><a target="_blank"
                                        href="{{$tutor->tutor_personal_info->facebook_link ?? '#'}}">{{$tutor->tutor_personal_info->facebook_link ?? 'N/A'}}</a>
                                </p>
                                <hr>
                                <strong>Instagram</strong>
                                <p class="text-muted">{{$tutor->tutor_personal_info->instagram_link ?? 'N/A'}}
                                </p>
                                <hr>
                                <strong>Twitter</strong>
                                <p class="text-muted">{{$tutor->tutor_personal_info->twitter_link ?? 'N/A'}}
                                </p>
                                <hr>
                                <strong>Linkdein</strong>
                                <p class="text-muted">{{$tutor->tutor_personal_info->linekdin_link ?? 'N/A'}}
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header p-2">
                    Certificates
                </div>
                <div class="card-body">


                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <strong style="text-align: center;">SSC/O Level /Dakhil/Certificate</strong>
                                <div class="card-body">
                                    @if($tutor->TutorCertificate != null)
                                    <a href="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->ssc_c ) }}"
                                        target="_blank">
                                        <img width="320" height="150"
                                            src="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->ssc_c) }}">
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <strong style="text-align: center;">SSC/O Level /Dakhil/Marksheet</strong>
                                <div class="card-body">
                                    @if($tutor->TutorCertificate != null)
                                    <a href="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->ssc_m) }}"
                                        target="_blank">
                                        <img width="320" height="150"
                                            src="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->ssc_m) }}">
                                    </a>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <strong style="text-align: center;">HSC/A Level /Alim/Certificate </strong>
                                <div class="card-body">
                                    @if($tutor->TutorCertificate != null)
                                    <a href="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->hsc_c) }}"
                                        target="_blank">
                                        <img width="320" height="150"
                                            src="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->hsc_c) }}">
                                    </a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <strong style="text-align: center;">HSC/A Level /Alim/Marksheet</strong>
                                <div class="card-body">
                                    @if($tutor->TutorCertificate != null)
                                    <a href="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->hsc_m) }}"
                                        target="_blank">
                                        <img width="320" height="150" border="0" align="center"
                                            src="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->hsc_m) }}">
                                    </a>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <strong style="text-align: center;">Nid/Passport/Birth Certificate</strong>
                                <div class="card-body">
                                    @if($tutor->TutorCertificate != null)
                                    <a href="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->nid) }}"
                                        target="_blank">
                                        <img width="320" height="150" border="0" align="center"
                                            src="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->nid) }}">
                                    </a>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <strong style="text-align: center;">CV </strong>
                                <div class="card-body">
                                    @if($tutor->TutorCertificate != null)
                                    <a href="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->cv) }}"
                                        target="_blank">
                                        <img width="320" height="150" border="0" align="center"
                                            src="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->cv) }}">
                                    </a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <strong style="text-align: center;">Admission Slip/University Id
                                    Certificate</strong>
                                <div class="card-body">
                                    @if($tutor->TutorCertificate != null)
                                    <a href="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->university_c) }}"
                                        target="_blank">
                                        <img width="320" height="150" border="0" align="center"
                                            src="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->university_c) }}">
                                    </a>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <strong style="text-align: center;">Others</strong>
                                <div class="card-body">
                                    @if($tutor->TutorCertificate != null)
                                    <a href="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->others) }}"
                                        target="_blank">
                                        <img width="320" height="150" border="0" align="center"
                                            src="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->others) }}">
                                    </a>
                                    @endif

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>




</div>
</div>

@php
$confirm = 'confirm';
$closed = 'closed';
$assign = 'assign';
$assign_stage_count = App\Models\JobApplication::where('tutor_id',$tutor->id)->where('current_stage','assign')->count();
$assign_stage =
App\Models\JobApplication::where('tutor_id',$tutor->id)->where('current_stage','assign')->latest('created_at')->get();

$total_stage_count = App\Models\JobApplication::where('tutor_id', $tutor->id)
->whereIn('current_stage', ['waiting', 'meet', 'trial', 'problem'])
->count();
$waiting_stage =
App\Models\JobApplication::where('tutor_id',$tutor->id)->where('current_stage','waiting')->latest('created_at')->get();
$meet_stage =
App\Models\JobApplication::where('tutor_id',$tutor->id)->where('current_stage','meet')->latest('created_at')->get();
$trial_stage =
App\Models\JobApplication::where('tutor_id',$tutor->id)->where('current_stage','trial')->latest('created_at')->get();
$problem_stage =
App\Models\JobApplication::where('tutor_id',$tutor->id)->where('current_stage','problem')->latest('created_at')->get();

$total_applied = App\Models\JobApplication::where('tutor_id',$tutor->id)->count();
$total_applied_tution = App\Models\JobApplication::where('tutor_id',$tutor->id)->latest('created_at')->get();

$total_shortlisted = App\Models\JobApplication::where('tutor_id', $tutor->id)->where('is_shortlisted', 1)->count();
$total_shortlisted_tution = App\Models\JobApplication::where('tutor_id', $tutor->id)->where('is_shortlisted',
1)->latest('created_at')->get();

$total_confirm = App\Models\JobApplication::where('tutor_id',$tutor->id)->where('confirm_date', '!=', null)->count();
$total_confirm_tution =
App\Models\JobApplication::where('tutor_id',$tutor->id)->whereNotNull('confirm_date')->where('current_stage','confirm')->latest('created_at')->get();

$total_pending_confirm_tution_count = App\Models\JobApplication::where('tutor_id', $tutor->id)
->whereNotNull('confirm_date')
->where('payment_status', null)
->count();
$total_pending_confirm_tution = App\Models\JobApplication::where('tutor_id', $tutor->id)
->where('current_stage','confirm')
->whereNotNull('confirm_date')
->where('payment_status', null)
->latest('created_at')
->get();



$total_cancel = App\Models\JobApplication::where('tutor_id',$tutor->id)->where('closed_date', '!=', null)->count();
$total_cancel_tution = App\Models\JobApplication::where('tutor_id',$tutor->id)->where('closed_date', '!=',
null)->latest('created_at')->get();


$total_given_job = App\Models\JobApplication::where('tutor_id',$tutor->id)->where('taken_at', '!=',
null)->latest('created_at')->get();
$total_given_job_count = App\Models\JobApplication::where('tutor_id',$tutor->id)->where('taken_at', '!=',
null)->count();

$total_repost_job = App\Models\JobApplication::where('tutor_id',$tutor->id)->where('repost_date', '!=',
null)->latest('created_at')->get();
$total_repost_job_count = App\Models\JobApplication::where('tutor_id',$tutor->id)->where('repost_date', '!=',
null)->count();


$total_payment_job = App\Models\JobApplication::where('tutor_id', $tutor->id)
->whereNotNull('payment_status')
->whereNotNull('payment_date')
->latest('created_at')
->get();
$total_payment_job_count = App\Models\JobApplication::where('tutor_id', $tutor->id)
->whereNotNull('payment_status')
->whereNotNull('payment_date')
->count();

$total_due_job = App\Models\JobApplication::where('tutor_id', $tutor->id)
->where('payment_status','due')
->latest('created_at')
->get();
$total_due_job_count = App\Models\JobApplication::where('tutor_id', $tutor->id)
->where('payment_status', 'due')
->count();

$total_refund_job = App\Models\JobApplication::where('tutor_id', $tutor->id)
->where('payment_status', 'refund')
->where('refund_status','!=', 1)
->whereNotNull('refund_amount')
->latest('created_at')
->get();
$total_refund_job_complete = App\Models\JobApplication::where('tutor_id', $tutor->id)
->whereNotNull('refund_complete_date')
->where('refund_status', 1)
->whereColumn('refund_complete_amount', 'refund_amount')
->latest('created_at')
->get();

$total_refund_job_count = App\Models\JobApplication::where('tutor_id', $tutor->id)
->where('payment_status', 'refund')
->where('refund_status','!=', 1)
->whereNotNull('refund_amount')
->count();


$total_refund_complete_job_count = App\Models\JobApplication::where('tutor_id', $tutor->id)
->whereNotNull('refund_complete_date')
->where('refund_status', 1)
->whereColumn('refund_complete_amount', 'refund_amount')
->count();

$total_note = App\Models\TutorNote::where('tutor_id',$tutor->id)->count();
$tutor_note_desc = App\Models\TutorNote::where('tutor_id',$tutor->id)->latest('created_at')->get();


@endphp
{{-- Tutor History --}}
<div class="tab-pane fade box-body" id="tutor-history" role="tabpanel" aria-labelledby="tutor-history">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title" style="font-size: 2.1rem!important">Total Applied Tuition: {{$total_applied}}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                @if (@$total_applied_tution)
                @foreach ($total_applied_tution as $item)
                <div class="col-md-3 mb-2">
                    <div class="card">
                        <div class="card-body">

                            Job Offer ID : <a
                                href="{{route('admin.job-details',$item->job_offer_id)}}">{{$item->job_offer_id}}</a><br>
                            Applied At : {{$item->created_at}}<br>
                        </div>
                    </div>
                </div>
                @endforeach

                @endif


            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title" style="font-size: 2.1rem!important">Total Shortlisted Tuition: {{$total_shortlisted}}
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                @if (@$total_shortlisted_tution)
                @foreach ($total_shortlisted_tution as $item)
                <div class="col-md-3 mb-2">
                    <div class="card">
                        <div class="card-body">

                            Job Offer ID : <a
                                href="{{route('admin.job-details',$item->job_offer_id)}}">{{$item->job_offer_id}}</a><br>

                            Shortlisted date : {{$item->shortlisted_date ?? ''}}<br>
                            Shortlisted By : {{$item->user->name ?? ''}}<br>
                        </div>
                    </div>
                </div>
                @endforeach

                @endif


            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title " style="font-size: 2.1rem!important">Total Assign Tuition:{{$total_given_job_count}}
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                @if (@$total_given_job)
                @foreach ($total_given_job as $item)
                <div class="col-md-3 mb-2">
                    <div class="card">
                        <div class="card-body">
                            Job Offer ID : <a
                                href="{{route('admin.job-details',$item->job_offer_id)}}">{{$item->job_offer_id}}</a><br>
                            Given By : {{$item->user->name}} <br>
                            Taken Date : {{$item->taken_at}}<br>
                        </div>
                    </div>
                </div>
                @endforeach

                @endif
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title" style="font-size: 2.1rem!important">Total Confirm Tuition: {{$total_confirm}}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                @if (@$total_confirm_tution)
                @foreach ($total_confirm_tution as $item)
                <div class="col-md-3 mb-2">
                    <div class="card">
                        <div class="card-body">
                            Job Offer ID : <a
                                href="{{route('admin.job-details',$item->job_offer_id)}}">{{$item->job_offer_id}}</a><br>

                            Confirm Date : {{$item->confirm_date}}<br>
                            Payment Date : {{$item->payment_date}}<br>
                            Confirm By : {{$item->user->name}}<br>
                        </div>
                    </div>
                </div>
                @endforeach

                @endif
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title" style="font-size: 2.1rem!important">Total Payment
                Tuition:{{$total_payment_job_count}}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                @if (@$total_payment_job)
                @foreach ($total_payment_job as $item)
                <div class="col-md-3 mb-2">
                    <div class="card">
                        <div class="card-body">

                            Job Offer ID : <a
                                href="{{route('admin.job-details',$item->job_offer_id)}}">{{$item->job_offer_id}}</a><br>
                            Given By : {{$item->user->name}} <br>
                            Charge : {{$item->charge}} <br>
                            Received Amount : {{$item->received_amount}} <br>
                            Payment Date : {{$item->paid_date}}<br>
                        </div>
                    </div>

                </div>
                @endforeach

                @endif
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title" style="font-size: 2.1rem!important">Total Cancel and Repost Tuition:
                {{$total_cancel + $total_repost_job_count}}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                @if($total_repost_job)
                @foreach ($total_repost_job as $item)
                <div class="col-md-3 mb-2">
                    <div class="card">
                        <div class="card-body" style="min-height: 300px">

                            Job Offer ID : <a
                                href="{{route('admin.job-details',$item->job_offer_id)}}">{{$item->job_offer_id}}</a><br>
                            Repost By : {{$item->user->name ?? ''}} <br>
                            Reposted At : {{$item->repost_date ?? ''}}<br>
                            <div class="card">
                                <div class="card-body text-bg-danger">
                                    <h5 class="text-danger text-sm-center">Repost Note: {{$item->repost_about}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @endforeach

                @else

                @endif
                @if (@$total_cancel_tution)
                @foreach ($total_cancel_tution as $item)
                <div class="col-md-3 mb-2">
                    <div class="card">
                        <div class="card-body" style="min-height: 300px">

                            Job Offer ID : <a
                                href="{{route('admin.job-details',$item->job_offer_id)}}">{{$item->job_offer_id}}</a><br>
                            Cancel By : {{$item->user->name ?? ''}} <br>
                            Closed Date : {{$item->closed_date ?? ''}}<br>
                            <div class="card">
                                <div class="card-body text-bg-danger">
                                    <h5 class="text-danger text-sm-center">Cancel Note: {{$item->closed_about}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @endforeach

                @endif


            </div>
        </div>
    </div>

    <div class="card shadow-lg mb-3">
        <div class="card-header">
            <h2 class="card-title" style="font-size: 2.1rem!important">Refund Tuition :
                {{$total_refund_complete_job_count }}</h2>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($total_refund_job_complete ?? [] as $item)
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            Job ID : <a target="_blank"
                                href="{{route('admin.job-details',$item->job_offer_id)}}">{{$item->job_offer_id ?? ''}}</a>
                            <br>
                            Refund Complete Date :
                            {{ $item->refund_complete_date ? \Carbon\Carbon::parse($item->refund_complete_date)->format('Y-m-d') : 'Not Available' }}
                            <br>
                            Refund Amount : {{$item->refund_amount ?? ''}} <br>
                            Job Confirm By : {{$item->user->name}}<br>
                            Refund By : {{$item->user->name}}<br>
                            Refund Status : Complete<br>
                            <p class="text-red">Refund Complete Note : {{$item->refund_complete_note}}<br></p>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title" style="font-size: 2.1rem!important">Notes : {{$total_note}}</h3>
        </div>
        <div class="col-md-3 mb-2">
            @if ($tutor_note_desc)
            <div class="card">
                <div class="card-body">
                    @foreach ($tutor_note_desc as $item)

                    Tutor Id : <a href="{{route('admin.tutor.tutorshow',$item->tutor_id)}}">{{$item->tutor_id}}</a> <br>
                    Message : <span class="text-danger">{{$item->body}}</span> <br>
                    Created By : {{$item->created_by}} <br>
                    Created At : {{$item->created_at}} <br>
                    <hr>
                    @endforeach
                </div>
            </div>

            @endif

        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title" style="font-size: 2.1rem!important">Other</h3>
        </div>
        <div class="card-body ">
            @if ($tutor->login_at !== null && is_string($tutor->login_at))
            Last Online Date: {{ \Carbon\Carbon::parse($tutor->login_at)->format('Y-m-d') }} <br>
            @endif
            @if ($tutor->updated_at !== null)

            Last information update date:{{ \Carbon\Carbon::parse($tutor->updated_at)->format('Y-m-d') }}
            @endif


        </div>
    </div>
</div>
{{-- Tutor Login --}}
<div class="tab-pane fade box-body" id="tutor-login-details" role="tabpanel" aria-labelledby="tutor-login-details">
    <div class="box-body">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <form id="updateTutorForm" action="{{ route('admin.tutor.update', $tutor->id) }}" method="post">
                    @csrf
                    <input type="hidden" name="edited_by" value="{{Auth::user()->name}}" class="form-control"
                        placeholder="Email">
                    <div class="form-group mb-3">
                        <label>Full name</label>
                        <input type="text" name="name" value="{{ $tutor->name ?? '' }}" class="form-control"
                            placeholder="Full name">
                    </div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $tutor->email ?? '' }}" class="form-control"
                            placeholder="Email">
                    </div>
                    <div class="form-group mb-3">
                        <label>Phone</label>
                        <input type="phone" name="phone" value="{{ $tutor->phone ?? '' }}" class="form-control"
                            placeholder="Phone">
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" value="" class="form-control" placeholder="Password">
                        <div class="input-group-append"></div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="cpassword" class="form-control" placeholder="Retype password">
                        <div class="input-group-append"></div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <button id="submit" type="button" class="btn btn-primary">Update Tutor</button>
                            <a class="btn btn-primary" id="tutor-login-logs" data-toggle="pill" href="#tutor-login-logs"
                                role="tab" aria-controls="tutor-login-logs" aria-selected="true">Tutor Log</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>User Edit Log</h2>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-hover bg-white shadow-none"
                        style="border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">#Tutor Id</th>
                                <th scope="col">Present Address</th>
                                <th scope="col">Permanent Address</th>
                                <th scope="col">Father Name</th>
                                <th scope="col">Father Phone</th>
                                <th scope="col">Mother Name</th>
                                <th scope="col">Mother Phone</th>
                                <th scope="col">E-name</th>
                                <th scope="col">E-phone</th>
                                <th scope="col">Additional Phone</th>
                                <th scope="col">Facebook</th>
                                <th scope="col">Twitter</th>
                                <th scope="col">Linkedin</th>
                                <th scope="col">Instagram</th>
                                <th scope="col">NID</th>
                                <th scope="col">Updated At</th>
                                <th scope="col">More</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($tutor_logs)
                            @foreach ($tutor_logs as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->tutor_id}}</td>
                                <td>{{$item->full_address ?? 'n/a'}}</td>
                                <td>{{$item->permanent_full_address ?? 'n/a'}}</td>
                                <td>{{$item->father_name ?? 'n/a'}}</td>
                                <td>{{$item->father_phone ?? 'n/a'}}</td>
                                <td>{{$item->mother_name ?? 'n/a'}}</td>
                                <td>{{$item->mother_phone ?? 'n/a'}}</td>
                                <td>{{$item->email ?? 'n/a'}}</td>
                                <td>{{$item->phone ?? 'n/a'}}</td>
                                <td>{{$item->additional_phone ?? 'n/a'}}</td>
                                <td>{{$item->facebook_link ?? 'n/a'}}</td>
                                <td>{{$item->twitter_link ?? 'n/a'}}</td>
                                <td>{{$item->linkedin_link ?? 'n/a'}}</td>
                                <td>{{$item->instagram_link ?? 'n/a'}}</td>
                                <td>{{$item->nid_number ?? 'n/a'}}</td>
                                <td>{{$item->updated_at ?? 'n/a'}}</td>
                                <td>
                                    <button type="button" class="btn btn-primary py-1" data-bs-toggle="modal"
                                        data-bs-target="#editHistoryModal_{{$item->id}}">
                                        More
                                    </button>
                                    <div class="modal fade" id="editHistoryModal_{{$item->id}}" tabindex="-1"
                                        aria-labelledby="dateModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Change Tutor Status
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-responsive-sm">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">SSC C</th>
                                                                <th scope="col">SSC M</th>
                                                                <th scope="col">HSC C</th>
                                                                <th scope="col">HSC M</th>
                                                                <th scope="col">Admission</th>
                                                                <th scope="col">NID</th>
                                                                <th scope="col">CV </th>
                                                                <th scope="col">others</th>
                                                                <th scope="col">Profile image</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <a href="{{ asset('storage/tutor-certificate/'. $item->ssc_c ) }}"
                                                                        target="_blank">
                                                                        <img src="{{ asset('storage/tutor-certificate/'. $item->ssc_c) }}"
                                                                            alt="image" width="250" height="80">
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ asset('storage/tutor-certificate/'. $item->ssc_m ) }}"
                                                                        target="_blank">
                                                                        <img src="{{ asset('storage/tutor-certificate/'. $item->ssc_m) }}"
                                                                            alt="image" width="250" height="80">
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ asset('storage/tutor-certificate/'. $item->hsc_c ) }}"
                                                                        target="_blank">
                                                                        <img src="{{ asset('storage/tutor-certificate/'. $item->hsc_c) }}"
                                                                            alt="image" width="250" height="80">
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ asset('storage/tutor-certificate/'. $item->hsc_m ) }}"
                                                                        target="_blank">
                                                                        <img src="{{ asset('storage/tutor-certificate/'. $item->hsc_m) }}"
                                                                            alt="image" width="250" height="80">
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ asset('storage/tutor-certificate/'. $item->university_c ) }}"
                                                                        target="_blank">
                                                                        <img src="{{ asset('storage/tutor-certificate/'. $item->university_c) }}"
                                                                            alt="image" width="250" height="80">
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ asset('storage/tutor-certificate/'. $item->nid ) }}"
                                                                        target="_blank">
                                                                        <img src="{{ asset('storage/tutor-certificate/'. $item->nid) }}"
                                                                            alt="image" width="250" height="80">
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ asset('storage/tutor-certificate/'. $item->cv ) }}"
                                                                        target="_blank">
                                                                        <img src="{{ asset('storage/tutor-certificate/'. $item->cv) }}"
                                                                            alt="image" width="250" height="80">
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ asset('storage/tutor-certificate/'. $item->others ) }}"
                                                                        target="_blank">
                                                                        <img src="{{ asset('storage/tutor-certificate/'. $item->others) }}"
                                                                            alt="image" width="250" height="80">
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ asset('storage/tutor-certificate/'. $item->profile_image ) }}"
                                                                        target="_blank">
                                                                        <img src="{{ asset('storage/tutor-log-images/'. $item->profile_image) }}"
                                                                            alt="image" width="250" height="80">
                                                                    </a>
                                                                </td>

                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

</div>
{{-- Tutor Log --}}
<div class="tab-pane fade box-body" id="tutor-login-log" role="tabpanel" aria-labelledby="tutor-login-log">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="d-inline">Tutor Edit Logs Table</h3>

                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>Tutor Id</th>
                                <th>Edit By</th>
                                <th>Tutor Name </th>
                                <th>Tutor Email </th>
                                <th>Tutor Phone Number</th>
                                <th>Updated At </th>
                            </tr>
                            @foreach ($tutor_important_update ?? [] as $item)
                            <tr>
                                <td> {{$item->tutor_id ?? ''}}</td>
                                <td>
                                    @if (isset($item->edited_by) || isset($item->edited_user))
                                    {{ $item->edited_by ?? $item->editor->name }}
                                    @endif
                                </td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->phone}}</td>
                                <td>{{$item->updated_at}}</td>

                            </tr>

                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Present-pending --}}
<div class="tab-pane fade box-body" id="present-pending-details" role="tabpanel"
    aria-labelledby="present-pending-details">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="d-inline">Present Pending</h3>
                </div>
                <div class="box-body">
                    <div class="card shadow-lg mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Assign Offer : {{$assign_stage_count}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($assign_stage ?? [] as $item)
                                <div class="col-lg-3">
                                    <div class="card">
                                        <div class="card-body">
                                            Job ID : <a target="_blank"
                                                href="{{route('admin.job-details',$item->job_offer_id)}}">{{$item->job_offer_id ?? ''}}</a>
                                            <br>
                                            Assign Date:
                                            {{ $item->taken_at ? \Carbon\Carbon::parse($item->taken_at)->format('Y-m-d H:i A') : 'Not Available' }}
                                            <br>
                                            Assign By: {{$item->user->name}}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-lg mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Tutor Current Stage : {{$total_stage_count}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="card-body">
                                <div class="row">
                                    @if ($waiting_stage)
                                    @foreach ($waiting_stage ?? [] as $item)
                                    <div class="col-lg-3">
                                        <div class="card">
                                            <div class="card-body">
                                                Job ID : <a target="_blank"
                                                    href="{{route('admin.job-details',$item->job_offer_id)}}">{{$item->job_offer_id ?? ''}}</a>
                                                <br>
                                                Assign Date:
                                                {{ $item->taken_at ? \Carbon\Carbon::parse($item->taken_at)->format('Y-m-d H:i A') : 'Not Available' }}
                                                <br>
                                                Waiting Date:
                                                {{ $item->waiting_date ? \Carbon\Carbon::parse($item->waiting_date)->format('Y-m-d H:i A') : 'Not Available' }}
                                                <br>
                                                Given By: {{$item->user->name}}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                    @if ($meet_stage)
                                    @foreach ($meet_stage ?? [] as $item)
                                    <div class="col-lg-3">
                                        <div class="card">
                                            <div class="card-body">
                                                Job ID : <a target="_blank"
                                                    href="{{route('admin.job-details',$item->job_offer_id)}}">{{$item->job_offer_id ?? ''}}</a>
                                                <br>
                                                Assign Date:
                                                {{ $item->taken_at ? \Carbon\Carbon::parse($item->taken_at)->format('Y-m-d H:i A') : 'Not Available' }}
                                                <br>
                                                Meeting Date:
                                                {{ $item->meeting_date ? \Carbon\Carbon::parse($item->meeting_date)->format('Y-m-d H:i A') : 'Not Available' }}
                                                <br>
                                                Given By: {{$item->user->name}}

                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                    @if ($trial_stage)
                                    @foreach ($trial_stage ?? [] as $item)
                                    <div class="col-lg-3">
                                        <div class="card">
                                            <div class="card-body">
                                                Job ID : <a target="_blank"
                                                    href="{{route('admin.job-details',$item->job_offer_id)}}">{{$item->job_offer_id ?? ''}}</a>
                                                <br>
                                                Assign Date:
                                                {{ $item->taken_at ? \Carbon\Carbon::parse($item->taken_at)->format('Y-m-d H:i A') : 'Not Available' }}
                                                <br>
                                                Trial Date:
                                                {{ $item->trial_date ? \Carbon\Carbon::parse($item->trial_date)->format('Y-m-d H:i A') : 'Not Available' }}
                                                <br>
                                                <br>
                                                Given By: {{$item->user->name}}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                    @if ($problem_stage)
                                    @foreach ($problem_stage ?? [] as $item)
                                    <div class="col-lg-3">
                                        <div class="card">
                                            <div class="card-body">
                                                Job ID : <a target="_blank"
                                                    href="{{route('admin.job-details',$item->job_offer_id)}}">{{$item->job_offer_id ?? ''}}</a>
                                                <br>
                                                Assign Date:
                                                {{ $item->taken_at ? \Carbon\Carbon::parse($item->taken_at)->format('Y-m-d H:i A') : 'Not Available' }}
                                                <br>
                                                Problem Date:
                                                {{ $item->problem_date ? \Carbon\Carbon::parse($item->problem_date)->format('Y-m-d H:i A') : 'Not Available' }}
                                                <br>
                                                <br>
                                                Given By: {{$item->user->name}}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-lg mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Confirm Tuition : {{$total_pending_confirm_tution_count}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($total_pending_confirm_tution ?? [] as $item)
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            Job ID : <a target="_blank"
                                                href="{{route('admin.job-details',$item->job_offer_id)}}">{{$item->job_offer_id ?? ''}}</a>
                                            <br>
                                            Confirm Date:
                                            {{ $item->confirm_date ? \Carbon\Carbon::parse($item->confirm_date)->format('Y-m-d') : 'Not Available' }}
                                            <br>

                                            {{-- Payment Status: <p> <b>Unpaid</b> </p> --}}
                                            Charge : {{$item->charge ?? ''}} <br>
                                            Payment Date :
                                            {{ $item->payment_date ? \Carbon\Carbon::parse($item->payment_date)->format('Y-m-d') : 'Not Available' }}
                                            <br>
                                            Confirm By : {{$item->user->name}}<br>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-lg mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Due Tuition : {{$total_due_job_count }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($total_due_job ?? [] as $item)
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            Job ID : <a target="_blank"
                                                href="{{route('admin.job-details',$item->job_offer_id)}}">{{$item->job_offer_id ?? ''}}</a>
                                            <br>
                                            Confirm Date :
                                            {{ $item->confirm_date ? \Carbon\Carbon::parse($item->confirm_date)->format('Y-m-d') : 'Not Available' }}
                                            <br>
                                            Charge : {{$item->charge ?? ''}} <br>
                                            Received Amount : {{$item->received_amount ?? ''}} <br>
                                            Due Amount : {{$item->due_amount ?? ''}} <br>
                                            Due Payment Date :
                                            {{ $item->due_payment_date ? \Carbon\Carbon::parse($item->due_payment_date)->format('Y-m-d') : 'Not Available' }}
                                            <br>
                                            Confirm By : {{$item->user->name}}<br>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-lg mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Refund Tuition : {{$total_refund_job_count }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($total_refund_job ?? [] as $item)
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            Job ID : <a target="_blank"
                                                href="{{route('admin.job-details',$item->job_offer_id)}}">{{$item->job_offer_id ?? ''}}</a>
                                            <br>
                                            Refund Date :
                                            {{ $item->refund_date ? \Carbon\Carbon::parse($item->refund_date)->format('Y-m-d') : 'Not Available' }}
                                            <br>
                                            Refund Amount : {{$item->refund_amount - $item->refund_complete_amount}}
                                            <br>
                                            Confirm By : {{$item->user->name}}<br>
                                            Refund Status : Pending<br>
                                            <p class="text-red">Refund Reason : {{$item->refund_reason}}<br></p>

                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Sms Log --}}
<div class="tab-pane fade box-body" id="sms-logs" role="tabpanel" aria-labelledby="sms-logs">
    <div id="count" style="margin-left: 18px">
        <div class="owl-carousel">
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <div class="report-card " style="text-align:center">
                    <h2>{{ $smsBalance->available_sms ?? 0}}</h2>
                    <span>Available Sms</span>
                </div>
            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <div class="report-card " style="text-align:center">
                    <h2>{{ $smsBalance->paid_sms ?? 0}}</h2>
                    <span>Paid Sms</span>
                </div>
            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <div class="report-card " style="text-align:center">
                    <h2>{{ $smsBalance->unpaid_sms ?? 0}}</h2>
                    <span>Unpaid Sms</span>
                </div>
            </div>
            <div
                class="bg-white p-3 rounded-3 shadow-lg d-flex justify-content-center align-items-center flex-column mb-2">
                <div class="report-card " style="text-align:center">
                    <h2>{{ $smsBalance->total_sms_received ?? 0}}</h2>
                    <span>Total Sms Received</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="d-inline">Sms Log</h3>
                </div>
                <div class="box-body">
                    <div class="box-title bg-white" style="color: black">
                        <div class="row">
                            <ul id="tab_nav" class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link" id="paid-sms" data-toggle="pill" href="#paid-sms" role="tab"
                                        aria-controls="paid-sms" aria-selected="true">Paid Sms</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="unpaid-sms" data-toggle="pill" href="#unpaid-sms" role="tab"
                                        aria-controls="unpaid-sms" aria-selected="true">Unpaid Sms</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="trx-history" data-toggle="pill" href="#trx-history"
                                        role="tab" aria-controls="unpaid-sms" aria-selected="true">Trx History</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
{{-- Paid sms log --}}
<div class="tab-pane fade box-body" id="paid-sms-logs" role="tabpanel" aria-labelledby="paid-sms-logs">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="d-inline">Paid Sms</h3>

                </div>
                <div class="card-body">
                    <table id="example1" class="table table-hover bg-white shadow-none"
                        style="border-collapse: collapse" id="tutor_data_table">
                        <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                            <tr>
                                <th scope="col-12" style="width: 10px" class="text-nowrap">SL</th>
                                <th scope="col" class="text-nowrap">Sender Name</th>
                                <th scope="col" class="text-nowrap">Sms Title</th>
                                <th scope="col" class="text-nowrap">Sent Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paidSms as $item)
                            <tr class="" style="vertical-align: middle">
                                <td scope="row " class="text-center text-nowrap" style="padding: 30px 18px">
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $item->sender_name }}</td>
                                <td>{{ Str::limit($item->sms_body, 120) }}</td>
                                <td>{{ $item->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tab-pane fade box-body" id="unpaid-sms-logs" role="tabpanel" aria-labelledby="unpaid-sms-logs">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="d-inline">Unpaid Sms</h3>

                </div>
                <div class="card-body">
                    <table id="example3" class="table table-hover bg-white shadow-none"
                        style="border-collapse: collapse" id="tutor_data_table">
                        <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                            <tr>
                                <th scope="col-12" style="width: 10px" class="text-nowrap">SL</th>
                                <th scope="col" class="text-nowrap">Sender Name</th>
                                <th scope="col" class="text-nowrap">Sms Title</th>
                                <th scope="col" class="text-nowrap">Sent Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unPaidSms as $item)
                            <tr class="" style="vertical-align: middle">
                                <td scope="row " class="text-center text-nowrap" style="padding: 30px 18px">
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ Str::limit($item->body, 120) }}</td>
                                <td>{{ $item->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="tab-pane fade box-body" id="trx-history-logs" role="tabpanel" aria-labelledby="trx-history-logs">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="d-inline">Transction History</h3>

                </div>
                <div class="card-body">
                    <table id="example1" class="table table-hover bg-white shadow-none"
                        style="border-collapse: collapse" id="tutor_data_table">
                        <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                            <tr>
                                <th scope="col-12" style="width: 10px" class="text-nowrap">SL</th>
                                <th scope="col" class="text-nowrap">Date</th>
                                <th scope="col" class="text-nowrap">Name</th>
                                <th scope="col" class="text-nowrap">Payment Method</th>
                                <th scope="col" class="text-nowrap">Amount</th>
                                <th scope="col" class="text-nowrap">Trx_id</th>
                                <th scope="col" class="text-nowrap">Created_at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($smsTrxHistory as $item)
                            <tr class="" style="vertical-align: middle">
                                <td scope="row " class="text-center text-nowrap" style="padding: 30px 18px">
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $item->created_at}}</td>
                                <td>{{ $item->tutor->name }}</td>
                                <td>{{ $item->payment_method }}</td>
                                <td>{{ $item->amount }}</td>
                                <td>{{ $item->invoice_no }}</td>
                                <td>{{ $item->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('page_scripts')
@include('backend.tutor.js.swtdeleteMethod_js')


<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
        const stars = $(".rating i");
        const ratingInput = $("#ratingValue");

        stars.on("mouseover", function () {
            let value = $(this).data("value");
            highlightStars(value);
        });

        stars.on("click", function () {
            let value = $(this).data("value");
            ratingInput.val(value);
            highlightStars(value);
        });

        stars.on("mouseout", function () {
            highlightStars(ratingInput.val());
        });

        function highlightStars(value) {
            stars.removeClass("selected");
            stars.each(function () {
                if ($(this).data("value") <= value) {
                    $(this).addClass("selected");
                }
            });
        }

        // Submit form via AJAX
        $("#reviewForm").submit(function (event) {
            event.preventDefault();

            let formData = {
                _token: "{{ csrf_token() }}",
                tutor_id: $("#tutor_id").val(),
                rating: $("#ratingValue").val(),
                description: $("#reviewText").val(),
            };

            if (formData.rating == 0) {
                alert("Please select a rating!");
                return;
            }

            if (formData.description.length < 20) {
                alert("Review must be at least 20 characters long.");
                return;
            }

            $.ajax({
            url: "/admin/send-tutor-reviews",
            type: "POST",
            data: formData,
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                });

                location.reload();

                $("#reviewModal").modal("hide");
                $("#reviewForm")[0].reset();
                highlightStars(0);
            },
            error: function (xhr) {
                let errorMessage = "Something went wrong!";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: errorMessage
                });
            }
        });

        });
    });
</script>

@include('data_tables.data_table_js')


<script>
    $(document).ready(function () {
        $("#tutor-information").addClass('active');
        $("#tutor-details").addClass('show');

        $("#tutor-information").click(function () {
            $("#tutor-information").addClass("active");
            $("#tutor-details").addClass('show');
            $("#tutor-history").addClass('d-none');
            $("#tutor-login-details").addClass('d-none');

            $("#tutor-details").removeClass('d-none');
            $("#tutor-login-details").removeClass('show');
            $("#tutor-history-details").removeClass("active");
            $("#tutor-login").removeClass("active");
            $("#tutor-history").removeClass("show");
            $("#present-pending-details").removeClass('show');
            $("#present-pending-details").addClass('d-none');
            $("#present-pending").removeClass('active');

            $("#sms-logs").removeClass('show');
            $("#sms-logs").addClass('d-none');
            $("#sms-log").removeClass('active');

            $("#unpaid-sms-logs").removeClass('show');
            $("#unpaid-sms-logs").addClass('d-none');
            $("#trx-history-logs").removeClass('show');
            $("#trx-history-logs").addClass('d-none');
            $("#paid-sms-logs").removeClass('show');
            $("#paid-sms-logs").addClass('d-none');
        });

        $("#tutor-history-details").click(function () {
            $("#tutor-history-details").addClass("active");
            $("#tutor-history").addClass('show');
            $("#tutor-details").addClass('d-none');
            $("#tutor-login-details").addClass('d-none');

            $("#tutor-history").removeClass('d-none');
            $("#tutor-information").removeClass("active");
            $("#tutor-login").removeClass("active");
            $("#tutor-login-details").removeClass("show");
            $("#tutor-details").removeClass('show');
            $("#present-pending-details").removeClass('show');
            $("#present-pending-details").addClass('d-none');
            $("#sms-logs").removeClass('show');
            $("#sms-logs").addClass('d-none');
            $("#present-pending").removeClass('active');
            $("#tutor-login-log").removeClass('show');
            $("#tutor-login-log").addClass('d-none');

            $("#unpaid-sms-logs").removeClass('show');
            $("#unpaid-sms-logs").addClass('d-none');
            $("#trx-history-logs").removeClass('show');
            $("#trx-history-logs").addClass('d-none');
            $("#paid-sms-logs").removeClass('show');
            $("#paid-sms-logs").addClass('d-none');
        });
        $("#tutor-login").click(function () {
            $("#tutor-login").addClass("active");
            $("#tutor-login-details").addClass('show');
            $("#tutor-details").addClass('d-none');
            $("#tutor-history").addClass('d-none');


            $("#tutor-information").removeClass("active");
            $("#tutor-history-details").removeClass("active");
            $("#tutor-details").removeClass('show');
            $("#tutor-login-details").removeClass('d-none');
            $("#present-pending-details").removeClass('show');
            $("#present-pending-details").addClass('d-none');
            $("#sms-logs").removeClass('show');
            $("#sms-logs").addClass('d-none');
            $("#present-pending").removeClass('active');

            $("#unpaid-sms-logs").removeClass('show');
            $("#unpaid-sms-logs").addClass('d-none');
            $("#trx-history-logs").removeClass('show');
            $("#trx-history-logs").addClass('d-none');
            $("#paid-sms-logs").removeClass('show');
            $("#paid-sms-logs").addClass('d-none');
        });

        $("#tutor-login-logs").click(function () {
            $("#tutor-login-log").addClass('show');
            $("#tutor-login-log").addClass('show');
            $("#tutor-login-log").removeClass('d-none');
            $("#tutor-login-details").removeClass('show');
            $("#tutor-login-details").addClass('d-none');
            $("#unpaid-sms-logs").removeClass('show');
            $("#unpaid-sms-logs").addClass('d-none');
            $("#trx-history-logs").removeClass('show');
            $("#trx-history-logs").addClass('d-none');
            $("#paid-sms-logs").removeClass('show');
            $("#paid-sms-logs").addClass('d-none');

        });
        $("#present-pending").click(function () {
            $("#present-pending-details").addClass('show');
            $("#tutor-login-details").addClass('d-none');
            $("#tutor-login-details").removeClass('show');


            $("#tutor-details").removeClass('show');
            $("#tutor-details").addClass('d-none');
            $("#tutor-login-log").addClass('d-none');
            $("#tutor-history").addClass('d-none');
            $("#tutor-history-details").removeClass('active');
            $("#present-pending-details").removeClass('d-none');

            $("#unpaid-sms-logs").removeClass('show');
            $("#unpaid-sms-logs").addClass('d-none');
            $("#trx-history-logs").removeClass('show');
            $("#trx-history-logs").addClass('d-none');
            $("#paid-sms-logs").removeClass('show');
            $("#paid-sms-logs").addClass('d-none');



        });
        $("#sms-log").click(function () {
            $("#sms-logs").addClass('show');
            $("#sms-logs").removeClass('d-none');
            $("#tutor-login-details").addClass('d-none');
            $("#tutor-login-details").removeClass('show');


            $("#tutor-details").removeClass('show');
            $("#tutor-details").addClass('d-none');
            $("#tutor-login-log").addClass('d-none');
            $("#tutor-history").addClass('d-none');
            $("#tutor-history-details").removeClass('active');

            $("#present-pending-details").removeClass('show');
            $("#present-pending-details").addClass('d-none');



        });
        $("#paid-sms").click(function () {
            $("#paid-sms-logs").addClass('show');
            $("#paid-sms-logs").removeClass('d-none');

            $("#unpaid-sms-logs").removeClass('show');
            $("#unpaid-sms-logs").addClass('d-none');
            $("#trx-history-logs").removeClass('show');
            $("#trx-history-logs").addClass('d-none');




        });
        $("#unpaid-sms").click(function () {
            $("#unpaid-sms-logs").addClass('show');
            $("#unpaid-sms-logs").removeClass('d-none');

            $("#paid-sms-logs").removeClass('show');
            $("#paid-sms-logs").addClass('d-none');
            $("#trx-history-logs").removeClass('show');
            $("#trx-history-logs").addClass('d-none');




        });
        $("#trx-history").click(function () {
            $("#trx-history-logs").addClass('show');
            $("#trx-history-logs").removeClass('d-none');

            $("#paid-sms-logs").removeClass('show');
            $("#paid-sms-logs").addClass('d-none');
            $("#unpaid-sms-logs").removeClass('show');
            $("#unpaid-sms-logs").addClass('d-none');




        });

    });

</script>
<script>
    $(document).ready(function () {
        $("#submit").on("click", function () {
            var formData = $("#updateTutorForm").serialize();

            $.ajax({
                url: $("#updateTutorForm").attr("action"),
                type: "POST",
                data: formData,
                success: function (response) {
                    console.log(response);
                    alert("Tutor update successful!");
                },
                error: function (xhr, status, error) {
                    if (xhr.status == 422) {
                        // Handle validation errors
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = "Validation Error:\n";
                        $.each(errors, function (key, value) {
                            errorMessage += value + "\n";
                        });
                        alert(errorMessage);
                    } else {
                        // Handle other types of errors
                        var errorMessage = xhr.responseJSON.message || "An error occurred";
                        console.error(errorMessage);
                        alert(errorMessage);
                    }
                }
            });
        });
    });

</script>
@endpush
