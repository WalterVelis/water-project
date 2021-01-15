<select class="state form-control" name="state" id="in-state">
    {{-- <option readonly selected>{{ __('Seleccione...') }}</option> --}}
    @foreach($state as $item)
    <option value="{{ $item->id }}"> {{ $item->estado }} </option>
    @endforeach
</select>

<script>
    $('.state').on('change', function () {

        id = $(this).val();
        // console.log($(this).val());
        // console.log($(this).html());
        va = $("#in-state option[value='"+id+"']").text()
        $('#current-value').val(va);
        // $('#municipality').load('/municipality/'+id)
        preload();

    });

    $(function () {
        // cid = $("#state").children("option:selected").val();
        cid = $("#in-state").children().val();
        // state = $("#in-state").children().html();
        $('#municipality').load('/municipality/'+cid)

        // preload();

    });
</script>
