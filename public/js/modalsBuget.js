
var emailF = true
var nameF = true
var radioF = true




function validationSaveModal() {





    var spanName = $('#errorNameUser')
    var spanEmail = $('#errorEmailUserXX')
    var spanVendor = $('#errorVendor');


    if ($('#input-name').val() == '') {
        spanName.removeClass("d-none");
        spanName.addClass("error text-danger");
        nameF = false

    } else {
        nameF = true
        spanName.removeClass("error text-danger");
        spanName.addClass("d-none");

    }

    if ($('#input-email').val() == '') {
        spanEmail.removeClass("d-none");
        spanEmail.addClass("error text-danger");
        emailF = false

    } else {
        emailF = true
        spanEmail.removeClass("error text-danger");
        spanEmail.addClass("d-none");
    }


    if (document.getElementById('radio1X').checked == true || document.getElementById('radio2X').checked == true) {
        spanVendor.removeClass("error text-danger");
        spanVendor.addClass("d-none");
        radioF = true
    } else {
        spanVendor.removeClass("d-none");
        spanVendor.addClass("error text-danger");
        radioF = false
    }


    if (emailF == true && nameF == true && radioF == true) {
        $('#saveUserModal').click()
    }
}

function validationSaveModalSection() {
    //budgetsection/addSection}

    var erroName = $('#errorNameSection')
    var erroCode = $('#errorCodeSection')
    var flagName = true
    var flagCode = true

    if ($('#input-code-section').val() == '') {
        erroCode.removeClass('d-none')
        flagCode = false
    } else {
        erroCode.addClass('d-none')
        flagCode = true
    }


    if ($('#input-name-section').val() == '') {
        erroName.removeClass('d-none')
        flagName = false
    } else {
        erroName.addClass('d-none')
        flagName = true
    }

    if ((flagName == true) && (flagCode == true)) {

        var routeRequest = mainRoute + "budgetsection/addSection";
        $.ajax({
            type: 'post',
            url: routeRequest,
            data: {
                name: $('#input-name-section').val(),
                code: $('#input-code-section').val(),
            },
            success: function (results) {

                if (results.section_save) {

                    deleteEvents()
                    if (results.section_code == "900") {
                        $('#toCreateSection').remove()
                    }
                    new_section = $('.toCloneSection').clone()
                    new_section.removeClass('toCloneSection')
                    new_section.addClass('belongsBudget')
                    new_section.attr('section', results.section_id)
                    new_section.attr('id', "mySection" + results.section_id)
                    new_section.find('td:eq(0)').find('a:eq(0)').append('<i class="material-icons">keyboard_arrow_down</i>' + results.section_code)
                    new_section.find('td:eq(1)').find('a:eq(0)').text(results.section_name)
                    budget = $('#myBudget')
                    if (!budget.hasClass('d-none') && budget.attr('status') == '1') {
                        new_section.removeClass('d-none')
                    }
                    if ($('.belongsBudget').length == 0) {
                        budget.after(new_section)
                    } else {
                        section_id = $('.belongsBudget').last().attr('section')
                        if ($('.belongsSection' + section_id).length == 0) {
                            $('.belongsBudget').last().after(new_section)
                        } else {
                            block_id = $('.belongsSection' + section_id).last().attr('block')
                            if ($('.belongsBlock' + block_id).length == 0) {
                                $('.belongsSection' + section_id).last().after(new_section)
                            } else {
                                if ($('.belongsBlock' + block_id).last().hasClass('uni')) {
                                    $('.belongsBlock' + block_id).last().after(new_section)
                                }
                                else {
                                    account = $('.belongsBlock' + block_id).last().attr('account')
                                    console.log(account)
                                    $('.belongsAccount' + account).last().after(new_section)
                                }
                            }
                        }
                    }


                    $('#budSectionModal').append('<option value=\"' + results.section_id + '\">' + results.section_code + ' ' + results.section_name + '</option>')
                    $('#input-code-section').val('')
                    $('#input-name-section').val('')
                    document.getElementById('lastCodeSection').innerHTML = results.section_code
                    $('#closeModalSection').click()
                    // document.getElementById('accordion').innerHTML += htmlSection

                    swal({
                        title: document.getElementById('modalSectionText01').innerHTML,
                        confirmButtonText: document.getElementById('modalSectionText02').innerHTML,
                        confirmButtonClass: 'btn btn-info',
                        type: "success"
                    });

                    refreshEvents()

                } else {

                    swal({
                        title: results.error_message,
                        confirmButtonText: document.getElementById('modalSectionText02').innerHTML,
                        confirmButtonClass: 'btn btn-info',
                        type: 'error',
                    });

                }
            }
        });

    }


}



function validationSaveModalSectionTree() {
    //budgetsection/addSection}

    var erroName = $('#errorNameSection')
    var erroCode = $('#errorCodeSection')
    var flagName = true
    var flagCode = true

    if ($('#input-code-section').val() == '') {
        erroCode.removeClass('d-none')
        flagCode = false
    } else {
        erroCode.addClass('d-none')
        flagCode = true
    }


    if ($('#input-name-section').val() == '') {
        erroName.removeClass('d-none')
        flagName = false
    } else {
        erroName.addClass('d-none')
        flagName = true
    }

    if ((flagName == true) && (flagCode == true)) {

        var routeRequest = mainRoute + "budgetsection/addSection";
        $.ajax({
            type: 'post',
            url: routeRequest,
            data: {
                name: $('#input-name-section').val(),
                code: $('#input-code-section').val(),
            },
            success: function (results) {

                if (results.section_save) {
                    var htmlSection =
                        '<div class="card-collapse">' +
                        '<div class="card-header" role="tab" id="head' + results.section_id + '">' +
                        '<h5 class="mb-0">' +
                        '<table class="table table-striped table-no-bordered table-hover r-space">' +
                        '<tr style="background-color: #5094c7">' +
                        '<h1 id="sectionDataName' + results.section_id + '" class="d-none">' + results.section_name + '</h1>' +
                        '<h1 id="sectionDataCode' + results.section_id + '" class="d-none">' + results.section_code + '</h1>' +
                        '<h1 id="sectionDataCount' + results.section_id + '" class="d-none">0</h1>' +
                        '<td id="tdSection' + results.section_id + '" WIDTH="100%"><a class="collapsed text-light" data-toggle="collapse" href="#collapse' + results.section_id + '" aria-expanded="false" aria-controls="collapse' + results.section_id + '">' +
                        '' + results.section_code + ' | ' + results.section_name + '' +
                        '<i name="allId" class="material-icons float-right">keyboard_arrow_down</i>' +
                        '</a>' +
                        '</td>' +
                        '<td class="td-actions text-center">' +
                        '<p onclick="editTree(' + "'section'" + ', ' + results.section_id + ', null);"  class="btn btn-white" >' +
                        '<i class="material-icons" >edit</i>' +
                        '</p>' +
                        '</td>' +
                        '</tr></table> ' +
                        '</h5>' +
                        '</div>' +
                        '<div id="collapse' + results.section_id + '" class="collapse" style="margin-left: 50px; margin-right: 50px;" role="tabpanel" aria-labelledby="head' + results.section_id + '" data-parent="#accordion">' +
                        '<div class="card-body">' +
                        '<div id="accordion2' + results.section_id + '" role="tablist">' +
                        '</div> ' +
                        '</div>' +
                        '</div>' +
                        '</div>'



                    $('#budSectionModal').append('<option value=\"' + results.section_id + '\">' + results.section_code + ' ' + results.section_name + '</option>')
                    $('#budSectionModalEditTree').append('<option value=\"' + results.section_id + '\">' + results.section_code + ' ' + results.section_name + '</option>')
                    $('#input-code-section').val('')
                    $('#input-name-section').val('')
                    document.getElementById('lastCodeSection').innerHTML = results.section_code
                    document.getElementById('lastCodeSectionTree').innerHTML = results.section_code
                    $('#closeModalSection').click()
                    document.getElementById('accordion').innerHTML += htmlSection

                    swal({
                        title: document.getElementById('modalSectionText01').innerHTML,
                        confirmButtonText: document.getElementById('modalSectionText02').innerHTML,
                        confirmButtonClass: 'btn btn-info',
                        type: "success"
                    });

                } else {

                    swal({
                        title: results.error_message,
                        confirmButtonText: document.getElementById('modalSectionText02').innerHTML,
                        confirmButtonClass: 'btn btn-info',
                        type: 'error',
                    });

                }
            }
        });

    }


}




function nextCodeSection() {
    if ($('#budSectionModal').attr('status') == 0) {
        idSection = $('#budSectionModal').find('option:selected').val();
        var routeRequest = mainRoute + "budgetSection/nextCode/" + idSection;
        $.get(routeRequest, function (res) {
            $('#input-code-block').val(res);
            if (isNaN(res)) {
                $('#errorCodeBlock').removeClass('d-none')
                $('#addBlock').addClass('disabled')
            } else {
                $('#errorCodeBlock').addClass('d-none')
                $('#addBlock').removeClass('disabled')
            }
        });
    }
}


function validationSaveModalBlock() {

    var erroNameBlock = $('#errorNameBlock')
    var erroSectionBlock = $('#errorSectionBlock')
    var flagNameBlock = true
    var flagSectionBlock = true

    if ($('#budSectionModal').find('option:selected').val() == '') {
        erroSectionBlock.removeClass('d-none')
        flagSectionBlock = false
    } else {
        erroSectionBlock.addClass('d-none')
        flagSectionBlock = true
    }


    if ($('#input-name-block').val() == '') {
        erroNameBlock.removeClass('d-none')
        flagNameBlock = false
    } else {
        erroNameBlock.addClass('d-none')
        flagNameBlock = true
    }


    if ((flagSectionBlock == true) && (flagNameBlock == true)) {
        //console.log('sen request')
        //budgetBlock/addBlock

        var routeRequest = mainRoute + "budgetBlock/addBlock";
        $.ajax({
            type: 'post',
            url: routeRequest,
            data: {
                name: $('#input-name-block').val(),
                code: $('#input-code-block').val(),
                budget_section_id: $('#budSectionModal').find('option:selected').val(),
            },
            success: function (results) {

                if (results.block_save) {
                    deleteEvents()

                    new_block = $('.toCloneBlock').clone()
                    new_block.removeClass('toCloneBlock')
                    new_block.addClass('belongsSection' + results.block_budget_section_id)
                    new_block.attr('block', results.block_id)
                    new_block.attr('section', results.block_budget_section_id)
                    new_block.attr('id', "myBlock" + results.block_id)
                    new_block.find('td:eq(0)').find('a:eq(0)').append('<i class="material-icons">keyboard_arrow_down</i>' + results.block_code)
                    new_block.find('td:eq(1)').find('a:eq(0)').text(results.block_name)
                    section = $('#mySection' + results.block_budget_section_id)
                    if (!section.hasClass('d-none') && section.attr('status') == '1') {
                        new_block.removeClass('d-none')
                    }
                    if ($('.belongsSection' + results.block_budget_section_id).length == 0) {
                        section.after(new_block)
                    } else {
                        block_id = $('.belongsSection' + results.block_budget_section_id).last().attr('block')
                        if ($('.belongsBlock' + block_id).length == 0) {
                            $('.belongsSection' + results.block_budget_section_id).last().after(new_block)
                        } else {
                            if ($('.belongsBlock' + block_id).last().hasClass('uni')) {
                                $('.belongsBlock' + block_id).last().after(new_block)
                            }
                            else {
                                account = $('.belongsBlock' + block_id).last().attr('account')
                                console.log(account)
                                $('.belongsAccount' + account).last().after(new_block)
                            }
                        }
                    }

                    $('#budAccountModal').append('<option value=\"' + results.block_id + '\">' + results.block_code + ' ' + results.block_name + '</option>')
                    $('#input-code-block').val('')
                    $('#input-name-block').val('')
                    $("#budSectionModal").attr('status', '1')
                    $("#budSectionModal").val('').trigger('change');
                    $("#budSectionModal").attr('status', '0')
                    $('#closeModalBlock').click()
                    // document.getElementById('accordion2' + results.block_budget_section_id).innerHTML += htmlBlock

                    swal({
                        title: document.getElementById('modalBlockText01').innerHTML,
                        confirmButtonText: document.getElementById('modalBlockText02').innerHTML,
                        confirmButtonClass: 'btn btn-info',
                        type: "success"
                    });
                    refreshEvents()
                } else {

                    swal({
                        title: results.error_message,
                        confirmButtonText: document.getElementById('modalBlockText02').innerHTML,
                        confirmButtonClass: 'btn btn-info',
                        type: 'error',
                    });

                }
            }
        });

    }

}


function validationSaveModalBlockTree() {

    var erroNameBlock = $('#errorNameBlock')
    var erroSectionBlock = $('#errorSectionBlock')
    var flagNameBlock = true
    var flagSectionBlock = true

    if ($('#budSectionModal').find('option:selected').val() == '') {
        erroSectionBlock.removeClass('d-none')
        flagSectionBlock = false
    } else {
        erroSectionBlock.addClass('d-none')
        flagSectionBlock = true
    }


    if ($('#input-name-block').val() == '') {
        erroNameBlock.removeClass('d-none')
        flagNameBlock = false
    } else {
        erroNameBlock.addClass('d-none')
        flagNameBlock = true
    }


    if ((flagSectionBlock == true) && (flagNameBlock == true)) {
        //console.log('sen request')
        //budgetBlock/addBlock

        var routeRequest = mainRoute + "budgetBlock/addBlock";
        $.ajax({
            type: 'post',
            url: routeRequest,
            data: {
                name: $('#input-name-block').val(),
                code: $('#input-code-block').val(),
                budget_section_id: $('#budSectionModal').find('option:selected').val(),
            },
            success: function (results) {

                if (results.block_save) {
                    var htmlBlock =
                        '<div class="card-collapse">' +
                        '<div class="card-header" role="tab" id="head2' + results.block_id + '">' +
                        '<h5 class="mb-0">' +
                        '<table class="table table-striped table-no-bordered table-hover r-space">' +
                        '<tr style="background-color: #d2e9fc">' +
                        '<h1 id="blockDataName' + results.block_id + '" class="d-none">' + results.block_name + '</h1>' +
                        '<h1 id="blockDataCode' + results.block_id + '" class="d-none">' + results.block_code + '</h1>' +
                        '<h1 id="blockDataCount' + results.block_id + '" class="d-none">0</h1>' +
                        '<td id="tdBlock' + results.block_id + '" WIDTH="100%" >' +
                        '<a class="collapsed text-dark" data-toggle="collapse" href="#collapse2' + results.block_id + '" aria-expanded="false" aria-controls="collapse2' + results.block_id + '">' +
                        '' + results.block_code + ' | ' + results.block_name + '' +
                        '<i name="allId" class="material-icons">keyboard_arrow_down</i>' +
                        '</a></td>' +
                        '<td class="td-actions text-center">' +
                        '<p onclick="editTree(' + "'block', " + '' + results.block_id + ', ' + results.block_budget_section_id + ');"  class="btn btn-link btn-gray" >' +
                        '<i class="material-icons" >edit</i>' +
                        '</p>' +
                        '</td>' +
                        '</tr>' +
                        '</table>' +
                        '</h5>' +
                        '</div>' +
                        '<div id="collapse2' + results.block_id + '"  class="collapse" role="tabpanel" aria-labelledby="head2' + results.block_id + '" data-parent="#accordion2">' +
                        '<div id="account' + results.block_id + '" class="card-body" style="margin-left: 50px; margin-right: 50px;">' +

                        '</div>' +
                        '</div>' +
                        '</div> '




                    $('#budAccountModal').append('<option value=\"' + results.block_id + '\">' + results.block_code + ' ' + results.block_name + '</option>')
                    $('#budAccountModalTree').append('<option value=\"' + results.block_id + '\">' + results.block_code + ' ' + results.block_name + '</option>')
                    newSectiocValor = Number(document.getElementById('sectionDataCount' + results.block_budget_section_id).innerHTML)
                    document.getElementById('sectionDataCount' + results.block_budget_section_id).innerHTML = newSectiocValor + 1
                    $('#input-code-block').val('')
                    $('#input-name-block').val('')
                    $("#budSectionModal").attr('status', '1')
                    $("#budSectionModal").val('').trigger('change');
                    $("#budSectionModal").attr('status', '0')
                    $('#closeModalBlock').click()
                    document.getElementById('accordion2' + results.block_budget_section_id).innerHTML += htmlBlock

                    swal({
                        title: document.getElementById('modalBlockText01').innerHTML,
                        confirmButtonText: document.getElementById('modalBlockText02').innerHTML,
                        confirmButtonClass: 'btn btn-info',
                        type: "success"
                    });

                } else {

                    swal({
                        title: results.error_message,
                        confirmButtonText: document.getElementById('modalBlockText02').innerHTML,
                        confirmButtonClass: 'btn btn-info',
                        type: 'error',
                    });

                }
            }
        });

    }

}



function nextCode() {
    if ($('#budAccountModal').attr('status') == 0) {
        idBlock = $('#budAccountModal').find('option:selected').val();
        var routeRequest = mainRoute + "budgetaccount/nextCode/" + idBlock;
        $.get(routeRequest, function (res) {
            $('#input-code-account').val(res);
        });
    }
}


function validationSaveModalAccount() {

    var errorNameAccount = $('#errorNameAccount')
    var errorBlockAccount = $('#errorBlockAccount')
    var flagNameAccount = true
    var flagBlockAccount = true

    if ($('#budAccountModal').find('option:selected').val() == '') {
        errorBlockAccount.removeClass('d-none')
        flagBlockAccount = false
    } else {
        errorBlockAccount.addClass('d-none')
        flagBlockAccount = true
    }


    if ($('#input-name-account').val() == '') {
        errorNameAccount.removeClass('d-none')
        flagNameAccount = false
    } else {
        errorNameAccount.addClass('d-none')
        flagNameAccount = true
    }


    if ((flagBlockAccount == true) && (flagNameAccount == true)) {
        var routeRequest = mainRoute + "budgetAccount/addAccount";
        $.ajax({
            type: 'post',
            url: routeRequest,
            data: {
                name: $('#input-name-account').val(),
                code: $('#input-code-account').val(),
                budget_block_id: $('#budAccountModal').find('option:selected').val(),
            },
            success: function (results) {

                if (results.account_save) {
                    deleteEvents()

                    new_account = $('.toCloneAccount').clone()
                    new_account.removeClass('toCloneAccount')
                    new_account.addClass('belongsBlock' + results.account_budget_block_id)
                    new_account.attr('account', results.account_id)
                    new_account.attr('block', results.account_budget_block_id)
                    new_account.find('td:eq(0)').text(results.account_budgetBlockCode + results.account_code)
                    new_account.find('td:eq(0)').append('<input type="hidden" value="A">')
                    new_account.find('td:eq(1)').text(results.account_name)
                    block = $('#myBlock' + results.account_budget_block_id)
                    if (!block.hasClass('d-none') && block.attr('status') == '1') {
                        new_account.removeClass('d-none')
                    }
                    if ($('.belongsBlock' + results.account_budget_block_id).length == 0) {
                        block.after(new_account)
                    } else {
                        if ($('.belongsBlock' + results.account_budget_block_id).last().hasClass('uni')) {
                            $('.belongsBlock' + results.account_budget_block_id).last().after(new_account)
                        }
                        else {
                            account = $('.belongsBlock' + results.account_budget_block_id).last().attr('account')
                            console.log(account)
                            $('.belongsAccount' + account).last().after(new_account)
                        }
                    }

                    $('#input-code-account').val('')
                    $('#input-name-account').val('')
                    $("#budAccountModal").attr('status', '1')
                    $("#budAccountModal").val('').trigger('change');
                    $("#budAccountModal").attr('status', '0')
                    $('#closeModalAccount').click()
                    // document.getElementById('accordion3' + results.account_budget_block_id).innerHTML += htmlAccount

                    swal({
                        title: document.getElementById('modalAccountText01').innerHTML,
                        confirmButtonText: document.getElementById('modalAccountText02').innerHTML,
                        confirmButtonClass: 'btn btn-info',
                        type: "success"
                    });

                    refreshEvents()

                } else {

                    swal({
                        title: results.error_message,
                        confirmButtonText: document.getElementById('modalAccountText02').innerHTML,
                        confirmButtonClass: 'btn btn-info',
                        type: 'error',
                    });

                }
            }
        });

    }

}


function validationSaveModalAccountTree() {

    var errorNameAccount = $('#errorNameAccount')
    var errorBlockAccount = $('#errorBlockAccount')
    var flagNameAccount = true
    var flagBlockAccount = true

    if ($('#budAccountModal').find('option:selected').val() == '') {
        errorBlockAccount.removeClass('d-none')
        flagBlockAccount = false
    } else {
        errorBlockAccount.addClass('d-none')
        flagBlockAccount = true
    }


    if ($('#input-name-account').val() == '') {
        errorNameAccount.removeClass('d-none')
        flagNameAccount = false
    } else {
        errorNameAccount.addClass('d-none')
        flagNameAccount = true
    }


    if ((flagBlockAccount == true) && (flagNameAccount == true)) {
        var routeRequest = mainRoute + "budgetAccount/addAccount";
        $.ajax({
            type: 'post',
            url: routeRequest,
            data: {
                name: $('#input-name-account').val(),
                code: $('#input-code-account').val(),
                budget_block_id: $('#budAccountModal').find('option:selected').val(),
            },
            success: function (results) {

                if (results.account_save) {
                    var htmlAccount =
                        '<div id="divAccountInfo' + results.account_id + '" class="row" style="background-color: #zzzzzz">' +
                        '<h1 id="accountDataName' + results.account_id + '" class="d-none">' + results.account_name + '</h1>' +
                        '<h1 id="accountDataCode' + results.account_id + '" class="d-none">' + results.account_code + '</h1>' +
                        '<h1 id="accountDataCount' + results.account_id + '" class="d-none">0</h1>' +
                        '<div id="accounRefresh' + results.account_id + '" class="col-8" style="display: block; margin-top: auto; margin-bottom: auto">' + results.account_budgetBlockCode + '' + results.account_code + ' | ' + results.account_name + '</div>' +
                        '<div class="col-4" style="display: block; margin-top: auto; margin-bottom: auto">' +
                        '<p onclick="editTree(' + "'account', " + results.account_id + ', ' + results.account_budget_block_id + ');"  class="btn btn-link btn-sm btn-fab" >' +
                        '<i class="material-icons">edit</i>' +
                        '</p>' +
                        '</div>' +
                        '</div>'


                    newSectiocValor = Number(document.getElementById('blockDataCount' + results.account_budget_block_id).innerHTML)
                    document.getElementById('blockDataCount' + results.account_budget_block_id).innerHTML = newSectiocValor + 1
                    $('#input-code-account').val('')
                    $('#input-name-account').val('')
                    $("#budAccountModal").attr('status', '1')
                    $("#budAccountModal").val('').trigger('change');
                    $("#budAccountModal").attr('status', '0')
                    $('#closeModalAccount').click()
                    document.getElementById('account' + results.account_budget_block_id).innerHTML += htmlAccount


                    swal({
                        title: document.getElementById('modalAccountText01').innerHTML,
                        confirmButtonText: document.getElementById('modalAccountText02').innerHTML,
                        confirmButtonClass: 'btn btn-info',
                        type: "success"
                    });

                } else {

                    swal({
                        title: results.error_message,
                        confirmButtonText: document.getElementById('modalAccountText02').innerHTML,
                        confirmButtonClass: 'btn btn-info',
                        type: 'error',
                    });

                }
            }
        });

    }

}





