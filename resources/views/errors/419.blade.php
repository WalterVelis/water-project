<style>
    .wrapper.wrapper-full-page {
        background:#eee
    }
</style>

@extends('errors.layout', ['classPage' => 'error-page', 'activePage' => '419', 'title' => __('Material Dashboard'), 'pageBackground' => ''])

@section('content')
  <div class="container text-center">
    <div class="row">
      <div class="col-md-12">
        <h1 class="title"><img style="width:200px;" src="/material/img/licons/agua-logo-1.png" alt=""></h1>
        <h2 style="color:#607D8B;">Su sesión ha expirado.</h2>
        <h4 style="color:#607D8B;">Por seguridad, lo redirigiremos a la página de inicio.</h4>
      </div>
    </div>
  </div>
@endsection

<script>
    setTimeout(() => {
        // window.location = "/";
    }, 5000);
</script>
