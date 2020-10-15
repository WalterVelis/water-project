async function checkDoubleFactor() {
    var userName = $('#exampleEmails').val()
    var routeRequest = mainRoute + "user/doubleFactor"
    $('#loadingTime').removeClass('d-none')
    $('#exampleEmails').addClass('disabled')
    $('#examplePassword').addClass('disabled')
    $('#divP1').addClass('disabled')
    //await wait(500000000)

    $.ajax({
        type: 'post',
        url: routeRequest,
        data: {
            email: $('#exampleEmails').val(),
            password: $('#examplePassword').val(),
        },
        success: function (r) {
            if (r != 0) {

                if (r.is_user_found == false) {
                    if(r.refreshPage){
                        $.notify({
                            icon: "error",
                            message: document.getElementById('msjEmailError').innerHTML
                        }, {
                            type: 'danger',
                            timer: 3000,
                            placement: {
                                from: 'top',
                                align: 'right'
                            }
                        });
                        $('#exampleEmails').removeClass('disabled')
                        $('#examplePassword').removeClass('disabled')
                        $('#divP1').removeClass('disabled')
                        $('#loadingTime').addClass('d-none')
                    }else{
                        $('#formLogin').submit()//Submit using form not button
                    }                    
                }
                else {
                    $('#dataLogin').addClass('d-none')
                    $('#exampleEmails').removeClass('disabled')
                    $('#examplePassword').removeClass('disabled')
                    var tokenShow = $('#tokenDiv');
                    tokenShow.removeClass("d-none");
                    var p1 = $('#divP1')
                    p1.addClass('d-none')
                    document.getElementById('input-token-hidden').value = r.user_id
                    document.getElementById('input-status-token').value = r.is_google_factor
                    var p2 = $('#divP2')
                    p2.removeClass('d-none')
                    if (r.is_google_factor) {
                        $.notify({
                            icon: "done",
                            message: document.getElementById('msjTokenGoogle').innerHTML
                        }, {
                            type: 'info',
                            timer: 3000,
                            placement: {
                                from: 'top',
                                align: 'right'
                            }
                        });
                    } else {

                        $.notify({
                            icon: "done",
                            message: document.getElementById('msjEmail').innerHTML
                        }, {
                            type: 'success',
                            timer: 3000,
                            placement: {
                                from: 'top',
                                align: 'right'
                            }
                        });

                    }
                    $('#loadingTime').addClass('d-none')

                }



            }
        }
    });

}


function doubleFactorValidation() {
    var tokenHidden = $('#input-token-hidden').val()
    var tokenInput = $('#input-token').val()
    var flagGoogle = $('#input-status-token').val()

    if (flagGoogle == 'true') {

        var routeRequest = mainRoute + "user/doubleFactor/tokenGoogle/verificate"
        $.ajax({
            type: 'post',
            url: routeRequest,
            data: {
                user_id: tokenHidden,
                token_login_view: tokenInput,
            },
            success: function (r) {
                if (r != 0) {
                    if (r.token_code_controller) {
                        $('#formLogin').submit()//Submit using form not button
                    } else {
                        $.notify({
                            icon: "error",
                            message: document.getElementById('msjToken').innerHTML
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
            }
        });

    } else {
        var routeRequest = mainRoute + "user/doubleFactor/tokenEmail/verificate"
        $.ajax({
            type: 'post',
            url: routeRequest,
            data: {
                user_id: tokenHidden,
                token_login_view: tokenInput,
            },
            success: function (r) {
                if (r != 0) {
                    if (r.token_code_controller) {
                        $('#formLogin').submit()//Submit using form not button
                    } else {
                        $.notify({
                            icon: "error",
                            message: document.getElementById('msjToken').innerHTML
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
            }
        });
    }
}