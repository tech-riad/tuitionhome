@extends('dashboard.tutor.layout')

@push('css')
    <link rel="stylesheet" href="{{ asset('/dashboard/tutor') }}/css/chosen-custom.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
          integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous"
          referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('backend/dist/js/ijaboCropTool.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

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
        <div class="modal fade"  id="exampleModal"  tabindex="-1"  aria-labelledby="exampleModalLabel"  aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">  Credential Upload  </h1>
                        <button  type="button"  class="btn-close" data-bs-dismiss="modal"  aria-label="Close"></button>
                    </div>
                    <form action="{{ route('tutor.crediantial.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <select class="form-select form-select-lg mb-3" aria-label="form-select-lg example" name="type" required id="typeSelect"  onchange="changeType(this)">
                                <option value="">~ Select Credential Type ~ </option>
                                <option value="SSC">SSC</option>
                                <option value="HSC">HSC</option>
                                <option value="honours">Honours</option>
                                <option value="masters">Masters</option>
                                @error('type')
                                <div class="error text-danger">{{ $message }}</div>
                                @enderror
                            </select>
                            <div class="file-upload">
                                <button
                                    class="file-upload-btn btn btn-primary"
                                    type="button"
                                    onclick="$('.file-upload-input').trigger( 'click' )" disabled>
                                    Add Image
                                </button>
                                <input type="file" class="file-upload-input " name="c_file" id="image_upload" hidden/>
                                @error('crediantial_file')
                                <div class="error text-danger">{{ $message }}</div>
                                @enderror

                                <div class="image-upload-wrap">
                                 <input  class="file-upload-input" type="file" onchange="readURL(this);" />

                                <div class="drag-text d-flex justify-content-center align-items-center" >

                                    @if(isset($tutor_crop_image))
                                        <input type="hidden" value="{{ ($tutor_crop_image->crop_image != null) ? $tutor_crop_image->crop_image : '' }}" name="crediantial_file">
                                        <img class="rounded-3 file-upload-image my-3 image-previewer"
                                             src="{{ asset('/files/') }}/{{ ($tutor_crop_image->crop_image != null) ? $tutor_crop_image->crop_image : '' }}"
                                             height="180px"
                                             width="70%"
                                             alt="uploaded image"
                                             style="
                          object-fit: cover;
                          /*filter: grayscale(100%);*/
                          min-width: 280px;

                        "
                                        />
                                    @endif


                                </div>

                            </div>
                        </div>
                        <div class="px-4" style="font-size: 12px;">
                            <p>
                                Note: Please Upload Certificate JPG,JPEG,PNG Format and Upload file size maximum 100KB.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Close </button>
                            <button type="submit" class="btn btn-primary upload">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- uploads model ends -->
        <div class="mt-4">
            <button data-bs-toggle="modal"  data-bs-target="#exampleModal" class="btn btn-primary px-3 py-1 rounded-3" >
                <i class="bi bi-file-earmark-arrow-up mx-2 fs-5"></i>Add Certificate
            </button>

        </div>

        <div class="d-flex gap-3 mt-4 flex-column flex-md-row">


            <div class="container">
                <div class="row">
                    @foreach($tutor_certificates as $tutor_file)
                        <div class="col-md-4 mb-4">
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
                                <div class="d-flex justify-content-between align-items-center mt-3"
                                >
                                    <div class="">
                                        <h5>{{ $tutor_file->type }}</h5>
                                        <p>23 Feb 2034</p>
                                    </div>
                                    <i class="bi bi-check-circle-fill fs-4 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>



        </div>
    </div>

    <!-- conent section ends -->
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('backend/dist/js/ijaboCropTool.min.js') }}"></script>
    ---------------------------------- tutoring info save  --------------------------------------
    <script type="text/javascript">

        function changeType(obj)
        {
            var selectedvalue = obj.value;
            if(selectedvalue == '')
            {
                $('.file-upload-btn').attr("disabled","true");
            }else
            {
                $('.file-upload-btn').removeAttr("disabled");
            }
        }
        $('#image_upload').ijaboCropTool({
            preview : '.image-previewer',
            setRatio:1,
            allowedExtensions: ['jpg','jpeg','png'],
            buttonsText:['CROP','CANCEL'],
            processUrl:'{{ route("crop-certificate") }}',
            withCSRF:['_token','{{ csrf_token() }}'],
            onSuccess:function(message, element, status){

                alert(message)
            },
            onError:function(message, element, status){
                console.log(element);
            }
        });

        $(document).ready(function (){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });
    </script>
    ---------------------------------- tutoring info save End --------------------------------------
    <script>
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
