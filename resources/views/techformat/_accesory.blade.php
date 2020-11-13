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
                        <td><i class="fa fa-trash" aria-hidden="true" onclick="removeAccesory({{ $item->id }})"></i></td>
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
</script>
