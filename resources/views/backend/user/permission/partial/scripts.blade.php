<script>
    $("#checkpermissionAll").click(function (){

        if($(this).is(':checked'))
        {
            // checked all input
            $('input[type=checkbox]').prop('checked',true);

        }else
        {
            // unchecked all input
            $('input[type=checkbox]').prop('checked',false);
        }

    });

    function checkPermissionByGroup(className,checkthis)
    {
        const groupIdName = $("#"+checkthis.id)
        const classCheckbox = $('.'+className+' input');
        if(groupIdName.is(':checked'))
        {
            classCheckbox.prop('checked',true);
        }else
        {
            classCheckbox.prop('checked',false);
        }
        // checkAllPermission();

    }

    function checkSinglePermission(groupClassName,groupId,countTotalPermission)
    {
        const groupClassNameCheck = $('.'+groupClassName+ ' input:checked');
        const groupIdcheck = $('#'+groupId);

        if(groupClassNameCheck.length == countTotalPermission)
        {
            groupIdcheck.prop('checked',true)

        }else
        {
            groupIdcheck.prop('checked',false)
        }
        checkAllPermission();

    }
    function checkAllPermission()
    {
        const countAllPermission = {{ count($All_permissions) }};
        const countGroup_permissions = {{ count($group_permissions) }};
        if($('input[type="checkbox"]:checked').length >= (countAllPermission + countGroup_permissions))
        {
            $("#checkpermissionAll").prop('checked',true);

        }else
        {
            $("#checkpermissionAll").prop('checked',false);
        }
    }


</script>
