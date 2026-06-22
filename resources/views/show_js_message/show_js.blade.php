@push('page_scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnj s.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" ></script>
    @if(Session::has("message"))
        <script>
            toastr.info({{ Session::get('message') }});
        </script>
    @endif
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
@endpush
