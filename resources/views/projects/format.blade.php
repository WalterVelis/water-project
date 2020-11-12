{{-- ThisFileisanAliasfor'create' --}}
@extends('layouts.app', ['activePage' => 'budgetaccount-management', 'menuParent' => 'catalog', 'sublevel' => 'budget', 'titlePage' => __('Budget Account Management')])
<style>

.form-check .form-check-label {
    padding-right: 0px!important;
}
.nav-item:not(.active) .nav-link{
    color: #3d5c7780!important;
    cursor:not-allowed
}

.c_label {
    /* font-size: 1.1em !important; */
    padding: 0 !important;
    margin-left: 0px !important;
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

.nav-item.active {
    color: white;
    background: #32526f;
}

form .col-12 {
    margin-top: 1rem;
}

</style>
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div id="all-container">
                    <h3 style="margin-top:-10px;">
                        {{ __('Create Project') }}
                    </h3>
                    @include('layouts.navbars.stepnav')
                    <div id="format-content">

                        <form id="form-update" method="post" action="{{ route('projects.update', $format) }}" autocomplete="off" class="form-horizontal">
                            <div class="row">
                                <div class="">
                                    <div class="card-header card-header-rose card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">supervisor_account</i>
                                        </div>
                                        <h4 class="card-title">{{ __('GENERAL DATA') }}</h4>
                                    </div>

                                    <div class="card-body ">

                                        <!-- Inicio -->

                                        @csrf
                                        @method('patch')
                                        <div class="row pb-5">
                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label">{{ __('Page') }}</label>
                                                <div class="col-sm-12">
                                                    <input readonly class="form-control" name="page" type="text"
                                                        value="{{ $format->page }}" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label">{{ __('First Meet') }}</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="date" type="date"
                                                        value="{{ $format->date }}" />
                                                </div>
                                            </div>
                                            <div class="col-offset-md-4 col-12 col-md-6">
                                                <label class="c_label col-12 col-form-label">{{ __('Client') }}</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="client" type="text"
                                                        value="{{ $format->client }}" />
                                                </div>
                                            </div>



                                            <div class="col-12 col-md-6">
                                                <label class="c_label col-12 col-form-label">{{ __('Main Contact') }}</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="main_contact" type="text"
                                                        value="{{ $format->main_contact }}" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label
                                                    class="c_label col-12 col-form-label">{{ __('Job Position') }}</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="position" type="text"
                                                        value="{{ $format->position }}" />
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label class="c_label col-12 col-form-label">{{ __('Phone') }}</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="phone" type="text"
                                                        value="{{ $format->phone }}" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="c_label col-12 col-form-label">{{ __('EEmail') }}</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" name="email" type="email"
                                                        value="{{ $format->email }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 card-header card-header-rose card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">assignment</i>
                                    </div>
                                    <h4 class="card-title">{{ __('FEATURES & NEEDS') }}</h4>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Structure') }}</label>
                                    <div class="col-sm-12">
                                        <select class="structure form-control" name="structure">
                                            @php ($set = 0) @endphp
                                            <option @if ($format->structure == __('House')) selected @php ($set = 1) @endphp @endif value="{{ __('House') }}"> {{ __('House') }} </option>
                                            <option @if ($format->structure == __('School')) selected @php ($set = 1) @endphp @endif value="{{ __('School') }}"> {{ __('School') }} </option>
                                            <option @if ($format->structure == __('Industry')) selected @php ($set = 1) @endphp @endif value="{{ __('Industry') }}"> {{ __('Industry') }} </option>
                                            <option @if ($format->structure == __('Bussiness')) selected @php ($set = 1) @endphp @endif value="{{ __('Bussiness') }}"> {{ __('Bussiness') }} </option>
                                            <option {{ $set == 1 ? '' : 'selected' }} id="structure-other" value="0"> {{ __('Other') }} </option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <input id="input-structure-other" style="{{ $set == 1 ? 'display:none;' : '' }}" class="form-control mt-2" type="text" placeholder="{{ __('specify...') }}" name="structure_other" value="{{ $format->structure }}">
                                    </div>
                                    <script>


                                    </script>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Environment') }}</label>
                                    <div class="col-sm-12">
                                        <select class="environment form-control" name="environment">
                                            <option {{ $format->environment == 0 ? 'selected' : '' }} value="0"> {{ __('Urban') }} </option>
                                            <option {{ $format->environment == 1 ? 'selected' : '' }} value="1"> {{ __('Rural') }} </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label
                                        class="c_label col-12 col-form-label">{{ __('Has Educational Programs?') }}</label>
                                    <div class="col-sm-12">
                                        <select class="education form-control" name="has_educational_programs">
                                            @php ($set = 0) @endphp
                                            <option {{ $format->has_educational_programs == 0 ? 'selected' : '' }} value="0">{{ __('No') }}</option>
                                            <option @if ($format->has_educational_programs == 1) selected @php ($set = 1) @endphp @endif value="1"> {{ __('Yes') }} </option>
                                        </select>
                                    </div>
                                </div>
                                    <div class="col-12 col-md-4 input-education-childs" style="{{ $set == 0 ? 'display:none;' : '' }}">
                                    <label class="c_label col-12 col-form-label">{{ __('# of Children') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="children" type="text"
                                            value="{{ $format->children }}" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 input-education-childs" style="{{ $set == 0 ? 'display:none;' : '' }}>
                                    <label class="c_label col-12 col-form-label">{{ __('# of Classrooms') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="classrooms" type="text"
                                            value="{{ $format->classrooms }}" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('Country') }}</label>
                                    <div class="col-sm-12">
                                        <select class="country form-control" name="country">
                                            <option selected value="142"> México </option>
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
                                            <input class="form-control" class="" name="state" type="text" value="{{ $format->state }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('Municipality') }}</label>
                                    <div class="col-sm-12">
                                        <div id="municipality">
                                            <input class="form-control" name="municipality" type="text" value="{{ $format->municipality }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('Colony') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="colony" type="text"
                                            value="{{ $format->colony }}" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('Street') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="street" type="text"
                                            value="{{ $format->street }}" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-3">
                                    <label class="c_label col-12 col-form-label">{{ __('# Exterior') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="n_ext" type="text"
                                            value="{{ $format->n_ext }}" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="c_label col-12 col-form-label">{{ __('# Interior') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="n_int" type="text"
                                            value="{{ $format->n_int }}" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="c_label col-12 col-form-label">{{ __('Postal Code') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="zip_code" type="text"
                                            value="{{ $format->zip_code }}" />
                                    </div>
                                </div>

                                <!-- <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('# of Users') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="users" type="text"
                                            value="{{ $format->users }}" />
                                    </div>
                                </div> -->

                                <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Has Water Lack?') }}</label>
                                    <div class="col-sm-12">
                                        <select class="has_water_lack form-control" name="has_water_lack">
                                            <option {{ $format->has_water_lack == 0 ? 'selected' : '' }} value="0">{{ __('No') }}</option>
                                            <option {{ $format->has_water_lack == 1 ? 'selected' : '' }} value="1"> {{ __('Yes') }} </option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <input id="input-has_water_lack-other" name="frequency" style="{{ $format->has_water_lack == 0 ? 'display:none;' : '' }}" value="{{ $format->frequency }}" class="form-control mt-2" type="text" placeholder="{{ __('Frequency') }}">
                                    </div>

                                </div>


                                <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Water Obtaining Method') }}</label>
                                    <div class="col-sm-12">
                                        <select class="obtaining form-control" name="obtaining_water">
                                            @php ($set = 0) @endphp
                                            <option @if ($format->obtaining_water == __('Own water system')) selected @php ($set = 1) @endphp @endif value="{{ __('Own water system') }}"> {{ __('Own water system') }} </option>
                                            <option @if ($format->obtaining_water == __('Pipes')) selected @php ($set = 1) @endphp @endif value="{{ __('Pipes') }}"> {{ __('Pipes') }} </option>
                                            <option {{ $set == 1 ? '' : 'selected' }} id="obtaining-other" value="0"> {{ __('Other') }} </option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <input id="input-obtaining-other" name="obtaining_water_other" style="{{ $set == 1 ? 'display:none;' : '' }}" value="{{ $format->obtaining_water }}" class="form-control mt-2" type="text" placeholder="{{ __('specify...') }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Water Consumption [lt]') }}</label>
                                    <div class="col-sm-12">
                                        <input id="water_consumption_lt" class="form-control" name="water_consumption"
                                            type="number" value="{{ $format->water_consumption }}" />
                                        <input readonly disabled id="water_consuption" class="form-control" type="text"
                                            value="" placeholder="[m3]" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label
                                        class="c_label col-12 col-form-label">{{ __('Average Cost Water/Year [pesos]') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="cost_average" type="number"
                                            value="{{ $format->cost_average }}" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <label class="c_label col-12 col-form-label">{{ __('Water Quality') }}</label>
                                        <div class="row">
                                            @php
                                                $water_quality = explode(",",$format->water_quality);
                                            @endphp
                                            <div class="col-12 col-md-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input {{ in_array(__('WC and Watering'), $water_quality) ? 'checked' : '' }} name="water_quality[]" class="form-check-input" type="checkbox"
                                                            value="{{ __('WC and Watering') }}"> {{ __('WC and Watering') }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input {{ in_array(__('Hygiene and personal care'), $water_quality) ? 'checked' : '' }} name="water_quality[]" class="form-check-input" type="checkbox"
                                                            value="{{ __('Hygiene and personal care') }}">
                                                        {{ __('Hygiene and personal care') }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input {{ in_array(__('Purified'), $water_quality) ? 'checked' : '' }} name="water_quality[]" class="form-check-input" type="checkbox"
                                                            value="{{ __('Purified') }}"> {{ __('Purified') }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input {{ in_array(__('Other'), $water_quality) ? 'checked' : '' }} name="water_quality[]" id="water_quality-other"
                                                            class="form-check-input" type="checkbox" value="{{ __('Other') }}"> {{ __('Other') }}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        <div class="col-12 col-md-4">
                                            <input id="input-quality-other" value="{{ end($water_quality) }}" name="water_quality[]" style="{{ in_array(__('Other'), $water_quality) ? '' : 'display:none;' }}" class="form-control mt-2"
                                                type="text" placeholder="{{ __('specify...') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-12">
                                    <label class="c_label col-12 col-form-label">{{ __('Roof Type') }}</label>
                                    @php
                                        $roof_type = explode(",",$format->roof_type);
                                    @endphp
                                    <div class="row col-sm-12 mt-2">
                                        <div class="col-12 col-md-3">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input {{ in_array(__('Arch Ceiling'), $roof_type) ? 'checked' : '' }} name="roof_type[]" class="form-check-input" type="checkbox"
                                                        value="{{ __('Arch Ceiling') }}"> {{ __('Arch Ceiling') }}
                                                    <span class="form-check-sign">
                                                        <span class="check"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input {{ in_array(__('Two Waters'), $roof_type) ? 'checked' : '' }} name="roof_type[]" class="form-check-input" type="checkbox"
                                                        value="{{ __('Two Waters') }}"> {{ __('Two Waters') }}
                                                    <span class="form-check-sign">
                                                        <span class="check"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input {{ in_array(__('Flat With Pending'), $roof_type) ? 'checked' : '' }} name="roof_type[]" class="form-check-input" type="checkbox"
                                                        value="{{ __('Flat With Pending') }}"> {{ __('Flat With Pending') }}
                                                    <span class="form-check-sign">
                                                        <span class="check"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input {{ in_array(__('Flat Without Pending'), $roof_type) ? 'checked' : '' }} name="roof_type[]" class="form-check-input" type="checkbox"
                                                        value="{{ __('Flat Without Pending') }}">
                                                    {{ __('Flat Without Pending') }}
                                                    <span class="form-check-sign">
                                                        <span class="check"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Rainwater Area') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" id="rainwater_area" name="rainwater_area" type="number"
                                            value="{{ $format->rainwater_area }}" />
                                        <input readonly disabled class="form-control" id="storage" type="text"
                                            placeholder="[m3]" value="" />
                                    </div>
                                </div>
                                <div class="col-12 card-header card-header-rose card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">check_circle_outline</i>
                                    </div>
                                    <h4 class="card-title">{{ __('VALIDATION') }}</h4>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('Property Type') }}</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="property_type">
                                            <option {{ $format->property_type == 0 ? 'selected' : '' }} value="0">{{ __('Own') }}</option>
                                            <option {{ $format->property_type == 1 ? 'selected' : '' }} value="1"> {{ __('Rent') }} </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('Has Resource for this Year?') }}</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="current_year_resources">
                                            <option {{ $format->current_year_resources == 0 ? 'selected' : '' }} value="0"> {{ __('No') }} </option>
                                            <option {{ $format->current_year_resources == 1 ? 'selected' : '' }} value="1">{{ __('Yes') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('Resources Type') }}</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="resources_type">
                                            <option {{ $format->resources_type == 0 ? 'selected' : '' }} value="0" selected>{{ __('Own') }}</option>
                                            <option {{ $format->resources_type == 1 ? 'selected' : '' }} value="1"> {{ __('Third Party') }} </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Implementation Date') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="implementation_date" type="date"
                                            value="{{ $format->implementation_date }}" />
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="c_label col-12 col-form-label">{{ __('Notes and Observations') }}</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="notes" type="text"
                                            value="{{ $format->notes }}" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-3">
                                    <label class="c_label col-12 col-form-label">{{ __('¿Es factible?') }}</label>
                                    <div class="col-sm-12">
                                        <input {{ $format->status == 3 ? 'checked' : '' }} class="d-inline mt-3" name="factible" type="radio" value="0" id="is_factible" /> <label class="mr-3" for="is_factible">Es factible</label>
                                        <input {{ $format->status == 2 ? 'checked' : '' }} class="d-inline" name="factible" type="radio" value="1" id="is_not_factible" /> <label for="is_not_factible">No es factible</label>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <form class="col-12 row" method="post" id="form-planning">
                                @csrf
                                <input type="hidden" name="project_id" value="{{ $format->id }}">
                                <input type="hidden" name="entity_type" value="0">
                                <div class="col-12 mt-5">
                                    <span>{{ __('People involved in planning and validation') }}</span>
                                </div>
                                <div class="col-12 col-md-4">
                                    <input class="form-control mt-2" type="text" placeholder="{{ __('Name') }}"
                                        name="name">
                                </div>
                                <div class="col-12 col-md-4">
                                    <input class="form-control mt-2" type="text" placeholder="{{ __('Email') }}"
                                        name="email">
                                </div>
                                <div class="col-12 col-md-4">
                                    <input class="form-control mt-2" type="text" placeholder="{{ __('Telephone') }}"
                                        name="telephone">
                                </div>
                                <div class="col-12 col-md-4">
                                    <input class="form-control mt-2" type="text" placeholder="{{ __('Position') }}"
                                        name="position">
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary float-right"
                                        onclick="addPlanning()">Agregar</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-12 mt-4" id="planning"></div>
                        <br>
                        <div class="row">
                            <form class="col-12 row" method="post" id="form-auth">
                                <input type="hidden" name="project_id" value="{{ $format->id }}">
                                @csrf
                                <input type="hidden" name="entity_type" value="1">
                                <div class="col-12 mt-5">
                                    <span>{{ __('Persons involved in project authorization') }}</span>
                                </div>
                                <div class="col-12 col-md-4">
                                    <input class="form-control mt-2" type="text" placeholder="{{ __('Name') }}"
                                        name="name">
                                </div>
                                <div class="col-12 col-md-4">
                                    <input class="form-control mt-2" type="text" placeholder="{{ __('Email') }}"
                                        name="email">
                                </div>
                                <div class="col-12 col-md-4">
                                    <input class="form-control mt-2" type="text" placeholder="{{ __('Telephone') }}"
                                        name="telephone">
                                </div>
                                <div class="col-12 col-md-4">
                                    <input class="form-control mt-2" type="text" placeholder="{{ __('Position') }}"
                                        name="position">
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary float-right"
                                        onclick="addAuth()">Agregar</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-12" id="auth"></div>

                        <div class="row float-right mr-4">
                            <a href="{{ route('projects.index') }}" class="btn btn-rose">{{ __('CANCEL') }}</a>
                            <button onclick="$('#form-update').submit();" class="btn btn-primary">{{ __('SAVE') }}</button>
                        </div>
                    </div>

                    <br>

                    <!-- Fin -->

                </div>
            </div>




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

function nextCode(block, code) {
    idBlock = $('#budAccount').find('option:selected').val();
    if (idBlock == block) {
        $('#input-code').val(code);
    } else {
        var routeRequest = mainRoute + "budgetaccount/nextCode/" + idBlock;
        $.get(routeRequest, function(res) {
            $('#input-code').val(res);
        });
    }
}

$('.country').on('change', function() {

    // if country is Mexico
    if ($(this).val() == 142) {
        $('#state').load('/states')
    } else {
        $('#state').html(
            `<input class="form-control" class="" name="state" type="text" value="{{ $format->state }}" />`
        );
        $('#municipality').html(
            `<input class="form-control" class="" name="municipality" type="text" value="{{ $format->municipality }}" />`
        );
    }
});

$('.structure').on('change', function() {
    if ($(this).val() == 0)
        $('#input-structure-other').fadeIn();
    else
        $('#input-structure-other').fadeOut();
});

$('.quality').on('change', function() {
    if ($(this).val() == 0)
        $('#input-quality-other').fadeIn();
    else
        $('#input-quality-other').fadeOut();
});

$('.education').on('change', function() {
    if ($(this).val() == 1)
        $('.input-education-childs').fadeIn();
    else
        $('.input-education-childs').fadeOut();
});

$('.obtaining').on('change', function() {
    if ($(this).val() == 0)
        $('#input-obtaining-other').fadeIn();
    else
        $('#input-obtaining-other').fadeOut();
});

$('.has_water_lack').on('change', function() {
    if ($(this).val() == 1)
        $('#input-has_water_lack-other').fadeIn();
    else
        $('#input-has_water_lack-other').fadeOut();
});

$('#water_consumption_lt').on('change', function() {
    let rtotal = $('#water_consumption_lt').val() * 0.001;
    $('#water_consuption').val(rtotal + " m3");
});

$('#rainwater_area').on('change', function() {
    let total = $('#rainwater_area').val();
    if ($('.environment').val() == 0)
        multiplier = 20;
    else
        multiplier = 30;
    $('#storage').val(total * multiplier + " m3");
});

$('.environment').on('change', function() {
    let total = $('#rainwater_area').val();
    if ($('.environment').val() == 0)
        multiplier = 20;
    else
        multiplier = 30;
    $('#storage').val(total * multiplier + "m3");
});

$('#water_quality-other').on('click', function() {
    console.log($(this).is(':checked'));
    if ($(this).is(':checked'))
        $('#input-quality-other').fadeIn();
    else
        $('#input-quality-other').fadeOut();
});

var projectId = {{ $format->id }};


function addPlanning() {
    $.ajax({
        type: 'POST',
        url: '/entities',
        data: $('#form-planning').serialize(),
    }).done(function(data) {
        loadPlanning();
    });

};

function addAuth() {
    $.ajax({
        type: 'POST',
        url: '/entities',
        data: $('#form-auth').serialize(),
    }).done(function(data) {
        loadAuth();
    });

};

function removePerson(id) {
    console.log(id);
    $.ajax({
        type: 'DELETE',
        url: '/entities/'+id,
        data: {
            "_token": "{{ csrf_token() }}"
        }
    }).done(function(data) {
        loadAuth();
        loadPlanning();
    });
}

function loadPlanning() {
    $('#planning').load('/entities/'+projectId+'/0');
}

function loadAuth() {
    $('#auth').load('/entities/'+projectId+'/1');
}

saving = false;

function saveWork() {
    console.log(saving);
    if(!saving) {
        saving = true;
        $.ajax({
            type: "patch",
            url: "{{ route('projects.update', $format) }}",
            data: $('#form-update').serialize(),
            complete: function (response) {
                console.log('Saved');
                saving = false;
            }
        });
}
}

$(function() {
    loadPlanning();
    loadAuth();

    $("input").blur(function(){
        saveWork();
    });

    let total = $('#rainwater_area').val();
    if ($('.environment').val() == 0)
        multiplier = 20;
    else
        multiplier = 30;
    $('#storage').val(total * multiplier + " m3");

    let rtotal = $('#water_consumption_lt').val() * 0.001;
    $('#water_consuption').val(rtotal + " m3");
});




</script>

@endpush


{{-- unhiddenqueseaelvalorreal(specify...) --}}
