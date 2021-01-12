<style>
    td {
        border: solid 1px;
    }
</style>

<div style="text-align: center;">
    <div>
        <div style="display: inline-block;    ">
            <img style="height:100px" src="material/img/licons/pas-bf-white.png" alt="AGUA">
        </div>
        <div style="display: inline-block; position: relative; top: -38px; margin-left: 10px;">
            <h4>
                COSTO DE MANO DE OBRA Y HERRAMIENTAS DE TRABAJO
            </h4>
        </div>
    </div>

    <table style="width:100%;border-collapse: collapse;" class="table c-table">
        <thead>
            <tr style="background:#8db3e2" class="cc">
                <th>Días</th>
                <th>Especialidad</th>
                <th>Costo Unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php($total = 0)
            @foreach($project_costs as $pc)
            @php($total += $pc->cost * $pc->day)
                <tr>
                    <td>{{ $pc->day }}</td>
                    <td>{{ $pc->costs->name }}</td>
                    <td style="text-align: right;">{{ Helper::formatMoney($pc->cost) }}</td>
                    <td style="text-align: right;">{{ Helper::formatMoney($pc->cost * $pc->day) }}</td>
                </tr>
            @endforeach
            <tr style="background:#8db3e2">
                <td colspan="3">
                    TOTAL:
                </td>
                <td>
                    {{ Helper::formatMoney($total) }}
                </td>
            </tr>
        </tbody>
    </table>

    <b>* NO INCLUYE IVA E INCLUYE HERRAMIENTAS</b>
</div>
