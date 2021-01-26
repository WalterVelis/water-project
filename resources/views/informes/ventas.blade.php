@extends('layouts.app', [
  'activePage' => 'datastudio-1',
  'menuParent' => 'datastudio',
  'titlePage' => __('Informe de ventas'),
])

@section('content')
<div class="container" style="height: auto;">
  <div class="row justify-content-center">

    <iframe style="border: 0; width: 95%; height: 85vh; margin-top: 80px;" src="https://datastudio.google.com/embed/reporting/abf4bc48-fecb-4350-aac9-8e803ca9231a/page/yRetB" frameborder="0" allowfullscreen></iframe>

  </div>
</div>
@endsection
