<div class="d-flex justify-content-between align-items-center">
    <div class="d-flex gap-4 flex-column flex-md-row px-3 py-4">
        <a class="text-decoration-none text-gray-800" href="#">Affiliate Leads</a>
        <a class="text-decoration-none text-gray-800 text-nowrap {{ Request::is('admin/web-leads') ? 'active-border' : '' }}" href="{{route('admin.web.lead')}}">Website
            Leads</a>
        <a class="text-decoration-none text-gray-800 text-nowrap  {{ Request::is('admin/parent/leads') || Request::is('admin/parent/lead/view/') ? 'active-border' : '' }}"
            href="{{route('admin.parent.leads')}}">Parent Leads</a>
        <a class="text-decoration-none text-gray-800 text-nowrap {{ Request::is('admin/parent-fnf/leads') ? 'active-border' : '' }} "
            href="{{route('admin.parent.fnf.leads')}}">Parent FNF Leads</a>
    </div>
</div>
