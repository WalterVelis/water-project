@extends('layouts.app', [
  'activePage' => 'datastudio-2',
  'menuParent' => 'datastudio',
  'titlePage' => __('Informes'),
])

<style>



.card-icon-inf i{
    color: white;
    font-size: 1.6em;
    line-height: 2em;
    padding-left: 12px;
}
.card-icon-inf {
    background: #0b6696;
    position: relative;
    display: block;
    width: 50px;
    height: 50px;
    left: -12px;
    top: 120px;
    border-radius: 40px;
}
@media (max-width: 800px){
    .card-icon-inf {
        display: none!important;
    }
}

    @media (min-width: 1200px){
.container {
    max-width: 1485px!important;
}

@media (max-width: 800px){
    .card-icon-inf {
        display: none!important;
    }
}

}
</style>

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">build</i>
                        </div>
                        <span style="    font-size: 2em; margin-top: 20px; display: inline-block;">Índice de bateo</span>
        <iframe style="border-radius: 15px;border: 0; width: 98%; height: 85vh; margin-top: 80px;" src="https://datastudio.google.com/embed/reporting/4ab22eaa-ecbd-4426-aea2-8f5cd02f0a6a/page/yRetB" frameborder="0" allowfullscreen></iframe>
    </div>
  </div>
</div>
</div>
</div>
</div>
@endsection
