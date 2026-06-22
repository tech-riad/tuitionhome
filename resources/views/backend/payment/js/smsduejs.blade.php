<script>
    let filter = {};

    function inputChange(colname, id) {
    filter[colname] = $("#" + id).val();
    var input = '';

    // Convert the date format if necessary
    const dateValue = filter[colname].replace(/-/g, '');

    Object.entries(filter).forEach((entry, index) => {
        const [key, value] = entry;

        if (index == (Object.keys(filter).length - 1)) {
            input += `${key}='${value}' `;
        } else {
            input += `${key}='${value}' and `;
        }
    });

    $('#sms_due_filter').val(input);
    }
</script>
