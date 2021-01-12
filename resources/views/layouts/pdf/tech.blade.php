@php
use Carbon\Carbon;
@endphp
<style>
    td, th {
        border: solid 2px #16506e;
        padding: 4px;
    }

    th, .bg-b {
        background: #16506e;
        color: white;
        font-weight:bold;
    }

    td.bg-b {
        border: solid 2px black;
    }

    table {
        border-collapse: collapse;
    }

    .st {
        color: #16506e;
        font-weight: bold;
        font-size: 1.1em;
    }

    .right {
        text-align: right;
    }

    .center {
        text-align: center;
    }

    .b {
        font-weight: bold;
    }

    .b-blue {
        background: #BBDEFB;
    }
</style>
<table style="width:100%;">
    <tr class="b-blue"  >
        <td style="width:20%;"><img style="height:100px" src="material/img/licons/pas-bf-white.png" alt="AGUA"></td>
        <td><h3 class="st" style="text-align:center; font-size:1.3em;">LEVANTAMIENTO TÉCNICO</h3></td>
        <td style="width:20%; text-align:right;"><img style="height:100px" src="material/img/licons/iu.png" alt="AGUA"></td>
    </tr>
</table>

<table style="width:100%;">
    <thead style="visibility:collapse">
        <tr style="width:100%;">
            <td width="25%"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td width="18%"></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="right b">Fecha: </td>
            <td colspan="2"> {{ $format->date }}</td>
            <td colspan="1"></td>
            <td> Folio</td>
            <td> {{ $format->page }}</td>
        </tr>
        <tr>
            <td class="right b">Dirección: </td>
            <td colspan="5" class="b-blue">{{ $format->street }}, No. Ext. {{ $format->n_ext }}, No. Int. {{ $format->n_int }},  {{ $format->colony }}, {{ $format->municipality }}, {{ $format->state }}, {{ $format->country->name }}  </td>
        </tr>
        <tr>
            <td class="right b">Cliente: </td>
            <td colspan="5">{{ $format->client }}</td>
        </tr>
        <tr>
            <td class="right b">Contacto principal: </td>
            <td class="b-blue" colspan="5">{{ $format->main_contact }}</td>
        </tr>
        <tr>
            <td class="right b">Puesto: </td>
            <td colspan="5">{{ $format->position }}</td>
        </tr>
        <tr>
            <td class="right b">Teléfono: </td>
            <td class="b-blue" colspan="5">{{ $format->phone }}</td>
        </tr>
        <tr>
            <td class="right b">Correo: </td>
            <td colspan="5">{{ $format->email }}</td>
        </tr>
        @php($water_quality = explode(",",$tech->water_quality))
        <tr>
            <td class="right b">Calidad del agua requerida: </td>
            <td>WC y riego {{ in_array(__('WC and Watering'), @$water_quality) ? '(X)' : '( )' }}</td>
            <td>Higiene y aseo personal {{ in_array(__('Hygiene and personal care'), @$water_quality) ? '(X)' : '( )' }}</td>
            <td>Purificada {{ in_array(__('Purified'), @$water_quality) ? '(X)' : '( )' }}</td>
            <td>Otro {{ in_array(__('Other'), @$water_quality) ? '(X)' : '( )' }}</td>
            <td>Especificar: ___</td>
        </tr>
        @php($filter_type = explode(",",$tech->filter_type))
        <tr>
            <td></td>
            <td>@if(in_array(__('WC and Watering'), @$water_quality))Tipo de filtro: {{ @$filter_type[0] }}@endif</td>
            <td>@if(in_array(__('Hygiene and personal care'), @$water_quality))Tipo de filtro: {{ @$filter_type[1] }}@endif</td>
            <td>@if(in_array(__('Purified'), @$water_quality))Tipo de filtro: {{ @$filter_type[2] }}@endif</td>
            <td colspan="2">@if(in_array(__('Other'), @$water_quality))Tipo de filtro: {{ @$filter_type[3] }}@endif</td>
        </tr>
        <tr>
            <td class="right b">Tipo de techo captación de lluvia: </td>
            <td colspan="5">{{ $tech->roof_type }}</td>
        </tr>
        <tr>
            <td class="right b">Acabado azotea: </td>
            <td colspan="5">{{ $tech->rooftop }}</td>
        </tr>
        <tr>
            <td class="right b">Área de captación de agua de lluvia: </td>
            <td class="b-blue">Techo</td>
            <td>{{ $tech->rainwater_area }}</td>
            <td class="b-blue">M2</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="right b"></td>
            <td class="b-blue">Canaletas</td>
            <td>{{ $tech->gutter }}</td>
            <td class="b-blue">pulgadas/metros</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="right b">Precipitación Pluvial de la Zona:</td>
            <td class="b-blue">Promedio Anual</td>
            <td>{{ $tech->anual_precipitation }}</td>
            <td class="b-blue">M3</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="right b">Captación de Lluvia estimada (considerar 15% perdida):</td>
            <td class="b-blue">Promedio Anual</td>
            <td>{{ $tech->anual_precipitation * $tech->rainwater_area * 0.85 }}</td>
            <td class="b-blue">Litros</td>
            <td></td>
            <td></td>
        </tr>

        <tr>
            <td class="right b">Volumen de almacenamiento (CISTERNA):</td>
            <td class="">{{ $tech->rainwater_area * ($tech->environment == 0 ? 20 : 30) * 0.85 }}</td>
            <td class="">Litros</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="right b">Tinaco que surte a servicio:</td>
            <td class="">{{ $tech->water_tank }}</td>
            <td class="">Litros</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="right b">Distancia desde el área de captacion a la cisterna:</td>
            <td class="">{{ $tech->distance }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="right b">Nivel de limpieza del techo:</td>
            <td class="">{{ $tech->cleanliness ? "Sucio con obstaculos " : "Limpio y Despejado" }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="right b">Cuentan con bajantes del techo:</td>
            <td class="">{{ Helper::boolString($tech->roof_slope) }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

        <tr>
            <td class="right b">Otras consideraciones técnicas existentes:</td>
            <td class="b-blue">Tubería</td>
            <td>{{ $tech->tube }}</td>
            <td class="b-blue">tipo/diametro</td>
            <td class="b-blue">Red diametro (pulgadas):</td>
            <td></td>
        </tr>
        <tr>
            <td class="right b"></td>
            <td class="b-blue">Bomba</td>
            <td>{{ $tech->pump }}</td>
            <td class="b-blue">potencia/diametro</td>
            <td class="b-blue">Succión diametro (1"):</td>
            <td>{{ $tech->diameter_inch }}</td>
        </tr>
        <tr>
            <td class="right b"></td>
            <td class="">¿Cuarto bombas debajo cisterna? {{ Helper::boolString($tech->pump_below_tank) }}</td>
            <td>¿Riesgo de inundacion bombas?</td>
            <td>{{ Helper::boolString($tech->pump_inundation) }}</td>
            <td>¿Espacio filtros necesita caseta?</td>
            <td>{{ Helper::boolString($tech->filter_stall) }}</td>
        </tr>
        <tr>
            <td class="right b"></td>
            <td class="">Notas:</td>
            <td colspan=4>{{ $tech->notes }}</td>
        </tr>

        <tr>
            <td class="right b">Otros detalles:</td>
            <td class="">Excavación (m3)</td>
            <td>{{ $tech->excavation }}</td>
            <td class="">Doble flotador</td>
            <td class="">{{ Helper::boolString($tech->d_float) }}</td>
            <td></td>
        </tr>
        <tr>
            <td class="right b"></td>
            <td class="">Control</td>
            <td>{{ $tech->control ? "automático" : "manual" }}</td>
            <td class=""></td>
            <td class=""></td>
            <td></td>
        </tr>
        <tr>
            <td class="right b"></td>
            <td class="">Necesita conexión eléctrica</td>
            <td>{{ Helper::boolString($tech->require_connection) }}</td>
            <td class="">Electroniveles</td>
            <td class="">{{ Helper::boolString($tech->electro) }}</td>
            <td></td>
        </tr>
        <tr>
            <td class="right b-blue">Notas adicionales</td>
            <td colspan="5" class="">{{ $tech->subnotes }}</td>
        </tr>
        <tr>
            <td class="right b-blue">Descripción del área y condiciones del inmueble donde se implementa el sistema:</td>
            <td colspan="5" class="">{{ $tech->description }}</td>
        </tr>
        <tr>
            <td class="b-blue" colspan="3" style="padding:5px;">
                <h2>NOTAS: Como escoger el mejor techo?</h2>
                <p>I. Limpio, grande, cerca de cisterna </p>
                <p>II. Techo Ideal: canaletas, bajantes (buenas condiciones?),tuberia conectada</p>
                <p>III. En caso de Escuela (AULAS): bajantes, pretiles</p>
            </td>
            <td colspan="1">Nombre y Firma Técnico:</td>
            <td colspan="2" style="text-align:center">{{ $tech->format->user->name }}</td>
        </tr>
    </tbody>
</table>
