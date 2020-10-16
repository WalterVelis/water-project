@extends('layouts.app', [
  'class' => 'off-canvas-sidebar',
  'classPage' => 'login-page',
  'activePage' => 'login',
  'title' => __('Balassa Films'),
  'pageBackground' => asset("img").'/agua-fondo-3.png'
])
{{-- Change logo-bf.webp to log-black.png --}}

@section('content')
<div class="container" style="padding: -120px">
  <div class="row justify-content-center">
    <img src="{{asset("material").'/img/licons/agua-logo-1.png'}}" width="15%">
  </div>

    <div class="row">
      <div class="col-md-9 ml-auto mr-auto mb-1 text-center">
        <h3 style="font-weight: bold">{{ __('app.welcome') }} </h3>
      </div>
    </div>    

    <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
        <form class="form" id="formLogin" method="POST" action="{{ route('login') }}">{{--Add a id to submit whithout button--}}
          @csrf
          <input type="hidden" id="tokenLogin" value="{{csrf_token()}}">

          <div class="card card-login card-hidden">
            {{-- <div class="card-header card-header-rose text-center">
              <h4 class="card-title">{{ __('Login') }}</h4>
            </div> --}}
            <div class="card-body ">
              <br>
              <div class="d-flex justify-content-center">
                <h3 class="card-title" style="color: #0b6696">{{ __('Login') }}</h3>
              </div>              
              <div id='loadingTime' class="loaderSpinnerLogin d-none"></div>
              <div id='dataLogin' class="">
              <span class="form-group  bmd-form-group email-error {{ $errors->has('email') ? ' has-danger' : '' }}" >
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons" style="color:#212121">email</i>
                    </span>
                  </div>
                  <input type="email" class="form-control" id="exampleEmails" name="email" placeholder="{{ __('Email') }}..." value="{{ old('email') }}" required>
                  @include('alerts.feedback', ['field' => 'email'])
                </div>
              </span>
              <span class="form-group bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons" style="color:#212121">lock_outline</i>
                    </span>
                  </div>
                  <input type="password" class="form-control" id="examplePassword" name="password" placeholder="{{ __('Password') }}..." required>
                  @include('alerts.feedback', ['field' => 'password'])
                </div>
              </span>
            </div>

              <div id="tokenDiv" class="input-group d-none">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons" style="color:#212121">security</i>
                  </span>
                </div>
                <input autocomplete="off" type="text" class="form-control" id="input-token" name="toke-req" placeholder="{{ __('Token Confirmation') }}...">
                <input type="hidden" class="form-control" id="input-token-hidden" name="toke-req-hidden" value="">
                <input type="hidden" class="form-control" id="input-status-token" name="toke-status-token" value="">
              </div>              
              
              

              {{-- <div class="form-check mr-auto ml-3 mt-3">
                  <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember me') }}
                    <span class="form-check-sign">
                      <span class="check"></span>
                    </span>
                  </label>
                </div> --}}
            </div>
            <div id="divP1" class="card-footer justify-content-center">
              <p onclick="checkDoubleFactor();" class="btn btn-rose btn-lg btn-round">{{ __('Lets Go') }}</p>
            </div>
            <div id="divP2" class="card-footer justify-content-center d-none">
              <p onclick="doubleFactorValidation();" class="btn btn-rose btn-lg btn-round">{{ __('Lets Go') }}</p>
            </div>{{--This gonna be submit while exist--}}
            {{-- <div class="card-footer justify-content-center d-none">
              <button id="loginBtn" type="submit" class="btn btn-rose btn-link btn-lg">{{ __('Lets Go') }}</button>
            </div> --}}
          </div>
        </form>
        <div class="row">
          <div class="col-6">
              @if (Route::has('password.request'))
                  <a href="{{ route('password.request') }}" class="text-light">
                      <small>{{ __('Forgot password?') }}</small>
                  </a>
              @endif
          </div>
          <h1 id='msjEmail' class="d-none">@lang('The confirmation token was sent to the email')</h1>
          <h1 id='msjEmailError' class="d-none">@lang('A conflict occurred when sending the email.')</h1>
          <h1 id='msjToken' class="d-none">@lang('That confirmation token is not valid')</h1>
          <h1 id='msjTokenGoogle' class="d-none">@lang('Enter the code generated by the application')</h1>          
          {{-- <div class="col-6 text-right">
              <a href="{{ route('register') }}" class="text-light">
                  <small>{{ __('Create new account') }}</small>
              </a>
          </div> --}}
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
<script>
  $(document).ready(function() {
    md.checkFullPageBackgroundImage();
    setTimeout(function() {
      // after 1000 ms we add the class animated to the login/register card
      $('.card').removeClass('card-hidden');
    }, 700);
  });
</script>

<script>
  // Capture the event "enter" 
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input').forEach( node => node.addEventListener('keypress', e => {
      if(e.keyCode == 13 && !$("#divP1").hasClass("d-none")) {
        checkDoubleFactor(); //Function when divP1 is showing
      }
      if(e.keyCode == 13 && !$("#divP2").hasClass("d-none")) {
        doubleFactorValidation(); //Function when divP2 is showing
      }
    }))
  });
</script>






@endpush
