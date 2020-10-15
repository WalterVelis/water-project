@extends('errors.layout', ['classPage' => 'error-page', 'activePage' => '503', 'title' => __('Material Dashboard'), 'pageBackground' => asset("material").'/img/licons/log-black.png'])

@section('content')
  <div class="container text-center">
    <div class="row">
      <div class="col-md-12">
        <h1 class="title">Service Unavailable</h1>
        <h2>{{ __('Server Error :') }}(</h2>
        <h4>{{ __('Ooooups! Looks like the service is unavailable') }}</h4>
      </div>
    </div>
  </div>
@endsection
