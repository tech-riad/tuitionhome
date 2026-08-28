@if ($partners->hasPages())

    <div class="d-flex justify-content-center align-items-center gap-2 mt-3">

        {{-- Previous --}}
        @if ($partners->onFirstPage())

            <button type="button"
                class="btn btn-outline-gdark py-1 px-2 text-gray-800"
                disabled>

                <i class="bi bi-chevron-left"></i>

            </button>

        @else

            <a href="{{ $partners->previousPageUrl() }}"
                class="btn btn-outline-gdark py-1 px-2 text-gray-800 pagination-link">

                <i class="bi bi-chevron-left"></i>

            </a>

        @endif


        {{-- Pages --}}
        @foreach ($partners->getUrlRange(1, $partners->lastPage()) as $page => $url)

            @if (
                $page == 1 ||
                $page == $partners->lastPage() ||
                abs($page - $partners->currentPage()) <= 1
            )

                @if ($page == $partners->currentPage())

                    <button type="button"
                        class="btn btn-outline-gdark py-1 text-white bg-dark"
                        style="padding: 0 13px;">

                        {{ $page }}

                    </button>

                @else

                    <a href="{{ $url }}"
                        class="btn btn-outline-gdark py-1 text-gray-800 pagination-link"
                        style="padding: 0 13px;">

                        {{ $page }}

                    </a>

                @endif

            @elseif (
                $page == 2 && $partners->currentPage() > 3
            )

                <span
                    class="btn btn-outline-gdark py-1 text-gray-800"
                    style="padding: 0 13px;">

                    ..

                </span>

            @elseif (
                $page == $partners->lastPage() - 1 &&
                $partners->currentPage() < $partners->lastPage() - 2
            )

                <span
                    class="btn btn-outline-gdark py-1 text-gray-800"
                    style="padding: 0 13px;">

                    ..

                </span>

            @endif

        @endforeach


        {{-- Next --}}
        @if ($partners->hasMorePages())

            <a href="{{ $partners->nextPageUrl() }}"
                class="btn btn-outline-gdark py-1 px-2 text-gray-800 pagination-link">

                <i class="bi bi-chevron-right"></i>

            </a>

        @else

            <button type="button"
                class="btn btn-outline-gdark py-1 px-2 text-gray-800"
                disabled>

                <i class="bi bi-chevron-right"></i>

            </button>

        @endif

    </div>

@endif