function activateAddBank() {
    if ($('#vendorApprove').val() == '0') {
        if (($('#input-swift').val() == '') && ($('#input-path_account_statement').val() == '') && ($('#input-clabe').val() == '') && ($('#input-account_number').val() == '') && ($('#input-account_owner').val() == '') && ($('#input-bank').val() == '')) {
            $('#btnAddBank').addClass('disabled')
        } else {
            $('#btnAddBank').removeClass('disabled')
        }
    } else {
        if ($('#vendorCountry').find('option:selected').val() == '142') {
            if (($('#input-path_account_statement').val() == '') || ($('#input-clabe').val() == '') || ($('#input-account_number').val() == '') || ($('#input-account_owner').val() == '') || ($('#input-bank').val() == '')) {
                $('#btnAddBankChanges').addClass('disabled')
            } else {
                $('#btnAddBankChanges').removeClass('disabled')
            }
        } else {
            if (($('#input-swift').val() == '') || ($('#input-path_account_statement').val() == '') || ($('#input-account_number').val() == '') || ($('#input-account_owner').val() == '') || ($('#input-bank').val() == '')) {
                $('#btnAddBankChanges').addClass('disabled')
            } else {
                $('#btnAddBankChanges').removeClass('disabled')
            }
        }
    }
}


function activateEditBank() {
    if ($('#vendorApprove').val() == '0') {
        if ($('#vendorCountry').find('option:selected').val() == '142') {
            if (($('#input-path_account_statementEdit').val().trim() == '') && ($('#input-clabeEdit').val().trim() == '') && ($('#input-account_numberEdit').val().trim() == '') && ($('#input-account_ownerEdit').val().trim() == '') && ($('#input-bankEdit').val().trim() == '')) {
                $('#btnEditBankEdit').addClass('disabled')
            } else {
                $('#btnEditBankEdit').removeClass('disabled')
            }
        } else {
            if (($('#input-swiftEdit').val().trim() == '') && ($('#input-path_account_statementEdit').val().trim() == '') && ($('#input-account_numberEdit').val().trim() == '') && ($('#input-account_ownerEdit').val().trim() == '') && ($('#input-bankEdit').val().trim() == '')) {
                $('#btnEditBankEdit').addClass('disabled')
            } else {
                $('#btnEditBankEdit').removeClass('disabled')
            }
        }
    } else {
        if ($('#vendorCountry').find('option:selected').val() == '142') {
            if (($('#input-clabeEdit').val() == '') || ($('#input-account_numberEdit').val() == '') || ($('#input-account_ownerEdit').val() == '') || ($('#input-bankEdit').val() == '')) {
                $('#btnEditBankChanges').addClass('disabled')
            } else {
                $('#btnEditBankChanges').removeClass('disabled')
            }
        } else {
            if (($('#input-swiftEdit').val() == '') || ($('#input-account_numberEdit').val() == '') || ($('#input-account_ownerEdit').val() == '') || ($('#input-bankEdit').val() == '')) {
                $('#btnEditBankChanges').addClass('disabled')
            } else {
                $('#btnEditBankChanges').removeClass('disabled')
            }
        }
    }
}


function addBankAccount() {

    var routeRequest = mainRoute + "vendor/accountsAdd";

    var bank = $('#input-bank').val()
    var account_owner = $('#input-account_owner').val()
    var vendorId = $('#vendorId').val()
    var account_number = $('#input-account_number').val()
    var clabe = $('#input-clabe').val()
    var path_account_statement = $('#input-path_account_statement').val()
    var swift = $('#input-swift').val()
    if (path_account_statement == '') {
    } else {
        path_account_statement = document.getElementById('input-path_account_statement').files[0]
    }
    // if($('#input-path_account_statement').val() != ''){
    //     
    // }  
    var countrySelect = $('#vendorCountry').find('option:selected').val()
    var classClabe = ''
    var classSwift = ''
    if (countrySelect != '142') {
        classClabe = 'd-none'
    } else {
        classSwift = 'd-none'
    }

    $(this).serialize();
    var data = new FormData();
    data.append('bank', bank)
    data.append('countrySelect', countrySelect)
    data.append('vendorId', vendorId)
    data.append('account_owner', account_owner)
    data.append('account_number', account_number)
    data.append('clabe', clabe)
    data.append('path_account_statement', path_account_statement)
    data.append('swift', swift)
    swal({
        title: document.getElementById('modalBankText06').innerHTML,
        html: '<div id="loadingTime" class="loaderSpinnerLogin"></div>',
        //type: 'success',
        showConfirmButton: false
    });

    $.ajax({
        type: 'post',
        url: routeRequest,
        data: data,
        processData: false,
        cache: false,
        contentType: false,
        success: function (r) {
            if (r.saveBankAccount) {
                $('#input-bank').val('')
                $('#input-account_owner').val('')
                $('#input-account_number').val('')
                $('#input-clabe').val('')
                $('#cleanFileBank').click()
                $('#btnAddBank').addClass('disabled')
                $('#closeModalBankAccount').click()
                var tableAccountsBank = $('#dataBankInformationTable')

                if (r[0].is_status_complete) {
                    var colorRow = 'style="background-color: #a5d6a7;"'
                    var dataInfoToolTip = ' title="' + document.getElementById('modalBankText05').innerHTML + '"'
                } else {
                    var colorRow = 'style="background-color: #fff59d;"'
                    var dataInfoToolTip = ' title="' + document.getElementById('modalBankText04').innerHTML + '"'
                }
                if (r[0].bank == null) {
                    bankData = ''
                } else {
                    bankData = r[0].bank
                }
                if (r[0].account_owner == null) {
                    account_ownerData = ''
                } else {
                    account_ownerData = r[0].account_owner
                }
                if (r[0].account_number == null) {
                    account_numberData = ''
                } else {
                    account_numberData = r[0].account_number
                }
                if (r[0].clabe == null) {
                    clabeData = ''
                } else {
                    clabeData = r[0].clabe
                }
                if (r[0].swift == null) {
                    swiftData = ''
                } else {
                    swiftData = r[0].swift
                }
                var account_statementDataClass = ''
                if (r[0].path_account_statement == null) {
                    path_account_statementData = ''
                    var account_statementDataClass = 'd-none'

                } else {
                    path_account_statementData = r[0].path_account_statement
                }

                htmlRowAccountBank =
                    '<tr id="trAccountInfo' + r[0].id + '"' + colorRow + ' ' + dataInfoToolTip + ' >' +
                    '<td id="idAccount' + r[0].id + '" class="d-none">' + r[0].id + '</td>' +
                    '<td id="tdBank' + r[0].id + '">' +
                    bankData +
                    '</td>' +
                    '<td id="tdAccount_owner' + r[0].id + '">' +
                    account_ownerData +
                    '</td>' +
                    '<td id="tdAccount_number' + r[0].id + '">' +
                    account_numberData +
                    '</td>' +
                    '<td name="clabeInfoName" class="' + classClabe + '" id="tdClabe' + r[0].id + '">' +
                    clabeData +
                    '</td>' +
                    '<td name="swiftInfoName" class="' + classSwift + '" id="tdSwift' + r[0].id + '" >' +
                    swiftData +
                    '</td>' +
                    '<td id="tdPath_account_statement' + r[0].id + '">' +
                    '<button id="btnPath_account_statement' + r[0].id + '" class="btn btn-primary btn-sm btn-fab ' + account_statementDataClass + '" onclick="watchDocument(' + "'bank_accounts','path_account_statement'," + r[0].id + ')"><i class="fa fa-file" aria-hidden="true"></i></button>' +
                    '<input type="hidden" id="valuePath_account_statement' + r[0].id + '" value="' + path_account_statementData + '"></input>' +
                    '</td>' +
                    '<td class="td-actions text-right">' +
                    '<button name="resetCountryAccounts" class="d-none" onclick="showBankEditModal(' + r[0].id + ', 2);">reset</button>' +
                    '<button type="button" onclick="showBankEditModal(' + r[0].id + ',1);" class="btn btn-warning btn-sm btn-fab">' +
                    '<i class="material-icons">edit</i>' +
                    '</button>' +
                    '&nbsp;' +
                    '<button type="button" onclick="removeAccount(' + r[0].id + ');" class="btn btn-danger btn-sm btn-fab">' +
                    '<i class="material-icons">remove</i>' +
                    '</button>' +
                    '</td>' +
                    '</tr>'

                tableAccountsBank.append(htmlRowAccountBank)
                $('#dataBankEmpty').addClass('d-none')
                $('#dataBankInformation').removeClass('d-none')
                $('#checkProfilePlease').click()


                swal({
                    title: document.getElementById('modalBankText01').innerHTML,
                    confirmButtonText: document.getElementById('modalBankText02').innerHTML,
                    confirmButtonClass: 'btn btn-info',
                    //type: "success"
                });
            } else {
                swal({
                    title: document.getElementById('modalBankText03').innerHTML,
                    confirmButtonText: document.getElementById('modalBankText02').innerHTML,
                    confirmButtonClass: 'btn btn-info',
                    //type: 'error',
                });
            }
        }
    });

}
function previewVendor(field, event) {
    const fileList = event.target.files;
    var image = fileList.length;
    if (image) {
        $('#show-' + field).text(fileList[0].name);
        //<i class="fa fa-eye" aria-hidden="true"></i>&nbsp; &nbsp;
        $('#show-' + field).append('&nbsp; &nbsp;')
        $('#show-' + field).append('<i class="fa fa-eye" aria-hidden="true"></i>')
        $('#show-' + field).removeClass('d-none');
    } else {
        $('#show-' + field).addClass('d-none');
    }
}

function hiddenDefaultValue(fileId) {
    $('#' + fileId).addClass('d-none')
}

function previewFile(field) {
    // var newtab = window.open(mainRoute + 'vendor/show', '_blank');
    var file = $('#' + field);
    var clone = file.clone().appendTo('#formPreview');
    $('#myFile').val(field);
    $('#formPreview').append(clone);
    // '/vendor/showPreview'
    $('#formPreview').attr('action', mainRoute + 'vendor/showPreview')
    $('#formPreview').submit();
    clone.remove();
    // var data = new FormData();
    // data.append(field, files);
    // data.append('field', field);

    // $.post(url, data)
    //     .always(function (response) {
    //         newtab.location = newurl + response;
    //     });
}

function showBankEditModal(idBank, valueAction) {
    $('#input-bank' + 'Edit').val(document.getElementById('tdBank' + idBank).innerText)
    $('#input-account_owner' + 'Edit').val(document.getElementById('tdAccount_owner' + idBank).innerText)
    $('#input-account_number' + 'Edit').val(document.getElementById('tdAccount_number' + idBank).innerText)
    $('#input-clabe' + 'Edit').val(document.getElementById('tdClabe' + idBank).innerText)
    $('#idEditAccount').val(document.getElementById('idAccount' + idBank).innerText)
    $('#input-swift' + 'Edit').val(document.getElementById('tdSwift' + idBank).innerText)
    $('#show-input-path_account_statementEdit').addClass('d-none')
    $('#cleanFileBankEdit').click()

    if ($('#valuePath_account_statement' + idBank).val() != '') {
        document.getElementById('previeFileEdit').setAttribute('onclick', "watchDocument('bank_accounts','path_account_statement'," + idBank + ");")
        $('#previeFileEdit').removeClass('d-none')
    } else {
        $('#previeFileEdit').addClass('d-none')
    }

    if (valueAction == 1) {
        $('#resetAction').val(1);
        $('#bankEdit').click()
    } else {
        $('#resetAction').val(2);
    }

}

function removeAccount(idBank) {

    swal({
        text: document.getElementById('modalDeleteAccount02').innerHTML,
        showCancelButton: true,
        confirmButtonText: document.getElementById('modalDeleteAccount03').innerHTML,
        cancelButtonText: document.getElementById('modalDeleteAccount04').innerHTML,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function (e) {

        if (e.value === true) {

            $('#trAccountInfo' + idBank).remove()
            var routeRequest = mainRoute + "vendor/accountsDelete";
            $.ajax({
                type: 'post',
                url: routeRequest,
                data: {
                    idAccount: idBank,
                },
                success: function (r) {
                    if (r.deleteBankAccount) {

                        $.notify({
                            icon: "done",
                            message: r.message
                        }, {
                            type: 'success',
                            timer: 3000,
                            placement: {
                                from: 'top',
                                align: 'right'
                            }
                        });
                        var counterRows = document.getElementById("dataBankInformationTable").getElementsByTagName('tr')
                        if (counterRows.length == 1) {
                            $('#dataBankEmpty').removeClass('d-none')
                            $('#dataBankInformation').addClass('d-none')
                            document.getElementById('sendDataReview').disabled = true
                            document.getElementById('sendDataReview').setAttribute("title", document.getElementById('modalDeleteAccount05').innerHTML);
                            $('#sendDataReview').removeClass('btn-primary')
                        } else {
                            $('#checkProfilePlease').click()
                        }

                    } else {

                        $.notify({
                            icon: "error",
                            message: r.message
                        }, {
                            type: 'danger',
                            timer: 3000,
                            placement: {
                                from: 'top',
                                align: 'right'
                            }
                        });

                    }
                }
            });

        } else {
            e.dismiss;
        }
    }, function (dismiss) {
        return false;
    }
    )
}




function sendDataReview() {
    //vendor/completeProfile
    var routeRequest = mainRoute + "vendor/completeProfile";
    swal({
        text: document.getElementById('vendorCompleteText01').innerHTML,
        showCancelButton: true,
        confirmButtonText: document.getElementById('vendorCompleteText02').innerHTML,
        cancelButtonText: document.getElementById('vendorCompleteText03').innerHTML,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function (e) {
        if (e.value === true) {
            swal({
                title: document.getElementById('vendorCompleteText04').innerHTML,
                html: '<div id="loadingTime" class="loaderSpinnerLogin"></div>',
                showConfirmButton: false
            });
            $.ajax({
                type: 'post',
                url: routeRequest,
                data: {
                    vendorId: $('#vendorId').val(),
                },
                success: function (results) {
                    if (results.vendorComplete) {
                        console.log(results.vendorComplete)
                        swal({
                            text: results.message,
                            confirmButtonText: results.btnSuccess,
                            confirmButtonClass: 'btn btn-info',
                        }).then(function (e) {
                            if (e.value === true) {
                                location.reload();
                            } else {
                                e.dismiss;
                            }
                        }, function (dismiss) {
                            return false;
                        }
                        )
                    } else {
                        console.log(results.vendorComplete)
                        swal({
                            text: results.message,
                            confirmButtonText: results.btnSuccess,
                            confirmButtonClass: 'btn btn-info',
                        });
                    }
                }
            });

        } else {
            e.dismiss;
        }
    }, function (dismiss) {
        return false;
    }
    )
}

function watchDocument(table, field, id) {
    $('#myFile').val(field);
    $('#myTable').val(table);
    $('#myId').val(id);
    $('#formPreview').attr('action', mainRoute + 'watchDocument')
    $('#formPreview').submit();
}


function editBankAccount() {

    var routeRequest = mainRoute + "vendor/accountsEdit";

    var bank = $('#input-bankEdit').val()
    var account_owner = $('#input-account_ownerEdit').val()
    var accountId = $('#idEditAccount').val()
    var account_number = $('#input-account_numberEdit').val()
    var clabe = $('#input-clabeEdit').val()
    var path_account_statement = $('#input-path_account_statementEdit').val()
    var swift = $('#input-swiftEdit').val()
    if (path_account_statement == '') {
    } else {
        path_account_statement = document.getElementById('input-path_account_statementEdit').files[0]
    }
    // if($('#input-path_account_statementEdit').val() != ''){
    //     
    // }  
    var countrySelect = $('#vendorCountry').find('option:selected').val()

    $(this).serialize();
    var data = new FormData();
    data.append('bank', bank)
    data.append('countrySelect', countrySelect)
    data.append('accountId', accountId)
    data.append('account_owner', account_owner)
    data.append('account_number', account_number)
    data.append('clabe', clabe)
    data.append('path_account_statement', path_account_statement)
    data.append('swift', swift)
    if ($('#resetAction').val() == 1) {
        swal({
            title: document.getElementById('modalBankText06').innerHTML,
            html: '<div id="loadingTime" class="loaderSpinnerLogin"></div>',
            //type: 'success',
            showConfirmButton: false
        });
    }

    $.ajax({
        type: 'post',
        url: routeRequest,
        data: data,
        processData: false,
        cache: false,
        contentType: false,
        success: function (r) {
            if (r.saveBankAccount) {
                $('#input-bankEdit').val('')
                $('#input-account_ownerEdit').val('')
                $('#input-account_numberEdit').val('')
                $('#input-clabeEdit').val('')
                $('#cleanFileBank').click()
                $('#closeModalBankAccountEdit').click()

                if (r[0].is_status_complete) {
                    document.getElementById('trAccountInfo' + r[0].id).style.backgroundColor = "#a5d6a7";
                    document.getElementById('trAccountInfo' + r[0].id).setAttribute("title", document.getElementById('modalBankText05').innerHTML);
                } else {
                    document.getElementById('trAccountInfo' + r[0].id).style.backgroundColor = "#fff59d";
                    document.getElementById('trAccountInfo' + r[0].id).setAttribute("title", document.getElementById('modalBankText04').innerHTML);
                }
                if (r[0].bank == null) {
                    bankData = ''
                } else {
                    bankData = r[0].bank
                }
                if (r[0].account_owner == null) {
                    account_ownerData = ''
                } else {
                    account_ownerData = r[0].account_owner
                }
                if (r[0].account_number == null) {
                    account_numberData = ''
                } else {
                    account_numberData = r[0].account_number
                }
                if (r[0].clabe == null) {
                    clabeData = ''
                } else {
                    clabeData = r[0].clabe
                }
                if (r[0].swift == null) {
                    swiftData = ''
                } else {
                    swiftData = r[0].swift
                }
                var account_statementDataClass = ''
                if (r[0].path_account_statement == null) {
                    path_account_statementData = ''
                    var account_statementDataClass = 'd-none'

                } else {
                    path_account_statementData = r[0].path_account_statement
                }
                document.getElementById('tdBank' + r[0].id).innerHTML = bankData
                document.getElementById('tdAccount_owner' + r[0].id).innerHTML = account_ownerData
                document.getElementById('tdAccount_number' + r[0].id).innerHTML = account_numberData
                document.getElementById('tdClabe' + r[0].id).innerHTML = clabeData
                document.getElementById('tdSwift' + r[0].id).innerHTML = swiftData
                $('#valuePath_account_statement' + r[0].id).val(path_account_statementData)
                $('#infoClabe' + r[0].id).val(clabeData)
                if (account_statementDataClass == '') {
                    $('#btnPath_account_statement' + r[0].id).removeClass('d-none')
                } else {
                    $('#btnPath_account_statement' + r[0].id).addClass('d-none')
                }

                if ($('#resetAction').val() == 1) {
                    swal({
                        text: document.getElementById('modalBankEditText01').innerHTML,
                        confirmButtonText: document.getElementById('modalBankEditText02').innerHTML,
                        confirmButtonClass: 'btn btn-sm btn-info',
                        //type: "success"
                    });
                    $('#checkProfilePlease').click()
                }



            } else {

                if ($('#resetAction').val() == 1) {
                    swal({
                        title: document.getElementById('modalBankText03').innerHTML,
                        confirmButtonText: document.getElementById('modalBankEditText02').innerHTML,
                        confirmButtonClass: 'btn btn-info',
                        //type: 'error',
                    });
                }

            }
        }
    });
}



function changeHiddenBox() {
    var countrySelect = $('#vendorCountry').find('option:selected').val()

    if (countrySelect != '') {
        $('#infoDataBank').removeClass('d-none')
        document.getElementById('addBankAcoounBtn').disabled = false
        document.getElementById('addBankAcoounBtn').setAttribute("title", '');
    }
    var countBtnReset = $("[name^='resetCountryAccounts']")//resetCountryAccounts
    for (i = 0; i < countBtnReset.length; i++) {
        countBtnReset[i].click()
        btnEditBankEdit.click()
    }
    $('#checkProfilePlease').click()


    if (countrySelect == 142) {
        $('#swiftBox').addClass('d-none')
        $('#swiftBoxEdit').addClass('d-none')
        $('#clabeBox').removeClass('d-none')
        $('#clabeBoxEdit').removeClass('d-none')
        $("[name^='clabeInfoName']").removeClass('d-none')
        $("[name^='swiftInfoName']").addClass('d-none')

    } else {
        $('#swiftBox').removeClass('d-none')
        $('#swiftBoxEdit').removeClass('d-none')
        $('#clabeBox').addClass('d-none')
        $('#clabeBoxEdit').addClass('d-none')
        $("[name^='clabeInfoName']").addClass('d-none')
        $("[name^='swiftInfoName']").removeClass('d-none')
    }

}


function fileValidation(event, fileId1, fileId2) {
    const fileList = event.target.files
    var image = fileList.length;
    if (image) {
        var nameFile = fileList[0].name
        var nameFileUpper = nameFile.toUpperCase()
        var extensionFile = nameFileUpper.split(".")
        var countPoints = extensionFile.length
        if ((extensionFile[countPoints - 1] == 'JPG') || (extensionFile[countPoints - 1] == 'JPEG') || (extensionFile[countPoints - 1] == 'PNG') || (extensionFile[countPoints - 1] == 'PDF')) {
            $('#' + fileId2).addClass('d-none')
        } else {
            $('#' + fileId1).click()
            $('#' + fileId2).removeClass('d-none')
        }
    }
}

function getStates() {
    var countrySelect = $('#vendorCountry').find('option:selected').val()
    var routeRequest = mainRoute + "vendor/getStates/" + countrySelect;
    var states = $('#vendorState')
    states.empty();
    states.append('<option value="" disabled selected  style="background-color:lightgray">' + document.getElementById('vendorAdressText01').innerHTML + '</option>')
    $.get(routeRequest, function (res) {
        $(res).each(function (key, value) {
            states.append('<option value=\"' + value.id + '\">' + value.name + '</option>')
        })

    })

}





function updateVendor() {

    var vendorId = $('#vendorId').val()
    var name = $('#input-name').val()
    var legal_name = $('#input-legal').val()
    var contact_name = $('#input-contact').val()
    var path_address_proof = $('#input-proofResidency').val()
    if (path_address_proof == '') {
    } else {
        path_address_proof = document.getElementById('input-proofResidency').files[0]
    }
    var street = $('#input-street-name').val()
    var inner_number = $('#input-street-ninternal').val()
    var outer_number = $('#input-street-nexternal').val()
    var suburb = $('#input-suburb').val()
    var delegation = $('#input-delegacy').val()
    var postal_code = $('#input-zip-code').val()
    var country_id = $('#vendorCountry').find('option:selected').val()
    var state_id = $('#vendorState').find('option:selected').val()
    var city = $('#input-city').val()
    var mobile = $('#input-mobile').val()
    var phone = $('#input-phone').val()
    var path_official_identification = $('#input-officialId').val()
    if (path_official_identification == '') {
    } else {
        path_official_identification = document.getElementById('input-officialId').files[0]
    }
    var vendorServices = $('#vendorServices').val()
    var key_rfc = $('#input-key-rfc').val()
    var path_cover_rfc = $('#input-proof-tax').val()
    if (path_cover_rfc == '') {
    } else {
        path_cover_rfc = document.getElementById('input-proof-tax').files[0]
    }
    var path_32d = $('#input-tax-32d').val()
    if (path_32d == '') {
    } else {
        path_32d = document.getElementById('input-tax-32d').files[0]
    }
    $(this).serialize();
    var data = new FormData();
    data.append('vendorId', vendorId)
    data.append('name', name)
    data.append('legal_name', legal_name)
    data.append('contact_name', contact_name)
    data.append('path_address_proof', path_address_proof)
    data.append('street', street)
    data.append('inner_number', inner_number)
    data.append('outer_number', outer_number)
    data.append('suburb', suburb)
    data.append('delegation', delegation)
    data.append('postal_code', postal_code)
    data.append('country_id', country_id)
    data.append('state_id', state_id)
    data.append('city', city)
    data.append('path_official_identification', path_official_identification)
    data.append('vendorServices', vendorServices)
    data.append('key_rfc', key_rfc)
    data.append('path_cover_rfc', path_cover_rfc)
    data.append('path_32d', path_32d)
    data.append('mobile', mobile)
    data.append('phone', phone)
    var routeRequest = mainRoute + "vendor/updateProfile";
    swal({
        title: document.getElementById('vendorUpdateText01').innerHTML,
        html: '<div id="loadingTime" class="loaderSpinnerLogin"></div>',
        //type: 'success',
        showConfirmButton: false
    });

    $.ajax({
        type: 'post',
        url: routeRequest,
        data: data,
        processData: false,
        cache: false,
        contentType: false,
        success: function (r) {
            if (r.updateVendor) {
                if (r[0].path_address_proof == null) {
                    $('#preview-proofResidency').addClass('d-none')
                } else {
                    $('#clean-proofResidency').click()
                    $('#preview-proofResidency').removeClass('d-none')
                }
                if (r[0].path_official_identification == null) {
                    $('#preview-officialId').addClass('d-none')
                } else {
                    $('#clean-officialId').click()
                    $('#preview-officialId').removeClass('d-none')
                }
                if (r[0].path_cover_rfcf == null) {
                    $('#preview-proof-tax').addClass('d-none')
                } else {
                    $('#clean-proof-tax').click()
                    $('#preview-proof-tax').removeClass('d-none')
                }
                if (r[0].path_32d == null) {
                    $('#preview-tax-32d').addClass('d-none')
                } else {
                    $('#clean-tax-32d').click()
                    $('#preview-tax-32d').removeClass('d-none')
                }
                if (r.vendorStatusForm) {
                    $('#sendDataReview').addClass('btn-primary')
                    document.getElementById('sendDataReview').disabled = false
                    document.getElementById('sendDataReview').setAttribute("title", document.getElementById('vendorUpdateText02').innerHTML);
                } else {
                    $('#sendDataReview').removeClass('btn-primary')
                    document.getElementById('sendDataReview').disabled = true
                    document.getElementById('sendDataReview').setAttribute("title", document.getElementById('vendorUpdateText03').innerHTML);
                }
                swal.close()
                $.notify({
                    icon: "done",
                    message: r.message
                }, {
                    type: 'success',
                    timer: 3000,
                    placement: {
                        from: 'top',
                        align: 'right'
                    }
                });
            } else {
                swal.close()
                $.notify({
                    icon: "error",
                    message: r.message
                }, {
                    type: 'danger',
                    timer: 3000,
                    placement: {
                        from: 'top',
                        align: 'right'
                    }
                });
            }
        }
    });

}


//vendor/checkProfile

function checkProfile() {
    var routeRequest = mainRoute + "vendor/checkVendorProfile";
    $.ajax({
        type: 'post',
        url: routeRequest,
        data: {
            vendorId: $('#vendorId').val(),
        },
        success: function (r) {
            if (r.vendorStatusForm) {
                document.getElementById('sendDataReview').disabled = false
                $('#sendDataReview').addClass('btn-primary')
                document.getElementById('sendDataReview').setAttribute("title", document.getElementById('vendorUpdateText02').innerHTML);
            } else {
                document.getElementById('sendDataReview').disabled = true
                $('#sendDataReview').removeClass('btn-primary')
                document.getElementById('sendDataReview').setAttribute("title", document.getElementById('vendorUpdateText03').innerHTML);
            }
        }
    });
}


function urlCurrent() {
    var url = window.location.href;
    document.getElementById('urlHelp').href = "https://docs.google.com/forms/d/e/1FAIpQLScGTFUkQtmCiOy1puT5SI7S19LTZT0etzpcNDA_gOScOK0Dtw/viewform?usp=pp_url&entry.387511766=" + url
    document.getElementById('urlHelp').click()
}


function activateAddVendor() {

    if (($('#input-name').val() == '') && ($('#input-legal').val() == '') && ($('#input-contact').val() == '')) {
        document.getElementById('addVendor').disabled = true
    } else {
        document.getElementById('addVendor').disabled = false
    }
}

//Funcion de inter
// function onLine(){
//     if(navigator.onLine) {
//         console.log('si hay inter')
//     } else {
//        console.log('no hay inter')
//     }
// }

// setInterval('onLine()', 3000);


function emailBtn() {
    if ($('#input-email').val() == '') {
        document.getElementById('btnUser').disabled = true
    } else {
        document.getElementById('btnUser').disabled = false
    }
}



function asingUserData() {

    var routeRequest = mainRoute + "vendor/assignUser";
    var formatEmail = true
    var emailString = $('#input-email').val()

    if (emailString.search("@") == -1) {
        $('#errorEmail').removeClass('d-none')
        formatEmail = false
    } else {
        $('#errorEmail').addClass('d-none')
        formatEmail = true
    }

    var htmlTitle = '<h4>' + document.getElementById('modalUserText01').innerHTML +
        '<b style="font-weight: bold;"> ' + $('#input-email').val() + '</b> ?' +
        '</h4>'
    //text-align: justify;text-justify: inter-word;


    if (formatEmail) {
        swal({
            html: htmlTitle,
            showCancelButton: true,
            confirmButtonText: document.getElementById('modalUserText02').innerHTML,
            cancelButtonText: document.getElementById('modalUserText03').innerHTML,
            confirmButtonClass: 'btn btn-success btn-sm',
            cancelButtonClass: 'btn btn-danger btn-sm',
            buttonsStyling: false
        }).then(function (e) {
            if (e.value === true) {
                swal({
                    title: document.getElementById('modalUserText04').innerHTML,
                    html: '<div id="loadingTime" class="loaderSpinnerLogin"></div>',
                    type: 'success',
                    showConfirmButton: false
                });

                $.ajax({
                    type: 'post',
                    url: routeRequest,
                    data: {
                        vendorId: $('#input-vendorId').val(),
                        email: $('#input-email').val(),
                    },
                    success: function (results) {
                        if (results.save_user) {
                            document.getElementById('input-vendorId').value = ''
                            document.getElementById('input-email').value = ''
                            $('#assignBtnUser' + results.vendor_id).addClass('d-none')
                            document.getElementById('btnUser').disabled = true
                            $('#trVendorInfo' + results.vendor_id).css({ "background-color": "#ffcc80" });
                            $('#closeModalUser').click()
                            swal({
                                text: document.getElementById('modalUserText05').innerHTML,
                                confirmButtonText: document.getElementById('modalUserText06').innerHTML,
                                confirmButtonClass: 'btn btn-info',
                            });
                        } else {
                            swal({
                                text: results.error_message,
                                confirmButtonText: document.getElementById('modalUserText06').innerHTML,
                                confirmButtonClass: 'btn btn-info',
                            });

                        }
                    }
                });

            } else {
                e.dismiss;
            }
        }, function (dismiss) {
            return false;
        }
        )

    }

}


function putIdVendor(vendorId) {
    $('#input-vendorId').val(vendorId)
}



function approvalProcess(vendorId, approvalType) {

    var routeRequest = mainRoute + "vendor/approveDataVendor";
    var flagSendData = true
    // var emailString = $('#input-email').val()

    // if( emailString.search("@") == -1 ){
    //     $('#errorEmail').removeClass('d-none')
    //     formatEmail = false
    // }else{
    //     $('#errorEmail').addClass('d-none')
    //     formatEmail = true
    // }
    var textModal = ''
    var confirmText = ''
    var motiveText = ''
    var typeA = ''

    if (approvalType) {
        flagSendData = true;
        textModal = document.getElementById('vendorAproveText01').innerHTML
        confirmText = document.getElementById('vendorAproveText02').innerHTML
        typeA = 1
    } else {
        textModal = document.getElementById('vendorAproveText05').innerHTML
        confirmText = document.getElementById('vendorAproveText06').innerHTML
        motiveText = $('#input-motive').val()
        typeA = 0

    }
    var flagResponse = true


    if (flagSendData) {
        swal({
            text: textModal,
            showCancelButton: true,
            confirmButtonText: confirmText,
            cancelButtonText: document.getElementById('vendorAproveText03').innerHTML,
            confirmButtonClass: 'btn btn-success btn-sm',
            cancelButtonClass: 'btn btn-danger btn-sm',
            buttonsStyling: false
        }).then(function (e) {
            if (e.value === true) {
                swal({
                    title: document.getElementById('vendorAproveText04').innerHTML,
                    html: '<div id="loadingTime" class="loaderSpinnerLogin"></div>',
                    type: 'success',
                    showConfirmButton: false
                });

                $.ajax({
                    type: 'post',
                    url: routeRequest,
                    data: {
                        vendorId: vendorId,
                        approvalType: typeA,
                        motive: motiveText,
                    },
                    success: function (results) {
                        if (results.save_info) {
                            document.getElementById('input-motive').value = ''
                            document.getElementById('btnMotive').disabled = true
                            $('#closeModalmotive').click()
                            flagResponse = true
                        } else {
                            flagResponse = false

                        }
                        swal({
                            text: results.message,
                            confirmButtonText: results.btnText,
                            confirmButtonClass: 'btn btn-info btn-sm',
                            buttonsStyling: false,
                        }).then(function (e) {
                            if (e.value === true) {
                                if (flagResponse) {
                                    window.location = mainRoute + 'vendor';
                                } else {
                                    swal.close()
                                }

                            } else {
                                e.dismiss;
                            }
                        }, function (dismiss) {
                            return false;
                        }
                        )
                    }
                });

            } else {
                e.dismiss;
            }
        }, function (dismiss) {
            return false;
        }
        )

    }

}

function motiveNull() {
    if ($('#input-motive').val() == '') {
        document.getElementById('btnMotive').disabled = true;
    } else {
        document.getElementById('btnMotive').disabled = false;
    }
}

function vendorsFilter() {
    $typeVendor = $('#filterVendorStatus').find('option:selected').val()
    var serviceFilter = $('#vendorServices').val()
    var routeRequest = mainRoute + "vendor/vendorFilter";
    var table = $('#datatables').DataTable()
    table.clear()
    table.draw()
    $.ajax({
        type: 'post',
        url: routeRequest,
        data: {
            filterType: $('#filterVendorStatus').val(),
        },
        success: function (res) {
            $(res[0]).each(function (key, value) {
                var statusValue =
                '<svg height="20" width="20">'+
                '<circle cx="10" cy="10" r="9" stroke="black" stroke-width="1" fill="'+value.color_status+'" />'+
                '</svg>'
                if (value.status == null) {
                    statusValue = ''
                    
                }
                var nameValue = value.name
                if (value.name == null) {
                    nameValue = ''
                }
                var legal_nameValue = value.legal_name
                if (value.legal_name == null) {
                    legal_nameValue = ''
                }
                var contact_nameValue = value.contact_name
                if (value.contact_name == null) {
                    contact_nameValue = ''
                }
                var servicesValues = ''
                $(res[1][key]).each(function (key2, value) {
                    servicesValues = servicesValues + value.name + '<br>'

                })
                var classColor = value.color_status
                if (classColor == '#ef9a9a') {
                    classColor = '#ef9a9a'
                }
                if (classColor == '#ffcc80') {
                    classColor = '#ffcc80'
                }
                if (classColor == '#fff59d') {
                    classColor = '#fff59d'
                }
                if (classColor == '#90caf9') {
                    classColor = '#90caf9'
                }
                if (classColor == '#c8e6c9') {
                    classColor = '#c8e6c9'
                }

                var btnActions =
                    '<div class="d-flex flex-row-reverse">' +
                    '<a id="seeBtnVendor' + value.id + '"  class="btn btn-link btnVendor d-none" href="/vendor/watch/' + value.id + '"' +
                    '<i class="material-icons">remove_red_eye</i>      ' +
                    '<div class="ripple-container"></div>' +
                    '</a> '

                if (res.permissionDeleteVendor) {
                    if (res[3][key] == 0) {
                        btnActions = btnActions +
                            '<a class="btn btn-link btnVendor" href="#" title="' + document.getElementById('tableAction06').innerHTML + '" onclick="deleteVendor(' + value.id + ',' + "'" + value.name + "'" + ')"><i class="material-icons">close</i>' +
                            '<div class="ripple-container"></div>' +
                            '</a>'
                    } else {
                        btnActions = btnActions +
                            '<a class="btn btn-link btnVendor" href="#" title="' + document.getElementById('tableAction05').innerHTML + '" ><i class="material-icons">not_interested</i>' +
                            '<div class="ripple-container"></div>' +
                            '</a>'
                    }

                }


                if (value.status == 0 && res.permissionAsingUser) {
                    btnActions = btnActions +
                        '<a class="btn btn-link btnVendor" id="assignBtnUser' + value.id + '"  href="" onclick="putIdVendor(' + value.id + ');" data-toggle="modal" data-target="#assignUser" title="' + document.getElementById('tableAction01').innerHTML + '">' +
                        '<i class="material-icons">person_add</i>' +
                        '<div class="ripple-container"></div>' +
                        '</a> '
                }
                if (value.status == 2) {
                    btnActions = btnActions +
                        '<a href="#" class="btn btn-link btnVendor">' +
                        '<i class="material-icons" title="' + document.getElementById('tableAction07').innerHTML + '"  onclick="sendEmailVendors(1,' + value.id + ');">email</i>' +
                        '</a>'
                }
                for (var z = 0; z < res[2].length; z++) {
                    if (res[2].length > 0) {
                        if (value.id == res[2][z][0].vendor_id && value.status == '2') {
                            if (res[2][z][0].is_review) {
                                if (res[2][z][0].motive == null) {
                                    btnActions = btnActions +
                                        '<a href="#" >' +
                                        '<i class="material-icons text-success" title="' + document.getElementById('tableAction03').innerHTML + '" >assignment_turned_in</i>' +
                                        '</a>'
                                } else {
                                    btnActions = btnActions +
                                        '<a href="#" >' +
                                        '<i class="material-icons text-danger" title="' + document.getElementById('tableAction04').innerHTML + '" >help_center</i>' +
                                        '</a>'
                                }
                            } else {
                                btnActions = btnActions +
                                    '<a href="#" >' +
                                    '<i class="material-icons text-warning" title="' + document.getElementById('tableAction02').innerHTML + '" >warning</i>' +
                                    '</a>'
                            }

                        }
                    }
                }


                if (value.status == 1) {
                    btnActions = btnActions +
                        '<a href="#" class="btn btn-link btnVendor">' +
                        '<i class="material-icons" title="' + document.getElementById('tableAction07').innerHTML + '"  onclick="sendEmailVendors(2,' + value.id + ');">email</i>' +
                        '</a>'
                }

                var flagServiceAdd = false
                var i
                var x
                for (x = 0; x < res[1][key].length; x++) {

                    for (i = 0; i < serviceFilter.length; i++) {
                        if (Number(serviceFilter[i]) == res[1][key][x].id) {
                            flagServiceAdd = true;
                            i = serviceFilter.length + 3
                            x = res[1][key].length + 3
                        }
                    }
                }

                if (serviceFilter.length == 0) {
                    flagServiceAdd = true
                }

                if (flagServiceAdd) {
                    var rowTable = table.row.add([
                        statusValue,
                        nameValue,
                        legal_nameValue,
                        contact_nameValue,
                        servicesValues,
                        btnActions + '</div>'
                    ]).draw(false)
                    var rowCount = $('#datatables tr').length
                    var rowsTables = $('#datatables tr')
                    //$('#datatables tr:last').css({"background-color": classColor})
                    var tableTd = document.getElementById('datatables')
                    var rowTd = tableTd.getElementsByTagName("tr")[rowCount - 1]
                    rowTd.setAttribute('id', 'trVendorInfo' + value.id)
                    var tdEdit = rowTd.getElementsByTagName("td")[4].style.fontSize = '10px'
                    rowTd.getElementsByTagName("td")[0].setAttribute('onclick', 'tdActionSee(' + value.id + ');');
                    rowTd.getElementsByTagName("td")[0].setAttribute('class', 'text-center');
                    rowTd.getElementsByTagName("td")[1].setAttribute('onclick', 'tdActionSee(' + value.id + ');');
                    rowTd.getElementsByTagName("td")[2].setAttribute('onclick', 'tdActionSee(' + value.id + ');');
                    rowTd.getElementsByTagName("td")[3].setAttribute('onclick', 'tdActionSee(' + value.id + ');');
                    rowTd.getElementsByTagName("td")[4].setAttribute('onclick', 'tdActionSee(' + value.id + ');');
                }


            })




        }
    })
}


function tdActionSee($id) {
    document.getElementById('seeBtnVendor' + $id).click()

}

function updateSimpleVendor() {

    var routeRequest = mainRoute + "vendor/updateTwo";
    $.ajax({
        type: 'post',
        url: routeRequest,
        data: {
            vendorId: $('#vendorId').val(),
            legal: $('#input-legal').val(),
            name: $('#input-name').val(),
            contact: $('#input-contact').val(),
            vendorServices: $('#vendorServices').val(),
        },
        success: function (r) {
            if (r.updateVendor) {
                document.getElementById('vendorTrueUpdate').click()
            } else {

                $.notify({
                    icon: "error",
                    message: r.message
                }, {
                    type: 'danger',
                    timer: 3000,
                    placement: {
                        from: 'top',
                        align: 'right'
                    }
                });

            }

        }
    });

}

function activateEditVendor() {

    if (($('#input-name').val() == '') && ($('#input-legal').val() == '') && ($('#input-contact').val() == '')) {
        document.getElementById('btnUpdate2').disabled = true
    } else {
        document.getElementById('btnUpdate2').disabled = false
    }
}

function feedBackVendorDeactivate() {
    //vendor/deactivateFeedBackVendors
    var routeRequest = mainRoute + "vendor/deactivateFeedBackVendors";
    $.ajax({
        type: 'post',
        url: routeRequest,
        data: {
            vendorId: $('#vendorId').val(),
        },
        success: function (r) {

        }
    });
}

function deleteVendor(id, name) {
    console.log('elimine al vendor'+id+name)
    var routeRequest = mainRoute + "vendor/deleteVendor";
    var htmlTitle =
        '<h4>' + document.getElementById('deleteVendor01').innerHTML +
        '<b style="font-weight: bold;"> ' + name + '</b> ?' +
        '</h4>'
    swal({
        html: htmlTitle,
        showCancelButton: true,
        confirmButtonText: document.getElementById('deleteVendor02').innerHTML,
        cancelButtonText: document.getElementById('deleteVendor03').innerHTML,
        confirmButtonClass: 'btn btn-info btn-sm',
        cancelButtonClass: 'btn btn-danger btn-sm',
        buttonsStyling: false
    }).then(function (e) {
        if (e.value === true) {
            $.ajax({
                type: 'post',
                url: routeRequest,
                data: {
                    vendorId: id,
                },
                success: function (results) {
                    if (results.deleteVendor) {
                        $('#trVendorInfo' + id).remove()
                        $.notify({
                            icon: "done",
                            message: results.message
                        }, {
                            type: 'success',
                            timer: 3000,
                            placement: {
                                from: 'top',
                                align: 'right'
                            }
                        });

                    } else {
                        $.notify({
                            icon: "error",
                            message: results.message
                        }, {
                            type: 'danger',
                            timer: 3000,
                            placement: {
                                from: 'top',
                                align: 'right'
                            }
                        });
                    }
                }
            });

        } else {
            e.dismiss;
        }
    }, function (dismiss) {
        return false;
    }
    )

}


function sendEmailVendors(type, id) {
    if (type == 1) {
        var routeRequest = mainRoute + "vendor/resendReviewsEmail";
        var tileEmail = document.getElementById('resenEmail01').innerHTML
    } else {
        var routeRequest = mainRoute + "vendor/resendVendorEmail";
        var tileEmail = document.getElementById('resenEmail06').innerHTML
    }
    swal({
        html: tileEmail,
        showCancelButton: true,
        confirmButtonText: document.getElementById('resenEmail02').innerHTML,
        cancelButtonText: document.getElementById('resenEmail03').innerHTML,
        confirmButtonClass: 'btn btn-info btn-sm',
        cancelButtonClass: 'btn btn-danger btn-sm',
        buttonsStyling: false
    }).then(function (e) {
        if (e.value === true) {
            swal({
                title: document.getElementById('resenEmail04').innerHTML,
                html: '<div id="loadingTime" class="loaderSpinnerLogin"></div>',
                type: 'success',
                showConfirmButton: false
            });
            $.ajax({
                type: 'post',
                url: routeRequest,
                data: {
                    vendorId: id,
                },
                success: function (results) {
                    if (results.resendEmail) {
                        swal({
                            text: results.message,
                            confirmButtonText: document.getElementById('resenEmail05').innerHTML,
                            confirmButtonClass: 'btn btn-info',
                        });
                    } else {
                        swal({
                            text: results.message,
                            confirmButtonText: document.getElementById('resenEmail05').innerHTML,
                            confirmButtonClass: 'btn btn-info',
                        });

                    }
                }
            });

        } else {
            e.dismiss;
        }
    }, function (dismiss) {
        return false;
    }
    )
}


//vendor/updateProfileChanges

function sendDataChange() {
    var routeRequest = mainRoute + "vendor/updateProfileChanges";

    var vendorId = $('#vendorId').val()
    var name = $('#input-name').val()
    var legal_name = $('#input-legal').val()
    var contact_name = $('#input-contact').val()
    var path_address_proof = $('#input-proofResidency').val()
    if (path_address_proof == '') {
    } else {
        path_address_proof = document.getElementById('input-proofResidency').files[0]
    }
    var street = $('#input-street-name').val()
    var inner_number = $('#input-street-ninternal').val()
    var outer_number = $('#input-street-nexternal').val()
    var suburb = $('#input-suburb').val()
    var delegation = $('#input-delegacy').val()
    var postal_code = $('#input-zip-code').val()
    var country_id = $('#vendorCountry').find('option:selected').val()
    var state_id = $('#vendorState').find('option:selected').val()
    var city = $('#input-city').val()
    var mobile = $('#input-mobile').val()
    var phone = $('#input-phone').val()
    var path_official_identification = $('#input-officialId').val()
    if (path_official_identification == '') {
    } else {
        path_official_identification = document.getElementById('input-officialId').files[0]
    }
    var vendorServices = $('#vendorServices').val()
    var key_rfc = $('#input-key-rfc').val()
    var path_cover_rfc = $('#input-proof-tax').val()
    if (path_cover_rfc == '') {
    } else {
        path_cover_rfc = document.getElementById('input-proof-tax').files[0]
    }
    var path_32d = $('#input-tax-32d').val()
    if (path_32d == '') {
    } else {
        path_32d = document.getElementById('input-tax-32d').files[0]
    }
    $(this).serialize();
    var data = new FormData();
    data.append('vendorId', vendorId)
    data.append('name', name)
    data.append('legal_name', legal_name)
    data.append('contact_name', contact_name)
    data.append('path_address_proof', path_address_proof)
    data.append('street', street)
    data.append('inner_number', inner_number)
    data.append('outer_number', outer_number)
    data.append('suburb', suburb)
    data.append('delegation', delegation)
    data.append('postal_code', postal_code)
    data.append('country_id', country_id)
    data.append('state_id', state_id)
    data.append('city', city)
    data.append('path_official_identification', path_official_identification)
    data.append('vendorServices', vendorServices)
    data.append('key_rfc', key_rfc)
    data.append('path_cover_rfc', path_cover_rfc)
    data.append('path_32d', path_32d)
    data.append('mobile', mobile)
    data.append('phone', phone)


    swal({
        text: document.getElementById('vendorCompleteText05').innerHTML,
        showCancelButton: true,
        confirmButtonText: document.getElementById('vendorCompleteText02').innerHTML,
        cancelButtonText: document.getElementById('vendorCompleteText03').innerHTML,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function (e) {
        if (e.value === true) {
            swal({
                title: document.getElementById('vendorCompleteText04').innerHTML,
                html: '<div id="loadingTime" class="loaderSpinnerLogin"></div>',
                showConfirmButton: false
            });
            $.ajax({
                type: 'post',
                url: routeRequest,
                data: data,
                processData: false,
                cache: false,
                contentType: false,
                success: function (results) {
                    console.log(results[1])
                    if (results.updateVendor) {
                        swal({
                            text: results.message,
                            confirmButtonText: results.btnSuccess,
                            confirmButtonClass: 'btn btn-info',
                        }).then(function (e) {
                            if (e.value === true) {
                                location.reload();
                            } else {
                                e.dismiss;
                            }
                        }, function (dismiss) {
                            return false;
                        }
                        )
                    } else {
                        swal({
                            text: results.message,
                            confirmButtonText: results.btnSuccess,
                            confirmButtonClass: 'btn btn-info',
                        });
                    }
                }
            });

        } else {
            e.dismiss;
        }
    }, function (dismiss) {
        return false;
    }
    )
}




function addBankChanges(type) {
    var name = $('#input-name').val()
    var legal_name = $('#input-legal').val()
    var contact_name = $('#input-contact').val()
    var path_address_proof = $('#input-proofResidency').val()
    if (path_address_proof == '') {
    } else {
        path_address_proof = document.getElementById('input-proofResidency').files[0]
    }
    var street = $('#input-street-name').val()
    var inner_number = $('#input-street-ninternal').val()
    var outer_number = $('#input-street-nexternal').val()
    var suburb = $('#input-suburb').val()
    var delegation = $('#input-delegacy').val()
    var postal_code = $('#input-zip-code').val()
    var country_id = $('#vendorCountry').find('option:selected').val()
    var state_id = $('#vendorState').find('option:selected').val()
    var city = $('#input-city').val()
    var mobile = $('#input-mobile').val()
    var phone = $('#input-phone').val()
    var path_official_identification = $('#input-officialId').val()
    if (path_official_identification == '') {
    } else {
        path_official_identification = document.getElementById('input-officialId').files[0]
    }
    var vendorServices = $('#vendorServices').val()
    var key_rfc = $('#input-key-rfc').val()
    var path_cover_rfc = $('#input-proof-tax').val()
    if (path_cover_rfc == '') {
    } else {
        path_cover_rfc = document.getElementById('input-proof-tax').files[0]
    }
    var path_32d = $('#input-tax-32d').val()
    if (path_32d == '') {
    } else {
        path_32d = document.getElementById('input-tax-32d').files[0]
    }
    var routeRequest = mainRoute + "vendor/addBankChanges";
    swal({
        text: document.getElementById('vendorCompleteText05').innerHTML,
        showCancelButton: true,
        confirmButtonText: document.getElementById('vendorCompleteText02').innerHTML,
        cancelButtonText: document.getElementById('vendorCompleteText03').innerHTML,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function (e) {
        if (e.value === true) {
            swal({
                title: document.getElementById('vendorCompleteText04').innerHTML,
                html: '<div id="loadingTime" class="loaderSpinnerLogin"></div>',
                showConfirmButton: false
            });
            if (type == 1) {
                var bank = $('#input-bank').val()
                var account_owner = $('#input-account_owner').val()
                var vendorId = $('#vendorId').val()
                var account_number = $('#input-account_number').val()
                var clabe = $('#input-clabe').val()
                var path_account_statement = $('#input-path_account_statement').val()
                var swift = $('#input-swift').val()
                if (path_account_statement == '') {
                } else {
                    path_account_statement = document.getElementById('input-path_account_statement').files[0]
                }
            } else {
                var bank = $('#input-bankEdit').val()
                var account_owner = $('#input-account_ownerEdit').val()
                var vendorId = $('#vendorId').val()
                var account_number = $('#input-account_numberEdit').val()
                var clabe = $('#input-clabeEdit').val()
                var path_account_statement = $('#input-path_account_statementEdit').val()
                var swift = $('#input-swiftEdit').val()
                if (path_account_statement == '') {
                } else {
                    path_account_statement = document.getElementById('input-path_account_statementEdit').files[0]
                }
            }

            var countrySelect = $('#vendorCountry').find('option:selected').val()
            var classClabe = ''
            var classSwift = ''
            if (countrySelect != '142') {
                classClabe = 'd-none'
            } else {
                classSwift = 'd-none'
            }

            $(this).serialize();
            var data = new FormData();
            data.append('bank', bank)
            data.append('countrySelect', countrySelect)
            data.append('vendorId', vendorId)
            data.append('account_owner', account_owner)
            data.append('account_number', account_number)
            data.append('clabe', clabe)
            data.append('path_account_statement', path_account_statement)
            data.append('swift', swift)
            data.append('type', type)
            data.append('idBank', $('#idEditAccount').val())
            data.append('name', name)
            data.append('legal_name', legal_name)
            data.append('contact_name', contact_name)
            data.append('path_address_proof', path_address_proof)
            data.append('street', street)
            data.append('inner_number', inner_number)
            data.append('outer_number', outer_number)
            data.append('suburb', suburb)
            data.append('delegation', delegation)
            data.append('postal_code', postal_code)
            data.append('country_id', country_id)
            data.append('state_id', state_id)
            data.append('city', city)
            data.append('path_official_identification', path_official_identification)
            data.append('vendorServices', vendorServices)
            data.append('key_rfc', key_rfc)
            data.append('path_cover_rfc', path_cover_rfc)
            data.append('path_32d', path_32d)
            data.append('mobile', mobile)
            data.append('phone', phone)
            $.ajax({
                type: 'post',
                url: routeRequest,
                data: data,
                processData: false,
                cache: false,
                contentType: false,
                success: function (results) {
                    console.log(results.bank)
                    if (results.updateVendor) {
                        swal({
                            text: results.message,
                            confirmButtonText: results.btnSuccess,
                            confirmButtonClass: 'btn btn-info',
                        }).then(function (e) {
                            if (e.value === true) {
                                location.reload();
                            } else {
                                e.dismiss;
                            }
                        }, function (dismiss) {
                            return false;
                        }
                        )
                    } else {
                        swal({
                            text: results.message,
                            confirmButtonText: results.btnSuccess,
                            confirmButtonClass: 'btn btn-info',
                        });
                    }
                }
            });

        } else {
            e.dismiss;
        }
    }, function (dismiss) {
        return false;
    }
    )
}

function createVariableFilter() {
    localStorage.setItem("filter", true);
}

function wait(time) {
    return new Promise(resolve => {
        setTimeout(() => {
            resolve();
        }, time);
    });
}


function isPageFullyLoaded() {
    if (document.readyState == "loaded" || document.readyState == "interactive" || document.readyState == "complete") {
        $('#datatables').addClass('d-none')
        document.getElementById("filterVendorStatus").selectedIndex = "3";
        document.getElementById('filterVendorStatus').dispatchEvent(new Event('change'));
        localStorage.clear()
        $('#datatables').removeClass('d-none')
        clearInterval(tmrReady);
    }
}
var tmrReady
async function filterVendorJs() {
    var routeActual = window.location.href
    if (vendorApprove) {
        tmrReady = setInterval(isPageFullyLoaded, 100);
    }
    if (routeActual.substr(-7, 7) == 'approve') {
        tmrReady = setInterval(isPageFullyLoaded, 100);
    }


}

$('.dataTables_info').ready(footer_bg());
async function footer_bg() {
    await wait(100);
    if ($('.dataTables_info').parents('.col-sm-12').parents('.row').length == 0) { footer_bg() }
    else { $('.dataTables_info').parent('.col-sm-12').parent('.row').css('background-color', '#fff') }
}

