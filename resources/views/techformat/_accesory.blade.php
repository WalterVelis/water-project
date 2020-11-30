<style>
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
<div class="row">
    <div class="col-8">
        <table class="table c-table">
            <thead>
                <tr class="cc">
                    <th>ID</th>
                    <th>Material</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($project_materials as $item)
                    <tr>
                        <td scope="row">{{ $item->id }}</td>
                        <td>{{ $item->accesory->name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td><i data-toggle="tooltip" data-placement="top" title="Eliminar" class="fa fa-trash" aria-hidden="true" onclick="removeAccesory({{ $item->id }})"></i></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <table class="table c-table">
            <thead>
                <tr class="cc">
                    <th>ID</th>
                    <th>Material</th>
                    <th>Piezas</th>
                    <th style="width:5%;">Costo Unitario</th>
                    <th>Costo (sin IVA)</th>
                    <th  style="width:5%;">Descuento</th>
                    <th>Costo con descuento</th>
                    <th>Total</th>
                    <th>Observaciones</th>
                    {{-- <th>Acciones</th> --}}
                </tr>
            </thead>
            <tbody>
                @php($total = 0)
                @foreach($project_materials as $item)
                    @php($total += (($item->cost - ($item->discount / 100) * $item->cost)) * $item->qty)
                    <tr>
                        <td scope="row">{{ $item->id }}</td>
                        <td>{{ $item->accesory->name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td><input type="number" data-id="{{ $item->id }}" class="accesory-cost form-control" value="{{ $item->cost }}"></td>
                        <td>{{ Helper::formatMoney($item->cost - ($item->cost * 0.16)) }}</td>
                        <td><input type="number"  data-id="{{ $item->id }}" class="accesory-discount form-control" value="{{ $item->discount }}"></td>
                        <td>{{ Helper::formatMoney(($item->cost - ($item->discount / 100) * $item->cost)) }}</td>
                        <td>{{ Helper::formatMoney((($item->cost - ($item->discount / 100) * $item->cost)) * $item->qty) }}</td>
                        <td><input type="text" data-id="{{ $item->id }}" class="accesory-details form-control" value="{{ $item->details }}"></td>
                        {{-- <td><i class="fa fa-trash" aria-hidden="true" onclick="removeAccesory({{ $item->id }})"></i></td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function removeAccesory(id) {
        $.ajax({
        type: 'DELETE',
        url: '/accesoryformat/'+id,
        data: {
            "_token": "{{ csrf_token() }}"
        }
    }).done(function(data) {
        loadAccesory();
    });
    }

    var delayer;
    var loading = false;
    $('.accesory-cost').on('change keyup', function() {
        id = $(this).attr('data-id');
        cost = $(this).val();
        console.log(id);
        clearTimeout(delayer);
        if(loading)
            return;
        delayer = setTimeout(function() {
            $.ajax({
                type: 'PUT',
                url: '/accesoryformat/cost/'+id+'/'+projectId,
                beforeSend: function( xhr ) {
                    loading = true;
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                    "cost": cost
                }
            })
            .done(function(data) {
                loadAccesory();
                loading = false;
            });
        }, 500);
    });

    $('.accesory-discount').on('change keyup', function() {
        id = $(this).attr('data-id');
        discount = $(this).val();
        console.log(id);
        clearTimeout(delayer);
        if(loading)
            return;
        delayer = setTimeout(function() {
            $.ajax({
                type: 'PUT',
                url: '/accesoryformat/discount/'+id+'/'+projectId,
                beforeSend: function( xhr ) {
                    loading = true;
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                    "discount": discount
                }
            })
            .done(function(data) {
                loadAccesory();
                loading = false;
            });
        }, 500);
    });

    $('.accesory-details').on('change keyup', function() {
        id = $(this).attr('data-id');
        details = $(this).val();
        console.log(id);
        clearTimeout(delayer);
        if(loading)
            return;
        delayer = setTimeout(function() {
            $.ajax({
                type: 'PUT',
                url: '/accesoryformat/details/'+id+'/'+projectId,
                beforeSend: function( xhr ) {
                    loading = true;
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                    "details": details
                }
            })
            .done(function(data) {
                loadAccesory();
                loading = false;
            });
        }, 500);
    });

    $(function () {
        $('#total-accesory').html("{{ Helper::formatMoney($total) }}");
    });
</script>
