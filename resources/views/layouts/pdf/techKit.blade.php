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
        /* text-align: center; */
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
                KIT ISLA URBANA
            </h2>
        </div>
    </div>

    <table class="table c-table">
        <thead>
            <tr class="cc">
                <th>ID</th>
                <th>Material</th>
                <th>Piezas</th>
                @if(App\User::hasPermissions("Admin"))
                <th style="width:5%;">Costo Unitario</th>
                <th>Costo (sin IVA)</th>
                <th  style="width:5%;">Descuento (%)</th>
                <th>Costo con descuento</th>
                @endif
                <th>Total</th>
                @if(App\User::hasPermissions("Admin"))
                <th>Observaciones</th>
                @endif
                {{-- <th>Acciones</th> --}}
            </tr>
        </thead>
        <tbody>
            @php($total = 0)
            @foreach($kit as $item)
                @php($total += (($item->cost - ($item->discount / 100) * $item->cost)) * $item->qty)
                <tr>
                    <td scope="row">{{ $item->id }}</td>
                    <td>{{ $item->accesory->name }}</td>
                    <td>{{ $item->qty }}</td>
                    @if(App\User::hasPermissions("Admin"))
                    <td>{{ Helper::formatMoney($item->cost) }}</td>
                    <td>{{ Helper::formatMoney($item->cost - ($item->cost * 0.16)) }}</td>
                    <td>{{ $item->discount }}%</td>
                    <td>{{ Helper::formatMoney(($item->cost - ($item->discount / 100) * $item->cost)) }}</td>
                    @endif
                    <td>{{ Helper::formatMoney((($item->cost - ($item->discount / 100) * $item->cost)) * $item->qty) }}</td>
                    @if(App\User::hasPermissions("Admin"))
                    <td>{{ $item->details }}</td>
                    @endif
                    {{-- <td><i class="fa fa-trash" aria-hidden="true" onclick="removeAccesory({{ $item->id }})"></i></td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
