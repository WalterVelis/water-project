@extends('layouts.app', ['activePage' => 'costs', 'menuParent' => 'costs-parent', 'titlePage' => 'Centro de Costos'])
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <form method="post" enctype="multipart/form-data" action="{{ route('costs.store') }}" autocomplete="off"
                    class="form-horizontal">
                    @csrf
                    @method('post')
                    <input type="hidden" id='formType' value='formCreate'>

                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">supervisor_account</i>
                            </div>
                            <h4 class="card-title">Mano de Obra</h4>
                        </div>
                        <br>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Especialidad') }}</label>
                                        <div class="col-sm-12">
                                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" value="{{ old('name') }}"  />
                                                <span id="errorNameUser" class="d-none">@lang('Campo obligatorio')</span>
                                                @include('alerts.feedback', ['field' => 'name'])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="col-12" style="margin-bottom:-12px; font-weight:bold;">{{ __('Costo Unitario') }}</label>
                                        <div class="col-sm-12">
                                            <div class="form-group{{ $errors->has('unit_cost') ? ' has-danger' : '' }}">
                                                <input class="form-control{{ $errors->has('unit_cost') ? ' is-invalid' : '' }}" name="unit_cost" id="input-unit_cost" type="text" value="{{ old('unit_cost') }}"  />
                                                <span id="errorNameUser" class="d-none">@lang('Campo obligatorio')</span>
                                                @include('alerts.feedback', ['field' => 'unit_cost'])
                                            </div>
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
</script>

@endpush
