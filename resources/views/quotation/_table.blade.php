<style>
    .f-icon {
        opacity: 0;
    }
    .has-icon:hover .f-icon{
        color: #9e9e9e;
        opacity: 1;
    }

    .q-details {
        background:#eeeeee;
    }

    .currency span {
        float:left;
    }
</style>
@php($id = 0)
@php($subTotal = 0.00)
<table class="table c-table">
    <thead>
        <tr class="cc">
            <th>ID</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Costo unitario</th>
            <th>Utilidad</th>
            <th>Indirectos</th>
            <th style="    width: 14.4%;">Total</th>
            <th class="d-none"></th>
        </tr>
    </thead>
    <tbody id="q-response">
        <tr>
            <td>{{ $id + 1 }} @php($id += 1)</td>
            <td>Mano de obra y operaciones</td>
            <td>1</td>
            <td style="text-align: right" class="currency"><span>$</span>{{ Helper::formatMoney($totalManoDeObra, false) }}</td>
            <td class="utilidad"><input style="width:80%; height: 20px;" type="number" class="obra-utilidad form-control d-inline-flex" value="{{ $costsUtility->utility }}"><span style=" padding-top: 10px; " class="d-inline-flex">%</span></td>
            <td class="indirect"><input style="width:80%; height: 20px;" type="number" class="obra-indirecto form-control d-inline-flex" value="{{ $costsUtility->indirect }}"><span style=" padding-top: 10px; " class="d-inline-flex">%</span></td>
            <td style="text-align: right" class="currency"><span>$</span>{{ Helper::formatMoney(( ($totalManoDeObra / (((100 - $costsUtility->utility) / 100))) + (($totalManoDeObra / (((100 - $costsUtility->utility) / 100))) * ((($costsUtility->indirect) / 100)))), false) }}</td>
            @php($subTotal += ( ($totalManoDeObra / (((100 - $costsUtility->utility) / 100))) + (($totalManoDeObra / (((100 - $costsUtility->utility) / 100))) * ((($costsUtility->indirect) / 100)))))
            {{-- <td>{{ Helper::formatMoney($totalManoDeObra) }}</td> --}}
        </tr>
        <tr class="q-details" style="display: none;">
            <td></td>
            <td>
                @foreach($manoDeObra as $mo)
                <div class="row">
                    <div style="text-align: right;" class="col-6">{{ $mo->costs->name }}</div>
                    <div style="text-align: right;" class="col-6">{{ Helper::formatMoney($mo->day * $mo->cost, false) }}</div>
                </div>
                @endforeach
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @if($escuela->has_educational_programs)
        <tr>
            <td>{{ $id + 1 }} @php($id += 1)</td>
            <td>Programa completo de escuelas de lluvia - Capacitación, supervisión y seguimiento técnica y propuesta participativa y educativa completa</td>
            <td>{{ $escuela->children }}</td>
            <td><span style=" padding-top: 10px; " class="d-inline-flex">$</span><input id="n-cost" style="width:80%; height: 20px;" type="number" class="form-control d-inline-flex" value="{{ $schoolCost->cost }}"></td>
            <td class="utilidad"><input style="width:80%; height: 20px;" type="number" class="school-utilidad form-control d-inline-flex" value="{{ $schoolCost->utility }}"><span style=" padding-top: 10px; " class="d-inline-flex">%</span></td>
            <td class="indirect"><input style="width:80%; height: 20px;" type="number" class="school-indirecto form-control d-inline-flex" value="{{ $schoolCost->indirect }}"><span style=" padding-top: 10px; " class="d-inline-flex">%</span></td>
            <td style="text-align: right;" class="currency"><span>$</span>{{ Helper::formatMoney($escuela->children * ( ($schoolCost->cost / (((100 - $schoolCost->utility) / 100))) + (($schoolCost->cost / (((100 - $schoolCost->utility) / 100))) * ((($schoolCost->indirect) / 100)))), false) }}</td>
            @php($subTotal += $escuela->children * ( ($schoolCost->cost / (((100 - $schoolCost->utility) / 100))) + (($schoolCost->cost / (((100 - $schoolCost->utility) / 100))) * ((($schoolCost->indirect) / 100)))))
        </tr>
        @endif
        <tr>
            <td>{{ $id + 1 }} @php($id += 1)</td>
            <td>Materiales y Equipo de instalación </td>
            <td>1</td>
            <td style="text-align: right" class="currency"><span>$</span>{{ Helper::formatMoney($allMaterials, false) }}</td>
            <td class="utilidad"><input style="width:80%; height: 20px;" type="number" class="material-utilidad form-control d-inline-flex" value="{{ $materialUtility->utility }}"><span style=" padding-top: 10px; " class="d-inline-flex">%</span></td>
            <td class="indirect"><input style="width:80%; height: 20px;" type="number" class="material-indirecto form-control d-inline-flex" value="{{ $materialUtility->indirect }}"><span style=" padding-top: 10px; " class="d-inline-flex">%</span></td>
            <td style="text-align: right" class="currency"><span>$</span>{{ Helper::formatMoney(( ($allMaterials / (((100 - $materialUtility->utility) / 100))) + (($allMaterials / (((100 - $materialUtility->utility) / 100))) * ((($materialUtility->indirect) / 100)))), false) }}</td>
            @php($subTotal += ( ($allMaterials / (((100 - $materialUtility->utility) / 100))) + (($allMaterials / (((100 - $materialUtility->utility) / 100))) * ((($materialUtility->indirect) / 100)))))
        </tr>
        <tr class="q-details" style="display: none;">
            <td></td>
            <td>
                <div class="row">
                    <div style="text-align: right;" class="col-6">Materiales Extra</div>
                    <div style="text-align: right;" class="col-6"class="currency"><span>$</span>{{ Helper::formatMoney($totalMaterial, false) }}</div>
                    <div style="text-align: right;" class="col-6">Accesorios IU</div>
                    <div style="text-align: right;" class="col-6"class="currency"><span>$</span>{{ Helper::formatMoney($totalIU, false) }}</div>
                </div>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        {{-- @dd($quotation) --}}
        @foreach ($quotation as $q)
        <tr class="has-icon">
            <td>{{ $id + 1 }} @php($id += 1)</td>
            <td>{{ $q->description }}</td>
            <td>{{ $q->qty }}</td>
            <td style="text-align: right;" class="currency"><span>$</span>{{ Helper::formatMoney($q->cost, false) }}</td>
            <td class="utilidad"><input data-id="{{ $q->id }}" style="width:80%; height: 20px;" type="number" class="quotation-utilidad form-control d-inline-flex" value="{{ $q->utility }}"><span style=" padding-top: 10px; " class="d-inline-flex">%</span></td>
            <td class="indirectos"><input data-id="{{ $q->id }}" style="width:80%; height: 20px;" type="number" class="quotation-indirecto form-control d-inline-flex" value="{{ $q->indirect }}"><span style=" padding-top: 10px; " class="d-inline-flex">%</span></td>
            <td style="text-align: right;" class="currency"><span>$</span>{{ Helper::formatMoney($q->qty * ( ($q->cost / (((100 - $q->utility) / 100))) + (($q->cost / (((100 - $q->utility) / 100))) * ((($q->indirect) / 100)))), false) }}</td>
            @php($subTotal += $q->qty * ( ($q->cost / (((100 - $q->utility) / 100))) + (($q->cost / (((100 - $q->utility) / 100))) * ((($q->indirect) / 100)))))
            <td>
                <a href="#" onclick="removeQuote({{ $q->id }});">
                    <i class="f-icon fa fa-times"></i>
                </a>
            </td>
        </tr>
        @endforeach
        <tr>
            <td style="text-align: right" colspan="7"><div class="row"><div style="font-weight: bold" class="col-10">Subtotal:</div> <div class="col-2 currency"><span>$</span>{{ Helper::formatMoney($subTotal, false) }} </div></div></td>
        </tr>
        <tr>
            <td style="text-align: right" colspan="7"><div class="row"><div style="font-weight: bold" class="col-10">IVA:</div> <div class="col-2 currency"><span>$</span>{{ Helper::formatMoney($subTotal * 0.16, false) }}</div></div></td>
        </tr>
        <tr>
            <td style="text-align: right" colspan="7"><div class="row"><div style="font-weight: bold" class="col-10">Total:</div> <div class="col-2 currency"><span>$</span>{{ Helper::formatMoney($subTotal * 1.16, false) }}</div></div></td>
        </tr>
    </tbody>
</table>

<script>
    var delayer2;
    var loading = false

$('.obra-utilidad').on('change keyup', function() {
    clearTimeout(delayer2);
    id = $(this).attr('data-id');
    utility = $(this).val();
    delayer2 = setTimeout(function() {
            $.ajax({
                type: 'PATCH',
                url: '/applyindividualutility',
                beforeSend: function( xhr ) {
                    loading = true;
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                    "type": 0,
                    "utility": utility,
                    "u_id": id,
                    "format_id": $('#format_id').val(),
                }
            })
            .always(function(data) {
                loading = false;
            })
            .done(function() {
                loadTable();
            });

        }, 1000);
});
$('.obra-indirecto').on('change keyup', function() {
    clearTimeout(delayer2);
    id = $(this).attr('data-id');
    indirect = $(this).val();
    delayer2 = setTimeout(function() {
            $.ajax({
                type: 'PATCH',
                url: '/applyindividualutility',
                beforeSend: function( xhr ) {
                    loading = true;
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                    "indirect": indirect,
                    "u_id": id,
                    "format_id": $('#format_id').val(),
                }
            })
            .always(function(data) {
                loading = false;
            })
            .done(function() {
                loadTable();
            });

        }, 1000);
});
$('.school-utilidad').on('change keyup', function() {
    clearTimeout(delayer2);
    id = $(this).attr('data-id');
    utility = $(this).val();
    delayer2 = setTimeout(function() {
            $.ajax({
                type: 'PATCH',
                url: '/applyindividualschoolutility',
                beforeSend: function( xhr ) {
                    loading = true;
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                    "type": 0,
                    "utility": utility,
                    "u_id": id,
                    "format_id": $('#format_id').val(),
                }
            })
            .always(function(data) {
                loading = false;
            })
            .done(function() {
                loadTable();
            });
        }, 1000);
});
$('.school-indirecto').on('change keyup', function() {
    clearTimeout(delayer2);
    id = $(this).attr('data-id');
    indirect = $(this).val();
    delayer2 = setTimeout(function() {
            $.ajax({
                type: 'PATCH',
                url: '/applyindividualschoolutility',
                beforeSend: function( xhr ) {
                    loading = true;
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                    "indirect": indirect,
                    "u_id": id,
                    "format_id": $('#format_id').val(),
                }
            })
            .done(function() {
                loadTable();
            })
            .always(function(data) {
                loading = false;
            });
        }, 1000);
});
$('.material-utilidad').on('change keyup', function() {
    clearTimeout(delayer2);
    id = $(this).attr('data-id');
    utility = $(this).val();
    delayer2 = setTimeout(function() {
            $.ajax({
                type: 'PATCH',
                url: '/applyindividualmaterialutility',
                beforeSend: function( xhr ) {
                    loading = true;
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                    "type": 0,
                    "utility": utility,
                    "u_id": id,
                    "format_id": $('#format_id').val(),
                }
            })
            .done(function() {
                loadTable();
            })
            .always(function(data) {
                loading = false;
            });
        }, 1000);
});
$('.quotation-indirecto').on('change keyup', function() {
    clearTimeout(delayer2);
    id = $(this).attr('data-id');
    indirect = $(this).val();
    delayer2 = setTimeout(function() {
            $.ajax({
                type: 'PATCH',
                url: '/applyindividualquotationutility',
                beforeSend: function( xhr ) {
                    loading = true;
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                    "indirect": indirect,
                    "u_id": id,
                    "format_id": $('#format_id').val(),
                }
            })
            .done(function() {
                loadTable();
            })
            .always(function(data) {
                loading = false;
            });
        }, 1000);
});
$('.quotation-utilidad').on('change keyup', function() {
    clearTimeout(delayer2);
    id = $(this).attr('data-id');
    utility = $(this).val();
    delayer2 = setTimeout(function() {
            $.ajax({
                type: 'PATCH',
                url: '/applyindividualquotationutility',
                beforeSend: function( xhr ) {
                    loading = true;
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                    "type": 0,
                    "utility": utility,
                    "u_id": id,
                    "format_id": $('#format_id').val(),
                }
            })
            .done(function() {
                loadTable();
            })
            .always(function(data) {
                loading = false;
            });
        }, 1000);
});
$('.material-indirecto').on('change keyup', function() {
    clearTimeout(delayer2);
    id = $(this).attr('data-id');
    indirect = $(this).val();
    delayer2 = setTimeout(function() {
            $.ajax({
                type: 'PATCH',
                url: '/applyindividualmaterialutility',
                beforeSend: function( xhr ) {
                    loading = true;
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                    "indirect": indirect,
                    "u_id": id,
                    "format_id": $('#format_id').val(),
                }
            })
            .done(function() {
                loadTable();
            })
            .always(function(data) {
                loading = false;
            });
        }, 1000);
});

function applyIndividualUtility(id) {

    $.ajax({
        type: "PATCH",
        url: "/applyutility/",
        data: {
            "utility": 20,
            "indirect": 20,
        },
        complete: function (response) {
            console.log(response.responseText);
        }
    });
}

    var delayer;
    $('#n-cost').on('change keyup', function() {
        clearTimeout(delayer);
        if(loading)
            return;
        delayer = setTimeout(function() {
            $.ajax({
                type: 'PUT',
                url: '/quotationschool',
                beforeSend: function( xhr ) {
                    loading = true;
                },
                data: {
                    "_token": "{{ csrf_token() }}",
                    "cost": $('#n-cost').val(),
                    "format_id": $('#format_id').val(),
                }
            })
            .done(function() {
                loadTable();
            })
            .always(function(data) {
                loading = false;
            });
        }, 1000);
    });

    function removeQuote(id) {
        $.ajax({
                type: 'DELETE',
                url: '/quotation/'+id,
                data: {
                    "_token": "{{ csrf_token() }}",
                }
            })
            .done(function() {
                loadTable();
            });
        }
</script>
