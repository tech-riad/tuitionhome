<div class="modal fade font-pop" id="AreaSearchModal" tabindex="-1" aria-labelledby="areaSearchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered px-4" style="max-width: 1000px">
        <div class="modal-content pt-4 pb-4 ps-1">
            <div class="modal-header pe-5">
                <h5 id="areaSearchModalLabel">Area Search</h5>
                <span id="areaTutorCount" class="ms-2 text-muted">0 tutors found</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-wrap align-items-end gap-3 mb-4">
                    <div class="btn btn-outline-primary py-1">
                        <p class="p-0 m-0">SMS Range</p>
                        <p class="p-0 m-0">{{ optional($smsLimit)->latest_created_input }}</p>
                    </div>
                    @if(in_array(Auth::user()->role_id, [1, 6]))
                        <button type="button" class="btn btn-primary" onclick="$('#areaLimitModal').modal('show')">
                            Limit SMS
                        </button>
                    @endif
                    <div class="btn btn-outline-info py-1">
                        <p class="p-0 m-0">SMS Sent</p>
                        <p class="p-0 m-0" id="areaSendSmsCount">0</p>
                    </div>
                    @if(in_array(Auth::user()->role_id, [1, 6]))
                        <form action="{{ route('admin.job.sms.delete') }}" method="POST">
                            @csrf
                            <input type="hidden" name="job_id" id="areaResetJobId">
                            <button class="btn btn-ndark" type="submit">Reset</button>
                        </form>
                    @endif
                </div>

                <div class="d-flex flex-wrap align-items-end gap-2 mb-3">
                    <div>
                        <label for="areaSearchRadius" class="form-label mb-1">Radius</label>
                        <select id="areaSearchRadius" class="form-select shadow-none rounded-3">
                            @for($radius = 1; $radius <= 10; $radius++)
                                <option value="{{ $radius }}">{{ $radius }} km</option>
                            @endfor
                        </select>
                    </div>
                    <button type="button" class="btn btn-success" onclick="runAreaSearch()">Search Area</button>
                    <div class="flex-grow-1">
                        <label for="areaTutorType" class="form-label mb-1">Tutor List</label>
                        <select id="areaTutorType" class="form-select shadow-none rounded-3"
                            onchange="classifyAreaTutors(this.value)">
                            <option value="All_tutor">All Tutors</option>
                            <option value="Latest_created_tutor">Latest Created ({{ optional($smsLimit)->latest_created_input }})</option>
                            <option value="2nd_latest_created_tutor">2nd Latest Created ({{ optional($smsLimit)->second_latest_created }})</option>
                            <option value="Random_tutor">Random ({{ optional($smsLimit)->random }})</option>
                            <option value="Bottom_tutor">Bottom ({{ optional($smsLimit)->second_bottom }})</option>
                            <option value="Premium_tutor">Premium ({{ optional($smsLimit)->premium }})</option>
                            <option value="2nd_bottom_tutor">2nd Bottom ({{ optional($smsLimit)->second_bottom }})</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <p class="mb-0">Search Result Tutors</p>
                    <label class="checkbox-wrapper-13 mb-0">
                        <input type="checkbox" id="areaSelectAll" checked>
                        Select all
                    </label>
                </div>
                <div id="areaTutorsDiv"></div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <form action="{{ route('admin.job.tutor.sms') }}" target="_blank" method="POST" id="areaTutorSendSms">
                        @csrf
                        <input type="hidden" name="sms_job_id" id="areaSmsJobId">
                        <input type="hidden" name="all_t_ids" id="areaAllTutorIds">
                        <button class="btn btn-primary" type="submit">Send SMS</button>
                    </form>
                    <button type="button" class="btn btn-danger border shadow-lg" onclick="clearAreaResults()">Clear</button>
                </div>
            </div>
        </div>
    </div>
</div>

@if(in_array(Auth::user()->role_id, [1, 6]))
<div class="modal fade" id="areaLimitModal" tabindex="-1" role="dialog" aria-labelledby="areaLimitModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.sms.limit') }}" id="areaLimitForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="areaLimitModalLabel">SMS Limit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach([
                        'latest_created_input' => 'Latest Created Tutor',
                        'second_latest_created' => '2nd Latest Created',
                        'random' => 'Random',
                        'bottom' => 'Bottom',
                        'second_bottom' => '2nd Bottom',
                        'premium' => 'Premium',
                        'send_sms_range' => 'SMS Send Range',
                    ] as $field => $label)
                        <div class="mb-3">
                            <label for="area_{{ $field }}" class="form-label">{{ $label }}</label>
                            <input name="{{ $field }}" type="number" class="form-control" id="area_{{ $field }}"
                                value="{{ old($field, data_get($smsLimit, $field)) }}">
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
