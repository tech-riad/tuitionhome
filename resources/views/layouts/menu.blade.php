@push('css')
<link href="{{ asset('backend/css/menu.css') }}" rel="stylesheet" />
@endpush




<li class="nav-item active">
    <a href="{{ url('/home') }}" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>

{{--dashboard menu start here--}}
<!----------
@if(Auth::user()->role_id == 3)
<li class="nav-item {{ Request::is('admin/config/country/index')||Request::is('cities*')||Request::is('locations*')
||Request::is('categories*')||Request::is('courses*')||
Request::is('curriculas*')||Request::is('degrees*')||Request::is('studies*')||
Request::is('departments*')||Request::is('subjects*')||Request::is('institutes*') ? 'menu-is-opening menu-open active' : '' }}">
    <a href="#" class="nav-link" style="background-color: #343A40">
        <i class='fas fa-users'></i>
        <p>
            Config
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('locations.index') }}" class="nav-link {{ Request::is('locations*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p style="font-size: 12px">Locations</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('subjects.index') }}" class="nav-link {{ Request::is('subjects*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p style="font-size: 12px">Subjects</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('course_subject.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p style="font-size: 12px">Course & Subjects</p>
            </a>
        </li>

    </ul>
</li>
@endif

@if(Auth::user()->role_id == 4)
<li class="nav-item {{ Request::is('admin/config/country/index')||Request::is('cities*')||Request::is('locations*')
||Request::is('categories*')||Request::is('courses*')||
Request::is('curriculas*')||Request::is('degrees*')||Request::is('studies*')||
Request::is('departments*')||Request::is('subjects*')||Request::is('institutes*') ? 'menu-is-opening menu-open active' : '' }}">
    <a href="#" class="nav-link" style="background-color: #343A40">
        <i class='fas fa-users'></i>
        <p>
            Config
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="#" class="nav-link {{ Request::is('institutes*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p style="font-size: 12px">Institutes</p>
            </a>
        </li>
    </ul>
</li>
@endif
---->

@if(in_array(Auth::user()->role_id, [1, 6]))
{{--Start config menu--}}
<li class="nav-item {{ Request::is('admin/config/country/index')||Request::is('cities*')||Request::is('locations*')
||Request::is('categories*')||Request::is('courses*')||
Request::is('curriculas*')||Request::is('degrees*')||Request::is('studies*')||
Request::is('departments*')||Request::is('subjects*')||Request::is('institutes*') ? 'menu-is-opening menu-open active' : '' }}">
    <a href="#" class="nav-link" style="background-color: #343A40">
        <i class='fas fa-users'></i>
        <p>
            Config
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item ">
            <a href="{{route('admin.config.requirement.template')}}"
                class="nav-link {{ Request::is('config/requirement/template') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p style="font-size: 12px">Requirement Template</p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="{{route('admin.config.country.index')}}"
                class="nav-link {{ Request::is('admin/config/country/index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p style="font-size: 12px">Country</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('cities.index') }}" class="nav-link {{ Request::is('cities*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p style="font-size: 12px">Cities</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('locations.index') }}" class="nav-link {{ Request::is('locations*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p style="font-size: 12px">Locations</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('categories.index') }}" class="nav-link {{ Request::is('categories*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p style="font-size: 12px">Categories</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('courses.index') }}" class="nav-link {{ Request::is('courses*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p style="font-size: 12px">Courses</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('curriculas.index') }}" class="nav-link {{ Request::is('curriculas*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p style="font-size: 12px">Curriculas</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('degrees.index') }}" class="nav-link {{ Request::is('degrees*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p style="font-size: 12px">Degrees</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('studies.index') }}" class="nav-link {{ Request::is('studies*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p style="font-size: 12px">Studies</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('departments.index') }}"
                class="nav-link {{ Request::is('departments*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p style="font-size: 12px">Departments</p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ route('subjects.index') }}" class="nav-link {{ Request::is('subjects*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p style="font-size: 12px">Subjects</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('course_subject.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p style="font-size: 12px">Course & Subjects</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('institutes.index') }}" class="nav-link {{ Request::is('institutes*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p style="font-size: 12px">Institutes</p>
            </a>
        </li>

    </ul>
</li>
{{--End of config menu--}}



{{--admin menu--}}

<li
    class="nav-item {{Request::is('admin/users')||Request::is('admin/roles')|| Request::is('admin/permission/index') ? 'menu-is-opening menu-open active' : '' }}">
    <a href="#" class="nav-link " style="background-color: #343A40">
        <i class='fas fa-users'></i>
        <p>
            Admin Users
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('admin.users.index')}}" class="nav-link {{ Request::is('admin/users') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Add User</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.user.activity')}}" class="nav-link {{ Request::is('admin/user/activity') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>User Activity</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.roles.index')}}" class="nav-link {{ Request::is('admin/roles') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Role & Permission</p>
            </a>
        </li>
        @if(Auth::user()->role_id == 1)
        <li class="nav-item">
            <a href="{{route('admin.permission.index')}}"
                class="nav-link {{ Request::is('admin/permission/index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Permission List</p>
            </a>
        </li>
        @endif



    </ul>
</li>
@endif


{{-- Sms template module --}}



<li class="nav-item">
    <a href="{{route('admin.sms_template.index')}}" class="nav-link " style="background-color: #343A40">
        <i class="fa fa-envelope"></i> <span>Sms Templates</span>
    </a>
</li>

{{-- end Sms template module --}}

{{-- Job Offers --}}
<li
    class="nav-item {{Request::is('admin/job-offer/all-offer')||Request::is('admin/job-offer/available-offer')|| Request::is('admin/job-offer/application-offer') || Request::is('admin/job-offer') ? 'menu-is-opening menu-open active' : '' }}">
    <a href="#" class="nav-link" style="background-color: #343A40">
        <i class='fas fa-envelope'></i>
        <p>
            Job Offers
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item ">
            <a href="{{ route('admin.job-offer.all-offers')}}"
                class="nav-link  {{ Request::is('admin/job-offer/all-offer') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>All Job Offers</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.job-offer.available-offers')}}"
                class="nav-link {{ Request::is('admin/job-offer/available-offer') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Available Offers</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.job-offer.application-offers')}}"
                class="nav-link {{ Request::is('admin/job-offer/application-offer') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Applications</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.job-offer.index')}}"
                class="nav-link {{ Request::is('admin/job-offer') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Offer</p>
            </a>
        </li>

    </ul>
</li>
{{-- Job Offers --}}
<li
    class="nav-item {{Request::is('admin/taken-offer/assign-offer')||Request::is('admin/taken-offer/waiting-offer')||Request::is('admin/taken-offer/meeting-offer')||Request::is('admin/taken-offer/trial-offer')
    ||Request::is('admin/taken-offer/confirm-offer')||Request::is('admin/taken-offer/repost-offer')||Request::is('admin/taken-offer/payment-offer') ? 'menu-is-opening menu-open active' : '' }}">
    <a href="#" class="nav-link" style="background-color: #343A40">
        <i class='fas fa-envelope'></i>
        <p>
            Taken Management
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item ">
            <a href="{{ route('admin.taken_offer.assign.offer')}}"
                class="nav-link  {{ Request::is('admin/taken-offer/assign-offer') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Assign Offer</p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="{{ route('admin.taken_offer.waiting.offer')}}"
                class="nav-link  {{ Request::is('admin/taken-offer/waiting-offer') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Waiting Offer</p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="{{ route('admin.taken_offer.meeting.offer')}}"
                class="nav-link  {{ Request::is('admin/taken-offer/meeting-offer') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Meeting Offer</p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="{{ route('admin.taken_offer.trial.offer')}}"
                class="nav-link  {{ Request::is('admin/taken-offer/trial-offer') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Trial Offer</p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="{{ route('admin.taken_offer.problem.offer')}}"
                class="nav-link  {{ Request::is('admin/taken-offer/problem-offer') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Problem Offer</p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="{{ route('admin.taken_offer.repost.offer')}}"
                class="nav-link  {{ Request::is('admin/taken-offer/repost-offer') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Repost Offer</p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="{{ route('admin.taken_offer.closed.offer')}}"
                class="nav-link  {{ Request::is('admin/taken-offer/closed-offer') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Closed Offer</p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="{{ route('admin.taken_offer.confirm.offer')}}"
                class="nav-link  {{ Request::is('admin/taken-offer/confirm-offer') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Confirm Offer</p>
            </a>
        </li>

        <li class="nav-item ">
            <a href="{{ route('admin.taken_offer.payment.offer')}}"
                class="nav-link  {{ Request::is('admin/taken-offer/payment-offer') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>payment Offer</p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="{{ route('admin.taken_offer.due.offer')}}"
                class="nav-link  {{ Request::is('admin/taken-offer/due-offer') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Due Offer</p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="{{ route('admin.taken_offer.refund.offer')}}"
                class="nav-link  {{ Request::is('admin/taken-offer/refund-offer') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Refund Offer</p>
            </a>
        </li>
    </ul>
</li>
{{-- Taken Offers --}}
<li class="nav-item">
    <a href="{{route('admin.taken_offer.index')}}" class="nav-link" style="background-color: #343A40">
        <i class='fas fa-users'></i>
        <p>
            Taken Offers
        </p>
    </a>

</li>
{{-- Payments --}}

<li class="nav-item">
    <a href="#" class="nav-link " style="background-color: #343A40">
        <i class='fas fa-bus'></i>
        <i class="fa-light fa-money-check-dollar"></i>
        <p>
            Payments
        </p>
    </a>

</li>
{{-- parents --}}
<li class="nav-item">
    <a href="#" class="nav-link" style="background-color: #343A40">
        <i class='fas fa-users'></i>
        <p>
            Parents
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item ">
            <a href="{{route('parent.create')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>New Parent</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('parent.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Parents</p>
            </a>
        </li>


    </ul>
</li>

{{-- tutors --}}
<li class="nav-item">
    <a href="#" class="nav-link" style="background-color: #343A40">
        <i class='fas fa-users'></i>
        <p>
            Tutors
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item ">
            <a href="{{route('tutor.create')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>New Tutor</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('tutor.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>tutors</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.tutor.premium')}}" class="nav-link ">
                <i class="far fa-circle nav-icon"></i>
                <p>Premium Tutors</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.tutor.featured')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Featured Tutors</p>
            </a>
        </li>

    </ul>
</li>
{{-- Request Management --}}
<li class="nav-item {{ Request::is('admin/premium-membership-request') ? 'menu-is-opening menu-open active' : '' }}">
    <a href="#" class="nav-link " style="background-color: #343A40">
        <i class="fas fa-users"></i>
        <p>
            Request Management
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>

    @php
      $premiumRequestCount = App\Models\PremiumMembership::where('request_status', 'pending')->count();
      $verifyRequestCount = App\Models\VerificationRequest::where('request_status', 'pending')->count();
    @endphp
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.premium.membership') }}" class="nav-link {{ Request::is('admin/premium-membership-request*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Premium Request<br>
                     <span class="text-red">{{$premiumRequestCount ?? ''}}</span></p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Affiliate Request</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.verify.request')}}" class="nav-link {{ Request::is('/admin/verify-request*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Verification Request</p>
                <span class="text-red">{{$verifyRequestCount ?? ''}}</span></p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Affiliate Leads</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.parent.leads')}}" class="nav-link {{ Request::is('/admin/parent/leads') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Parent Leads</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.parent.fnf.leads')}}" class="nav-link {{ Request::is('admin/parent-fnf/leads') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Parent Fnf Leads</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.web.lead')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Web Leads</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.cat.request')}}" class="nav-link {{ Request::is('/admin/tutor-category-request') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Category Request</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.request.tutor')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Tutor Request</p>
            </a>
        </li>
    </ul>
</li>


{{-- pending approval --}}
<li class="nav-item">
    <a href="#" class="nav-link" style="background-color: #343A40">
        <i class='fas fa-users'></i>
        <p>
            Pending Approval
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    @php

    $instituteCount = App\Models\TutorTypeUniversity::all()->count();
    @endphp
    <ul class="nav nav-treeview ">
        <li class="nav-item ">
            <a href="{{route('admin.approve.institute')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Institution Approval <span
                        class="badge rounded-pill badge-notification bg-danger">{{$instituteCount}}</span>
                </p>
            </a>
        </li>


    </ul>
</li>

{{-- Payment --}}
<li class="nav-item">
    <a href="#" class="nav-link" style="background-color: #343A40">
        <i class="bi bi-credit-card fs-5 me-4"></i>
        <p>
            Payment
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>

    <ul class="nav nav-treeview ">
        <li class="nav-item ">
            <a href="{{route('admin.payment')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                Revenue
            </a>
        </li>
        <li class="nav-item ">
            <a href="{{route('admin.due.payment')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                Due
            </a>
        </li>
        <li class="nav-item ">
            <a href="{{route('admin.payment.employee')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                Employee
            </a>
        </li>


    </ul>
</li>


{{-- Blog --}}
<li
    class="nav-item {{ Request::is('admin/blog/category')||Request::is('admin/blog/tag/index')||Request::is('admin/blog/posts')
  ||Request::is('admin/blog/reviews')||Request::is('admin/blog/comments') ? 'menu-is-opening menu-open active' : '' }}">
    <a href="#" class="nav-link" style="background-color: #343A40">
        <i class='fas fa-blog'></i>
        <p>
            Blog
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('blog.category')}}"
                class="nav-link {{ Request::is('admin/blog/category') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Blog Category</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('blog.course')}}"
                class="nav-link {{ Request::is('/admin/course-blogs') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Blog Course</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('blog.tag.index')}}"
                class="nav-link {{ Request::is('admin/blog/tag/index') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Blog Tags</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('blog.posts')}}" class="nav-link {{ Request::is('admin/blog/posts') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Blog Posts</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="" class="nav-link {{ Request::is('admin/blog/reviews') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Blog Reviews</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('blog.comment.index')}}"
                class="nav-link {{ Request::is('admin/blog/comments') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Blog Comments</p>
            </a>
        </li>
    </ul>
</li>

{{-- Affiliate --}}
<li class="nav-item">
    <a href="#" class="nav-link" style="background-color: #343A40">
        <i class='fas fa-users'></i>
        <p>
            Corporate Partner
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('admin.cprequest.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Partner Request</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.roles.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reference </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.roles.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reference Transations</p>
            </a>
        </li>
    </ul>
</li>

{{-- @if(Auth::user()->role_id == 1) --}}
{{-- Video Tutorials --}}
<li class="nav-item">
    <a href="{{route('tutorial.index')}}" class="nav-link" style="background-color: #343A40">
        <i class='fas fa-users'></i>
        <p>
            Video Tutorials
        </p>
    </a>




<li class="nav-item">
    <a href="" class="nav-link" style="background-color: #343A40">
        <i class='fas fa-users'></i>
        <p>
            SMS Module
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <li class="nav-item ">
            <a href="{{route('admin.bulk-sms')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Bulk SMS</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('admin.sms.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Bulk SMS template</p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item ">
            <a href="{{route('admin.sms.log')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>SMS Logs</p>
            </a>
        </li>

    </ul>

</li>
{{-- Reviews --}}
<li class="nav-item">
    <a href="" class="nav-link" style="background-color: #343A40">
        <i class='fas fa-users'></i>
        <p>
            Reviews
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <li class="nav-item ">
            <a href="{{route('admin.reviews.tutor')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Tutor Reviews</p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="{{route('admin.reviews.website')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Website Reviews</p>
            </a>
        </li>

    </ul>


</li>
{{-- Setting --}}
<li class="nav-item">
    <a href="{{ route('setting.index') }}" class="nav-link" style="background-color: #343A40">
        <i class='fas fa-sun'></i>
        <i class="fa-light fa-money-check-dollar"></i>
        <p>
            Setting
        </p>
    </a>

</li>
{{-- @endif --}}

<li class="nav-item">
    <a href="{{ route('admin.social.media') }}" class="nav-link" style="background-color: #343A40">
        <i class='fas fa-sun'></i>
        <i class="fa-light fa-money-check-dollar"></i>
        <p>
            Social Media
        </p>
    </a>

</li>


{{-- Marketting --}}

<li class="nav-item">
    <a href="" class="nav-link" style="background-color: #343A40">
        <i class='fas fa-users'></i>
        <p>
            Marketting
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <li class="nav-item ">
            <a href="{{route('admin.all.notice')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Notice</p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="{{route('admin.all.popupimage')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Popup</p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="{{route('admin.sms.marketting')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Sms Marketing</p>
            </a>
        </li>

    </ul>


</li>


{{--end admin menu--}}
