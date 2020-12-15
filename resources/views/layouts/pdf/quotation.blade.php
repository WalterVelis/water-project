<style>
    td {
        padding: 3px 6px
    }

    table {
        border: solid 1px gray;
    }

    .b {
        font-weight:bold;
    }

    .bl {
        border-left: solid 1px gray;
    }

    .blue {
        background:#8db3e2
    }

    .c-table2 td{
        border: solid 1px gray;
    }
</style>

<div style="text-align: center;">
    <div>
        <div style="display: inline-block;    ">
            <img style="height:100px" src="material/img/licons/pas-bf-white.png" alt="AGUA">
        </div>
        <h2 style="margin-top:-60px;color:#32526f;">Cotización</h2>
    </div>

    <table style="width:100%;border-collapse: collapse;" class="table c-table">
        <tbody>
            <tr>
                <td class="b">Razón social: </td>
                <td>{{ $format->client }}</td>
                <td></td>
                <td></td>
                <td class="b bl">Fecha:</td>
                <td>{{ $quotation->created_at->format('Y-m-d') }}</td>
            </tr>
            <tr>
                <td class="b">Contacto: </td>
                <td>{{ $format->main_contact }}</td>
                <td class="b">Correo electrónico:     </td>
                <td>{{ $format->email }}</td>
                <td class="b bl">Vigencia:</td>
                <td>{{ $quotation->validity }}</td>
            </tr>
            <tr>
                <td class="b">Dirección: </td>
                <td></td>
                <td></td>
                <td></td>
                <td class="b bl">Moneda:</td>
                <td>{{ $quotation->currency }}</td>
            </tr>
            <tr>
                <td class="b">Tel/s: </td>
                <td>{{ $format->phone }}</td>
                <td></td>
                <td></td>
                <td class="b bl">No. Cot.:</td>
                <td>{{ $quotation->id }}</td>
            </tr>
            <tr>
                <td class="b">Página web: </td>
                <td>{{ $quotation->web }}</td>
                <td></td>
                <td></td>
                <td class="b bl">Versión:</td>
                <td>{{ $quotation->version }}</td>
            </tr>
        </tbody>
    </table>

    <table style="margin-top:10px;width:100%;border-collapse: collapse;" class="table c-table2">
        <thead>
            <tr style="text-align: center; font-weight:bold; background:#8db3e2">
                <td>ID</td>
                <td>Descripción</td>
                <td>Cantidad</td>
                <td>Costo Unitario</td>
                <td>Total</td>
            </tr>
        </thead>
        <tbody>
            @foreach($subQuotation as $sc)
            <tr>
                <td>{{ $sc->id }}</td>
                <td>{{ $sc->description }}</td>
                <td>{{ $sc->qty }}</td>
                <td>{{ Helper::formatMoney($sc->cost) }}</td>
                <td>{{ Helper::formatMoney($sc->qty * $sc->cost) }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3"></td>
                <td class="b">Sub Total</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="b">IVA 16%</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="b">TOTAL</td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <div style="margin-top:50px">
        <div style="width:50%; display: inline-block;">
            <div style="border:solid 1px gray;" class="blue b">Tiempo de Entrega</div>
            <div style="border:solid 1px gray;">{{ $quotation->delivery }}</div>
            <br>
            <div style="border:solid 1px gray;" class="blue b">Forma de pago</div>
            <div style="border:solid 1px gray;">{{ $quotation->payment }}</div>
            <br>
            <div style="border:solid 1px gray;" class="blue b">Elaboró:</div>
            <div style="border:solid 1px gray;">{{ $format->vendor->name }}</div>
        </div>
        <div style="margin-top:-35px;width:50%; display: inline-block;">
            <div style="border:solid 1px gray;" class="blue b">Notas:</div>
            <div style="border:solid 1px gray;">{{ $quotation->notes }}</div>
        </div>
    </div>

</div>
