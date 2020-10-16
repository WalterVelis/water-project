@extends('layouts.app', ['activePage' => 'projects-management', 'menuParent' => 'projects', 'titlePage' => __('Projects')])

@section('content')
  <div class="content"> 
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('projects.store') }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('post')

            <div class="card ">
              <div class="card-header card-header-rose card-header-icon"> 
                <div class="card-icon">
                  <i class="material-icons">assignment</i>
                </div>
                <h4 class="card-title">{{ __('General data') }}</h4>
              </div>

              <div class="card-body ">
                <div class="row">
                  <div class="col-md-12 text-right">
                    <a href="{{ route('projects.index') }}" class="btn btn-sm btn-rose">{{ __('Back to list') }}</a>
                  </div>
                </div>
              <!-- Inicio -->

                <div class="row col-12">
                  <div class="row col-6">
                    <label class="col-sm-2 col-form-label">{{ __('Date') }}</label>
                    <div class="col-sm-9">
                      <div class="form-group{{ $errors->has('date') ? ' has-danger' : '' }}">
                        <input class="form-control" id="date" type="date" onblur="saveMeInput('date')" />
                        @include('alerts.feedback', ['field' => 'date'])
                      </div>
                    </div> 
                  </div>

                  <div class="row col-6">
                    <label class="col-sm-2 col-form-label">{{ __('City') }}</label>
                    <div class="col-sm-9">
                      <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" id="input-city" type="text" placeholder="{{ __('City') }}" readonly aria-required="true"/>
                        @include('alerts.feedback', ['field' => 'city'])
                      </div>
                    </div>
                  </div>

                  <div class="row col-6">
                    <label class="col-sm-2 col-form-label">{{ __('Client') }}</label>
                    <div class="col-sm-9">
                      <div class="form-group{{ $errors->has('client') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('client') ? ' is-invalid' : '' }}" name="client" id="input-client" type="text" placeholder="{{ __('Client') }}" readonly aria-required="true"/>
                        @include('alerts.feedback', ['field' => 'client'])
                      </div>
                    </div>
                  </div>
            
                  <div class="row col-6">
                    <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                    <div class="col-sm-9">
                      <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" placeholder="{{ __('Name') }}" aria-required="true"/>
                        @include('alerts.feedback', ['field' => 'name'])
                      </div>
                    </div>
                  </div>

                  <div class="row col-6">
                    <label class="col-sm-2 col-form-label">{{ __('Role') }}</label>
                    <div class="col-sm-9">
                      <div class="form-group{{ $errors->has('role') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" id="input-role" type="text" placeholder="{{ __('Role') }}"  aria-required="true"/>
                        @include('alerts.feedback', ['field' => 'role'])
                      </div>
                    </div>
                  </div>
            
                  <div class="row col-6">
                    <label class="col-sm-2 col-form-label">{{ __('Phone') }}</label>
                    <div class="col-sm-9">
                      <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" id="input-phone" type="text" placeholder="{{ __('Phone') }}" aria-required="true"/>
                        @include('alerts.feedback', ['field' => 'phone'])
                      </div>
                    </div>
                  </div>

                  <div class="row col-6">
                    <label class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                    <div class="col-sm-9">
                      <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="text" placeholder="{{ __('Email') }}" aria-required="true"/>
                        @include('alerts.feedback', ['field' => 'email'])
                      </div>
                    </div>
                  </div>
                </div> <br> 

                <!-- Fin -->

                {{-- <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Key SAT') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('clave_sat') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('clave_sat') ? ' is-invalid' : '' }}" name="clave_sat" id="input-name" type="text" placeholder="{{ __('Key SAT') }}" value="{{ old('clave_sat') }}" aria-required="true"/>
                      @include('alerts.feedback', ['field' => 'clave_sat'])
                    </div>
                  </div>
                </div> --}}
              </div>
            </div>

            <div class="card ">
              <div class="card-header card-header-rose card-header-icon">
                <h4 class="card-title">{{ __('Caracteristicas y Necesidades') }}</h4>
              </div>
              <div class="card-body ">
               
                <!-- Inicio -->
                <div class="row col-12">      
                  <div class="row col-sm-6">
                    <label class="col-sm-4 col-form-label">{{ __('Building type') }}</label>
                    <div class="col-sm-8">
                      <div class="form-group{{ $errors->has('building_type') ? ' has-danger' : '' }}">
                        <select id="budAccount" onchange="nextCode()" class="js-example-basic-single js-states form-control" name="building_type" data-style="select-with-transition" title="" data-size="100">
                          <option value="" disabled selected style="background-color:lightgray">@lang('Select building type')</option>
                          <option value="">Casa</option>
                          <option value="">Escuela</option>
                          <option value="">Industria</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row col-sm-6">
                    <label class="col-sm-4 col-form-label">{{ __('Environment') }}</label>
                    <div class="col-sm-8">
                      <div class="form-group{{ $errors->has('Environment') ? ' has-danger' : '' }}">
                        <select id="budAccount2" onchange="nextCode()" class="js-example-basic-single js-states form-control" name="Environment" data-style="select-with-transition" title="" data-size="100">
                          <option value="" disabled selected style="background-color:lightgray">@lang('Select environment')</option>
                          <option value="">Urbano</option>
                          <option value="">Rural</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row col-sm-6">
                    <label class="col-sm-4 col-form-label">{{ __('Source water') }}</label>
                    <div class="col-sm-8">
                      <div class="form-group{{ $errors->has('water_source') ? ' has-danger' : '' }}">
                        <select id="budAccount3" onchange="nextCode()" class="js-example-basic-single js-states form-control" name="water_source" data-style="select-with-transition" title="" data-size="100">
                          <option value="" disabled selected style="background-color:lightgray">@lang('Select an option')</option>
                          <option value="">Urbano</option>
                          <option value="">Rural</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row col-6">
                    <label class="col-sm-5 col-form-label">{{ __('Educational program') }}</label>
                    <div class="col-sm-7">
                      <div class="form-group{{ $errors->has('Edu_program') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('Edu_program') ? ' is-invalid' : '' }}" name="Edu_program" id="input-Edu_program" type="text" placeholder="{{ __('Educational program') }}"  aria-required="true"/>
                        @include('alerts.feedback', ['field' => 'Edu_program'])
                      </div>
                    </div>
                  </div>

                  <div class="row col-3">
                    <label class="col-sm-5 col-form-label">{{ __('# Children') }}</label>
                    <div class="col-sm-7">
                      <div class="form-group{{ $errors->has('Num_children') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('Num_children') ? ' is-invalid' : '' }}" name="Num_children" id="input-Num_children" type="text" placeholder="{{ __('Number of children') }}"  aria-required="true"/>
                        @include('alerts.feedback', ['field' => 'Num_children'])
                      </div>
                    </div>
                  </div>
                  <div class="row col-3">
                    <label class="col-sm-5 col-form-label">{{ __('# rooms') }}</label>
                    <div class="col-sm-7">
                      <div class="form-group{{ $errors->has('Num_rooms') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('Num_rooms') ? ' is-invalid' : '' }}" name="Num_rooms" id="input-Num_rooms" type="text" placeholder="{{ __('Number of rooms') }}"  aria-required="true"/>
                        @include('alerts.feedback', ['field' => 'Num_rooms'])
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Fin -->

                {{-- <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Key SAT') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('clave_sat') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('clave_sat') ? ' is-invalid' : '' }}" name="clave_sat" id="input-name" type="text" placeholder="{{ __('Key SAT') }}" value="{{ old('clave_sat') }}" aria-required="true"/>
                      @include('alerts.feedback', ['field' => 'clave_sat'])
                    </div>
                  </div>
                </div> --}}
              </div>
                <input type="hidden" name="created_by" value="{{auth()->user()->id}}">
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-rose">{{ __('Save') }}</button>
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

$("#budAccount2").select2({
  language: {
          noResults: function() {
              return "{{__('No results found')}}";
          },
          searching: function() {
            return "{{__('Searching')}}...";
          }
      }
})

$("#budAccount3").select2({
  language: {
          noResults: function() {
              return "{{__('No results found')}}";
          },
          searching: function() {
            return "{{__('Searching')}}...";
          }
      }
})

function nextCode(){
  idBlock=$('#budAccount').find('option:selected').val();
  var routeRequest = mainRoute + "budgetaccount/nextCode/" + idBlock;
  $.get(routeRequest, function (res) {
    $('#input-code').val(res);
  });
}
</script>  
@endpush