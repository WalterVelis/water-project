@extends('layouts.app', ['activePage' => 'projects-management', 'menuParent' => 'projects', 'titlePage' => 'Gestión de Proyectos'])
@section('content')
<style>
    .form-check .form-check-label {
        padding-right: 0px!important;
    }


    .c_label {
        /* font-size: 1.1em !important; */
        padding: 0 !important;
        margin-left: 15px !important;
        width: auto !important;
        margin-top: 30px;
    }

    #all-container {
        background: #7dabc375;
        padding: 30px;
    }

    #format-content {
        padding: 20px;
        border: solid 4px #32526f;
        border-radius: 6px;
        background: white;
        height: 60vh;
        overflow-y: scroll;
        overflow-x: hidden;
    }

    nav .nav-item.active {
        color: white;
        background: #32526f;
    }

    form .col-12 {
        margin-top: 1rem;
    }

    .bg-b {
        background: #32526f!important;
        color: white;
    }
</style>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <form method="post" enctype="multipart/form-data" action="{{ route('assignment.update', $assignmentData->id) }}" autocomplete="off"
                    class="form-horizontal">
                    @csrf
                    @method('put')
                    <input type="hidden" id='formType' value='formCreate'>

                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">supervisor_account</i>
                            </div>
                            <h4 class="card-title">Gestión de Proyectos</h4>
                        </div>
                        <nav class="navbar step-navbar navbar-expand-lg c-nav">
                            <div class="container">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-bar navbar-kebab"></span>
                                <span class="navbar-toggler-bar navbar-kebab"></span>
                                <span class="navbar-toggler-bar navbar-kebab"></span>
                                </button>
                                <div class="w-100" id="navbarNavDropdown">
                                    <ul class="navbar-nav" style="">
                                        <li class="nav-item {{ $assignmentData->internal_status >= 0 ? "c-enabled" : "" }}">
                                            <a class="nav-link" href="{{ $assignmentData->internal_status >= 0 ? route('projects.edit', $assignmentData) : "#" }}">{{ __('Needs Diagnosis') }}</a>
                                        </li>
                                        <li class="nav-item  {{ $assignmentData->internal_status >= 0 && !$assignmentData->tech_assigned == 0 ? "c-enabled" : "" }}">
                                            <a class="nav-link" href="{{ $assignmentData->internal_status >= 0 ? route('techformat.edit', $assignmentData) : "#" }}">{{ __('Technical Lift') }}</a>
                                        </li>
                                        <li class="nav-item  {{ $assignmentData->internal_status >= 2 && $assignmentData->internal_status != 2 && !App\User::hasPermissions("Tech") ? "c-enabled" : "" }}">
                                            <a class="nav-link" href="{{ $assignmentData->internal_status >= 2 && !App\User::hasPermissions("Tech") ? "/quotation/$assignmentData->id/edit" : "#" }}">{{ __('Quotation') }}</a>
                                        </li>
                                        <li class="nav-item {{ $assignmentData->internal_status == 6 ? "c-enabled" : "" }}">
                                            <a class="nav-link" href="{{ $assignmentData->internal_status == 6 ? "/order/$assignmentData->id/edit" : "#" }}">{{ __('Purchase Order') }}</a>
                                        </li>
                                        <li class="nav-item active {{ $assignmentData->internal_status >= 1 ? "c-enabled" : "" }}">
                                            <a class="nav-link" href="{{ $assignmentData->internal_status >= 1 ? "/assignment/$assignmentData->id/edit" : "#" }}">{{ __('Assignment') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                        <div class="card-body">
                            <div class="container" >
                                {{-- @foreach($users as $user)
                                @dump($user->hasPermissions('Admin'))
                                @endforeach --}}
                                <div class="row mt-2">

                                    <div class="mt-5 col-sm-hidden col-12 col-md-6">
                                        <h3>Personas Asignadas</h3>
                                    </div>
                                    <div class="mt-5 col-sm-hidden col-12 col-md-6">
                                        <h3>Estatus Asignado</h3>
                                    </div>
                                    <div class="mt-5 col-12 col-md-6">
                                        <span>Proyecto creado por: </span> <input class="w-100" readonly disabled type="text" value="{{ $assignmentData->user->name }}">
                                    </div>
                                    <div class="mt-5 col-12 col-md-6">
                                        <span style="margin-bottom:-10px;font-weight:bold;">{{ __('Estatus') }}</span>
                                        <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                            <select class="form-control" name="status" id="stt">
                                                <option readonly value="">Seleccione...</option>
                                                <option {{ $assignmentData->internal_status == 4 ? "selected" : "" }} value="4">Cotizado</option>
                                                <option {{ $assignmentData->internal_status == 5 ? "selected" : "" }} value="5">Negociación</option>
                                                <option {{ $assignmentData->internal_status == 7 ? "selected" : "" }} value="7">Aceptado</option>
                                                <option {{ $assignmentData->internal_status == 8 ? "selected" : "" }} value="8">Rechazado</option>
                                                <option {{ $assignmentData->internal_status == 6 ? "selected" : "" }} value="6">Anticipo</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'status'])
                                        </div>
                                    </div>
                                    <div class="mt-5 col-12 col-md-6">
                                        <span style="margin-bottom:-10px;font-weight:bold;">{{ __('Vendedor Titular') }}</span>
                                        <div class="form-group{{ $errors->has('vendor_assigned') ? ' has-danger' : '' }}">
                                            <select class="form-control" name="vendor_assigned" id="" required>
                                                <option value="0">No asignado</option>
                                                @foreach($users->where('role_id', 6) as $user)
                                                <option {{ $assignmentData->vendor_assigned == $user->id ? "selected" : "" }} value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            @include('alerts.feedback', ['field' => 'vendor_assigned'])
                                        </div>
                                    </div>
                                    <div class="mt-5 col-12 col-md-6">
                                    </div>
                                    <div class="mt-5 col-12 col-md-6">
                                        <span style="margin-bottom:-10px;font-weight:bold;">{{ __('Técnico asignado') }}</span>
                                        <div class="form-group{{ $errors->has('tech_assigned') ? ' has-danger' : '' }}">
                                            <select class="form-control" name="tech_assigned" id="" required>
                                                <option value="0">No asignado</option>
                                                @foreach($users->where('role_id', 4) as $user)
                                                {{-- @if(!$user->hasPermissions('Tech'))
                                                @continue
                                                @endif --}}
                                                <option {{ $assignmentData->tech_assigned == $user->id ? "selected" : "" }} value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            @include('alerts.feedback', ['field' => 'tech_assigned'])
                                        </div>
                                    </div>
                                    <div class="mt-5 col-12 col-md-6">
                                    </div>
                                    <div class="mt-5 col-12 col-md-6">
                                        <span style="margin-bottom:-10px;font-weight:bold;">{{ __('Administrador') }}</span>
                                        <div class="form-group{{ $errors->has('admin_assigned') ? ' has-danger' : '' }}">
                                            <select class="form-control" name="admin_assigned" id="" required>
                                                <option value="0">No asignado</option>
                                                @foreach($users->where('role_id', 1) as $user)
                                                <option {{ $assignmentData->admin_assigned == $user->id ? "selected" : "" }} value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            @include('alerts.feedback', ['field' => 'admin_assigned'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex flex-row-reverse" style="justify-content: end;">
                            {{-- <p onclick="validationSave();" class="btn btn-primary">{{ __('Save') }}</p> --}}
                            @if (!App\User::hasPermissions("Tech"))
                            <button id="saveUser" type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            @endif
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
        }));
    });

    @if (App\User::hasPermissions("Tech"))
    $(function () {
        $('input, select').addClass('disabled');
        $('input, select').prop('disabled', true);
    });
    @endif

    @if (App\User::hasPermissions("Vendor"))
    $(function () {
        $('input, select').addClass('disabled');
        $('input, select').prop('disabled', true);
        $('#stt').removeClass('disabled');
        $('#stt').prop('disabled', false);
    });
    @endif

</script>

@endpush
