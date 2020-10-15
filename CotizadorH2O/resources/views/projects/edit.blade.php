@extends('layouts.app', ['activePage' => 'budgetaccount-management', 'menuParent' => 'catalog', 'sublevel' => 'budget', 'titlePage' => __('Budget Account Management')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('budgetaccount.update', $budgetAccount) }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')

            <div class="card ">
              <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">assignment</i>
                </div>
                <h4 class="card-title">{{ __('Edit Account') }}</h4>
              </div>
              <div class="card-body ">
                <div class="row">
                  <div class="col-md-12 text-right">
                      <a href="{{ route('budgetaccount.index') }}" class="btn btn-sm btn-rose">{{ __('Back to list') }}</a>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Budget Block') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('budget_block_id') ? ' has-danger' : '' }}">
                      <select class="js-example-basic-single js-states form-control" id="budAccount" name="budget_block_id" data-style="select-with-transition" onchange="nextCode({{$budgetAccount->budget_block_id}},'{{$budgetAccount->code}}')" title="" data-size="100" {{$flagCount}} >
                        @foreach ($budget_blocks as $block)
                          <option value="{{$block->id}}" @if ($budgetAccount->budget_block_id ==$block->id) selected="selected" @endif>{{ __($block->code) }} {{ __($block->name) }}</option>
                        @endforeach
                      </select>
                      @include('alerts.feedback', ['field' => 'budget_account_id'])
                    </div>
                  </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">{{ __('Code') }}</label>
                    <div class="col-sm-7">
                      <div class="form-group{{ $errors->has('code') ? ' has-danger' : '' }}">
                        <input class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" name="code" id="input-code" type="text" placeholder="{{ __('Code') }}" value="{{ old('code',$budgetAccount->code) }}" readonly aria-required="true"/>
                        <span id="errorCodeUnique" class="d-none">@lang('Code already in use')</span>
                        @include('alerts.feedback', ['field' => 'code'])
                      </div>
                    </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" placeholder="{{ __('Name') }}" value="{{ old('name', $budgetAccount->name) }}" aria-required="true"/>
                      @include('alerts.feedback', ['field' => 'name'])
                    </div>
                  </div>
                </div>
                {{-- <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Key SAT') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('clave_sat') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('clave_sat') ? ' is-invalid' : '' }}" name="clave_sat" id="input-name" type="text" placeholder="{{ __('Key SAT') }}" value="{{ old('clave_sat', $budgetAccount->clave_sat) }}" aria-required="true"/>
                      @include('alerts.feedback', ['field' => 'clave_sat'])
                    </div>
                  </div>
                </div> --}}
              </div>
              <input type="hidden" name="updated_by" value="{{auth()->user()->id}}">
              <input type="hidden" name="id_validate" value="{{$budgetAccount->id}}">
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

function nextCode(block,code){
  idBlock=$('#budAccount').find('option:selected').val();
  if(idBlock==block){
    $('#input-code').val(code);
  }else{
    var routeRequest = mainRoute + "budgetaccount/nextCode/" + idBlock;
    $.get(routeRequest, function (res) {
      $('#input-code').val(res);
    });
  }
}

</script>
    
@endpush