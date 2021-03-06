@extends('layouts.app', ['activePage' => 'user-management', 'menuParent' => 'user', 'titlePage' => __('User Management')])
@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8">
          <form method="post" enctype="multipart/form-data" action="{{ route('user.store') }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('post')
            <input type="hidden" id='formType' value='formCreate'>

            <div class="card ">
              <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">supervisor_account</i>
                </div>
                <h4 class="card-title">{{ __('Add User') }}</h4>
              </div>
              <div class="card-body  text-center">
                <div class="row">
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Profile photo') }}</label>
                  <div class="col-sm-7">
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                      <div class="fileinput-new thumbnail img-circle">
                        <img src="{{ asset('material') }}/img/placeholder.jpg" alt="...">
                      </div>
                      <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
                      <div>
                        <span class="btn btn-primary btn-file" style="width: 150px;">
                          <span style="color:white!important;" class="fileinput-new">{{ __('Seleccionar') }}</span>
                          <span style="color: white;" class="fileinput-exists">{{ __('Change') }}</span>
                          <input type="file" name="photo" id = "input-picture" />
                        </span>
                          <a style="width: 150px;" href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"> {{ __('Remove') }}</a>
                      </div>
                      @include('alerts.feedback', ['field' => 'photo'])
                    </div>
                  </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12" style="    text-align: left;">
                        <b><label style="    font-weight: 600;" class="">{{ __('Nombre de usuario') }}</label></b>
                        <div style="text-align:left;" class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                          <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" ="{{ __('Name') }}" value="{{ old('name') }}" required />
                          <span id="errorNameUser" class="d-none" style="text-align:left;">@lang('Campo obligatorio')</span>
                          @include('alerts.feedback', ['field' => 'name'])
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12" style="    text-align: left;">
                            <b><label style="    font-weight: 600;" class=" col-form-label">{{ __('Correo electrónico') }}</label></b>
                        <div style="text-align:left;" class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                          <input onkeyup="emailUnique();" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" ="{{ __('Email') }}" value="{{ old('email') }}" required />
                          <span id="errorEmailU" class="d-none">@lang('This email already exists')</span>
                          <span id="errorEmailUserXX" class="d-none" style="text-align:left;">@lang('Campo obligatorio')</span>
                          @include('alerts.feedback', ['field' => 'email'])
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12" style="    text-align: left;">
                            <b><label style="font-weight: 600;" class=" col-form-label">{{ __('Teléfono') }}</label></b>
                        <div style="text-align:left;" class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                          <input class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" id="input-phone" type="phone" ="{{ __('phone') }}" value="{{ old('phone') }}" required />
                          <span id="errorphoneU" class="d-none">@lang('This phone already exists')</span>
                          <span id="errorPhoneXX" class="d-none" style="text-align:left;">@lang('Campo obligatorio')</span>
                          @include('alerts.feedback', ['field' => 'phone'])
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div style="text-align:left;" class="col-sm-12" style="    text-align: left;">
                            <b><label style="font-weight: 600;" class=" col-form-label">{{ __('Role') }}</label></b>
                        <div class="form-group{{ $errors->has('role_id') ? ' has-danger' : '' }}">
                          <select class="js-example-basic-single js-states form-control" style="width: 100%" id="role_input" name="role_id" data-style="select-with-transition" title="" data-size="100" required>
                            <option disabled selected value="">Seleccione una opción</option>
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{ $role->name }}</option>
                            @endforeach
                          </select>
                          <span id="errorRoleUser" class="d-none" style="text-align:left;    transform: translateY(35px); display: block;">@lang('Campo obligatorio')</span>
                          @include('alerts.feedback', ['field' => 'role_id'])
                        </div>
                      </div>
                    </div>
                </div>
                <br></br>

                <div id="vendorDiv" class="row d-none">
                  <label class="col-sm-2 col-form-label">{{ __('Vendor Type') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group form-check-inline">

                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" id="radio1X" type="radio" name="is_external" value="0">@lang('Internal Vendor')
                          <span class="circle">
                            <span class="check"></span>
                          </span>
                        </label>
                      </div>
                      <div class="form-check">
                        <label class="form-check-label">
                          <input class="form-check-input" id="radio2X" type="radio" name="is_external" value="1">@lang('External Vendor')
                          <span class="circle">
                            <span class="check"></span>
                          </span>
                        </label>
                      </div>
                    </div>
                    <div class="row">

                      <span id="errorVendor" class="d-none">@lang('You must select a vendor type')</span>
                    </div>




                    </div>

                  </div>

                  <div class="row d-none">
                    <input type="text" id="rol-text" name="rol-text" value="">
                  </div>
                {{-- <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-password">{{ __('Password') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" input type="password" name="password" id="input-password" ="{{ __('Password') }}" />
                      @include('alerts.feedback', ['field' => 'password'])
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-password-confirmation">{{ __('Confirm Password') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="password_confirmation" id="input-password-confirmation" type="password" placeholder="{{ __('Confirm Password') }}" />
                    </div>
                  </div>
                </div>--}}
              </div>
              <input type="hidden" name="change_password" value="0">
              <input type="hidden" name="created_by" value="{{auth()->user()->id}}">
              <div class="card-footer d-flex flex-row-reverse" style="justify-content: end;">
                  <p onclick="validationSave();" class="btn btn-primary btn-lg">{{ __('Save') }}</p>
                  <a href="{{ route('user.index') }}" class="btn-rose btn btn-lg">{{ __('Cancelar') }}</a>
                <button id="saveUser" type="submit" class="btn btn-rose btn-round btn-lg d-none">{{ __('Save') }}</button>

                <button id="saveUser2" type="button" class="d-none" data-original-title="" title="" onclick="
            return swal({
                title: '{{ __('Warning') }}',
                text: '{{ __('Creating a vendor user will send an email with instructions for filling up their vendor profile, are you sure you want to create a vendor user?') }}',
                type: 'warning',
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
            {{ __('Save') }}
        </button>



              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <footer class="footer">
        <div class="container-fluid">
            <div class="copyright "> &copy; <script> document.write(new Date().getFullYear()) </script> Cotizador AguaH2O, Todos los derechos reservados. Desarrollado por ISINET.</div>
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
//   $("#role_input").select2({
//       language: {
//           noResults: function() {
//               return "{{__('No results found')}}";
//           },
//           searching: function() {
//             return "{{__('Searching')}}...";
//           }
//       },
//       theme: "classic",
//   })
</script>

@endpush
