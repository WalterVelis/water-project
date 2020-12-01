@extends('layouts.app', ['activePage' => 'project-managment', 'menuParent' => 'project-managment', 'titlePage' => 'Gestión de Proyectos'])
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" enctype="multipart/form-data" action="{{ route('assignment.update', $assignmentData->id) }}" autocomplete="off"
                    class="form-horizontal">
                    @csrf
                    @method('put')
                    <input type="hidden" id='formType' value='formCreate'>

                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">supervisor_account</i>
                            </div>
                            <h4 class="card-title">Gestión de Proyectos</h4>
                        </div>
                        <br>
                        <div class="card-body">
                            <div class="container">
                                <div class="row mt-2">
                                    <div class="mt-5 col-12 col-md-6">
                                        <span style="margin-bottom:-10px;font-weight:bold;">{{ __('Vendedor Titular') }}</span>
                                        <div class="form-group{{ $errors->has('vendor_assigned') ? ' has-danger' : '' }}">
                                            <select class="form-control" name="vendor_assigned" id="" required>
                                                <option value="">No asignado</option>
                                                @foreach($users as $user)
                                                <option {{ $assignmentData->vendor_assigned == $user->id ? "selected" : "" }} value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            @include('alerts.feedback', ['field' => 'vendor_assigned'])
                                        </div>
                                    </div>
                                    <br>
                                    <div class="mt-5 col-12 col-md-6">
                                        <span style="margin-bottom:-10px;font-weight:bold;">{{ __('Estatus') }}</span>
                                        <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                            <select class="form-control" name="status" id="" required>
                                                <option {{ $assignmentData->status == 4 ? "selected" : "" }} value="4">Cotizado</option>
                                                <option {{ $assignmentData->status == 5 ? "selected" : "" }} value="5">Negociación</option>
                                                <option {{ $assignmentData->status == 3 ? "selected" : "" }} value="3">Aceptado</option>
                                                <option {{ $assignmentData->status == 2 ? "selected" : "" }} value="2">Rechazado</option>
                                                <option {{ $assignmentData->status == 6 ? "selected" : "" }} value="6">Anticipo</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'status'])
                                        </div>
                                    </div>
                                    <div class="mt-5 col-12 col-md-6">
                                        <span style="margin-bottom:-10px;font-weight:bold;">{{ __('Técnico asignado') }}</span>
                                        <div class="form-group{{ $errors->has('tech_assigned') ? ' has-danger' : '' }}">
                                            <select class="form-control" name="tech_assigned" id="" required>
                                                <option value="">No asignado</option>
                                                @foreach($users as $user)
                                                <option {{ $assignmentData->tech_assigned == $user->id ? "selected" : "" }} value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            @include('alerts.feedback', ['field' => 'tech_assigned'])
                                        </div>
                                    </div>
                                    <div class="mt-5 col-12 col-md-7">
                                        <span style="margin-bottom:-10px;font-weight:bold;">{{ __('Administrador') }}</span>
                                        <div class="form-group{{ $errors->has('admin_assigned') ? ' has-danger' : '' }}">
                                            <select class="form-control" name="admin_assigned" id="" required>
                                                <option value="">No asignado</option>
                                                @foreach($users as $user)
                                                <option {{ $assignmentData->admin_assigned == $user->id ? "selected" : "" }} value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            @include('alerts.feedback', ['field' => 'admin_assigned'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex flex-row-reverse" style="justify-content: end;">
                            {{-- <p onclick="validationSave();" class="btn btn-primary">{{ __('Save') }}</p> --}}
                            <button id="saveUser" type="submit" class="btn btn-primary">{{ __('Save') }}</button>
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
