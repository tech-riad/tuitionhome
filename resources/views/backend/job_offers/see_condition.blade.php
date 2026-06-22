
@extends('layouts.app')
@push('page_css')

@endpush


@section('content')

<main class="container-custom">
    <div class="col-md-9 ms-sm-auto col-lg-12" style="">
      <!-- main content section starts here -->
      <div class="ps-3 py-4" style="padding-right: 13px">
        <div class="p-2 shadow-lg rounded-3 bg-white">
          <div class="table-responsive">
            <table
              class="table table-hover bg-white shadow-none"
              style="border-collapse: collapse"
            >
              <thead style="border-bottom: 1px solid #c8ced3">
                <tr>
                  <th scope="col" class="text-nowrap ps-4">SL</th>
                  <th scope="col" class="text-nowrap">Job ID</th>
                  <th scope="col" class="text-nowrap">Parent Phone</th>
                  <th scope="col" class="text-nowrap">Tutor Name</th>
                  <th scope="col" class="text-nowrap">Tutor Id</th>
                  <th scope="col" class="text-nowrap">University</th>
                  <th scope="col" class="text-nowrap">Current Stage</th>
                  <th scope="col">EM Name</th>
                  <th scope="col" class="text-nowrap">EM ID</th>
                  <th scope="col" class="text-nowrap">Token Date</th>
                  <th scope="col" class="text-nowrap">Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($job_applications as $job_application)

                @php
                $jobParent = App\Models\JobOffer::where('id', $job_application->job_offer_id)->first();
                $jobParentNumber = App\Models\Parents::where('id', $jobParent->parent_id)->pluck('phone');
                @endphp
                <tr class="">

                    <td
                      scope="row "
                      class="text-center text-nowrap"
                      style="padding: 30px 18px"
                    >
                      {{ $loop->iteration}}
                    </td>
                    <td>
                      <a href="{{ route('admin.job-details', ['job' => $job_application->job_offer_id]) }}" class="text-decoration-none text-info"
                        >{{$job_application->job_offer_id}}</a
                      >
                    </td>
                    <td><b>@php
                        echo $jobParentNumber;
                    @endphp</b></td>
                    <td>
                      <a href="{{ route('admin.tutor.tutorshow', ['tutor' =>$job_application->tutor_id]) }}" target="_blank" class="text-decoration-none text-info"
                        >{{$job_application->tutor->name ?? ''}} </a
                      >
                    </td>

                    <td class="text-info">
                      <a
                        class="p-1 rounded text-info text-decoration-none"
                        style="background-color: #e6eef7"
                        >{{$job_application->tutor->unique_id ?? ''}}</a
                      >
                    </td>
                    @php
                        $university = App\Models\TutorEducation::with('institutes')->where(['tutor_id'=>$job_application->tutor_id,'degree_name'=>'honours'])->first();

                    @endphp
                    <td class="text-nowrap">{{$university->institutes->title ?? 'n/a' }} <br>
                        <p class="text-bold">{{$university->departments->title ?? ''}}</p> </td>
                    <td class="text-wrap">{{$job_application->current_stage ?? 'n/a'}}</td>
                    <td class="text-nowrap">{{$job_application->user->name ?? 'n/a'}}</td>
                    <td class="text-info">{{$job_application->taken_by_id ?? 'n/a'}}</td>
                    <td class="text-nowrap">{{$job_application->taken_at ?? 'n/a'}}</td>

                    <td class="d-flex gap-1" style="padding: 30px 0px">
                      {{-- <button
                        class="btn btn-primary py-1 px-2 taken_note" data-id="{{$job_application->id}}"
                        data-bs-toggle="modal"
                        data-bs-target="#note_modal"
                      >
                        Note
                      </button> --}}
                      <button type="button" class="btn btn-primary py-1 px-2"
                      id="{{ @$job_application->id}}"
                      onclick="btnNote(this.id)"
                      data-bs-toggle="modal"
                      data-bs-target="#noteModal">
                      Note
                     </button>
                      {{-- <button
                        class="btn btn-info py-1 px-2 text-nowrap"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModal2"
                      >
                        Create Note
                      </button> --}}
                      <button
                        class="btn btn-warning py-1 px-2 note_log"
                        data-bs-toggle="modal"  data-id="{{$job_application->id}}"
                        data-bs-target="#log_note_modal"
                      >
                        Log
                      </button>
                      @if(in_array(Auth::user()->role_id, [1, 6]))
                      <a class="btn btn-warning py-1 px-2" href="{{route('admin.job.restore-condition',$job_application->id)}}">Restore</a>
                      @endif
                    </td>
                  </tr>

                @empty
                <tr class="" style="vertical-align: middle">
                    <td colspan="10">
                     No data Available
                    </td>
                @endforelse

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- main content section ends here -->




    <!-- Note model -->
    <div class="modal fade" id="note_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Create Note
                </h5>
            </div>
            <div class="modal-body">
                <textarea name="note" class="note_description form-control">{{$job_application_note}}</textarea>
                <input type="hidden" class="taken_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light shadow-lg" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary note_submit">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>


    {{-- <div
      class="modal fade"
      id="exampleModal1"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div
        class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
      >
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Note Details
            </h5>
          </div>
          <div class="modal-body">
            <div>
              <div
                class="p-3 bg-light rounded-3 border border-1 border-dark mb-3"
              >
                <div
                  class="d-flex justify-content-between align-items-center"
                >
                  <div>
                    <p class="mb-0 text-dark fs-5">Sohag Sarkar</p>
                    <p class="text-info" style="font-size: 12px">
                      ID-23456
                    </p>
                  </div>
                  <div><p>June 17, 2023</p></div>
                </div>
                <p>
                  doloremque dolorem dolor, delectus repellendus expedita
                  modi distinctio voluptate voluptas impedit. Corrupti est
                  expedita non qui accusamus illum quam, cum cumque saepe
                  excepturi rem.
                </p>
                <div
                  class="d-flex justify-content-between align-items-center"
                >
                  <div>
                    <p>Read More</p>
                  </div>
                  <div>
                    <button class="btn btn-primary py-1">Edit</button>
                  </div>
                </div>
              </div>
              <div
                class="p-3 bg-light rounded-3 border border-1 border-dark mb-3"
              >
                <div
                  class="d-flex justify-content-between align-items-center"
                >
                  <div>
                    <p class="mb-0 text-danger fs-5">Sajid HDY</p>
                    <p class="text-info" style="font-size: 12px">
                      ID-23456
                    </p>
                  </div>
                  <div><p>June 17, 2023</p></div>
                </div>
                <p>
                  doloremque dolorem dolor, delectus repellendus expedita
                  modi distinctio voluptate voluptas impedit. Corrupti est
                  expedita non qui accusamus illum quam, cum cumque saepe
                  excepturi rem.
                </p>
                <div
                  class="d-flex justify-content-between align-items-center"
                >
                  <div>
                    <p>Read More</p>
                  </div>
                  <div>
                    <button class="btn btn-primary py-1">Edit</button>
                  </div>
                </div>
              </div>
              <div
                class="p-3 bg-light rounded-3 border border-1 border-dark mb-3"
              >
                <div
                  class="d-flex justify-content-between align-items-center"
                >
                  <div>
                    <p class="mb-0 text-dark fs-5">Sohag Sarkar</p>
                    <p class="text-info" style="font-size: 12px">
                      ID-23456
                    </p>
                  </div>
                  <div><p>June 17, 2023</p></div>
                </div>
                <p>
                  doloremque dolorem dolor, delectus repellendus expedita
                  modi distinctio voluptate voluptas impedit. Corrupti est
                  expedita non qui accusamus illum quam, cum cumque saepe
                  excepturi rem.
                </p>
                <div
                  class="d-flex justify-content-between align-items-center"
                >
                  <div>
                    <p>Read More</p>
                  </div>
                  <div>
                    <button class="btn btn-warning py-1">Edited</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="py-2"></div>
          </div>
        </div>
      </div>
    </div> --}}
    <!-- Create Note model -->
    <div
      class="modal fade"
      id="exampleModal2"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Make A Note
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <form action="">
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label"
                  >Note Title</label
                >
                <input
                  type="text"
                  class="form-control shadow-none rounded-3"
                  id="exampleFormControlInput1"
                  placeholder="Maximum 8 words can be given "
                />
              </div>
              <div>
                <label
                  for="exampleFormControlTextarea1"
                  class="form-label"
                  >Note Details</label
                >
                <textarea
                  class="form-control shadow-none rounded-3"
                  id="exampleFormControlTextarea1"
                  rows="3"
                  placeholder="Maximum 30 words can be given"
                ></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-light shadow-lg"
              data-bs-dismiss="modal"
            >
              Close
            </button>
            <button type="button" class="btn btn-primary">Save</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Log model -->
    {{-- log  note modal --}}
    <div class="modal fade" id="log_note_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Note History
                </h5>
            </div>
            <div class="modal-body">
                <input type="hidden" class="taken_id">
                <div class="note_table">

                </div>

            </div>

        </div>
    </div>
</div>
    {{-- <div
      class="modal fade"
      id="exampleModal3"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div
        class="modal-dialog modal-dialog-centered"
        style="max-width: 900px"
      >
        <div class="modal-content mx-4">
          <div class="modal-body p-0">
            <table class="table shadow-none">
              <thead
                class="text-white"
                style="background-color: #3378c2; "
              >
                <tr class="">
                  <th
                    scope="col"
                    class="border-end border-1"
                    style="border-top-left-radius: 8px;"
                  >
                    Name
                  </th>
                  <th scope="col" class="text-nowrap border-end border-1">
                    Em ID
                  </th>
                  <th scope="col" class="border-end border-1">Date</th>
                  <th
                    scope="col"
                    class="text-nowrap"
                    style="border-top-right-radius: 8px"
                  >
                    Note Before Edit
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr class="" style="vertical-align: middle">
                  <th scope="row" class="text-nowrap border-end border-1">
                    Fahmida Rahman
                  </th>
                  <td class="text-info border-end border-1">234567</td>
                  <td class="text-nowrap border-end border-1">
                    <p class="mb-0">14-06-2023</p>
                    <p class="mb-0 text-muted">47: 15: 12 PM</p>
                  </td>
                  <td>
                    <p class="border border-info p-2 rounded-3">
                      Lorem ipsum dolor sit amet consectetur adipisicing
                      elit. Reprehenderit molestias magnam doloribus
                      impedit sunt ducimus inventore voluptas numquam eum
                      ad corporis aperiam harum quo, explicabo officiis
                      suscipit, reiciendis architecto veniam amet sequi,
                      facere placeat illo veritatis. Dignissimos eius
                      quibusdam tempora!
                    </p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div> --}}
  </main>



    <!--  note model  -->
    <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 600px">
        <div class="modal-content p-2">
            <div class="modal-body py-0 mt-2">
                <div class="mb-4">

                    <form action="{{ route('admin.application.setnote') }}" id="applicationNote"
                        method="post">
                        @csrf

                        <input type="hidden" name="note_application_id" id="note_application_id">
                        <div class="mb-3">
                            <label for="notet" class="form-label fw-500 fs-14">Note</label>
                            <textarea name="application_note" placeholder="Write your note here..." class="form-control shadow-none rounded-2"
                                id="application_note" rows="4"></textarea>

                        </div>
                        <span class="text-danger error-text application_note_error"></span>

                        <div class="d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-primary px-2 py-1">
                                Create
                            </button>
                        </div>

                    </form>
                </div>
                <div class="mb-4" id="allNote">

                </div>
                {{-- <div class="mb-4">
                    <div class="border-bottom border-1 pb-3">
                        <div class="bg-light rounded-2 p-2" style="font-size: 14px">
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Perspiciatis, dignissimos.
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="d-flex justify-content-start align-items-center gap-3">
                            <img height="45" width="45" class="rounded-3"
                                src="/images/avatar.svg" alt="" />
                            <div class="">
                                <p class="m-0" style="font-size: 14; font-weight: 500">
                                    Kaji Polash
                                </p>
                                <p class="m-0 fw-light" style="font-size: 12px">
                                    Sales & Operation Dep:
                                </p>
                            </div>
                        </div>
                        <div>
                            <p style="font-size: 12px">12:30 PM 21-01-2023</p>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>



@endsection

@push('page_scripts')

<script>
      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

     //  create note script

     $('.taken_note').on('click', function(e) {

var id = $(this).data('id');
$('#note_modal').modal('show');
$('.taken_id').val(id);
$.ajax({

    type: 'POST',
    url: "{{ route('admin.applied_tutor.note.get') }}",
    data: {
        id: id
    },
    success: function(response) {
        console.log(response);
        if (response.status == 'success') {
            $('.note_description').text(response.message);
        }
        if (response.status == 'error') {
            $('.note_description').text('');
        }

    },
});


});

$('.note_submit').on('click', function() {

var note_description = $('.note_description').val();
var id = $('.taken_id').val();
$.ajax({

    type: 'POST',
    url: "{{ route('admin.applied_tutor.note') }}",
    data: {
        id: id,
        description: note_description
    },
    success: function(response) {
        console.log(response);
        if (response.status == 'success') {
            toastr.success("note saved successfully");
            $('#note_modal').modal('hide');
            location.reload();

        }

    },
});


});


// log history
$('.note_log').on('click', function(e) {

var id = $(this).data('id');
$('#log_note_modal').modal('show');
$('.taken_id').val(id);
$.ajax({

    type: 'POST',
    url: "{{ route('admin.applied_tutor.note.log') }}",
    data: {
        id: id
    },
    success: function(response) {
        console.log(response);
        if (response.status == 'success') {
            $('.note_table').html(response.data);
        }
        if (response.status == 'error') {
            $('.note_table').text(response.message);
        }

    },
});


});
</script>


@include('backend.taken_offer.js.index_page_js')

@endpush
