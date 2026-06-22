
@extends('layouts.app')

@push ('page_css')

  @endpush


@section('content')

<main class="container-custom">
    <div class="col-md-9 ms-sm-auto col-lg-12" >
      <!-- main content section starts here -->
      <div class="pt-4 ps-3" style="padding-right: 13px">
        <div class="pt-2 shadow-lg rounded-3 bg-white">
          <div class="table-responsive">
            <table
              class="table table-hover bg-white shadow-none"
              style="border-collapse: collapse"
            >
              <thead
                class="text-dark"
                style="border-bottom: 1px solid #c8ced3"
              >
                <tr>
                  <th scope="col" class="text-nowrap">Updated By</th>
                  <th scope="col" class="text-nowrap">EM Name</th>
                  <th scope="col" class="text-nowrap">Em ID</th>
                  <th scope="col" class="text-nowrap">Status</th>
                  <th scope="col" class="text-nowrap">Date and time</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($status as $item)
                <tr class="" style="vertical-align: middle">
                    <td class="text-nowrap">{{$item->updated_by}}</td>

                    <td class="text-nowrap">{{$item->user->name ?? ''}} @if(!$item->updated_by) (Auto Off) @endif</td>

                    <td class="text-nowrap">{{$item->emp_id}}</td>
                    <td class="text-info">
                        <div class="switch-toggle">
                            <div class="button-check" id="button-check"
                               >
                                <input type="checkbox" class="checkbox" @if($item->status == 1) checked disabled @endif />
                                {{-- <input type="checkbox" class="checkbox" @if($item->status == 0) checked disabled @endif /> --}}
                                <span class="switch-btn"></span>
                                <span class="layer"></span>
                            </div>
                        </div>
                    </td>
                    <td class="text-nowrap">
                      <p class="mb-0">{{$item->created_at}}</p>
                    </td>
                  </tr>

                @endforeach

              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- main content section ends here -->
    </div>
  </main>



@endsection

@push('page_scripts')


@endpush
