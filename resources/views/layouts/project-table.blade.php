@if ( !$entities )
    <span>{{ __('No records found...') }}</span>
    @php
        return;
    @endphp
@endif
<table class="table format-table">
    <thead>
        <th style="font-size: 0.9em!important;" scope="col">{{ __('Name') }}</th>
        <th style="font-size: 0.9em!important;" scope="col">{{ __('Email') }}</th>
        <th style="font-size: 0.9em!important;" scope="col">{{ __('Telephone') }}</th>
        <th style="font-size: 0.9em!important;" scope="col">{{ __('Job Position') }}</th>
        @if (!App\User::hasPermissions("Tech"))<th style="font-size: 0.9em!important;" scope="col">{{ __('Actions') }}</th>@endif
    </thead>
    <tbody>
        @foreach ($entities as $item)
            <tr>
                <td> {{ $item->name }} </td>
                <td> {{ $item->email }} </td>
                <td> {{ $item->telephone }} </td>
                <td> {{ $item->position }} </td>
                @if (!App\User::hasPermissions("Tech"))<td> <i data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="removePerson({{ $item->id }})" class="fa fa-trash" aria-hidden="true"></i> </td>@endif
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
