<div class="d-flex gap-4 flex-column flex-md-row p-3 mb-2">
        <a class="text-decoration-none text-gray-800  {{ request()->routeIs('admin.cprequest.index') ? 'active-border' : '' }}"
            href="{{ route('admin.cprequest.index') }}">CP Request</a>
        <a class="text-decoration-none text-gray-800  {{ request()->routeIs('admin.cpprofile.index') ? 'active-border' : '' }}"
            href="{{ route('admin.cpprofile.index') }}">CP Profile</a>

</div>



@if(session('message'))
<p class="alert alert-success">{{ session('message') }}</p>
@endif
