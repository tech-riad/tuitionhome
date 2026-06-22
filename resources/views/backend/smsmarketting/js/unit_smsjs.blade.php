<script>
    $(document).ready(function () {
        function submitSMSForm(sendNow = true) {
            let numbers = $('#numbers').val();
            let smsBody = $('#description').val();
            let title = $('#title').val();
            let sendLaterTime = sendNow ? null : $('#sendLaterInput').val();
            let recurring = sendNow ? null : $('#sendRecurringInput').val();

            if (!numbers || !smsBody) {
                toastr.error("Please fill in both numbers and SMS body.");
                return;
            }

            $('#loading-spinner').show();

            $.ajax({
                url: "{{ route('admin.sms.marketing.unit.filter') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    title: title,
                    numbers: numbers,
                    sms_body: smsBody,
                    send_now: sendNow ? 1 : null,
                    send_later_time: sendLaterTime,
                    recurring: recurring,
                },
                success: function (response) {
                    toastr.success(response.message || "SMS saved successfully!");
                    $('#smsForm')[0].reset();
                    $('#sendModal').modal('hide');
                },
                error: function (xhr) {
                    toastr.error("Something went wrong!");
                },
                complete: function () {
                    $('#loading-spinner').hide();
                }
            });
        }

        $('#sendNowBtn').click(function () {
            submitSMSForm(true);
        });

        $('#sendLaterBtn').click(function () {
            submitSMSForm(false);
        });
    });
    </script>



<script>
    function liveChange(id) {
        var isChecked = $("#button-check[data-id='" + id + "'] .checkbox").is(":checked");
        var newState = isChecked ? 1 : 0;

        // Show spinner
        $('#loading-spinner').show();

        $.ajax({
            url: "{{ route('admin.sms.marketing.unit.send.sms') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                state: newState
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr, status, error) {
                toastr.error('Something went wrong!');
            },
            complete: function() {

                $('#loading-spinner').hide();
            }
        });
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const fields = [
            { id: "description", char: "char", rem: "rem", msg: "msg", message: "char-left-message" },
            { id: "description_unit", char: "char_unit", rem: "rem_unit", msg: "msg_unit", message: "char-left-message-unit" }
        ];

        fields.forEach(field => {
            const element = document.getElementById(field.id);
            if (element) {
                element.addEventListener("input", function () {
                    count(this, field);
                });
            }
        });
    });

    function count(element, field) {
        const maxCharacters = 320;
        let text = element.value;
        let charCount = text.length;

        if (charCount > maxCharacters) {
            text = text.slice(0, maxCharacters);
            element.value = text;
            charCount = maxCharacters;
        }

        const remaining = maxCharacters - charCount;
        const msgCount = Math.ceil(charCount / 160);

        document.getElementById(field.char).textContent = `${charCount}/320`;
        document.getElementById(field.rem).textContent = remaining;
        document.getElementById(field.msg).textContent = msgCount;

        const messageElement = document.getElementById(field.message);
        if (remaining <= 20) {
            document.getElementById(field.rem).classList.add('text-danger');
            messageElement.textContent = `${remaining} characters left`;
        } else {
            document.getElementById(field.rem).classList.remove('text-danger');
            messageElement.textContent = '';
        }
    }
</script>
