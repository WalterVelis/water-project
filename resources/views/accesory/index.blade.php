@extends('layouts.app', ['activePage' => 'costs-iu', 'menuParent' => 'costs-parent', 'titlePage' => __('Accesorios IU')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <span style="color:white;"><i class="material-icons">work_outline</i></span>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Accesorios IU</h4>
                            {{-- @can('create', App\User::class) --}}
                            <div class="row col-12">
                                <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 text-right">
                                    @if (App\User::hasPermissions("User Create"))
                                    <a href="{{ route('accesory.create') }}" class="btn-add" style="margin-right: 20px"><i
                                            style="    line-height: 1em;background: #0b6696; color: white; font-size: 1em; width: 30px; padding: 10px; border-radius: 50px;"
                                            class="fa fa-plus fw" aria-hidden="true"></i></a>
                                    @endif
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-left">
                                    <div class="dropdown">
                                        <button title="Download Data" class="dropdown-toggle"
                                            style="background: none; border: none; font-size: 1.5em;    width: 90px;"
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
                                            {{ __('ID') }}
                                        </th>
                                        <th>
                                            {{ __('Existencia') }}
                                        </th>
                                        <th>
                                            {{ __('Nombre') }}
                                        </th>
                                        <th>
                                            {{ __('Costo unitario') }}
                                        </th>
                                        <th>
                                            {{ __('Fecha actualización') }}
                                        </th>
                                        <th class="text-right">
                                            {{ __('Actions') }}
                                        </th>
                                    </thead>
                                    <tbody>
                                        @foreach($accesories as $accesory)
                                        <tr>
                                            <td>
                                                {{ $accesory->id }}
                                            </td>
                                            <td>
                                                {{ $accesory->qty }}
                                            </td>
                                            <td>
                                                {{ $accesory->name }}
                                            </td>
                                            <td>
                                                {{ $accesory->unit_cost }}
                                            </td>
                                            <td>
                                                {{ $accesory->updated_at }}
                                            </td>
                                            <td class="td-actions text-right">
                                                <a data-toggle="tooltip" data-placement="top" title="Editar" href="{{ route('accesory.edit', $accesory->id) }}"><i class="material-icons">edit</i></a>
                                                <form style="cursor: pointer;display: inline-block;transform: translateY(6px)" action="{{ route('accesory.destroy', $accesory->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button data-toggle="tooltip" data-placement="top" title="Eliminar" type="submit" title="delete" style="border: none; background-color:transparent;">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                </form>
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
