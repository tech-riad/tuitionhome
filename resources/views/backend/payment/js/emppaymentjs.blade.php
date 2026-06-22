<script>
    let filter = {};

    function inputChange(colname, id) {
    filter[colname] = $("#" + id).val();
    var input = '';

    const dateValue = filter[colname].replace(/-/g, '');

    Object.entries(filter).forEach((entry, index) => {
        const [key, value] = entry;

        if (index == (Object.keys(filter).length - 1)) {
            input += `${key}='${value}' `;
        } else {
            input += `${key}='${value}' and `;
        }
    });

    $('#emp_payment').val(input);
    }
</script>
