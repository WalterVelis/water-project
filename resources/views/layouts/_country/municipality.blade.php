<select class="form-control" name="municipality" id="in-municipality">
    {{-- <option readonly selected>{{ __('Seleccione...') }}</option> --}}
    @foreach($municipality as $item)
    <option value="{{ $item->municipio->municipio }}"> {{ $item->municipio->municipio }} </option>
    @endforeach
</select>

<script>
    $(function () {

        preload();

    });
</script>
