<x-backend.layouts.master>

    <div class="col-md-10">
        <h1>
            Package Amount Setting Page
        </h1>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Package Amount Setting</h5>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#packageAmountModal">
                            <i class="fas fa-plus"></i> Add Package Amount
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Package Amount Modal -->
        <div class="modal fade" id="packageAmountModal" tabindex="-1" aria-labelledby="packageAmountModalLabel"
            aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="packageAmountModalLabel">
                            Package Amount Setting
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('admin.package.add') }}" method="POST">
                        @csrf

                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="package_name" class="form-label">Package Name</label>
                                <select class="form-control" id="package_name" name="package_name">
                                    <option value="">Select Package</option>
                                    <option value="regular">Regular Premium</option>
                                    <option value="pro">Pro Premium</option>
                                    <option value="advance">Advance Premium</option>
                                    <option value="regular_boost">Regular Boost</option>
                                    <option value="pro_boost">Pro Boost</option>
                                    <option value="advance_boost">Advance Boost</option>
                                    <option value="enterprise_boost">Enterprise Boost</option>
                                    <option value="verify">Profile Verify</option>
                                    <option value="sms">SMS</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="amount" name="amount"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="currency" class="form-label">Currency</label>
                                <input type="text" class="form-control" id="currency" name="currency" value="BDT"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="duration" class="form-label">Duration (months)</label>
                                <input type="text" class="form-control" id="duration" name="duration"
                                    placeholder="e.g. 2 months " required>
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="">Select Package</option>
                                    <option value="premium">Premium</option>
                                    <option value="profile_verify">Profile Verification</option>
                                    <option value="boost">Boost</option>
                                    <option value="sms">SMS</option>

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="cupon" class="form-label">Cupon Code</label>
                                <input type="text" class="form-control" id="cupon" name="cupon"
                                    placeholder="ABC#" >
                            </div>
                            <div class="mb-3">
                                <label for="discount" class="form-label">Discount Amount</label>
                                <input type="text" class="form-control" id="discount" name="discount"
                                    placeholder="e.g. 20" >
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Cancel
                            </button>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Package
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">Package Amount List</h5>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Package Name</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Currency</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Cupon Code</th>
                                    <th scope="col">Discount Amount</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($packageAmounts as $index => $packageAmount)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $packageAmount->package_name ?? 'N/A'}}</td>
                                    <td>{{ $packageAmount->amount }}</td>
                                    <td>{{ $packageAmount->currency }}</td>
                                    <td>{{ $packageAmount->duration }}</td>
                                    <td>{{ $packageAmount->type }}</td>
                                    <td>{{ $packageAmount->cupon ?? 'N/A'}}</td>
                                    <td>{{ $packageAmount->discount ?? 'N/A'}}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editPackageModal{{ $packageAmount->id }}">
                                            <i class="fas fa-edit"></i> Update
                                        </button>
                                    </td>
                                </tr>

                                <!-- Edit Package Modal -->
                                <div class="modal fade" id="editPackageModal{{ $packageAmount->id }}" tabindex="-1"
                                    aria-labelledby="editPackageLabel{{ $packageAmount->id }}" aria-hidden="true">

                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">

                                            <form
                                                action="{{ route('admin.package.amount.update', $packageAmount->id) }}"
                                                method="POST">
                                                @csrf

                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editPackageLabel{{ $packageAmount->id }}">
                                                        Update Package Amount
                                                    </h5>

                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">

                                                    <div class="mb-3">
                                                        <label class="form-label">Package Name</label>
                                                        <select class="form-control" id="package_name" name="package_name">
                                                            <option value="regular" {{ $packageAmount->package_name == 'regular' ? 'selected' : '' }}>Regular Premium</option>
                                                            <option value="pro" {{ $packageAmount->package_name == 'pro' ? 'selected' : '' }}>Pro Premium</option>
                                                            <option value="advance" {{ $packageAmount->package_name == 'advance' ? 'selected' : '' }}>Advance Premium</option>
                                                            <option value="regular_boost" {{ $packageAmount->package_name == 'regular_boost' ? 'selected' : '' }}>Regular Boost</option>
                                                            <option value="pro_boost" {{ $packageAmount->package_name == 'pro_boost' ? 'selected' : '' }}>Pro Boost</option>
                                                            <option value="advance_boost" {{ $packageAmount->package_name == 'advance_boost' ? 'selected' : '' }}>Advance Boost</option>
                                                            <option value="enterprise_boost" {{ $packageAmount->package_name == 'enterprise_boost' ? 'selected' : '' }}>Enterprise Boost</option>
                                                            <option value="verify" {{ $packageAmount->package_name == 'verify' ? 'selected' : '' }}>Profile Verify</option>
                                                            <option value="sms" {{ $packageAmount->package_name == 'sms' ? 'selected' : '' }}>SMS</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Amount</label>
                                                        <input type="number" step="0.01" min="0" class="form-control"
                                                            name="amount" value="{{ $packageAmount->amount }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Currency</label>
                                                        <input type="text" class="form-control" name="currency"
                                                            value="{{ $packageAmount->currency }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Duration</label>
                                                        <input type="text" class="form-control" name="duration"
                                                            value="{{ $packageAmount->duration }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Type</label>
                                                        <input type="text" class="form-control" name="type"
                                                            value="{{ $packageAmount->type }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Cupon Code</label>
                                                        <input type="text" class="form-control" name="cupon"
                                                            value="{{ $packageAmount->cupon }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Discount Amount</label>
                                                        <input type="text" class="form-control" name="discount"
                                                            value="{{ $packageAmount->discount }}">
                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        Cancel
                                                    </button>

                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save"></i> Save Changes
                                                    </button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>
        </div>



    </div>

    <div class="col-md-10">


    </div>


</x-backend.layouts.master>
