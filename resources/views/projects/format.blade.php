{{-- This File is an Alias for 'create' --}}
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

    #all-container {
        background: #7dabc375;
        padding: 30px;
    }
    #format-content {
        border: solid 4px #32526f;
    border-radius: 6px;
    background: white;
    height: 600px;
    overflow-y: scroll;
    overflow-x: hidden;
    }

    .nav-item.active {
        color: white;
        background:#32526f;
    }
</style>
@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 text-right">
                    <a href="{{ route('projects.index') }}" class="btn btn-sm btn-rose">{{ __('Back to list') }}</a>
                </div>
            </div>
            <div id="all-container">
                <h3 style="margin-top:-10px;">
                    {{ __('Create Project') }}
                </h3>
                @include('layouts.navbars.stepnav')
                <div id="format-content">
                    <form method="post" action="{{ route('projects.store') }}" autocomplete="off" class="form-horizontal">
                        @csrf
                        @method('patch')

                        <div class="">
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
                                            <input class="form-control" name="date" type="date" value="{{-- $project->format->date --}}" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="c_label col-12 col-form-label">{{ __('Client') }}</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" name="client" type="text" value="{{-- $project->format->client --}}" />
                                        </div>
                                    </div>



                                    <div class="col-12 col-md-6">
                                        <label class="c_label col-12 col-form-label">{{ __('Contact') }}</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" name="main_contact" type="text" value="{{-- $project->format->main_contact --}}" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="c_label col-12 col-form-label">{{ __('Job Position') }}</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" name="position" type="text" value="{{-- $project->format->position --}}" />
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="c_label col-12 col-form-label">{{ __('Phone') }}</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" name="phone" type="text" value="{{-- $project->format->phone --}}" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="c_label col-12 col-form-label">{{ __('Email') }}</label>
                                        <div class="col-sm-12">
                                            <input class="form-control" name="email" type="email" value="{{-- $project->format->email --}}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="">
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
                                        <select class="structure form-control" name="structure">
                                            <option selected>{{ __('Choose...') }}</option>
                                            <option value="{{ __('Building') }}"> {{ __('Building') }} </option>
                                            <option value="{{ __('House') }}"> {{ __('House') }} </option>
                                            <option value="{{ __('School') }}"> {{ __('School') }} </option>
                                            <option value="{{ __('Bussiness') }}"> {{ __('Bussiness') }} </option>
                                            <option id="structure-other" value="0"> {{ __('Other') }} </option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <input id="input-structure-other" style="display:none;" class="form-control mt-2" type="text" placeholder="{{ __('specify...') }}">
                                    </div>
                                    <script>


                                    </script>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Environment') }}</label>
                                    <div class="col-sm-12">
                                        <select class="environment form-control" name="environment">
                                            {{-- <option selected>{{ __('Choose...') }}</option> --}}
                                            <option selected value="0"> {{ __('Urban') }} </option>
                                            <option value="1"> {{ __('Rural') }} </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('Has Educational Programs?') }}</label>
                                    {{-- <div class="col-sm-12">
                                    </div> --}}
                                    <div class="col-sm-12">
                                        <select class="education form-control" name="structure">
                                            <option selected value="0">{{ __('No') }}</option>
                                            <option value="1"> {{ __('Yes') }} </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 input-education-childs">
                                    <label class="c_label col-12 col-form-label">{{ __('# of Children') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="children" type="text" value="{{-- $project->format->children --}}" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 input-education-childs">
                                    <label class="c_label col-12 col-form-label">{{ __('# of Classrooms') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="classrooms" type="text" value="{{-- $project->format->classrooms --}}" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('Country') }}</label>
                                    <div class="col-sm-12">
                                        <select class="country form-control">
                                            <option selected>{{ __('Choose...') }}</option>
                                            <option value="142"> México </option>
                                            @foreach($countries as $item)
                                            <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('State') }}</label>
                                    <div class="col-sm-12">
                                        <div id="state">
                                            <input class="form-control" class="" name="state" type="text" value="{{-- $project->format->state --}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('Municipality') }}</label>
                                    <div class="col-sm-12">
                                        <div id="municipality">
                                            <input class="form-control" name="municipality" type="text" value="{{-- $project->format->municipality --}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('colony') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="colony" type="text" value="{{-- $project->format->colony --}}" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('Street') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="street" type="text" value="{{-- $project->format->street --}}" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-3">
                                    <label class="c_label col-12 col-form-label">{{ __('# Exterior') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="n_ext" type="text" value="{{-- $project->format->frequency --}}" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="c_label col-12 col-form-label">{{ __('# Interior') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="n_int" type="text" value="{{-- $project->format->frequency --}}" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('# of Users') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="users" type="text" value="{{-- $project->format->users --}}" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Has Water Lack?') }}</label>
                                    <div class="col-sm-12">
                                        <select class="has_water_lack form-control" name="has_water_lack">
                                            <option selected value="0">{{ __('No') }}</option>
                                            <option value="1"> {{ __('Yes') }} </option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <input id="input-has_water_lack-other" name="frequency" style="display:none;" class="form-control mt-2" type="text" placeholder="{{ __('Frequency') }}">
                                    </div>

                                </div>
                                {{-- <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Frequency') }}</label>
                                    <div class="col-sm-12">

                                    </div>
                                </div> --}}

                                <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Water Obtaining Method') }}</label>
                                    <div class="col-sm-12">
                                        <select class="obtaining form-control" name="obtaining_water">
                                            <option selected value="{{ __('Own water system') }}">{{ __('Own water system') }}</option>
                                            <option value="{{ __('Pipes') }}"> {{ __('Pipes') }} </option>
                                            <option id="obtaining-other" value="0"> {{ __('Other') }} </option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <input id="input-obtaining-other" style="display:none;" class="form-control mt-2" type="text" placeholder="{{ __('specify...') }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Water Consumption [lt]') }}</label>
                                    <div class="col-sm-12">
                                        <input id="water_consumption_lt" class="form-control" name="water_consumption" type="number" value="" />
                                        <input readonly disabled id="water_consuption" class="form-control" type="text" value="" placeholder="[m3]"/>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Average Cost Water/Year [pesos]') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="cost_average" type="number" value="{{-- $project->format->cost_average --}}" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Water Quality') }}</label>
                                    {{-- <div class="col-sm-12">
                                    </div> --}}
                                    <div class="col-sm-12 mt-2">

                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input name="water_quality[]" class="form-check-input" type="checkbox" value="{{ __('WC and Watering') }}"> {{ __('WC and Watering') }}
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input name="water_quality[]" class="form-check-input" type="checkbox" value="{{ __('Hygiene and personal care') }}"> {{ __('Hygiene and personal care') }}
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input name="water_quality[]" class="form-check-input" type="checkbox" value="{{ __('Purified') }}"> {{ __('Purified') }}
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input name="water_quality[]" id="water_quality-other" class="form-check-input" type="checkbox" value=""> {{ __('Other') }}
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <input id="input-quality-other" style="display:none;" class="form-control mt-2" type="text" placeholder="{{ __('specify...') }}">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Roof Type') }}</label>
                                    <div class="col-sm-12 mt-2">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input name="roof_type[]" class="form-check-input" type="checkbox" value="{{ __('Arch Ceiling') }}"> {{ __('Arch Ceiling') }}
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input name="roof_type[]" class="form-check-input" type="checkbox" value="{{ __('Two Waters') }}"> {{ __('Two Waters') }}
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input name="roof_type[]" class="form-check-input" type="checkbox" value="{{ __('Flat With Pending') }}"> {{ __('Flat With Pending') }}
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input name="roof_type[]" class="form-check-input" type="checkbox" value="{{ __('Flat Without Pending') }}"> {{ __('Flat Without Pending') }}
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Rainwater Area') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" id="rainwater_area" name="rainwater_area" type="number" value="" />
                                        <input readonly disabled class="form-control" id="storage" type="text" placeholder="[m3]" value="" />
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="">
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
                                        <select class="form-control" name="property_type">
                                            <option value="{{ __('Own') }}" selected>{{ __('Own') }}</option>
                                            <option value="{{ __('Rent') }}"> {{ __('Rent') }} </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('current_year_resources') }}</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="current_year_resources">
                                            <option value="{{ __('Yes') }}" selected>{{ __('Yes') }}</option>
                                            <option value="{{ __('No') }}"> {{ __('No') }} </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('Resources Type') }}</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="resources_type">
                                            <option value="{{ __('Own') }}" selected>{{ __('Own') }}</option>
                                            <option value="{{ __('Third Party') }}"> {{ __('Third Party') }} </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Planning Entity') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="planning_entity_id" type="text" value="{{-- $project->format->planning_entity_id --}}" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Auth Entity') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="auth_entity_id" type="text" value="{{-- $project->format->auth_entity_id --}}" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Implementation Date') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="implementation_date" type="date" value="{{-- $project->format->implementation_date --}}" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Notes and Observations') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="notes" type="text" value="{{-- $project->format->notes --}}" />
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

$('.country').on('change', function () {

    // if country is Mexico
    if($(this).val() == 142) {
        $('#state').load('/states')
        console.log($(this).val());
    } else {
        $('#state').html(`<input class="form-control" class="" name="state" type="text" value="{{-- $project->format->state --}}" />`);
        $('#municipality').html(`<input class="form-control" class="" name="state" type="text" value="{{-- $project->format->municipality --}}" />`);
    }
});

$('.structure').on('change', function () {
    if($(this).val() == 0)
        $('#input-structure-other').fadeIn();
    else
        $('#input-structure-other').fadeOut();
});

$('.quality').on('change', function () {
    if($(this).val() == 0)
        $('#input-quality-other').fadeIn();
    else
        $('#input-quality-other').fadeOut();
});

$('.education').on('change', function () {
    if($(this).val() == 1)
        $('.input-education-childs').fadeIn();
    else
        $('.input-education-childs').fadeOut();
});

$('.obtaining').on('change', function () {
    if($(this).val() == 0)
        $('#input-obtaining-other').fadeIn();
    else
        $('#input-obtaining-other').fadeOut();
});

$('.has_water_lack').on('change', function () {
    if($(this).val() == 1)
        $('#input-has_water_lack-other').fadeIn();
    else
        $('#input-has_water_lack-other').fadeOut();
});

$('#water_consumption_lt').on('keyup', function () {
    let total = $('#water_consumption_lt').val() * 0.001;
    $('#water_consuption').val(total+" m3");
});

$('#rainwater_area').on('keyup', function () {
    let total = $('#rainwater_area').val();
    if( $('.environment').val() == 0 )
        multiplier = 20;
    else
        multiplier = 30;
    $('#storage').val(total * multiplier + " m3");
});

$('.environment').on('change', function () {
    let total = $('#rainwater_area').val();
    if( $('.environment').val() == 0 )
        multiplier = 20;
    else
        multiplier = 30;
    $('#storage').val(total * multiplier + "m3");
});

$('#water_quality-other').on('click', function () {
    console.log($(this).is(':checked'));
    if( $(this).is(':checked') )
        $('#input-quality-other').fadeIn();
    else
        $('#input-quality-other').fadeOut();
});


$('.input-education-childs').hide();

</script>

@endpush


{{-- un hidden que sea el valor real (specify...) --}}
