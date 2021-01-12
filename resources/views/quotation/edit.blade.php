@extends('layouts.app', ['activePage' => 'projects-management', 'menuParent' => 'projects', 'sublevel' => 'budget', 'titlePage' => __('Gestión de Proyectos')])
<style>
    /* PDF, CSV, XLS */
    /* 11:00 */

    form label, .col-form-label {
    font-size: 15px!important;
}
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

    .table thead tr.cc th {
        font-size: 0.9rem;
        background: #bacfda;
        color: black;
        padding: 12px 10px;
        font-weight: bold;
    }

    td {
        border: solid 1px gray;
        text-align: center;
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
                            <div class="w-100" id="navbarNavDropdown">
                                <ul class="navbar-nav" style="">
                                    <li class="nav-item {{ $format->internal_status >= 0 ? "c-enabled" : "" }}">
                                        <a class="nav-link" href="{{ $format->internal_status >= 0 ? route('projects.edit', $format) : "#" }}">{{ __('Needs Diagnosis') }}</a>
                                    </li>
                                    <li class="nav-item  {{ $format->internal_status >= 1 ? "c-enabled" : "" }}">
                                        <a class="nav-link" href="{{ $format->internal_status >= 1 ? route('techformat.edit', $format) : "#" }}">{{ __('Technical Lift') }}</a>
                                    </li>
                                    <li class="nav-item active">
                                        <a class="nav-link" href="{{ $format->internal_status >= 1 && $format->internal_status != 2 ? "/quotation/$format->id/edit" : "#" }}">{{ __('Quotation') }}</a>
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

                    <form action="{{ route('quotation.update', $quotation->format_id) }}" method="post" id="form-quotation">
                        @csrf
                        @method('put')
                        <input type="hidden" name="status" class="set-status" value="0">
                        <div class="card-body bg-white" style="max-height: 720px;overflow: scroll">
                            <a class="float-right" href="/quotationPdf/{{ $format->id }}">
                                <button class=" d-inline" style="    background: none; border: none; font-size: 1.5em;" type="button">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                </button>
                            </a>
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('Fecha de creación') }}</label>
                                    <div class="col-sm-12">
                                        <input readonly class="form-control" id="" name="version" type="text" value="{{ $quotation->created_at->format("Y-m-d") }}" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('No. Cotización') }}</label>
                                    <div class="col-sm-12">
                                        @php($qId = 1)
                                        <input readonly class="form-control" id="" name="version" type="text" value="H2O-{{ str_pad($format->id, 4, '0', STR_PAD_LEFT)."-".str_pad($qId, 4, '0', STR_PAD_LEFT) }}" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('Versión') }}</label>
                                    <div class="col-sm-12">
                                        <input required class="form-control" id="" name="version" type="text" value="{{ $quotation->version }}" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('Vigencia') }}</label>
                                    <div class="col-sm-12">
                                        <input required class="form-control" id="" name="validity" type="text" value="{{ $quotation->validity }}" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('Moneda') }}</label>
                                    <div class="col-sm-12">
                                        <input required class="form-control" id="" name="currency" type="text" value="{{ $quotation->currency }}" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('Página web') }}</label>
                                    <div class="col-sm-12">
                                        <input required class="form-control" id="" name="web" type="text" value="{{ $quotation->web }}" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="c_label col-12 col-form-label">{{ __('Tiempo de entrega (días)') }}</label>
                                    <div class="col-sm-12">
                                        <input required class="form-control" id="" name="delivery" type="number" value="{{ $quotation->delivery }}" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-8">
                                    <label class="c_label col-12 col-form-label">{{ __('Forma de pago') }}</label>
                                    <div class="col-sm-12">
                                        <input required class="form-control" id="" name="payment" type="text" value="{{ $quotation->payment }}" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-8">
                                    <label class="c_label col-12 col-form-label">{{ __('Notas') }}</label>
                                    <div class="col-sm-12">
                                        <input required class="form-control" id="" name="notes" type="text" value="{{ $quotation->notes }}" />
                                    </div>
                                </div>
                            </div>

                        </form>

                    <form action="" method="post" id="sendQuotation" style="display: none">
                        @csrf
                        <div class="row mt-5">
                            <div class="col-12 col-md-4">
                                <label class="c_label col-12 col-form-label">{{ __('Otro elemento a cotizar') }}</label>
                                <div class="col-sm-12">
                                    <input required class="form-control" id="" name="description" type="text" value="" />
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="c_label col-12 col-form-label">{{ __('Cantidad') }}</label>
                                <div class="col-sm-12">
                                    <input required class="form-control" id="" name="qty" type="number" value="" />
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="c_label col-12 col-form-label">{{ __('Unitario') }}</label>
                                <div class="col-sm-12">
                                    <input required class="form-control" id="" name="cost" type="text" value="" />
                                </div>
                            </div>
                            <input required class="form-control" id="format_id" name="format_id" type="hidden" value="{{ $quotation->format_id }}" />
                            <div class="col-12 col-md-2">
                                <button type="button" onclick="sendQuotation()" class="btn btn-primary">Agregar</button>
                            </div>
                        </div>
                    </form>

                    <form action="" method="post" id="applyUtility" style="display: none">
                        @csrf
                        @method('PATCH')
                        <div class="row mt-5">

                            <div class="col-12 col-md-5">
                                <label class="c_label col-12 col-form-label">{{ __('Utilidad') }}</label>
                                <div class="col-sm-12">
                                    <input required class="form-control" id="" name="utility" type="number" value="" />
                                </div>
                            </div>
                            <div class="col-12 col-md-5">
                                <label class="c_label col-12 col-form-label">{{ __('Indirectos') }}</label>
                                <div class="col-sm-12">
                                    <input required class="form-control" id="" name="indirect" type="text" value="" />
                                </div>
                            </div>
                            <input required class="form-control" id="format_id" name="format_id" type="hidden" value="{{ $quotation->format_id }}" />
                            <div class="col-12 col-md-2">
                                <button type="button" onclick="applyUtility()" class="btn btn-primary">Aplicar</button>
                            </div>
                        </div>
                    </form>
                    <div style="text-align: right;" class="mb-2 mt-2 mr-4">
                        <span onclick="$('.q-details').toggle();" style="    text-align: left;cursor: pointer;width:30px; height: 30px; border-radius:40px; font-weight:bold; background: #0b6696; color: white; display:inline-bl<ock;padding-left:5px;font-size:1.2em;padding-top:4px;"><i style="color:white;    transform: translate(-2px, 3px) scale(0.8);" class="material-icons">remove_red_eye</i></span>
                        <span onclick="$('#sendQuotation').hide();$('#applyUtility').show();" style="    text-align: left;cursor: pointer;width:30px; height: 30px; border-radius:40px; font-weight:bold; background: #0b6696; color: white; display:inline-block;padding-left:8px;font-size:1.2em;padding-top:5px;">%</span>
                        <span onclick="$('#sendQuotation').show();$('#applyUtility').hide();" style="    text-align: left;cursor: pointer;width:30px; height: 30px; border-radius:40px; font-weight:bold; background: #0b6696; color: white; display:inline-block;padding-left:10px;font-size:1.2em;padding-top:5px;">+</span>
                    </div>
                    <div class="container mt-4" id="q-table">

                    </div>
                    <div class="row float-right mr-4">
                        <a href="{{ route('projects.index') }}" class="btn btn-rose">{{ __('CANCEL') }}</a>
                        <button onclick="$('.set-status').val(1);$('#form-quotation').submit();" class="btn btn-primary">{{ __('SAVE') }}</button>
                    </div>
                </div>

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
    saving = false;

function saveWork() {
    console.log(saving);
    if(!saving) {
        saving = true;
        $.ajax({
            type: "put",
            url: "{{ route('quotation.update', $quotation->format_id) }}",
            data: $('#form-quotation').serialize(),
            complete: function (response) {
                console.log(response);
            }
        });
    }
}

function sendQuotation() {
    $.ajax({
        type: "post",
        url: "{{ route('quotation.store') }}",
        data: $('#sendQuotation').serialize(),
        complete: function (response) {
            console.log(response.responseText);
            $('#q-table').load('/quotationformat/{{ $quotation->format_id }}/table');
        }
    });
}

function applyUtility() {
    $.ajax({
        type: "PATCH",
        url: "/applyutility/{{ $quotation->format_id }}",
        data: $('#applyUtility').serialize(),
        complete: function (response) {
            console.log(response.responseText);
            $('#q-table').load('/quotationformat/{{ $quotation->format_id }}/table');
        }
    });
}



$(function () {
    $("input").blur(function(){
        saveWork();
    });
});

function loadTable() {

    $('#q-table').load('/quotationformat/{{ $quotation->format_id }}/table');
}

loadTable();

@if($format->status == 4)
    $('input, select').attr('readonly', 'true');
    $('input, select').attr('disabled', 'true');
@endif

</script>
@endpush
