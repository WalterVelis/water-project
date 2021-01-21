@extends('layouts.app', ['activePage' => 'projects-management', 'menuParent' => 'projects-management', 'sublevel' => 'necesidades', 'titlePage' => __('Gestión de Proyectos')])


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
                            {{ __('Proyectos') }}</h4>
                    </div>
                    <div class="card-body">

                        <div class="row d-none">
                            <div class="col-12 text-left">
                                <a id="exportXlsx" href="/formatPdf"
                                    class="btn btn-sm btn-rose">{{ __('Export xlsx') }}</a>
                                {{-- <a id="exportCsv" href="{{ route('user_csv') }}"
                                    class="btn btn-sm btn-rose">{{ __('Export csv') }}</a> --}}
                                <a id="exportPdf"
                                    href="/formatPdf"
                                    target='_blank'
                                    class="btn btn-sm btn-rose">{{ __('Export pdf') }}</a>
                            </div>
                        </div>

                        <div class="row col-12">
                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12 text-right">
                                @if(App\User::hasPermissions("Admin") || App\User::hasPermissions("Vendor") )<a name="" id="" class="btn btn-primary btn-sm btn-round" style="color:white; padding:5px;" href="{{ route('projects.create') }}" role="button"><i style="color:white;font-size: 1em;padding: 4px;" class="fa fa-plus fw" aria-hidden="true"></i></a>@endif
                                @if(App\User::hasPermissions("Budget Create Account"))
                                    <a href="{{ route('projects.create') }}"
                                        class="btn btn-sm btn-rose">{{ __('Nuevo Proyecto') }}</a>
                                @endif
                            </div>
                            {{-- <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 text-right">
                                <a class="float-right" href="/formatPdf/">
                                    <button class=" d-inline" style="    background: none; border: none; font-size: 1.5em;" type="button">
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                    </button>
                                </a>
                            </div> --}}

                            <div class="dropdown" style="position: absolute; right: 0px;">
                                <button title="Download Data" class="dropdown-toggle" style="background: none; border: none; font-size: 1.5em;    width: 90px;" type="button" id="costmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="costmenu">
                                    <a class="dropdown-item" href="/projectCsv/"><p class=""><i class="fa fa-file-code-o" aria-hidden="true"></i>&nbsp; CSV</p></a>
                                    <a class="dropdown-item" href="/projectXlsx/"><p class=""><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp; XLSX</p></a>
                                    <a class="dropdown-item" href="/formatPdf/"><p class=""><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; PDF</p></a>
                                </div>
                            </div>

                        </div>
                        <div class="table-responsive">
                            @include('layouts.table')
                            @if( ! $projects->isEmpty() )

                                <table id="datatables" class="table table-striped table-no-bordered table-hover"
                                    style="display:none">
                                    <thead class="text-primary">
                                        <th>
                                            {{ __('Page') }}
                                        </th>
                                        <th>
                                            {{ __('Client') }}
                                        </th>
                                        <th>
                                            {{ __('Main Contact') }}
                                        </th>
                                        <th>
                                            {{ __('Place') }}
                                        </th>
                                        <th>
                                            {{ __('Fecha Primer Contacto') }}
                                        </th>
                                        {{-- <th>
                                            {{ __('Email') }}
                                        </th>
                                        <th>
                                            {{ __('Phone') }}
                                        </th> --}}
                                        @if(App\User::hasPermissions("Admin"))
                                        <th>Vendedor asignado</th>
                                        <th>Técnico asignado</th>
                                        @endif
                                        @if(App\User::hasPermissions("Tech"))
                                        <th>Vendedor asignado</th>
                                        @endif
                                        @if(App\User::hasPermissions("Vendor"))
                                        <th>Técnico asignado</th>
                                        @endif
                                        <th>
                                            {{ __('Quotation Date') }}
                                        </th>
                                        <th>
                                            {{ __('Estado') }}
                                        </th>
                                        <th>
                                            {{ __('Actions') }}
                                        </th>
                                    </thead>
                                    <tbody>

                                        @foreach($projects as $item)
                                        <tr {{ $item->status == 0 ? 'style=opacity:0.5' : '' }}>
                                            <td>
                                                {{ $item->page }}
                                            </td>
                                            <td>
                                                {{ $item->client }}
                                            </td>
                                            <td>
                                                {{ $item->main_contact }}
                                            </td>

                                            <td>
                                                {{ $item->state }}, {{ $item->municipality }}
                                            </td>
                                            <td>
                                                {{ $item->date }}
                                            </td>
                                            {{-- <td>
                                                {{ $item->email }}
                                            </td>
                                            <td>
                                                {{ $item->phone }}
                                            </td> --}}
                                            @if(App\User::hasPermissions("Admin"))
                                            <td>{{ $item->vendor->name }}</td>
                                            <td>{{ $item->tech->name }}</td>
                                            @endif
                                            @if(App\User::hasPermissions("Tech"))
                                            <td>{{ $item->vendor->name }}</td>
                                            @endif
                                            @if(App\User::hasPermissions("Vendor"))
                                            <td>{{ $item->tech->name }}</td>
                                            @endif
                                            <td>
                                                {{ $item->created_at->format('Y-m-d') }}
                                            </td>
                                            <td>
                                                {{ $item->status == 2 ? "No factible" : $item->statusLabel() }}
                                            </td>
                                            <td class="td-actions text-right" style="    white-space: nowrap;">
                                                <!-- <a href="{{ route('projects.show', $item->id) }}"><i class="material-icons">remove_red_eye</i></a> -->
                                                <a class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Editar" href="{{ route('projects.edit', $item->id) }}"><i class="material-icons">edit</i></a>
                                                @if($item->status == 0)
                                                <form action="{{ route('projects.destroy', $item->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Eliminar" ><i class="material-icons">close</i></button>
                                                </form>
                                                @endif
                                                {{-- <i class="material-icons">close</i> --}}
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            @else
                                {{ __('No records found') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container-fluid">
            <div class="copyright "> &copy; <script> document.write(new Date().getFullYear()) </script> Cotizador AguaH2O, Todos los derechos reservados. Desarrollado por ISINET.</div>
        </div>
    </footer>
</div>

@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#datatables').fadeIn(1100);
            $('#datatables').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                // responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: $('#SearchTable').val(),
                    "lengthMenu": $('#showTable').val(),
                    "info": $('#infoTable').val(),
                    "infoEmpty": $('#emptyTable').val(),
                    "zeroRecords": $('#emptyRecords').val(),
                    "infoFiltered": $('#filterRecords').val(),
                    "paginate": {
                        "next": $('#nextTable').val(),
                        "previous": $('#previusTable').val(),
                        "first": $('#firstTable').val(),
                        "last": $('#lastTable').val()
                    },
                },
                "columnDefs": [{
                    "orderable": false,
                    "targets": 4
                }, ],
            });
        });

    </script>
    <script>
        function exportDataCsv() {
            document.getElementById('exportCsv').click()
        }

        function exportDataXlsx() {
            document.getElementById('exportXlsx').click()
        }

        function exportDataPdf() {
            document.getElementById('exportPdf').click()
        }

    </script>
@endpush

