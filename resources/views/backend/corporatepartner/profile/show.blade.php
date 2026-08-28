<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/assets/fav.png" />
    {{-- <link rel="stylesheet" href="/css/bootstrap.min.css" /> --}}
    <link rel="stylesheet" href="{{ asset('backend/file/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/file/css/color_palets.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/file/css/style.css') }}" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
      integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="{{ asset('/assets/style.css') }}" />
    <title>Admin - Affiliate</title>
  </head>
  <body>
    <!-- navbar starts here -->
    <nav
      class="navbar navbar-expand-lg bg-white shadow-lg fixed-top"
      data-bs-theme="dark"
    >
      <div class="container-fluid">
        <a href="/index.html"><img src="/images/logo.svg" alt="logo" /></a>
        <button
          class="navbar-toggler d-md-none collapsed"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#sidebarMenu"
          aria-controls="navbarColor02"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <i class="bi bi-caret-down-fill"></i>
        </button>
      </div>
    </nav>
    <!-- navbar ends here -->

    <div class="container-fluid">
      <div class="row">
        <!-- sidebar starts here -->
        <nav
          id="sidebarMenu"
          class="col-md-3 col-lg-2 d-md-block bg-white sidebar collapse sidebar-width shadow-lg"
          style="height: 100vh; margin-top: 60px; position: fixed"
        >
          <div
            class="d-flex justify-content-center align-items-center flex-column border-bottom mt-2 pb-3"
          >
            <div class="mb-2">
              <img
                src="/images/boy.jpg"
                alt="image"
                class="profile-img"
                style="
                  width: 80px;
                  height: 90px;
                  object-fit: cover;
                  margin-top: 16px;
                "
              />
            </div>
            <h5 class="text-gray-800 mt-3">Super Admin</h5>
          </div>
          <div style="overflow-y: auto; height: 65vh" class="scrollbar-none">
            <ul class="list-unstyled px-3 mt-2">
              <li class="mb-3">
                <div class="d-flex align-items-center">
                  <i class="bi bi-credit-card fs-5 me-4"></i>
                  <div class="d-flex w-100 justify-content-between">
                    <a
                      class="text-decoration-none text-gray-800 align-items-center collapsed"
                      data-bs-toggle="collapse"
                      data-bs-target="#offer-collapse"
                      aria-expanded="false"
                      style="cursor: pointer"
                    >
                      Affiliate
                    </a>
                    <i class="bi bi-chevron-left arrow-icon"></i>
                  </div>
                </div>

                <div class="collapse show" id="offer-collapse">
                  <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li
                      class="ms-4 px-3 py-1 my-3"
                      style="border-left: 3px solid #898e99"
                    >
                      <a
                        href="/index.html"
                        class="text-gray-800 text-decoration-none"
                        >Affiliate Request</a
                      >
                    </li>
                    <li
                      class="ms-4 px-3 py-1 my-3"
                      style="border-left: 3px solid #89c33f"
                    >
                      <a
                        href="/affiliate-profile.html"
                        class="text-primary text-decoration-none text-nowrap"
                        >Affiliate Profile</a
                      >
                    </li>
                    <li
                      class="ms-4 px-3 py-1 my-3"
                      style="border-left: 3px solid #898e99"
                    >
                      <a
                        href="/affiliate-transaction.html"
                        class="text-gray-800 text-decoration-none text-nowrap"
                        >Affiliate Transaction</a
                      >
                    </li>
                    <li
                      class="ms-4 px-3 py-1 my-3"
                      style="border-left: 3px solid #898e99"
                    >
                      <a
                        href="/setting.html"
                        class="text-gray-800 text-decoration-none"
                        >Setting</a
                      >
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </nav>
        <!-- sidebar ends here -->
        <main class="container-custom">
          <div class="col-md-9 ms-sm-auto col-lg-10" style="margin-top: 62px">
            <!-- mini nav starts here -->
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-flex gap-4 flex-column flex-md-row px-3 py-4">
                <a
                  class="text-decoration-none text-gray-800 text-nowrap"
                  href="index.html"
                  >Affiliate Request</a
                >
                <a
                  class="text-decoration-none text-gray-800 text-nowrap active-border"
                  href="affiliate-profile.html"
                  >Affiliate Profile</a
                >
                <a
                  class="text-decoration-none text-gray-800 text-nowrap"
                  href="affiliate-transaction.html"
                  >Affiliate Transactions</a
                >
                <a
                  class="text-decoration-none text-gray-800"
                  href="setting.html"
                  >Setting</a
                >
              </div>
              <button
                class="btn btn-info mx-3 py-2 text-nowrap"
                data-bs-toggle="modal"
                data-bs-target="#addProfileModal"
                style="background: #3378c2"
              >
                Add profile
              </button>
            </div>
            <!-- mini nav ends here -->
            <!-- main content section starts here -->
            <!-- header cards starts here -->
            <div class="row gap-4 gap-md-0 ms-1 me-1 mb-4">
              <div class="col-12">
                <div class="bg-white shadow-lg rounded-3 p-4">
                  <p class="text-center fw-bold fs-5 mb-1">675</p>
                  <p class="text-center mb-0">Active Profile</p>
                </div>
              </div>
            </div>
            <div
              class="row row-cols-1 gap-4 row-cols-md-2 row-cols-lg-4 gap-md-0 ms-1 me-1"
            >
              <div class="mb-md-4 mb-lg-0">
                <div class="bg-white shadow-lg rounded-3 p-4">
                  <p class="text-center fw-bold fs-5 mb-1">210</p>
                  <p class="text-center mb-0">Inactive Profile</p>
                </div>
              </div>
              <div class="mb-md-4 mb-lg-0">
                <div class="bg-white shadow-lg rounded-3 p-4">
                  <p class="text-center fw-bold fs-5 mb-1">305</p>
                  <p class="text-center mb-0 text-nowrap">Tutor Profile</p>
                </div>
              </div>
              <div class="">
                <div class="bg-white shadow-lg rounded-3 p-4">
                  <p class="text-center fw-bold fs-5 mb-1">255</p>
                  <p class="text-center mb-0">Male Profile</p>
                </div>
              </div>
              <div class="">
                <div class="bg-white shadow-lg rounded-3 p-4">
                  <p class="text-center fw-bold fs-5 mb-1">199</p>
                  <p class="text-center mb-0">Female Profile</p>
                </div>
              </div>
            </div>
            <!-- header cards ends here -->
            <!-- table starts here -->
            <div class="ps-3 mt-4" style="padding-right: 13px">
              <div
                class="d-flex flex-wrap flex-xl-nowrap justify-content-between flex-column flex-lg-row gap-2 gap-lg-0"
              >
                <div class="d-flex justify-content-between gap-3 mb-3 mb-xl-0">
                  <button
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#filterModal"
                  >
                    <i class="bi bi-sliders2 me-1"></i>Filter
                  </button>
                  <button class="btn btn-outline-ndark">Send Bulk SMS</button>
                  <a
                    href="/affiliate-profile-inactive.html"
                    class="btn btn-warning grayed"
                    >Inactive Profile</a
                  >
                </div>
                <div class="d-flex flex-wrap flex-md-nowrap gap-3">
                  <input
                    type="text"
                    class="form-control rounded"
                    placeholder="Search"
                  />
                  <select class="form-select rounded" style="width: 100px">
                    <option selected value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="300">300</option>
                    <option value="500">500</option>
                  </select>
                </div>
              </div>
              <div class="bg-white shadow-lg rounded-3 p-2 my-4">
                <div class="bg-white pb-4 mb-b">
                  <div class="table-responsive">
                    <table
                      class="table table-sm table-hover bg-white shadow-none"
                      style="border-collapse: collapse"
                    >
                      <thead
                        class="text-dark"
                        style="border-bottom: 1px solid #c8ced3"
                      >
                        <tr>
                          <th scope="col" class="text-nowrap">
                            <input
                              class="form-check-input ms-3"
                              type="checkbox"
                              value=""
                              id="flexCheckDefault"
                              style="margin-right: 12px"
                            />#SL
                          </th>
                          <th scope="col" class="text-nowrap">Date</th>
                          <th scope="col" class="text-nowrap">Affiliate ID</th>
                          <th scope="col" class="text-nowrap">Tutor ID</th>

                          <th scope="col" class="text-nowrap">Name</th>
                          <th scope="col" class="text-nowrap">Phone</th>
                          <th scope="col" class="text-nowrap">Location</th>
                          <th scope="col" class="text-nowrap">Gender</th>
                          <th scope="col" class="text-nowrap">Channel</th>
                          <th scope="col" class="text-nowrap">Action By</th>
                          <th scope="col" class="text-nowrap">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="align-middle">
                          <td
                            scope="row "
                            class="text-center text-nowrap"
                            style="padding: 30px 18px"
                          >
                            <input
                              class="form-check-input me-2"
                              type="checkbox"
                              value=""
                              id="flexCheckDefault"
                            />

                            005
                          </td>
                          <td class="">
                            <a
                              type="button"
                              class="text-decoration-none text-gray-800 text-nowrap"
                              data-bs-toggle="modal"
                              data-bs-target="#showDateTimeModal"
                            >
                              11-06-23
                            </a>
                          </td>
                          <td class="text-info">
                            <a
                              href="/log-files/view/aboutme.html"
                              class="text-decoration-none text-info"
                              >RA00593</a
                            >
                            <div style="display: inline-block">
                              <img
                                src="/images/yollow-star-mark.svg"
                                alt="yollow-star-mark"
                              />
                              <img
                                src="/images/green-mark.svg"
                                alt="green-mark"
                              />
                              <img
                                src="/images/blue-tick-mark.svg"
                                alt="blue-tick"
                              />
                            </div>
                          </td>
                          <td class="text-info">A000593</td>
                          <td class="text-nowrap">Jubaer Hoss...</td>
                          <td>01775859569</td>
                          <td>Mirpur-1, Dha...</td>
                          <td>Male</td>
                          <td>Tutor Request</td>
                          <td class="">
                            <button
                              type="button"
                              class="btn btn-outline-primary px-2 py-1 text-dark"
                              data-bs-toggle="modal"
                              data-bs-target="#viewModal"
                            >
                              <i class="bi bi-eye-fill"></i>
                              View
                            </button>
                          </td>

                          <td class="">
                            <div class="d-flex gap-2">
                              <div class="dropdown">
                                <button
                                  class="btn shadow-none py-1 px-2"
                                  type="button"
                                  data-bs-toggle="dropdown"
                                  aria-expanded="false"
                                >
                                  <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul
                                  class="dropdown-menu"
                                  style="border: 1px solid #d7dfe9"
                                >
                                  <li>
                                    <a class="dropdown-item" href="#"
                                      >Super Lead Hunter</a
                                    >
                                  </li>
                                  <li>
                                    <a class="dropdown-item" href="#"
                                      >Average Lead Hunter</a
                                    >
                                  </li>
                                  <li>
                                    <a class="dropdown-item" href="#"
                                      >Make Verify</a
                                    >
                                  </li>
                                  <li>
                                    <a class="dropdown-item" href="#"
                                      >Deactive</a
                                    >
                                  </li>
                                  <li>
                                    <a
                                      class="dropdown-item"
                                      data-bs-toggle="modal"
                                      data-bs-target="#noteModal"
                                      href="#"
                                      >Note</a
                                    >
                                  </li>
                                  <li>
                                    <a
                                      class="dropdown-item"
                                      data-bs-toggle="modal"
                                      data-bs-target="#createNoteModal"
                                      href="#"
                                      >Create a Note</a
                                    >
                                  </li>
                                  <li>
                                    <a
                                      class="dropdown-item"
                                      data-bs-toggle="modal"
                                      data-bs-target="#logModal"
                                      href="#"
                                      >Log</a
                                    >
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr class="align-middle">
                          <td
                            scope="row "
                            class="text-center text-nowrap"
                            style="padding: 30px 18px"
                          >
                            <input
                              class="form-check-input me-2"
                              type="checkbox"
                              value=""
                              id="flexCheckDefault"
                            />

                            002
                          </td>
                          <td class="">
                            <a
                              type="button"
                              class="text-decoration-none text-gray-800 text-nowrap"
                              data-bs-toggle="modal"
                              data-bs-target="#showDateTimeModal"
                            >
                              08-06-23
                            </a>
                          </td>
                          <td class="text-info">
                            <a
                              href="/log-files/view/aboutme.html"
                              class="text-decoration-none text-info"
                              >RA00593</a
                            >
                            <div style="display: inline-block">
                              <img
                                src="/images/yollow-star-mark.svg"
                                alt="yollow-star-mark"
                              />
                              <img
                                src="/images/green-mark.svg"
                                alt="green-mark"
                              />
                              <img
                                src="/images/blue-tick-mark.svg"
                                alt="blue-tick"
                              />
                            </div>
                          </td>
                          <td class="">Null</td>
                          <td class="text-nowrap">Jubaer Hoss...</td>
                          <td>01775859569</td>
                          <td>Mirpur-1, Dha...</td>
                          <td>Male</td>
                          <td>Web</td>
                          <td class="">
                            <button
                              type="button"
                              class="btn btn-outline-primary px-2 py-1 text-dark"
                              data-bs-toggle="modal"
                              data-bs-target="#viewModal"
                            >
                              <i class="bi bi-eye-fill"></i>
                              View
                            </button>
                          </td>

                          <td class="">
                            <div class="d-flex gap-2">
                              <div class="dropdown">
                                <button
                                  class="btn shadow-none py-1 px-2"
                                  type="button"
                                  data-bs-toggle="dropdown"
                                  aria-expanded="false"
                                >
                                  <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul
                                  class="dropdown-menu"
                                  style="border: 1px solid #d7dfe9"
                                >
                                  <li>
                                    <a class="dropdown-item" href="#"
                                      >Super Lead Hunter</a
                                    >
                                  </li>
                                  <li>
                                    <a class="dropdown-item" href="#"
                                      >Average Lead Hunter</a
                                    >
                                  </li>
                                  <li>
                                    <a class="dropdown-item" href="#"
                                      >Make Verify</a
                                    >
                                  </li>
                                  <li>
                                    <a class="dropdown-item" href="#"
                                      >Deactive</a
                                    >
                                  </li>
                                  <li>
                                    <a
                                      class="dropdown-item"
                                      data-bs-toggle="modal"
                                      data-bs-target="#noteModal"
                                      href="#"
                                      >Note</a
                                    >
                                  </li>
                                  <li>
                                    <a
                                      class="dropdown-item"
                                      data-bs-toggle="modal"
                                      data-bs-target="#createNoteModal"
                                      href="#"
                                      >Create a Note</a
                                    >
                                  </li>
                                  <li>
                                    <a
                                      class="dropdown-item"
                                      data-bs-toggle="modal"
                                      data-bs-target="#logModal"
                                      href="#"
                                      >Log</a
                                    >
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr class="align-middle">
                          <td
                            scope="row "
                            class="text-center text-nowrap"
                            style="padding: 30px 18px"
                          >
                            <input
                              class="form-check-input me-2"
                              type="checkbox"
                              value=""
                              id="flexCheckDefault"
                            />

                            003
                          </td>
                          <td class="">
                            <a
                              type="button"
                              class="text-decoration-none text-gray-800 text-nowrap"
                              data-bs-toggle="modal"
                              data-bs-target="#showDateTimeModal"
                            >
                              09-06-23
                            </a>
                          </td>
                          <td class="text-info">
                            <a
                              href="/log-files/view/aboutme.html"
                              class="text-decoration-none text-info"
                              >RA00593</a
                            >
                            <div style="display: inline-block">
                              <img
                                src="/images/yollow-star-mark.svg"
                                alt="yollow-star-mark"
                              />
                              <img
                                src="/images/green-mark.svg"
                                alt="green-mark"
                              />
                              <img
                                src="/images/blue-tick-mark.svg"
                                alt="blue-tick"
                              />
                            </div>
                          </td>
                          <td class="text-info">A000593</td>
                          <td class="text-nowrap">Jubaer Hoss...</td>
                          <td>01775859569</td>
                          <td>Mirpur-1, Dha...</td>
                          <td>Male</td>
                          <td>App</td>
                          <td class="">
                            <button
                              type="button"
                              class="btn btn-outline-primary px-2 py-1 text-dark"
                              data-bs-toggle="modal"
                              data-bs-target="#viewModal"
                            >
                              <i class="bi bi-eye-fill"></i>
                              View
                            </button>
                          </td>

                          <td class="">
                            <div class="d-flex gap-2">
                              <div class="dropdown">
                                <button
                                  class="btn shadow-none py-1 px-2"
                                  type="button"
                                  data-bs-toggle="dropdown"
                                  aria-expanded="false"
                                >
                                  <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul
                                  class="dropdown-menu"
                                  style="border: 1px solid #d7dfe9"
                                >
                                  <li>
                                    <a class="dropdown-item" href="#"
                                      >Super Lead Hunter</a
                                    >
                                  </li>
                                  <li>
                                    <a class="dropdown-item" href="#"
                                      >Average Lead Hunter</a
                                    >
                                  </li>
                                  <li>
                                    <a class="dropdown-item" href="#"
                                      >Make Verify</a
                                    >
                                  </li>
                                  <li>
                                    <a class="dropdown-item" href="#"
                                      >Deactive</a
                                    >
                                  </li>
                                  <li>
                                    <a
                                      class="dropdown-item"
                                      data-bs-toggle="modal"
                                      data-bs-target="#noteModal"
                                      href="#"
                                      >Note</a
                                    >
                                  </li>
                                  <li>
                                    <a
                                      class="dropdown-item"
                                      data-bs-toggle="modal"
                                      data-bs-target="#createNoteModal"
                                      href="#"
                                      >Create a Note</a
                                    >
                                  </li>
                                  <li>
                                    <a
                                      class="dropdown-item"
                                      data-bs-toggle="modal"
                                      data-bs-target="#logModal"
                                      href="#"
                                      >Log</a
                                    >
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr class="align-middle">
                          <td
                            scope="row "
                            class="text-center text-nowrap"
                            style="padding: 30px 18px"
                          >
                            <input
                              class="form-check-input me-2"
                              type="checkbox"
                              value=""
                              id="flexCheckDefault"
                            />

                            004
                          </td>
                          <td class="">
                            <a
                              type="button"
                              class="text-decoration-none text-gray-800 text-nowrap"
                              data-bs-toggle="modal"
                              data-bs-target="#showDateTimeModal"
                            >
                              10-06-23
                            </a>
                          </td>
                          <td class="text-info">
                            <a
                              href="/log-files/view/aboutme.html"
                              class="text-decoration-none text-info"
                              >RA00593</a
                            >
                            <div style="display: inline-block">
                              <img
                                src="/images/yollow-star-mark.svg"
                                alt="yollow-star-mark"
                              />
                              <img
                                src="/images/green-mark.svg"
                                alt="green-mark"
                              />
                              <img
                                src="/images/blue-tick-mark.svg"
                                alt="blue-tick"
                              />
                            </div>
                          </td>
                          <td class="text-info">A000593</td>
                          <td class="text-nowrap">Jubaer Hoss...</td>
                          <td>01775859569</td>
                          <td>Mirpur-1, Dha...</td>
                          <td>Male</td>
                          <td>Admin(Saji...</td>
                          <td class="">
                            <button
                              type="button"
                              class="btn btn-outline-primary px-2 py-1 text-dark"
                              data-bs-toggle="modal"
                              data-bs-target="#viewModal"
                            >
                              <i class="bi bi-eye-fill"></i>
                              View
                            </button>
                          </td>

                          <td class="">
                            <div class="d-flex gap-2">
                              <div class="dropdown">
                                <button
                                  class="btn shadow-none py-1 px-2"
                                  type="button"
                                  data-bs-toggle="dropdown"
                                  aria-expanded="false"
                                >
                                  <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul
                                  class="dropdown-menu"
                                  style="border: 1px solid #d7dfe9"
                                >
                                  <li>
                                    <a class="dropdown-item" href="#"
                                      >Super Lead Hunter</a
                                    >
                                  </li>
                                  <li>
                                    <a class="dropdown-item" href="#"
                                      >Average Lead Hunter</a
                                    >
                                  </li>
                                  <li>
                                    <a class="dropdown-item" href="#"
                                      >Make Verify</a
                                    >
                                  </li>
                                  <li>
                                    <a class="dropdown-item" href="#"
                                      >Deactive</a
                                    >
                                  </li>
                                  <li>
                                    <a
                                      class="dropdown-item"
                                      data-bs-toggle="modal"
                                      data-bs-target="#noteModal"
                                      href="#"
                                      >Note</a
                                    >
                                  </li>
                                  <li>
                                    <a
                                      class="dropdown-item"
                                      data-bs-toggle="modal"
                                      data-bs-target="#createNoteModal"
                                      href="#"
                                      >Create a Note</a
                                    >
                                  </li>
                                  <li>
                                    <a
                                      class="dropdown-item"
                                      data-bs-toggle="modal"
                                      data-bs-target="#logModal"
                                      href="#"
                                      >Log</a
                                    >
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!-- pagination starts here -->
                  <div
                    class="d-flex justify-content-center align-items-center gap-2 mt-3"
                  >
                    <button
                      class="btn btn-outline-gdark py-1 px-2 text-gray-800"
                    >
                      <i class="bi bi-chevron-left"></i>
                    </button>
                    <button
                      class="btn btn-outline-gdark py-1 text-gray-800"
                      style="padding: 0 13px"
                    >
                      1
                    </button>

                    <button
                      class="btn btn-outline-gdark py-1 text-gray-800"
                      style="padding: 0 13px"
                    >
                      2
                    </button>
                    <button
                      class="btn btn-outline-gdark py-1 text-gray-800"
                      style="padding: 0 13px"
                    >
                      ..
                    </button>

                    <button
                      class="btn btn-outline-gdark py-1 text-gray-800"
                      style="padding: 0 13px"
                    >
                      34
                    </button>

                    <button
                      class="btn btn-outline-gdark py-1 px-2 text-gray-800"
                    >
                      <i class="bi bi-chevron-right"></i>
                    </button>
                  </div>
                  <!-- pagination ends here -->
                </div>
              </div>
            </div>
            <!-- table ends here -->
            <!-- Show Date time model starts here-->
            <div
              class="modal fade"
              id="showDateTimeModal"
              tabindex="-1"
              aria-labelledby="showDateTimeModalLabel"
              aria-hidden="true"
            >
              <div
                class="modal-dialog model-sm modal-dialog-slide-top"
                style="max-width: 400px"
              >
                <div class="modal-content">
                  <div class="modal-body pt-5 pb-4">
                    <p class="text-center text-info fs-3">7 June 2023</p>
                    <p class="text-center text-gray-700 border-top fs-1 pt-1">
                      03:30 PM
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <!-- Show Date time model ends here-->

            <!-- view model starts here-->
            <div
              class="modal fade"
              id="viewModal"
              tabindex="-1"
              aria-labelledby="idInfoModalLabel"
              aria-hidden="true"
            >
              <div
                class="modal-dialog model-sm modal-dialog-slide-left"
                style="max-width: 400px"
              >
                <div class="modal-content">
                  <div class="modal-body pt-2 pb-4 px-5">
                    <div
                      class="row row-cols-2 mt-3 border-bottom border-2 pb-3 align-items-center"
                    >
                      <p class="fw-semibold mb-0">SLH</p>
                      <div>
                        <p class="mb-0">Sajid HDY</p>
                        <small>04-04-23</small>
                      </div>
                    </div>
                    <div
                      class="row row-cols-2 border-bottom border-2 py-3 align-items-center"
                    >
                      <p class="fw-semibold mb-0">ALH</p>
                      <div>
                        <p class="mb-0">Saikat Ullah</p>
                        <small>09-04-23</small>
                      </div>
                    </div>
                    <div
                      class="row row-cols-2 border-bottom border-2 py-3 align-items-center"
                    >
                      <p class="fw-semibold mb-0">Verifyed By</p>
                      <div>
                        <p class="mb-0">Afnun Polash</p>
                        <small>08-04-23</small>
                      </div>
                    </div>
                    <div class="row row-cols-2 pt-3 align-items-center">
                      <p class="fw-semibold mb-0">Deactived By</p>
                      <div>
                        <p class="mb-0">Robel Hossen</p>
                        <small>07-04-23</small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Note model starts here-->
            <div
              class="modal fade"
              id="noteModal"
              tabindex="-1"
              aria-labelledby="noteModalLabel"
              aria-hidden="true"
            >
              <div
                class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
              >
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel5">
                      Note Details
                    </h5>
                  </div>
                  <div class="modal-body">
                    <div>
                      <div
                        class="p-3 bg-light rounded-3 border border-1 border-dark mb-3"
                      >
                        <div
                          class="d-flex justify-content-between align-items-center"
                        >
                          <div>
                            <p class="mb-0 text-dark fs-5">Fahmida Tayba</p>
                            <p class="text-info" style="font-size: 12px">
                              ID-34582
                            </p>
                          </div>
                          <div><p>Nov 14, 2023</p></div>
                        </div>
                        <div>
                          <p class="" style="font-size: 16px; color: #3b3c3d">
                            Note Title
                          </p>
                          <p>
                            doloremque dolorem dolor, delectus repellendus
                            expedita modi distinctio voluptate voluptas impedit.
                            Corrupti est expedita non qui accusamus illum quam,
                            cum cumque saepe excepturi rem.
                          </p>
                        </div>
                        <div
                          class="d-flex justify-content-between align-items-center"
                        >
                          <div>
                            <p style="font-size: 16px; color: #3b3c3d">
                              Read More
                            </p>
                          </div>
                          <div>
                            <button class="btn btn-primary py-1">Edit</button>
                          </div>
                        </div>
                      </div>
                      <div
                        class="p-3 bg-light rounded-3 border border-1 border-dark mb-3"
                      >
                        <div
                          class="d-flex justify-content-between align-items-center"
                        >
                          <div>
                            <p class="mb-0 fs-5">Sajid HDY</p>
                            <p class="text-info" style="font-size: 12px">
                              ID-31934
                            </p>
                          </div>
                          <div><p>Nov 29, 2023</p></div>
                        </div>
                        <div>
                          <p class="text-gay-900" style="font-size: 16px">
                            Note Title
                          </p>
                          <p>
                            doloremque dolorem dolor, delectus repellendus
                            expedita modi distinctio voluptate voluptas impedit.
                            Corrupti est expedita non qui accusamus illum quam,
                            cum cumque saepe excepturi rem.
                          </p>
                        </div>
                        <div
                          class="d-flex justify-content-between align-items-center"
                        >
                          <div>
                            <p>Read More</p>
                          </div>
                          <div>
                            <button class="btn btn-primary py-1">Edit</button>
                          </div>
                        </div>
                      </div>
                      <div
                        class="p-3 bg-light rounded-3 border border-1 border-dark mb-3"
                      >
                        <div
                          class="d-flex justify-content-between align-items-center"
                        >
                          <div>
                            <p class="mb-0 text-dark fs-5">Fahmida Tayba</p>
                            <p class="text-info" style="font-size: 12px">
                              ID-34582
                            </p>
                          </div>
                          <div><p>Nov 30, 2023</p></div>
                        </div>
                        <div>
                          <p class="" style="font-size: 16px; color: #3b3c3d">
                            Note Title
                          </p>
                          <p>
                            doloremque dolorem dolor, delectus repellendus
                            expedita modi distinctio voluptate voluptas impedit.
                            Corrupti est expedita non qui accusamus illum quam,
                            cum cumque saepe excepturi rem.
                          </p>
                        </div>
                        <div
                          class="d-flex justify-content-between align-items-center"
                        >
                          <div>
                            <p>Read More</p>
                          </div>
                          <div>
                            <button class="btn btn-warning py-1">Edited</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <div class="py-2"></div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Note model ends here-->

            <!-- Create Note model starts here-->
            <div
              class="modal fade"
              id="createNoteModal"
              tabindex="-1"
              aria-labelledby="createNoteModalLabel"
              aria-hidden="true"
            >
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-3">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel6">
                      Make A Note
                    </h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"
                    ></button>
                  </div>
                  <div class="modal-body">
                    <form action="">
                      <div class="mb-3">
                        <label
                          for="exampleFormControlInput1"
                          class="form-label text-dark"
                          >Note Title</label
                        >
                        <input
                          type="text"
                          class="form-control shadow-none rounded-3"
                          id="exampleFormControlInput1"
                          placeholder="Maximum 8 words can be given "
                        />
                      </div>
                      <div>
                        <label
                          for="exampleFormControlTextarea1"
                          class="form-label text-dark"
                          >Note Details</label
                        >
                        <textarea
                          class="form-control shadow-none rounded-3"
                          id="exampleFormControlTextarea1"
                          rows="3"
                          placeholder="Maximum 30 words can be given"
                        ></textarea>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button
                      type="button"
                      class="btn btn-gdark shadow-lg"
                      data-bs-dismiss="modal"
                    >
                      Close
                    </button>
                    <button type="button" class="btn btn-primary">Save</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Create Note model ends here-->
            <!-- Log model starts here -->
            <div
              class="modal fade"
              id="logModal"
              tabindex="-1"
              aria-labelledby="logModalLabel"
              aria-hidden="true"
            >
              <div
                class="modal-dialog modal-dialog-centered"
                style="max-width: 900px"
              >
                <div class="modal-content mx-4">
                  <div class="modal-body p-0">
                    <table class="table shadow-none">
                      <thead
                        class="text-white"
                        style="background-color: #3378c2"
                      >
                        <tr class="">
                          <th
                            scope="col"
                            class="border-end border-1"
                            style="border-top-left-radius: 8px"
                          >
                            Name
                          </th>
                          <th
                            scope="col"
                            class="text-nowrap border-end border-1"
                          >
                            Em ID
                          </th>
                          <th scope="col" class="border-end border-1">Date</th>
                          <th
                            scope="col"
                            class="text-nowrap"
                            style="border-top-right-radius: 8px"
                          >
                            Note Before Edit
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="" style="vertical-align: middle">
                          <th
                            scope="row"
                            class="text-nowrap border-end border-1"
                          >
                            Fahmida Tayba
                          </th>
                          <td class="text-info border-end border-1">56123</td>
                          <td class="text-nowrap border-end border-1">
                            <p class="mb-0">14-07-2023</p>
                            <p class="mb-0 text-muted">47: 15: 12 PM</p>
                          </td>
                          <td>
                            <p class="border border-info p-2 rounded-3">
                              Lorem ipsum dolor sit amet consectetur adipisicing
                              elit. Reprehenderit molestias magnam doloribus
                              impedit sunt ducimus inventore voluptas numquam
                              eum ad corporis aperiam harum quo, explicabo
                              officiis suscipit, reiciendis architecto veniam
                              amet sequi, facere placeat illo veritatis.
                              Dignissimos eius quibusdam tempora!
                            </p>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- Log model ends here -->
            <!-- Filter model starts here -->
            <div
              class="modal fade font-pop"
              id="filterModal"
              tabindex="-1"
              aria-labelledby="filterModalLabel"
              aria-hidden="true"
            >
              <div
                class="modal-dialog modal-dialog-slide-right"
                style="max-width: 900px"
              >
                <div class="modal-content pb-4 pt-3">
                  <div
                    class="modal-header"
                    style="padding-left: 40px; padding-right: 40px"
                  >
                    <h4 class="modal-title" id="exampleModalLabel">Filter</h4>

                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"
                    ></button>
                  </div>
                  <div class="modal-body py-0" style="padding-left: 40px">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                      <div class="d-flex align-items-center">
                        <div class="flex-grow-1 pe-4">
                          <div class="pb-3">
                            <label
                              for="datef"
                              class="form-label text-dark text-sm"
                              >Date from</label
                            >
                            <div class="">
                              <input
                                type="date"
                                class="form-control shadow rounded-3"
                                id="datef"
                              />
                            </div>
                          </div>
                          <div class="pb-3">
                            <label
                              for="datet"
                              class="form-label text-dark text-sm"
                              >Date To</label
                            >
                            <input
                              type="date"
                              class="form-control shadow rounded-3"
                              id="datet"
                            />
                          </div>
                          <div class="pb-3">
                            <label
                              for="Status"
                              class="form-label text-dark text-sm"
                              >Verify Status</label
                            >

                            <select
                              id="Status"
                              class="shadow rounded-3 form-select"
                              aria-label="Default select example"
                            >
                              <option selected value="Verified">
                                Verified
                              </option>
                              <option value="Option 1">Option 1</option>
                              <option value="Option 2">Option 2</option>
                              <option value="Option 3">Option 3</option>
                              <option value="Option 4">Option 4</option>
                            </select>
                          </div>
                        </div>
                        <div
                          class="border-end mt-3"
                          style="height: 210px"
                        ></div>
                      </div>
                      <div class="d-flex align-items-center">
                        <div class="flex-grow-1 pe-4">
                          <div class="pb-3">
                            <label
                              for="cntry"
                              class="form-label text-dark text-sm"
                              >Country</label
                            >

                            <select
                              id="cntry"
                              class="shadow rounded-3 form-select"
                              aria-label="Default select example"
                            >
                              <option selected value="bangladesh">
                                Bangladesh
                              </option>
                              <option value="Option 1">Option 1</option>
                              <option value="Option 2">Option 2</option>
                              <option value="Option 3">Option 3</option>
                              <option value="Option 4">Option 4</option>
                            </select>
                          </div>
                          <div class="pb-3">
                            <label
                              for="cty"
                              class="form-label text-dark text-sm"
                              >City</label
                            >

                            <select
                              id="cty"
                              class="shadow rounded-3 form-select"
                              aria-label="Default select example"
                            >
                              <option selected value="dhaka">Dhaka</option>
                              <option value="Option 1">Option 1</option>
                              <option value="Option 2">Option 2</option>
                              <option value="Option 3">Option 3</option>
                              <option value="Option 4">Option 4</option>
                            </select>
                          </div>
                          <div class="pb-3">
                            <label
                              for="loc"
                              class="form-label text-dark text-sm"
                              >Location</label
                            >

                            <select
                              id="loc"
                              class="shadow rounded-3 form-select"
                              aria-label="Default select example"
                            >
                              <option selected value="mirpur 1">
                                Mirpur 1
                              </option>
                              <option value="Option 1">Option 1</option>
                              <option value="Option 2">Option 2</option>
                              <option value="Option 3">Option 3</option>
                              <option value="Option 4">Option 4</option>
                            </select>
                          </div>
                        </div>
                        <div
                          class="border-end mt-3"
                          style="height: 210px"
                        ></div>
                      </div>

                      <div class="d-flex align-items-center">
                        <div class="flex-grow-1 pe-4">
                          <div class="pb-3">
                            <label
                              for="Featured"
                              class="form-label text-dark text-sm"
                              >Featured</label
                            >

                            <select
                              id="Featured"
                              class="shadow rounded-3 form-select"
                              aria-label="Default select example"
                            >
                              <option selected value="SLH">SLH</option>
                              <option value="Option 1">Option 1</option>
                              <option value="Option 2">Option 2</option>
                              <option value="Option 3">Option 3</option>
                              <option value="Option 4">Option 4</option>
                            </select>
                          </div>
                          <div class="pb-3">
                            <label
                              for="Other"
                              class="form-label text-dark text-sm"
                              >Channel</label
                            >

                            <select
                              id="Tutor Request"
                              class="shadow rounded-3 form-select"
                              aria-label="Default select example"
                            >
                              <option selected value="Tutor Request">
                                Tutor Request
                              </option>
                              <option value="Option 1">Option 1</option>
                              <option value="Option 2">Option 2</option>
                              <option value="Option 3">Option 3</option>
                              <option value="Option 4">Option 4</option>
                            </select>
                          </div>
                          <div class="pb-3">
                            <label for="am" class="form-label text-dark text-sm"
                              >Action By</label
                            >

                            <select
                              id="am"
                              class="shadow rounded-3 form-select"
                              aria-label="Default select example"
                            >
                              <option selected value="Robel Hosssen">
                                Robel Hosssen
                              </option>
                              <option value="Option 1">Option 1</option>
                              <option value="Option 2">Option 2</option>
                              <option value="Option 3">Option 3</option>
                              <option value="Option 4">Option 4</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class=""></div>
                    </div>
                  </div>
                  <div
                    class="modal-footer d-flex justify-content-end align-items-center"
                    style="padding-right: 27px"
                  >
                    <div class="pe-2">
                      <button
                        type="button"
                        class="btn btn-danger grayed py-1 me-2"
                      >
                        Clear
                      </button>
                      <a
                        href="employee-filter-apply.html"
                        type="button"
                        class="btn btn-primary py-1"
                      >
                        Apply
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Filter Model ends here -->
            <div
              class="modal fade"
              id="addProfileModal"
              tabindex="-1"
              aria-labelledby="payLabel"
              aria-hidden="true"
            >
              <div
                class="modal-dialog modal-dialog-slide-top"
                style="max-width: 600px"
              >
                <div class="modal-content p-3">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">
                      Create Affiliate Profile
                    </h1>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"
                    ></button>
                  </div>
                  <div class="modal-body pt-0">
                    <form action="">
                      <div class="row row-cols-md-2">
                        <div class="mb-3">
                          <label
                            for="name"
                            class="form-label text-dark text-sm required"
                          >
                            Name</label
                          >
                          <input
                            id="name"
                            class="shadow-none rounded-3 form-control"
                            placeholder="Enter your name"
                          />
                        </div>
                        <div class="mb-3">
                          <label
                            for="phone"
                            class="form-label text-dark text-sm required"
                          >
                            Phone</label
                          >
                          <input
                            id="phone"
                            class="shadow-none rounded-3 form-control"
                            placeholder="Enter your phone"
                          />
                        </div>
                        <div class="mb-3">
                          <label
                            for="phone"
                            class="form-label text-dark text-sm"
                          >
                            Email</label
                          >
                          <input
                            id="email"
                            class="shadow-none rounded-3 form-control"
                            placeholder="Enter your phone"
                          />
                        </div>
                        <div class="mb-3">
                          <label
                            for="gndr"
                            class="form-label text-dark text-sm required"
                            >Gender</label
                          >
                          <select
                            id="gndr"
                            class="shadow-none rounded-3 form-select"
                          >
                            <option selected value="Male">Male</option>
                            <option value="Female">Female</option>
                          </select>
                        </div>

                        <div class="mb-3">
                          <label
                            for="cntry"
                            class="form-label text-dark text-sm required"
                            >Country</label
                          >
                          <select
                            id="cntry"
                            class="shadow-none rounded-3 form-select"
                          >
                            <option selected value="Bangladesh">
                              Bangladesh
                            </option>
                            <option value="Option 1">Option 1</option>
                            <option value="Option 2">Option 2</option>
                            <option value="Option 3">Option 3</option>
                            <option value="Option 4">Option 4</option>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label
                            for="cty"
                            class="form-label text-dark text-sm required"
                            >City</label
                          >
                          <select
                            id="cty"
                            class="shadow-none rounded-3 form-select"
                          >
                            <option selected value="dhaka">Dhaka</option>
                            <option value="Option 1">Option 1</option>
                            <option value="Option 2">Option 2</option>
                            <option value="Option 3">Option 3</option>
                            <option value="Option 4">Option 4</option>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label
                            for="cntry"
                            class="form-label text-dark text-sm required"
                            >Location</label
                          >
                          <select
                            id="lction"
                            class="shadow-none rounded-3 form-select"
                          >
                            <option selected value="Mirpur 1">Location</option>
                            <option value="Option 1">Option 1</option>
                            <option value="Option 2">Option 2</option>
                            <option value="Option 3">Option 3</option>
                            <option value="Option 4">Option 4</option>
                          </select>
                        </div>
                        <div class="mb-3 mb-md-0">
                          <label
                            for="acom"
                            class="form-label text-dark text-sm required"
                          >
                            Affiliate Commission</label
                          >
                          <input
                            id="acom"
                            class="shadow-none rounded-3 form-control bg-light"
                            placeholder="12% / By Defult"
                            disabled
                          />
                        </div>

                        <div class="mb-3 mb-md-0">
                          <label
                            for="pass"
                            class="form-label text-dark text-sm required"
                          >
                            Password</label
                          >
                          <input
                            id="Password"
                            class="shadow-none rounded-3 form-control bg-light"
                            placeholder="12345678 / By Defult"
                            disabled
                          />
                        </div>
                        <div class="mb-3 mb-md-0">
                          <label
                            for="pass"
                            class="form-label text-dark text-sm required"
                          >
                            Re-Password</label
                          >
                          <input
                            id="Password"
                            class="shadow-none rounded-3 form-control bg-light"
                            placeholder="12345678 / By Defult"
                            disabled
                          />
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary w-100">
                      Submit
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <!-- main content section ends here -->
          </div>
        </main>
      </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
