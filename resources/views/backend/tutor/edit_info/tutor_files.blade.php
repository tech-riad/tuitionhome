@if(session('message'))
<p class="alert alert-success">{{ session('message') }}</p>
@endif

<div class="row row-cols-lg-12">
    <div style="">
        <div class="bg-white rounded-3 shadow-lg p-4 mb-4" style="height: 580px">
            <form id="certificateForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="tutor_id" value="{{ $tutor->id }}">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>SSC/O Level /Dakhil/Certificate :</label>
                                    <input type="file" name="ssc_c" class="form-control" />
                                    <span class="text-danger error-text ssc_c_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <strong style="text-align: center;"></strong>
                                    <div class="card-body">
                                        @if($tutor->TutorCertificate != null)
                                        <a href="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->ssc_c ) }}"
                                            target="_blank">
                                            <img width="250" height="80"
                                                src="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->ssc_c) }}">
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>SSC/O Level /Dakhil/Marksheet :</label>
                                    <input type="file" name="ssc_m" class="form-control" />
                                    <span class="text-danger error-text ssc_m_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <strong style="text-align: center;"></strong>
                                    <div class="card-body">
                                        @if($tutor->TutorCertificate != null)
                                        <a href="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->ssc_m ) }}"
                                            target="_blank">
                                            <img width="250" height="80"
                                                src="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->ssc_m) }}">
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>HSC/A Level /Alim/Certificate : </label>
                                    <input type="file" name="hsc_c" class="form-control" />
                                    <span class="text-danger error-text hsc_c_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <strong style="text-align: center;"></strong>
                                    <div class="card-body">
                                        @if($tutor->TutorCertificate != null)
                                        <a href="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->hsc_c ) }}"
                                            target="_blank">
                                            <img width="250" height="80"
                                                src="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->hsc_c) }}">
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>HSC/A Level /Alim/Marksheet  : </label>
                                    <input type="file" name="hsc_m" class="form-control" />
                                    <span class="text-danger error-text hsc_m_error"></span>
                                </div>
                            </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <strong style="text-align: center;"></strong>
                                        <div class="card-body">
                                            @if($tutor->TutorCertificate != null)
                                            <a href="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->hsc_m ) }}"
                                                target="_blank">
                                                <img width="250" height="80"
                                                    src="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->hsc_m) }}">
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Nid/Passport/Birth Certificate : </label>
                                    <input type="file" name="nid" class="form-control" />
                                    <span class="text-danger error-text nid_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <strong style="text-align: center;"></strong>
                                    <div class="card-body">
                                        @if($tutor->TutorCertificate != null)
                                        <a href="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->nid ) }}"
                                            target="_blank">
                                            <img width="250" height="80"
                                                src="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->nid) }}">
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Admission Slip/University Id Certificate : </label>
                                    <input type="file" name="university_c" class="form-control" />
                                    <span class="text-danger error-text university_c_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <strong style="text-align: center;"></strong>
                                    <div class="card-body">
                                        @if($tutor->TutorCertificate != null)
                                        <a href="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->university_c ) }}"
                                            target="_blank">
                                            <img width="250" height="80"
                                                src="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->university_c) }}">
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Upload CV : </label>
                                    <input type="file" name="cv" class="form-control" />
                                    <span class="text-danger error-text cv_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <strong style="text-align: center;"></strong>
                                    <div class="card-body">
                                        @if($tutor->TutorCertificate != null)
                                        <a href="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->cv ) }}"
                                            target="_blank">
                                            <img width="250" height="80"
                                                src="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->cv) }}">
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Others : </label>
                                    <input type="file" name="others" class="form-control" />
                                    <span class="text-danger error-text others_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <strong style="text-align: center;"></strong>
                                    <div class="card-body">
                                        @if($tutor->TutorCertificate != null)
                                        <a href="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->others ) }}"
                                            target="_blank">
                                            <img width="250" height="80"
                                                src="{{ asset('storage/tutor-certificate/'. $tutor->TutorCertificate->others) }}">
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>

</div>

