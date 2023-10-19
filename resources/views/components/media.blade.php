@foreach ($page->files as $item)
    <div class="col-md-3 my-3">
        <img src="{{asset('storage/'.$item->file)}}" class="w-100" />
        <a download href="{{asset('storage/'.$item->file)}}">Download</a>
        <a href="javascript:void(0)" onclick="removeFile('{{$item->id}}')">Delete</a>
    </div>
@endforeach


