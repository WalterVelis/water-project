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
        <td style="width: 60%"><h3 class="st" style="text-align:center; font-size:1.3em;">DIAGNÓSTICO DE NECESIDADES</h3></td>
        <td style="width:20%; text-align:right;"><img style="height:100px" src="material/img/licons/iu.png" alt="AGUA"></td>
    </tr>
</table>

<table style="width:100%;margin-top:10px;">
    <tbody style="width:100%;">
        <tr>
            <td width="35%" class="right b">Fecha: </td>
            <td width="15%">{{ @$format->created_at->format('Y-m-d') }}</td>
            <td width="30%" colspan="2"></td>
            <td width="12%">Folio</td>
            <td width="8%">{{ @$format->page }}</td>
        </tr>
        <tr>
            <td width="35%" class="right b">Dirección: </td>
            <td width="15%" colspan="2" class="b-blue">{{ @$format->street }}, No. Ext. {{ @$format->n_ext }}, No. Int. {{ @$format->n_int }},  {{ @$format->colony }}, {{ @$format->municipality }}, {{ @$format->state }}, {{ @$format->country->name }}  </td>
            <td width="30%" colspan="3"></td>
        </tr>
        <tr>
            <td width="35%" class="right b">Cliente: </td>
            <td width="30%" colspan="2">{{ @$format->client }}</td>
            <td width="15%" colspan="3"></td>
        </tr>
        <tr>
            <td width="35%" class="right b">Contacto principal: </td>
            <td width="30%" class="b-blue" colspan="2">{{ @$format->main_contact }}</td>
            <td width="15%" colspan="3"></td>
        </tr>
        <tr>
            <td width="35%" class="right b">Puesto: </td>
            <td width="30%" colspan="2">{{ @$format->position }}</td>
            <td width="15%" colspan="3"></td>
        </tr>
        <tr>
            <td width="35%" class="right b">Teléfono: </td>
            <td width="30%" class="b-blue" colspan="2">{{ @$format->phone }}</td>
            <td width="15%" colspan="3"></td>
        </tr>
        <tr>
            <td width="35%" class="right b">Correo: </td>
            <td width="30%" colspan="2">{{ @$format->email }}</td>
            <td width="15%" colspan="3"></td>
        </tr>

        <tr>
            <td width="35%" class="right b">Tipo de Edificio: </td>
            <td width="65%" colspan="5">{{ @$format->structure }}</td>
        </tr>
        <tr>
            <td width="35%" class="right b">Entorno: </td>
            <td width="15%">{{ @$format->environment ? "Rural" : "Urbano" }}</td>
            <td width="50%" colspan="4"></td>
        </tr>
        <tr>
            <td width="35%" class="right b">Programa educativo o escuelas: </td>
            <td width="15%">{{ Helper::boolString($format->has_educational_programs) }}</td>
            <td width="15%" class="b-blue">Número de niños</td>
            <td width="15%">{{ @$format->children }}</td>
            <td width="12%" class="b-blue">Número de salones</td>
            <td width="8%">{{ @$format->classrooms }}</td>
        </tr>
        <tr>
            <td width="35%" class="right b">Ubicación geográfica del predio: </td>
            <td width="15%"><b>País:</b> {{ @$format->country->name }}</td>
            <td width="15%"><b>Estado:</b> {{ @$format->state }}</td>
            <td width="15%"><b>Municipio:</b> {{ @$format->municipality }}</td>
            <td width="12%"><b>Colonia:</b> {{ @$format->colony }}</td>
            <td width="8%"></td>
        </tr>
        <tr>
            <td width="35%" class="right b"></td>
            <td width="15%"><b>Calle:</b> {{ @$format->street }}</td>
            <td width="15%"><b>Número ext:</b> {{ @$format->n_ext }}</td>
            <td width="15%"><b>Número int:</b> {{ @$format->n_int }}</td>
            <td width="20%" colspan="2"></td>
        </tr>
        <tr>
            <td width="35%" class="right b">Hay escasez de agua</td>
            <td width="15%">{{ Helper::boolString($format->has_water_lack) }}</td>
            <td width="15%">Frecuencia</td>
            <td width="15%">{{ @$format->frequency }}</td>
            <td width="20%" colspan="2"></td>
        </tr>
        <tr>
            <td width="35%" class="right b">Como obtienen Agua</td>
            <td width="15%">{{ @$format->obtaining_water }}</td>
            <td width="50%" colspan="4"></td>
        </tr>
        <tr>
            <td width="35%" class="right b">Consumo de agua (Mensual)</td>
            <td width="15%">{{ @$format->water_consumption }}</td>
            <td width="15%" class="b-blue">litros</td>
            <td width="15%">{{ @$format->water_consumption * 0.001 }}</td>
            <td width="12%" class="b-blue">m3</td>
            <td width="8%"></td>
        </tr>
        <tr>
            <td width="35%" class="right b">Costo promedio actual agua/anual</td>
            <td width="15%">{{ @$format->cost_average }}</td>
            <td width="50%" class="b-blue" colspan="4">Pesos</td>
        </tr>
        <tr>
            <td width="35%" class="right b">Calidad del agua deseada</td>
            <td width="15%">{{ @$format->water_quality }}</td>
            <td width="50%" colspan="4"></td>
        </tr>
        <tr>
            <td width="35%" class="right b">Tipo de techo para captación de agua de lluvia</td>
            <td width="15%">{{ @$format->roof_type }}</td>
            <td width="50%" colspan="4"></td>
        </tr>
        <tr>
            <td width="35%" class="right b">Área de captación de agua de lluvia (estimada m2)</td>
            <td width="15%" class="b-blue">Techo</td>
            <td width="15%">{{ @$format->rainwater_area }}</td>
            <td width="15%" class="b-blue">m2</td>
            <td width="20%" colspan="2"></td>
        </tr>
        <tr>
            <td width="35%" class="right b">Volumen de almacenamiento (CISTERNA)</td>
            <td width="15%">{{ @$format->environment ? 30 * @$format->rainwater_area : 20 * @$format->rainwater_area }}</td>
            <td width="15%" class="b-blue">m3</td>
            <td width="35%" colspan="3"></td>
        </tr>

        <tr>
            <td width="35%" class="right b">El inmueble es propio o rentado</td>
            <td width="15%">{{ @$format->property_type ? "Rentado" : "Propio" }}</td>
            <td width="50%" colspan="4"></td>
        </tr>
        <tr>
            <td width="35%" class="right b">¿Cuentan con recursos para este año?</td>
            <td width="15%">{{ Helper::boolString($format->current_year_resources) }}</td>
            <td width="50%" colspan="4"></td>
        </tr>
        <tr>
            <td width="35%" class="right b">Recursos propios o de terceros: </td>
            <td width="15%">{{ @$format->resources_type ? "Terceros" : "Propio" }}</td>
            <td width="50%" colspan="4"></td>
        </tr>
        <tr>
            <td width="35%" class="right b">Personal involucrado en la planificación y validación: </td>
            <td width="65%" colspan="5"></td>
        </tr>
        @foreach($entities[0] as $e)
        <tr>
            <td width="35%"></td>
            <td width="15%" colspan="2"><b>Nombre:</b> {{ @$e->name }}</td>
            <td width="15%"><b>Puesto:</b> {{ @$e->position }}</td>
            <td width="15%"><b>Tel:</b> {{ @$e->telephone }}</td>
            <td width="20%"><b>Mail:</b> {{ @$e->email }}</td>
        </tr>
        @endforeach
        <tr>
            <td width="35%" class="right b">Personas involucradas en autorización del proyecto: </td>
            <td width="65%" colspan="5"></td>
        </tr>
        @foreach($entities[1] as $e)
        <tr>
            <td width="35%"></td>
            <td width="15%" colspan="2"><b>Nombre:</b> {{ @$e->name }}</td>
            <td width="15%"><b>Puesto:</b> {{ @$e->position }}</td>
            <td width="15%"><b>Tel:</b> {{ @$e->telephone }}</td>
            <td width="20%"><b>Mail:</b> {{ @$e->email }}</td>
        </tr>
        @endforeach
        <tr>
            <td width="35%">¿Fecha en la que quisiera realizar el proyecto?</td>
            <td width="15%">{{ @$format->date }}</td>
            <td width="35%" colspan="4"></td>
        </tr>
        <tr>
            <td width="100%" colspan="6" class="b-blue">¿Qué otras necesidades adicionales tiene o notas adicionales?</td>
        </tr>
        <tr>
            <td width="100%" colspan="6" style="border-bottom:none;" >{{ @$format->notes }}</td>
        </tr>
        <tr>
            <td width="100%" colspan="6" style="border-top: none;border-bottom:none;"></td>
        </tr>
        <tr>
            <td width="100%" colspan="6" style="border-top: none;border-bottom:none;"></td>
        </tr>
        <tr>
            <td width="100%" colspan="6" style="border-top: none;border-bottom:none;"></td>
        </tr>
        <tr  style="border-top: none;">
            <td width="60%" colspan="3"></td>
            <td width="20%">Firma:</td>
            <td width="20%" class="b-blue" style="height:100px;" colspan="2">{{ @$format->user->name }}</td>
        </tr>
    </tbody>
</table>
