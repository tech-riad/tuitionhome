<div class="d-flex gap-4 flex-column flex-md-row p-3 mb-2">
        <a class="text-decoration-none text-gray-800 {{ Request::is('admin/cprequest/index') ? 'active-border' : '' }}"
            href="{{ route('admin.cprequest.index') }}">CP Request</a>

</div>



    @if(session('message'))
    <p class="alert alert-success">{{ session('message') }}</p>
    @endif
