@extends('layouts.app', ['activePage' => 'costs', 'menuParent' => 'costs-parent', 'titlePage' => __('Centro de Costos')])
<style>
    td {
        padding: 3px 8px!important;
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
                            <span style="color:white;"><i class="material-icons">supervisor_account</i></span>
                        </div>
                        <br>

                        <h4 class="card-title d-inline">Mano de Obra</h4>

                        <div class="card-body">

                            {{-- @can('create', App\User::class) --}}
                            <div class="row col-12">
                                <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 text-right">
                                    @if (App\User::hasPermissions("User Create"))
                                    <a href="{{ route('costs.create') }}" class="btn-add" style="margin-right: 20px"><i
                                            style="    line-height: 1em;background: #0b6696; color: white; font-size: 1em; width: 30px; padding: 10px; border-radius: 50px;"
                                            class="fa fa-plus fw" aria-hidden="true"></i></a>
                                    @endif
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-left">
                                    <a class="float-right" href="/costPdf/">
                                        <button class=" d-inline" style="    background: none; border: none; font-size: 1.5em;" type="button">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            {{-- @endcan --}}

                            <div class="row d-none">
                                <div class="col-12 text-left">
                                    {{-- <a id="exportXlsx" href="{{ route('user_xlsx') }}"
                                        class="btn btn-sm btn-rose">{{ __('Export xlsx') }}</a> --}}
                                    <a id="exportCsv" href="{{ route('user_csv') }}"
                                        class="btn btn-sm btn-rose">{{ __('Export csv') }}</a>
                                    <a id="exportPdf" href="/costPdf" target='_blank'
                                        class="btn btn-sm btn-rose">{{ __('Export pdf') }}</a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                @include('layouts.table')
                                <table id="datatables" class="table table-striped table-no-bordered table-hover"
                                    style="display:none; width: 100%">
                                    <thead class="text-dark">
                                        {{-- <th>
                                            {{ __('ID') }}
                                        </th> --}}
                                        <th>
                                            {{ __('ID') }}
                                        </th>
                                        <th>
                                            {{ __('Nombre') }}
                                        </th>
                                        <th>
                                            {{ __('Costo Unitario') }}
                                        </th>
                                        <th>
                                            {{ __('Fecha de Actualización') }}
                                        </th>
                                        <th class="text-right">
                                            {{ __('Actions') }}
                                        </th>
                                    </thead>
                                    <tbody>
                                        @foreach($costs as $cost)
                                        <tr>
                                            {{-- <td>
                                                {{ $provider->id }}
                                            </td> --}}
                                            <td>
                                                {{ $cost->id }}
                                            </td>
                                            <td>
                                                {{ $cost->name }}
                                            </td>
                                            <td style="text-align: right">
                                                {{ Helper::formatMoney($cost->unit_cost) }}
                                            </td>
                                            <td>
                                                {{ $cost->updated_at }}
                                            </td>
                                            <td class="td-actions text-right">
                                                <a class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Editar" href="{{ route('costs.edit', $cost->id) }}"><i class="material-icons">edit</i></a>
                                                <form style="cursor: pointer;display: inline-block;transform: translateY(6px)" action="{{ route('costs.destroy', $cost->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Eliminar" type="submit" title="delete" style="border: none; background-color:transparent;margin-top:-10px;">
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
    <footer class="footer">
        <div class="container-fluid">
            <div class="copyright "> &copy; <script> document.write(new Date().getFullYear()) </script> Cotizador de AguaH2O, Todos los derechos reservados. Desarrollado por ISINET.</div>
        </div>
    </footer>
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
