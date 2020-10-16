function refreshEventsTT() {
    $(".editTypeTT").click(function () {
        cleanSelects(0)
        if ($(this).hasClass("off") && !$(this).parents('tr').hasClass('rowNotApprovedT') && !$(this).parents('tr').hasClass('rowNotApprovedTC')) {
            if ($('#myType').attr('status') == '1') {
                $('#myType').parents('td').append($('.warehouse').find('.textTypeTT'))
            }
            $(this).removeClass('off')
            $(this).append($('#divType'))
            $('.warehouse').append($(this).find('.textTypeTT'))
            $('#divType').removeClass('d-none')
            $('#divType').find('div').removeClass('d-none')
            $('#myType').attr('status', '1')
            $('#myType').attr('update', '1')
            id = $(this).find('input:eq(0)').val()
            text = $("#myType option[value='" + id + "']").text()
            $("#myType").val(id).trigger('change');
            $('#myType').attr('update', '0')
        } else if ($(this).find('#divType').length == 0) {
            $(this).addClass('off')
        }
    })
    $(".editVendorTT").click(function () {
        cleanSelects(0)
        if ($(this).hasClass("off") && !$(this).parents('tr').hasClass('rowNotApprovedT') && !$(this).parents('tr').hasClass('rowNotApprovedTC')) {
            if ($('#myVendor').attr('status') == '1') {
                $('#myVendor').parents('td').append($('.warehouse').find('.textVendor'))
            }
            $(this).removeClass('off')
            $(this).append($('#divVendor'))
            $('.warehouse').append($(this).find('.textVendor'))
            $('#divVendor').removeClass('d-none')
            $('#divVendor').find('div').removeClass('d-none')
            $('#myVendor').attr('status', '1')
            $('#myVendor').attr('update', '1')
            id = $(this).find('input:eq(0)').val()
            text = $("#myVendor option[value='" + id + "']").text()
            $("#myVendor").val(id).trigger('change');
            $('#myVendor').attr('update', '0')
        } else if ($(this).find('#divVendor').length == 0) {
            $(this).addClass('off')
        }
    })
    $(".editDescriptionTT").click(function () {
        tr = $(this).parents('tr')
        if (!$(this).parents('tr').hasClass('rowNotApprovedT') && !$(this).parents('tr').hasClass('rowNotApprovedTC')) {
            if (tr.find('.editTypeTT').find('input:eq(0)').val() != "") {
                cleanSelects(0)
                if ($(this).hasClass("off")) {
                    if (tr.find('.editTypeTT').find('input:eq(0)').val() == "1") {
                        descriptionType($(this), "Tax")

                    } else if (tr.find('.editTypeTT').find('input:eq(0)').val() == "2") {
                        descriptionType($(this), "Fee")
                    }
                } //else if ($(this).find('#divVendor').length == 0) {
                //     $(this).addClass('off')
                // }
            } else {
                swal({
                    text: $('#validationExistTaxFee').text(),
                    buttonsStyling: false,
                    confirmButtonClass: 'btn btn-success',
                }).catch(swal.noop)
            }
        }
    })
    $(".editPercentageTT").click(function () {
        if (!$(this).parents('tr').hasClass('rowNotApprovedT') && !$(this).parents('tr').hasClass('rowNotApprovedTC')) {
            $(this).find('div').addClass('d-none')
            $(this).find('input').removeClass('d-none')
            $(this).find('input').focus()
            cleanSelects(0)
        }
    })
    $(".utta").keyup(function (e) {
        if (e.keyCode != "9") {
            valor = $(this).val();
            if (valor.length > 1) {
                if (parseFloat(valor) < 0)
                    $(this).val(parseFloat(valor) * -1)

                if (parseFloat(valor) > 100) {
                    valor = valor.substring(0, valor.length - 1);
                    $(this).val(parseFloat(valor))
                }
            }
            var res = valor.split(".");

            if (res.length > 1) {
                if (res[1].length > 2) {
                    show = parseFloat(res[0] + "." + res[1].substr(0, 2));
                    $(this).val(show.toFixed(2));
                }
            }
            selectCellsTT($(this).parents('td').parents('tr'))
            updateTaxFee()
        }
    })
    $(".hidePercentage").blur(function () {
        $(this).parent('td').find('div').removeClass('d-none')
        before = $(this).parent('td').find('input:eq(0)').val()
        if ($(this).val().trim() != "")
            $(this).parent('td').find('div').text(parseFloat($(this).val()).toFixed(1) + " %")
        else if ($(this).parent('td').next().find('input:eq(0)').val() == "")
            $(this).parent('td').find('div').text("")
        $(this).addClass('d-none')
        if (before.trim() != $(this).val().trim()) {
            $(this).parent('td').find('input:eq(0)').val($(this).val())
            $(this).parents('td').parents('tr').attr('changet', '1')
            $(this).parents('td').parents('tr').find('.btn').removeClass('d-noneTT')
        }
        checkCompleteThisTT($(this).parents('td').parents('tr'), 1)
    })
    $('.duplicateRowTT').click(function () {
        cleanSelects(0)
        row = $(this).parents('td').parents('tr')
        duplicateTaxFee(row)
    })
    $(".editAmountTT").click(function () {
        if (!$(this).parents('tr').hasClass('rowNotApprovedT') && !$(this).parents('tr').hasClass('rowNotApprovedTC')) {
            $(this).find('div').addClass('d-none')
            $(this).find('input').removeClass('d-none')
            $(this).find('input').focus()
            cleanSelects(0)
        }
    })
    $(".uttaa").keyup(function (e) {
        if (e.keyCode != "9") {
            valor = $(this).val();
            if (valor.length > 1) {
                if (parseFloat(valor) < 0)
                    $(this).val(parseFloat(valor) * -1)
            }
            var res = valor.split(".");

            if (res.length > 1) {
                if (res[1].length > 2) {
                    show = parseFloat(res[0] + "." + res[1].substr(0, 2));
                    $(this).val(show.toFixed(2));
                }
            }
            selectCellsTTA($(this).parents('td').parents('tr'))
            updateTaxFee()
        }
    })
    $(".hideAmount").blur(function () {
        $(this).parent('td').find('div').removeClass('d-none')
        before = $(this).parent('td').find('input:eq(0)').val()
        if ($(this).val().trim() != "") {
            if ($('#show_currency').find('option:selected').val() != '0') {
                amount_value = conversion(parseFloat($(this).val()), parseFloat($('#currency').find('option:selected').val()));
            } else {
                amount_value = convertBudgetCurrency(parseFloat($(this).val()), parseFloat($('#currency').find('option:selected').val()));
            }
            $(this).parent('td').find('div').text(formatNumber(amount_value[1]))
        }
        else if ($(this).parent('td').prev().find('input:eq(0)').val() == "")
            $(this).parent('td').find('div').text("")
        $(this).addClass('d-none')
        if (before.trim() != $(this).val().trim()) {
            $(this).parent('td').find('input:eq(0)').val($(this).val())
            $(this).parents('td').parents('tr').attr('changet', '1')
            $(this).parents('td').parents('tr').find('.btn').removeClass('d-noneTT')
        }
        checkCompleteThisTT($(this).parents('td').parents('tr'), 1)
    })
    $('.deleteRowTT').click(function () {
        cleanSelects(0)
        if (ln() == 'es') {
            text = "¿Esta seguro en eliminar este valor?"
            btnYes = "Sí, Eliminar"
            btnNot = "No, Cancelar"
        } else {
            text = "Are you sure you want to delete this value?"
            btnYes = "Yes, delete!"
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
                deleteElementTT($(this).parents('td').parents('tr'))
            }
        });
    })
    $("#myTaxFee").click(function () {
        tax_f = $(this)
        if (tax_f.attr('status') == '0') {
            $('.r-space-tt').find('.tax-fee').removeClass('d-none')
            $('.tableHead2').removeClass('d-none')

            tax_f.attr('status', '1')
            tax_f.find('i').css('color', '#ffffff')
            tax_f.find('a').css('color', '#ffffff')
            tax_f.find('i').text('keyboard_arrow_up')
        } else {
            $('.r-space-tt').find('.tax-fee').addClass('d-none')
            $('.tableHead2').addClass('d-none')
            tax_f.attr('status', '0')
            tax_f.find('i').css('color', '#fff')
            tax_f.find('a').css('color', '#fff')
            tax_f.find('i').text('keyboard_arrow_down')
            $('#divBudgetTT').scrollTop(0);
            $('#divBudgetTT').perfectScrollbar('update');
        }
    })
    $("#myTax").click(function () {
        tax_f = $(this)
        if (tax_f.attr('status') == '0') {
            $('.r-space-yy').find('.tax-fee').removeClass('d-none')
            $('.tableHead3').removeClass('d-none')

            tax_f.attr('status', '1')
            tax_f.find('i').css('color', '#ffffff')
            tax_f.find('a').css('color', '#ffffff')
            tax_f.find('i').text('keyboard_arrow_up')
        } else {
            $('.r-space-yy').find('.tax-fee').addClass('d-none')
            $('.tableHead3').addClass('d-none')
            tax_f.attr('status', '0')
            tax_f.find('i').css('color', '#fff')
            tax_f.find('a').css('color', '#fff')
            tax_f.find('i').text('keyboard_arrow_down')
            $('#divBudgetYY').scrollTop(0);
            $('#divBudgetYY').perfectScrollbar('update');
        }
    })
} //End refresh
//Delete events
function deleteEventsTT() {
    $(".editTypeTT").unbind()
    $(".editVendorTT").unbind()
    $(".editDescriptionTT").unbind()
    $(".editPercentageTT").unbind()
    $(".utta").unbind()
    $(".hidePercentage").unbind()
    $('.duplicateRowTT').unbind()
    $(".uttaa").unbind()
    $(".editAmountTT").unbind()
    $(".hideAmount").unbind()
    $('.deleteRowTT').unbind()
    $("#myTaxFee").unbind()
}
//End delete
$("#myType").change(function () {
    if ($('#myType').attr('update') == '0') {
        $(this).parents('td').parents('tr').find('.btn').removeClass('d-noneTT')
        // $(this).parents('td').append($('.warehouse').find('.textTypeTT'))
        text = $(this).find('option:selected').text();
        id = $(this).find('option:selected').val();
        $('.warehouse').find('.textTypeTT').text(text)
        $(this).parents('td').find('input:eq(0)').val(id)
        $(this).parents('td').parents('tr').attr('changet', '1')
        $(this).parents('td').next().find('g').text('')
        $(this).parents('td').next().find('input').val('')
        checkCompleteThisTT($(this).parents('td').parents('tr'), 1)
    }
})
function descriptionType(td, type) {
    console.log($('#myDescription' + type))
    if ($('#myDescription' + type).attr('status') == '1') {
        $('#myDescription' + type).parents('td').append($('.warehouse').find('.textDescriptionTT'))
    }
    td.removeClass('off')
    td.append($('#divDescription' + type))
    $('.warehouse').append(td.find('.textDescriptionTT'))
    $('#divDescription' + type).removeClass('d-none')
    $('#divDescription' + type).find('div').removeClass('d-none')
    $('#myDescription' + type).attr('status', '1')
    $('#myDescription' + type).attr('update', '1')
    id = td.find('input:eq(0)').val()
    text = $('#myDescription' + type + " option[value='" + id + "']").text()
    $('#myDescription' + type).val(id).trigger('change');
    $('#myDescription' + type).attr('update', '0')
}

$("#myDescriptionTax").change(function () {
    chosenDescription('Tax')
})

$("#myDescriptionFee").change(function () {
    chosenDescription('Fee')
})

function chosenDescription(type) {
    if ($('#myDescription' + type).attr('update') == '0') {
        if ($('#myDescription' + type).find('option:selected').text() == $('#myDescription' + type).find('option:selected').val()) {
            if (!checkIt()) {
                $('#myDescription' + type).attr('update', '1')
                $('#myDescription' + type).val('').trigger('change');
                $('#myDescription' + type).attr('update', '0')
                return false;
            }
            catchDescription = $('#myDescription' + type)
            message = "<b>" + $('#myDescription' + type).find('option:selected').text() + "</b>"
            html = "<div class='swal2-content' style='display: block;'>" + document.getElementById('modalVendorText08').innerHTML + " " + message + "?</div>"
            swal({
                html: html,
                showCancelButton: true,
                confirmButtonText: document.getElementById('modalVendorText03').innerHTML,
                cancelButtonText: document.getElementById('modalVendorText04').innerHTML,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then(function (e) {

                if (e.value === true) {
                    $.ajax({
                        type: 'post',
                        url: mainRoute + "taxfeebudget/taxFeeAdd",
                        data: {
                            type: type,
                            description: catchDescription.find('option:selected').text(),
                        },
                        success: function (results) {
                            if (results.save_description) {
                                console.log(results.id_description)
                                catchDescription.append('<option value="' + results.id_description + '">' + catchDescription.find('option:selected').text() + '</option>')
                                catchDescription.attr('update', '1')
                                catchDescription.val("" + results.id_description + "").trigger('change');
                                catchDescription.attr('update', '0')
                                alphabeticSelect('myDescription' + type)

                                swal({
                                    title: document.getElementById('modalVendorText06').innerHTML,
                                    confirmButtonText: document.getElementById('modalVendorText07').innerHTML,
                                    confirmButtonClass: 'btn btn-info',
                                    type: "success"
                                });
                                catchDescription.parents('td').parents('tr').attr('changet', '1')
                                catchDescription.parents('td').parents('tr').find('.btn').removeClass('d-noneTT')

                                text = catchDescription.find('option:selected').text();
                                id = catchDescription.find('option:selected').val();
                                $('.warehouse').find('.textDescriptionTT').text(text)
                                catchDescription.parents('td').find('input:eq(0)').val(id)

                                checkCompleteThisTT(catchDescription.parents('td').parents('tr'), 1)
                            } else {

                                swal({
                                    title: results.error_message,
                                    confirmButtonText: document.getElementById('modalVendorText07').innerHTML,
                                    confirmButtonClass: 'btn btn-info',
                                    type: 'error',
                                });
                            }
                        }
                    });

                } else {
                    $('#myDescription' + type).attr('update', '1')
                    $('#myDescription' + type).val('').trigger('change');
                    $('#myDescription' + type).attr('update', '0')
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            }
            )
        } else {
            $('#myDescription' + type).parents('td').parents('tr').attr('changet', '1')
            $('#myDescription' + type).parents('td').parents('tr').find('.btn').removeClass('d-noneTT')

            text = $('#myDescription' + type).find('option:selected').text();
            id = $('#myDescription' + type).find('option:selected').val();
            $('.warehouse').find('.textDescriptionTT').text(text)
            $('#myDescription' + type).parents('td').find('input:eq(0)').val(id)
            checkCompleteThisTT($('#myDescription' + type).parents('td').parents('tr'), 1)

        }
    }
}
function selectCellsTT(tr) {
    //Get percentage
    if (tr.find('.editPercentageTT').find('input:eq(1)').val().trim() != '') {
        pr = parseFloat(tr.find('.editPercentageTT').find('input:eq(1)').val())
    } else {
        pr = 0;
    }
    //Get poduction cost
    if ($('#myBudget').find('td:eq(2)').find('input:eq(0)').val() != '') {
        pc = parseFloat($('#myBudget').find('td:eq(2)').find('input:eq(0)').val())
    } else {
        pc = 0
    }
    //Get fees 
    if (tr.parent('tbody').parent('table').hasClass('r-space-yy')) {
        if ($('#myTaxFee').find('td:eq(2)').find('input:eq(0)').val().trim() != '') {
            pt = parseFloat($('#myTaxFee').find('td:eq(2)').find('input:eq(0)').val())
        } else {
            pt = 0;
        }
        pc = pc + pt
    }
    if (pr == 0 || pc == 0) {
        tr.find('.editAmountTT').find('div').text('')
        tr.find('.editAmountTT').find('input:eq(0)').val('')
        tr.find('.editAmountTT').find('input:eq(1)').val('')
        tr.find('.editAmountTT').find('.amountToSum').val('')
    } else {
        tr.find('.editAmountTT').find('div').text(formatNumber(((pr / 100) * pc).toFixed(2)))
        tr.find('.editAmountTT').find('input:eq(0)').val('')
        tr.find('.editAmountTT').find('input:eq(1)').val('')
        if ($('#hswitchRound').val() == '0')
            tr.find('.editAmountTT').find('.amountToSum').val(((pr / 100) * pc).toFixed(2))
        else
            tr.find('.editAmountTT').find('.amountToSum').val(Math.round((pr / 100) * pc))
    }
}
function duplicateTaxFee(row) {
    deleteEventsTT()
    var clone = row.clone()
    clone.attr('tfid', '')
    clone.attr('changet', '1')
    clone.removeClass('rowNotComplete')
    clone.find('.editVendorTT').find('g').text("")
    clone.find('.editVendorTT').find('input').val("")
    clone.find('.td-actions').empty()
    clone.find('.td-actions').append('<button type="button" class="btn btn-sssm btn-link btn-github duplicateRowTT"><i class="fa fa-copy"></i></button><button type="button" class="btn btn-sssm btn-link btn-github deleteRowTT"><i class="fa fa-minus-square"></i></button>')
    if (row.parent('tbody').parent('table').hasClass('r-space-tt')) {
        $('.r-space-tt').find('.tax-fee').last().after(clone)
    } else {
        $('.r-space-yy').find('.tax-fee').last().after(clone)
    }
    gradientColorTT(clone)
    updateTaxFee()
    refreshEventsTT()
}
function selectCellsTTA(tr) {
    //Get amount
    if (tr.find('.editAmountTT').find('input:eq(1)').val().trim() != '') {
        pa = parseFloat(tr.find('.editAmountTT').find('input:eq(1)').val())
    } else {
        pa = 0;
    }
    //Get poduction cost
    if ($('#myBudget').find('td:eq(2)').find('input:eq(0)').val() != '') {
        pc = parseFloat($('#myBudget').find('td:eq(2)').find('input:eq(0)').val())
    } else {
        pc = 0
    }
    //Get fees 
    if (tr.parent('tbody').parent('table').hasClass('r-space-yy')) {
        if ($('#myTaxFee').find('td:eq(2)').find('input:eq(0)').val().trim() != '') {
            pt = parseFloat($('#myTaxFee').find('td:eq(2)').find('input:eq(0)').val())
        } else {
            pt = 0
        }
        pc = pc + pt
    }
    if (pa == 0 || pc == 0) {
        tr.find('.editPercentageTT').find('div').text('')
        tr.find('.editPercentageTT').find('input:eq(0)').val('')
        tr.find('.editPercentageTT').find('input:eq(1)').val('')
    } else {
        tr.find('.editPercentageTT').find('input:eq(0)').val('')
        tr.find('.editPercentageTT').find('input:eq(1)').val('')
        if ($('#show_currency').find('option:selected').val() != '0') {
            amount_value = conversion(pa, parseFloat($('#currency').find('option:selected').val()));
        } else {
            amount_value = convertBudgetCurrency(pa, parseFloat($('#currency').find('option:selected').val()));
        }
        tr.find('.editPercentageTT').find('div').text(((amount_value[1] * 100) / pc).toFixed(1) + " %")
        tr.find('.editAmountTT').find('div').text(formatNumber(amount_value[1]))

        if ($('#hswitchRound').val() == '0') {
            tr.find('.editAmountTT').find('.amountToSum').val(amount_value[1])
        }
        else {
            tr.find('.editAmountTT').find('.amountToSum').val(Math.round(amount_value[1]))
        }
    }
    // updateTotal(tr, cvr, toSum)
}

function checkChangesTT() {
    tr_t = $('tr[changet="1"]')
    if (tr_t.length > 0) {
        if (checkIt()) {
            var data = new FormData();
            data.append('size', tr_t.length)
            data.append('budget_id', $("#my_budget").val())
            tr_t.each(function (key) {
                tfid = $(this).attr('tfid')
                type = $(this).find('td:eq(0)').find('input:eq(0)').val()
                description = $(this).find('td:eq(1)').find('input:eq(0)').val()
                vendor = $(this).find('td:eq(2)').find('input:eq(0)').val()
                percentage = $(this).find('td:eq(3)').find('input:eq(0)').val()
                amount = $(this).find('td:eq(4)').find('input:eq(0)').val()
                data.append('tfid' + key, tfid)
                data.append('type' + key, type)
                data.append('description' + key, description)
                data.append('vendor' + key, vendor)
                data.append('percentage' + key, percentage)
                data.append('amount' + key, amount)
            });

            $.ajax({
                type: 'post',
                url: mainRoute + "taxfeebudget/saveTaxFee",
                headers: { 'X-CSRF-TOKEN': token = $('#tokenBudget').val() },
                data: data,
                processData: false,
                cache: false,
                contentType: false,
                success: function (r) {
                    if (r != 0) {
                        showSaveMessage();
                        if (r != 1) {
                            for (i = 0; i < r.number; i++) {
                                console.log(r.myIndex[i])
                                console.log(r.ids[i])
                                console.log(r.ids[i])
                                console.log(tr_t.eq([r.myIndex[i]]))
                                tr_t.eq([r.myIndex[i]]).attr('tfid', r.ids[i])
                            }
                        }
                        tr_t.attr('changet', '0')
                    }
                }
            });
        }
    }
    //Delete tax and fee
    trd_t = $('tr[changet="2"]')
    if (trd_t.length > 0) {
        if (checkIt()) {
            var datat = new FormData();
            datat.append('size', trd_t.length)
            datat.append('budget_id', $("#my_budget").val())
            trd_t.each(function (key) {
                tfid = $(this).attr('tfid')
                datat.append('tfid' + key, tfid)
            })
            $.ajax({
                type: 'post',
                url: mainRoute + "taxfeebudget/deleteTaxFee",
                headers: { 'X-CSRF-TOKEN': token = $('#tokenBudget').val() },
                data: datat,
                processData: false,
                cache: false,
                contentType: false,
                success: function (r) {
                    if (r != 0) {
                        showSaveMessage();
                        if (r == 1) {
                            $('.deleteThisTT').remove()
                        }
                    }
                }
            });

        }
    }
    trc_t = $('tr[changet="3"]')
    if (trc_t.length > 0) {
        if (checkIt()) {
            var datac_t = new FormData();
            datac_t.append('size', trc_t.length)
            datac_t.append('budget_id', $("#my_budget").val())
            datac_t.append('change', "1")
            trc_t.each(function (key) {
                tfid = $(this).attr('tfid')
                datac_t.append('tfid' + key, tfid)
            })
            $.ajax({
                type: 'post',
                url: mainRoute + "taxfeebudget/change",
                headers: { 'X-CSRF-TOKEN': token = $('#tokenBudget').val() },
                data: datac_t,
                processData: false,
                cache: false,
                contentType: false,
                success: function (r) {
                    if (r != 0) {
                        showSaveMessage();
                        if (r == 1) {
                            $('tr[changet="3"]').attr('changet', '0')
                        }
                    }
                }
            });
        }
    }
    tre_t = $('tr[changet="4"]')
    if (tre_t.length > 0) {
        if (checkIt()) {
            var datac = new FormData();
            datac.append('size', tre_t.length)
            datac.append('budget_id', $("#my_budget").val())
            datac.append('change', "2")
            tre_t.each(function (key) {
                tfid = $(this).attr('tfid')
                datac.append('tfid' + key, tfid)
            })
            $.ajax({
                type: 'post',
                url: mainRoute + "taxfeebudget/change",
                headers: { 'X-CSRF-TOKEN': token = $('#tokenBudget').val() },
                data: datac,
                processData: false,
                cache: false,
                contentType: false,
                success: function (r) {
                    if (r != 0) {
                        showSaveMessage();
                        if (r == 1) {
                            $('tr[changet="4"]').attr('tfid', '')
                            $('tr[changet="4"]').attr('change', '0')
                            $('.deleteThisTTC').remove()
                        }
                    }
                }
            });
        }
    }
}
function updateAmount() {
    tr = $('.tax-fee')
    tr.each(function () {
        if ($(this).find('.editPercentageTT').find('input:eq(0)').val().trim() != "") {
            selectCellsTT($(this))
        } else if ($(this).find('.editAmountTT').find('input:eq(0)').val().trim() != "") {
            selectCellsTTA($(this))
        }
    })
}
function checkCompleteThisTT(row, can) {
    if (!checkRowCompleteTT(row))
        row.addClass('rowNotComplete')
    else
        row.removeClass('rowNotComplete')
    if (can == 1)
        canApprove()
}
function checkRowCompleteTT(row) {
    if (row.attr('changet') == '0' && row.attr('tfid') == '')
        return true
    //type
    if (row.find('td:eq(0)').find('input:eq(0)').val().trim() == '')
        return false;
    //Description
    if (row.find('td:eq(1)').find('input:eq(0)').val().trim() == '')
        return false;
    //Vebdor
    // if (row.find('td:eq(2)').find('input:eq(0)').val().trim() == '')
    //     return false;
    //Percentage/Amount
    if (row.find('td:eq(3)').find('input:eq(0)').val().trim() == '' && row.find('td:eq(4)').find('input:eq(0)').val().trim() == '')
        return false;
    return true;
}
async function gradientColorTT(clone) {
    clone.css("background-color", "#7da453")
    await wait(100);
    clone.css("background-color", "#88AC62")
    await wait(100);
    clone.css("background-color", "#97B675")
    await wait(100);
    clone.css("background-color", "#A5C088")
    await wait(100);
    clone.css("background-color", "#AFC795")
    await wait(100);
    clone.css("background-color", "#BACFA3")
    await wait(100);
    clone.css("background-color", "#CADAB9")
    await wait(100);
    clone.css("background-color", "#ffffff")
    checkCompleteThisTT(clone)
}
function checkCompleteAllTT() {
    tr = $('.r-space-tt').find('tr')
    tr.each(function () {
        if ($(this).hasClass('tax-fee') && $(this).attr('tfid') != '') {
            checkCompleteThisTT($(this), 0)
        }
    })
    trt = $('.r-space-yy').find('tr')
    trt.each(function () {
        if ($(this).hasClass('tax-fee') && $(this).attr('tfid') != '') {
            checkCompleteThisTT($(this), 0)
        }
    })
    canApprove()
}
function deleteElementTT(row) {
    if (row.parent('tbody').parent('table').hasClass('r-space-tt')) {
        actual_table = $('.r-space-tt')
    } else {
        actual_table = $('.r-space-yy')
    }
    if (actual_table.find('.tax-fee').length == 1) {
        deleteEventsTT()

        clone = actual_table.find('.duplicateTaxFee').clone()
        clone.removeClass('d-none')
        clone.removeClass('duplicaTaxFee')
        clone.addClass('tax-fee')
        actual_table.find('.duplicateTaxFee').after(clone)
        refreshEventsTT()
    }
    row.removeClass('tax-fee')
    row.attr('changet', '2')
    row.addClass('d-none')
    row.addClass('deleteThisTT')
    updateTaxFee()
}
function updateTaxFee() {
    tr = $('.r-space-tt').find('.tax-fee')
    tf_total = 0;
    tf_aux = 0;
    tr.each(function () {
        if ($(this).attr('tfid') != '' || $(this).attr('changet') == '1') {
            if ($(this).find('.editAmountTT').find('.amountToSum').val().trim() != "") {
                tf_total = parseFloat($(this).find('.editAmountTT').find('.amountToSum').val()) + tf_total
            }
            tf_aux++;
        }
    })
    if (tf_aux == 0) {
        $('#myTaxFee').find('td:eq(2)').find('g').text("")
        $('#myTaxFee').find('td:eq(2)').find('input:eq(0)').val("")
    } else {
        aux = getSymbolCode()
        $('#myTaxFee').find('td:eq(2)').find('g').text(formatNumber(tf_total.toFixed(2)) + " " + aux[1])
        $('#myTaxFee').find('td:eq(2)').find('input:eq(0)').val(tf_total)
    }
    $('#myTaxFee').find('td:eq(2)').find('g').addClass('mb');
    if (tf_total != 0) {
        $('#myTaxFee').find('td:eq(2)').find('g').addClass('text-light');
        $('#myTaxFee').find('td:eq(2)').removeClass('text-danger');
    } else {
        $('#myTaxFee').find('td:eq(2)').find('g').removeClass('text-light');
    }
    updateTax()
}
function updateTax() {
    if (tr.parent('tbody').parent('table').hasClass('r-space-tt')) {

        tr_tax = $('.r-space-yy').find('.tax-fee')
        tr_tax.each(function () {
            if ($(this).find('.editPercentageTT').find('input:eq(0)').val().trim() != "") {
                selectCellsTT($(this))
            } else if ($(this).find('.editAmountTT').find('input:eq(0)').val().trim() != "") {
                selectCellsTTA($(this))
            }
        })
    }
    tr = $('.r-space-yy').find('.tax-fee')
    tf_total = 0;
    tf_aux = 0;
    tr.each(function () {
        if ($(this).attr('tfid') != '' || $(this).attr('changet') == '1') {
            if ($(this).find('.editAmountTT').find('.amountToSum').val().trim() != "") {
                tf_total = parseFloat($(this).find('.editAmountTT').find('.amountToSum').val()) + tf_total
            }
            tf_aux++;
        }
    })
    if (tf_aux == 0) {
        $('#myTax').find('td:eq(2)').find('g').text("")
        $('#myTax').find('td:eq(2)').find('input:eq(0)').val("")
    } else {
        aux = getSymbolCode()
        $('#myTax').find('td:eq(2)').find('g').text(formatNumber(tf_total.toFixed(2)) + " " + aux[1])
        $('#myTax').find('td:eq(2)').find('input:eq(0)').val(tf_total)
    }
    $('#myTax').find('td:eq(2)').find('g').addClass('mb');
    if (tf_total != 0) {
        $('#myTax').find('td:eq(2)').find('g').addClass('text-light');
        $('#myTax').find('td:eq(2)').removeClass('text-danger');
    } else {
        $('#myTax').find('td:eq(2)').find('g').removeClass('text-light');
    }
    updateTotalCost(aux[1])
}
function updateTotalCost(code) {
    t_fee = $('#myTaxFee').find('td:eq(2)').find('input:eq(0)').val()
    t_tax = $('#myTax').find('td:eq(2)').find('input:eq(0)').val()
    t_product = $('#myBudget').find('td:eq(2)').find('input:eq(0)').val()
    if (t_fee.trim() != "" || t_tax.trim() != "" || t_product != "") {
        if (t_fee.trim() == "")
            tt_fee = 0
        else
            tt_fee = parseFloat(t_fee)
        if (t_tax.trim() == "")
            tt_tax = 0
        else
            tt_tax = parseFloat(t_tax)
        if (t_product.trim() == "")
            tt_product = 0
        else
            tt_product = parseFloat(t_product)
        sum = tt_product + tt_fee + tt_tax

        $('#total-cost').text(formatNumber(sum.toFixed(2)) + " " + code)
    } else
        $('#total-cost').text("")
}