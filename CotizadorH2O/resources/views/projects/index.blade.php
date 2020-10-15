@extends('layouts.app', ['activePage' => 'projects-management', 'menuParent' => 'projects', 'sublevel' => 'necesidades', 'titlePage' => __('Proyectos')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">assignment</i>
                </div>
                <h4 class="card-title">
                    {{ __('Lista de Proyectos') }}</h4>
              </div>
              <div class="card-body">

                  <div class="row d-none">
                    <div class="col-12 text-left">
                        <a id="exportXlsx" href="{{ route('user_xlsx') }}" class="btn btn-sm btn-rose">{{ __('Export xlsx') }}</a>
                        <a id="exportCsv" href="{{ route('user_csv') }}" class="btn btn-sm btn-rose">{{ __('Export csv') }}</a>
                        <a id="exportPdf" href="{{ route('userPdf',['all'])}}" target='_blank' class="btn btn-sm btn-rose">{{ __('Export pdf') }}</a>
                    </div>
                  </div>

                  <div class="row col-12">
                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12 text-right">
                    @if(App\User::hasPermissions("Budget Create Account"))
                      <a href="{{ route('projects.create') }}" class="btn btn-sm btn-rose">{{ __('Nuevo Proyecto') }}</a>
                    @endif
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 text-right">
                      <div class="dropdown">
                        <button title="Download Data" class="dropdown-toggle btn btn-sm btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-download" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">                            
                          <p class="dropdown-item" onclick="exportDataCsv();"><i class="fa fa-file-code-o" aria-hidden="true"></i>&nbsp; CSV</p>
                          <p class="dropdown-item" onclick="exportDataXlsx();"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp; XLSX</p>
                          <p class="dropdown-item" onclick="exportDataPdf();"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; PDF</p>
                        </div>
                      </div>
                    </div>
                  </div>

                <div class="table-responsive">
                  @include('layouts.table')
                  <table id="datatables" class="table table-striped table-no-bordered table-hover" style="display:none">
                    <thead class="text-primary">
                        <th>
                            {{ __('Id') }}
                        </th>
                        <th>
                            {{ __('Cliente') }}
                        </th>
                        <th>
                          {{ __('Ciudad') }}
                        </th>
                        <th>
                            {{ __('Telefono') }}
                        </th>
                        <th>
                          {{ __('Correo') }}
                        </th>
                          
                       
                    </thead>
                    <tbody>
                      
                        <tr>
                          <td>
                             
                          </td>
                          <td>
                           
                          </td>
                          <td>
                   
                          </td>
                          <td>
                       
                          </td>
                          <td class="td-actions text-right">
                          <i class="material-icons">close</i>
                        </td>
                        </tr>
                    
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
        { "orderable": false, "targets": 4 },
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

</script>
@endpush