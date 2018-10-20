@foreach(['success','danger','info','warning'] as $type)
    @if(session()->has($type))
        <div class="alert alert-{{ $type }}" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h2>
                @if($type==='success')<span class="glyphicon glyphicon-ok"></span>
                @elseif($type==='danger')<span class="glyphicon glyphicon-remove"></span>
                @else<span class="glyphicon glyphicon-exclamation-sign"></span>
                @endif
                {{ session()->get($type) }}
            </h2>
        </div>
    @endif
@endforeach
