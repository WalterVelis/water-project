{{-- ThisFileisanAliasfor'create' --}}
@extends('layouts.app', ['activePage' => 'budgetaccount-management', 'menuParent' => 'catalog', 'sublevel' => 'budget', 'titlePage' => __('Gestión de Proyectos')])
<style>

form label, .col-form-label {
    font-size: 15px!important;
}

/* PDF, CSV, XLS */
/* 11:00 */
.form-check .form-check-label {
    padding-right: 0px!important;
}

.card .card-body .col-form-label, .card .card-body .label-on-right {
    text-align: left!important;
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

.nav-item.active {
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

.accordion .card-header[aria-expanded=false]:after {
    content: 'v';
    line-height: 0;
    font-family: ui-monospace;
    font-size: 1.2em;
    position: absolute;
    top: 50%;
    right: 1.5rem;
    transition: all .15s cubic-bezier(.68,-.55,.265,1.55);
    transform: translateY(-50%);
}

.accordion .card-header[aria-expanded=true]:after {
    content: '^';
    color:white;
    line-height: 0;
    position: absolute;
    top: 50%;
    right: 1.5rem;
    transition: all .15s cubic-bezier(.68,-.55,.265,1.55);
    transform: translateY(-50%);
}

.crd {
    margin-bottom: 15px!important;
    margin-top: 15px!important;
}

</style>
@section('content')
<input class="environment" type="hidden"  value="{{ $format->environment }}">
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div id="all-container">
                    <h3 style="margin-top:-10px;">
                    </h3>
                    <nav class="navbar step-navbar navbar-expand-lg c-nav">
                        <div class="container">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-bar navbar-kebab"></span>
                            <span class="navbar-toggler-bar navbar-kebab"></span>
                            <span class="navbar-toggler-bar navbar-kebab"></span>
                            </button>
                            <div class="" style="width:100%;" id="navbarNavDropdown">
                                <ul class="navbar-nav" style="">
                                    <li class="nav-item c-enabled">
                                        <a class="nav-link" href="{{ route('projects.edit', $format) }}">{{ __('Needs Diagnosis') }} <span class="sr-only">(current)</span></a>
                                    </li>
                                    <li class="nav-item active {{ $format->internal_status >= 0 ? "c-enabled" : "" }}">
                                        <a class="nav-link" href="{{ $format->internal_status >= 0 ? route('techformat.edit', $format) : "#" }}">{{ __('Technical Lift') }}</a>
                                    </li>
                                    <li class="nav-item {{ $format->internal_status > 2 && !App\User::hasPermissions("Tech") ? "c-enabled" : "" }}">
                                        <a class="nav-link" href="{{ $format->internal_status > 2 && !App\User::hasPermissions("Tech")  ? "/quotation/$format->id/edit" : "#" }}">{{ __('Quotation') }}</a>
                                    </li>
                                    <li class="nav-item {{ $format->internal_status == 6 ? "c-enabled" : "" }}">
                                        <a class="nav-link" href="{{ $format->internal_status == 6 ? "/order/$format->id/edit" : "#" }}">{{ __('Purchase Order') }}</a>
                                    </li>
                                    <li class="nav-item {{ $format->internal_status >= 1 ? "c-enabled" : "" }}">
                                        <a class="nav-link" href="{{ $format->internal_status >= 1 ? "/assignment/$format->id/edit" : "#" }}">{{ __('Assignment') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>

                    <div class="accordion" id="accordionExample">
                        <div class="card crd">
                            <div class="card-header bg-b" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h5 class="mb-0 text-uppercase d-inline">Levantamiento Técnico</h5>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <form action="{{ route('techformat.update', $techFormat->id) }}" method="post" id="form-techformat">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="status" class="set-status" value="0">
                                    <div class="card-body bg-white" style="max-height: 610px;overflow: scroll">
                                        <div class="col-12 col-md-12">
                                            <div class="col-12">
                                                <h4 class="mb-0 mt-2 d-inline" style="font-weight: bold!important">Características</h4>
                                                <a {{$format->internal_status >= 2 ? "href=/getTech/$format->id" : "#"}} >
                                                    <button {{$format->internal_status >= 2 ? "" : "disabled"}} class=" d-inline" style="{{$format->internal_status >= 2 ? "" : "opacity:0.4;"}} position: absolute; right: 0px;background: none; border: none; font-size: 1.5em;    width: 90px;" type="button">
                                                        <i class="fa fa-download" aria-hidden="true"></i>
                                                    </button>
                                                </a>
                                            </div>
                                            <label class="c_label col-12 col-form-label">{{ __('Water Quality') }}</label>
                                                <div class="row col-12">
                                                    @php
                                                        $water_quality = explode(",",$techFormat->water_quality);
                                                        $filter_type = explode(",",$techFormat->filter_type);
                                                        @endphp
                                                        {{-- @dd($water_quality, $techFormat->water_quality) --}}
                                                    <div class="col-12 col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input required {{ in_array(__('WC and Watering'), @$water_quality) ? 'checked' : '' }} id="water_quality-wc" name="water_quality[]" class="form-check-input" type="checkbox" value="{{ __('WC and Watering') }}"> {{ __('WC and Watering') }}
                                                                <span class="form-check-sign">
                                                                    <span class="check"></span>
                                                                </span>
                                                            </label>
                                                            <input style="{{ in_array(__('WC and Watering'), @$water_quality) ? '' : 'display:none;' }}" id="filter-quality-wc" type="text" name="filter_type[]" class="filter mt-3 form-control" placeholder="Tipo de filtro" value="{{ @$filter_type[0] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input required {{ in_array(__('Hygiene and personal care'), @$water_quality) ? 'checked' : '' }} id="water_quality-personal" name="water_quality[]" class="form-check-input" type="checkbox" value="{{ __('Hygiene and personal care') }}">
                                                                <div style="white-space: nowrap">{{ __('Hygiene and personal care') }}</div>
                                                                <span class="form-check-sign">
                                                                    <span class="check"></span>
                                                                </span>
                                                            </label>
                                                            <input style="{{ in_array(__('Hygiene and personal care'), @$water_quality) ? '' : 'display:none;' }}" id="filter-quality-personal" type="text" name="filter_type[]" class="filter mt-3 form-control" placeholder="Tipo de filtro" value="{{ @$filter_type[1] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input required {{ in_array(__('Purified'), @$water_quality) ? 'checked' : '' }} name="water_quality[]" id="water_quality-purified" class="form-check-input" type="checkbox" value="{{ __('Purified') }}"> {{ __('Purified') }}
                                                                <span class="form-check-sign">
                                                                    <span class="check"></span>
                                                                </span>
                                                            </label>
                                                            <input style="{{ in_array(__('Purified'), @$water_quality) ? '' : 'display:none;' }}" id="filter-quality-purified" type="text" name="filter_type[]" class="filter mt-3 form-control" placeholder="Tipo de filtro" value="{{ @$filter_type[2] }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input required {{ in_array(__('Other'), @$water_quality) ? 'checked' : '' }} name="water_quality[]" id="water_quality-other" class="form-check-input" type="checkbox" value="{{ __('Other') }}"> {{ __('Other') }}
                                                                <span class="form-check-sign">
                                                                    <span class="check"></span>
                                                                </span>
                                                            </label>
                                                            <input style="{{ in_array(__('Other'), @$water_quality) ? '' : 'display:none;' }}" id="filter-quality-other" type="text" name="filter_type[]" class="filter mt-3 form-control" placeholder="Tipo de filtro" value="{{ @$filter_type[3] }}">
                                                        </div>
                                                    </div>
                                                <div class="col-12 col-md-3">
                                                    <input id="input-quality-other" value="{{ end($water_quality) }}" name="water_quality[]" style="    margin-top: -10px !important; {{ in_array(__('Other'), $water_quality) ? '' : 'display:none;' }}" class="form-control mt-2" type="text" placeholder="{{ __('Especifique...') }}">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-12 col-md-12">
                                            <label class="c_label col-12 col-form-label">{{ __('Roof Type') }}</label>
                                            @php
                                                $roof_type = explode(",",$techFormat->roof_type);
                                            @endphp
                                            <div class="row col-sm-12 mt-2" id="t-te">
                                                <div class="col-12 col-md-3">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input required {{ in_array(__('Arch Ceiling'), $roof_type) ? 'checked' : '' }} name="roof_type[]" class="form-check-input" type="checkbox" value="{{ __('Arch Ceiling') }}"> {{ __('Arch Ceiling') }}
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input required {{ in_array(__('Two Waters'), $roof_type) ? 'checked' : '' }} name="roof_type[]" class="form-check-input" type="checkbox" value="{{ __('Two Waters') }}"> {{ __('Two Waters') }}
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input required {{ in_array(__('Flat With Pending'), $roof_type) ? 'checked' : '' }} name="roof_type[]" class="form-check-input" type="checkbox" value="{{ __('Flat With Pending') }}"> {{ __('Flat With Pending') }}
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input required {{ in_array(__('Flat Without Pending'), $roof_type) ? 'checked' : '' }} name="roof_type[]" class="form-check-input" type="checkbox" value="{{ __('Flat Without Pending') }}">
                                                            {{ __('Flat Without Pending') }}
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-12">
                                            <label class="c_label col-12 col-form-label">{{ __('Acabado azotea') }}</label>
                                            @php
                                                $rooftop = explode(",",$techFormat->rooftop);
                                            @endphp
                                            <fieldset id="chk-azotea">
                                            <div class="row col-sm-12 mt-2">
                                                <div class="col-12 col-md-3">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input required {{ in_array(__('Enladrillado'), $rooftop) ? 'checked' : '' }} name="rooftop[]" class="form-check-input" type="checkbox" value="{{ __('Enladrillado') }}"> {{ __('Enladrillado') }}
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input required {{ in_array(__('Imp. acrílico'), $rooftop) ? 'checked' : '' }} name="rooftop[]" class="form-check-input" type="checkbox" value="{{ __('Imp. acrílico') }}"> {{ __('Imp. acrílico') }}
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input required {{ in_array(__('Concreto'), $rooftop) ? 'checked' : '' }} name="rooftop[]" class="form-check-input" type="checkbox" value="{{ __('Concreto') }}"> {{ __('Concreto') }}
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input required {{ in_array(__('Imp. prefabricado arenoso'), $rooftop) ? 'checked' : '' }} name="rooftop[]" class="form-check-input" type="checkbox" value="{{ __('Imp. prefabricado arenoso') }}">
                                                            {{ __('Imp. prefabricado arenoso') }}
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            </fieldset>
                                        </div>

                                        <div class="row">
                                            <label class="c_label col-12 col-form-label ml-4 mt-5">{{ __('Área de captación de agua de lluvia estimada (m2)') }}</label>
                                            <div class="col-12 col-md-6">
                                                <label class="c_label col-12 col-form-label">{{ __('Techo (m2)') }}</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" id="rainwater_area" name="rainwater_area" type="number" value="{{ $techFormat->rainwater_area }}" />
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label class="c_label col-12 col-form-label">{{ __('Canaletas (pulgadas/metros)') }}</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" id="gutter" name="gutter" type="text" value="{{ $techFormat->gutter }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <label style="" class="c_label col-12 col-form-label">{{ __('Promedio anual de precipitación pluvial de la zona (m3)') }}</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" id="anual_precipitation" name="anual_precipitation" type="number" value="{{ $techFormat->anual_precipitation }}" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label style="" class="c_label col-12 col-form-label">{{ __('Promedio anual de captación de lluvia estimada (lts)') }}</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" disabled id="pa" name="" type="text" value="" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label style="" class="c_label col-12 col-form-label">{{ __('Volumen de almacenamiento cisterna (m3)') }}</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" disabled id="va" name="" type="text" value="" />
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label" style="    padding-right: 25px!important;">{{ __('Volumen del tinaco que surte a servicio (L)') }}</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" id="" name="water_tank" type="text" value="{{ $techFormat->water_tank }}" />
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label">{{ __('Distancia de área de captación a cisterna (M)') }}</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" id="" name="distance" type="text" value="{{ $techFormat->distance }}" />
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label" style="padding-right: 50px!important;">{{ __('Estado del nivel de limpieza del techo') }}</label>
                                                <div class="col-sm-12">
                                                    {{-- <input required class="form-control" id="" name="cleanliness" type="text" value="{{ $techFormat->cleanliness }}" /> --}}
                                                    <select class="form-control" name="cleanliness">
                                                        <option disabled selected value="">Seleccione una opción</option>
                                                        <option {{ $techFormat->cleanliness == 0 ? 'selected' : '' }} value="0">{{ __('Limpio y Despejado') }}</option>
                                                        <option {{ $techFormat->cleanliness == 1 ? 'selected' : '' }} value="1"> {{ __('Sucio con obstaculos') }} </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label">{{ __('Cuentan con bajantes de techo') }}</label>
                                                <div class="col-sm-12">
                                                    {{-- <input required class="form-control" id="" name="roof_slope" type="text" value="{{ $techFormat->roof_slope }}" /> --}}
                                                    <select class="form-control" name="roof_slope">
                                                        <option disabled selected value="">Seleccione una opción</option>
                                                        <option {{ $techFormat->roof_slope == 0 ? 'selected' : '' }} value="0">{{ __('No') }}</option>
                                                        <option {{ $techFormat->roof_slope == 1 ? 'selected' : '' }} value="1"> {{ __('Sí') }} </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <span class="col-12 mt-4">Otras consideraciones técnicas existentes</span>

                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label">{{ __('Tubería (tipo y diametro)') }}</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" id="" name="tube" type="text" value="{{ $techFormat->tube }}" />
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label">{{ __('Red diametro (pulgadas)') }}</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" id="" name="diameter" type="text" value="{{ $techFormat->diameter }}" />
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label">{{ __('Bomba (potencia/diametro)') }}</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" id="" name="pump" type="text" value="{{ $techFormat->pump }}" />
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label">{{ __('Succión diametro (1")') }}</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" id="" name="diameter_inch" type="text" value="{{ $techFormat->diameter_inch }}" />
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label">{{ __('¿Cuarto Bombas debajo cisterna?') }}</label>
                                                <div class="col-sm-12">
                                                    {{-- <input required class="form-control" id="" name="pump_below_tank" type="text" value="{{ $techFormat->pump_below_tank }}" /> --}}
                                                    <select class="form-control" name="pump_below_tank">
                                                        <option disabled selected value="">Seleccione una opción</option>
                                                        <option {{ $techFormat->pump_below_tank == 0 ? 'selected' : '' }} value="0">{{ __('No') }}</option>
                                                        <option {{ $techFormat->pump_below_tank == 1 ? 'selected' : '' }} value="1"> {{ __('Sí') }} </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label">{{ __('¿Riesgo de inundacion bombas?') }}</label>
                                                <div class="col-sm-12">
                                                    {{-- <input required class="form-control" id="" name="cleanliness" type="text" value="{{ $techFormat->pump_inundation }}" /> --}}
                                                    <select class="form-control" name="pump_inundation">
                                                        <option disabled selected value="">Seleccione una opción</option>
                                                        <option {{ $techFormat->pump_inundation == 0 ? 'selected' : '' }} value="0">{{ __('No') }}</option>
                                                        <option {{ $techFormat->pump_inundation == 1 ? 'selected' : '' }} value="1"> {{ __('Sí') }} </option>
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label">{{ __('¿Espacio filtros necesita caseta?') }}</label>
                                                <div class="col-sm-12">
                                                    {{-- <input required class="form-control" id="" name="cleanliness" type="text" value="{{ $techFormat->filter_stall }}" /> --}}
                                                    <select class="form-control" name="filter_stall">
                                                        <option disabled selected value="">Seleccione una opción</option>
                                                        <option {{ $techFormat->filter_stall == 0 ? 'selected' : '' }} value="0">{{ __('No') }}</option>
                                                        <option {{ $techFormat->filter_stall == 1 ? 'selected' : '' }} value="1"> {{ __('Sí') }} </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-12">
                                                <label class="c_label col-12 col-form-label">{{ __('Notas') }}</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" id="" name="notes" type="text" value="{{ $techFormat->notes }}" />
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <span class="col-12 mt-4">Otros detalles</span>
                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label">{{ __('Excavación') }}</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" id="" name="excavation" type="text" value="{{ $techFormat->excavation }}" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label">{{ __('Doble Flotador') }}</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" name="d_float">
                                                        <option disabled selected value="">Seleccione una opción</option>
                                                        <option {{ $techFormat->d_float == 0 ? 'selected' : '' }} value="0">{{ __('No') }}</option>
                                                        <option {{ $techFormat->d_float == 1 ? 'selected' : '' }} value="1"> {{ __('Sí') }} </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label">{{ __('Control') }}</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" name="control">
                                                        <option disabled selected value="">Seleccione una opción</option>
                                                        <option {{ $techFormat->control == 0 ? 'selected' : '' }} value="0">{{ __('Manual') }}</option>
                                                        <option {{ $techFormat->control == 1 ? 'selected' : '' }} value="1"> {{ __('Automático') }} </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label">{{ __('Necesita conexión eléctrica') }}</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" name="require_connection">
                                                        <option disabled selected value="">Seleccione una opción</option>
                                                        <option {{ $techFormat->require_connection == 0 ? 'selected' : '' }} value="0">{{ __('No') }}</option>
                                                        <option {{ $techFormat->require_connection == 1 ? 'selected' : '' }} value="1"> {{ __('Sí') }} </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label">{{ __('Electroniveles') }}</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" name="electro">
                                                        <option disabled selected value="">Seleccione una opción</option>
                                                        <option {{ $techFormat->electro == 0 ? 'selected' : '' }} value="0">{{ __('No') }}</option>
                                                        <option {{ $techFormat->electro == 1 ? 'selected' : '' }} value="1"> {{ __('Sí') }} </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <label class="c_label col-12 col-form-label">{{ __('Notas Adicionales') }}</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" id="" name="subnotes" type="text" value="{{ $techFormat->subnotes }}" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <label class="c_label col-12 col-form-label">{{ __('Descripción del área y condiciones del inmueble donde se implementa el sistema') }}</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" id="" name="description" type="text" value="{{ $techFormat->description }}" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 mt-3">
                                                <label class="c_label col-12 col-form-label">{{ __('¿Es factible?') }}</label>
                                                <div class="col-sm-12">
                                                    <input {{ $format->status == 3 ? 'checked' : '' }} class="d-inline mt-3" name="factible" type="radio" value="0" id="is_factible" /> <label class="mr-3" for="is_factible">Es factible</label>
                                                    <input {{ $format->status == 2 ? 'checked' : '' }} class="d-inline" name="factible" type="radio" value="1" id="is_not_factible" /> <label for="is_not_factible">No es factible</label>
                                                </div>
                                                <div id="feasible" class="col-12 col-md-12 mt-0" style="{{ $format->status == 2 ? "" : "display:none;" }}">
                                                    <input name="why_not_feasible" type="text" class="form-control" placeholder="¿Por qué?" value="{{ $format->why_not_feasible }}">
                                                </div>
                                            </div>
                                            @if (App\User::hasPermissions("Admin") || App\User::hasPermissions("Tech"))
                                            <div class="row w-100">
                                                <div class="col-12 col-md-8">
                                                </div>
                                                <div class="col-12 col-md-2">
                                                    {{-- <a href="{{ route('projects.index') }}" class="btn btn-rose float-right">{{ __('CANCEL') }}</a> --}}
                                                </div>
                                                <div class="col-12 col-md-2">
                                                    <button onclick="saveForm();" class="btn btn-primary">{{ __('SAVE') }}</button>

                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @if (App\User::hasPermissions("Admin") || App\User::hasPermissions("Tech"))
                        <div class="card crd">
                            <div class="card-header bg-b" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h5 class="mb-0 text-uppercase d-inline">Mano de obra y Herramientas</h5><div style="color:white; margin-right: 26px;" class="d-inline float-right" id="total-cost">$0.00</div>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body bg-white" style="overflow-x: auto;">
                                    {{-- <a href="/getMO/{{ $format->id }}">
                                        <button class=" d-inline" style="position: absolute; right: 0px;background: none; border: none; font-size: 1.5em;    width: 90px;" type="button">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                        </button>
                                    </a> --}}



                                    <div class="dropdown" style="position: absolute; right: 0px;">
                                        <button title="Download Data" class="dropdown-toggle" style="background: none; border: none; font-size: 1.5em;    width: 90px;" type="button" id="costmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="costmenu">
                                            <a class="dropdown-item" href="/costProjectCsv/{{ $format->id }}"><p class=""><i class="fa fa-file-code-o" aria-hidden="true"></i>&nbsp; CSV</p></a>
                                            <a class="dropdown-item" href="/costProjectExcel/{{ $format->id }}"><p class=""><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp; XLSX</p></a>
                                            <a class="dropdown-item" href="/getMO/{{ $format->id }}"><p class=""><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; PDF</p></a>
                                        </div>
                                    </div>

                                    @if (App\User::hasPermissions("Tech"))
                                    <form action="" id="form-costformat">
                                        @csrf
                                        <div class="row">
                                            <div class="col-4">
                                                <input required type="text" name="day" class="form-control" placeholder="Días" required>
                                                <input required type="hidden" name="format_id" class="form-control" value="{{ $techFormat->id }}" required>
                                            </div>
                                            <div class="col-4">
                                                <select required name="cost_id" id="" class="form-control">
                                                    <option disabled selected value="">Seleccione una opción</option>
                                                    @foreach($costs as $cost)
                                                        <option value="{{ $cost->id }}">{{ $cost->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-2">
                                                <button type="button" onclick="addCost()" class="btn btn-primary">Agregar</button>
                                            </div>
                                        </div>
                                    </form>
                                    @endif
                                    <div id="costs"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card crd">
                            <div class="card-header bg-b" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <h5 class="mb-0 text-uppercase d-inline">Listado de Materiales</h5><div style="color:white; margin-right: 26px;" class="d-inline float-right" id="total-material">$0.00</div>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                <div class="card-body bg-white" style="overflow-x: auto;">
                                    @if (App\User::hasPermissions("Tech"))
                                    <form action="" id="form-materialformat">
                                        @csrf
                                        <div class="row">
                                            <div class="col-4">
                                                <select required name="material_id" id="" class="form-control">
                                                    <option disabled selected value="">Seleccione una opción</option>
                                                    @foreach($materials as $material)
                                                        <option value="{{ $material->id }}">{{ $material->name }}, {{ $material->unitLabel() }}, {{ $material->type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <input required type="number" name="qty" class="form-control" placeholder="Cantidad" required>
                                                <input required type="hidden" name="format_id" class="form-control" value="{{ $techFormat->id }}" required>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" onclick="addMaterial()" class="btn btn-primary">Agregar</button>
                                            </div>
                                        </div>

                                    </form>
                                    @endif
                                    <div>
                                        {{-- <a href="/getMat/{{ $format->id }}">
                                            <button class=" d-inline" style="    top: 20px;position: absolute; right: 0px;background: none; border: none; font-size: 1.5em;    width: 90px;" type="button">
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                            </button>
                                        </a> --}}

                                        <div class="dropdown" style="position: absolute; right: 0px;top:20px;">
                                            <button title="Download Data" class="dropdown-toggle" style="background: none; border: none; font-size: 1.5em;    width: 90px;" type="button" id="materialmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="materialmenu">
                                                <a class="dropdown-item" href="/materialProjectCsv/{{ $format->id }}"><p class=""><i class="fa fa-file-code-o" aria-hidden="true"></i>&nbsp; CSV</p></a>
                                                <a class="dropdown-item" href="/materialProjectExcel/{{ $format->id }}"><p class=""><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp; XLSX</p></a>
                                                <a class="dropdown-item" href="/getMat/{{ $format->id }}"><p class=""><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; PDF</p></a>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="mt-5" id="materials"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card crd">
                            <div class="card-header bg-b" id="headingFour" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <h5 class="mb-0 text-uppercase d-inline">KIT Isla Urbana</h5><div style="color:white; margin-right: 26px;" class="d-inline float-right" id="total-accesory">$0.00</div>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                <div class="card-body bg-white" style="overflow-x: auto;">
                                    @if (App\User::hasPermissions("Admin") || App\User::hasPermissions("Tech"))
                                    {{-- <a href="/getKit/{{ $format->id }}">
                                        <button class=" d-inline" style="    position: absolute; right: 0px;background: none; border: none; font-size: 1.5em;    width: 90px;" type="button">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                        </button>
                                    </a> --}}

                                    <div class="dropdown" style="position: absolute; right: 0px;">
                                        <button title="Download Data" class="dropdown-toggle" style="background: none; border: none; font-size: 1.5em;    width: 90px;" type="button" id="kitmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="kitmenu">
                                            <a class="dropdown-item" href="/accesoryProjectCsv/{{ $format->id }}"><p class=""><i class="fa fa-file-code-o" aria-hidden="true"></i>&nbsp; CSV</p></a>
                                            <a class="dropdown-item" href="/accesoryProjectExcel/{{ $format->id }}"><p class=""><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp; XLSX</p></a>
                                            <a class="dropdown-item" href="/getKit/{{ $format->id }}"><p class=""><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; PDF</p></a>
                                        </div>
                                    </div>

                                    @endif
                                    @if (App\User::hasPermissions("Tech"))
                                    <form action="" id="form-accesoryformat">
                                        @csrf
                                        <div class="row">
                                            <div class="col-4">
                                                <select name="accesory_id" id="" class="form-control" required>
                                                    <option disabled selected value="">Seleccione una opción</option>
                                                    @foreach($accesories as $accesory)
                                                        <option value="{{ $accesory->id }}">{{ $accesory->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <input required type="text" name="qty" class="form-control" placeholder="Piezas">
                                                <input required type="hidden" name="format_id" class="form-control" value="{{ $techFormat->id }}">
                                            </div>
                                            <div class="col-2">
                                                <button type="button" onclick="addAccesory()" class="btn btn-primary">Agregar</button>
                                            </div>
                                        </div>
                                    </form>
                                    @endif
                                    <div id="accesories" class="mt-5"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                        <form id="form-update" method="post" action="{{ route('projects.update', $techFormat->format) }}" autocomplete="off" class="form-horizontal">
                            @csrf
                            @method('patch')
                        </form>

                    <br>

                    @if (App\User::hasPermissions("Admin") || App\User::hasPermissions("Tech"))
                    <div class="row w-100">
                        <div class="col-12 col-md-12" style="    text-align: right;">
                            <button id="finish" {{ $format->status == 2 ? "disabled" : "" }} onclick="sendForm()" class="{{ $format->status == 2 ? "disabled" : "" }} btn btn-primary">{{ __('FINALIZAR') }}</button>
                        </div>
                        {{-- <div class="col-12 col-md-2">
                            <a href="{{ route('projects.index') }}" class="btn btn-rose float-right">{{ __('CANCEL') }}</a>
                        </div> --}}
                    </div>
                    @endif
                    <!-- Fin -->

                </div>

            </div>




        </div>
    </div>
    <footer class="footer">
        <div class="container-fluid">
            <div class="copyright "> &copy; <script> document.write(new Date().getFullYear()) </script> Cotizador AguaH2O, Todos los derechos reservados. Desarrollado por ISINET.</div>
        </div>
    </footer>
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
            `<input required class="form-control" class="" name="state" type="text" value="{{ $techFormat->state }}" />`
        );
        $('#municipality').html(
            `<input required class="form-control" class="" name="municipality" type="text" value="{{ $techFormat->municipality }}" />`
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


$('.environment').on('change', function() {
    let total = $('#rainwater_area').val();
    if ($('.environment').val() == 0)
        multiplier = 20;
    else
        multiplier = 30;
    $('#va').val(total * multiplier * 0.85);
});

$('#water_quality-other').on('click', function() {
    console.log($(this).is(':checked'));
    if ($(this).is(':checked'))
        {
            $('#input-quality-other').fadeIn();
            $('#filter-quality-other').fadeIn();
            $('#filter-quality-other').addClass("required");
        }
    else
        {$('#input-quality-other').fadeOut();
        $('#filter-quality-other').fadeOut();
        $('#filter-quality-other').removeClass("required");
        $('#filter-quality-other').val("");
    }
});

$('#water_quality-wc').on('click', function() {
    console.log($(this).is(':checked'));
    if ($(this).is(':checked'))
        {$('#input-quality-wc').fadeIn();
        $('#filter-quality-wc').fadeIn();
        $('#filter-quality-wc').addClass("required");}
    else
        {$('#input-quality-wc').fadeOut();
        $('#filter-quality-wc').fadeOut();
        $('#filter-quality-wc').removeClass("required");
        $('#filter-quality-wc').val("");}
});

$('#water_quality-personal').on('click', function() {
    console.log($(this).is(':checked'));
    if ($(this).is(':checked'))
        {$('#input-quality-personal').fadeIn();
        $('#filter-quality-personal').fadeIn();
        $('#filter-quality-personal').addClass("required");}
    else
        {$('#input-quality-personal').fadeOut();
        $('#filter-quality-personal').fadeOut();
        $('#filter-quality-personal').removeClass("required");
        $('#filter-quality-personal').val("");}
});

$('#water_quality-purified').on('click', function() {
    console.log($(this).is(':checked'));
    if ($(this).is(':checked'))
        {$('#input-quality-purified').fadeIn();
        $('#filter-quality-purified').fadeIn();
        $('#filter-quality-purified').addClass("required");}
    else
        {$('#input-quality-purified').fadeOut();
        $('#filter-quality-purified').fadeOut();
        $('#filter-quality-purified').removeClass("required");
        $('#filter-quality-purified').val("");}
});

function saveForm() {

    $("span.error").remove();
    hasErrors = false;



    if($('input[name="rooftop[]"]:checked').length <= 0) {
        // $.notify(
        //     { message: 'Debe seleccionar al menos un Acabado de Azotea' },
        //     { type: 'danger' }
        // );
        $('#chk-azotea').after('<span class="error text-danger" style="text-align:left;">Campo obligatorio</span>');
        hasErrors = true;
    }

    if($('#filter-quality-other').hasClass("required") && $('#filter-quality-other').val() == "") {
        $("#filter-quality-other").after('<span class="error text-danger" style="text-align:left;">Campo obligatorio</span>');
        hasErrors = true;
    }

    if($('#filter-quality-personal').hasClass("required") && $('#filter-quality-personal').val() == "") {
        $('#filter-quality-personal').after('<span class="error text-danger" style="text-align:left;">Campo obligatorio</span>');
        hasErrors = true;
    }

    if($('#filter-quality-purified').hasClass("required") && $('#filter-quality-purified').val() == "") {
        $('#filter-quality-purified').after('<span class="error text-danger" style="text-align:left;">Campo obligatorio</span>');
        hasErrors = true;
    }

    if($('#filter-quality-wc').hasClass("required") && $('#filter-quality-wc').val() == "") {
        $('#filter-quality-wc').after('<span class="error text-danger" style="text-align:left;">Campo obligatorio</span>');
        hasErrors = true;
    }

    if($('input[name="roof_type[]"]:checked').length <= 0) {
        // $.notify({
        //     // options
        //     message: 'Debe seleccionar al menos un Tipo de Techo para Captación de Agua'
        // },{
        //     // settings
        //     type: 'danger'
        // });
        $('#t-te').after('<span class="error text-danger" style="text-align:left;">Campo obligatorio</span>');
        hasErrors = true;
    }

    if(hasErrors) {
        return;
    }

    $('#form-techformat').submit();
    $.notify({
            // options
            message: 'Formulario guardado exitosamente'
    },{
        // settings
        type: 'success'
    });
}

var projectId = {{ $techFormat->id }};


function addCost() {
    $.ajax({
        type: 'POST',
        url: '/costformat',
        data: $('#form-costformat').serialize(),
    }).done(function(data) {
        loadCosts();
        $('#form-costformat').trigger("reset");

    });

};

function addMaterial() {
    $.ajax({
        type: 'POST',
        url: '/materialformat',
        data: $('#form-materialformat').serialize(),
    }).done(function(data) {
        loadMaterials();
        $('#form-materialformat').trigger("reset");
    });

};

function addAccesory() {
    $.ajax({
        type: 'POST',
        url: '/accesoryformat',
        data: $('#form-accesoryformat').serialize(),
    }).done(function(data) {
        loadAccesory();
        $('#form-accesoryformat').trigger("reset");
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
        loadCosts();
    });
}

function loadCosts() {
    $('#costs').load('/getCosts/'+projectId);
}
function loadMaterials() {
    $('#materials').load('/getMaterials/'+projectId);
}
function loadAccesory() {
    $('#accesories').load('/getAccesories/'+projectId);
}

saving = false;

function saveWork() {
    console.log(saving);
    if(!saving) {
        saving = true;
        $.ajax({
            type: "put",
            url: "{{ route('techformat.update', $techFormat->format) }}",
            data: $('#form-techformat').serialize(),
            complete: function (response) {
                console.log('Saved');
                saving = false;
            }
        });
    }
}

$('#anual_precipitation').change(() => {
    console.log('l');
    nval = $('#anual_precipitation').val() * $('#rainwater_area').val() * 0.85;
    $('#pa').val(nval)
});
$('#rainwater_area').change(() => {
    nval = $('#anual_precipitation').val() * $('#rainwater_area').val() * 0.85;
    $('#pa').val(nval)

    let total = $('#rainwater_area').val();
    if ($('.environment').val() == 0)
        multiplier = 20;
    else
        multiplier = 30;
        $('#va').val(total * multiplier * 0.85 + "m3");
});




$(function() {
    loadCosts();
    loadMaterials();
    loadAccesory();

    @if (App\User::hasPermissions("Vendor"))
    $('.container input').prop('readonly', 'true');
    $('.container input').prop('disabled', 'true');
    $('.container select').prop('readonly', 'true');
    $('.container select').prop('disabled', 'true');
    @endif

    // setTotals();
    nval = $('#anual_precipitation').val() * $('#rainwater_area').val() * 0.85;
    $('#pa').val(nval)
    let total2 = $('#rainwater_area').val();
    if ($('.environment').val() == 0)
        multiplier = 20;
    else
        multiplier = 30;
    $('#va').val(total2 * multiplier * 0.85 + "m3");
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

@if($format->status == 4)
    $('input, select').attr('readonly', 'true');
    $('input, select').attr('disabled', 'true');
@endif


$('input:radio[name="factible"]').change(
    function(){
        console.log($(this).val());
        if ($(this).val() == 1) {
            // no factible
            $('#feasible').fadeIn();
            $('#finish').prop('disabled', true);
            $('#finish').addClass('disabled');
            console.log('nfac');
        } else {
            $('#feasible').fadeOut();
            $('#finish').prop('disabled', false);
            $('#finish').removeClass('disabled');
        }
});

@if (!App\User::hasPermissions("Admin") && !App\User::hasPermissions("Tech"))
$(document).ready(function () {
    $('input, select, textarea, radio').prop('disabled', true);
    $('input, select, textarea, radio').addClass('disabled');
});
@endif

function sendForm() {

    $("span.error").remove();
    hasErrors = false;



    if($('input[name="rooftop[]"]:checked').length <= 0) {
        // $.notify(
        //     { message: 'Debe seleccionar al menos un Acabado de Azotea' },
        //     { type: 'danger' }
        // );
        $('#chk-azotea').after('<span class="error text-danger" style="text-align:left;">Campo obligatorio</span>');
        hasErrors = true;
    }

    if($('#filter-quality-other').hasClass("required") && $('#filter-quality-other').val() == "") {
        $("#filter-quality-other").after('<span class="error text-danger" style="text-align:left;">Campo obligatorio</span>');
        hasErrors = true;
    }

    if($('#filter-quality-personal').hasClass("required") && $('#filter-quality-personal').val() == "") {
        $('#filter-quality-personal').after('<span class="error text-danger" style="text-align:left;">Campo obligatorio</span>');
        hasErrors = true;
    }

    if($('#filter-quality-purified').hasClass("required") && $('#filter-quality-purified').val() == "") {
        $('#filter-quality-purified').after('<span class="error text-danger" style="text-align:left;">Campo obligatorio</span>');
        hasErrors = true;
    }

    if($('#filter-quality-wc').hasClass("required") && $('#filter-quality-wc').val() == "") {
        $('#filter-quality-wc').after('<span class="error text-danger" style="text-align:left;">Campo obligatorio</span>');
        hasErrors = true;
    }

    if($('input[name="roof_type[]"]:checked').length <= 0) {
        // $.notify({
        //     // options
        //     message: 'Debe seleccionar al menos un Tipo de Techo para Captación de Agua'
        // },{
        //     // settings
        //     type: 'danger'
        // });
        $('#t-te').after('<span class="error text-danger" style="text-align:left;">Campo obligatorio</span>');
        hasErrors = true;
    }

    if(hasErrors) {
        return;
    }

    $('.set-status').val(1);
    $('#form-techformat').submit();
    $.notify({
            // options
            message: 'Formulario finalizado exitosamente'
    },{
        // settings
        type: 'success'
    });
}

</script>

@endpush


{{-- unhiddenqueseaelvalorreal(specify...) --}}
