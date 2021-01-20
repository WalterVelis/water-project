<div class="sidebar viewConnection" style="background-color: #fafafa;color: #000;" data-color="rose" data-background-color="black">
  <!-- colores de fondo: 1- #32526f 2- #51809b 3- #7dabc3 4- #c9dbe7
    Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

    Tip 2: you can also add an image using data-image tag
-->
  <div class="logo">
    {{-- <a href="#" class="simple-text logo-mini">
      {{ __('BF') }}
    </a> --}}
    <center>
      <a href="/" class="simple-text logo-normal">
        <img src="{{asset('material/img/licons/agua-logo-1.png')}}" width="75%"/>
      </a>
    </center>
  </div>
  <div class="sidebar-wrapper" style="height: 70%">
    <div class="user">
      <div class="photo">
        <img src="{{ auth()->user()->profilePicture() }}" />
      </div>
      <div class="user-info">
        <a data-toggle="collapse" href="#collapseProfile"   class="username">
          <span style="white-space: initial;"> {{ auth()->user()->name }} <span style="display:block; font-weight: 400;">{{ auth()->user()->role->name }}</span> <b class="caret"></b> </span>
        </a>
        <div class="collapse{{ $menuParent == 'profile' ? 'aria-expanded=true' : '' }}" id="collapseProfile">
          <ul class="nav">
            <li class="nav-item {{ $activePage == 'profile-edit' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('profile.edit') }}">
                <span class="sidebar-mini">MP</span>
                <span class="sidebar-normal"> {{__('My Profile') }} </span>
              </a>
            </li>
            <li class="nav-item {{ $activePage == 'profile-security' ? ' active' : '' }}">
            <a class="nav-link" href="{{URL::action('ProfileController@viewDoubleFactorAuth', 'form')}}">
                <span class="sidebar-mini">{{__('app.SC')}}</span>
                <span class="sidebar-normal"> {{__('Security Configuration') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <ul class="nav" >
      @include('layouts.navbars.menus.base')
    </ul>
  </div>
</div>
