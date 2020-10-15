
<form method="post" action="{{ route('role.destroy', $role) }}">
    @csrf
    @method('delete')    
    
    <a rel="tooltip" class="btn btn-link" href="{{ route('role.edit', $role) }}" data-original-title="" title="">
        <i class="material-icons">edit</i>
        <div class="ripple-container"></div>
    </a>
    
    @if ($role->users()->count()==0)
        <button type="button" class="btn btn-link" data-original-title="" title="" onclick="
            return swal({
                text: '{{ __('Are you sure you want to delete this role?') }}',
                showCancelButton: true,
                confirmButtonText: '{{ __('Yes, Delete!') }}',
                cancelButtonText: '{{ __('No, ¡Cancel!') }}',
                confirmButtonClass: 'btn btn-info',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then((result) => {
                if (result.value) {
                  submit();
                }
            });">
            <i class="material-icons">close</i>
            <div class="ripple-container"></div>
        </button>
        @else
        <button type="button" class="btn btn-link" data-original-title="" title="{{__('This role cannot be deleted because there are users with this role')}}">
            <i class="material-icons">not_interested</i>
            <div class="ripple-container"></div>
        </button>
        @endif
</form>


