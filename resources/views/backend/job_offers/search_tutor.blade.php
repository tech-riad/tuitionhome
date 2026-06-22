

@extends('layouts.app')
@push('page_css')

@endpush


@section('content')


<main class="container-custom">

    <div class="col-md-9 ms-sm-auto col-lg-12" >
      <!-- main content section starts here -->
      <div class="py-lg-4 py-md-3 py-3 px-md-2 px-lg-5 mx-lg-5">
        <div class="px-lg-5">
          <div class="shadow-lg rounded-3 bg-white p-3 p-lg-5 mx-lg-5">
            <div
              class="d-flex justify-content-between align-items-start flex-column flex-lg-row align-items-lg-center"
            >
              <p class="text-nowrap">Search Tutors</p>
              <div class="d-flex gap-3">
                <button
                  class="btn btn-outline-primary py-1"
                  style="
                    box-shadow: 0px 4px 7px 0px rgba(59, 60, 61, 0.75);
                  "
                >
                  <p class="p-0 m-0">SMS Ranges</p>
                  <p class="p-0 m-0">5</p>
                </button>
                <button
                  class="btn btn-outline-info py-1"
                  style="
                    box-shadow: 0px 4px 7px 0px rgba(59, 60, 61, 0.75);
                  "
                >
                  <p class="p-0 m-0">SMS Send</p>
                  <p class="p-0 m-0">50</p>
                </button>
                <button class="btn btn-ndark" style="height: 52px">
                  Reset
                </button>
              </div>
            </div>
            <div class="mt-5">
              <select class="form-select shadow-none rounded-3">
                <option value="Latest Created Tutor">
                  Latest Created Tutor
                </option>
                <option value="2nd Latest Created Tutor">
                  2nd Latest Created Tutor
                </option>
                <option value="Random Tutor">Random Tutor</option>
                <option value="Bottom Tutor">Bottom Tutor</option>
                <option value="2nd Bottom Tutor">2nd Bottom Tutor</option>
              </select>
            </div>
            <!-- result box -->
            <div class="mt-4">
              <!-- Here gose the result box -->
            </div>
          </div>
          <div
            class="shadow-lg rounded-3 bg-white p-3 p-lg-5 mx-lg-5 mt-5"
          >
            <div
              class="d-flex justify-content-between align-items-start flex-column flex-lg-row align-items-lg-center"
            >
              <p class="text-nowrap">Search Tutors</p>
              <div class="d-flex gap-3">
                <button
                  class="btn btn-outline-primary py-1"
                  style="
                    box-shadow: 0px 4px 7px 0px rgba(59, 60, 61, 0.75);
                  "
                >
                  <p class="p-0 m-0">SMS Ranges</p>
                  <p class="p-0 m-0">5</p>
                </button>
                <button
                  class="btn btn-outline-info py-1"
                  style="
                    box-shadow: 0px 4px 7px 0px rgba(59, 60, 61, 0.75);
                  "
                >
                  <p class="p-0 m-0">SMS Send</p>
                  <p class="p-0 m-0">50</p>
                </button>
                <button class="btn btn-ndark" style="height: 52px">
                  Reset
                </button>
              </div>
            </div>
            <div class="mt-5">
              <select class="form-select shadow-none rounded-3">
                <option value="Latest Created Tutor">
                  Latest Created Tutor
                </option>
                <option value="2nd Latest Created Tutor">
                  2nd Latest Created Tutor
                </option>
                <option value="Random Tutor">Random Tutor</option>
                <option value="Bottom Tutor">Bottom Tutor</option>
                <option value="2nd Bottom Tutor">2nd Bottom Tutor</option>
              </select>
            </div>
            <!-- result box -->
            <div class="mt-4">
              <div
                class="d-flex justify-content-between align-items-center"
              >
                <p>Search Result 5 Tutors</p>
                <button class="btn btn-primary">Mark All</button>
              </div>
              <div>
                <div>
                  <div
                    class="d-flex justify-content-between align-items-start gap-3 gap-lg-0 align-items-lg-center border-bottom border-2 py-3"
                  >
                    <div class="">
                      <p class="text-info mb-0 fw-semibold">
                        Abdul Hatem<i class="bi bi-patch-check ms-1"></i
                        ><i class="bi bi-star-fill ms-1 text-warning"></i>
                      </p>
                      <p class="mb-0 text-muted">
                        Stamford University Bangladesh
                      </p>
                      <div class="d-flex gap-1">
                        <i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-gray-500"></i>
                      </div>
                    </div>
                    <p class="text-muted mb-0">Mirpur , Dhaka</p>
                    <p
                      class="rounded px-1 text-muted mb-0"
                      style="border: 2px solid #8a8f98"
                    >
                      100%
                    </p>

                    <div class="checkbox-wrapper-13">
                      <input id="c1-13" type="checkbox" />
                    </div>
                  </div>
                  <div
                    class="d-flex justify-content-between align-items-start gap-3 gap-lg-0 align-items-lg-center border-bottom border-2 py-3"
                  >
                    <div class="">
                      <p class="text-info mb-0 fw-semibold">
                        Abdul Kapa<i class="bi bi-patch-check ms-1"></i
                        ><i class="bi bi-star-fill ms-1 text-warning"></i>
                      </p>
                      <p class="mb-0 text-muted">
                        Stamford University Bangladesh
                      </p>
                      <div class="d-flex gap-1">
                        <i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-warning"></i>
                      </div>
                    </div>
                    <p class="text-muted mb-0">Mirpur , Dhaka</p>
                    <p
                      class="rounded px-1 text-muted mb-0"
                      style="border: 2px solid #8a8f98"
                    >
                      100%
                    </p>
                    <div class="checkbox-wrapper-13">
                      <input id="c1-13" type="checkbox" />
                    </div>
                  </div>
                  <div
                    class="d-flex justify-content-between align-items-start gap-3 gap-lg-0 align-items-lg-center border-bottom border-2 py-3"
                  >
                    <div class="">
                      <p class="text-info mb-0 fw-semibold">
                        Mulla Hatem<i class="bi bi-patch-check ms-1"></i
                        ><i class="bi bi-star-fill ms-1 text-warning"></i>
                      </p>
                      <p class="mb-0 text-muted">
                        Stamford University Bangladesh
                      </p>
                      <div class="d-flex gap-1">
                        <i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-gray-500"></i
                        ><i class="bi bi-star-fill text-gray-500"></i>
                      </div>
                    </div>
                    <p class="text-muted mb-0">Mirpur , Dhaka</p>
                    <p
                      class="rounded px-1 text-muted mb-0"
                      style="border: 2px solid #8a8f98"
                    >
                      100%
                    </p>
                    <div class="checkbox-wrapper-13">
                      <input id="c1-13" type="checkbox" />
                    </div>
                  </div>
                  <div
                    class="d-flex justify-content-between align-items-start gap-3 gap-lg-0 align-items-lg-center border-bottom border-2 py-3"
                  >
                    <div class="">
                      <p class="text-info mb-0 fw-semibold">
                        Abdul Hatem<i class="bi bi-patch-check ms-1"></i
                        ><i class="bi bi-star-fill ms-1 text-warning"></i>
                      </p>
                      <p class="mb-0 text-muted">
                        Stamford University Bangladesh
                      </p>
                      <div class="d-flex gap-1">
                        <i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-gray-500"></i>
                      </div>
                    </div>
                    <p class="text-muted mb-0">Mirpur , Dhaka</p>
                    <p
                      class="rounded px-1 text-muted mb-0"
                      style="border: 2px solid #8a8f98"
                    >
                      100%
                    </p>
                    <div class="checkbox-wrapper-13">
                      <input id="c1-13" type="checkbox" />
                    </div>
                  </div>
                  <div
                    class="d-flex justify-content-between align-items-start gap-3 gap-lg-0 align-items-lg-center border-bottom border-2 py-3"
                  >
                    <div class="">
                      <p class="text-info mb-0 fw-semibold">
                        Abdul Kapa<i class="bi bi-patch-check ms-1"></i
                        ><i class="bi bi-star-fill ms-1 text-warning"></i>
                      </p>
                      <p class="mb-0 text-muted">
                        Stamford University Bangladesh
                      </p>
                      <div class="d-flex gap-1">
                        <i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-warning"></i>
                      </div>
                    </div>
                    <p class="text-muted mb-0">Mirpur , Dhaka</p>
                    <p
                      class="rounded px-1 text-muted mb-0"
                      style="border: 2px solid #8a8f98"
                    >
                      100%
                    </p>
                    <div class="checkbox-wrapper-13">
                      <input id="c1-13" type="checkbox" />
                    </div>
                  </div>
                  <div
                    class="d-flex justify-content-between align-items-start gap-3 gap-lg-0 align-items-lg-center border-bottom border-2 py-3"
                  >
                    <div class="">
                      <p class="text-info mb-0 fw-semibold">
                        Mulla Hatem<i class="bi bi-patch-check ms-1"></i
                        ><i class="bi bi-star-fill ms-1 text-warning"></i>
                      </p>
                      <p class="mb-0 text-muted">
                        Stamford University Bangladesh
                      </p>
                      <div class="d-flex gap-1">
                        <i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-warning"></i
                        ><i class="bi bi-star-fill text-gray-500"></i
                        ><i class="bi bi-star-fill text-gray-500"></i>
                      </div>
                    </div>
                    <p class="text-muted mb-0">Mirpur , Dhaka</p>
                    <p
                      class="rounded px-1 text-muted mb-0"
                      style="border: 2px solid #8a8f98"
                    >
                      100%
                    </p>
                    <div class="checkbox-wrapper-13">
                      <input id="c1-13" type="checkbox" />
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="d-flex justify-content-between align-items-center mt-4"
              >
                <button class="btn btn-primary">Send SMS</button>
                <button class="btn btn-danger border shadow-lg">
                  Clear
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- main content section ends here -->
    </div>
  </main>


@endsection

@push('page_scripts')


@endpush