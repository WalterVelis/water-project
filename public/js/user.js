/* $("#role_input").select2({
}) */

function roleDetection(){

    var selectRol = document.getElementById("role_input")
    var rolName = selectRol.options[selectRol.selectedIndex].text
    var vendorDiv = $('#vendorDiv')
    document.getElementById('rol-text').value = rolName


    if(rolName == "Vendor"){
        vendorDiv.removeClass('d-none')
    }else{
        vendorDiv.addClass('d-none')
        $('input[name=is_external]').prop('checked',false);
    }


}



var userF = true
function emailUnique(){

    var emailT = ''

    if($("#input-email").val() == ''){
        emailT = '----------'
    }else{
        emailT = $("#input-email").val()
    }

    if( $('#formType').val() == 'formCreate' ){
        var routeRequest = mainRoute + "user/uniqueEmail/" + emailT
    }else{
        var routeRequest = mainRoute + "user/uniqueEmailEdit/" + emailT + "/" + $('#oldEmailUser').val()
    }

    $.get(routeRequest, function (res) {
        if (res.length === 0) {
            userF = true;
            var spanUniqueName = $('#errorEmailU');
            spanUniqueName.removeClass("error text-danger");
            spanUniqueName.addClass("d-none");
        }
        if (res.length > 0) {

            var spanUniqueName = $('#errorEmailU');
            spanUniqueName.removeClass("d-none");
            spanUniqueName.addClass("error text-danger");
            userF = false;
        }
    });

}

var emailF = true
var nameF = true
var roleF = true


function validationSave(){

    var spanRole = $('#errorRoleUser')
    var spanName = $('#errorNameUser')
    var spanEmail = $('#errorEmailUserXX')


    if($('#input-name').val() == ''){
        spanName.removeClass("d-none");
        spanName.addClass("error text-danger");
        nameF = false

    }else{
        nameF = true
        spanName.removeClass("error text-danger");
        spanName.addClass("d-none");

    }

    if($('#input-email').val() == ''){
        spanEmail.removeClass("d-none");
        spanEmail.addClass("error text-danger");
        emailF = false

    }else{
        emailF = true
        spanEmail.removeClass("error text-danger");
        spanEmail.addClass("d-none");

    }

    if($('#input-phone').val() == ''){
        $('#errorPhoneXX').removeClass("d-none");
        $('#errorPhoneXX').addClass("error text-danger");

    }else{
        $('#errorPhoneXX').removeClass("error text-danger");
        $('#errorPhoneXX').addClass("d-none");

    }

    if($('#role_input').val() == 0){
        spanRole.removeClass("d-none");
        spanRole.addClass("error text-danger");
        roleF = false

    }else{
        roleF = true
        spanRole.removeClass("error text-danger");
        spanRole.addClass("d-none");

    }

    if(userF){

        if($('#rol-text').val() == 'Vendor'){

            var spanVendor = $('#errorVendor');

            if ( document.getElementById('radio1X').checked == true || document.getElementById('radio2X').checked == true ) {
                spanVendor.removeClass("error text-danger");
                spanVendor.addClass("d-none");
                if(emailF == true && nameF == true && roleF == true){
                    $('#saveUser2').click()
                    var spanUniqueName = $('#errorEmailU');
                    spanUniqueName.removeClass("error text-danger");
                    spanUniqueName.addClass("d-none")
                }
            }else{
                spanVendor.removeClass("d-none");
                spanVendor.addClass("error text-danger");
            }

        }else{
            $('#saveUser').click()
            var spanUniqueName = $('#errorEmailU');
            spanUniqueName.removeClass("error text-danger");
            spanUniqueName.addClass("d-none")
        }

    }

}




function validationSaveUpdate(){

    var spanRole = $('#errorRoleUser')
    var spanName = $('#errorNameUser')
    var spanEmail = $('#errorEmailUserXX')


    if($('#input-name').val() == ''){
        spanName.removeClass("d-none");
        spanName.addClass("error text-danger");
        nameF = false

    }else{
        nameF = true
        spanName.removeClass("error text-danger");
        spanName.addClass("d-none");

    }

    if($('#input-email').val() == ''){
        spanEmail.removeClass("d-none");
        spanEmail.addClass("error text-danger");
        emailF = false

    }else{
        emailF = true
        spanEmail.removeClass("error text-danger");
        spanEmail.addClass("d-none");

    }

    if($('#role_input').val() == ''){
        spanRole.removeClass("d-none");
        spanRole.addClass("error text-danger");
        roleF = false

    }else{
        roleF = true
        spanRole.removeClass("error text-danger");
        spanRole.addClass("d-none");

    }

    if(userF){

        if($('#rol-text').val() == 'Vendor'){

            var spanVendor = $('#errorVendor');

            // if ( document.getElementById('radio1X').checked == true || document.getElementById('radio2X').checked == true ) {
                spanVendor.removeClass("error text-danger");
                spanVendor.addClass("d-none");
                if(emailF == true && nameF == true && roleF == true){
                    if( document.getElementById('sameValue').innerHTML == 'Vendor'){
                        $('#saveUser').click()
                        var spanUniqueName = $('#errorEmailU');
                        spanUniqueName.removeClass("error text-danger");
                        spanUniqueName.addClass("d-none")

                    }else{
                        $('#saveUser2').click()
                        var spanUniqueName = $('#errorEmailU');
                        spanUniqueName.removeClass("error text-danger");
                        spanUniqueName.addClass("d-none")
                    }
                }
            // }else{
            //     spanVendor.removeClass("d-none");
            //     spanVendor.addClass("error text-danger");
            // }

        }else{
            $('#saveUser').click()
            var spanUniqueName = $('#errorEmailU');
            spanUniqueName.removeClass("error text-danger");
            spanUniqueName.addClass("d-none")
        }

    }

}
