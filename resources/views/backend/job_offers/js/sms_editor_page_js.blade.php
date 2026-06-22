<script>
    function changeTemplate(id, job_id) {
        $.ajax({
            type: "GET",
            url: '{{ route("admin.job.sms_template.change") }}',
            data: {
                id: id,
                job_id: job_id,
            },
            success: function (response) {
                let originalBody = response.template.body;
                let job = response.job;

                let replacements = [
                    { from: "-job_id-", to: job.id },
                    { from: "-class-", to: job.class },
                    { from: "-subjects-", to: job.subject },
                    { from: "-location-", to: job.full_address },
                    { from: "-days-", to: job.days },
                    { from: "-duration-", to: job.duration },
                    { from: "-time-", to: job.time },
                    { from: "-salary-", to: job.salary },
                    { from: "-offer_id-", to: job.id },
                ];

                let body = originalBody;

                for (let i = 0; i < replacements.length; i++) {
                    body = body.replace(replacements[i].from, replacements[i].to);
                }

                $('#sms_body').val(body);

                const alphabetCount = countAlphabetsAndSpaces(body);
                updateCharacterCount(alphabetCount);
            },
        });
    }

    function countAndUpdate(value) {
        const characterCount = countAlphabetsAndSpaces(value);
        updateCharacterCount(characterCount);
    }

    function countAlphabetsAndSpaces(sentence) {
        const cleanSentence = sentence.replace(/[^a-zA-Z0-9 ]/g, '').toLowerCase();
        const count = cleanSentence.length;
        return count;
    }

    function updateCharacterCount(count) {
        const maxCharacters = 160;
        const remaining = maxCharacters - count;
        const messageCount = Math.ceil(count / 160);
        $('#char').text(count + '/' + maxCharacters);
        $('#rem').text(remaining);

        // Display red alert when remaining characters are 20 or less
        if (remaining <= 20) {
            $('#rem').addClass('text-danger');
            $('#char-left-message').text(remaining + ' characters left');
        } else {
            $('#rem').removeClass('text-danger');
            $('#char-left-message').text('');
        }

        $('#msg').text(messageCount);
    }
</script>