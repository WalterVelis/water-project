<form method="post" action="{{ url("/changeUser/{$user->id}") }}">
    @csrf
    @method('post')
        
    @if (App\User::hasPermissions("User Update"))
    <a rel="tooltip" class="btn btn-link" href="{{ route('user.edit', $user) }}" data-original-title="" title="">
        <i class="material-icons">edit</i>
        <div class="ripple-container"></div>
    </a>
    @endif
    
    @if ($user->id != auth()->id() && App\User::hasPermissions("User Deactivate"))
    <a rel="tooltip" class="btn btn-link"  href="#" onclick="pressResetData({{$user->id}});">
        <i class="material-icons">email</i>
        <div class="ripple-container"></div>
    </a> 
        <button type="button" class="btn btn-link" data-original-title="" title="" onclick="
            return swal({
                text: '{{ __('Are you sure you want to delete this user?') }}',
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
            <i class="material-icons">close</i>
            <div class="ripple-container"></div>
        </button>
        @endif
</form>



<form class="d-none" method="post" action="{{ url("email2reset/{$user->id}") }}">
    @csrf
    @method('post')
    <button id="btnResetData{{$user->id}}" type="button" class="btn btn-link" data-original-title="" title="" onclick="
    return swal({
        text: '{{ __('The information will be sent again and the security and password settings will be reset') }}',
        showCancelButton: true,
        confirmButtonText: '{{ __('Yes, Send!') }}',
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
    </form>


