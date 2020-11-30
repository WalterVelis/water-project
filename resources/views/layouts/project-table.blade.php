@if ( !$entities )
    <span>{{ __('No records found...') }}</span>
    @php
        return;
    @endphp
@endif
<table class="table format-table">
    <thead>
        <th scope="col">{{ __('Name') }}</th>
        <th scope="col">{{ __('Email') }}</th>
        <th scope="col">{{ __('Telephone') }}</th>
        <th scope="col">{{ __('Job Position') }}</th>
        <th scope="col">{{ __('Actions') }}</th>
    </thead>
    <tbody>
        @foreach ($entities as $item)
            <tr>
                <td> {{ $item->name }} </td>
                <td> {{ $item->email }} </td>
                <td> {{ $item->telephone }} </td>
                <td> {{ $item->position }} </td>
                <td> <i data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="removePerson({{ $item->id }})" class="fa fa-trash" aria-hidden="true"></i> </td>
            </tr>
        @endforeach
    </tbody>
</table>

<style>

    .format-table td{
        font-size: 1em!important;
    }

    .format-table th{
        font-size: 1.1em!important;
    }

    .format-table thead th {
        font-weight: bold!important;
    }
    .format-table th, .format-table td {
        padding: 12px 8px!important;
    }
</style>
