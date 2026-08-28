<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-white sidebar collapse sidebar-width shadow-lg"
                style="height: 100vh; margin-top: 60px; position: fixed">
                <div class="d-flex justify-content-center align-items-center flex-column border-bottom mt-2 pb-3">
                    <div class="mb-2">
                        <img src="{{ asset('backend/file/images/boy.jpg') }}" alt="image" class="profile-img" style="
                  width: 80px;
                  height: 90px;
                  object-fit: cover;
                  margin-top: 16px;
                " />
                    </div>
                    <h5 class="text-gray-800 mt-3">Super Admin</h5>
                </div>
                <div style="overflow-y: auto; height: 65vh" class="scrollbar-none">
                    <ul class="list-unstyled px-3 mt-2">
                        <li class="mb-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-credit-card fs-5 me-4"></i>
                                <div class="d-flex w-100 justify-content-between">
                                    <a class="text-decoration-none text-gray-800 align-items-center collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#offer-collapse" aria-expanded="false"
                                        style="cursor: pointer">
                                        Corporate Partner
                                    </a>
                                    <i class="bi bi-chevron-left arrow-icon"></i>
                                </div>
                            </div>

                            <div class="collapse show" id="offer-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li class="ms-4 px-3 py-1 my-3" style="border-left: 3px solid #898e99">
                                        <a href="{{ route('admin.cprequest.index') }}" class="text-gray-800 text-decoration-none">CP Request</a>
                                    </li>
                                    <li class="ms-4 px-3 py-1 my-3" style="border-left: 3px solid #89c33f">
                                        <a href="{{ route('admin.cpprofile.index') }}"
                                            class="text-primary text-decoration-none text-nowrap">CP Profile</a>
                                    </li>
                                    {{-- <li class="ms-4 px-3 py-1 my-3" style="border-left: 3px solid #898e99">
                                        <a href="/affiliate-transaction.html"
                                            class="text-gray-800 text-decoration-none text-nowrap">Affiliate
                                            Transaction</a>
                                    </li>
                                    <li class="ms-4 px-3 py-1 my-3" style="border-left: 3px solid #898e99">
                                        <a href="/setting.html" class="text-gray-800 text-decoration-none">Setting</a>
                                    </li> --}}
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>