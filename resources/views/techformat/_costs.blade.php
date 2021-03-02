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
@php($total = 0)
@if (App\User::hasPermissions("Tech") || App\User::hasPermissions("Vendor"))
<div class="row">
    <div class="col-8">
        <table class="table c-table">
            <thead>
                <tr class="cc">
                    <th>Días</th>
                    <th>Especialidad</th>
                    <th>Precio unitario</th>
                    <th>Total</th>
                    @if (!App\User::hasPermissions("Vendor"))<th>Acciones</th>@endif
                </tr>
            </thead>
            <tbody>
                @foreach($project_costs as $pc)
                    <tr>
                        <td scope="row">{{ $pc->day }}</td>
                        <td>{{ $pc->costs->name }}</td>
                        <td>{{ Helper::formatMoney($pc->cost) }}</td>
                        <td>{{ Helper::formatMoney($pc->cost * $pc->day) }}</td>
                        @php($total += ($pc->cost * $pc->day))
                        @if (!App\User::hasPermissions("Vendor"))<td><i data-toggle="tooltip" data-placement="top" title="Eliminar" class="fa fa-trash" aria-hidden="true" onclick="removeCost({{ $pc->id }})"></i></td>@endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@if (App\User::hasPermissions("Admin"))
@php($total = 0)
<div class="row">
    <div class="col-8">
        <table class="table c-table">
            <thead>
                <tr class="cc">
                    <th>Días</th>
                    <th>Especialidad</th>
                    <th style="    width: 90px;">Precio unitario</th>
                    <th>Total</th>
                    {{-- <th>Acciones</th> --}}
                </tr>
            </thead>
            <tbody>

                @foreach($project_costs as $pc)
                    @php($total += ($pc->cost * $pc->day))
                    <tr>
                        <td scope="row">{{ $pc->day }}</td>
                        <td>{{ $pc->costs->name }}</td>
                        <td><input class="form-control unit_cost" style="width: 70px;" data-id="{{ $pc->id }}" type="number" name="unit_cost" value="{{{ $pc->cost }}}"></td>
                        <td>{{ Helper::formatMoney($pc->cost * $pc->day) }}</td>
                        {{-- <td><i class="fa fa-trash" aria-hidden="true" onclick="removeCost({{ $pc->id }})"></i></td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
<script>
    function removeCost(id) {
        $.ajax({
        type: 'DELETE',
        url: '/costformat/'+id,
        data: {
            "_token": "{{ csrf_token() }}"
        }
        }).done(function(data) {
            loadCosts();
        });
    }

    var delayer;
    var loading = false;
    $('.unit_cost').on('change keyup', function() {
        id = $(this).attr('data-id');
        cost = $(this).val();
        console.log(id);
        clearTimeout(delayer);
        if(loading)
            return;
        delayer = setTimeout(function() {
            $.ajax({
                type: 'PUT',
                url: '/costformat/'+id+'/'+projectId,
                beforeSend: function( xhr ) {
                    loading = true;
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                    "cost": cost
                }
            })
            .done(function(data) {
                loadCosts();
                loading = false;
            });
        }, 500);
    });

$(function () {
    $('#total-cost').html("{{ Helper::formatMoney($total) }}");
});
</script>
