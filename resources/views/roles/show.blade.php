@extends('layouts.app', ['activePage' => 'role-management', 'menuParent' => 'user', 'titlePage' => __('Role Management')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8">
            <div class="card">
              <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon" style="background-image: url({{asset("img/icons").'/Gestion_Rol.png'}});">
                  <i class="material-icons">f</i>
                </div>
                <h3 class="card-title">{{ $rol->name }}</h3>
              </div>
              <div class="card-body">
                  <div class="row">
                    <div class="col-12 text-right">
                      <a href="{{ route('role.edit', $rol) }}" class="btn btn-sm btn-rose btn-round">{{ __('Edit Role') }}</a>
                      <a href="{{ route('role.index') }}" class="btn-add"><img src="{{asset("img/icons").'/Regresar.png'}}"></a>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12">
                      <h4 style="font-weight: bold">@lang('Description')</h4>
                    <p>{{$rol->description}}</p>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-12 text-center">
                      <h4 style="font-weight: bold">@lang('Assigned Permissions List')</h4>
                    </div>
                  </div>

                <div class="table-responsive">
                  @include('layouts.table')
                  <table id="datatables" class="table table-striped table-no-bordered table-hover"  >
                    <thead class="text-dark">
                      <th>
                          {{ __('Name') }}
                      </th>
                    </thead>
                    <tbody>
                      @foreach($rol->rolePermission as $permission)
                        <tr style="background-color: white;">
                          <td>
                            {{ $permission->permission->description}}
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
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

