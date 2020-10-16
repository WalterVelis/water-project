function approveChange(vendor_account_id) {
    $('#row' + vendor_account_id).removeClass('af')
    $('#row' + vendor_account_id).addClass('naf')
    $('#row' + vendor_account_id).removeClass('ap0')
    $('#row' + vendor_account_id).addClass('ap1')
    $('#row' + vendor_account_id).removeAttr('style')
    $('#row' + vendor_account_id).css('background-color', 'rgb(207, 250, 216)')
    $('#row' + vendor_account_id).find('.text-right').find('button').remove()
    chosen()
}
function rejectChange(vendor_account_id) {
    $('#row' + vendor_account_id).removeClass('af')
    $('#row' + vendor_account_id).addClass('naf')
    $('#row' + vendor_account_id).removeClass('ap0')
    $('#row' + vendor_account_id).addClass('ap2')
    $('#row' + vendor_account_id).removeAttr('style')
    $('#row' + vendor_account_id).css('background-color', 'rgb(248, 215, 212)')
    $('#row' + vendor_account_id).find('.text-right').find('button').remove()
    chosen()
}
function saveChange(vendor_account_id, is_approved) {
    var routeRequest = mainRoute + "budget/saveChanges";
    $.ajax({
        type: 'post',
        url: routeRequest,
        headers: { 'X-CSRF-TOKEN': $('#tokenBudget').val() },
        data: {
            budget_vendor_account_id: vendor_account_id,
            is_approved: is_approved,
        },
        success: function (r) {
            if (r != 0) {
                if (is_approved == 1) {
                    approveChange(vendor_account_id)
                } else {
                    rejectChange(vendor_account_id)
                }
                // gab gabp
                $('#gab').text(formatNumber(r.approved.toFixed(2)))
                $('#gabp').text(formatNumber(r.pending.toFixed(2)))
                $('#ttCg').text(formatNumber(r.totalChanges.toFixed(2)))

            }
        }
    });
}
function refreshEventsC() {
    $('.backRow').click(function () {
        cleanSelects(0)
        if ($(this).parents('tr').hasClass('rowNotApproved') || $(this).parents('tr').hasClass('rowNotApprovedC')) {
            ptr = $(this).parents('tr')
            vendor = ptr.find('.editVendor').find('.cg').val().split('/')
            description = ptr.find('.dp').find('.cg').val().split('/')
            qu = ptr.find('.qu').find('.cg').val().split('/')
            unit = ptr.find('.un').find('.cg').val().split('/')
            qt = ptr.find('.qt').find('.cg').val().split('/')
            time = ptr.find('.editTime').find('.cg').val().split('/')
            cost = ptr.find('.editUnitCost').find('.cg').val().split('/')
            currency = ptr.find('.editCurrency').find('.cg').val().split('/')
            if (ptr.attr('cg') == '0') {
                $(this).attr('title', $('#display2').val())
                ptr.find('.editVendor').find('input:eq(0)').val(vendor[1])

                ptr.find('.dp').find('div:eq(0)').text(description[1])
                ptr.find('.dp').find('input:eq(0)').val(description[1])

                ptr.find('.qu').find('div:eq(0)').text(qu[1])
                ptr.find('.qu').find('input:eq(0)').val(qu[1])

                ptr.find('.un').find('div:eq(0)').text(unit[1])
                ptr.find('.un').find('input:eq(0)').val(unit[1])

                ptr.find('.qt').find('div:eq(0)').text(qt[1])
                ptr.find('.qt').find('input:eq(0)').val(qt[1])

                ptr.find('.editTime').find('input:eq(0)').val(time[1])

                ptr.find('.editUnitCost').find('input:eq(0)').val(cost[1])
                ptr.find('.editUnitCost').find('.hideCost').val(cost[1])

                ptr.find('.editCurrency').find('input:eq(0)').val(currency[1])
                ptr.removeClass('rowNotApproved')
                ptr.addClass('rowNotApprovedC')
                ptr.find('.td-actions').find('.approveRow,.rejectRow').addClass('d-noneTT')
                ptr.attr('cg', '1')
            } else {
                $(this).attr('title', $('#display1').val())
                ptr.find('.editVendor').find('input:eq(0)').val(vendor[0])

                ptr.find('.dp').find('div:eq(0)').text(description[0])
                ptr.find('.dp').find('input:eq(0)').val(description[0])

                ptr.find('.qu').find('div:eq(0)').text(qu[0])
                ptr.find('.qu').find('input:eq(0)').val(qu[0])

                ptr.find('.un').find('div:eq(0)').text(unit[0])
                ptr.find('.un').find('input:eq(0)').val(unit[0])

                ptr.find('.qt').find('div:eq(0)').text(qt[0])
                ptr.find('.qt').find('input:eq(0)').val(qt[0])

                ptr.find('.editTime').find('input:eq(0)').val(time[0])

                ptr.find('.editUnitCost').find('input:eq(0)').val(cost[0])
                ptr.find('.editUnitCost').find('.hideCost').val(cost[0])
                ptr.find('.editCurrency').find('input:eq(0)').val(currency[0])
                ptr.removeClass('rowNotApprovedC')
                ptr.addClass('rowNotApproved')
                ptr.find('.td-actions').find('.approveRow,.rejectRow').removeClass('d-noneTT')
                ptr.attr('cg', '0')
            }
            // Update vendor
            aux_vendor = ptr.find('.editVendor').find('input:eq(0)').val()
            if (aux_vendor == "")
                ptr.find('.editVendor').find('g:eq(0)').text("")
            else {
                if (aux_vendor.split('-')[1] == 'l')
                    aux_vendor = "-l"
                this_vendor = $('#myVendor').find('option[value="' + aux_vendor + '"]').text()
                ptr.find('.editVendor').find('g:eq(0)').text(this_vendor)
            }
            // Update time
            aux_time = ptr.find('.editTime').find('input:eq(0)').val()
            if (aux_time == "")
                ptr.find('.editTime').find('g:eq(0)').text("")
            else {
                if (ln() == 'es')
                    array_time = ['Horas', 'Días', 'Semanas', 'Meses', 'Proyecto'];
                else
                    array_time = ['Hours', 'Days', 'Weeks', 'Months', 'Project'];
                ptr.find('.editTime').find('g:eq(0)').text(array_time[parseFloat(aux_time)])
            }
            // Update unit cost
            field = ptr.find('.editUnitCost').find('input:eq(0)').val()
            if (field.trim() == '') {
                cost = 0;
            } else {
                cost = parseFloat(field)
            }
            tr = ptr
            if (tr.find('.editCurrency').find('input:eq(0)').val().trim() != '') {
                account_c = parseFloat(tr.find('.editCurrency').find('input:eq(0)').val())
            } else {
                account_c = parseFloat($('#currency').find('option:selected').val())
            }
            if ($('#show_currency').find('option:selected').val() != '0') {
                cvr = conversion(cost, account_c);
                toSum = conversion(cost, account_c);

            } else {
                cvr = currencyValues(cost, account_c);
                toSum = convertBudgetCurrency(cost, account_c);
            }
            if (cost > 0)
                ptr.find('.editUnitCost').find('div').text(formatNumber(cvr[1]))
            else
                ptr.find('.editUnitCost').find('div').text("")

            actual = $('#show_currency').find('option:selected').val()
            if (ptr.find('.editCurrency').find('input:eq(0)').val() != "") {
                if (actual != '0') {
                    array_codes = ['MXN', 'USD', 'EUR'];
                    text = array_codes[parseFloat(actual) - 1]
                } else {
                    text = array_codes[parseFloat(ptr.find('.editCurrency').find('input:eq(0)').val())]
                }
            } else {
                text = ""
            }
            ptr.find('.editCurrency').find('g').text(text)
            updateTotal(tr, cvr, toSum)
            if (tr.hasClass('mult')) {
                updateTop('account', tr.attr('account'))
            } else if (tr.hasClass('uni')) {
                updateTop('block', tr.attr('block'))
            }
        }
    })
    $('.backRowTT').click(function () {
        if ($(this).parents('tr').hasClass('rowNotApprovedT') || $(this).parents('tr').hasClass('rowNotApprovedTC')) {
            ptr = $(this).parents('tr')
            //To validete empty fields
            if (ptr.find('.editTypeTT').find('.cg').val().trim() == "") {
                type = ["", ""]
            } else
                type = ptr.find('.editTypeTT').find('.cg').val().split('/')
            if (ptr.find('.editDescriptionTT').find('.cg').val().trim() == "") {
                description = ["", ""]
            } else
                description = ptr.find('.editDescriptionTT').find('.cg').val().split('/')
            if (ptr.find('.editVendorTT').find('.cg').val().trim() == "") {
                vendor = ["", ""]
            } else
                vendor = ptr.find('.editVendorTT').find('.cg').val().split('/')
            if (ptr.find('.editPercentageTT').find('.cg').val().trim() == "") {
                percentage = ["", ""]
            } else
                percentage = ptr.find('.editPercentageTT').find('.cg').val().split('/')
            if (ptr.find('.editAmountTT').find('.cg').val().trim() == "") {
                amount = ["", ""]
            } else
                amount = ptr.find('.editAmountTT').find('.cg').val().split('/')

            // To compare changes

            if (ptr.attr('cg') == '0') {
                $(this).attr('title', $('#display2').val())
                ptr.find('.editTypeTT').find('input:eq(0)').val(type[1])
                ptr.find('.editDescriptionTT').find('input:eq(0)').val(description[1])
                ptr.find('.editVendorTT').find('input:eq(0)').val(vendor[1])

                if (percentage[1] != "")
                    ptr.find('.editPercentageTT').find('div:eq(0)').text(parseFloat(percentage[1]).toFixed(1) + " %")
                else
                    ptr.find('.editPercentageTT').find('div:eq(0)').text("")
                ptr.find('.editPercentageTT').find('input:eq(0)').val(percentage[1])
                ptr.find('.editPercentageTT').find('input:eq(1)').val(percentage[1])
                if (amount[1] != "") {
                    if ($('#show_currency').find('option:selected').val() != '0') {
                        amount_value = conversion(parseFloat(amount[1]), parseFloat($('#currency').find('option:selected').val()));
                    } else {
                        amount_value = convertBudgetCurrency(parseFloat(amount[1]), parseFloat($('#currency').find('option:selected').val()));
                    }
                    ptr.find('.editAmountTT').find('div:eq(0)').text(formatNumber(amount_value[1]))
                }
                else {
                    ptr.find('.editAmountTT').find('div:eq(0)').text("")
                }
                ptr.find('.editAmountTT').find('input:eq(0)').val(amount[1])
                ptr.find('.editAmountTT').find('input:eq(1)').val(amount[1])
                ptr.removeClass('rowNotApprovedT')
                ptr.addClass('rowNotApprovedTC')
                ptr.find('.td-actions').find('.approveRowTT,.rejectRowTT').addClass('d-noneTT')
                ptr.attr('cg', '1')
            } else {
                $(this).attr('title', $('#display1').val())
                ptr.find('.editTypeTT').find('input:eq(0)').val(type[0])
                ptr.find('.editDescriptionTT').find('input:eq(0)').val(description[0])
                ptr.find('.editVendorTT').find('input:eq(0)').val(vendor[0])

                if (percentage[0] != "")
                    ptr.find('.editPercentageTT').find('div:eq(0)').text(parseFloat(percentage[0]).toFixed(1) + " %")
                else
                    ptr.find('.editPercentageTT').find('div:eq(0)').text("")

                ptr.find('.editPercentageTT').find('input:eq(0)').val(percentage[0])
                ptr.find('.editPercentageTT').find('input:eq(1)').val(percentage[0])
                if (amount[0] != "") {
                    if ($('#show_currency').find('option:selected').val() != '0') {
                        amount_value = conversion(parseFloat(amount[0]), parseFloat($('#currency').find('option:selected').val()));
                    } else {
                        amount_value = convertBudgetCurrency(parseFloat(amount[0]), parseFloat($('#currency').find('option:selected').val()));
                    }
                    ptr.find('.editAmountTT').find('div:eq(0)').text(formatNumber(amount_value[1]))
                }
                else {
                    ptr.find('.editAmountTT').find('div:eq(0)').text("")
                }
                ptr.find('.editAmountTT').find('input:eq(0)').val(amount[0])
                ptr.find('.editAmountTT').find('input:eq(1)').val(amount[0])
                ptr.removeClass('rowNotApprovedTC')
                ptr.addClass('rowNotApprovedT')
                ptr.find('.td-actions').find('.approveRowTT,.rejectRowTT').removeClass('d-noneTT')
                ptr.attr('cg', '0')
            }
            // Update type
            aux_type = ptr.find('.editTypeTT').find('input:eq(0)').val()
            if (aux_type.trim() == "") {
                aux_type = ptr.find('.editTypeTT').find('g:eq(0)').text("")
            } else {
                this_type = $('#myType').find('option[value="' + aux_type + '"]').text()
                ptr.find('.editTypeTT').find('g:eq(0)').text(this_type)
            }
            // Update description
            aux_description = ptr.find('.editDescriptionTT').find('input:eq(0)').val()
            if (aux_description.trim() == "") {
                aux_description = ptr.find('.editDescriptionTT').find('g:eq(0)').text("")
            } else {
                if ($('#myDescriptionFee').find('option[value="' + aux_description + '"]').length > 0)
                    this_description = $('#myDescriptionFee').find('option[value="' + aux_description + '"]').text()
                else
                    this_description = $('#myDescriptionTax').find('option[value="' + aux_description + '"]').text()
                ptr.find('.editDescriptionTT').find('g:eq(0)').text(this_description)
            }
            // Update vendor
            aux_vendor = ptr.find('.editVendorTT').find('input:eq(0)').val()
            if (aux_vendor == "")
                ptr.find('.editVendorTT').find('g:eq(0)').text("")
            else {
                if (aux_vendor.split('-')[1] == 'l')
                    aux_vendor = "-l"
                this_vendor = $('#myVendor').find('option[value="' + aux_vendor + '"]').text()
                ptr.find('.editVendorTT').find('g:eq(0)').text(this_vendor)
            }

            if ($(this).parents('tr').find('.editPercentageTT').find('input:eq(0)').val().trim() != "") {
                selectCellsTT($(this).parents('tr'))
            } else if ($(this).parents('tr').find('.editAmountTT').find('input:eq(0)').val().trim() != "") {
                selectCellsTTA($(this).parents('tr'))
            } else {
                ptr.find('.editAmountTT').find('.amountToSum').val("")
            }
            updateTaxFee()
        }
    })
}
function deleteEventsC() {
    $('.backRow').unbind()
    $('.backRowTT').unbind()
}

///To approve changes
$('.approveRow').click(function () {
    if (ln() == 'es') {
        text = "¿Esta seguro en aprobar este cambio?"
        btnYes = "Sí, aprobar"
        btnNot = "No, Cancelar"
    } else {
        text = "Are you sure you want to approve this change?"
        btnYes = "Yes, approve!"
        btnNot = "No, ¡Cancel!"
    }
    swal({
        html: text,
        showCancelButton: true,
        confirmButtonText: btnYes,
        cancelButtonText: btnNot,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then((result) => {
        if (result.value) {
            row = $(this).parents('td').parents('tr')
            approveElement(row)
        }
    });
})
function approveElement(row) {

    if (row.attr('cg') == '1') {
        row.find('.backRow').click()
    }
    deleteEvents()
    row.removeClass('rowNotApproved')
    row.attr('change', '3')
    row.find('.td-actions').empty()
    row.find('.cg').remove()
    row.removeAttr('cg')
    row.find('.td-actions').append('<button type="button" class="btn btn-sssm btn-link btn-github duplicateRow"><i class="fa fa-copy"></i></button><button type="button" class="btn btn-sssm btn-link btn-github deleteRow"><i class="fa fa-minus-square"></i></button>')
    refreshEvents()
}
///To reject changes
$('.rejectRow').click(function () {
    if (ln() == 'es') {
        text = "¿Esta seguro en rechazar este cambio?"
        btnYes = "Sí, Rechazar"
        btnNot = "No, Cancelar"
    } else {
        text = "Are you sure you want to reject this change?"
        btnYes = "Yes, reject!"
        btnNot = "No, ¡Cancel!"
    }
    swal({
        html: text,
        showCancelButton: true,
        confirmButtonText: btnYes,
        cancelButtonText: btnNot,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then((result) => {
        if (result.value) {
            row = $(this).parents('td').parents('tr')
            rejectElement(row)
        }
    });
})
function rejectElement(row) {
    if (row.hasClass('ecg')) { //ncg class is for edited change
        if (row.attr('cg') == '0') {
            row.find('.backRow').click()
        }
        deleteEvents()
        row.removeClass('rowNotApprovedC')
        row.removeClass('ecg')
        row.attr('change', '4')
        row.find('.td-actions').empty()
        row.find('.cg').remove()
        row.removeAttr('cg')
        row.find('.td-actions').append('<button type="button" class="btn btn-sssm btn-link btn-github duplicateRow"><i class="fa fa-copy"></i></button><button type="button" class="btn btn-sssm btn-link btn-github deleteRow"><i class="fa fa-minus-square"></i></button>')
        refreshEvents()
    } else if (row.hasClass('ncg') && row.hasClass('uni')) {
        row.removeClass('rowNotComplete')
        row.removeClass('rowNotApproved')
        row.removeClass('ntitle="Aceptar cambio"cg')

        row.attr('change', '4')
        row.find('td:eq(0)').find('input:eq(0)').val('A')
        //Vendor
        row.find('td:eq(2)').find('g').text('')
        row.find('td:eq(2)').find('input').val('')
        //Description
        row.find('td:eq(3)').find('div').text('')
        row.find('td:eq(3)').find('input').val('')
        //Quantity
        row.find('td:eq(4)').find('div').text('')
        row.find('td:eq(4)').find('input').val('')
        //Unit
        row.find('td:eq(5)').find('div').text('')
        row.find('td:eq(5)').find('input').val('')
        //Quantity
        row.find('td:eq(6)').find('div').text('')
        row.find('td:eq(6)').find('input').val('')
        //Time
        row.find('td:eq(7)').find('g').text('')
        row.find('td:eq(7)').find('input').val('')
        //Unit cost
        row.find('td:eq(8)').find('div').text('')
        row.find('td:eq(8)').find('input').val('')
        //Currency
        row.find('td:eq(9)').find('g').text('')
        row.find('td:eq(9)').find('input').val('')
        //Total cost
        row.find('td:eq(10)').text('')
        row.find('td:eq(10)').append("<input type='hidden' value=''/>")

        //Actions
        row.find('.cg').remove()
        row.removeAttr('cg')
        row.find('.td-actions').empty()
        row.find('.td-actions').append('<button type="button" class="btn btn-sssm btn-link btn-github duplicateRow d-none"><i class="fa fa-copy"></i></button><button type="button" class="btn btn-sssm btn-link btn-github deleteRow d-none"><i class="fa fa-minus-square"></i></button>')
        updateTop('block', row.attr('block'))
    } else if (row.hasClass('ncg') && row.hasClass('mult')) {
        account = row.attr('account')
        belongs = ".belongsAccount" + account

        row.addClass('d-none')
        row.addClass('deleteThisTC')
        row.removeClass("belongsAccount" + account)
        row.removeClass("rowNotComplete")
        row.attr('change', 4)
        if ($(belongs).length == 1) {
            rowAccount = $('#myAccount' + account)
            onlyRow = $(belongs)
            aux_clone = onlyRow.clone()
            onlyRow.attr('class', rowAccount.attr('class'))
            if (onlyRow.find('.editVendor').find('input:eq(0)').val() == "-l")
                onlyRow.addClass('client')
            if (aux_clone.hasClass('rowNotApproved'))
                onlyRow.addClass('rowNotApproved')
            if (aux_clone.hasClass('rowNotApprovedC'))
                onlyRow.addClass('rowNotApprovedC')
            if (aux_clone.hasClass('ecg'))
                onlyRow.addClass('ecg')
            if (aux_clone.hasClass('ncg'))
                onlyRow.addClass('ncg')
            onlyRow.removeClass('myAccount')
            onlyRow.removeClass('mb')
            onlyRow.addClass('uni')
            onlyRow.find('td:eq(0)').removeAttr('colspan')
            valtd = onlyRow.find('td:eq(0)').text().split('-')
            onlyRow.find('td:eq(0)').text(valtd[0])
            onlyRow.find('td:eq(0)').append("<input type='hidden' value='" + valtd[1].trim() + "'>")
            onlyRow.find('td:eq(0)').after("<td class='mb'>" + rowAccount.find('td:eq(1)').text() + "</td>")
            rowAccount.remove()
            updateTop('block', onlyRow.attr('block'))
        } else {
            updateTop('account', account)
        }
    }
}
///To approve changes (fees and taxes)
$('.approveRowTT').click(function () {
    if (ln() == 'es') {
        text = "¿Esta seguro en aprobar este cambio?"
        btnYes = "Sí, aprobar"
        btnNot = "No, Cancelar"
    } else {
        text = "Are you sure you want to approve this change?"
        btnYes = "Yes, approve!"
        btnNot = "No, ¡Cancel!"
    }
    swal({
        html: text,
        showCancelButton: true,
        confirmButtonText: btnYes,
        cancelButtonText: btnNot,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then((result) => {
        if (result.value) {
            row = $(this).parents('td').parents('tr')
            approveElementTT(row)
        }
    });
})
function approveElementTT(row) {
    if (row.attr('cg') == '1') {
        row.find('.backRowTT').click()
    }
    deleteEventsTT()
    row.removeClass('rowNotApprovedT')
    row.attr('changet', '3')
    row.find('.td-actions').empty()
    row.find('.cg').remove()
    row.removeAttr('cg')
    row.find('.td-actions').append('<button type="button" class="btn btn-sssm btn-link btn-github duplicateRowTT"><i class="fa fa-copy"></i></button><button type="button" class="btn btn-sssm btn-link btn-github deleteRowTT"><i class="fa fa-minus-square"></i></button>')
    refreshEventsTT()
}
///To reject changes (fees and taxes)
$('.rejectRowTT').click(function () {
    if (ln() == 'es') {
        text = "¿Esta seguro en rechazar este cambio?"
        btnYes = "Sí, Rechazar"
        btnNot = "No, Cancelar"
    } else {
        text = "Are you sure you want to reject this change?"
        btnYes = "Yes, reject!"
        btnNot = "No, ¡Cancel!"
    }
    swal({
        html: text,
        showCancelButton: true,
        confirmButtonText: btnYes,
        cancelButtonText: btnNot,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then((result) => {
        if (result.value) {
            row = $(this).parents('td').parents('tr')
            rejectElementTT(row)
        }
    });
})
function rejectElementTT(row) {
    if (row.attr('cg') == '0') {
        row.find('.backRowTT').click()
    }
    if (row.hasClass('ecgc')) { //ncgc class is for edited change
        deleteEventsTT()
        row.removeClass('rowNotApprovedTC')
        row.removeClass('ecgc')
        row.attr('changet', '4')
        row.find('.td-actions').empty()
        row.find('.cg').remove()
        row.removeAttr('cg')
        row.find('.td-actions').append('<button type="button" class="btn btn-sssm btn-link btn-github duplicateRowTT"><i class="fa fa-copy"></i></button><button type="button" class="btn btn-sssm btn-link btn-github deleteRowTT"><i class="fa fa-minus-square"></i></button>')
        refreshEventsTT()
    } else if (row.hasClass('ncgc')) {
        if (row.parent('tbody').parent('table').hasClass('r-space-yy')) {
            aux_type = $('.r-space-yy')
        } else {
            aux_type = $('.r-space-tt')
        }
        if (aux_type.find('.tax-fee').length == 1) {
            deleteEventsTT()
            clone = aux_type.find('.duplicateTaxFee').clone()
            clone.removeClass('d-none')
            clone.removeClass('duplicaTaxFee')
            clone.addClass('tax-fee')
            aux_type.find('.duplicateTaxFee').after(clone)
            refreshEventsTT()
        }
        row.attr('class', '')
        row.addClass('deleteThisTTC')
        row.addClass('d-none')
        row.attr('changet', '4')
        row.find('.td-actions').empty()
        row.find('.cg').remove()
        row.removeAttr('cg')
        row.find('.td-actions').append('<button type="button" class="btn btn-sssm btn-link btn-github duplicateRowTT"><i class="fa fa-copy"></i></button><button type="button" class="btn btn-sssm btn-link btn-github deleteRowTT"><i class="fa fa-minus-square"></i></button>')
    }
}
$('#switchChange').click(function () {
    if ($('#hswitchChange').val() == '0') {
        $('#hswitchChange').val('1')
        $("#scLabel").text($('#display2').val())
        $('.rowNotApproved').find('.backRow').click()
        $('.rowNotApprovedT').find('.backRowTT').click()
    } else {
        $('#hswitchChange').val('0')
        $("#scLabel").text($('#display1').val())
        $('.rowNotApprovedC').find('.backRow').click()
        $('.rowNotApprovedTC').find('.backRowTT').click()
    }
})

