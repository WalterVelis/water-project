@extends('layouts.app', ['activePage' => 'costs-me', 'menuParent' => 'costs-parent', 'titlePage' => 'Materiales extra'])
<style>
    .bg-w {
        background: white;
        border: solid 2px #adadad;
        border-radius: 4px;
        padding: 16px 4px;
        margin-top: 20px;
    }

    .btn-c {
        padding: 2px;
    }
</style>

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" enctype="multipart/form-data" action="{{ route('materials.store') }}" autocomplete="off"
                    class="form-horizontal">
                    @csrf
                    @method('post')
                    <input type="hidden" id='formType' value='formCreate'>

                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">build</i>
                            </div>
                            <h4 class="card-title">Materiales extra</h4>
                        </div>
                        <br>
                        <div class="card-body">
                            <div class="container-sm">
                                <div class="row">
                                    <div class="col-4">
                                        <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Nombre de material') }}</label>
                                        <div class="col-sm-12">
                                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" value="{{ old('name') }}"  />
                                                <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                                @include('alerts.feedback', ['field' => 'name'])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Unidad') }}</label>
                                        <div class="col-sm-12">
                                            <div class="form-group{{ $errors->has('unit') ? ' has-danger' : '' }}">
                                                {{-- <input class="form-control{{ $errors->has('unit') ? ' is-invalid' : '' }}" name="unit" id="input-unit" type="text" value="{{ old('unit') }}"  /> --}}
                                                <select class="form-control" name="unit" id="">
                                                    <option value="0">TRAMO</option>
                                                    <option value="1">PZA</option>
                                                    <option value="2">ML</option>
                                                    <option value="3">M2</option>
                                                    <option value="4">LTS</option>
                                                    <option value="5">LOTE</option>
                                                    <option value="6">GMS</option>
                                                </select>
                                                <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                                @include('alerts.feedback', ['field' => 'unit'])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Tipo de material') }}</label>
                                        <div class="col-sm-12">
                                            <div class="form-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                                                {{-- <input class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" name="type" id="input-type" type="text" value="{{ old('type') }}"  /> --}}
                                                <select class="form-control" name="type" id="">
                                                    <option value="0">COBRE</option>
                                                    <option value="1">PVC SANITARIO</option>
                                                    <option value="2">PVC HIDR RD26</option>
                                                    <option value="3">CONDUIT</option>
                                                    <option value="4">TUBOPLUS</option>
                                                    <option value="5">PVC HIDR CED40</option>
                                                    <option value="6">BUSHING GALVANIZADO</option>
                                                    <option value="7">GALVANIZADA</option>
                                                    <option value="8">ACERO</option>
                                                    <option value="9">PLÁSTICO</option>
                                                    <option value="10">PVC</option>
                                                    <option value="11">SILICON</option>
                                                    <option value="12">GARLOCK</option>
                                                    <option value="13">BRONCE</option>
                                                    <option value="14">HULE</option>
                                                    <option value="15">SILER</option>
                                                    <option value="16">50% ESTAÑO y 50% PLOMO</option>
                                                    <option value="17">OTRO</option>
                                                </select>
                                                <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                                @include('alerts.feedback', ['field' => 'type'])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-7 mt-5">
                                        <span style="color:black; font-size:1.1em;">Proveedores asignados</span>
                                        <div class="row mt-4">
                                            <div class="col-4">Proveedores</div>
                                            <div class="col-3">Existencia</div>
                                            <div class="col-3">Costo Unitario</div>
                                            <div class="col-2"></div>
                                        </div>
                                        <div class="bg-w" id="providers">
                                        </div>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-4  mt-5">
                                        <span style="color:black; font-size:1.1em;">Proveedores disponibles</span>
                                        <div class="row mt-4">
                                            <div class="col-8">Proveedores</div>
                                            <div class="col-4">Acciones</div>
                                        </div>
                                        <div class="bg-w">
                                            @foreach($providers as $provider)
                                                <div class="row">
                                                    <div class="col-8""><span id="provider-{{ $provider->id }}">{{ $provider->contact_name }}</span></div>
                                                    <div class="col-4"><button type="button" style="padding: 8px 8px 8px 7px; width: 24px; height: 24px; line-height: 6px; font-weight: bold;" class="btn btn-primary btn-c btn-sm btn-round" onclick="addProvider({{ $provider->id }})">+</button></div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex flex-row-reverse" style="justify-content: end;">
                            <p onclick="validationSave();" class="btn btn-primary">{{ __('Save') }}</p>
                            <a href="{{ route('materials.index') }}" class="btn-rose btn">{{ __('Cancelar') }}</a>
                            <button id="saveUser" type="submit" class="btn btn-rose btn-round d-none">{{ __('Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@push('js')

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('input').forEach( node => node.addEventListener('keypress', e => {
            if(e.keyCode == 13) {
                e.preventDefault();
            }
        }));
    });

    function addProvider(id) {
        name = $('#provider-'+id).html();
        $('#provider-'+id).parent().parent('.row').hide();
        content = `
        <div id="p-${id}" class="row">
            <div class="col-12 col-md-4"><span>${name}</span></div>
            <div class="col-12 col-md-3"><input required name="qty[]" type="number" class="form-control"><input name="provider_id[]" type="hidden" value="${id}"></div>
            <div class="col-12 col-md-3"><input required name="unit_cost[]" type="number" class="form-control"></div>
            <div class="col-12 col-md-2">
                <button type="button" style="padding: 8px 8px 8px 7px; width: 24px; height: 24px; line-height: 6px; font-weight: bold;" class="btn btn-primary btn-sm btn-c btn-round" onclick="removeProvider(${id})">-</button>
            </div>
        </div>
        `;
        $('#providers').append(content);
    }

    function removeProvider(id) {
        $('#p-'+id).remove();
        $('#provider-'+id).parent().parent('.row').show();
    }
</script>

@endpush
