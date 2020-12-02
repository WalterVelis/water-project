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
</style>
<table style="width:100%;">
    <tr>
        <td style="width:20%;"><img style="height:100px" src="material/img/licons/pas-bf-white.png" alt="AGUA"></td>
        <td><h3 class="st" style="text-align:center; font-size:1.3em;">DIAGNÓSTICO DE NECESIDADES</h3></td>
        <td style="width:20%; text-align:right;"><img style="height:100px" src="material/img/licons/pas-bf-white.png" alt="AGUA"></td>
    </tr>
</table>

<table style="width:100%;">
    <tbody>
        <tr>
            <td width="35%" class="right b">Fecha: </td>
            <td width="15%">{{ $format->date }}</td>
            <td width="30%" colspan="2"></td>
            <td width="12%">Folio</td>
            <td width="8%">{{ $format->page }}</td>
        </tr>
        <tr>
            <td width="35%" class="right b">Dirección: </td>
            <td width="15%">{{ $format->street }}, No. Ext. {{ $format->n_ext }}, No. Int. {{ $format->n_int }},  {{ $format->colony }}, {{ $format->municipality }}, {{ $format->state }}, {{ $format->country_id }}  </td>
            <td width="30%" colspan="2"></td>
            <td width="12%">Folio</td>
            <td width="8%">{{ $format->page }}</td>
        </tr>
        <tr>
            <td width="35%" class="right b">Cliente: </td>
            <td width="30%" colspan="2">{{ $format->client }}</td>
            <td width="15%" colspan="3"></td>
        </tr>
        <tr>
            <td width="35%" class="right b">Contacto principal: </td>
            <td width="30%" colspan="2">{{ $format->main_contact }}</td>
            <td width="15%" colspan="3"></td>
        </tr>
        <tr>
            <td width="35%" class="right b">Puesto: </td>
            <td width="30%" colspan="2">{{ $format->position }}</td>
            <td width="15%" colspan="3"></td>
        </tr>
        <tr>
            <td width="35%" class="right b">Teléfono: </td>
            <td width="30%" colspan="2">{{ $format->phone }}</td>
            <td width="15%" colspan="3"></td>
        </tr>
        <tr>
            <td width="35%" class="right b">Correo: </td>
            <td width="30%" colspan="2">{{ $format->email }}</td>
            <td width="15%" colspan="3"></td>
        </tr>
    </tbody>
</table>
