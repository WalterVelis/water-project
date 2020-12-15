{{-- @dd($pj) --}}
<style>
    .table thead tr.c-2 th {
        font-size: 0.9rem;
        background: #efefef!important;
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
                    <th>Acciones</th>
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
                        <td><i data-toggle="tooltip" data-placement="top" title="Eliminar" class="fa fa-trash" aria-hidden="true" onclick="removeMaterial({{ $item->id }})"></i></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="row t-head d-flex justify-content-around" style="background: #bacfda;">
            <span>ID</span>
            <span>Material</span>
            <span>Unidad</span>
            <span>Cantidad</span>
            <span>Tipo de material</span>
        </div>
        @foreach($project_materials as $item)
        {{-- @foreach($materialProvider[$item->id] as $mp) --}}
        {{-- @dd($project_materials) --}}
        {{-- @endforeach --}}
        @php($currentId = $item->id)
        @foreach($item->materials->providers as $mProvider)
        {{-- @dump($mProvider->materialProvider) --}}
        @endforeach
            <div class="row mt-3 d-flex justify-content-around" style="    background: #fafafa; padding-top: 10px; padding-bottom: 10px;">
                <div style="cursor: pointer;    margin-top: -8px;" onclick="showTable({{ $item->id }})">{{ $item->id }} <div class="d-inline-block" style="transform: translateY(8px);"><i class="material-icons">arrow_drop_down</i></div></div>
                <div>{{ $item->materials->name }}</div>
                <div>{{ $item->materials->unitLabel() }}</div>
                <div>{{ $item->qty }}</div>
                <div>{{ $item->materials->type }}</div>
            </div>
            <div id="t-{{ $item->id }}" style="display: none" class="mt-2 mb-4">

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
                        @php($total = 0)

                        @foreach($materialProvider[$item->material_id] as $mp)
                        @if($mp->qty <= 0)
                            @continue
                        @endif
                            @php($total += $mp->qty * $mp->unit_cost)
                            <tr>
                                <td scope="row">{{ $mp->provider->contact_name }}</td>
                                <td>{{ $mp->qty }}</td>
                                <td>{{ Helper::formatMoney($mp->unit_cost) }}</td>
                                <td>
                                    @if($mp->materialProvider)
                                        <input max="{{ $mp->qty }}" class="total-item-{{ $currentId }} form-control data-material" data-id="{{ $mp->id }}" type="number" value="{{ $mp->materialProvider->qty }}">
                                    @else
                                        <input max="{{ $mp->qty }}" class="total-item-{{ $currentId }} form-control data-material" data-id="{{ $mp->id }}" type="number" value="0">
                                    @endif
                                </td>
                                <td>{{ Helper::formatMoney($mp->qty * $mp->unit_cost) }}</td>
                            </tr>
                        @endforeach
                        <script>
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
    <div class="col-12">
        <button class="float-right d-block btn btn-primary">Guardar</button>
    </div>
</div>
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
    $('.data-material').on('change keyup', function() {
        mpId = $(this).attr('data-id');
        data = $(this).val();
        clearTimeout(delayer);
        delayer = setTimeout(function() {
            $.ajax({
                type: 'PUT',
                url: '/materialformat/'+mpId+'/'+projectId,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "qty": data
                }
            }).done(function(data) {
                loadCosts();
            });
        }, 500);

    });
    $(function () {
        $('#total-material').html("{{ Helper::formatMoney($total) }}");
    });
</script>
