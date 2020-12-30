@extends('layouts.app', ['activePage' => 'role-management', 'menuParent' => 'user', 'titlePage' => __('Gestión de Usuarios')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <span style="color: white; padding: 2px;">GR</span>
                        </div>
                        <h4 class="card-title">{{ __('Roles') }}</h4>
                    </div>
                    <div class="card-body">

                        <div class="row d-none">
                            <div class="col-12 text-left">
                                <a id="exportXlsx" href="{{ route('role_xlsx') }}"
                                    class="btn btn-sm btn-rose">{{ __('Export xlsx') }}</a>
                                <a id="exportCsv" href="{{ route('role_csv') }}"
                                    class="btn btn-sm btn-rose">{{ __('Export csv') }}</a>
                                <a id="exportPdf" href="{{ route('rolePdf',['all'])}}" target='_blank'
                                    class="btn btn-sm btn-rose">{{ __('Export pdf') }}</a>
                            </div>
                        </div>

                        <div class="row col-12">
                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12 text-right">
                                <a href="{{ route('role.create') }}" class="btn-add"><i style="background: #0b6696; color: white; font-size: 1em; width: 30px; padding: 10px; border-radius: 50px;" class="fa fa-plus fw" aria-hidden="true"></i></a>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 text-left">
                                <div class="dropdown">
                                    <button title="Download Data" class="btn btn-ns" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <a style="transform: translateY(10px);" href="{{ route('role.create') }}" class="btn-add"><i class="fa fa-download" aria-hidden="true"></i></a>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <p class="dropdown-item" onclick="exportDataCsv();"><i class="fa fa-file-code-o"
                                                aria-hidden="true"></i>&nbsp; CSV</p>
                                        <p class="dropdown-item" onclick="exportDataXlsx();"><i
                                                class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp; XLSX</p>
                                        <p class="dropdown-item" onclick="exportDataPdf();"><i class="fa fa-file-pdf-o"
                                                aria-hidden="true"></i>&nbsp; PDF</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            @include('layouts.table')
                            <table id="datatables" class="table table-striped table-no-bordered table-hover"
                                style="display:none">
                                <thead class="text-dark">
                                    <th>
                                        {{ __('Name') }}
                                    </th>
                                    <th>
                                        {{ __('Description') }}
                                    </th>
                                    <th>
                                        {{ __('Creation date') }}
                                    </th>
                                    <th class="text-right">
                                        {{ __('Actions') }}
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                    <tr>
                                        <td>
                                            <a
                                                href="{{URL::action('RoleController@show',$role->id)}}">{{ $role->name }}</a>
                                        </td>
                                        <td>
                                            {{ $role->description }}
                                        </td>
                                        <td>
                                            {{ $role->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="td-actions text-right">
                                            @include('roles.options.actions')
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
        { "orderable": false, "targets": 3 },
      ],
    });
  });
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
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
</script>

@endpush
