<form method="post" action="{{ url("/changeUser/{$user->id}") }}">
    @csrf
    @method('post')     
        
    @if ($user->id != auth()->id() && App\User::hasPermissions("User Activate"))
        <button type="button" class="btn btn-link" data-original-title="" title="" onclick="
            return swal({
                text: '{{ __('Are you sure you want to recover this user?') }}',
                showCancelButton: true,
                confirmButtonText: '{{ __('Yes') }}',
                cancelButtonText: '{{ __('No, ¡Cancel!') }}',
                confirmButtonClass: 'btn btn-info',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then((result) => {
                if (result.value) {
                  submit();
                }
            });">
            <i class="material-icons">autorenew</i>
            <div class="ripple-container"></div>
        </button>
        @endif
</form>
