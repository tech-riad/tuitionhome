<script>
    // add permission field javascript
    var formfield = document.getElementById('formfield');

    function add(){
        var newField = document.createElement('input');
        newField.setAttribute('type','text');
        newField.setAttribute('name','permission_name[]');
        newField.setAttribute('class','form-control mb-4');
        newField.setAttribute('size',50);
        newField.setAttribute('placeholder','Permission Name');
        formfield.appendChild(newField);
    }

    function remove(){
        var input_tags = formfield.getElementsByTagName('input');
        if(input_tags.length > 2) {
            formfield.removeChild(input_tags[(input_tags.length) - 1]);
        }
    }

    // add permission field javascript end
</script>
