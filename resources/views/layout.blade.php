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

    @yield('css')
    {{-- @livewireStyles --}}
</head>
<body>
    @yield('content')
   
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    {{-- @livewireScripts --}}

    @yield('script')
<script>
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#content').on('keyup',function(){
        let content = $("#content").val();
        let slug = "{{ request('slug')}}" ;

        function timer(){
            $.ajax({
                type: "post",
                url: "{{route('update-content')}}",
                data: {content , slug},
                success: function (data) { 
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }        
        setTimeout(timer,2000);   
    });

    function addPassword(){
        let password = $("#password").val();
        let slug = "{{ request('slug')}}" ;
        $.ajax({
            type: "post",
            url: "{{route('add-password')}}",
            data: {password , slug},
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
        let slug = "{{ request('slug')}}" ;
        $.ajax({
            type: "post",
            url: "{{route('remove-password')}}",
            data: {slug},
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
</script>
</body>
</html>