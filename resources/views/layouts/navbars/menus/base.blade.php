@php
    if(!isset($sublevel)){
      $sublevel="";
    }
@endphp
@if (auth()->user()->role->name == 'Vendor')
<li class="nav-item{{ $activePage == 'vendor-management' ? ' active' : '' }}">
  <a class="nav-link" href="{{URL::action('VendorController@edit', auth()->user()->vendor->id)}}">
    <div class="photo2 sidebar-image">
      <img src="{{asset("img/icons").'/Gestion_proveedor.png'}}" />
    </div>
      <p>{{ __('Profile Vendor') }}</p>
  </a>
</li>

@endif

@if(App\User::hasPermissions('Role Index') || App\User::hasPermissions('User Index'))
<li class="nav-item {{ ($menuParent == 'role') ? ' active' : '' }}">
  <a class="nav-link" data-toggle="collapse" href="#bfUser" {{ ($menuParent == 'laravel' || $activePage == 'dashboard') ? ' aria-expanded="true"' : '' }}>
    <div class="photo2 sidebar-image">
      <img src="{{asset("img/icons").'/Gestion_Usuario.png'}}" />
    </div>
    <p>{{ __('User Management') }}
      <b class="caret"></b>
    </p>
  </a>
  <div class="collapse {{ ($menuParent == 'user') ? ' show' : '' }}" id="bfUser">
    <ul class="nav">


      @if(App\User::hasPermissions('Role Index'))
      <li class="nav-item{{ $activePage == 'role-management' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('role.index') }}">
        <span class="sidebar-mini">{{__('app.rm')}}</span>
          <span class="sidebar-normal"> {{ __('Role Management') }} </span>
        </a>
      </li>
      @endif

      <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('user.index') }}">
        <span class="sidebar-mini">{{__('app.um')}}</span>
          <span class="sidebar-normal"> {{ __('User Management') }} </span>
        </a>
      </li>


    </ul>
  </div>
</li>
@endif
<li class="nav-item{{ $activePage == 'projects-management' ? ' actives' : '' }}">
    <a class="nav-link" href="{{ route('projects.index') }}">
    <span class="sidebar-mini"></span>
        <span class="sidebar-normal"> {{ __('Projects') }} </span>
    </a>
</li>
@if(App\User::hasPermissions("Vendor Index"))
<li class="nav-item {{ ($menuParent == 'vendor') ? ' active' : '' }}">
  <a class="nav-link" data-toggle="collapse" href="#bfVendor" {{ ($menuParent == 'vendor') ? ' aria-expanded="true"' : '' }}>
    <div class="photo2 sidebar-image">
      <img src="{{asset("img/icons").'/Gestion_proveedor.png'}}"/>
    </div>
    <p>{{ __('Vendor Management') }}
      <b class="caret"></b>
    </p>
  </a>
  <div class="collapse {{ ($menuParent == 'vendor') ? ' show' : '' }}" id="bfVendor">
    <ul class="nav">

      <li class="nav-item{{ $activePage == 'vendor-management' ? ' active' : '' }}">
        <a class="nav-link" href="#">
        <span class="sidebar-mini">{{__('app.v')}}</span>
          <span class="sidebar-normal"> {{ __('Vendors') }} </span>
        </a>
      </li>

    </ul>
  </div>
</li>
@endif

@if(App\User::hasPermissions("Vendor Index"))
<li class="nav-item {{ ($menuParent == 'vendor') ? ' active' : '' }}">
  <a class="nav-link" data-toggle="collapse" href="#proyectos" {{ ($menuParent == 'vendor') ? ' aria-expanded="true"' : '' }}>
    <div class="photo2 sidebar-image">
      <img src="{{asset("img/icons").'/Catalogo.png'}}" />
    </div>
    <!-- <i class="material-icons">perm_identity</i> -->
    <p>{{ __('Poyectos') }}
      <b class="caret"></b>
    </p>
  </a>
  <div class="collapse {{ ($menuParent == 'vendor') ? ' show' : '' }}" id="proyectos">
    <ul class="nav">

      <li class="nav-item{{ $activePage == 'vendor-management' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('projects.index') }}">
        <span class="sidebar-mini">{{__('app.v')}}</span>
          <span class="sidebar-normal"> {{ __('Diagnostico') }} </span>
        </a>
      </li>

    </ul>
  </div>
</li>
@endif
<!-- <img src="{{asset("img/icons").'/Gestion_proveedor.png'}}" />
<img src="{{asset("img/icons").'/Catalogo.png'}}" />
<img src="{{asset("img/icons").'/Gestion_presupuesto.png'}}" />
<img src="{{asset("img/icons").'/Gestion_presupuesto.png'}}" /> -->
