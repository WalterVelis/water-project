@extends('layouts.app', ['activePage' => 'projects-management', 'menuParent' => 'projects', 'sublevel' => 'necesidades', 'titlePage' => __('Gestión de proyectos')])

<style>
    .form-check .form-check-label {
        padding-right: 0px!important;
    }


    .c_label {
        /* font-size: 1.1em !important; */
        padding: 0 !important;
        margin-left: 15px !important;
        width: auto !important;
        margin-top: 30px;
    }

    #all-container {
        background: #7dabc375;
        padding: 30px;
    }

    #format-content {
        padding: 20px;
        border: solid 4px #32526f;
        border-radius: 6px;
        background: white;
        height: 60vh;
        overflow-y: scroll;
        overflow-x: hidden;
    }

    nav .nav-item.active {
        color: white;
        background: #32526f;
    }
</style>

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div id="all-container">
                    <h3 style="margin-top:-10px;">
                    </h3>
                    <nav class="navbar step-navbar navbar-expand-lg c-nav">
                        <div class="container">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-bar navbar-kebab"></span>
                            <span class="navbar-toggler-bar navbar-kebab"></span>
                            <span class="navbar-toggler-bar navbar-kebab"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                <ul class="navbar-nav" style="">
                                    <li class="nav-item {{ $format->internal_status >= 0 ? "c-enabled" : "" }}">
                                        <a class="nav-link" href="{{ $format->internal_status >= 0 ? route('projects.edit', $format) : "#" }}">{{ __('Needs Diagnosis') }}</a>
                                    </li>
                                    <li class="nav-item  {{ $format->internal_status >= 0 ? "c-enabled" : "" }}">
                                        <a class="nav-link" href="{{ $format->internal_status >= 0 ? route('techformat.edit', $format) : "#" }}">{{ __('Technical Lift') }}</a>
                                    </li>
                                    <li class="nav-item  {{ $format->internal_status >= 1 ? "c-enabled" : "" }}">
                                        <a class="nav-link" href="{{ $format->internal_status >= 1 ? "/quotation/$format->id/edit" : "#" }}">{{ __('Quotation') }}</a>
                                    </li>
                                    <li class="nav-item active {{ $format->internal_status >= 5 ? "c-enabled" : "" }}">
                                        <a class="nav-link" href="{{ $format->internal_status >= 5 ? "/order/$format->id/edit" : "#" }}">{{ __('Purchase Order') }}</a>
                                    </li>
                                    <li class="nav-item {{ $format->internal_status >= 1 ? "c-enabled" : "" }}">
                                        <a class="nav-link" href="{{ $format->internal_status >= 1? "/assignment/$format->id/edit" : "#" }}">{{ __('Assignment') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <div class="card-body">

                        <div class="row d-none">
                            <div class="col-12 text-left">
                                {{-- <a id="exportXlsx" href="{{ route('user_xlsx') }}"
                                    class="btn btn-sm btn-rose">{{ __('Export xlsx') }}</a>
                                <a id="exportCsv" href="{{ route('user_csv') }}"
                                    class="btn btn-sm btn-rose">{{ __('Export csv') }}</a> --}}
                                {{-- <a id="exportPdf"
                                    href="{{ route('getFormat', $format->id) }}"
                                    target='_blank'
                                    class="btn btn-sm btn-rose">{{ __('Export pdf') }}</a> --}}
                            </div>
                        </div>

                        <div class="row col-12">

                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 text-right">

                            </div>
                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12 text-right">
                                <h4>TOTAL A PAGAR <br> <strong id="totalSum"></strong></h4>
                            </div>
                        </div>
                        <div class="table-responsive">
                            @include('layouts.table')
                            @foreach($providers as $item)
                            {{-- @dump($item) --}}
                            @endforeach
                            {{-- @dd($providers) --}}
                            {{-- @dd("end") --}}
                            {{-- @if( ! $providers->isEmpty() ) --}}

                                <table id="datatables" class="table table-striped table-no-bordered table-hover"
                                    style="display:none">
                                    <thead class="text-primary">
                                        <th>
                                            {{ __('Orden') }}
                                        </th>
                                        <th>
                                            {{ __('Proveedor') }}
                                        </th>
                                        <th>
                                            {{ __('Total a pagar por proveedor') }}
                                        </th>
                                        <th>
                                            {{ __('Fecha de orden de compra') }}
                                        <th>
                                            {{ __('Actions') }}
                                        </th>
                                    </thead>
                                    <tbody>
                                        {{-- $providers, not $projects --}}
                                        {{-- @dump($providers) --}}
                                        @php($totalSum = 0.00)
                                        @foreach($providers as $item)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $item->denomination }}
                                            </td>
                                            <td>
                                                {{ Helper::formatMoney($totals[$item->id] * 1.13)  }}
                                                @php($totalSum += $totals[$item->id] * 1.13)
                                            </td>

                                            <td>
                                                {{ $item->created_at }}
                                            </td>
                                            <td class="td-actions text-right">
                                                <a data-toggle="tooltip" data-placement="top" title="Descargar" href="/getorder/{{ $item->id }}/{{ $id }}/{{ $loop->iteration }}"><i class="material-icons">arrow_downward</i></a>
                                                {{-- <i class="material-icons">close</i> --}}
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            {{-- @else --}}
                                {{-- {{ __('No records found') }} --}}
                            {{-- @endif --}}
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
        $(document).ready(function () {

            $('#totalSum').html('{{ Helper::formatMoney($totalSum) }}');

            $('#datatables').fadeIn(1100);
            $('#datatables').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                responsive: true,
                // dom: 'Bfrtip',
                // buttons: [
                //     'copy', 'excel', 'pdf'
                // ],
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
