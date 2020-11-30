    @extends('layouts.app', ['activePage' => 'projects-management', 'menuParent' => 'projects', 'titlePage' => __('Gestión de Proyectos')])

    @section('content')
        <div class="content">
            <div class="container-fluid">
            <div class="row">
            <div class="col-md-12">
            <form method="post" action="{{ route('projects.store') }}" autocomplete="off" class="form-horizontal">
                @csrf
                @method('post')

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
                                    <input class="form-control" id="name" name="name" type="text"value="" />
                                    @include('alerts.feedback', ['field' => 'name'])
                                </div>
                            </div>
                        </div>
                        <div class="row col-6">
                            <label class="col-sm-2 col-form-label">{{ __('Description') }}</label>
                            <div class="col-sm-9">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <input class="form-control" id="name" name="description" type="text"value="" />
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

    $("#budAccount2").select2({
    language: {
            noResults: function() {
                return "{{__('No results found')}}";
            },
            searching: function() {
                return "{{__('Searching')}}...";
            }
        }
    })

    $("#budAccount3").select2({
    language: {
            noResults: function() {
                return "{{__('No results found')}}";
            },
            searching: function() {
                return "{{__('Searching')}}...";
            }
        }
    })

    function nextCode(){
    idBlock=$('#budAccount').find('option:selected').val();
    var routeRequest = mainRoute + "budgetaccount/nextCode/" + idBlock;
    $.get(routeRequest, function (res) {
        $('#input-code').val(res);
    });
    }
    </script>
    @endpush
