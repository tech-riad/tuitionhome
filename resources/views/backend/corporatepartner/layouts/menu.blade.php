<div class="d-flex justify-content-between align-items-center">
    <div class="d-flex gap-4 flex-column flex-md-row px-3 py-4">
        <a class="text-decoration-none text-gray-800 text-nowrap  {{ request()->routeIs('admin.cprequest.index') ? 'active-border' : '' }}"
            href="{{ route('admin.cprequest.index') }}">CP Request</a>
        <a class="text-decoration-none text-gray-800 text-nowrap  {{ request()->routeIs('admin.cpprofile.index') ? 'active-border' : '' }}"
            href="{{ route('admin.cpprofile.index') }}">CP Profile</a>
    </div>
    <button class="btn btn-info mx-3 py-2 text-nowrap" data-bs-toggle="modal" data-bs-target="#addProfileModal"
        style="background: #3378c2">
        Add profile
    </button>
</div>
