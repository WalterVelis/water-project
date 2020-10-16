function editTree(typeBudget, idTypeBudget, idTypeBudgetFather) {

    if (typeBudget == 'section') {

        //NotSection
        $('#titleBlock').addClass('d-none')
        $('#titleAccount').addClass('d-none')
        $('#budgetBlockSectionDiv').addClass('d-none')
        $('#budgetBlockCodeDiv').addClass('d-none')
        $('#budgetAccountBlockDiv').addClass('d-none')
        $('#budgetAccountCodeDiv').addClass('d-none')
        $('#editBlockLogic').addClass('d-none')
        $('#editAccountLogic').addClass('d-none')
        //

        if (Number(document.getElementById('sectionDataCount' + idTypeBudget).innerHTML) > 0) {
            document.getElementById('input-code-section-tree').readOnly = true
        } else {
            document.getElementById('input-code-section-tree').readOnly = false
        }

        $('#actualId').val(idTypeBudget)
        $('#editSectionLogic').removeClass('d-none')
        $('#titleSection').removeClass('d-none')
        $('#budgetSectionCodeDiv').removeClass('d-none')
        document.getElementById('input-code-section-tree').value = document.getElementById('sectionDataCode' + idTypeBudget).innerHTML
        $('#budgetNameDiv').removeClass('d-none')
        $('#input-name-section-tree').val(document.getElementById('sectionDataName' + idTypeBudget).innerHTML.replace(/&amp;/g, '&'))
        $('#editTreeModalBudget').click()

    }

    if (typeBudget == 'block') {

        //NotBlock
        $('#titleSection').addClass('d-none')
        $('#titleAccount').addClass('d-none')
        $('#budgetSectionCodeDiv').addClass('d-none')
        $('#budgetAccountBlockDiv').addClass('d-none')
        $('#budgetAccountCodeDiv').addClass('d-none')
        $('#editSectionLogic').addClass('d-none')
        $('#editAccountLogic').addClass('d-none')
        //

        if (Number(document.getElementById('blockDataCount' + idTypeBudget).innerHTML) > 0) {
            document.getElementById('budSectionModalEditTree').disabled = true
        } else {
            document.getElementById('budSectionModalEditTree').disabled = false
        }

        $('#actualIdFather').val(idTypeBudgetFather)
        $('#budgetBlockSectionDiv').removeClass('d-none')
        $('#actualId').val(idTypeBudget)
        $('#editBlockLogic').removeClass('d-none')
        $('#titleBlock').removeClass('d-none')
        $('#budgetBlockCodeDiv').removeClass('d-none')
        $("#budSectionModalEditTree").val(idTypeBudgetFather).trigger('change');
        document.getElementById('input-code-block-tree').value = document.getElementById('blockDataCode' + idTypeBudget).innerHTML
        $('#budgetNameDiv').removeClass('d-none')
        $('#input-name-section-tree').val(document.getElementById('blockDataName' + idTypeBudget).innerHTML.replace(/&amp;/g, '&'))
        $('#editTreeModalBudget').click()

    }


    if (typeBudget == 'account') {

        //NotAccount
        $('#titleSection').addClass('d-none')
        $('#titleBlock').addClass('d-none')
        $('#budgetSectionCodeDiv').addClass('d-none')
        $('#budgetBlockSectionDiv').addClass('d-none')
        $('#budgetBlockCodeDiv').addClass('d-none')
        $('#editSectionLogic').addClass('d-none')
        $('#editBlockLogic').addClass('d-none')
        //

        if (Number(document.getElementById('accountDataCount' + idTypeBudget).innerHTML) > 0) {
            document.getElementById('budAccountModalTree').disabled = true
        } else {
            document.getElementById('budAccountModalTree').disabled = false
        }

        $('#actualIdFather').val(idTypeBudgetFather)
        $('#budgetAccountBlockDiv').removeClass('d-none')
        $('#actualId').val(idTypeBudget)
        $('#editAccountLogic').removeClass('d-none')
        $('#titleAccount').removeClass('d-none')
        $('#budgetAccountCodeDiv').removeClass('d-none')
        $("#budAccountModalTree").val(idTypeBudgetFather).trigger('change');
        document.getElementById('input-code-account-tree').value = document.getElementById('accountDataCode' + idTypeBudget).innerHTML
        $('#budgetNameDiv').removeClass('d-none')
        $('#input-name-section-tree').val(document.getElementById('accountDataName' + idTypeBudget).innerHTML.replace(/&amp;/g, '&'))
        $('#editTreeModalBudget').click()

    }




}

function editTreeSection() {

    //budgetsection/editSection
    var routeRequest = mainRoute + "budgetsection/editSection";

    var erroName = $('#errorNameSectionTree')
    var erroCode = $('#errorCodeSectionTree')
    var flagName = true
    var flagCode = true

    if ($('#input-code-section-tree').val() == '') {
        erroCode.removeClass('d-none')
        flagCode = false
    } else {
        erroCode.addClass('d-none')
        flagCode = true
    }


    if ($('#input-name-section-tree').val() == '') {
        erroName.removeClass('d-none')
        flagName = false
    } else {
        erroName.addClass('d-none')
        flagName = true
    }

    if ((flagName == true) && (flagCode == true)) {

        $.ajax({
            type: 'post',
            url: routeRequest,
            data: {
                name: $('#input-name-section-tree').val(),
                code: $('#input-code-section-tree').val(),
                actualId: $('#actualId').val(),
            },
            success: function (results) {

                if (results.section_update) {
                    var htmlSection =
                        '<a class="collapsed" data-toggle="collapse" href="#collapse' + results.section_id + '" aria-expanded="false" aria-controls="collapse' + results.section_id + '">' +
                        '' + results.section_code + ' | ' + results.section_name + '' +
                        '<i name="allId" class="material-icons float-right">keyboard_arrow_down</i>' +
                        '</a>'
                    document.getElementById('tdSection' + $('#actualId').val()).innerHTML = htmlSection
                    document.getElementById('sectionDataName' + $('#actualId').val()).innerHTML = $('#input-name-section-tree').val()
                    document.getElementById('sectionDataCode' + $('#actualId').val()).innerHTML = $('#input-code-section-tree').val()
                    var nextCodeChance = Number(document.getElementById('lastCodeSectionTree').innerHTML)
                    if (Number(results.section_code) > nextCodeChance) {
                        document.getElementById('lastCodeSection').innerHTML = results.section_code
                        document.getElementById('lastCodeSectionTree').innerHTML = results.section_code
                    }

                    $('#input-code-section-tree').val('')
                    $('#input-name-section-tree').val('')

                    var routeRequest = mainRoute + 'budgetsection/editSection/all';
                    var modalSectionAdd = $('#budSectionModal')
                    var modalSectionEdit = $('#budSectionModalEditTree')
                    modalSectionEdit.empty()
                    modalSectionAdd.empty()
                    modalSectionEdit.append('<option value="" disabled selected  style="background-color:lightgray">' + document.getElementById('refresModalText01').innerHTML + '</option>')
                    modalSectionAdd.append('<option value="" disabled selected  style="background-color:lightgray">' + document.getElementById('refresModalText01').innerHTML + '</option>')
                    $.get(routeRequest, function (res) {
                        $(res).each(function (key, value) {
                            modalSectionAdd.append('<option value=\"' + value.id + '\">' + value.code + ' ' + value.name + '</option>')
                        })
                        $(res).each(function (key, value) {
                            modalSectionEdit.append('<option value=\"' + value.id + '\">' + value.code + ' ' + value.name + '</option>')
                        })
                    });

                    $('#closeModalEditTree').click()

                    swal({
                        title: document.getElementById('modalTreeEditText01').innerHTML,
                        confirmButtonText: document.getElementById('modalTreeEditText02').innerHTML,
                        confirmButtonClass: 'btn btn-info',
                        type: "success"
                    });

                } else {

                    swal({
                        title: results.error_message,
                        confirmButtonText: document.getElementById('modalTreeEditText02').innerHTML,
                        confirmButtonClass: 'btn btn-info',
                        type: 'error',
                    });

                }
            }
        });
    }

}

function nextCodeSectionTreeEdit() {
    idSectionActual = $('#actualIdFather').val()
    idSection = $('#budSectionModalEditTree').find('option:selected').val();
    var routeRequest = mainRoute + "budgetSection/nextCode/" + idSection;
    if (idSectionActual != idSection) {
        $.get(routeRequest, function (res) {
            $('#input-code-block-tree').val(res);
            if (isNaN(res)) {
                $('#errorCodeBlockTree').removeClass('d-none')
                $('#editBlockLogic').addClass('disabled')
            } else {
                $('#errorCodeBlockTree').addClass('d-none')
                $('#editBlockLogic').removeClass('disabled')
            }
        });
    } else {
        $('#input-code-block-tree').val(document.getElementById('blockDataCode' + $('#actualId').val()).innerHTML);
        $('#editBlockLogic').removeClass('disabled')
    }
}



//


function editTreeBlock() {

    var erroNameBlockTree = $('#errorNameSectionTree')
    var erroSectionBlockTree = $('#errorSectionBlockTree')
    var flagNameBlockTree = true
    var flagSectionBlockTree = true

    if ($('#budSectionModalEditTree').find('option:selected').val() == '') {
        erroSectionBlockTree.removeClass('d-none')
        flagSectionBlockTree = false
    } else {
        erroSectionBlockTree.addClass('d-none')
        flagSectionBlockTree = true
    }


    if ($('#input-name-section-tree').val() == '') {
        erroNameBlockTree.removeClass('d-none')
        flagNameBlockTree = false
    } else {
        erroNameBlockTree.addClass('d-none')
        flagNameBlockTree = true
    }



    if ((flagSectionBlockTree == true) && (flagNameBlockTree == true)) {

        var routeRequest = mainRoute + "budgetBlock/editBlock";
        $.ajax({
            type: 'post',
            url: routeRequest,
            data: {
                name: $('#input-name-section-tree').val(),
                code: $('#input-code-block-tree').val(),
                budget_section_id: $('#budSectionModalEditTree').find('option:selected').val(),
                actualId: $('#actualId').val(),
            },
            success: function (results) {

                if (results.block_update) {
                    var htmlBlock =
                        '<a class="collapsed" data-toggle="collapse" href="#collapse2' + results.block_id + '" aria-expanded="false" aria-controls="collapse2' + results.block_id + '">' +
                        '' + results.block_code + ' | ' + results.block_name + '' +
                        ' <i name="allId" class="material-icons">keyboard_arrow_down</i>' +
                        '</a>'

                    var htmlBlockMove =
                        '<div id="divBlockInfo' + results.block_id + '" class="card-collapse">' +
                        '<div class="card-header" role="tab" id="head2' + results.block_id + '">' +
                        '<h5 class="mb-0">' +
                        '<table class="table table-striped table-no-bordered table-hover">' +
                        '<tr id="tr" style="background-color: #5094c7">' +
                        '<h1 id="blockDataName' + results.block_id + '" class="d-none">' + results.block_name + '</h1>' +
                        '<h1 id="blockDataCode' + results.block_id + '" class="d-none">' + results.block_code + '</h1>' +
                        '<h1 id="blockDataCount' + results.block_id + '" class="d-none">0</h1>' +
                        '<td id="tdBlock' + results.block_id + '" WIDTH="100%" >' +
                        '<a class="collapsed" data-toggle="collapse" href="#collapse2' + results.block_id + '" aria-expanded="false" aria-controls="collapse2' + results.block_id + '">' +
                        '' + results.block_code + ' | ' + results.block_name + '' +
                        '<i name="allId" class="material-icons">keyboard_arrow_down</i>' +
                        '</a>' +
                        '</td>' +
                        '<td class="td-actions text-center">' +
                        '<p onclick="editTree(' + "'block'," + results.block_id + ', ' + results.block_budget_section_id + ');"  class="btn btn-success btn-sm btn-fab" >' +
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
                        '</div>'

                    var routeRequest = mainRoute + 'budgetblock/editBlock/all';
                    var modalBlockAdd = $('#budAccountModal')
                    var modalBlockEdit = $('#budAccountModalTree')
                    modalBlockEdit.empty()
                    modalBlockAdd.empty()
                    modalBlockEdit.append('<option value="" disabled selected  style="background-color:lightgray">' + document.getElementById('refresModalText02').innerHTML + '</option>')
                    modalBlockAdd.append('<option value="" disabled selected  style="background-color:lightgray">' + document.getElementById('refresModalText02').innerHTML + '</option>')
                    $.get(routeRequest, function (res) {
                        $(res).each(function (key, value) {
                            modalBlockAdd.append('<option value=\"' + value.id + '\">' + value.code + ' ' + value.name + '</option>')
                        })
                        $(res).each(function (key, value) {
                            modalBlockEdit.append('<option value=\"' + value.id + '\">' + value.code + ' ' + value.name + '</option>')
                        })
                    });

                    if (results.block_budget_section_id == $('#actualIdFather').val()) {
                        document.getElementById('tdBlock' + $('#actualId').val()).innerHTML = htmlBlock
                        document.getElementById('blockDataName' + $('#actualId').val()).innerHTML = $('#input-name-section-tree').val()
                        document.getElementById('blockDataCode' + $('#actualId').val()).innerHTML = $('#input-code-block-tree').val()
                    } else {
                        $('#divBlockInfo' + $('#actualId').val()).remove()
                        //Subtract previous section
                        preSectiocValor = Number(document.getElementById('sectionDataCount' + $('#actualIdFather').val()).innerHTML)
                        document.getElementById('sectionDataCount' + $('#actualIdFather').val()).innerHTML = preSectiocValor - 1
                        //Add new section
                        newSectiocValor = Number(document.getElementById('sectionDataCount' + results.block_budget_section_id).innerHTML)
                        document.getElementById('sectionDataCount' + results.block_budget_section_id).innerHTML = newSectiocValor + 1
                        //
                        document.getElementById('accordion2' + results.block_budget_section_id).innerHTML += htmlBlockMove
                    }



                    $('#closeModalEditTree').click()

                    swal({
                        title: document.getElementById('modalTreeEditText01').innerHTML,
                        confirmButtonText: document.getElementById('modalTreeEditText02').innerHTML,
                        confirmButtonClass: 'btn btn-info',
                        type: "success"
                    });

                } else {

                    swal({
                        title: results.error_message,
                        confirmButtonText: document.getElementById('modalTreeEditText02').innerHTML,
                        confirmButtonClass: 'btn btn-info',
                        type: 'error',
                    });

                }
            }
        });
        //budgetblock/editBlock/{all}       

    }

}



function nextCodeAccountTreeEdit() {
    idBlockActual = $('#actualIdFather').val()
    idBlock = $('#budAccountModalTree').find('option:selected').val();
    var routeRequest = mainRoute + "budgetaccount/nextCode/" + idBlock;
    if (idBlockActual != idBlock) {
        $.get(routeRequest, function (res) {
            $('#input-code-account-tree').val(res);
        });
    } else {
        $('#input-code-account-tree').val(document.getElementById('accountDataCode' + $('#actualId').val()).innerHTML);
    }
}




function editTreeAccount() {

    var erroNameAccountTree = $('#errorNameSectionTree')
    var erroBlockAccountTree = $('#errorSectionAccountTree')
    var flagNameAccountTree = true
    var flagSectionAccountTree = true

    if ($('#budAccountModalTree').find('option:selected').val() == '') {
        erroBlockAccountTree.removeClass('d-none')
        flagSectionAccountTree = false
    } else {
        erroBlockAccountTree.addClass('d-none')
        flagSectionAccountTree = true
    }


    if ($('#input-name-section-tree').val() == '') {
        erroNameAccountTree.removeClass('d-none')
        flagNameAccountTree = false
    } else {
        erroNameAccountTree.addClass('d-none')
        flagNameAccountTree = true
    }



    if ((flagSectionAccountTree == true) && (flagNameAccountTree == true)) {

        var routeRequest = mainRoute + "budgetAccount/editAccount";
        $.ajax({
            type: 'post',
            url: routeRequest,
            data: {
                name: $('#input-name-section-tree').val(),
                code: $('#input-code-account-tree').val(),
                budget_block_id: $('#budAccountModalTree').find('option:selected').val(),
                actualId: $('#actualId').val(),
            },
            success: function (results) {

                if (results.account_update) {

                    var htmlAccountMove =
                        '<div id="divAccountInfo' + results.account_id + '" class="row">' +
                        '<h1 id="accountDataName' + results.account_id + '" class="d-none">' + results.account_name + '</h1>' +
                        '<h1 id="accountDataCode' + results.account_id + '" class="d-none">' + results.account_code + '</h1>' +
                        '<h1 id="accountDataCount' + results.account_id + '" class="d-none">0</h1>' +
                        '<div id="accounRefresh' + results.account_id + '" class="col-8" style="display: block; margin-top: auto; margin-bottom: auto">' + results.account_budgetBlockCode + '' + results.account_code + ' | ' + results.account_name + '</div>' +
                        '<div class="col-4" style="display: block; margin-top: auto; margin-bottom: auto">' +
                        '<p onclick="editTree(' + "'account'" + ', ' + results.account_id + ', ' + results.account_budget_block_id + ');"  class="btn btn-success" >' +
                        '<i class="material-icons">edit</i>' +
                        '</p>' +
                        '</div>' +
                        '</div>'


                    if (results.account_budget_block_id == $('#actualIdFather').val()) {
                        document.getElementById('accounRefresh' + $('#actualId').val()).innerHTML = results.account_budgetBlockCode + results.account_code + ' | ' + results.account_name
                        document.getElementById('accountDataName' + $('#actualId').val()).innerHTML = $('#input-name-section-tree').val()
                        document.getElementById('accountDataCode' + $('#actualId').val()).innerHTML = $('#input-code-account-tree').val()
                    } else {
                        $('#divAccountInfo' + $('#actualId').val()).remove()
                        //Subtract previous section
                        preSectiocValor = Number(document.getElementById('blockDataCount' + $('#actualIdFather').val()).innerHTML)
                        document.getElementById('blockDataCount' + $('#actualIdFather').val()).innerHTML = preSectiocValor - 1
                        //Add new section
                        newSectiocValor = Number(document.getElementById('blockDataCount' + results.account_budget_block_id).innerHTML)
                        document.getElementById('blockDataCount' + results.account_budget_block_id).innerHTML = newSectiocValor + 1
                        //
                        document.getElementById('account' + results.account_budget_block_id).innerHTML += htmlAccountMove
                    }



                    $('#closeModalEditTree').click()

                    swal({
                        title: document.getElementById('modalTreeEditText01').innerHTML,
                        confirmButtonText: document.getElementById('modalTreeEditText02').innerHTML,
                        confirmButtonClass: 'btn btn-info',
                        type: "success"
                    });

                } else {

                    swal({
                        title: results.error_message,
                        confirmButtonText: document.getElementById('modalTreeEditText02').innerHTML,
                        confirmButtonClass: 'btn btn-info',
                        type: 'error',
                    });

                }
            }
        });

    }

}


