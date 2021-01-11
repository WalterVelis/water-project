<style>
    .noti:hover a {
        background: none!important;
        color: #0b6696!important;
        box-shadow: none!important;
        font-weight: bold!important;
        transition: all ease 0.2s;
    }
</style>


@foreach ($notifications as $n)
    <div class="my-2" style="padding: 4px 14px;">
        <span class="noti">{!! $n->msg !!}</span>
    </div>
    <hr>
    @php($i = $loop->index + 1)
@endforeach

<script>
    $('#n-total').html("{{ $i }}");
</script>
