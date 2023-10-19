<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>laravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" rel="stylesheet">

    @yield('css')
    {{-- @livewireStyles --}}
</head>
<body>
    @yield('content')
   
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    {{-- @livewireScripts --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
    <script>
        var dropzone = new Dropzone('#file-upload', {
            previewTemplate: document.querySelector('#preview-template').innerHTML,
            parallelUploads: 3,
            thumbnailHeight: 150,
            thumbnailWidth: 150,
            maxFilesize: 5,
            filesizeBase: 1500,
            thumbnail: function (file, dataUrl) {
                if (file.previewElement) {
                    file.previewElement.classList.remove("dz-file-preview");
                    var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
                    for (var i = 0; i < images.length; i++) {
                        var thumbnailElement = images[i];
                        thumbnailElement.alt = file.name;
                        thumbnailElement.src = dataUrl;
                    }
                    setTimeout(function () {
                        file.previewElement.classList.add("dz-image-preview");
                    }, 1);
                }
            } 
        });

        var minSteps = 6,
            maxSteps = 60,
            timeBetweenSteps = 100,
            bytesPerStep = 100000;
        dropzone.uploadFiles = function (files) {
            var self = this;
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                totalSteps = Math.round(Math.min(maxSteps, Math.max(minSteps, file.size / bytesPerStep)));
                for (var step = 0; step < totalSteps; step++) {
                    var duration = timeBetweenSteps * (step + 1);
                    setTimeout(function (file, totalSteps, step) {
                        return function () {
                            file.upload = {
                                progress: 100 * (step + 1) / totalSteps,
                                total: file.size,
                                bytesSent: (step + 1) * file.size / totalSteps
                            };
                            self.emit('uploadprogress', file, file.upload.progress, file.upload
                                .bytesSent);
                            if (file.upload.progress == 100) {
                                file.status = Dropzone.SUCCESS;
                                self.emit("success", file, 'success', null);
                                self.emit("complete", file);
                                self.processQueue();
                            }
                        };
                    }(file, totalSteps, step), duration);
                }
            }
        }
    
    

    function updateContent(){
        let content = $("#content").val();
        let slug = "{{ request('slug')}}" ;
        let token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: "post",
            url: "{{route('update-content')}}",
            data: {content , slug , _token : token},
            success: function (data) { 
            },
            error: function (data) {
                console.log(data);
            }
        });
    } 

    function addPassword(){
        let password = $("#password").val();
        let slug = "{{ request('slug')}}" ;
        let token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: "post",
            url: "{{route('add-password')}}",
            data: {password , slug , _token : token},
            success: function (response) {  
                if (response.status === 200) {
                    $("#remove-password").css("display","block");
                    $("#add-password").css("display","none");
                }
            },
            error: function(response) {
                if (response.status === 422) {
                    var errors = response.responseJSON.errors;
                    displayErrors(errors);
                }
            }
        });
    }

    function removePassword(){ 
        $("#password").val('');
        let token = $('meta[name="csrf-token"]').attr('content');
        let slug = "{{ request('slug')}}" ;
        $.ajax({
            type: "post",
            url: "{{route('remove-password')}}",
            data: {slug , _token : token},
            success: function (response) {  
                if (response.status === 200) {
                    $("#remove-password").css("display","none");
                    $("#add-password").css("display","block");
                }
            },
            error: function(response) { 
                var errors = response.responseJSON.errors;
                displayErrors(errors); 
            }
        });
    }

    function displayErrors(errors) {
        $("#errorMessages").css("display","block");
        var errorMessages = '<ul>';
        for (var field in errors) {
            errorMessages += '<li>' + errors[field][0] + '</li>';
        }
        errorMessages += '</ul>';
        $('#errorMessages').html(errorMessages);
        setTimeout(function() { $("#errorMessages").fadeOut(1500); }, 3000)
    }

    function removeFile(id){
        let token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "post",
            url: "{{route('remove-file')}}",
            data: {id , _token : token},
            success: function (response) {  
                $("#media-wrapper").html(response)
            },
            error: function(response) { 
                var errors = response.responseJSON.errors;
                displayErrors(errors); 
            }
        });
    }
</script>

@yield('script')
</body>
</html>