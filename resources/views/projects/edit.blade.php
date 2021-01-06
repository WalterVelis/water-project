@extends('layouts.app', ['activePage' => 'budgetaccount-management', 'menuParent' => 'catalog', 'sublevel' => 'budget', 'titlePage' => __('Gestión de Proyectos')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{ route('projects.update', $project->id) }}" autocomplete="off" class="form-horizontal">
                @csrf
                @method('patch')

                <div class="card ">
                <div class="card-header card-header-rose card-header-icon">
                    <div class="card-icon">
                    <i class="material-icons">assignment</i>
                    </div>
                    <h4 class="card-title">{{ __('General data') }}</h4>
                </div>

                <div class="card-body ">
                    <div class="row">
                    <div class="col-md-12 text-right">
                        <a href="{{ route('projects.index') }}" class="btn btn-sm btn-rose">{{ __('Back to list') }}</a>
                    </div>
                    </div>
                <!-- Inicio -->

                    <div class="row col-12">
                        <div class="row col-6">
                            <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                            <div class="col-sm-9">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <input class="form-control" id="name" name="name" type="text"value="{{ $project->name }}" />
                                    @include('alerts.feedback', ['field' => 'name'])
                                </div>
                            </div>
                        </div>
                        <div class="row col-6">
                            <label class="col-sm-2 col-form-label">{{ __('Description') }}</label>
                            <div class="col-sm-9">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <input class="form-control" id="name" name="description" type="text"value="{{ $project->description }}" />
                                    @include('alerts.feedback', ['field' => 'name'])
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <!-- Fin -->

                </div>
                </div>

                <input name="" id="" class="btn btn-rose" type="submit" value="{{ __('Save') }}">

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
$("#budAccount").select2({
  language: {
          noResults: function() {
              return "{{__('No results found')}}";
          },
          searching: function() {
            return "{{__('Searching')}}...";
          }
      }
})

function nextCode(block,code){
  idBlock=$('#budAccount').find('option:selected').val();
  if(idBlock==block){
    $('#input-code').val(code);
  }else{
    var routeRequest = mainRoute + "budgetaccount/nextCode/" + idBlock;
    $.get(routeRequest, function (res) {
      $('#input-code').val(res);
    });
  }
}

</script>

@endpush
