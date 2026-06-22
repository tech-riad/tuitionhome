
{{--@if(Auth::guard('tutor')->user()->give_personal_info == null)--}}

<!-- {{-- <script>--}}
{{--     $(document).ready(function (){--}}
{{--         $('#exampleModalCenter').modal('show');--}}
{{--     })--}} -->

{{-- </script>--}}

{{--@endif--}}

<script type="text/javascript">

    // display tab option js
    $(".tab").css("display", "none");
$("#tab-1").css("display", "block");

function next(hideTab, showTab) {
    if (hideTab < showTab) { // If not press previous button
        // Validation if press next button

        var currentTab = 0;
        x = $('#tab-' + hideTab);
        y = $(x).find('select')
        for (i = 0; i < y.length; i++) {
            if (y[i].value == '') {

                toastr.error('filap this field');
                toastr.options.timeOut = 500;
                // $(y[i]).css("background", "#ffdddd");
                return false;
            }
        }
        for (i = 1; i < showTab; i++) {
            $("#step-" + i).css("opacity", "1");
            document.getElementById("element_add").innerHTML ="Finished";
            document.getElementById("element_add2").innerHTML =" In Progress";
        }
        // Switch tab
        $("#tab-" + hideTab).css("display", "none");
        $("#tab-" + showTab).css("display", "block");
        $("input").css("background", "#fff");
    }
}


function previous(pre,next)
{
    if(pre > next)
    {
        $("#tab-" + pre).css("display", "none");
        $("#tab-" + next).css("display", "block");
        $("input").css("background", "#fff");
    }

}
    //................ display tab option js end.............................


    //  --------------------select2 input field -------------------------------------

    $('#country').select2();
    $('#city').select2();
    $('#location').select2();
    $('#preferable_location').select2();
    $('#department').select2();

    //  -------------------- End select2 input field -------------------------------------

    //  -------------------- Start get city -------------------------------------
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

        //  -------------------- end get city -------------------------------------

        //  -------------------- Start get Location -------------------------------------
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

    //  -------------------- End get Location -------------------------------------


    //  -------------------- start get university type user -------------------------------------

    function otherClicked(obj,num){
    var el=$($(".ins_"+num)[0]);
    el.html(`
          <label>University</label>
          <input required type="text" name="institute[`+num+`]" placeholder="Please Enter the University Name" id="institute"  class="form-control">
          `);
    $(obj).closest(".select2-container").remove();
}
//     function otherClicked(obj,num){
//     var el=$($(".ins_"+num)[0]);
//     el.html(`
//           <label>University</label>
//           <input required type="text" name="institute" placeholder="Please Enter the University Name"  class="form-control">
//           `);
//     $(obj).closest(".select2-container").remove();
// }
    function otherButton(){
    return `
        <button class="btn btn-secondary" onclick="otherClicked(this)">Other</a>
        `;
};

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

    //  -------------------- End get university type user -------------------------------------


    // ..............................start store data tutor information into database...................
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function (){
       $("#register_data").submit(function (e){
          e.preventDefault();
           var country = $('#country').val();
           var city = $('#city').val();
           var location = $('#location').val();
           var preferable_locations = $('#preferable_location').val();
           var institute_name = $('#institute_name').val();
           var institute = $('#institute').val();
           var department = $('#department').val();
           // var data = 'country='+country  + '&city='+ city + '&location='+ location + '&preferable_location='+ preferable_location + '&institute_name='+ institute_name  + '&institute='+ institute +'&department='+ department;
           $.ajax({
               url:'{{route("tutor.personal.info.store")}}',
               type:'post',
               data:{
                   country:country,
                   city:city,
                   location:location,
                   preferable_locations:preferable_locations,
                   institute_name:institute_name,
                   institute:institute,
                   department:department
               },
               success:function (result){

                   if(result)
                   {
                       $('#exampleModalCenter').modal('hide');
                       swal({
                           title: "Registration all done!",
                           icon: "success",
                           button: "ok",
                           timer: 2000,
                       });

                   }

               }


           });
       });
    });

</script>
