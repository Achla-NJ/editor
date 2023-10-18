@extends('layout')
@section('content')
<div class="container">
    <div class="row text-center mt-5">  
        <div class="col-md-12">
            <p class="fa-2xl primary-font-color"><i class="fa-solid fa-lock"></i></p>
            <form action="{{route('signin')}}" method="post">
                @csrf
                <input type="text" name="password" id="password" class="modal-password py-2 my-2 w-auto" placeholder="Password">   
                <input type="hidden" name="slug"  value="{{$slug}}">  <br>       
                <button type="submit" class="main-btn py-2 px-4">Login</button>       
            </form>
            <p class="mt-3 "><a href="{{ route('index')}}" class="primary-font-color"><i class="fa-solid fa-arrow-left me-2"></i>Go Back to Notepad</a></p>
        </div>
    </div>
   
</div>
@endsection