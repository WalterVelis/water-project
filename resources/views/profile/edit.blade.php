@extends('layouts.app', ['activePage' => 'profile-edit', 'menuParent' => 'profile', 'titlePage' => __('User Profile')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        @if (auth()->user()->change_password == 1)


        <div class="card">
            <div class="card-header card-header-icon card-header-rose">
                <div class="card-icon" style="">
              <i class="material-icons">person</i>
            </div>
            <h4 class="card-title">{{ __('Edit Profile') }}
            </h4>
          </div>
          <div class="card-body text-center">
            <form method="post" enctype="multipart/form-data" action="{{ route('profile.update') }}" autocomplete="off" class="form-horizontal">
              @csrf
              @method('put')

              <div class="row">
                <label class="col-sm-3 col-form-label">{{ __('Profile photo') }}</label>
                <div class="col-sm-7">
                  <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                    <div class="fileinput-new thumbnail img-circle">
                      @if (auth()->user()->picture)
                        <img src="{{ auth()->user()->profilePicture() }}" alt="...">
                      @else
                        <img src="{{ asset('material') }}/img/placeholder.jpg" alt="...">
                      @endif
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
                    <div>
                      <span class="btn btn-rose btn-file">
                        <span class="fileinput-new">{{ __('Select image') }}</span>
                        <span class="fileinput-exists">{{ __('Change') }}</span>
                        <input type="file" name="photo" id = "input-picture" />
                      </span>
                        <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> {{ __('Remove') }}</a>
                    </div>
                    @include('alerts.feedback', ['field' => 'photo'])
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-3 col-form-label">{{ __('Name') }}</label>
                <div class="col-sm-7">
                  <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->name) }}" aria-required="true"/>
                    @include('alerts.feedback', ['field' => 'name'])
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-3 col-form-label">{{ __('Email') }}</label>
                <div class="col-sm-7">
                  <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->email) }}"/>
                    @include('alerts.feedback', ['field' => 'email'])
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-rose btn-lg btn-round pull-right">{{ __('Update Profile') }}</button>
              <div class="clearfix"></div>
            </form>
          </div>
        </div>

        @endif

        <div class="card">
          <div class="card-header card-header-icon card-header-rose">
            <div class="card-icon" style="">
                <i class="material-icons">lock</i>
              </div>
            <h4 class="card-title">{{ __('Change password') }}</h4>
          </div>
          <div class="card-body text-center">
            <form method="post" action="{{ route('profile.password') }}" class="form-horizontal">
              @csrf
              @method('put')

              <div class="row">
                <label class="col-sm-4 col-form-label" for="input-current-password">{{ __('Current Password') }}</label>
                <div class="col-sm-6">
                  <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" input type="password" name="old_password" id="input-current-password" placeholder="{{ __('Current Password') }}" value=""/>
                    @include('alerts.feedback', ['field' => 'old_password'])
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-4 col-form-label" for="input-password">{{ __('New Password') }}</label>
                <div class="col-sm-6">
                  <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="input-password" type="password" placeholder="{{ __('New Password') }}" value=""/>
                    @include('alerts.feedback', ['field' => 'password'])
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-4 col-form-label" for="input-password-confirmation">{{ __('Confirm New Password') }}</label>
                <div class="col-sm-6">
                  <div class="form-group">
                    <input class="form-control" name="password_confirmation" id="input-password-confirmation" type="password" placeholder="{{ __('Confirm New Password') }}" value=""/>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-rose btn-lg btn-round pull-right">{{ __('Change password') }}</button>
              <div class="clearfix"></div>
            </form>
          </div>
        </div>

      </div>

      @if(!auth()->user()->change_password)
      <div class="col-md-4" style="display: block; margin-right: auto; margin-left: auto">
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <i class="material-icons">close</i>
            </button>
            <span>
              <b>{{__('Alert')}} - </b>{{__('Password needs to be updated')}}</span>
          </div>
      </div>
      @endif

      {{-- @if (auth()->user()->change_password == 1)
      <div class="col-md-4">
        <div class="card card-profile">
          <div class="card-body">
            <br><br><br>
            <div class="card-avatar">
              <img class="img" src="{{ auth()->user()->profilePicture() }}" />
          </div>
          <br><br>
          </div>
        </div>



      </div>
      @endif --}}

    </div>
  </div>
  <footer class="footer">
    <div class="container-fluid">
        <div class="copyright "> &copy; <script> document.write(new Date().getFullYear()) </script> Cotizador AguaH2O, Todos los derechos reservados. Desarrollado por ISINET.</div>
    </div>
</footer>
</div>
@endsection
