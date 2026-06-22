<script>

    $('#sscCertificate').ijaboCropTool({
        // preview : '.image-previewer',
        setRatio:1.5,
        allowedExtensions: ['jpg','jpeg','png'],
        buttonsText:['CROP & Upload','CANCEL'],
        processUrl:'{{ route("crop-certificate") }}',
        withCSRF:['_token','{{ csrf_token() }}'],
        onSuccess:function(message, element, status){

            alert(message)
        },
        onError:function(message, element, status){
            console.log(element);
        }
    });

    $('#sscMarksheet').ijaboCropTool({
        // preview : '.image-previewer',
        setRatio:1.5,
        allowedExtensions: ['jpg','jpeg','png'],
        buttonsText:['CROP & Upload','CANCEL'],
        processUrl:'{{ route("crop-certificate") }}',
        withCSRF:['_token','{{ csrf_token() }}'],
        onSuccess:function(message, element, status){

            alert(message)
        },
        onError:function(message, element, status){
            console.log(element);
        }
    });
    $('#hscCertificate').ijaboCropTool({
        // preview : '.image-previewer',
        setRatio:1.5,
        allowedExtensions: ['jpg','jpeg','png'],
        buttonsText:['CROP & Upload','CANCEL'],
        processUrl:'{{ route("crop-certificate") }}',
        withCSRF:['_token','{{ csrf_token() }}'],
        onSuccess:function(message, element, status){

            alert(message)
        },
        onError:function(message, element, status){
            console.log(element);
        }
    });
    $('#hscMarksheet').ijaboCropTool({
        // preview : '.image-previewer',
        setRatio:1.5,
        allowedExtensions: ['jpg','jpeg','png'],
        buttonsText:['CROP & Upload','CANCEL'],
        processUrl:'{{ route("crop-certificate") }}',
        withCSRF:['_token','{{ csrf_token() }}'],
        onSuccess:function(message, element, status){

            alert(message)
        },
        onError:function(message, element, status){
            console.log(element);
        }
    });
    $('#upload_cv').ijaboCropTool({
        // preview : '.image-previewer',
        setRatio:1.5,
        allowedExtensions: ['jpg','jpeg','png'],
        buttonsText:['CROP & Upload','CANCEL'],
        processUrl:'{{ route("crop-certificate") }}',
        withCSRF:['_token','{{ csrf_token() }}'],
        onSuccess:function(message, element, status){

            alert(message)
        },
        onError:function(message, element, status){
            console.log(element);
        }
    });
    $('#birth_nid').ijaboCropTool({
        // preview : '.image-previewer',
        setRatio:1.5,
        allowedExtensions: ['jpg','jpeg','png'],
        buttonsText:['CROP & Upload','CANCEL'],
        processUrl:'{{ route("crop-certificate") }}',
        withCSRF:['_token','{{ csrf_token() }}'],
        onSuccess:function(message, element, status){

            alert(message)
        },
        onError:function(message, element, status){
            console.log(element);
        }
    });
    $('#admission_certificate').ijaboCropTool({
        // preview : '.image-previewer',
        setRatio:1.5,
        allowedExtensions: ['jpg','jpeg','png'],
        buttonsText:['CROP & Upload','CANCEL'],
        processUrl:'{{ route("crop-certificate") }}',
        withCSRF:['_token','{{ csrf_token() }}'],
        onSuccess:function(message, element, status){

            alert(message)
        },
        onError:function(message, element, status){
            console.log(element);
        }
    });
    $('#other').ijaboCropTool({
        // preview : '.image-previewer',
        setRatio:1.5,
        allowedExtensions: ['jpg','jpeg','png'],
        buttonsText:['CROP & Upload','CANCEL'],
        processUrl:'{{ route("crop-certificate") }}',
        withCSRF:['_token','{{ csrf_token() }}'],
        onSuccess:function(message, element, status){

            alert(message)
        },
        onError:function(message, element, status){
            console.log(element);
        }
    });
</script>
