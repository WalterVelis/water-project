@extends('layouts.app', ['activePage' => 'user-management', 'menuParent' => 'user', 'titlePage' => __('Gestión de usuarios')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <span style="color:white;">GU</span>
                        </div>
                        <h4 class="card-title">Gestión de Usuarios</h4>
                        <div class="card-body">

                            {{-- @can('create', App\User::class) --}}
                            <div class="row col-12">
                                <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 text-right">
                                    @if($status)
                                        @if (App\User::hasPermissions("User Create"))
                                        <a href="{{ route('user.create') }}" class="btn-add" style="margin-right: 20px"><i style="    line-height: 1em;background: #0b6696; color: white; font-size: 1em; width: 30px; padding: 10px; border-radius: 50px;" class="fa fa-plus fw" aria-hidden="true"></i></a>
                                        @endif
                                    @else
                                    <a href="{{ url("/user?status=1") }}" class="btn-add"><img
                                            src="{{asset("img/icons").'/Gestion_Usuario.png'}}"></a>
                                    @endif
                                </div>
                                @if ($status)
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-left">
                                    <div class="dropdown">
                                        <button title="Download Data" class="dropdown-toggle" style="background: none; border: none; font-size: 1.5em;    width: 90px;"
                                            type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <p class="dropdown-item" onclick="exportDataCsv();"><i
                                                    class="fa fa-file-code-o" aria-hidden="true"></i>&nbsp; CSV</p>
                                            <p class="dropdown-item" onclick="exportDataXlsx();"><i
                                                    class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp; XLSX</p>
                                            <p class="dropdown-item" onclick="exportDataPdf();"><i
                                                    class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; PDF</p>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="col-12 text-left d-none">
                                    <a id="exportXlsx2" href="{{ route('user_xlsx2') }}"
                                        class="btn btn-sm btn-rose">{{ __('Export xlsx') }}</a>
                                    <a id="exportCsv2" href="{{ route('user_csv2') }}"
                                        class="btn btn-sm btn-rose">{{ __('Export csv') }}</a>
                                    <a id="exportPdf2" href="{{ route('user2Pdf',['all'])}}" target='_blank'
                                        class="btn btn-sm btn-rose">{{ __('Export pdf') }}</a>
                                </div>

                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 text-left">
                                    <div class="dropdown">
                                        <button title="Download Data" class="btn btn-ns" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <a href="{{ route('role.create') }}" class="btn-add"><img
                                                    src="{{asset("img/icons").'/Descargar.png'}}"></a>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <p class="dropdown-item" onclick="exportDataCsv2();"><i
                                                    class="fa fa-file-code-o" aria-hidden="true"></i>&nbsp; CSV</p>
                                            <p class="dropdown-item" onclick="exportDataXlsx2();"><i
                                                    class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp; XLSX</p>
                                            <p class="dropdown-item" onclick="exportDataPdf2();"><i
                                                    class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; PDF</p>
                                        </div>
                                    </div>
                                </div>

                                @endif


                            </div>
                            {{-- @endcan --}}

                            <div class="row d-none">
                                <div class="col-12 text-left">
                                    <a id="exportXlsx" href="{{ route('user_xlsx') }}"
                                        class="btn btn-sm btn-rose">{{ __('Export xlsx') }}</a>
                                    <a id="exportCsv" href="{{ route('user_csv') }}"
                                        class="btn btn-sm btn-rose">{{ __('Export csv') }}</a>
                                    <a id="exportPdf" href="{{ route('userPdf',['all'])}}" target='_blank'
                                        class="btn btn-sm btn-rose">{{ __('Export pdf') }}</a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                @include('layouts.table')
                                <table id="datatables" class="table table-striped table-no-bordered table-hover"
                                    style="display:none; width: 100%">
                                    <thead class="text-dark">
                                        <th>
                                            {{ __('Photo') }}
                                        </th>
                                        <th>
                                            {{ __('Name') }}
                                        </th>
                                        <th>
                                            {{ __('Email') }}
                                        </th>
                                        <th>
                                            {{ __('Role') }}
                                        </th>
                                        <th>
                                            {{ __('Creation date') }}
                                        </th>
                                        <th class="text-right">
                                            {{ __('Actions') }}
                                        </th>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td>
                                                <div class="avatar avatar-sm rounded-circle img-circle" style="width:4.0625rem; height:4.0625rem;overflow: hidden;">
                                                    <img src="{{ $user->profilePicture() }}" alt="" style="width: 100%; height:100%">
                                                </div>
                                            </td>
                                            <td>
                                                {{ $user->name }}
                                            </td>
                                            <td>
                                                {{ $user->email }}
                                            </td>
                                            <td>
                                                {{ $user->role->name }}
                                            </td>
                                            <td>
                                                {{ $user->created_at->format('Y-m-d') }}
                                            </td>
                                            <td class="td-actions text-right">
                                                @if($status)
                                                @include('users.options.inactive')
                                                @else
                                                @include('users.options.active')
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @push('js')
    <script>
        $(document).ready(function() {
      $('#datatables').fadeIn(1100);
      $('#datatables').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: $('#SearchTable').val(),
          "lengthMenu": $('#showTable').val(),
                "info": $('#infoTable').val(),
                "infoEmpty": $('#emptyTable').val(),
                "zeroRecords": $('#emptyRecords').val(),
              "infoFiltered": $('#filterRecords').val(),
          "paginate": {
              "next":     $('#nextTable').val(),
              "previous": $('#previusTable').val(),
              "first":    $('#firstTable').val(),
              "last":     $('#lastTable').val()
          },
        },
        "columnDefs": [
          { "orderable": false, "targets": 5 },
        ],
      });
    });
    </script>
    <script>
        function exportDataCsv(){
      document.getElementById('exportCsv').click()
    }

    function exportDataXlsx(){
      document.getElementById('exportXlsx').click()
    }
    function exportDataPdf(){
    document.getElementById('exportPdf').click()
    }

    function exportDataCsv2(){
      document.getElementById('exportCsv2').click()
    }

    function exportDataXlsx2(){
      document.getElementById('exportXlsx2').click()
    }
    function exportDataPdf2(){
    document.getElementById('exportPdf2').click()
    }

    function pressResetData(value){
      document.getElementById('btnResetData'+value).click()
    }
    </script>
    @endpush
