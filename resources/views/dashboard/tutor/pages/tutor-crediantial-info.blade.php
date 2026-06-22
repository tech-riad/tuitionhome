@extends('dashboard.tutor.layout')

@push('css')
    <link rel="stylesheet" href="{{ asset('/dashboard/tutor') }}/css/chosen-custom.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
          integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous"
          referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('backend/dist/js/ijaboCropTool.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        .file-upload-btn:active {
            border: 0;
            transition: all 0.2s ease;
        }

        .file-upload-content {
            display: none;
            text-align: center;
        }

        .file-upload-input {
            position: absolute;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            outline: none;
            opacity: 0;
            cursor: pointer;
        }

        .image-upload-wrap {
            margin-top: 20px;
            border: 2px dashed #8cbe0f;
            position: relative;
            padding: 10px;
            border-radius: 5%;
            margin-left: 10px;
            margin-right: 10px;
        }

        .image-dropping,
        .image-upload-wrap:hover {
            background-color: #f5f5f5;
            border: 2px dashed #8cbe0f;
        }
    </style>
    <style>
        [x-cloak] {
            display: none !important;
        }
        body{
            background-color: #e3e4e9;
        }
    </style>
@endpush
@section('content')


    <!-- conent section starts -->
    <!-- conent section starts -->
    <div class="t-dashboard-contant p-4" style="margin-left: 245px">
        <div class="profile-up-banner">
            <div class="d-flex flex-column pt-2">
                <div class="d-flex">
                    <div class="green-circle">
                        <span class="green-circle-text">1</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <a class="mx-2 t-link" style=" font-size: 14px;font-weight: 400;line-height: 30px; margin-top: -5px;" href="{{ route('tutor.profile.update') }}">
                            Tutoring Information
                        </a>
                        <span class="green-line"></span>
                    </div>
                </div>
                <p
                    class="money-text"
                    style="line-height: 10px; margin-left: 33px"
                >
                    33% complete
                </p>
            </div>
            <div class="d-flex flex-column pt-2">
                <div class="d-flex">
                    <div class="green-circle">
                        <span class="green-circle-text">2</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <a class="mx-2 t-link" style="font-size: 14px; font-weight: 400;line-height: 30px; margin-top: -5px;" href="{{ route('tutor.education_info') }}">
                            Education Information
                        </a>
                        <span class="green-line"></span>
                    </div>
                </div>
                <p
                    class="money-text"
                    style="line-height: 10px; margin-left: 33px"
                >
                    33% complete
                </p>
            </div>
            <div class="d-flex flex-column pt-2">
                <div class="d-flex">
                    <div class="green-circle">
                        <span class="green-circle-text">3</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <a
                            class="mx-2 t-link"
                            style="
                      font-size: 14px;
                      font-weight: 400;
                      line-height: 30px;
                      margin-top: -5px;
                    "
                            href="{{ route('tutor.personal_info') }}"
                        >
                            Personal Information
                        </a>
                        <span class="green-line"></span>
                    </div>
                </div>
                <p
                    class="money-text"
                    style="line-height: 10px; margin-left: 33px"
                >
                    33% complete
                </p>
            </div>
            <div class="d-flex flex-column pt-2">
                <div class="d-flex">
                    <div class="green-circle">
                        <span class="green-circle-text">4</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <p
                            class="mx-2 mt-2"
                            style="font-size: 14px; font-weight: 400; line-height: 3px"
                        >
                            Credential
                        </p>
                        <span class="green-line"></span>
                    </div>
                </div>
                <p
                    class="money-text"
                    style="line-height: 10px; margin-left: 33px"
                >
                    33% complete
                </p>
            </div>
        </div>

        <!-- upload model starts -->
        <div class="container">
            <div class="row mt-4">
                <div class="col-md-3">
                    @if(isset($validator))
                        <span class="text-danger">{{ $validator }}</span>
                    @endif
                    <p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".sscCrediantial" {{ (is_active() != true) ? 'disabled':'' }}>
                          SSC Credentials Upload Here
                        </button>
                    </p>
                    <div class="modal fade sscCrediantial" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                            <div class="card card-body">
                                <div class="mb-3">
                                    <label for="sscCertificate" class="form-label">SSC/O Level/Dakhil/Certificate:</label>
                                    <input type="file" name="sscCertificate" class="form-control" id="sscCertificate" aria-describedby="emailHelp">
                                    <span class="text-danger" style="font-size: 13px">JPG/JPEG/PNG Image Given Less Than 100 KB</span>
                                </div>
                                <div class="mb-3">
                                    <label for="sscMarksheet" class="form-label">SSC/O Level/Dakhil/Marksheet:</label>
                                    <input type="file" class="form-control" id="sscMarksheet" name="sscMarksheet">
                                    <span class="text-danger" style="font-size: 13px">JPG/JPEG/PNG Image Given Less Than 100 KB</span>
                                </div>
                            </div>
                                <div class="container">
                                    <div class="row">
                                        @foreach($tutor_certificates as $tutor_file)
                                            @if($tutor_file->type =='ssc_c' || $tutor_file->type =='ssc_m')
                                                <div class="col-md-6 mb-4">
                                                    <div class="bg-white rounded-3 shadow-lg px-3 pt-3">
                                                        <div>
                                                            <img
                                                                class="border border-primary rounded-3"
                                                                src="{{ asset('/files') }}/{{ $tutor_file->file_path }}"
                                                                height="180px"
                                                                width="100%"
                                                                alt="doc"
                                                                style="
                    object-fit: cover;
                    min-width: 280px;
                  "
                                                            />
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                                            <div class="">
                                                                <h5>{{ $tutor_file->type }}</h5>
                                                                <p>23 Feb 2034</p>
                                                            </div>
                                                            <i class="bi bi-check-circle-fill fs-4 text-primary"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".HSCCredentials" {{ (is_active() != true) ? 'disabled':'' }}>
                            HSC Credentials Upload Here
                        </button>
                    </p>
                    <div class="modal fade HSCCredentials" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="card card-body">
                                    <div class="mb-3">
                                        <label for="hscCertificate" class="form-label">HSC/A Level/Alim/Certificate:</label>
                                        <input type="file" name="hscCertificate" class="form-control" id="hscCertificate" aria-describedby="emailHelp">
                                        <span class="text-danger" style="font-size: 13px">JPG/JPEG/PNG Image Given Less Than 100 KB</span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="hscMarksheet" class="form-label">HSC/A Level/Alim/Marksheet:</label>
                                        <input type="file" class="form-control" id="hscMarksheet" name="hscMarksheet">
                                        <span class="text-danger" style="font-size: 13px">JPG/JPEG/PNG Image Given Less Than 100 KB</span>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        @foreach($tutor_certificates as $tutor_file)
                                            @if($tutor_file->type =='hsc_c' || $tutor_file->type =='hsc_m')
                                            <div class="col-md-6 mb-4">
                                                <div class="bg-white rounded-3 shadow-lg px-3 pt-3">
                                                    <div>
                                                        <img
                                                            class="border border-primary rounded-3"
                                                            src="{{ asset('/files') }}/{{ $tutor_file->file_path }}"
                                                            height="180px"
                                                            width="100%"
                                                            alt="doc"
                                                            style="
                    object-fit: cover;
                    min-width: 280px;
                  "
                                                        />
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                                        <div class="">
                                                            <h5>{{ $tutor_file->type }}</h5>
                                                            <p>23 Feb 2034</p>
                                                        </div>
                                                        <i class="bi bi-check-circle-fill fs-4 text-primary"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".CvUpload" style="width: 100%" {{ (is_active() != true) ? 'disabled':'' }}>
                           CV Upload Here
                        </button>
                    </p>

                    <div class="modal fade CvUpload" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="card card-body">
                                    <div class="mb-3">
                                        <label for="upload_cv" class="form-label">Upload CV :</label>
                                        <input type="file" class="form-control" id="upload_cv" name="upload_cv">
                                        <span class="text-danger" style="font-size: 13px">JPG/JPEG/PNG Image Given Less Than 100 KB</span>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        @foreach($tutor_certificates as $tutor_file)
                                            @if($tutor_file->type =='cv')
                                            <div class="col-md-6 mb-4">
                                                <div class="bg-white rounded-3 shadow-lg px-3 pt-3">
                                                    <div>
                                                        <img
                                                            class="border border-primary rounded-3"
                                                            src="{{ asset('/files') }}/{{ $tutor_file->file_path }}"
                                                            height="180px"
                                                            width="100%"
                                                            alt="doc"
                                                            style="
                    object-fit: cover;
                    min-width: 280px;
                  "
                                                        />
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                                        <div class="">
                                                            <h5>{{ $tutor_file->type }}</h5>
                                                            <p>23 Feb 2034</p>
                                                        </div>
                                                        <i class="bi bi-check-circle-fill fs-4 text-primary"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <p>
                        <button {{ (is_active() != true) ? 'disabled':'' }} type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".birth_nid_Credentials">
                            Others Crediantials Upload
                        </button>
                    </p>

                    <div class="modal fade birth_nid_Credentials" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="card card-body">
                                    <div class="mb-3">
                                        <label for="birth_nid" class="form-label">Nid/Passport/Birth Certificate:</label>
                                        <input type="file" name="birth_nid_certificate" class="form-control" id="birth_nid" aria-describedby="emailHelp">
                                        <span class="text-danger" style="font-size: 13px">JPG/JPEG/PNG Image Given Less Than 100 KB</span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="admission_certificate" class="form-label">Admission Slip/University Id Certificate :</label>
                                        <input type="file" class="form-control" id="admission_certificate" name="u_admission_certificate">
                                        <span class="text-danger" style="font-size: 13px">JPG/JPEG/PNG Image Given Less Than 100 KB</span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="other" class="form-label">Others :</label>
                                        <input type="file" class="form-control" id="other" name="others">
                                        <span class="text-danger" style="font-size: 13px">JPG/JPEG/PNG Image Given Less Than 100 KB</span>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="row">
                                        @foreach($tutor_certificates as $tutor_file)
                                            @if($tutor_file->type == 'birth_certificate' || $tutor_file->type == 'admission' || $tutor_file->type == 'other' )

                                            <div class="col-md-6 mb-4">
                                                <div class="bg-white rounded-3 shadow-lg px-3 pt-3">

                                                    <div>
                                                        <img
                                                            class="border border-primary rounded-3"
                                                            src="{{ asset('/files') }}/{{ $tutor_file->file_path }}"
                                                            height="180px"
                                                            width="100%"
                                                            alt="doc"
                                                            style="
                    object-fit: cover;
                    min-width: 280px;
                  "
                                                        />

                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                                        <div class="">
                                                            <h5>{{ $tutor_file->type }}</h5>
                                                            <p>23 Feb 2034</p>
                                                        </div>
                                                        <i class="bi bi-check-circle-fill fs-4 text-primary"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>

    <!-- conent section ends -->
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('backend/dist/js/ijaboCropTool.min.js') }}"></script>
 @include('dashboard.tutor.pages.src.file-upload-js')
    {{------------------------------------ tutoring info save  ----------------------------------------}}
    {{------------------------------------ tutoring info save End ----------------------------------------}}
   <script>


       // $(document).ready(function (){
       //     $.ajaxSetup({
       //         headers: {
       //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       //         }
       //     });
       //
       // });

       @if(Session::has('updatemessage'))
           toastr.options =
           {
               "closeButton" : true,
               "progressBar" : true
           }
       toastr.success("{{ session('updatemessage') }}");
       @endif

   </script>
@endpush
