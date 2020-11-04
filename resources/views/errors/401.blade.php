@extends('errors.layout', ['classPage' => 'error-page', 'activePage' => '401', 'title' => __('Cotizador Agua H2O'), 'pageBackground' => asset("material").'/img/licons/log-black.png'])

@section('content')
  <div class="container text-center">
    <div class="row">
      <div class="col-md-12">
        <h1 class="title">401</h1>
        <h2>{{ __('Page not found :') }}(</h2>
        <h4>{{ __('Ooooups! Looks like you got lost.') }}</h4>
      </div>
    </div>
  </div>
@endsection
