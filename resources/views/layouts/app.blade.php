{{--

=========================================================
* Argon Dashboard PRO - v1.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-pro-laravel
* Copyright 2018 Creative Tim (https://www.creative-tim.com) & UPDIVISION (https://www.updivision.com)

* Coded by www.creative-tim.com & www.updivision.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

--}}
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/apple-icon.png">
  <link rel="icon" type="image/png" href="{{ asset('material') }}/img/licons/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Cotizador Agua H2O
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="{{ asset('material') }}/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
  <link href="{{ asset('material') }}/css/material-new.css" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="{{ asset('material') }}/demo/demo.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.22/b-1.6.5/b-colvis-1.6.5/b-html5-1.6.5/b-print-1.6.5/r-2.2.6/datatables.min.css"/>


  <link rel="stylesheet" href="{{asset('css/vendorsTable.css')}}">

  <style>

@media (max-width: 991px) {
    .sidebar::before, .off-canvas-sidebar nav .navbar-collapse::before {
        background:white;
    }
}

.btn.btn-link, .btn.btn-default.btn-link {
    width: 30px;
    padding: 0px!important;
 }

.navbar-nav.nav-mobile-menu i  {
    color: rgb(11 102 150)!important;
}

.navbar-nav.nav-mobile-menu .nav-item .nav-link  {
    border: solid 1px #e8e8e8;
}

    .has-danger .form-control, .is-focused .has-danger .form-control {
        background-image: linear-gradient(to top, #f44336 2px, rgba(244, 67, 54, 0) 2px), linear-gradient(to top, #FF5722 1px, rgba(210, 210, 210, 0) 1px);
    }
    .ps-container.ps-active-x>.ps-scrollbar-x-rail, .ps-container.ps-active-y>.ps-scrollbar-y-rail {
        background: none!important;
    }
    .loaderSpinner {
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid #0b6696;
      width: 120px;
      height: 120px;
      display: block;
      margin-left: auto;
      margin-right: auto;
      -webkit-animation: spin 2s linear infinite; /* Safari */
      animation: spin 2s linear infinite;
    }


    select.form-control:focus, select.form-control:hover {
        background-image: linear-gradient(45deg, transparent 50%, gray 50%), linear-gradient(135deg, gray 50%, transparent 50%), linear-gradient(to right, transparent, transparent)!important;
        background-position: calc(100% - 20px) calc(1em + 2px), calc(100% - 14px) calc(1em + 2px), calc(100% - 2.5em) 0.5em;
        background-size: 6px 6px, 6px 6px, 1px 1.5em;
        background-repeat: no-repeat;
        border-bottom: solid 1px #afaaaa;
        margin-top: -4px;
    }
    select.form-control {
        background-image: linear-gradient(45deg, transparent 50%, gray 50%), linear-gradient(135deg, gray 50%, transparent 50%), linear-gradient(to right, transparent, transparent)!important;
        background-position: calc(100% - 20px) calc(1em + 2px), calc(100% - 14px) calc(1em + 2px), calc(100% - 2.5em) 0.5em;
        background-size: 6px 6px, 6px 6px, 1px 1.5em;
        background-repeat: no-repeat;
        border-bottom: solid 1px #afaaaa;
        margin-top: -4px;
    }
    .btn.btn-primary, .btn.btn-primary:hover, .btn.btn-rose, .btn.btn-rose:hover {
        box-shadow: none!important;
    }
    .btn.btn-rose {
        border: none!important;
        margin-right: 5px;
        min-width: 115px;
    }
    .copyright  {
        color: #607D8B!important;
    }

    @media (max-width: 991px){
        .card .card-body .col-form-label, .card .card-body .label-on-right {
            padding-left: 15px!important;
        }
    }
    /* Safari */
    @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    </style>

<style>
    .c-nav.step-navbar {
        box-shadow: none;
        background: transparent!important;
        margin-bottom: 10px;
    }

    .c-nav .navbar.step-navbar .collapse .navbar-nav .nav-item .nav-link {
        margin-left: 25px;
    }

    .c-nav .step-navbar .nav-item.active {
        color: white;
        background: transparent;
        border-radius: 4px;
        font-weight: bold;
    }

    .c-nav .step-navbar .nav-item.active a {
        color: white;
        background: #32526f!important;
        border-radius: 4px;
        font-weight: bold;
    }

    .c-nav .navbar.step-navbar .collapse .navbar-nav .nav-item .nav-link {
        font-weight: bold;
    }

    .c-nav .nav-item:not(.active):not(.c-enabled) .nav-link{
        color: #3d5c7780;
        cursor:not-allowed
    }

    nav.c-nav li.nav-item a.nav-link.c-enabled {
        color: #32526f!important;
        cursor: pointer!important;
        font-weight: bold!important;
    }

    .c-nav.navbar .navbar-nav {
        margin: 0 auto;
    }

    .c-nav .nav-item {
        margin-right: 3px;
        margin-left: 3px;
    }

    .c-nav .nav-link  {
        font-size: 14px!important;
    }

</style>

<style>

    /* footer {
    position: absolute;
    bottom: -15px;
    right: 0;
    margin-left: auto;
    margin-right: auto;
    } */

    .form-control[disabled], fieldset[disabled] .form-control, .form-group .form-control[disabled], fieldset[disabled] .form-group .form-control {
        opacity: 0.45;
    }

  .loaderSpinnerLogin {
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #0b6696;
    width: 80px;
    height: 80px;
    display: block;
    margin-left: auto;
    margin-right: auto;
    -webkit-animation: spin 2s linear infinite; /* Safari */
    animation: spin 2s linear infinite;
  }

  /* Safari */
  @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  </style>

</head>
<body class="{{ $class ?? '' }}" >
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        @if (auth()->check() && !in_array(request()->route()->getName(), ['welcome', 'page.pricing', 'page.lock', 'page.error']))
            @include('layouts.page_templates.auth')
        @else
            @include('layouts.page_templates.guest')
        @endif
{{-- @include('layouts.footers.auth') --}}


        <!--   Core JS Files   -->
        <script src="{{ asset('material') }}/js/core/jquery.min.js"></script>
        <script src="{{ asset('material') }}/js/core/popper.min.js"></script>
        <script src="{{ asset('material') }}/js/core/bootstrap-material-design.min.js"></script>
        <script src="{{ asset('material') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
        <!-- Plugin for the momentJs  -->
        <script src="{{ asset('material') }}/js/plugins/moment.min.js"></script>
        <!--  Plugin for Sweet Alert -->
        <script src="{{ asset('material') }}/js/plugins/sweetalert2.js"></script>
        <!-- Forms Validations Plugin -->
        <script src="{{ asset('material') }}/js/plugins/jquery.validate.min.js"></script>
        <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
        <script src="{{ asset('material') }}/js/plugins/jquery.bootstrap-wizard.js"></script>
        <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
        <script src="{{ asset('material') }}/js/plugins/bootstrap-selectpicker.js"></script>
        <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
        <script src="{{ asset('material') }}/js/plugins/bootstrap-datetimepicker.min.js"></script>
        <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
        {{-- <script src="{{ asset('material') }}/js/plugins/jquery.dataTables.min.js"></script> --}}
        <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
        <script src="{{ asset('material') }}/js/plugins/bootstrap-tagsinput.js"></script>
        <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
        <script src="{{ asset('material') }}/js/plugins/jasny-bootstrap.min.js"></script>
        <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
        <script src="{{ asset('material') }}/js/plugins/fullcalendar.min.js"></script>
        <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
        <script src="{{ asset('material') }}/js/plugins/jquery-jvectormap.js"></script>
        <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
        <script src="{{ asset('material') }}/js/plugins/nouislider.min.js"></script>
        <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
        <!-- Library for adding dinamically elements -->
        <script src="{{ asset('material') }}/js/plugins/arrive.min.js"></script>
        <!--  Google Maps Plugin    -->
        {{-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> --}}
        <!-- Chartist JS -->
        <script src="{{ asset('material') }}/js/plugins/chartist.min.js"></script>
        <!--  Notifications Plugin    -->
        <script src="{{ asset('material') }}/js/plugins/bootstrap-notify.js"></script>
        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="{{ asset('material') }}/js/material-dashboard.js?v=2.1.0" type="text/javascript"></script>
        <!-- Material Dashboard DEMO methods, don't include it in your project! -->
        <script src="{{ asset('material') }}/demo/demo.js"></script>
        <script src="{{ asset('material') }}/js/application.js"></script>
        <script src="{{asset('js/permission.js')}}"></script>
        <script src="{{asset('js/attrchange.js')}}"></script>
        <script src="{{asset('js/attrchange_ext.js')}}"></script>
        {{-- <script src="{{asset('js/budget.js')}}"></script> --}}
        <script src="{{asset('js/validations.js')}}"></script>
        <script src="{{asset('js/user.js')}}"></script>
        <script src="{{asset('js/doubleFactor.js')}}"></script>
        <script src="{{asset('js/login.js')}}"></script>
        <script src="{{asset('js/tree.js')}}"></script>
        <script src="{{asset('js/vendor.js')}}"></script>
        <script src="{{asset('js/modalsBuget.js')}}"></script>
        <script src="{{asset('js/modalContact.js')}}"></script>
        <script src="{{asset('js/modalContactAgency.js')}}"></script>
        <script src="{{asset('js/currency.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.22/b-1.6.5/b-colvis-1.6.5/b-html5-1.6.5/b-print-1.6.5/r-2.2.6/datatables.min.js"></script>
<style>
    .c-enabled > a {
        font-weight:bold!important;
    }
    .photo2 {
        transform: scale(1.35);
    }

    .main-panel>.content {
        margin-top: 30px;
    }
</style>
        <script>
          $(document).ready(function () {
            @if (session('status')) //Succesfully
              $.notify({
                icon: "done",
                message: "{{ session('status') }}"
              }, {
                type: 'success',
                timer: 3000,
                placement: {
                  from: 'top',
                  align: 'right'
                }
              });
            @endif
            @if (session('error')) //Error
              $.notify({
                icon: "error",
                message: "{{ session('error') }}"
              }, {
                type: 'danger',
                timer: 3000,
                placement: {
                  from: 'top',
                  align: 'right'
                }
              });
            @endif

            $.ajax({
                type: 'GET',
                url: '/getNotifications'
            })
            .done(function(data) {
                $('#notify').html(data);
            });
          });

function formatMoney(number, decPlaces, decSep, thouSep) {
    decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
    decSep = typeof decSep === "undefined" ? "." : decSep;
    thouSep = typeof thouSep === "undefined" ? "," : thouSep;
    var sign = number < 0 ? "-$" : "$";
    var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
    var j = (j = i.length) > 3 ? j % 3 : 0;

    return sign +
        (j ? i.substr(0, j) + thouSep : "") +
        i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
        (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
}
        </script>

        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
                $('[data-toggle="tooltip"]').css('cursor', 'pointer')
            })
        </script>
        @stack('js')
</body>

</html>
