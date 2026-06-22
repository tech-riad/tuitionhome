@extends('welcome')
@push('css')

@endpush
@section('content')
   <div class="container">
       <div class="col-md-8 offset-md-2 mt-4">
           <div class="card">
               <div class="card-header bg-secondary text-white">Tutoring Location</div>
               <form action="{{ route('tutor.personal.info.store') }}" method="post">
                   @csrf
               <div class="card-body">
                   @error('tutor_id') <span class=" alert alert-dangererror text-danger"> {{ $message }} </span>@enderror
                   <div class="row">
                       <div class="col-md-6">
                           <div class="form-group">
                               <input type="hidden" value="{{ session()->get('tutor_id') }}" name="tutor_id">
                               <label >Country Name</label>
                               <select name="country_name" class="form-control select2" id="country">
                                   <option value="">~select country~</option>
                                   @if(isset($countries))
                                       @foreach($countries as $country)
                                           <option value="{{ $country->id }}">{{ $country->name }}</option>
                                       @endforeach
                                   @endif
                               </select>
                               <span class="error text-danger">@error('country_name') {{ $message }} @enderror</span>
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label >Your Tutoring City</label>
                               <select name="city_name" class="form-control select2" id="city">
                                   <option value="">~select City~</option>
                               </select>
                           <span class="error text-danger"> @error('city_name'){{ $message }} @enderror </span>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-md-6">
                           <div class="form-group">
                               <label> Your Location</label>
                               <select name="location" class="form-control select2" id="location">
                                   <option value="">~select Location~</option>
                               </select>
                            <span class="error text-danger">@error('location') {{ $message }} @enderror</span>
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label > Your Preferable Location</label>
                               <select name="preferable_locations[]" class="form-control select2" id="preferable_location" multiple>
                                   <option value="">~select Preferable location~</option>
                               </select>
                                <span class="error text-danger">@error('preferable_locations') {{ $message }} @enderror</span>
                           </div>
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-md-6">
                           <div class="form-group ins_6">
                               <label for="">University Name</label>
                               <select name="institute_name" class="select2_6 form-control" required>
                                   <option value="">~Select Your University~</option>
                                   @foreach($institutes as $institute)
                                       <option value="{{ $institute->id }}">{{ $institute->title }}</option>
                                   @endforeach
                               </select>
                            <span class="text-danger">@error('institute_name'){{ $message }}@enderror</span>
                           </div>

                       </div>
                       <div class="col-md-6">
                           <div class="form-group ">
                               <label for="">Department</label>
                               <select name="department" class="form-control select2" id="department">
                                   <option value="">~Select Department~</option>
                                   @foreach($departments as $department)
                                       <option value="{{ $department->id }}">{{ $department->title }}</option>
                                   @endforeach
                               </select>
                              <span class="text-danger">@error('department'){{ $message }}@enderror</span>
                           </div>
                       </div>

                   </div>
                   <div class="card-footer pb-4">
                       <input type="submit" class="btn btn-success px-5 float-right " value="Submit">
                   </div>

               </div>
               </form>
           </div>
       </div>
   </div>

@endsection
@push('js')

    <script>


        $('#country').select2();
        $('#city').select2();
        $('#location').select2();
        $('#preferable_location').select2();
        $('#department').select2();
        // get city
        $(document).ready(function(){
            $('#country').change(function (){
                let c_id = $(this).val();
                $.ajax({
                    url:'{{route("get_city")}}',
                    type:'post',
                    data:'c_id='+c_id+'&_token={{ csrf_token() }}',
                    success:function (result){
                        $('#city').html(result);
                    }


                });
            });

            // get location
            $('#city').change(function (){
                let city_id = $(this).val();
                $.ajax({
                    url:'{{route("get_location")}}',
                    type:'post',
                    data:'city_id='+city_id+'&_token={{ csrf_token() }}',
                    success:function (result){
                        $('#location').html(result);
                        $('#preferable_location').html(result);
                    }


                });
            });

        });

        // function otherClicked(obj,num){
        //     var el=$($(".ins_"+num)[0]);
        //     el.html(`
        //   <label>University</label>
        //   <input required type="text" name="institute[`+num+`]" placeholder="Please Enter the University Name"  class="form-control">
        //   `);
        //     $(obj).closest(".select2-container").remove();
        // }
        function otherClicked(obj,num){
            var el=$($(".ins_"+num)[0]);
            el.html(`
          <label>University</label>
          <input required type="text" name="institute" placeholder="Please Enter the University Name"  class="form-control">
          `);
            $(obj).closest(".select2-container").remove();
        }
        // function otherButton(){
        //     return `
        // <button class="btn btn-secondary" onclick="otherClicked(this)">Other</a>
        // `;
        // };

        function insSelect2(num){
            $('.select2_'+num).select2({
                language: {
                    noResults: function(){
                        return `
                <button class="btn btn-secondary" onclick="otherClicked(this,`+num+`)">Type University</a>
                `;
                    }
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
            });
        }
        // demo test
        $(function(){
            //Initialize Select2 Elements
            $('.select2').select2();
            var arr=[6,4];
            for(var n of arr){
                insSelect2(n);
            }

            //Initialize Select2 Elements
        });
        //     end demo test

    </script>

@endpush
