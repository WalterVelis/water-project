@extends('layouts.app', ['activePage' => 'costs-me', 'menuParent' => 'costs-parent', 'titlePage' => 'Centro de Costos'])
@section('content')
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
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" enctype="multipart/form-data" action="{{ route('materials.update', $material->id) }}" autocomplete="off"
                    class="form-horizontal">
                    @csrf
                    @method('put')
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
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-md-4 mt-5">
                                        <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Nombre de material') }}</label>
                                        <div class="col-sm-12">
                                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" value="{{ $material->name }}"  />
                                                <span id="errorNameUser" class="d-none">@lang('Campo obligatorio')</span>
                                                @include('alerts.feedback', ['field' => 'name'])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 mt-5">
                                    <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Tipo de material') }}</label>
                                        <div class="col-sm-12">
                                            <div class="form-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                                                {{-- <input class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" name="type" id="input-type" type="text" value="{{ old('type') }}"  /> --}}
                                                <select class="form-control" name="" id="ti">
                                                    <option {{ $material->type == "COBRE" ? "selected" : "" }} value="COBRE">COBRE</option>
                                                    <option {{ $material->type == "PVC SANITARIO" ? "selected" : "" }} value="PVC SANITARIO">PVC SANITARIO</option>
                                                    <option {{ $material->type == "PVC HIDR RD26" ? "selected" : "" }} value="PVC HIDR RD26">PVC HIDR RD26</option>
                                                    <option {{ $material->type == "CONDUIT" ? "selected" : "" }} value="CONDUIT">CONDUIT</option>
                                                    <option {{ $material->type == "TUBOPLUS" ? "selected" : "" }} value="TUBOPLUS">TUBOPLUS</option>
                                                    <option {{ $material->type == "PVC HIDR CED40" ? "selected" : "" }} value="PVC HIDR CED40">PVC HIDR CED40</option>
                                                    <option {{ $material->type == "BUSHING GALVANIZADO" ? "selected" : "" }} value="BUSHING GALVANIZADO">BUSHING GALVANIZADO</option>
                                                    <option {{ $material->type == "GALVANIZADA" ? "selected" : "" }} value="GALVANIZADA">GALVANIZADA</option>
                                                    <option {{ $material->type == "ACERO" ? "selected" : "" }} value="ACERO">ACERO</option>
                                                    <option {{ $material->type == "PLÁSTICO" ? "selected" : "" }} value="PLÁSTICO">PLÁSTICO</option>
                                                    <option {{ $material->type == "PVC" ? "selected" : "" }} value="PVC">PVC</option>
                                                    <option {{ $material->type == "SILICON" ? "selected" : "" }} value="SILICON">SILICON</option>
                                                    <option {{ $material->type == "GARLOCK" ? "selected" : "" }} value="GARLOCK">GARLOCK</option>
                                                    <option {{ $material->type == "BRONCE" ? "selected" : "" }} value="BRONCE">BRONCE</option>
                                                    <option {{ $material->type == "HULE" ? "selected" : "" }} value="HULE">HULE</option>
                                                    <option {{ $material->type == "SILER" ? "selected" : "" }} value="SILER">SILER</option>
                                                    <option {{ $material->type == "50% ESTAÑO y 50% PLOMO" ? "selected" : "" }} value="50% ESTAÑO y 50% PLOMO">50% ESTAÑO y 50% PLOMO</option>
                                                    <option {{ $material->type == "0" ? "selected" : "" }} value="0">OTRO</option>
                                                </select>
                                                <span id="errorNameUser" class="d-none">@lang('Campo obligatorio')</span>
                                                @include('alerts.feedback', ['field' => 'type'])
                                            </div>
                                            <div class="col-sm-12">
                                                <input id="otro" type="text" name="type" class="form-control mt-4" style="{{ $material->type == "0" ? "" : "display:none;" }}" placeholder="Especifique..." value="{{ $material->type }}">
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-12 col-md-4 mt-5">
                                    <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Unidad') }}</label>
                                        <div class="col-sm-12">
                                            <div class="form-group{{ $errors->has('unit') ? ' has-danger' : '' }}">
                                                {{-- <input class="form-control{{ $errors->has('unit') ? ' is-invalid' : '' }}" name="unit" id="input-unit" type="text" value="{{ old('unit') }}"  /> --}}
                                                <select class="form-control" name="unit" id="">
                                                    <option {{ $material->unit == 0 ? "selected" : "" }} value="0">TRAMO</option>
                                                    <option {{ $material->unit == 1 ? "selected" : "" }} value="1">PZA</option>
                                                    <option {{ $material->unit == 2 ? "selected" : "" }} value="2">ML</option>
                                                    <option {{ $material->unit == 3 ? "selected" : "" }} value="3">M2</option>
                                                    <option {{ $material->unit == 4 ? "selected" : "" }} value="4">LTS</option>
                                                    <option {{ $material->unit == 5 ? "selected" : "" }} value="5">LOTE</option>
                                                    <option {{ $material->unit == 6 ? "selected" : "" }} value="6">GMS</option>
                                                </select>
                                                <span id="errorNameUser" class="d-none">@lang('Campo obligatorio')</span>
                                                @include('alerts.feedback', ['field' => 'unit'])
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-12 col-md-7 mt-5">
                                            <span style="color:black; font-size:1.1em;">Proveedores asignados</span>
                                            <div class="row mt-4">
                                                <div class="col-12 col-md-4">Proveedores</div>
                                                <div class="col-12 col-md-3">Existencia</div>
                                                <div class="col-12 col-md-3">Precio unitario</div>
                                                <div class="col-12 col-md-2"></div>
                                            </div>
                                            <div class="bg-w" id="providers" style="height:300px;overflow-y: scroll; overflow-x: hidden;">
                                                @foreach($providers as $p)
                                                <div id="p-{{ $p->provider->id }}" class="row mt-3">
                                                    <div class="col-12 col-md-4"><span>{{ $p->provider->denomination }}</span></div>
                                                    <div class="col-12 col-md-3"><input value="{{ $p->qty }}" required name="qty[]" type="number" class="form-control">
                                                        <input name="provider_id[]" type="hidden" value="{{ $p->provider->id }}">
                                                    </div>
                                                    <div class="col-12 col-md-3"><input required name="unit_cost[]" type="number" class="form-control" value="{{ $p->unit_cost }}"></div>
                                                    <div class="col-12 col-md-2">
                                                        <button type="button" style="padding: 8px 8px 8px 7px; width: 24px; height: 24px; line-height: 6px; font-weight: bold;" class="btn btn-primary btn-sm btn-c btn-round" onclick="removeProvider({{ $p->provider->id }})">-</button>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-1"></div>
                                        <div class="col-12 col-md-4 mt-5">
                                            <span style="color:black; font-size:1.1em;">Proveedores disponibles</span>
                                            <div class="row mt-4">
                                                <div class="col-8">Proveedores</div>
                                                <div class="col-4">Acciones</div>
                                            </div>
                                            <div class="bg-w" style="height:300px;overflow-y: scroll; overflow-x: hidden;">
                                                @foreach($allProviders as $provider)
                                                @if($provider->product_type == 1)
                                                @continue
                                                @endif
                                                    <div style="{{ in_array($provider->id, $alreadyProvided) ? "display:none;" : "" }}" class="row">
                                                        <div class="col-8"><span id="provider-{{ $provider->id }}">{{ $provider->denomination }}</span></div>
                                                        <div class="col-4"><button type="button" style="padding: 8px 8px 8px 7px; width: 24px; height: 24px; line-height: 6px; font-weight: bold;" class="btn btn-primary btn-c btn-sm btn-round" onclick="addProvider({{ $provider->id }})">+</button></div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <span class="mt-4">* No se podrán eliminar proveedores que estén en algún proyecto con este material</span>
                                        </div>
                                    {{-- <div class="col-4">
                                        <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Proveedor') }}</label>
                                        <div class="col-sm-12">
                                            <div class="form-group{{ $errors->has('provider_id') ? ' has-danger' : '' }}">
                                                <select name="provider_id" class="form-control {{ $errors->has('provider_id') ? ' is-invalid' : '' }}">
                                                    @foreach($providers as $provider)
                                                        <option {{ $provider->id == $material->provider_id ? 'selected' : '' }} value="{{ $provider->id }}">{{ $provider->denomination }}</option>
                                                    @endforeach
                                                </select>
                                                <span id="errorNameUser" class="d-none">@lang('Campo obligatorio')</span>
                                                @include('alerts.feedback', ['field' => 'provider_id'])
                                            </div>
                                        </div>
                                    </div> --}}
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
    <footer class="footer">
        <div class="container-fluid">
            <div class="copyright "> &copy; <script> document.write(new Date().getFullYear()) </script> Cotizador AguaH2O, Todos los derechos reservados. Desarrollado por ISINET.</div>
        </div>
    </footer>
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
        <div id="p-${id}" class="row mt-3">
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

    $('#ti').on('change', () => {
        console.log($('#ti'));
        if($('#ti').val() == 0){
            $('#otro').fadeIn();
        } else {
            $('#otro').fadeOut();
            $('#otro').val($('#ti').val());
        }
    });
</script>

@endpush
