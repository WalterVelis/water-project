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
                    <tr>
                        <td scope="row">{{ $item->id }}</td>
                        <td>{{ $item->materials->name }}</td>
                        <td>{{ $item->materials->unit }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->materials->type }}</td>
                        <td><i class="fa fa-trash" aria-hidden="true" onclick="removeMaterial({{ $item->id }})"></i></td>
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
            <div class="row mt-3 d-flex justify-content-around" style="border-bottom: solid 2px #efefef; padding-bottom: 4px;">
                <div style="cursor: pointer;" onclick="showTable({{ $item->id }})">{{ $item->id }} <div class="d-inline-block" style="transform: translateY(8px);"><i class="material-icons">arrow_drop_down</i></div></div>
                <div>{{ $item->materials->name }}</div>
                <div>{{ $item->materials->unit }}</div>
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
                            <th>Cantidad</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($item->materials->providers as $mProvider)
                            <tr>
                                <td scope="row">{{ $mProvider->provider->contact_name }}</td>
                                <td>{{ $mProvider->qty }}</td>
                                <td>${{ $mProvider->unit_cost }}</td>
                                <td><input type="number" class="form-control" value="{{ $mProvider->qty }}"></td>
                                <td>${{ $mProvider->qty * $mProvider->unit_cost }}</td>
                            </tr>
                        @endforeach
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
</script>
