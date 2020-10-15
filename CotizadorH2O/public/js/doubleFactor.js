function showByEmail(){
    $('#loadingTime').addClass('d-none')
    $('#2fa-byEmail').removeClass('d-none');
    $('#2fa-byGoogle').addClass('d-none');    
} 




async function showByGoogle() {    
    $('#2fa-byGoogle').addClass('d-none');     
    $('#2fa-byEmail').addClass('d-none')
    $('#loadingTime').removeClass('d-none')
    var routeRequest = mainRoute + "profile/auth-google";
    $.ajax({
        type: 'post',
        url: routeRequest,
        headers: { 'X-CSRF-TOKEN': $('#tokenQr').val() },
        success: function (r) {
            if (r != 0) {
                document.getElementById('imgQR').setAttribute('src', r.urlQR)
            }
        }
    });
    await wait(3000);
    $('#loadingTime').addClass('d-none')
    $('#2fa-byGoogle').removeClass('d-none')


}

function sendEmailJs(){
    $('#divLoadEmail').removeClass('d-none')
    var routeRequest = mainRoute + "profile/auth-google-sendEmail";
    $.ajax({
        type: 'post',
        url: routeRequest,
        data: {
            email_2fa: $('#input-email_2fa').val(),
        },
        success: function (r) {
            if (r.emailSend) {
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
                $('#divCodeEmail').removeClass('d-none')
                $('#activateEmail').addClass('d-none')
                $('#activateEmailCode').removeClass('d-none')
                $('#divLoadEmail').addClass('d-none')
            }else{

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
                $('#divLoadEmail').addClass('d-none')

            }
        }
    });

}

function verficateEmailCode(){
    var routeRequest = mainRoute + "profile/auth-google-sendEmailCode"
        $.ajax({
            type: 'post',
            url: routeRequest,
            data: {
                code: $('#code').val(),
            },
            success: function (r) {
                if (r != 0) {
                    if (r.token_code_controller) {
                        document.getElementById('activeSecurity').click()
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


function googleValidate(){

    if( ($('#code_verification').val() == '' ) ){
        $('#errorCode').removeClass('d-none')
        $('#errorCode').addClass('text-danger')
    }else{

        $('#errorCode').addClass('d-none')
        $('#errorCode').removeClass('text-danger')
        var routeRequest = mainRoute + "profile/auth-google-form";
        $.ajax({
            type: 'post',
            url: routeRequest,
            headers: { 'X-CSRF-TOKEN': $('#tokenQr').val() },
            data: {
                code_verification: $('#code_verification').val(),
            },
            success: function (r) {
                if (r != 0) {
                    if(r.statusCode){
                        $('#btn-google').click()
                    }else{

                        $.notify({
                            icon: "error",
                            message: document.getElementById('msjError').innerHTML
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