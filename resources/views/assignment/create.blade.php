@extends('layouts.app', ['activePage' => 'provider', 'menuParent' => 'providers', 'titlePage' => 'Proveedores'])
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <form method="post" enctype="multipart/form-data" action="{{ route('providers.store') }}" autocomplete="off"
                    class="form-horizontal">
                    @csrf
                    @method('post')
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
                                            <input class="form-control{{ $errors->has('denomination') ? ' is-invalid' : '' }}" name="denomination" id="input-denomination" type="text" value="{{ old('denomination') }}"  />
                                            <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                            @include('alerts.feedback', ['field' => 'denomination'])
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Nombre del contacto') }}</label>
                                    <div class="col-sm-12">
                                        <div class="form-group{{ $errors->has('contact_name') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('contact_name') ? ' is-invalid' : '' }}" name="contact_name" id="input-contact_name" type="text" value="{{ old('contact_name') }}"  />
                                            <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                            @include('alerts.feedback', ['field' => 'contact_name'])
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Cargo') }}</label>
                                    <div class="col-sm-12">
                                        <div class="form-group{{ $errors->has('job_title') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('job_title') ? ' is-invalid' : '' }}" name="job_title" id="input-job_title" type="text" value="{{ old('job_title') }}"  />
                                            <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                            @include('alerts.feedback', ['field' => 'job_title'])
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Teléfono') }}</label>
                                    <div class="col-sm-12">
                                        <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" id="input-phone" type="text" value="{{ old('phone') }}"  />
                                            <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                            @include('alerts.feedback', ['field' => 'phone'])
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('RFC') }}</label>
                                    <div class="col-sm-12">
                                        <div class="form-group{{ $errors->has('rfc') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('rfc') ? ' is-invalid' : '' }}" name="rfc" id="input-rfc" type="text" value="{{ old('rfc') }}"  />
                                            <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                            @include('alerts.feedback', ['field' => 'rfc'])
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Dirección') }}</label>
                                    <div class="col-sm-12">
                                        <div class="form-group{{ $errors->has('direccion') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('direccion') ? ' is-invalid' : '' }}" name="direccion" id="input-direccion" type="text" value="{{ old('direccion') }}"  />
                                            <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                            @include('alerts.feedback', ['field' => 'direccion'])
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row mt-4">
                                    <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Teléfono') }}</label>
                                    <div class="col-sm-12">
                                        <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" id="input-phone" type="text" value="{{ old('phone') }}"  />
                                            <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                            @include('alerts.feedback', ['field' => 'phone'])
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row mt-4">
                                    <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Correo electrónico') }}</label>
                                    <div class="col-sm-12">
                                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="" type="email" value="{{ old('email') }}"  />
                                            <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                            @include('alerts.feedback', ['field' => 'email'])
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Tipo de producto') }}</label>
                                    <div class="col-sm-12 mb-5">
                                        <div class="form-group{{ $errors->has('product_type') ? ' has-danger' : '' }}">
                                            <select class="form-control" name="product_type" id="product_type">
                                                <option value="0">Materiales extra</option>
                                                <option value="1">Accesorios Isla Urbana</option>
                                            </select>
                                            <span id="errorNameUser" class="d-none">@lang('The name field cannot be empty')</span>
                                            @include('alerts.feedback', ['field' => 'product_type'])
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer d-flex flex-row-reverse" style="justify-content: end;">
                            <p onclick="validationSave();" class="btn btn-primary">{{ __('Save') }}</p>
                            <a href="{{ route('user.index') }}" class="btn-rose btn">{{ __('Cancelar') }}</a>
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
