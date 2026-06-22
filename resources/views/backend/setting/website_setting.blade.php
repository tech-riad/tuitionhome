<x-backend.layouts.master>


    <div class="col-md-10">
        <div class="card">
            <h5 class="card-header">Set A Point</h5>
            <div class="card-body">
                <div class="col-lg-4">
                    <div class="pb-3">
                        <label for="datet" class="form-label">Set Point</label>
                        <input type="date" class="form-control shadow rounded-2" id="datet" value="{{ $data->set_point_date ?? '' }}" />
                    </div>
                    <button type="button" class="btn btn-primary" id="submitButton">
                        Submit
                    </button>
                </div>
            </div>
        </div>
        <div class="card">
            <h5 class="card-header">Application Payment Data : </h5>
            <div class="card-body">
                <div class="col-lg-4">
                    <div class="pb-3">
                        <label for="datet" class="form-label gap-5 mr-4">All Payment :</label>
                        <a href="{{ route('export.payment') }}" class="btn btn-primary">Download Payment as Excel</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="pb-3">
                        <form action="{{ route('export.data') }}" method="GET">
                            <label for="start_date">Date Wise:</label>
                            <div class="row pb-3">
                                <div class="col-lg-6">
                                    <input type="date" class="form-control" name="start_date" id="start_date" required>

                                </div>
                                <div class="col-lg-6">
                                    <input type="date" class="form-control" name="end_date" id="end_date" required>

                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Download Data</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <h5 class="card-header">Due Data : </h5>
            <div class="card-body">
                <div class="col-lg-4">
                    <div class="pb-3">
                        <label for="datet" class="form-label gap-5 mr-4">All Due :</label>
                        <a href="{{ route('export.due') }}" class="btn btn-primary">Download Due as Excel</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="pb-3">
                        <form action="{{ route('export.data.date.wise') }}" method="GET">
                            <label for="start_date">Date Wise:</label>
                            <div class="row pb-3">
                                <div class="col-lg-6">
                                    <input type="date" class="form-control" name="start_date" id="start_date" required>

                                </div>
                                <div class="col-lg-6">
                                    <input type="date" class="form-control" name="end_date" id="end_date" required>

                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Download Data</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @include('js.swtdeleteMethod_js')
    <script>
        $(document).ready(function() {
            $('#submitButton').on('click', function() {
                var dateTo = $('#datet').val();

                $.ajax({
                    url: '{{ route('website.payment.setpoint') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        set_point_date: dateTo
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data saved successfully',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred',
                            text: 'Failed to save data'
                        });
                    }
                });
            });
        });
    </script>






</x-backend.layouts.master>

