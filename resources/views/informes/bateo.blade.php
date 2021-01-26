@extends('layouts.app', [
  'activePage' => 'datastudio-2',
  'menuParent' => 'datastudio',
  'titlePage' => __('Índice de bateo'),
])

@section('content')
<div class="container" style="height: auto;">
  <div class="row justify-content-center">

    <iframe style="border: 0; width: 95%; height: 85vh; margin-top: 80px;" src="https://datastudio.google.com/embed/reporting/4ab22eaa-ecbd-4426-aea2-8f5cd02f0a6a/page/yRetB" frameborder="0" allowfullscreen></iframe>

  </div>
</div>
@endsection
