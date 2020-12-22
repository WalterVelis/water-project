@extends('layouts.app', ['activePage' => 'role-management', 'menuParent' => 'user', 'titlePage' => __('Role Management')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">supervisor_account</i>
                        </div>
                        <h4 class="card-title">{{ __('Edit Role') }}</h4>
                    </div>
                    <div class="card-body ">

                        <form method="post" action="{{ route('role.update', $role->id) }}" autocomplete="off"
                            class="form-horizontal">
                            @csrf
                            @method('put')
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <input onkeypress="return lettersOnlySpace(event)" onpaste="return false"
                                            class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            name="name" id="input-name" type="text" placeholder="{{ __('Name') }}"
                                            value="{{ $role->name }}" aria-required="true" />
                                        @include('alerts.feedback', ['field' => 'name'])
                                        <span id="errorNameP" class="d-none">@lang('Campo obligatorio')</span>
                                        <span id="errorNameU" class="d-none">@lang('Ya existe un registro')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Description') }}</label>
                                <div class="col-sm-9">
                                    <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                        <textarea cols="30" rows="1"
                                            class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                            name="description" id="input-description" type="text"
                                            placeholder="{{ __('Description') }}"
                                            aria-required="true">{{ $role->description }}</textarea>
                                        @include('alerts.feedback', ['field' => 'description'])
                                    </div>
                                </div>
                            </div>
                            <div class="row d-none">
                                <label class="col-sm-2 col-form-label">{{ __('Permission Count') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input class="form-control" name="permissionCount" id="input-permissionCount"
                                            type="number" placeholder="0" value="{{ sizeof($role->rolePermission) }}" />
                                    </div>
                                </div>
                            </div>
                            <h6 class="card-description" style="color: black; margin-top: 1rem;">@lang('Lista de permisos asignados')</h6>
                            <div id="PerAM" class="d-none" style="height: 10rem;">
                                <small>
                                    <span class="tim-note"></span>@lang('Unassigned Permissions')
                                </small>
                            </div>
                            <div class="d-none" id="errorPermissions">
                                <span class="error text-danger">@lang("Permission slip can't be empty")</span>
                            </div>
                            <div class="row" id="divTablePA">
                                <div class="table-responsive divRol" style="height: 10rem;">
                                    <table class="table" id="tablePA">
                                        <thead>
                                            <tr>
                                                <th>@lang('Permission Name')</th>
                                                <th class="text-right">@lang('Actions')</th>
                                            </tr>
                                        </thead>
                                        @foreach ($role->rolePermission as $permission)
                                        <tr id='selectedRow{{$loop->index}}' style="background-color: white;">
                                            <td id='selectedColumn02-{{$loop->index}}'>
                                                {{$permission->permission->description}}</td>
                                            <td id='selectedColumn03-{{$loop->index}}' class='d-none'>
                                                {{$permission->permission->id}}
                                                <input type='text' name='idPermission[]'
                                                    value='{{$permission->permission->id}}' />
                                            </td>
                                            <td class='td-actions text-right'>
                                                <p onclick='deletePermission("{{$loop->index}}");' class='btn btn-link'>
                                                    <i class='material-icons'>remove_circle</i>
                                                </p>
                                            </td>
                                        </tr>

                                        @endforeach
                                    </table>
                                </div>
                            </div>
                    </div>
                    <input type="hidden" name="updated_by" value="{{auth()->user()->id}}">
                    <div class="card-footer float-right" style="padding-top: 0px; justify-content: flex-end;">
                        <a href="{{ route('role.index') }}" class="btn btn-rose">{{ __('CANCEL') }}</a>
                        <p class="btn btn-primary pull-right" onclick='PermissionDataValidationUpdate("{{$role->name}}");'>{{ __('Save') }}</p>
                    </div>
                    <div class="d-none">
                        <button id="permissionSave" type="submit" class="btn btn-rose">{{ __('Save') }}</button>
                    </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">lock</i>
                        </div>
                        <h4 class="card-title">{{ __('Permission Filter') }}</h4>
                    </div>
                    <div class="card-body ">

                        <div class="row">
                            <label class="col-sm-2 col-form-label">@lang('Filter')</label>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <input id="inputFP" onkeyup="filterPermissions();" type="text"
                                                class="form-control" placeholder="{{ __('Permission Name') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="PerFM" class="d-none">
                            <h6>
                                <span class="tim-note"></span>@lang('Permission Not Found')</h6>
                        </div>
                        <input id="header1" type="text" value="{{ __('Permission Name')}}" class="d-none" />
                        <input id="header2" type="text" value="{{ __('Actions')}}" class="d-none" />

                        <div class="table-responsive divRol" div="divTablePF" style="height: 21.7rem;">
                            <table class="table" id="tablePF">
                            </table>
                        </div>
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
    document.querySelectorAll('input').forEach( node => node.addEventListener('keypress', e => {
      if(e.keyCode == 13) {
        e.preventDefault();
      }
    }))
  });
</script>

<script>
    $(function() {
    filterPermissions()
 });
</script>

@endpush
