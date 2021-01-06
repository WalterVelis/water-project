<style>
    .table thead tr.cc th {
        font-size: 0.9rem;
        background: #bacfda;
        color: black;
        padding: 12px 10px;
        font-weight: bold;
    }
    td {
        border: solid 1px;
    }

    .c-table td, .c-table th{
        border: solid 1px lightgrey;
    }

    .c-table {
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }
</style>

<div style="text-align: center;">
    <div>
        <div style="display: inline-block;    ">
            <img style="height:100px" src="material/img/licons/iu.png" alt="AGUA">
        </div>
        <div style="display: inline-block; position: relative; top: -38px; margin-left: -50px;">
            <h2>
                LISTADO MATERIAL EXTRA
            </h2>
        </div>
    </div>
{{-- @dd($project_materials) --}}
@php($total = 0)
@if (App\User::hasPermissions("Tech") || App\User::hasPermissions("Vendor"))
<div class="row">
    <div class="col-8">
        <table class="table c-table">
            <thead>
                <tr class="cc">
                    <th>ID</th>
                    <th>Material</th>
                    <th>Unidad</th>
                    <th>Cantidad</th>
                    <th>Tipo de material</th>
                </tr>
            </thead>
            <tbody>
                @foreach($project_materials as $item)
                {{-- @dump($item) --}}
                    <tr>
                        <td scope="row">{{ $item->id }}</td>
                        <td>{{ $item->materials->name }}</td>
                        <td>{{ $item->materials->unitLabel() }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->materials->type }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

</div>
