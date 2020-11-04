@extends('layouts.app', ['activePage' => 'provider', 'menuParent' => 'providers', 'titlePage' => 'Proveedores'])
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <form method="post" enctype="multipart/form-data" action="{{ route('providers.update', $provider->id) }}" autocomplete="off"
                    class="form-horizontal">
                    @csrf
                    @method('put')
                    <input type="hidden" id='formType' value='formCreate'>

                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">supervisor_account</i>
                            </div>
                            <h4 class="card-title">Agregar Proveedor</h4>
                        </div>
                        <br>
                        <div class="card-body">
                            <div class="container">
                                <div class="row mt-2">
                                    <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Razón social') }}</label>
                                    <div class="col-sm-12">
                                        <div class="form-group{{ $errors->has('denomination') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('denomination') ? ' is-invalid' : '' }}" name="denomination" id="input-denomination" type="text" value="{{ $provider->denomination }}" required />
                                            <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                            @include('alerts.feedback', ['field' => 'name'])
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Nombre del contacto') }}</label>
                                    <div class="col-sm-12">
                                        <div class="form-group{{ $errors->has('contact_name') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('contact_name') ? ' is-invalid' : '' }}" name="contact_name" id="input-contact_name" type="text" value="{{ $provider->contact_name }}" required />
                                            <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                            @include('alerts.feedback', ['field' => 'name'])
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Cargo') }}</label>
                                    <div class="col-sm-12">
                                        <div class="form-group{{ $errors->has('job_title') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('job_title') ? ' is-invalid' : '' }}" name="job_title" id="input-job_title" type="text" value="{{ $provider->job_title }}" required />
                                            <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                            @include('alerts.feedback', ['field' => 'name'])
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Teléfono') }}</label>
                                    <div class="col-sm-12">
                                        <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" id="input-phone" type="text" value="{{ $provider->phone }}" required />
                                            <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                            @include('alerts.feedback', ['field' => 'name'])
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Correo electrónico') }}</label>
                                    <div class="col-sm-12">
                                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" value="{{ $provider->email }}" required />
                                            <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                            @include('alerts.feedback', ['field' => 'name'])
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Tipo de producto') }}</label>
                                    <div class="col-sm-12 mb-5">
                                        <div class="form-group{{ $errors->has('denomination') ? ' has-danger' : '' }}">
                                            <select class="form-control" name="product_type" id="product_type">
                                                <option value="0">Materiales extra</option>
                                                <option {{ $provider->product_type ? 'selected' : '' }} value="1">Accesorios Isla Urbana</option>
                                            </select>
                                            <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                            @include('alerts.feedback', ['field' => 'name'])
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer d-flex flex-row-reverse">
                            <p onclick="validationSave();" class="btn btn-primary">{{ __('Save') }}</p>
                            <a href="{{ route('providers.index') }}" class="btn-rose btn">{{ __('Cancelar') }}</a>
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
