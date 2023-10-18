<div>
 
    <h1>{{ $content }}</h1>
    {{request('slug') }}
    
    <textarea name="" id="" class="form-control" wire:keydown.page-down="foo" wire:model.debounce.3000ms="content"
    wire:keyup="updateContent"></textarea>
</div>

      