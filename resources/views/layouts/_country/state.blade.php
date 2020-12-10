<select class="state form-control" name="state">
    <option readonly selected>{{ __('Seleccione...') }}</option>
    @foreach($state as $item)
    <option value="{{ $item->id }}"> {{ $item->estado }} </option>
    @endforeach
</select>

<script>
    $('.state').on('change', function () {

        id = $(this).val();
        $('#municipality').load('/municipality/'+id)

    });
</script>
