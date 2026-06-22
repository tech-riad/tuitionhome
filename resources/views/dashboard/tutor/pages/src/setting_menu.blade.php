<div class="setting-nav w-md-25 " style="max-height: 400px;">
    <ui>
        <li class="setting-nav-item px-4 ">
            <!-- add class its-active to make it active -->
            <a
                class="t-link its-active d-none d-md-block text-nowrap"
                href="{{ route('tutor.Setting') }}"
            ><i class="bi bi-person-fill mx-2"></i>Signup Information
            </a>
            <a
                class="t-link its-active d-md-none d-block"
                href="{{ route('tutor.Setting') }}"
            ><i class="bi bi-person-fill mx-2 fs-1"></i>
            </a>
        </li>
        <li class="setting-nav-item px-4">
            <a class="t-link d-none d-md-block text-nowrap" href="{{ route('tutor.notification')  }}"
            ><i class="bi bi-bell-fill mx-2"></i> Notifications</a
            >
            <a
                class="t-link  d-md-none d-block"
                href="{{ route('tutor.notification')  }}"
            ><i class="bi bi-bell-fill mx-2 fs-1"></i>
            </a>
        </li>
        <li class="setting-nav-item px-4">
            <a class="t-link d-none d-md-block text-nowrap" href="{{ route('tutor.notification')  }}"
            ><i class='bi bi-bell-fill mx-2'></i> Message Alert</a
            >
            <a
                class="t-link  d-md-none d-block"
                href="{{ route('tutor.notification')  }}"
            ><i class="bi bi-bell-fill mx-2 fs-1"></i>
            </a>
        </li>

        <li class="setting-nav-item px-4">
            <a class="t-link d-none d-md-block text-nowrap" href="{{ route('tutor.change-password') }}"
            ><i class="bi bi-shield-lock-fill mx-2"></i>Password &
                Security</a
            >
            <a
                class="t-link  d-md-none d-block"
                href="{{ route('tutor.change-password') }}"
            ><i class="bi bi-shield-lock-fill mx-2 fs-1"></i>
            </a>
        </li>
        <li class="setting-nav-item px-4">
            <a class="t-link d-none d-md-block text-nowrap" href="{{route('tutor.status')}}"
            ><i class="bi bi-gear-fill mx-2"></i> Accounts Status</a
            >
            <a
                class="t-link  d-md-none d-block"
                href="{{route('tutor.status')}}"
            ><i class="bi bi-gear-fill mx-2 fs-1"></i>
            </a>
        </li>
{{--        <li class="Setting-nav-item px-4">--}}
{{--            <a class="t-link d-none d-md-block text-nowrap" href="{{ route('tutor.account-deactivate') }}"--}}
{{--            ><i class="bi bi-trash2-fill mx-2"></i>Deactivate Account</a--}}
{{--            >--}}
{{--            <a--}}
{{--                class="t-link  d-md-none d-block"--}}
{{--                href="{{ route('tutor.account-deactivate') }}"--}}
{{--            ><i class="bi bi-trash2-fill mx-2 fs-1"></i>--}}
{{--            </a>--}}
{{--        </li>--}}
    </ui>
</div>
