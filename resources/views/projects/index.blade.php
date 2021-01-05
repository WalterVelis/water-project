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
                                <a name="" id="" class="btn btn-primary btn-sm btn-round" style="color:white; padding:5px;" href="{{ route('projects.create') }}" role="button"><i style="color:white;font-size: 1em;padding: 4px;" class="fa fa-plus fw" aria-hidden="true"></i></a>
                                @if(App\User::hasPermissions("Budget Create Account"))
                                    <a href="{{ route('projects.create') }}"
                                        class="btn btn-sm btn-rose">{{ __('Nuevo Proyecto') }}</a>
                                @endif
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 text-right">
                                <a class="float-right" href="/formatPdf/">
                                    <button class=" d-inline" style="    background: none; border: none; font-size: 1.5em;" type="button">
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                    </button>
                                </a>
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
                                            {{ __('First Contact') }}
                                        </th>
                                        <th>
                                            {{ __('Email') }}
                                        </th>
                                        <th>
                                            {{ __('Phone') }}
                                        </th>
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
                                            <td>
                                                {{ $item->email }}
                                            </td>
                                            <td>
                                                {{ $item->phone }}
                                            </td>

                                            <td>
                                                {{ $item->created_at->format('Y-m-d') }}
                                            </td>
                                            <td>
                                                {{ $item->statusLabel() }}
                                            </td>
                                            <td class="td-actions text-right">
                                                <!-- <a href="{{ route('projects.show', $item->id) }}"><i class="material-icons">remove_red_eye</i></a> -->
                                                <a class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Editar" href="{{ route('projects.edit', $item->id) }}"><i class="material-icons">edit</i></a>
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
            <div class="copyright "> &copy; <script> document.write(new Date().getFullYear()) </script> Cotizador de AguaH2O, Todos los derechos reservados. Desarrollado por ISINET.</div>
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

