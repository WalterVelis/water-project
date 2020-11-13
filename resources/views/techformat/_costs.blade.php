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
                    <th>Días</th>
                    <th>Especialidad</th>
                    <th>Costo Unitario</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($project_costs as $pc)
                    <tr>
                        <td scope="row">{{ $pc->day }}</td>
                        <td>{{ $pc->costs->name }}</td>
                        <td>${{ $pc->costs->unit_cost }}</td>
                        <td>${{ $pc->costs->unit_cost * $pc->day }}</td>
                        <td><i class="fa fa-trash" aria-hidden="true" onclick="removeCost({{ $pc->id }})"></i></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
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
</script>
