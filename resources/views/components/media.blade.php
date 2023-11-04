@foreach ($page->files as $item)
    <div class="col-4 my-3">
        <img src="{{asset('storage/'.$item->file)}}" class="w-100" />
        <a download href="{{asset('storage/'.$item->file)}}"><i class="fa fa-download"></i></a>
        <a href="javascript:void(0)" onclick="removeFile('{{$item->id}}')"><i class="fa fa-trash"></i></a>
    </div>
@endforeach


