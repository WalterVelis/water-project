{{-- @dd($pj) --}}
<style>
    .table thead tr.c-2 th {
        font-size: 0.9rem;
        background: #fafafa!important;
        color: black;
        padding: 2px 4px!important;
        font-weight: bold;
    }

    .table thead tr.cc th {
        font-size: 0.9rem;
        background: #bacfda;
        color: black;
        padding: 12px 10px;
        font-weight: bold;
    }

    .c-table td, .c-table th{
        border: solid 1px lightgrey;
    }

    .c-table {
        text-align: center;
    }

    .max-error {
        border-bottom: solid 1px red;
        background: #fce4ec;
        transition: all ease 0.2s;
    }
</style>
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
                    @if (!App\User::hasPermissions("Vendor"))<th>Acciones</th>@endif
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
                        @if (!App\User::hasPermissions("Vendor"))<td><i data-toggle="tooltip" data-placement="top" title="Eliminar" class="fa fa-trash" aria-hidden="true" onclick="removeMaterial({{ $item->id }})"></i></td>@endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@if (App\User::hasPermissions("Admin"))
<div class="row">
    <div class="col-12">
        <div class="row t-head d-flex justify-content-around" style="background: #bacfda;">
            <div style="padding: 4px 8px;width: 16.6%">ID</div>
            <div style="padding: 4px 8px;width: 16.6%">Material</div>
            <div style="padding: 4px 8px;width: 16.6%">Unidad</div>
            <div style="padding: 4px 8px;width: 16.6%">Cantidad</div>
            <div style="padding: 4px 8px;width: 16.6%">Tipo de material</div>
            <div style="padding: 4px 8px;width: 16.6%">Total</div>
        </div>
        @php($total = 0)
        @foreach($project_materials as $item)
        {{-- @foreach($materialProvider[$item->id] as $mp) --}}
        {{-- @dd($project_materials) --}}
        {{-- @endforeach --}}

        @php($currentId = $item->id)

        @foreach($item->materials->providers as $mProvider)
        @endforeach







            <div class="row mt-3 d-flex justify-content-around" style="    background: #fafafa; padding-top: 10px; padding-bottom: 10px;">
                <div style="cursor: pointer;padding-left: 12px;width: 16.6%;margin-top: -8px;" onclick="showTable({{ $item->id }})">{{ $item->id }} <div class="d-inline-block" style="transform: translateY(8px);"><i class="material-icons">arrow_drop_down</i></div></div>
                <div style="padding: 4px 8px;width: 16.6%">{{ $item->materials->name }}</div>
                <div  style="padding: 4px 8px;width: 16.6%">{{ $item->materials->unitLabel() }}</div>
                <div  style="padding: 4px 8px;width: 16.6%">{{ $item->qty }}</div>
                <div  style="padding: 4px 8px;width: 16.6%">{{ $item->materials->type }}</div>
                <div  style="padding: 4px 8px;width: 16.6%" id="total-{{ $item->id }}">$0.00</div>
            </div>
            <div id="t-{{ $item->id }}" style="" class="mt-2 mb-4">

                <table class="table c-table">
                    <thead>
                        <tr class="cc c-2">
                            <th>Proveedor</th>
                            <th>Existencia</th>
                            <th>Costo Unitario</th>
                            <th style="width:8%;">Cantidad</th>
                            <th>Total</th>
                        </tr>
                    </thead>
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
                                <td scope="row">{{ $mp->provider->denomination }}</td>
                                <td>{{ $mp->qty }}</td>
                                {{-- @if($mp->materialProvider) --}}
                                {{-- @php($uc = $mp->materialProvider->unit_cost) --}}
                                {{-- @else --}}
                                @php($uc = $mp->unit_cost)
                                {{-- @endif --}}
                                <td style="text-align:right;">{{ Helper::formatMoney($uc) }}</td>
                                <td>
                                    @if($mp->materialProvider)
                                        <input oninput="validity.valid||(value='{{ $mp->qty }}');" min="0" max="{{ $mp->qty }}" class="total-item-{{ $currentId }} form-control data-material" data-id="{{ $mp->id }}" type="number" value="{{ $mp->materialProvider->qty }}">
                                        @php($tqty = $mp->materialProvider->qty)
                                    @else
                                        <input oninput="validity.valid||(value='{{ $mp->qty }}');" min="0" max="{{ $mp->qty }}" class="total-item-{{ $currentId }} form-control data-material" data-id="{{ $mp->id }}" type="number" value="0">
                                        @php($tqty = 0)
                                    @endif
                                </td>
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
@endif
<script>
    function showTable(id) {
        console.log($('#t-'+id).css('display') == 'block');
        if ($('#t-'+id).css('display') == 'block'){
            $('#t-'+id).hide();
            return;
        }
        $('#t-'+id).show();
    }
</script>
<style>
    .t-head {
        color: #32526f;
        font-size: 1.1em;
        font-weight: bold;
        padding: 6px;
    }
</style>

<script>
    function removeMaterial(id) {
        $.ajax({
        type: 'DELETE',
        url: '/materialformat/'+id,
        data: {
            "_token": "{{ csrf_token() }}"
        }
    }).done(function(data) {
        loadMaterials();
    });
    }

    var delayer;

    function updateTable() {

    }

    $('.data-material').blur( function() {
        console.log('blur');
        mpId = $(this).attr('data-id');
        data = $(this).val();
        clearTimeout(delayer);
        delayer = setTimeout(function() {
            $.ajax({
                type: 'PUT',
                url: '/materialformat/'+mpId+'/'+projectId,
                beforeSend: function() {
                    $('input').prop("readonly", true);
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                    "qty": data
                }
            })
            .done(function(data) {
                loadMaterials();
            }).complete(() => {
                $('input').prop("readonly", false);
            });
        }, 500);

    });
    $(function () {
        $('#total-material').html("{{ Helper::formatMoney($total) }}");
        @if (!App\User::hasPermissions("Admin"))
        $('#total-material').html("");
        @endif
    });
</script>
