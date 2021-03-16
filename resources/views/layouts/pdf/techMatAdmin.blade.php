<style>

    .whide {
        display: none;
    }
    .table thead tr.cc th {
        font-size: 0.9rem;
        background: #2195f357;
        color: black;
        padding: 12px 10px;
        font-weight: bold;
    }
    td {
        border: solid 1px;
        width:20%;
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
@php($iffed = true)
@php($total = 0)
{{-- @if (App\User::hasPermissions("Tech") || App\User::hasPermissions("Vendor")) --}}
<div class="row">
    <div class="row" style="min-width: max-content;">
        <div class="col-12">
            {{-- <div class="row t-head d-flex justify-content-around" style="background: #bacfda;">
                <div style="padding: 4px 8px;width: 16.6%">ID</div>
                <div style="padding: 4px 8px;width: 16.6%">Material</div>
                <div style="padding: 4px 8px;width: 16.6%">Unidad</div>
                <div style="padding: 4px 8px;width: 16.6%">Cantidad</div>
                <div style="padding: 4px 8px;width: 16.6%">Tipo de material</div>
                <div style="padding: 4px 8px;width: 16.6%">Total</div>
            </div> --}}
            @php($total = 0)
            @foreach($project_materials as $item)
            {{-- @foreach($materialProvider[$item->id] as $mp) --}}
            {{-- @dd($project_materials) --}}
            {{-- @endforeach --}}

            @php($currentId = $item->id)

                {{-- <div class="" style="margin-bottom:20px;display: inline-block;background: #fafafa; padding-top: 10px; padding-bottom: 10px;">
                    <div style="display: inline-block; margin-right:16px;"><b>Material:</b> {{ @$item->materials->name }}</div>
                    <div style="display: inline-block; margin-right:16px;"><b>Unidad:</b> {{ @$item->materials->unitLabel() }}</div>
                    <div style="display: inline-block; margin-right:16px;"><b>Tipo:</b> {{ @$item->materials->type }}</div>
                </div> --}}


                <div id="t-{{ $item->id }}" style="margin-top:0px;" class="mt-2 mb-4">

                    <table class="table c-table" style="margin-top:0px;">
                        @if($iffed == true)
                        <thead >
                            <tr class="cc c-2">
                                <th style="width: 12.5%">Material</th>
                                <th style="width: 12.5%">Unidad</th>
                                <th style="width: 12.5%">Cantidad</th>
                                <th style="width: 12.5%">Tipo material</th>
                                <th style="width: 12.5%">Proveedor</th>
                                {{-- <th style="width: 12.5%">Existencia</th> --}}
                                <th style="width: 12.5%">Precio unitario</th>
                                <th style="width: 12.5%">Total</th>
                            </tr>
                        </thead>
                        @else
                        <thead style="height:1px!important;background:white!important;border-top:none;border-bottom:none;">
                            <tr  class="cc c-2">
                                <th style="width: 12.5%;background: white;height:0px;line-height:0px;padding:0px;"></th>
                                {{-- <th style="width: 12.5%;background: white;height:0px;line-height:0px;padding:0px;"></th> --}}
                                <th style="width: 12.5%;background: white;height:0px;line-height:0px;padding:0px;"></th>
                                <th style="width: 12.5%;background: white;height:0px;line-height:0px;padding:0px;"></th>
                                <th style="width: 12.5%;background: white;height:0px;line-height:0px;padding:0px;"></th>
                                <th style="width: 12.5%;background: white;height:0px;line-height:0px;padding:0px;"></th>
                                <th style="width: 12.5%;background: white;height:0px;line-height:0px;padding:0px;"></th>
                                <th style="width: 12.5%;background: white;height:0px;line-height:0px;padding:0px;"></th>
                            </tr>
                        </thead>
                        @endif
                        @php($iffed = false)
                        <tbody>

                            @php($subtotal = 0)
                            @foreach($materialProvider[$item->material_id] as $mp)
                            @if($mp->qty <= 0)
                                @continue
                            @endif

                            @if($mp->materialProvider)
                                @php($nq = $mp->materialProvider->qty)
                            @endif

                                <tr>
                                    <td scope="row">{{ @$item->materials->name }}</td>
                                    <td>{{ @$item->materials->unitLabel() }}</td>
                                    <td>
                                        @if($mp->materialProvider)
                                            {{ $mp->materialProvider->qty }}
                                            @php($tqty = $mp->materialProvider->qty)
                                        @else
                                            N/A
                                            @php($tqty = 0)
                                        @endif
                                    </td>
                                    <td>{{ @$item->materials->type }}</td>
                                    <td>{{ $mp->provider->denomination }}</td>
                                    {{-- @if($mp->materialProvider) --}}
                                    {{-- @php($uc = $mp->materialProvider->unit_cost) --}}
                                    {{-- @else --}}
                                    @php($uc = $mp->unit_cost)
                                    {{-- @endif --}}
                                    <td style="text-align:right;">{{ Helper::formatMoney($uc) }}</td>

                                    @php($subtotal += $tqty  * $mp->unit_cost)

                                    @php($total += $tqty  * $mp->unit_cost)
                                    <td style="text-align:right;">{{ Helper::formatMoney($tqty * $mp->unit_cost) }}</td>
                                </tr>

                            @endforeach
                                {{-- @dump($subtotal) --}}
                            <script>

                                $('#total-{{ $item->id }}').html("{{ Helper::formatMoney($subtotal) }}");

                                $('.total-item-{{ $currentId }}').on('change keyup', () => {
                                    total = parseFloat(0.00);
                                    $('.total-item-{{ $currentId }}').each(function() {
                                        total += parseFloat($(this).val());
                                        if(total > {{ $item->qty }}) {
                                            // console.log('Error');
                                            $('.total-item-{{ $currentId }}').addClass('max-error')
                                        } else {
                                            $('.total-item-{{ $currentId }}').removeClass('max-error')
                                        }
                                    })

                                })
                            </script>
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </div>
</div>
{{-- @endif --}}

</div>
