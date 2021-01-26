<style>
    .photo2 {
        width: 1.75rem;
        height: 1.75rem;
        overflow: hidden;
        float: left;
        z-index: 5;
        margin-right: 1.5625rem;
        border-radius: 50%;
        background-color: #0b6696;
    }

    .sidebar[data-color="rose"] li.active>a {
        background-color: #bacfda;
        box-shadow: 0 4px 10px 0px rgba(0, 0, 0, 0.07), 0 7px 5px -5px rgba(11, 102, 150, 0.2);
    }
    .sub-itm {
        margin-left: 1rem;
        background: #0b6696;
        color: white;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        line-height: 30px;
    }

    .sidebar[data-background-color="black"] .nav .nav-item i {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.3em;
        margin-left: -1px;
    }
</style>
@php
if(!isset($sublevel)){
$sublevel="";
}
@endphp
{{-- @if (auth()->user()->role->name == 'Vendor')
<li class="nav-item{{ $activePage == 'vendor-management' ? ' active' : '' }}">
    <a class="nav-link" href="{{URL::action('VendorController@edit', auth()->user()->vendor->id)}}">
        <div class="photo2 sidebar-image">
            <img src="{{asset("img/icons").'/Gestion_proveedor.png'}}" />
        </div>
        <p>{{ __('Profile Vendor') }}</p>
    </a>
</li>

@endif --}}

@if(App\User::hasPermissions('Admin'))
@if(App\User::hasPermissions('Role Index') || App\User::hasPermissions('User Index'))
<li class="nav-item {{ ($menuParent == 'role') ? ' active' : '' }}">
    <a class="nav-link" data-toggle="collapse" href="#bfUser"
        {{ ($menuParent == 'laravel' || $activePage == 'dashboard') ? ' aria-expanded="true"' : '' }}>
        <div class="photo2 sidebar-image">
            <i class="material-icons">supervisor_account</i>
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
                    <span class="sidebar-mini sub-itm">{{__('app.rm')}}</span>
                    <span class="sidebar-normal"> {{ __('Role Management') }} </span>
                </a>
            </li>
            @endif

            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('user.index') }}">
                    <span class="sidebar-mini  sub-itm">{{__('app.um')}}</span>
                    <span class="sidebar-normal"> {{ __('User Management') }} </span>
                </a>
            </li>


        </ul>
    </div>
</li>
@endif
<li class="nav-item{{ $activePage == 'provider' ? ' active' : '' }}">
    <a class="nav-link" href="{{ route('providers.index') }}">
        <span class="sidebar-mini photo2"><i class="material-icons">assignment_ind</i></span>
        <span class="sidebar-normal"> {{ __('Gestión de Proveedores') }} </span>
    </a>
</li>
<li class="nav-item {{ ($menuParent == 'costs-parent') ? ' active' : '' }}">
    <a class="nav-link" data-toggle="collapse" href="#bfCosts"
        {{ ($menuParent == 'laravel' || $activePage == 'costs') ? ' aria-expanded="true"' : '' }}>
        <div class="photo2 sidebar-image">
            <i class="material-icons">request_page</i>
        </div>
        <p>{{ __('Centro de costos') }}
            <b class="caret"></b>
        </p>
    </a>
    <div class="collapse {{ ($menuParent == 'costs-parent') ? ' show' : '' }}" id="bfCosts">
        <ul class="nav">


            <li class="nav-item{{ $activePage == 'costs-me' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('materials.index') }}">
                    <span class="sidebar-mini sub-itm">ME</span>
                    <span class="sidebar-normal"> {{ __('Materiales extra') }} </span>
                </a>
            </li>

            <li class="nav-item{{ $activePage == 'costs-iu' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('accesory.index') }}">
                    <span class="sidebar-mini  sub-itm">AI</span>
                    <span class="sidebar-normal"> {{ __('Accesorios IU') }} </span>
                </a>
            </li>

            <li class="nav-item{{ $activePage == 'costs' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('costs.index') }}">
                    <span class="sidebar-mini  sub-itm">MO</span>
                    <span class="sidebar-normal"> {{ __('Mano de obra') }} </span>
                </a>
            </li>


        </ul>
    </div>
</li>
@endif
<li class="nav-item{{ $activePage == 'projects-management' ? ' active' : '' }}">
    <a class="nav-link" href="{{ route('projects.index') }}">
        <span class="sidebar-mini photo2"><i class="material-icons">work</i></span>
        <span class="sidebar-normal"> {{ __('Gestión de Proyectos') }} </span>
    </a>
</li>

@if(App\User::hasPermissions("Vendor Index"))
<li class="nav-item {{ ($menuParent == 'vendor') ? ' active' : '' }}">
    <a class="nav-link" data-toggle="collapse" href="#bfVendor"
        {{ ($menuParent == 'vendor') ? ' aria-expanded="true"' : '' }}>
        <div class="photo2 sidebar-image">
            <img src="{{asset("img/icons").'/Gestion_proveedor.png'}}" />
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
    <a class="nav-link" data-toggle="collapse" href="#proyectos"
        {{ ($menuParent == 'vendor') ? ' aria-expanded="true"' : '' }}>
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
                    <span class="sidebar-normal"> {{ __('Projects') }} </span>
                </a>
            </li>

        </ul>
    </div>
</li>
@endif

@if(App\User::hasPermissions("Admin"))

<li class="nav-item {{ ($menuParent == 'datastudio') ? ' active' : '' }}">
    <a class="nav-link" data-toggle="collapse" href="#dataStudio"
        {{ ($menuParent == 'datastudio-1' || $activePage == 'datastudio-1') ? ' aria-expanded="true"' : '' }}>
        <div class="photo2 sidebar-image">
            <i class="material-icons">request_page</i>
        </div>
        <p>{{ __('Informes') }}
            <b class="caret"></b>
        </p>
    </a>
    <div class="collapse {{ ($menuParent == 'datastudio') ? ' show' : '' }}" id="dataStudio">
        <ul class="nav">


            <li class="nav-item{{ $activePage == 'datastudio-1' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('informe.ventas') }}">
                    <span class="sidebar-mini sub-itm">VU</span>
                    <span class="sidebar-normal"> {{ __('Venta y utilidad') }} </span>
                </a>
            </li>

            <li class="nav-item{{ $activePage == 'datastudio-2' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('informe.bateo') }}">
                    <span class="sidebar-mini  sub-itm">IB</span>
                    <span class="sidebar-normal"> {{ __('Índice de bateo') }} </span>
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
