<script>
    $(function () {
        $("#parentNote").on("submit", function (event) {
            event.preventDefault();


            const formElement = document.getElementById('parentNote');
            const formData = new FormData(formElement);

            const parent_id = formData.get('parent_id');
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


            $.ajax({
                url: $(this).attr("action"),
                method: $(this).attr("method"),
                data: new FormData(this),
                processData: false,
                datatype: JSON,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },

                success: function (response) {

                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "note added successfully",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    $("#parentNote")[0].reset();


                    btnNote(parent_id);
                    //    console.log(response);
                },

                error: function (err) {
                    let error = err.responseJSON;
                    console.log(error);
                },
            });
        });
    });


    $.date = function (dateObject) {
        const myArray = dateObject.split("T");
        var d = new Date(myArray[0]);
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        var date = day + "-" + month + "-" + year;

        return date;
    };


    function btnNote(id) {


        $('#note_parent_id').val(id);

        //  console.log(id);

        $.ajax({
            url: '{{route("admin.parent.getnote")}}',
            type: 'get',
            data: {
                id: id,
            },
            success: function (response) {

                let html = '';

                var notes = response.data
                for (i = 0; i < notes.length; i++) {

                    // console.log(notes[i].body);

                    html += ' <div class="border-bottom border-1 pb-3">\
                                            <div class="bg-light rounded-2 p-2" style="font-size: 14px">\
                                                Lorem ipsum dolor sit amet consectetur adipisicing\
                                                elit. Perspiciatis, dignissimos.\
                                            </div>\
                                        </div>\
                                        <div class="d-flex justify-content-between align-items-center mt-3">\
                                            <div class="d-flex justify-content-start align-items-center gap-3">\
                                                <img height="45" width="45" class="rounded-3"\
                                                    src="/images/avatar.svg" alt="" />\
                                                <div class="">\
                                                    <p class="m-0" style="font-size: 14; font-weight: 500">\
                                                        Kaji Polash\
                                                    </p>\
                                                    <p class="m-0 fw-light" style="font-size: 12px">\
                                                        Sales & Operation Dep:\
                                                    </p>\
                                                </div>\
                                            </div>\
                                            <div>\
                                                <p style="font-size: 12px">12:30 PM 21-01-2023</p>\
                                            </div>\
                                        </div>';

                }


                $('#noteModal').html(html);



            }
        });

    }


    $(function (e) {
        $("#select_all").click(function () {
            $('.checkboxx').prop('checked', $(this).prop('checked'));
        });

        $("#sendSms").click(function (e) {
            e.preventDefault();
            var all_ids = [];

            $('input:checkbox[name=ids]:checked').each(function () {
                all_ids.push($(this).val());
            });

            $("#var1").val(all_ids);
            console.log(all_ids);
            if (all_ids == '') {
                alert("please select atleast one parents");
            } else {
                $("#smsForm").submit();
            }


        });

    });

    function dateTime(dateTime) {

        let xx = dateTime;
        const myArray = xx.split(" ");

        let date = new Date(myArray[0]);
        let year = new Intl.DateTimeFormat('en', {
            year: 'numeric'
        }).format(date);
        let month = new Intl.DateTimeFormat('en', {
            month: 'short'
        }).format(date);
        let day = new Intl.DateTimeFormat('en', {
            day: '2-digit'
        }).format(date);

        let time = myArray[1];

        var hour = parseInt(time.split(":")[0]) % 12;
        var timeInAmPm = (hour == 0 ? "12" : hour) + ":" + time.split(":")[1] + " " + (parseInt(parseInt(time.split(
            ":")[0]) / 12) < 1 ? "am" : "pm");

        $("#date").text(`${day} ${month} ${year}`);
        $("#time").text(timeInAmPm);

    }

    $('#checkbox').on('click', function () {

        // let value = $(this).val();
        if (this.checked) {
            console.log('on');
        } else {
            console.log('off');
        }
    })

    function btnEdit(id) {

        var route = '{{ route("parent.edit", ":id") }}';
        route = route.replace(':id', id);

        $.ajax({
            type: "GET",
            url: route,
            success: function (response) {
                $('#parent_id').val(response.parent.id);
                $('#name').val(response.parent.name);
                $('#email').val(response.parent.email);
                $('#phone').val(response.parent.phone);
                $('#additional_phone').val(response.parent.additional_phone);
            }
        });
    }



    //  var checkboxes = document.querySelectorAll('.checkbox');

    //  function selectAll(){

    //     var checkboxes = document.querySelectorAll('.checkbox');

    //     for(var checkbox of checkboxes){
    //         checkbox.checked = this.checked;
    //     }
    //     console.log('hi');



    // }

    function selectAll(source) {
        var checkboxes = document.querySelectorAll('.checkbox');
        var count = 0;
        for (var i = 0; i < checkboxes.length; i++) {

            if (checkboxes[i] != source) {
                checkboxes[i].checked = source.checked;

                if (checkboxes[i].checked == true) {
                    count++;
                    document.getElementById('selected').innerHTML = count;
                }
            } else {
                count = 0;
                document.getElementById('selected').innerHTML = count;

            }
        }


    }






    // for(var i=0; i < checkboxes.length ;i++){
    //     checkboxes[i].addEventListener('click',function(){
    //         if(this.checked == true){
    //             count ++;
    //         }
    //         else{
    //             count -- ;
    //         }
    //         document.getElementById('selected').innerHTML = count;

    //     })
    // }

</script>

<script>
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // $('#country_id').select2();
        $('#city_id').select2();
        $('#location_id').select2();
        $('#institute_id').select2();
        // $('#ssc_institute_id').select2();
        $('#department_id').select2();
        $('#hsc_institute_id').select2();
        $('#category_id').select2();
        $('#course_id').select2();
        $('#subject_id').select2();
        $('#country_id').change(function () {
            let c_id = $(this).val();
            $.ajax({
                url: '{{route("get_city")}}',
                type: 'post',
                data: 'c_id=' + c_id + '&_token={{ csrf_token() }}',
                success: function (result) {
                    $('#city_id').html(result);
                }


            });
        });

        // get location
        $('#city_id').change(function () {
            let city_id = $(this).val();
            $.ajax({
                url: '{{route("get_location")}}',
                type: 'post',
                data: 'city_id=' + city_id + '&_token={{ csrf_token() }}',
                success: function (result) {
                    $('#location_id').html(result);
                }


            });
        });


        // .............................Start get Category and course...........................

        $('#category_id').change(function () {
            let category_id = $(this).val();
            // console.log(category_id);
            $.ajax({
                url: '{{route("get_class_course")}}',
                type: 'post',
                data: {
                    category_id: category_id
                },
                success: function (result) {
                    $("#course_id").html(result);

                }

            });
        });


        $('#course_id').change(function () {
            let course_id = $(this).val();
            $.ajax({
                url: '{{route("get_course_subject")}}',
                type: 'post',
                data: {
                    course_id: course_id
                },
                success: function (result) {
                    $('#subject_id').html(result)

                }

            });
        });

    });


      let filter = {};
        let orFilter = [];

    // let orFilter = ['group_or_major','university_type' ,'department_id'];
    function filterChange(colname, id){

        filter[colname]=$("#"+id).val();

      var input = '';

      const orDatas = new Map();
      Object.entries(filter).forEach((entry,index) => {
          const [key, value] = entry;


          if(orFilter.includes(key)){
            orDatas.set(key, value);
          }
          else{
            if(index==(Object.keys(filter).length-1)){
                if(key=='created_at <' || key=='country_id' || key=='city_id' || key=='created_at >' || key=='gender' || key =='tutoring_experience' || key =='religion' || key=='blood_group' || key =='method_id' || key =='group_or_major' || key=='blood_group' || key =='method_id' || key =='institute_id' || key=='category_id' || key=='curriculum_id' || key=='location_id'
                || key=='university_type' || key=='degree_name' || key=='department_id' || key=="degree_name='honours' and institute_id" || key=="degree_name='ssc' and institute_id" || key=="degree_name='hsc' and institute_id" || key=="department_id" || key=="expected_salary" || key=="education_board"){
                    input+= `${key}='${value}' `;
                }
                else{
                    input+= `${key} in (${value})` ;
                }
            }
            else{
                if(key=='created_at <' || key=='country_id' || key=='city_id' || key=='created_at >' || key=='gender' || key =='tutoring_experience' || key =='religion' || key=='blood_group' || key =='method_id' || key =='group_or_major' || key=='blood_group' || key =='method_id' || key =='institute_id' || key=='category_id' || key=='curriculum_id' || key=='location_id'
                || key=='university_type' || key=='degree_name' || key=='department_id' || key=="degree_name='honours' and institute_id" || key=="degree_name='ssc' and institute_id" || key=="degree_name='hsc' and institute_id" || key=="department_id" || key=="expected_salary" || key=="education_board"){
                        input+= `${key}='${value}' and `;
                }
                else{
                    input+= `${key} in (${value}) and ` ;
                }
            }
        }


      });

      if(orDatas.size>0){
            input+= '('
        }
        orDatas.forEach((value,key)=>{
            const currLen = Array.from(orDatas);
            const lastEntry = currLen[currLen.length-1];
            const [lkey,lvalus] = lastEntry;



            if(lkey==key){
                input+= `${key} = '${value}' ` ;
            }
            else{
                input+= `${key} = '${value}' or ` ;
            }

        });
        if(orDatas.size>0){
            input+= ')'
        }

    //    console.log(input);


      $('#searchInput').val(input);





    }

</script>
<script>
    $(document).ready(function () {
        $('form[id^="additional-note-form-"]').on('submit', function (e) {
            e.preventDefault();

            let form = $(this);
            let parentId = form.find('input[name="parent_id"]').val();
            let note = form.find('textarea[name="parent_manage_note"]').val();
            let modalId = `#additional_note_${parentId}`;

            $.ajax({
                url: "{{ route('admin.parent.additional.note.add') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    parent_id: parentId,
                    parent_manage_note: note
                },
                success: function (response) {
                    toastr.success(response.message || "Note updated successfully.");
                    $(modalId).modal('hide');
                    location.reload(1500); // Reload the page to reflect changes
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        form.find('.parent_manage_note_error').text(errors.parent_manage_note?.[0] || '');
                    } else {
                        toastr.error("An error occurred. Please try again.");
                    }
                }
            });
        });
    });
</script>