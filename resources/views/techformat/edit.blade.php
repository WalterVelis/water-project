{{-- ThisFileisanAliasfor'create' --}}
@extends('layouts.app', ['activePage' => 'budgetaccount-management', 'menuParent' => 'catalog', 'sublevel' => 'budget', 'titlePage' => __('Gestión de Proyectos')])
<style>
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
                            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                <ul class="navbar-nav" style="">
                                    <li class="nav-item {{ $format->internal_status >= 0 ? "c-enabled" : "" }}">
                                        <a class="nav-link" href="{{ $format->internal_status >= 0 ? route('projects.edit', $format) : "#" }}">{{ __('Needs Diagnosis') }}</a>
                                    </li>
                                    <li class="nav-item active {{ $format->internal_status >= 1 ? "c-enabled" : "" }}">
                                        <a class="nav-link" href="{{ $format->internal_status >= 1 ? route('techformat.edit', $format) : "#" }}">{{ __('Technical Lift') }}</a>
                                    </li>
                                    <li class="nav-item {{ $format->internal_status >= 2 ? "c-enabled" : "" }}">
                                        <a class="nav-link" href="{{ $format->internal_status >= 2 ? "/quotation/$format->id/edit" : "#" }}">{{ __('Quotation') }}</a>
                                    </li>
                                    <li class="nav-item {{ $format->internal_status >= 3 ? "c-enabled" : "" }}">
                                        <a class="nav-link" href="{{ $format->internal_status >= 3 ? "/order/$format->id" : "#" }}">{{ __('Purchase Order') }}</a>
                                    </li>
                                    <li class="nav-item {{ $format->internal_status >= 4 ? "c-enabled" : "" }}">
                                        <a class="nav-link" href="{{ $format->internal_status >= 4 ? "/assignment/$format->id" : "#" }}">{{ __('Assignment') }}</a>
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
                                    <div class="card-body bg-white" style="max-height: 540px;overflow: scroll">
                                        <div class="col-12 col-md-12">
                                            <h4 class="mb-0 mt-2" style="font-weight: bold!important">Características</h4>
                                            <label class="c_label col-12 col-form-label">{{ __('Water Quality') }}</label>
                                                <div class="row col-12">
                                                    @php
                                                        $water_quality = explode(",",$techFormat->water_quality);
                                                    @endphp
                                                    <div class="col-12 col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input required {{ in_array(__('WC and Watering'), $water_quality) ? 'checked' : '' }} name="water_quality[]" class="form-check-input" type="checkbox" value="{{ __('WC and Watering') }}"> {{ __('WC and Watering') }}
                                                                <span class="form-check-sign">
                                                                    <span class="check"></span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input required {{ in_array(__('Hygiene and personal care'), $water_quality) ? 'checked' : '' }} name="water_quality[]" class="form-check-input" type="checkbox" value="{{ __('Hygiene and personal care') }}">
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
                                                                <input required {{ in_array(__('Purified'), $water_quality) ? 'checked' : '' }} name="water_quality[]" class="form-check-input" type="checkbox" value="{{ __('Purified') }}"> {{ __('Purified') }}
                                                                <span class="form-check-sign">
                                                                    <span class="check"></span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-2">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input required {{ in_array(__('Other'), $water_quality) ? 'checked' : '' }} name="water_quality[]" id="water_quality-other" class="form-check-input" type="checkbox" value="{{ __('Other') }}"> {{ __('Other') }}
                                                                <span class="form-check-sign">
                                                                    <span class="check"></span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                <div class="col-12 col-md-4">
                                                    <input required id="input-quality-other" value="{{ end($water_quality) }}" name="water_quality[]" style="{{ in_array(__('Other'), $water_quality) ? '' : 'display:none;' }}" class="form-control mt-2" type="text" placeholder="{{ __('specify...') }}">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-12 col-md-12">
                                            <label class="c_label col-12 col-form-label">{{ __('Roof Type') }}</label>
                                            @php
                                                $roof_type = explode(",",$techFormat->roof_type);
                                            @endphp
                                            <div class="row col-sm-12 mt-2">
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
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label class="c_label col-12 col-form-label">{{ __('Techo') }}</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" id="rainwater_area" name="rainwater_area" type="number" value="{{ $techFormat->rainwater_area }}" />
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label class="c_label col-12 col-form-label">{{ __('Canaletas') }}</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" id="gutter" name="gutter" type="text" value="{{ $techFormat->gutter }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <label style="" class="c_label col-12 col-form-label">{{ __('Promedio anual de precipitación pluvial de la zona (mm)') }}</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" id="anual_precipitation" name="anual_precipitation" type="text" value="{{ $techFormat->anual_precipitation }}" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label style="" class="c_label col-12 col-form-label">{{ __('Promedio anual de captación de lluvia estimada') }}</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" disabled id="pa" name="" type="text" value="" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label style="" class="c_label col-12 col-form-label">{{ __('Volumen de almacenamiento cisterna (lts)') }}</label>
                                                <div class="col-sm-12">
                                                    <input required class="form-control" disabled id="va" name="" type="text" value="" />
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label">{{ __('Tinaco que surte a servicio (L)') }}</label>
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
                                                <label class="c_label col-12 col-form-label">{{ __('Nivel de limpieza del techo') }}</label>
                                                <div class="col-sm-12">
                                                    {{-- <input required class="form-control" id="" name="cleanliness" type="text" value="{{ $techFormat->cleanliness }}" /> --}}
                                                    <select class="form-control" name="cleanliness">
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
                                                        <option {{ $techFormat->d_float == 0 ? 'selected' : '' }} value="0">{{ __('No') }}</option>
                                                        <option {{ $techFormat->d_float == 1 ? 'selected' : '' }} value="1"> {{ __('Sí') }} </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label">{{ __('Control') }}</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" name="control">
                                                        <option {{ $techFormat->control == 0 ? 'selected' : '' }} value="0">{{ __('Manual') }}</option>
                                                        <option {{ $techFormat->control == 1 ? 'selected' : '' }} value="1"> {{ __('Automático') }} </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label">{{ __('Necesita conexión eléctrica') }}</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" name="require_connection">
                                                        <option {{ $techFormat->require_connection == 0 ? 'selected' : '' }} value="0">{{ __('No') }}</option>
                                                        <option {{ $techFormat->require_connection == 1 ? 'selected' : '' }} value="1"> {{ __('Sí') }} </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label class="c_label col-12 col-form-label">{{ __('Electroniveles') }}</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" name="electro">
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
                                            <div class="row w-100">
                                                <div class="col-12 col-md-8">
                                                </div>
                                                <div class="col-12 col-md-2">
                                                    <a href="{{ route('projects.index') }}" class="btn btn-rose float-right">{{ __('CANCEL') }}</a>
                                                </div>
                                                <div class="col-12 col-md-2">
                                                    <button onclick="$('#form-techformat').submit();" class="btn btn-primary">{{ __('SAVE') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card crd">
                            <div class="card-header bg-b" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h5 class="mb-0 text-uppercase d-inline">Mano de obra y Herramientas</h5><div style="color:white; margin-right: 26px;" class="d-inline float-right" id="total-cost">$0.00</div>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body bg-white">
                                    <form action="" id="form-costformat">
                                        @csrf
                                        <div class="row">
                                            <div class="col-4">
                                                <input required type="text" name="day" class="form-control" placeholder="Días" required>
                                                <input required type="hidden" name="format_id" class="form-control" value="{{ $techFormat->id }}" required>
                                            </div>
                                            <div class="col-4">
                                                <select name="cost_id" id="" class="form-control">
                                                    @foreach($costs as $cost)
                                                        <option value="{{ $cost->id }}">{{ $cost->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" onclick="addCost()" class="btn btn-primary">Agregar</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div id="costs"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card crd">
                            <div class="card-header bg-b" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <h5 class="mb-0 text-uppercase d-inline">Listado de Materiales</h5><div style="color:white; margin-right: 26px;" class="d-inline float-right" id="total-material">$0.00</div>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                <div class="card-body bg-white">
                                    <form action="" id="form-materialformat">
                                        @csrf
                                        <div class="row">
                                            <div class="col-4">
                                                <select name="material_id" id="" class="form-control">
                                                    @foreach($materials as $material)
                                                        <option value="{{ $material->id }}">{{ $material->name }}, {{ $material->unit }}, {{ $material->type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <input required type="text" name="qty" class="form-control" placeholder="Cantidad" required>
                                                <input required type="hidden" name="format_id" class="form-control" value="{{ $techFormat->id }}" required>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" onclick="addMaterial()" class="btn btn-primary">Agregar</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div id="materials"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card crd">
                            <div class="card-header bg-b" id="headingFour" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <h5 class="mb-0 text-uppercase d-inline">KIT Isla Urbana</h5><div style="color:white; margin-right: 26px;" class="d-inline float-right" id="total-accesory">$0.00</div>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                <div class="card-body bg-white">
                                    <form action="" id="form-accesoryformat">
                                        @csrf
                                        <div class="row">
                                            <div class="col-4">
                                                <select name="accesory_id" id="" class="form-control">
                                                    @foreach($accesories as $accesory)
                                                        <option value="{{ $accesory->id }}">{{ $accesory->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <input required type="text" name="qty" class="form-control" placeholder="Piezas" required>
                                                <input required type="hidden" name="format_id" class="form-control" value="{{ $techFormat->id }}" required>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" onclick="addAccesory()" class="btn btn-primary">Agregar</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div id="accesories"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                        <form id="form-update" method="post" action="{{ route('projects.update', $techFormat->format) }}" autocomplete="off" class="form-horizontal">
                            @csrf
                            @method('patch')
                        </form>

                    <br>
                    <div class="row w-100">
                        <div class="col-12 col-md-8">
                        </div>
                        {{-- <div class="col-12 col-md-2">
                            <a href="{{ route('projects.index') }}" class="btn btn-rose float-right">{{ __('CANCEL') }}</a>
                        </div> --}}
                        <div class="col-12 col-md-2">
                            <button onclick="$('.set-status').val(1);$('#form-techformat').submit();" class="btn btn-primary">{{ __('FINALIZAR') }}</button>
                        </div>
                    </div>
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
    $('#va').val(total * multiplier * 0.85 + "m3");
});

$('#water_quality-other').on('click', function() {
    console.log($(this).is(':checked'));
    if ($(this).is(':checked'))
        $('#input-quality-other').fadeIn();
    else
        $('#input-quality-other').fadeOut();
});

var projectId = {{ $techFormat->id }};


function addCost() {
    $.ajax({
        type: 'POST',
        url: '/costformat',
        data: $('#form-costformat').serialize(),
    }).done(function(data) {
        loadCosts();
    });

};

function addMaterial() {
    $.ajax({
        type: 'POST',
        url: '/materialformat',
        data: $('#form-materialformat').serialize(),
    }).done(function(data) {
        loadMaterials();
    });

};

function addAccesory() {
    $.ajax({
        type: 'POST',
        url: '/accesoryformat',
        data: $('#form-accesoryformat').serialize(),
    }).done(function(data) {
        loadAccesory();
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




</script>

@endpush


{{-- unhiddenqueseaelvalorreal(specify...) --}}
