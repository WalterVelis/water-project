@extends('layouts.app', ['activePage' => 'user-management', 'menuParent' => 'user', 'titlePage' => __('User Management')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            @include('message.errors')
        </div>
        <div class="row">
            <div class="col-md-8">
                <form method="post" enctype="multipart/form-data" action="{{ route('user.update', $user) }}"
                    autocomplete="off" class="form-horizontal">
                    @csrf
                    @method('put')
                    <input type="hidden" id='formType' value='formEdit'>
                    <input type="hidden" id="oldEmailUser" value="{{$user->email}}">

                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">person</i>
                            </div>
                            <h4 class="card-title">{{ __('Edit User') }}</h4>
                        </div>
                        <div class="card-body text-center">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Profile photo') }}</label>
                                <div class="col-sm-7">
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail img-circle">
                                            @if ($user->picture)
                                            <img src="{{ $user->profilePicture() }}" alt="...">
                                            @else
                                            <img src="{{ asset('material') }}/img/placeholder.jpg" alt="...">
                                            @endif
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
                                        <div>
                                            <span class="btn btn-rose btn-file">
                                                <span class="fileinput-new">{{ __('Select image') }}</span>
                                                <span class="fileinput-exists">{{ __('Change') }}</span>
                                                <input type="file" name="photo" id="input-picture" />
                                            </span>
                                            <a href="#" class="btn btn-danger btn-round fileinput-exists"
                                                data-dismiss="fileinput"><i class="fa fa-times"></i>
                                                {{ __('Remove') }}</a>
                                        </div>
                                        @include('alerts.feedback', ['field' => 'photo'])
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            name="name" id="input-name" type="text" placeholder="{{ __('Name') }}"
                                            value="{{ old('name', $user->name) }}" required />
                                        <span id="errorNameUser" class="d-none">@lang('The name field cannot be
                                            empty')</span>
                                        @include('alerts.feedback', ['field' => 'name'])
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                        <input onkeyup="emailUnique();"
                                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            name="email" id="input-email" type="email" placeholder="{{ __('Email') }}"
                                            value="{{ old('email', $user->email) }}" required />
                                        <span id="errorEmailU" class="d-none">@lang('This email already exists')</span>
                                        <span id="errorEmailUserXX" class="d-none">@lang('The email field cannot be
                                            empty')</span>
                                        @include('alerts.feedback', ['field' => 'email'])
                                    </div>
                                </div>
                            </div>

                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Role') }}</label>
                            <div class="col-sm-7">
                                <div class="form-group{{ $errors->has('role_id') ? ' has-danger' : '' }}">
                                    <select {{$isVendor}} onchange="roleDetection();"
                                        class="js-example-basic-single js-states form-control" style="width: 100%"
                                        id="" name="role_id" data-style="select-with-transition" title=""
                                        data-size="100" required>
                                        <option value="">{{ __('Choose a role') }}</option>
                                        @foreach ($roles as $role)
                                        <option value="{{$role->id}}" @if ($user->role_id ==$role->id)
                                            selected="selected" @endif>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <span id="errorRoleUser" class="d-none">@lang('The email field cannot be
                                        empty')</span>
                                    @include('alerts.feedback', ['field' => 'role_id'])
                                </div>
                            </div>
                        </div>

                        @if ( $user->role->name == 'Vendor' )
                        <input type="hidden" name="role_id" id="role_id" value="{{$user->role_id}}">
                        @endif

                        {{-- @if ($vendorStatus->is_status_approved == "1")
              <input type="hidden" name="role_id" id="role_id" value="{{$user->role_id}}">
                        @endif --}}


                        <div id="vendorDiv" class="row {{$classVendor}}">
                            <label class="col-sm-2 col-form-label">{{ __('Vendor Type') }}</label>
                            <div class="col-sm-7">
                                <div class="form-group form-check-inline">
                                    {{-- @if ($vendorStatus->is_external == "1")

                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" id="radio1X" type="radio" name="is_external"
                                                value="0">@lang('Internal Vendor')
                                            <span class="circle">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" id="radio2X" type="radio" name="is_external"
                                                value="1" checked>@lang('External Vendor')
                                            <span class="circle">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>

                                    @endif --}}

                                    {{-- @if ($vendorStatus->is_external == "0")

                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" id="radio1X" type="radio" name="is_external"
                                                value="0" checked>@lang('Internal Vendor')
                                            <span class="circle">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" id="radio2X" type="radio" name="is_external"
                                                value="1">@lang('External Vendor')
                                            <span class="circle">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>

                                    @endif

                                    @if ($vendorStatus->is_external == "2")

                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" id="radio1X" type="radio" name="is_external"
                                                value="0">@lang('Internal Vendor')
                                            <span class="circle">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" id="radio2X" type="radio" name="is_external"
                                                value="1">@lang('External Vendor')
                                            <span class="circle">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>

                                    @endif --}}


                                </div>
                                <div class="row">

                                    <span id="errorVendor" class="d-none">@lang('You must select a vendor type')</span>
                                </div>




                            </div>

                        </div>

                        <div class="row d-none">
                            <input type="text" id="rol-text" name="rol-text" value="{{ $user->role->name }}">
                        </div>
                        {{-- <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-password">{{ __('Password') }}</label>
                        <div class="col-sm-7">
                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" input
                                    type="password" name="password" id="input-password"
                                    placeholder="{{ __('Password') }}" />
                                @include('alerts.feedback', ['field' => 'password'])
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label"
                            for="input-password-confirmation">{{ __('Confirm Password') }}</label>
                        <div class="col-sm-7">
                            <div class="form-group">
                                <input class="form-control" name="password_confirmation"
                                    id="input-password-confirmation" type="password"
                                    placeholder="{{ __('Confirm Password') }}" />
                            </div>
                        </div>
                    </div>--}}
            </div>
            <input type="hidden" name="created_by" value="{{auth()->user()->id}}">
            <div class="card-footer d-flex flex-row-reverse" style="    justify-content: end;">
                <p onclick="validationSaveUpdate();" class="btn btn-primary btn-lg">{{ __('Save') }}</p>
                <a href="{{ route('user.index') }}" class="btn btn-rose btn-lg">{{ __('Cancelar') }}</a>
                <button id="saveUser" type="submit" class="btn btn-rose btn-lg d-none">{{ __('Save') }}</button>

                {{-- @if ($vendorStatus->is_status_approved == "0")

                <button id="saveUser2" type="button" class="d-none" data-original-title="" title="" onclick="
            return swal({
                title: '{{ __('Warning') }}',
                text: '{{ __('Creating a vendor user will send an email with instructions for filling up their vendor profile, are you sure you want to create a vendor user?') }}',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __('Yes, Send!') }}',
                cancelButtonText: '{{ __('No, ¡Cancel!') }}',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then((result) => {
                if (result.value) {
                  submit();
                }
            });">
                    {{ __('Save') }}
                </button>

                @else

                <button id="saveUser2" type="submit" class="btn btn-rose d-none">{{ __('Save') }}</button>

                @endif --}}





            </div>
        </div>

        </form>
        <h1 id="sameValue" class="d-none">{{$user->role->name}}</h1>
    </div>
</div>
</div>
<footer class="footer">
    <div class="container-fluid">
        <div class="copyright "> &copy; <script> document.write(new Date().getFullYear()) </script> Cotizador de AguaH2O, Todos los derechos reservados. Desarrollado por ISINET.</div>
    </div>
</footer>
</div>
@endsection


@push('js')

<script>
    document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input').forEach( node => node.addEventListener('keypress', e => {
      if(e.keyCode == 13) {
        e.preventDefault();
      }
    }))
  });
</script>

<script>
    //role_input
  $("#role_input").select2({
      language: {
          noResults: function() {
              return "{{__('No results found')}}";
          },
          searching: function() {
            return "{{__('Searching')}}...";
          }
      },
      theme: "classic",
  })
</script>

@endpush
