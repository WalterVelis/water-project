@extends('layouts.app', ['activePage' => 'costs-me', 'menuParent' => 'costs-parent', 'titlePage' => 'Materiales extra'])
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
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
                                    <div class="col-4">
                                        <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Nombre de material') }}</label>
                                        <div class="col-sm-12">
                                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" value="{{ $material->name }}"  />
                                                <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                                @include('alerts.feedback', ['field' => 'name'])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Existencia') }}</label>
                                        <div class="col-sm-12">
                                            <div class="form-group{{ $errors->has('qty') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('qty') ? ' is-invalid' : '' }}" name="qty" id="input-qty" type="text" value="{{ $material->qty }}"  />
                                                <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                                @include('alerts.feedback', ['field' => 'qty'])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Tipo de material') }}</label>
                                        <div class="col-sm-12">
                                            <div class="form-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" name="type" id="input-type" type="text" value="{{ $material->type }}"  />
                                                <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                                @include('alerts.feedback', ['field' => 'type'])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Costo unitario') }}</label>
                                        <div class="col-sm-12">
                                            <div class="form-group{{ $errors->has('cost') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('cost') ? ' is-invalid' : '' }}" name="cost" id="input-cost" cost="text" value="{{ $material->cost }}"  />
                                                <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                                @include('alerts.feedback', ['field' => 'cost'])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Proveedor') }}</label>
                                        <div class="col-sm-12">
                                            <div class="form-group{{ $errors->has('provider_id') ? ' has-danger' : '' }}">
                                                <select name="provider_id" class="form-control {{ $errors->has('provider_id') ? ' is-invalid' : '' }}">
                                                    @foreach($providers as $provider)
                                                        <option {{ $provider->id == $material->provider_id ? 'selected' : '' }} value="{{ $provider->id }}">{{ $provider->contact_name }}</option>
                                                    @endforeach
                                                </select>
                                                <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                                @include('alerts.feedback', ['field' => 'provider_id'])
                                            </div>
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
</script>

@endpush
