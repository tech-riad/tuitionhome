<div class="d-flex gap-4 flex-column flex-md-row p-3 tabholder ">

    @php
    $user_id = Auth::user()->role_id;
    @endphp
    <a style="border: 1px solid #c5bfbf"
        class="text-decoration-none btn text-white-600 {{ Request::is('admin/taken-offer/assign-offer') ? 'btn-primary active-border' : '' }}"
        href="{{ route('admin.taken_offer.assign.offer') }}">Assign
        <span class="badge rounded-pill text-gray-600 bg-light fw-normal">
            @php
            $cacheKey = $user_id == 2
            ? 'assign_count_taken_by_' . Auth::id()
            : 'assign_count_all';

            $assignCount = Cache::remember($cacheKey, now()->addHours(24), function () use ($user_id) {
            $query = App\Models\JobApplication::where('current_stage', 'assign');

            if ($user_id == 2) {
            $query->where('taken_by_id', Auth::id());
            }

            return $query->count();
            });
            @endphp

            {{ $assignCount }}
        </span>
    </a>

    <a style="border: 1px solid #c5bfbf"
        class="text-decoration-none btn text-white-600 {{ Request::is('admin/taken-offer/waiting-offer') ? 'btn-primary active-border' : '' }}"
        href="{{ route('admin.taken_offer.waiting.offer') }}">Waiting
        <span class="badge rounded-pill text-gray-600 bg-light fw-normal">
            @php
            $cacheKey = $user_id == 2
            ? 'waiting_count_taken_by_' . Auth::id()
            : 'waiting_count_all';

            $waitingCount = Cache::remember($cacheKey, now()->addHours(24), function () use ($user_id) {
            $query = App\Models\JobApplication::where('current_stage', 'waiting');

            if ($user_id == 2) {
            $query->where('taken_by_id', Auth::id());
            }

            return $query->count();
            });
            @endphp

            {{ $waitingCount }}
        </span>
    </a>

    <a style="border: 1px solid #c5bfbf" class="text-decoration-none btn  text-white-600 {{ Request::is('admin/taken-offer/meeting-offer') ? 'btn-primary active-border' : '' }}"
        href="{{ route('admin.taken_offer.meeting.offer') }}">Meeting
        <span class="badge rounded-pill text-gray-600 bg-light fw-normal">
            @php
            $cacheKey = $user_id == 2
            ? 'meeting_count_taken_by_' . Auth::id()
            : 'meeting_count_all';

            $meetingCount = Cache::remember($cacheKey, now()->addHours(24), function () use ($user_id) {
            $query = App\Models\JobApplication::where('current_stage', 'meet');

            if ($user_id == 2) {
            $query->where('taken_by_id', Auth::id());
            }

            return $query->count();
            });
            @endphp

            {{ $meetingCount }}
        </span>
    </a>

    <a style="border: 1px solid #c5bfbf" class="text-decoration-none btn text-white-600 {{ Request::is('admin/taken-offer/trial-offer') ? 'btn-primary active-border' : '' }}"
        href="{{ route('admin.taken_offer.trial.offer') }}">Trial
        <span class="badge rounded-pill text-gray-600 bg-light fw-normal">
            @php
            $cacheKey = $user_id == 2
            ? 'trial_count_taken_by_' . Auth::id()
            : 'trial_count_all';

            $trialCount = Cache::remember($cacheKey, now()->addHours(24), function () use ($user_id) {
            $query = App\Models\JobApplication::where('current_stage', 'trial');

            if ($user_id == 2) {
            $query->where('taken_by_id', Auth::id());
            }

            return $query->count();
            });
            @endphp

            {{ $trialCount }}
        </span>
    </a>

    <a style="border: 1px solid #c5bfbf"  class="text-decoration-none btn  text-white-600 {{ Request::is('admin/taken-offer/problem-offer') ? 'btn-primary active-border' : '' }}"
        href="{{route('admin.taken_offer.problem.offer')}}">Problem
        <span class="badge rounded-pill text-gray-600 bg-light fw-normal">
            @php
            $cacheKey = $user_id == 2
            ? 'problem_count_taken_by_' . Auth::id()
            : 'problem_count_all';

            $problemCount = Cache::remember($cacheKey, now()->addHours(24), function () use ($user_id) {
            $query = App\Models\JobApplication::where('current_stage', 'problem');

            if ($user_id == 2) {
            $query->where('taken_by_id', Auth::id());
            }

            return $query->count();
            });
            @endphp

            {{ $problemCount }}
        </span>
    </a>

    <a style="border: 1px solid #c5bfbf" class="text-decoration-none btn  text-white-600 {{ Request::is('admin/taken-offer/repost-offer') ? 'btn-primary active-border' : '' }}"
        href="{{ route('admin.taken_offer.repost.offer') }}">Repost
        <span class="badge rounded-pill text-gray-600 bg-light fw-normal">
            @php
            $cacheKey = $user_id == 2
            ? 'repost_count_taken_by_' . Auth::id()
            : 'repost_count_all';

            $repostCount = Cache::remember($cacheKey, now()->addHours(24), function () use ($user_id) {
            $query = App\Models\JobApplication::where('current_stage', 'repost');

            if ($user_id == 2) {
            $query->where('taken_by_id', Auth::id());
            }

            return $query->count();
            });
            @endphp

            {{ $repostCount }}
        </span>
    </a>

    <a style="border: 1px solid #c5bfbf"  class="text-decoration-none btn  text-white-600 {{ Request::is('admin/taken-offer/closed-offer') ? 'btn-primary active-border' : '' }}"
        href="{{route('admin.taken_offer.closed.offer')}}">Closed
        <span class="badge rounded-pill text-gray-600 bg-light fw-normal">
            @php
            $cacheKey = $user_id == 2
            ? 'closed_count_taken_by_' . Auth::id()
            : 'closed_count_all';

            $closedCount = Cache::remember($cacheKey, now()->addHours(24), function () use ($user_id) {
            $query = App\Models\JobApplication::where('current_stage', 'closed');

            if ($user_id == 2) {
            $query->where('taken_by_id', Auth::id());
            }

            return $query->count();
            });
            @endphp

            {{ $closedCount }}
        </span>
    </a>

    <a style="border: 1px solid #c5bfbf" class="text-decoration-none btn  text-white-600 {{ Request::is('admin/taken-offer/confirm-offer') ? 'btn-primary active-border' : '' }}"
        href="{{ route('admin.taken_offer.confirm.offer') }}">Confirm
        <span class="badge rounded-pill text-gray-600 bg-light fw-normal">
            @php
            $cacheKey = $user_id == 2
            ? 'confirm_count_taken_by_' . Auth::id()
            : 'confirm_count_all';

            $confirmCount = Cache::remember($cacheKey, now()->addHours(24), function () use ($user_id) {
            $query = App\Models\JobApplication::where('current_stage', 'confirm')
            ->where('payment_status', null);

            if ($user_id == 2) {
            $query->where('taken_by_id', Auth::id());
            }

            return $query->count();
            });
            @endphp

            {{ $confirmCount }}
        </span>
    </a>

    <a style="border: 1px solid #c5bfbf" class="text-decoration-none btn  text-white-600 {{ Request::is('admin/taken-offer/payment-offer') ? 'btn-primary active-border' : '' }}"
        href="{{ route('admin.taken_offer.payment.offer') }}">Payment
        <span class="badge rounded-pill text-gray-600 bg-light fw-normal">
            @php
            $cacheKey = $user_id == 2
            ? 'payment_count_taken_by_' . Auth::id()
            : 'payment_count_all';

            $paymentCount = Cache::remember($cacheKey, now()->addHours(24), function () use ($user_id) {
            $query = App\Models\JobApplication::where(function ($query) {
            $query->where('payment_status', 'paid')
            ->orWhere('payment_status', 'Partial_paid')
            ->orWhere('payment_status', 'due');
            });

            if ($user_id == 2) {
            $query->where('taken_by_id', Auth::id());
            }

            return $query->count();
            });
            @endphp

            {{ $paymentCount }}
        </span>
    </a>

    <a style="border: 1px solid #c5bfbf" class="text-decoration-none btn  text-white-600 {{ Request::is('admin/taken-offer/due-offer') ? 'btn-primary active-border' : '' }}"
        href="{{route('admin.taken_offer.due.offer')}}">Due
        <span class="badge rounded-pill text-gray-600 bg-light fw-normal">
            @php
            $cacheKey = $user_id == 2
            ? 'due_count_taken_by_' . Auth::id()
            : 'due_count_all';

            $dueCount = Cache::remember($cacheKey, now()->addHours(24), function () use ($user_id) {
            $query = App\Models\JobApplication::where(function ($query) {
            $query->where('payment_status', 'Partial_paid')
            ->orWhere('payment_status', 'due');
            });

            if ($user_id == 2) {
            $query->where('taken_by_id', Auth::id());
            }

            return $query->count();
            });
            @endphp

            {{ $dueCount }}
        </span>
    </a>

    <a style="border: 1px solid #c5bfbf" class="text-decoration-none btn  text-white-600 {{ Request::is('admin/taken-offer/refund-offer') ? 'btn-primary active-border' : '' }}"
        href="{{route('admin.taken_offer.refund.offer')}}">Refund
        <span class="badge rounded-pill text-gray-600 bg-light fw-normal">
            @php
            $cacheKey = $user_id == 2
            ? 'refund_count_taken_by_' . Auth::id()
            : 'refund_count_all';

            $refundCount = Cache::remember($cacheKey, now()->addHours(24), function () use ($user_id) {
            if ($user_id == 2) {
            return App\Models\JobApplication::where('payment_status', 'refund')
            ->where('taken_by_id', Auth::id())
            ->count();
            } else {
            return App\Models\JobApplication::where('payment_status', 'refund')->count();
            }
            });
            @endphp

            {{ $refundCount }}
        </span>
    </a>


</div>
