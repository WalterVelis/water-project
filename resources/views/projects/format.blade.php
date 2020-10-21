@extends('layouts.app', ['activePage' => 'budgetaccount-management', 'menuParent' => 'catalog', 'sublevel' => 'budget', 'titlePage' => __('Budget Account Management')])
<style>
    .c_label {
        font-size: 1.1em!important;
        padding: 0!important;
        font-weight: 600;
        margin-left: 0px!important;
        width: auto!important;
        margin-top: 30px;
    }
</style>
@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-12">
                    <h3 style="font-weight:300;margin-bottom:0;">{{ __('Project') }}:</h3>
                    <h2 style=""">{{ $project->name }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <a href="{{ route('projects.index') }}" class="btn btn-sm btn-rose">{{ __('Back to list') }}</a>
                </div>
            </div>
            <form method="post" action="{{ route('projects.update', $project->id) }}" autocomplete="off" class="form-horizontal">
                @csrf
                @method('patch')

                <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                        <i class="material-icons">supervisor_account</i>
                        </div>
                        <h4 class="card-title">{{ __('GENERAL DATA') }}</h4>
                    </div>

                    <div class="card-body ">

                    <!-- Inicio -->

                        <div class="row pb-5">
                            <div class="col-12 col-md-6">
                                <label class="c_label col-12 col-form-label">{{ __('Date') }}</label>
                                <div class="col-sm-12">
                                    <input class="form-control" name="date" type="date" value="{{ $project->format->date }}" />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="c_label col-12 col-form-label">{{ __('Client') }}</label>
                                <div class="col-sm-12">
                                    <input class="form-control" name="client" type="text" value="{{ $project->format->client }}" />
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="c_label col-12 col-form-label">{{ __('Municipality') }}</label>
                                <div class="col-sm-12">
                                    <input class="form-control" name="municipality" type="text" value="{{ $project->format->municipality }}" />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="c_label col-12 col-form-label">{{ __('State') }}</label>
                                <div class="col-sm-12">
                                    <input class="form-control" name="state" type="text" value="{{ $project->format->state }}" />
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="c_label col-12 col-form-label">{{ __('Contact') }}</label>
                                <div class="col-sm-12">
                                    <input class="form-control" name="main_contact" type="text" value="{{ $project->format->main_contact }}" />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="c_label col-12 col-form-label">{{ __('Job Position') }}</label>
                                <div class="col-sm-12">
                                    <input class="form-control" name="position" type="text" value="{{ $project->format->position }}" />
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="c_label col-12 col-form-label">{{ __('Phone') }}</label>
                                <div class="col-sm-12">
                                    <input class="form-control" name="phone" type="text" value="{{ $project->format->phone }}" />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="c_label col-12 col-form-label">{{ __('Email') }}</label>
                                <div class="col-sm-12">
                                    <input class="form-control" name="email" type="email" value="{{ $project->format->email }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                        <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">{{ __('FEATURES & NEEDS') }}</h4>
                    </div>

                    <div class="card-body row pb-5">
                        <div class="col-12 col-md-6">
                            <label class="c_label col-12 col-form-label">{{ __('Structure') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="structure" type="text" value="{{ $project->format->structure }}" />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="c_label col-12 col-form-label">{{ __('Environment') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="environment" type="text" value="{{ $project->format->environment }}" />
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="c_label col-12 col-form-label">{{ __('Has Educational Programs?') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="has_educational_programs" type="text" value="{{ $project->format->has_educational_programs }}" />
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="c_label col-12 col-form-label">{{ __('# of Children') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="children" type="text" value="{{ $project->format->children }}" />
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="c_label col-12 col-form-label">{{ __('# of Classrooms') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="classrooms" type="text" value="{{ $project->format->classrooms }}" />
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="c_label col-12 col-form-label">{{ __('colony') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="colony" type="text" value="{{ $project->format->colony }}" />
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="c_label col-12 col-form-label">{{ __('Street') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="street" type="text" value="{{ $project->format->street }}" />
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="c_label col-12 col-form-label">{{ __('# of Users') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="users" type="text" value="{{ $project->format->users }}" />
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="c_label col-12 col-form-label">{{ __('Has Water Lack?') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="has_water_lack" type="text" value="{{ $project->format->has_water_lack }}" />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="c_label col-12 col-form-label">{{ __('Frequency') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="frequency" type="text" value="{{ $project->format->frequency }}" />
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="c_label col-12 col-form-label">{{ __('Water Obtaining Method') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="obtaining_water" type="text" value="{{ $project->format->obtaining_water }}" />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="c_label col-12 col-form-label">{{ __('Water Consumption') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="water_consumption" type="text" value="{{ $project->format->water_consumption }}" />
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="c_label col-12 col-form-label">{{ __('Cost Average') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="cost_average" type="text" value="{{ $project->format->cost_average }}" />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="c_label col-12 col-form-label">{{ __('Water Quality') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="water_quality" type="text" value="{{ $project->format->water_quality }}" />
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="c_label col-12 col-form-label">{{ __('Roof Type') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="roof_type" type="text" value="{{ $project->format->roof_type }}" />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="c_label col-12 col-form-label">{{ __('Rainwater Area') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="rainwater_area" type="text" value="{{ $project->format->rainwater_area }}" />
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                            <i class="material-icons">check_circle_outline</i>
                            </div>
                            <h4 class="card-title">{{ __('VALIDATION') }}</h4>
                        </div>

                        <div class="card-body row pb-5">
                        <div class="col-12 col-md-4">
                            <label class="c_label col-12 col-form-label">{{ __('Property Type') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="property_type" type="text" value="{{ $project->format->property_type }}" />
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="c_label col-12 col-form-label">{{ __('current_year_resources') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="current_year_resources" type="text" value="{{ $project->format->current_year_resources }}" />
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="c_label col-12 col-form-label">{{ __('Resources Type') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="resources_type" type="text" value="{{ $project->format->resources_type }}" />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="c_label col-12 col-form-label">{{ __('Planning Entity') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="planning_entity_id" type="text" value="{{ $project->format->planning_entity_id }}" />
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="c_label col-12 col-form-label">{{ __('Auth Entity') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="auth_entity_id" type="text" value="{{ $project->format->auth_entity_id }}" />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="c_label col-12 col-form-label">{{ __('Implementation Date') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="implementation_date" type="date" value="{{ $project->format->implementation_date }}" />
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="c_label col-12 col-form-label">{{ __('Notes and Observations') }}</label>
                            <div class="col-sm-12">
                                <input class="form-control" name="notes" type="text" value="{{ $project->format->notes }}" />
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
