@extends('layouts.app', ['activePage' => 'profile-security', 'menuParent' => 'profile', 'titlePage' => __('Security Configuration')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">lock</i>
                </div>
                <h4 class="card-title">
                    {{ __('Double Factor Authentication') }}</h4>
              </div>
              <div class="card-body">
                <h1 id='msjEmail' class="d-none">@lang('The confirmation token was sent to the email')</h1>
          <h1 id='msjEmailError' class="d-none">@lang('A conflict occurred when sending the email.')</h1>
          <h1 id='msjToken' class="d-none">@lang('That confirmation token is not valid')</h1>
                  <div class="row">
                    <div class="col-12 text-right">
                        {{-- <a href="{{ route('budgetsection.create') }}" class="btn btn-sm btn-rose">{{ __('Add Section') }}</a> --}}
                    </div>
                  </div>
                  <h1 id='msjError' class="d-none">@lang('That confirmation token is not valid')</h1>
                  @if ( (auth()->user()->activate_2fa == false) && (auth()->user()->activate_2fa_google == false) )
                  <div class="row">
                    <div class="col-6">
                        <div class="card-body text-center">
                            <p onclick="showByEmail();" class="btn btn-rose btn-lg btn-round"><i class="fa fa-send"></i>&nbsp;&nbsp;@lang('By e-mail')</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card-body text-center">
                            <p onclick="showByGoogle();" class="btn btn-rose btn-lg btn-round"><i class="fa fa-google"></i>&nbsp;&nbsp;@lang('By google authentication')</p>
                        </div>
                    </div>
                  </div>
                  <br><br>
                    <div id='loadingTime' class="loaderSpinner d-none"></div>

                  <div id="2fa-byEmail" class="row d-none">

                        <div class="card-body text-center">
                            <h2>@lang('Double Factor Authentication') @lang('By e-mail')</h2>
                        </div>
                      <div class="col-12" style="margin-left: 50px">
                        <form method="post" enctype="multipart/form-data" action="{{ route('doubleFactorEmail') }}" autocomplete="off" class="form-horizontal">
                            @csrf
                            @method('post')
                            <div class="row">
                              <label class="col-2 col-form-label">{{ __('Authentication Email') }}</label>
                              <div class="col-7">
                                <div class="form-group">
                                  <input class="form-control" name="email_2fa" id="input-email_2fa" type="email" placeholder="{{ __('Authentication Email') }}" value="{{ old('email_2fa', auth()->user()->email) }}" required/>
                                </div>
                              </div>
                            </div>
                            <div class="row d-none" id="divCodeEmail" >
                              <label class="col-2 col-form-label">{{ __('Verification Code') }}</label>
                              <div class="col-7">
                                <div class="form-group">
                                  <input class="form-control" name="code" id="code" type="text" placeholder="{{ __('Verification Code') }}"  required/>
                                </div>
                              </div>
                            </div>
                            <div class="row d-none" id="divLoadEmail">
                              <div id='loadingTime' class="loaderSpinnerLogin"></div>
                            </div>
                            <input type="hidden" name='activate_2fa' value='1'>
                            <br><br>
                            <div class="text-center">
                                <p id="activateEmail" onclick="sendEmailJs()" type="submit" class="btn btn-rose btn-lg btn-round">{{ __('Activate') }}</p>
                                <p id="activateEmailCode" onclick="verficateEmailCode()" type="submit" class=" d-none btn btn-rose btn-lg btn-round">{{ __('Activate') }}</p>
                                <button id="activeSecurity"  type="submit" class=" d-none btn btn btn-rose btn-lg btn-round">{{ __('Activate') }}</button>
                            </div>

                          </form>
                      </div>



                  </div>

                  <div id='2fa-byGoogle' class="row d-none">

                    <div class="card-body text-center">
                        <h2>@lang('Double Factor Authentication') @lang('By google authentication')</h2>
                    </div>
                    <br><br>
                  <div class="col-6" style="margin-left: 50px">
                    <form method="post" enctype="multipart/form-data" action="{{ route('activateGoogle') }}" autocomplete="off" class="form-horizontal">
                        @csrf
                        @method('post')
                        <input type="hidden" id="tokenQr" value="{{csrf_token()}}">
                        <div class="row">
                            <label class="col-sm-1 col-form-label">{{ __('QR') }}</label>
                            <div class="col-sm-5">
                              <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                <div class="fileinput-new thumbnail">
                                    <img id="imgQR" src="" alt="...">
                                </div>
                              </div>
                            </div>
                          </div>
                          <br><br>
                        <div class="row">
                          <label class="col-2 col-form-label">{{ __('Verification Code') }}</label>
                          <div class="col-4">
                            <div class="form-group">
                              <input class="form-control" name="code_verification" id="code_verification" type="text" placeholder="{{ __('Verification Code') }}" value='' required/>
                            </div>
                            <span id="errorCode" class="d-none">@lang('Campo obligatorio')</span>
                          </div>
                        </div>
                        <input type="hidden" name='activate_2fa_google' value='1'>
                        <br><br>
                        <div class="row">
                          <div class="col-6">
                            <div class="text-center">
                              <p onclick="googleValidate();" class="btn btn-rose btn-lg btn-round pull-right">{{ __('Activate') }}</p>
                              <button id='btn-google' type="submit" class="d-none ">{{ __('Activate') }}</button>
                          </div>
                          </div>
                        </div>
                      </form>
                  </div>

                  <div class="col-3" style="display: block; margin-top: auto; margin-bottom: auto;">
                    <p class="text-justify">@lang('To scan the code, you can use the following applications:')</p>
                    <ul class="nav">
                      <li class="nav-item">
                        <a class="nav-link" style="color:green" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" target="_blank">
                          <i class="material-icons">android</i>&nbsp;&nbsp;&nbsp;
                            <span class="sidebar-normal"> Android </span>
                          </a>
                      </li>
                      <br>
                      <li class="nav-item">
                        <a class="nav-link" style="color:#8e8e8e" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" target="_blank">
                          <i class="fa fa-apple" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;
                            <span class="sidebar-normal"> Apple </span>
                          </a>
                      </li>
                    </ul>
                  </div>

                  </div>




                  @else
                  <div class="card-body text-left">
                      <h2>@lang('You have active the:')</h2>
                  </div>
                  @if (auth()->user()->activate_2fa == "1")
                  <div class="card-body text-center">
                    <h2>@lang('Double Factor Authentication') @lang('By e-mail')</h2>
                    </div>
                  @else
                  <div class="card-body text-center">
                    <h2>@lang('Double Factor Authentication') @lang('By google authentication')</h2>
                </div>

                  @endif

              <div class="col-12">
                <form method="post" enctype="multipart/form-data" action="{{ route('doubleFactorDeactivate') }}" autocomplete="off" class="form-horizontal">
                    @csrf
                    @method('post')
                    <br><br>
                    <div class="text-center">

                        <button  type="button" class="btn btn-rose btn-lg btn-round" data-original-title="" title="" onclick="
            return swal({
                text: '{{ __('Are you sure you want to disable two-step authentication?') }}',
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
            {{ __('Deactivate') }}
        </button>



                    </div>

                  </form>
              </div>


                  @endif
              </div>
            </div>
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
      document.querySelectorAll('input[type=text]').forEach( node => node.addEventListener('keypress', e => {
        if(e.keyCode == 13) {
          e.preventDefault();
        }
      }))
    });
  </script>

@endpush
