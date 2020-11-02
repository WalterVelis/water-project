
<form method="post" action="{{ route('budgetaccount.destroy', $account) }}">
    @csrf
    @method('delete')    
    @if(App\User::hasPermissions("Budget Update Account"))
    <a rel="tooltip" class="btn btn-success" href="{{ route('budgetaccount.edit', $account) }}" data-original-title="" title="">
        <i class="material-icons">edit</i>
        <div class="ripple-container"></div>
    </a>
    @endif
    
    @if ($account->budgetVendorAccounts->count()==0 && App\User::hasPermissions("Budget Delete Account"))
        <button type="button" class="btn btn-danger" data-original-title="" title="" onclick="
            return swal({
                text: '{{ __('Are you sure you want to delete this account?') }}',
                showCancelButton: true,
                confirmButtonText: '{{ __('Yes, Delete!') }}',
                cancelButtonText: '{{ __('No, ¡Cancel!') }}',
                confirmButtonClass: 'btn btn-success',
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
        <button type="button" class="btn btn-danger" data-original-title="" title="{{__('This account cannot be deleted because there are sub-accounts with this account')}}">
            <i class="material-icons">not_interested</i>
            <div class="ripple-container"></div>
        </button>
        @endif
</form>


