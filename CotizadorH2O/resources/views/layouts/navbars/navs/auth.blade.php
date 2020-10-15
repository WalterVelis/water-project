<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
    <div class="container-fluid">
      <div class="navbar-wrapper">
        <div class="navbar-minimize">
          <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
            <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
            <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
          </button>
        </div>
        <a class="navbar-brand" href="#pablo">{{ $titlePage }}</a>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
      </button>   
      <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <button class="btn btn-primary btn-round btn-fab btn-topbar"><i class="material-icons">notifications</i></button>
              @php
              $notificacions=App\Notification::countNotificationActive();
              @endphp
              @foreach ($notificacions as $item)
              @if ($item->notifications == 0)                  
              @else
              <span class="notification">{{$item->notifications}}</span>                  
              @endif                                
              @endforeach              
              <p class="d-lg-none d-md-block">
                {{ __('Notifications') }}
              </p>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              @php
              $notificacionsInfo=App\Notification::textNotificationActive();              
              @endphp
              @if (count($notificacionsInfo) == 0)
              <a class="dropdown-item disabled" href="#">{{ __("You don't have any system notifications") }}</a>                  
              @else
              @foreach ($notificacionsInfo as $item)
              @php
                  $textOnclick = '';
              @endphp
              @if ($item->action == 'Approve Vendor')
                  @php
                  $textOnclick = 'onclick=createVariableFilter();';
                  @endphp
              @endif
              <a class="dropdown-item" {{$textOnclick}} href="{{$item->action_url}}">@lang($item->description) &nbsp;&nbsp;&nbsp;<span class="notification">{{$item->total}}</span></a>
              @endforeach                   
              @endif                           
            </div>
          </li>
          <li class="nav-item dropdown">
              <a class="nav-link" href=""  onclick="urlCurrent();" >
                <button class="btn btn-primary btn-round btn-fab btn-topbar">
                <i class="material-icons">feedback</i></button>
              <p class="d-lg-none d-md-block">
                  {{ __('Help') }}
              </p>              
            </a>
            <a  id="urlHelp" class="btn btn-primary d-none" target="_blank">help</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <button class="btn btn-primary btn-round btn-fab btn-topbar">
              <i class="material-icons">person</i></button>
              <p class="d-lg-none d-md-block">
                  {{ __('Account') }}
              </p>
            </a>
            <div class="dropdown-menu dropdown-menu-right viewConnection" aria-labelledby="navbarDropdownProfile">
                <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item logButton" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Log out') }}</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->