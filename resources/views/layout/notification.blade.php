@foreach ($notifications as $n)
    <div class="my-2" style="padding: 4px 14px;">
        <span>{!! $n->msg !!}</span>
    </div>
    <hr>
@endforeach
