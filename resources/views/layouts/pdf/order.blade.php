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
</style>
<table style="width:100%;">
    <tr>
        <td style="width:20%;"><img style="height:100px" src="material/img/licons/pas-bf-white.png" alt="AGUA"></td>
        <td><h3 class="st" style="text-align:center; font-size:1.3em;">Orden de compra</h3></td>
    </tr>
    <tr>
        <td colspan="2">
            <span class="st">Folio del proyecto:</span> <span>{{ $format->page }}</span>
            <div style="text-align:right; float:right;">
                <span class="st" >Orden de compra:</span> <span>{{ $oderId }} #</span>
            </div>
            <br>
            <span class="st">Vendedor:</span> <span>{{ $format->user->name }}</span>
            <br>
            <span class="st">Fecha de la orden:</span> <span>{{ Carbon::today()->format('d-m-Y') }}</span>

        </td>
    </tr>
</table>
<table style="width:100%; margin-top:30px;">
    <thead>
        <tr>
            <th style="width:50%;">Datos de comprador</th>
            <th style="width:50%;">Datos de proveedor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td scope="row"><span class="st">Razón social: </span><span>ASESORES EN GESTIÓN URBANA DEL AGUA SA DE CV</span></td>
            <td scope="row"><span class="st">Razón social: </span><span>{{ $providers[0]->providers->provider->denomination }}</span></td>

        </tr>
        <tr>
            <td scope="row"><span class="st">RFC: </span><span>AGU160215SLA</span></td>
            <td scope="row"><span class="st">RFC: </span><span>{{ $providers[0]->providers->provider->rfc }}</span></td>

        </tr>
        <tr>
            <td scope="row"><span class="st">Domicilio: </span><span>CAMINO REAL DE CARRETAS NO 299, 4° PISO INT 417 TORRE LUMA CAPITAL, MILENIO III, CP 76060, QUERETARO, QRO.</span></td>
            <td scope="row"><span class="st">Domicilio: </span><span>{{ $providers[0]->providers->provider->direccion }}</span></td>

        </tr>
        <tr>
            <td scope="row"><span class="st">Teléfono: </span><span>(52) 442-246-2869</span></td>
            <td scope="row"><span class="st">Teléfono: </span><span>{{ $providers[0]->providers->provider->phone }}</span></td>

        </tr>
        <tr>
            <td scope="row"><span class="st">Email: </span><span>aguah20@gmail.com</span></td>
            <td scope="row"><span class="st">Email: </span><span>{{ $providers[0]->providers->provider->email }}</span></td>

        </tr>
    </tbody>
</table>

<table style="width:100%; margin-top:30px; text-align:center;">
    <thead>
        <tr>
            <th style="width:10%;">Cant.</th>
            <th style="width:40%;">Descripción</th>
            <th style="width:12%;">Unidad</th>
            <th style="width:12%;">Tipo de material</th>
            <th style="width:12%;">Costo unitario</th>
            <th style="width:14%;">Total</th>
        </tr>
    </thead>
    <tbody>
        @php($subTotal = 0.00)
        @foreach($providers as $provider)
        @php($subTotal += $provider->qty * $provider->cost)
        {{-- @dd($provider->providers->material->typeLabel()) --}}
        <tr>
            <td scope="row">{{ $provider->qty }}</td>
            <td style=" text-align:left;">{{ $provider->providers->material->name }}</td>
            <td>{{ $provider->providers->material->unitLabel() }}</td>
            <td>{{ $provider->providers->material->typeLabel() }}</td>
            <td>{{ Helper::formatMoney($provider->cost) }}</td>
            <td>{{ Helper::formatMoney($provider->qty * $provider->cost) }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="4"></td>
            <td class="bg-b">Subtotal</td>
            <td>{{ Helper::formatMoney($subTotal) }}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td class="bg-b">IVA</td>
            <td>{{ Helper::formatMoney($subTotal * 0.13) }}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td class="bg-b">Total</td>
            <td>{{ Helper::formatMoney($subTotal * 1.13) }}</td>
        </tr>
    </tbody>
</table>

<div style="height:150px; width:100%;border:solid 2px #16506e;margin-top:30px;">
    <div style="background:#16506e; color:white; font-weight:bold;">Observaciones:</div>
</div>
