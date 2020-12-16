<style>
    td {
        border: solid 1px;
    }
</style>

<div style="text-align: center;">
    <div>
        <div style="display: inline-block;    ">
            <img style="height:100px" src="material/img/licons/iu.png" alt="AGUA">
        </div>
        <div style="display: inline-block; position: relative; top: -38px; margin-left: -50px;">
            <h2>
                KIT ISLA URBANA
            </h2>
        </div>
    </div>

    <table style="width:100%;border-collapse: collapse;" class="table c-table">
        <thead>
            <tr style="background:#8db3e2" class="cc">
                <th>ID</th>
                <th>Material</th>
                <th>Piezas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kit as $k)
                <tr>
                    <td>{{ $k->id }}</td>
                    <td>{{ $k->accesory->name }}</td>
                    <td>{{ $k->qty }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
