function changeCurrency(field) {
    if ($('#is_updated').val() == '1') {
        saveMeSelect(field);
    }
    totalCombo()
}
function totalCombo() {
    aux = getSymbolCode()
    updateSubaccounts(aux[0], aux[1]);
    updateAccounts(aux[0], aux[1]);
    updateBlocks(aux[0], aux[1]);
    updateSections(aux[0], aux[1]);
    updateBudget(aux[0], aux[1]);
    checkCompleteAll()
}
function getSymbolCode() {
    actual = $('#show_currency').find('option:selected').val()
    if (actual != '0') {
        index = parseFloat(actual) - 1
    } else {
        index = parseFloat($('#currency').find('option:selected').val())
    }
    array_codes = ['MXN', 'USD', 'EUR'];
    array_symbols = ['$', '$', '€'];
    return [array_symbols[index], array_codes[index]]
}
function updateSubaccounts() {
    tr = $('.mylines').find('tr')
    tr.each(function () {
        if ($(this).hasClass('mult') || $(this).hasClass('uni') && $(this).attr('change') != '2') {
            selectCells($(this))
            actual = $('#show_currency').find('option:selected').val()
            c_budget = $(this).find('.editCurrency').find('input:eq(0)').val()
            if (c_budget.trim() != '') {
                if (actual != '0') {
                    array_codes = ['MXN', 'USD', 'EUR'];
                    text = array_codes[parseFloat(actual) - 1]
                } else {
                    text = array_codes[parseFloat(c_budget)]
                }
            } else {
                text = ""
            }
            $(this).find('.editCurrency').find('.textCurrency').text(text)
        }
    })
}
function conversion(cost, account_c) {
    // console.log(cost + account_c)
    array_fields = ['mxn_equivalence', 'usd_equivalence', 'eur_equivalence'];
    array_symbols = ['$', '$', '€'];
    array_codes = ['MXN', 'USD', 'EUR'];
    show_currency = $('#show_currency').find('option:selected').val();

    //To pass mexican pesos
    a_currency = parseFloat($('#p_' + [array_fields[account_c]]).val());
    b_currency = parseFloat($('#p_' + [array_fields[(parseFloat(show_currency) - 1)]]).val());
    base = cost * a_currency;
    //To pas the budget currency
    aux_cost = (base / b_currency);
    return [array_symbols[(parseFloat(show_currency) - 1)], aux_cost.toFixed(2), array_codes[(parseFloat(show_currency) - 1)]];
}

function currencyValues(cost, account_c) {
    array_fields = ['mxn_equivalence', 'usd_equivalence', 'eur_equivalence'];
    array_symbols = ['$', '$', '€'];
    array_codes = ['MXN', 'USD', 'EUR'];

    return [array_symbols[account_c], cost.toFixed(2), array_codes[account_c]];
}
///////////////////////////////////////////////////////////////////////////////////////////////////
function updateAccounts(symbol, code) {
    $(".myAccount").each(function () {
        saccounts = $('.belongsAccount' + $(this).attr('account'))
        total = 0;
        aux_c = 0;
        saccounts.each(function () {
            if ($(this).find('.totalCost').find('input:eq(0)').val() != "") {
                total = total + parseFloat($(this).find('.totalCost').find('input:eq(0)').val())
                aux_c++;
            }
        })
        changeLastCell($(this), total, symbol, code, aux_c)
    })
}
function updateBlocks(symbol, code) {
    $(".myBlock").each(function () {
        accounts = $('.belongsBlock' + $(this).attr('block'))
        total = 0;
        aux_c = 0;
        accounts.each(function () {
            if ($(this).find('.totalCost').find('input:eq(0)').val() != "") {
                total = total + parseFloat($(this).find('.totalCost').find('input:eq(0)').val())
                aux_c++;
            }
        })
        changeLastCell($(this), total, symbol, code, aux_c)

    })
}
function updateSections(symbol, code) {
    $(".mySection").each(function () {
        blocks = $('.belongsSection' + $(this).attr('section'))
        total = 0;
        aux_c = 0;
        blocks.each(function () {
            if ($(this).find('.totalCost').find('input:eq(0)').val() != "") {
                total = total + parseFloat($(this).find('.totalCost').find('input:eq(0)').val())
                aux_c++;
            }
        })
        changeLastCell($(this), total, symbol, code, aux_c)
    })
}
function updateBudget(symbol, code) {
    budget = $('#myBudget')
    sections = $('.belongsBudget')
    total = 0;
    aux_c = 0
    sections.each(function () {
        if ($(this).find('.totalCost').find('input:eq(0)').val() != "") {
            total = total + parseFloat($(this).find('.totalCost').find('input:eq(0)').val())
            aux_c++;
        }
    })
    changeLastCell(budget, total, symbol, code, aux_c)

}
function convertBudgetCurrency(cost, account_c) {
    array_fields = ['mxn_equivalence', 'usd_equivalence', 'eur_equivalence'];
    array_symbols = ['$', '$', '€'];
    array_codes = ['MXN', 'USD', 'EUR'];
    currency = $('#currency').find('option:selected').val();

    //To pass mexican pesos
    a_currency = parseFloat($('#p_' + [array_fields[account_c]]).val());
    b_currency = parseFloat($('#p_' + [array_fields[(parseFloat(currency))]]).val());
    base = cost * a_currency;
    //To pas the budget currency
    aux_cost = (base / b_currency);
    return [array_symbols[(parseFloat(currency))], aux_cost.toFixed(2), array_codes[(parseFloat(currency))]];
}
////Functions to change the budget currency
function updateEquivalences(id, r) {//id for currency and r for content returned
    array_currency = ['MXN', 'USD', 'EUR'];
    fix = 4;
    if (id == '0') {
        $('#c_mxn').addClass('d-none');
        $('#c_usd').removeClass('d-none');
        $('#c_eur').removeClass('d-none');

    } else if (id == '1') {
        $('#c_mxn').removeClass('d-none');
        $('#c_usd').addClass('d-none');
        $('#c_eur').removeClass('d-none');
    } else {
        $('#c_mxn').removeClass('d-none');
        $('#c_usd').removeClass('d-none');
        $('#c_eur').addClass('d-none');
    }
    $('.l-currency').text(array_currency[id]);

    $('#mxn_equivalence').val(r[0].toFixed(fix));
    $('#usd_equivalence').val(r[1].toFixed(fix));
    $('#eur_equivalence').val(r[2].toFixed(fix));
    $('#p_mxn_equivalence').val(r[0].toFixed(fix));
    $('#p_usd_equivalence').val(r[1].toFixed(fix));
    $('#p_eur_equivalence').val(r[2].toFixed(fix));
    totalCombo()

}
function checkEquivalences(field) {
    if (field == "nxm_equivalence" || field == "usd_equivalence" || field == "eur_equivalence") {
        totalCombo()
    }

}
function updateTop(type, id) {
    aux = getSymbolCode()
    symbol = aux[0]
    code = aux[1]

    if (type == 'account') {
        account = $('#myAccount' + id)
        saccounts = $('.belongsAccount' + id)
        total = 0;
        aux_c = 0;
        saccounts.each(function () {
            if ($(this).find('.totalCost').find('input:eq(0)').val() != "") {
                total = total + parseFloat($(this).find('.totalCost').find('input:eq(0)').val())
                aux_c++;
            }
        })
        changeLastCell(account, total, symbol, code, aux_c)
        idBlock = account.attr('block')
    } else {
        idBlock = id;
    }
    block = $('#myBlock' + idBlock)
    accounts = $('.belongsBlock' + idBlock)
    total = 0;
    aux_c = 0;
    accounts.each(function () {
        if ($(this).find('.totalCost').find('input:eq(0)').val() != "") {
            total = total + parseFloat($(this).find('.totalCost').find('input:eq(0)').val())
            aux_c++;
        }
    })
    changeLastCell(block, total, symbol, code, aux_c)
    idSection = block.attr('section')

    section = $('#mySection' + idSection)
    blocks = $('.belongsSection' + idSection)
    total = 0;
    aux_c = 0;
    blocks.each(function () {
        if ($(this).find('.totalCost').find('input:eq(0)').val() != "") {
            total = total + parseFloat($(this).find('.totalCost').find('input:eq(0)').val())
            aux_c++;
        }
    })
    changeLastCell(section, total, symbol, code, aux_c)
    updateBudget(symbol, code);
}
function changeLastCell(row, total, symbol, code, aux_c) {
    if (row.attr('id') == 'myBudget') {
        row.find('td:eq(2)').find('g').empty()
        row.find('td:eq(2)').find('g').addClass('totalCost')
    } else {
        row.find('td:eq(2)').empty()
        row.find('td:eq(2)').addClass('totalCost')
    }
    if (aux_c > 0) {
        if (row.attr('id') == 'myBudget') {
            row.find('td:eq(2)').find('g').text(formatNumber(total.toFixed(2)) + ' ' + code)
            row.find('td:eq(2)').find('input:eq(0)').val(total)
        }
        else {
            row.find('td:eq(2)').text(formatNumber(total.toFixed(2)))
            row.find('td:eq(2)').append("<input type='hidden' value='" + total + "'/>")
        }
    } else {
        if (row.attr('id') == 'myBudget') {
            row.find('td:eq(2)').find('g').text("")
            row.find('td:eq(2)').find('input:eq(0)').val("")

        } else {
            row.find('td:eq(2)').append("<input type='hidden' value=''/>")
        }
    }
    if (row.hasClass('mySection') || row.attr('id') == 'myBudget')
        row.find('td:eq(2)').addClass('text-light');
    if (row.hasClass('myBlock'))
        row.find('td:eq(2)').addClass('text-dark');

    if (row.attr('id') == 'myBudget') {
        updateAmount()
        checkCompleteAllTT()
        updateTaxFee()
    }
}
function checkCompleteAll() {
    tr = $('.mylines').find('tr')
    tr.each(function () {
        if ($(this).hasClass('mult') || $(this).hasClass('uni') && $(this).attr('bva') != '')
            checkCompleteThis($(this), 0)
    })
    canApprove()
}
function checkCompleteThis(row, can) {
    if (row.hasClass('client')) {
        cleanClientRow(row)
        row.removeClass('rowNotComplete')
    }
    else if (!checkRowComplete(row))
        row.addClass('rowNotComplete')
    else
        row.removeClass('rowNotComplete')
    if (can == 1)
        canApprove()
}
function canApprove() {
    if ($('.rowNotComplete').length > 0) {
        $('#btnApprove').addClass('d-none')
        $('#btnNotApprove').removeClass('d-none')
    }
    else {
        $('#btnNotApprove').addClass('d-none')
        $('#btnApprove').removeClass('d-none')
    }
}
function checkRowComplete(row) {
    if (row.attr('change') == '0' && row.attr('bva') == '')
        return true
    if (row.hasClass('uni')) {
        plus = 1
    } else {
        plus = 0
    }
    if (row.find('.editCurrency').find('input:eq(0)').val() == "") {
        text = $('#currency').find('option:selected').text();
        id = $('#currency').find('option:selected').val();
        actual = $('#show_currency').find('option:selected').val()
        if (actual != '0') {
            array_codes = ['MXN', 'USD', 'EUR'];
            text = array_codes[parseFloat(actual) - 1]
        }
        row.find('.textCurrency').text(text)
        row.find('.editCurrency').find('input:eq(0)').val(id)
    }
    //Vendor
    if (row.find('td:eq(' + (1 + plus) + ')').find('input').val().trim() == '')
        return false;
    //Description
    if (row.find('td:eq(' + (2 + plus) + ')').find('input').val().trim() == '')
        return false;
    //Quantity
    if (row.find('td:eq(' + (3 + plus) + ')').find('input').val().trim() == '')
        return false;
    if (parseFloat(row.find('td:eq(' + (3 + plus) + ')').find('input').val()) == 0)
        return false;
    //Unit
    if (row.find('td:eq(' + (4 + plus) + ')').find('input').val().trim() == '')
        return false;
    //Quantity
    if (row.find('td:eq(' + (5 + plus) + ')').find('input').val().trim() == '')
        return false;
    if (parseFloat(row.find('td:eq(' + (5 + plus) + ')').find('input').val()) == 0)
        return false;
    //Time
    if (row.find('td:eq(' + (6 + plus) + ')').find('input').val().trim() == '')
        return false;
    //Unit cost
    if (row.find('td:eq(' + (7 + plus) + ')').find('input').val().trim() == '')
        return false;
    if (parseFloat(row.find('td:eq(' + (7 + plus) + ')').find('input').val()) == 0)
        return false;
    //Currency
    if (row.find('td:eq(' + (8 + plus) + ')').find('input').val().trim() == '')
        return false;
    return true;
}
function integerNumber(obj, e, valor) {
    val = (document.all) ? e.keyCode : e.which;
    if (val > 47 && val < 58) {
        return true;
    } else {
        return false;
    }
}
function positiveNumber(obj, e, valor) {
    val = (document.all) ? e.keyCode : e.which;
    if (val != 45) {
        return true;
    } else {
        return false;
    }
}
function positiveNumberH(obj, e, valor) {
    val = (document.all) ? e.keyCode : e.which;
    if (val != 45) {

        var cad = valor + String.fromCharCode(val);

        var res = cad.split(".");
        if (res.length > 1) {
            if (res[1].length > 2) {
                return false;
            }
        }
        return true;
    } else {
        return false;
    }
}
$('#switchRound').click(function () {
    if ($('#hswitchRound').val() == '0') {
        $('#hswitchRound').val('1')
    } else {
        $('#hswitchRound').val('0')
    }
    totalCombo()
})

function cleanClientRow(row) {
    if (row.hasClass('mult')) {
        aux_sum = 0
    } else {
        aux_sum = 1
    }
    //Description
    row.find('td:eq(' + (2 + aux_sum) + ')').find('div').text('')
    row.find('td:eq(' + (2 + aux_sum) + ')').find('input').val('')
    //Quantity
    row.find('td:eq(' + (3 + aux_sum) + ')').find('div').text('')
    row.find('td:eq(' + (3 + aux_sum) + ')').find('input').val('')
    //Unit
    row.find('td:eq(' + (4 + aux_sum) + ')').find('div').text('')
    row.find('td:eq(' + (4 + aux_sum) + ')').find('input').val('')
    //Quantity
    row.find('td:eq(' + (5 + aux_sum) + ')').find('div').text('')
    row.find('td:eq(' + (5 + aux_sum) + ')').find('input').val('')
    //Time
    row.find('td:eq(' + (6 + aux_sum) + ')').find('g').text('')
    row.find('td:eq(' + (6 + aux_sum) + ')').find('input').val('')
    //Unit cost
    row.find('td:eq(' + (7 + aux_sum) + ')').find('div').text('')
    row.find('td:eq(' + (7 + aux_sum) + ')').find('input').val('')
    //Currency
    row.find('td:eq(' + (8 + aux_sum) + ')').find('g').text('')
    row.find('td:eq(' + (8 + aux_sum) + ')').find('input').val('')
    //Total cost
    row.find('td:eq(' + (9 + aux_sum) + ')').text('')
    row.find('td:eq(' + (9 + aux_sum) + ')').append("<input type='hidden' value=''/>")
    if (row.hasClass('mult')) {
        updateTop('account', row.attr('account'))
    } else {
        updateTop('block', row.attr('block'))
    }
}