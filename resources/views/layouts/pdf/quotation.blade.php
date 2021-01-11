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

    .clearfix {
  overflow: auto;
}


.clearfix::after {
  content: "";
  clear: both;
  display: table;
}
</style>

<div style="display: inline-block; width:100%;">
    <img style="height:100px; display:inline-block; width:120px;" src="material/img/licons/pas-bf-white.png" alt="AGUA">
    <div style="display:inline-block;text-align: center;margin-left:-20%;margin-bottom:0px;">
        <h2 style="color:#32526f;">ASESORES EN GESTIÓN URBANA DEL AGUA</h2>
        <div style="color:#32526f;">www.aguah2o.com.mx</div>
    </div>
</div>
<div class="blue" style="text-align:center;line-height:20px;padding: 10px 18px;position: absolute;margin-left:-221px;height:20px;width:182px;   ;top:60px;border: solid 1px gray"> <b>COTIZACIÓN</b> </div>
<div style="text-align: center;">


    <table style="width:100%;border-collapse: collapse;" class="table c-table">
        <tbody>
            <tr>
                <td class="b">Razón social: </td>
                <td>{{ $format->client }}</td>
                <td></td>
                <td></td>
                <td style="width:100px" class="b bl">Fecha:</td>
                <td style="width:95px">{{ $quotation->created_at->format('Y-m-d') }}</td>
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
                <td colspan="3">{{ $format->street }}, No. Ext. {{ $format->n_ext }}, No. Int. {{ $format->n_int }},  {{ $format->colony }}, {{ $format->municipality }}, {{ $format->state }}, {{ $format->country->name }}</td>
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
                <td style="text-align: right;">{{ Helper::formatMoney($sc->cost) }}</td>
                <td style="text-align: right;">{{ Helper::formatMoney($sc->qty * $sc->cost) }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" style="border-bottom:solid 1px transparent;"></td>
                <td class="b">Sub Total</td>
                <td style="text-align: right;">$0.00</td>
            </tr>
            <tr>
                <td colspan="3" style="border-bottom:solid 1px transparent;"></td>
                <td class="b">IVA 16%</td>
                <td style="text-align: right;">$0.00</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="b">TOTAL</td>
                <td style="text-align: right;"><b>$0.00</b></td>
            </tr>
        </tbody>
    </table>
    <br>
    <div style="margin-top:40px" class="clearfix" style="page-break-inside: avoid;">
        <div style="width:40%; display: inline-block;page-break-inside: avoid;" class="clearfix">
            <div>
                <div style="border:solid 1px gray; width:200px;" class="blue b">Tiempo de Entrega (días)</div>
                <div style="border:solid 1px gray;text-align:left;padding: 2px 6px;">{{ $quotation->delivery }}</div>
                <br>
                <div style="border:solid 1px gray; width:200px;" class="blue b">Forma de pago</div>
                <div style="border:solid 1px gray;text-align:left;padding: 2px 6px;">{{ $quotation->payment }}</div>
                <br>
                <div style="border:solid 1px gray; width:200px;" class="blue b">Elaboró:</div>
                <div style="border:solid 1px gray;text-align:left;padding: 2px 6px;">
                    <span>{{ $format->vendor->name }}</span><br>
                    <span>{{ $format->vendor->email }}</span><br>
                    <span>{{ $format->vendor->phone }}505050</span>
                </div>
            </div>
        </div>
        <div style="margin-top:-5px;width:50%; display: inline-block;margin-left:9%;">
            <div style="border:solid 1px gray;width:100px;" class="blue b">Notas:</div>
            <div style="height:180px;border:solid 1px gray;text-align:left;padding: 2px 6px;">{{ $quotation->notes }} Lorem imilique numquam eaque odio veritatis alias fuga iure autem, commodi dolore facilis, pariatur aspernatur incidunt suscipit, dolores quo doloribus reiciendis?</div>
        </div>
    </div>

</div>
