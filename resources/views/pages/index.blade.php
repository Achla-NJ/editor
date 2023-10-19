@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <section class="row navbar mt-4">
                <div class="col-md-6">
                    <img src="{{asset('assets/imgs/logo.png')}}" alt="" class="head-logo">
                </div>
                <div class="col-md-6 ">
                    <ul class="options d-flex justify-content-evenly">
                        <li><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editUrl"><i class="fa-solid fa-pen"></i></a></li>
                        <li><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa-solid fa-lock"></i></a></li>
                        
                        <li><a href="{{ route('index')}}"><i class="fa fa-plus"></i></a></li>
                        {{-- <li><a href=""><i class="fa-solid fa-user"></i></a></li> --}}
                    </ul>
                </div> 
            </section>
            
            <section class="row editor"> 
                <div class="col-md-12 p-0">
                        <textarea name="content" id="content" class="form-control" onkeyup="updateContent()" >{!! $page->content ?? '' !!}</textarea>
                </div>
            </section>
        </div>
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12" id="dropzone"> 

                    <form  class="dropzone" id="file-upload" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="page_id"  value="{{$page->id}}">  
                        <div class="dz-message">
                            Drag and Drop Single/Multiple Files Here<br>
                        </div>
                    </form>
                </div>
                <div class="row" id="media-wrapper">
                    <x-media :page="$page"/>
                </div>
            </div> 
        </div>
    </div> 
    
    {{-- Update Password --}}

    <div class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog   modal-dialog-centered">
            <div class="modal-content"> 
            <div class="modal-body">
                <div class="row text-center"> 
                    <div class="col-12 " id="add-password" style="display: {{ empty($page->password) ? ' block;' : ' none;'  }}">
                        <p class="modal-text">Add Password</p>
                        <input type="text" name="password" id="password" class="modal-password w-50" placeholder="Password">
                        <button type="button" class="main-btn" onclick="addPassword()">Save</button>
                        <button type="button" class="button main-btn" data-bs-dismiss="modal" >X</button>
                    </div>
                    <div class="col-md-12" id="remove-password" style="display: {{ !empty($page->password) ? ' block;' : ' none;'  }}">
                        <p class="modal-text">Password Options</p>
                        
                        <form action="{{route('logout')}}" method="post">
                            <button type="button" class="main-btn" onclick="removePassword()">Remove</button>
                            @csrf
                            <input type="hidden" name="slug"  value="{{$slug}}"> 
                            <button type="submit" class="button main-btn"  >Logout</button>
                            <button type="button" class="button main-btn" data-bs-dismiss="modal" >X</button>
                        </form>
                        
                    </div>
                    <div class="col-md-12 text-danger  mt-2" id="errorMessages"></div>
                </div>
                
                
            </div> 
            </div>
        </div>
    </div>

    {{-- update URL --}}

    <div class="modal fade " id="editUrl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editUrlLabel" aria-hidden="true">
        <div class="modal-dialog   modal-dialog-centered">
            <div class="modal-content"> 
            <div class="modal-body">
                <div class="row text-center"> 
                    <div class="col-12" >
                        <p class="modal-text">Change URL</p>
                        <form action="{{route('update-url')}}" method="post">
                            @csrf
                            <input type="hidden" name="slug"  value="{{$slug}}"> 
                            <input type="text" required name="url" value="{{$slug}}" id="url" class="modal-password w-50" placeholder="Password">
                            <button type="submit" class="main-btn">Change</button>
                            <button type="button" class="button main-btn" data-bs-dismiss="modal" >X</button>
                        </form>
                        
                    </div>
                    <div class="col-md-12 text-danger  mt-2" id="errorMessages"></div>
                </div>
                
                
            </div> 
            </div>
        </div>
    </div>
</div>
@endsection