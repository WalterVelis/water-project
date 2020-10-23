<select class="form-control" name="municipality">
    <option readonly selected>{{ __('Choose...') }}</option>
    @foreach($municipality as $item)
    <option value="{{ $item->id }}"> {{ $item->municipio->municipio }} </option>
    @endforeach
</select>
