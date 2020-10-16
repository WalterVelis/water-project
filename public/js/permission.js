//PerAM
//PerFM

//Identify the project path
var domain = window.location.host;
var protocol = window.location.protocol;
var mainRoute = '';
if (domain == "localhost" || domain == "127.0.0.1") {
    mainRoute = (protocol + "//" + "localhost/");
} else {
    mainRoute = (protocol + "//" + domain + "/");
}


//permission filtering functionality
function filterPermissions(){

    if($("#inputFP").val().length == 0){
        var routeRequest = mainRoute + "permission/all";
        var tableF = $("#tablePF");
        var header1 = document.getElementById("header1").value;
        var header2 = document.getElementById("header2").value;
        var messageF = $("#PerFM");
        $.get(routeRequest, function(res){
            if(res.length === 0){
                tableF.empty();
                messageF.removeClass("d-none");
                messageF.addClass("row d-flex justify-content-center");
            }
            if(res.length > 0){
                //document.getElementById("myTable").rows[0].cells.item(1).innerHTML                             
                var counterTableGlobal= document.getElementById("tablePA").getElementsByTagName('tr').length;
                tableF.empty();
                headF =
                    "<thead>" +
                    "<tr>" +
                    "<th>" + header1 + "</th>" +
                    "<th class='d-none'>" + "id" + "</th>" +
                    "<th class='text-right'>" + header2 + "</th>" +
                    "</tr>" +
                    "</thead>";
                tableF.append(headF);
                messageF.removeClass("row d-flex justify-content-center");
                messageF.addClass("d-none");   
                var countFalse = 0;             
                $(res).each(function (key, value) {
                    rowF =
                        "<tr style='background-color: white' id='filterRow"+key+"'>" +
                        "<td id='filterColumn02-"+key+"' >" + value.description + "</td>" +
                        "<td id='filterColumn03-"+key+"' class='d-none'>" + value.id + "</td>" +
                        "<td class='td-actions text-right'>" +
                        "<button type='submit' value=\""+key+"\" onclick='addPermission("+key+");' class='btn btn-lg btn-link'>" +
                        "<i class='material-icons'>add_circle</i>" +
                        "</button>" +
                        "</td>" +
                        "</tr>";

                    if(counterTableGlobal > 1){
                        var i;
                        var statusAssigned=true;
                        for (i = 1; i < counterTableGlobal; i++) {
                            if(document.getElementById("tablePA").rows[i].cells.item(0).innerHTML == value.description){
                                statusAssigned = false;
                                countFalse = countFalse+1;

                            }else{
                            }

                        }
                        if(statusAssigned === true){
                            tableF.append(rowF);
                        }
                    }else{
                        tableF.append(rowF);
                    } 

                    if(countFalse === res.length){
                        tableF.empty();
                        messageF.removeClass("d-none");
                        messageF.addClass("row d-flex justify-content-center");

                    }

                    
                    
                });
            }
        });
    }



    if($("#inputFP").val().length > 0){
        var routeRequest = mainRoute + "permission/searchName/" + $("#inputFP").val();
        var tableF = $("#tablePF");
        var header1 = document.getElementById("header1").value;
        var header2 = document.getElementById("header2").value;
        var messageF = $("#PerFM");
        $.get(routeRequest, function(res){
            if(res.length === 0){
                tableF.empty();
                messageF.removeClass("d-none");
                messageF.addClass("row d-flex justify-content-center");
            }
            if(res.length > 0){
                //document.getElementById("myTable").rows[0].cells.item(1).innerHTML                             
                var counterTableGlobal= document.getElementById("tablePA").getElementsByTagName('tr').length;
                tableF.empty();
                headF =
                    "<thead>" +
                    "<tr>" +
                    "<th>" + header1 + "</th>" +
                    "<th class='d-none'>" + "id" + "</th>" +
                    "<th class='text-right'>" + header2 + "</th>" +
                    "</tr>" +
                    "</thead>";
                tableF.append(headF);
                messageF.removeClass("row d-flex justify-content-center");
                messageF.addClass("d-none");   
                var countFalse = 0;             
                $(res).each(function (key, value) {
                    rowF =
                        "<tr style='background-color: white' id='filterRow"+key+"'>" +
                        "<td id='filterColumn02-"+key+"' >" + value.description + "</td>" +
                        "<td id='filterColumn03-"+key+"' class='d-none'>" + value.id + "</td>" +
                        "<td class='td-actions text-right'>" +
                        "<button type='submit' value=\""+key+"\" onclick='addPermission("+key+");' class='btn btn-lg btn-link'>" +
                        "<i class='material-icons'>add_circle</i>" +
                        "</button>" +
                        "</td>" +
                        "</tr>";

                    if(counterTableGlobal > 1){
                        var i;
                        var statusAssigned=true;
                        for (i = 1; i < counterTableGlobal; i++) {
                            if(document.getElementById("tablePA").rows[i].cells.item(0).innerHTML == value.description){
                                statusAssigned = false;
                                countFalse = countFalse+1;

                            }else{
                            }

                        }
                        if(statusAssigned === true){
                            tableF.append(rowF);
                        }
                    }else{
                        tableF.append(rowF);
                    } 

                    if(countFalse === res.length){
                        tableF.empty();
                        messageF.removeClass("d-none");
                        messageF.addClass("row d-flex justify-content-center");

                    }

                    
                    
                });
            }
        });
    }
}



//add permissions

function addPermission(e){


    //var tableF = $("#tablePF");
    //var tableA = $("#tablePA");
    var divA = $("#divTablePA");
    var messageA = $("#PerAM");

    var nameP = document.getElementById("filterColumn02-"+e).textContent;
    var idP = document.getElementById("filterColumn03-"+e).textContent;

    var counterRows = document.getElementById("tablePA").getElementsByTagName('tr');

    if(counterRows.length === 1){
        divA.removeClass("row d-none");
        divA.addClass("row");

        messageA.removeClass("row d-flex justify-content-center");
        messageA.addClass("d-none");

        var spanErrorPermission = $('#errorPermissions');
        spanErrorPermission.removeClass("row d-flex justify-content-center");
        spanErrorPermission.addClass("d-none");


    }

    key = counterRows.length -1;

    var tableA = $("#tablePA");

    rowA =
        "<tr style='background-color: white' id='selectedRow" + key + "'>" +
        "<td id='selectedColumn02-" + key + "' >" + nameP + "</td>" +
        "<td id='selectedColumn03-" + key + "' class='d-none'>" + idP + 
        "<input type='text' name='idPermission[]' value='"+idP+"' />"+
        "</td>" +
        "<td class='td-actions text-right'>" +
        "<p onclick='deletePermission(" + key + ");' class='btn btn-lg btn-link'>" +
        "<i class='material-icons'>remove_circle</i>" +
        "</p>" +
        "</td>" +
        "</tr>";

    tableA.append(rowA);
    $('#filterRow'+e).remove();

    var countP = Number(document.getElementById('input-permissionCount').value);
    document.getElementById('input-permissionCount').value = countP +1;

    var counterRows2 = document.getElementById("tablePF").getElementsByTagName('tr');
    var tableF = $("#tablePF");
    if(counterRows2.length === 1){
        document.getElementById("inputFP").value='';
        var routeRequest = mainRoute + "permission/all";
        var tableF = $("#tablePF");
        var header1 = document.getElementById("header1").value;
        var header2 = document.getElementById("header2").value;
        var messageF = $("#PerFM");
        $.get(routeRequest, function(res){
            if(res.length === 0){
                tableF.empty();
                messageF.removeClass("d-none");
                messageF.addClass("row d-flex justify-content-center");
            }
            if(res.length > 0){
                //document.getElementById("myTable").rows[0].cells.item(1).innerHTML                             
                var counterTableGlobal= document.getElementById("tablePA").getElementsByTagName('tr').length;
                tableF.empty();
                headF =
                    "<thead class='text-dark'>" +
                    "<tr>" +
                    "<th>" + header1 + "</th>" +
                    "<th class='d-none'>" + "id" + "</th>" +
                    "<th class='text-right'>" + header2 + "</th>" +
                    "</tr>" +
                    "</thead>";
                tableF.append(headF);
                messageF.removeClass("row d-flex justify-content-center");
                messageF.addClass("d-none");   
                var countFalse = 0;             
                $(res).each(function (key, value) {
                    rowF =
                        "<tr style='background-color: white' id='filterRow"+key+"'>" +
                        "<td id='filterColumn02-"+key+"' >" + value.description + "</td>" +
                        "<td id='filterColumn03-"+key+"' class='d-none'>" + value.id + "</td>" +
                        "<td class='td-actions text-right'>" +
                        "<button type='submit' value=\""+key+"\" onclick='addPermission("+key+");' class='btn btn-lg btn-link'>" +
                        "<i class='material-icons'>add_circle</i>" +
                        "</button>" +
                        "</td>" +
                        "</tr>";

                    if(counterTableGlobal > 1){
                        var i;
                        var statusAssigned=true;
                        for (i = 1; i < counterTableGlobal; i++) {
                            if(document.getElementById("tablePA").rows[i].cells.item(0).innerHTML == value.description){
                                statusAssigned = false;
                                countFalse = countFalse+1;

                            }else{
                            }

                        }
                        if(statusAssigned === true){
                            tableF.append(rowF);
                        }
                    }else{
                        tableF.append(rowF);
                    } 

                    if(countFalse === res.length){
                        tableF.empty();
                        messageF.removeClass("d-none");
                        messageF.addClass("row d-flex justify-content-center");

                    }

                    
                    
                });
            }
        });


    }

}



function deletePermission(e){

    $('#selectedRow'+e).remove();
    var tableF = $("#tablePF");
    tableF.empty();
    var messageF = $("#PerFM");
    document.getElementById("inputFP").value='';
    var counterRows = document.getElementById("tablePA").getElementsByTagName('tr');
    if(counterRows.length === 1){
        var divTablePA = $('#divTablePA')
        divTablePA.removeClass("row");
        divTablePA.addClass("d-none");

        var messageAP = $('#PerAM');
        messageAP.removeClass("d-none");
        messageAP.addClass("row d-flex justify-content-center");
    }

    var countP = Number(document.getElementById('input-permissionCount').value);
    document.getElementById('input-permissionCount').value = countP -1;



    var routeRequest = mainRoute + "permission/all";
    var tableF = $("#tablePF");
    var header1 = document.getElementById("header1").value;
    var header2 = document.getElementById("header2").value;
    var messageF = $("#PerFM");
    $.get(routeRequest, function (res) {
        if (res.length === 0) {
            tableF.empty();
            messageF.removeClass("d-none");
            messageF.addClass("row d-flex justify-content-center");
        }
        if (res.length > 0) {
            //document.getElementById("myTable").rows[0].cells.item(1).innerHTML                             
            var counterTableGlobal = document.getElementById("tablePA").getElementsByTagName('tr').length;
            tableF.empty();
            headF =
                "<thead>" +
                "<tr>" +
                "<th>" + header1 + "</th>" +
                "<th class='d-none'>" + "id" + "</th>" +
                "<th class='text-right'>" + header2 + "</th>" +
                "</tr>" +
                "</thead>";
            tableF.append(headF);
            messageF.removeClass("row d-flex justify-content-center");
            messageF.addClass("d-none");
            var countFalse = 0;
            $(res).each(function (key, value) {
                rowF =
                    "<tr style='background-color: white' id='filterRow" + key + "'>" +
                    "<td id='filterColumn02-" + key + "' >" + value.description + "</td>" +
                    "<td id='filterColumn03-" + key + "' class='d-none'>" + value.id + "</td>" +
                    "<td class='td-actions text-right'>" +
                    "<button type='submit' value=\"" + key + "\" onclick='addPermission(" + key + ");' class='btn btn-lg btn-link'>" +
                    "<i class='material-icons'>add_circle</i>" +
                    "</button>" +
                    "</td>" +
                    "</tr>";

                if (counterTableGlobal > 1) {
                    var i;
                    var statusAssigned = true;
                    for (i = 1; i < counterTableGlobal; i++) {
                        if (document.getElementById("tablePA").rows[i].cells.item(0).innerHTML == value.description) {
                            statusAssigned = false;
                            countFalse = countFalse + 1;

                        } else {
                        }

                    }
                    if (statusAssigned === true) {
                        tableF.append(rowF);
                    }
                } else {
                    tableF.append(rowF);
                }

                if (countFalse === res.length) {
                    tableF.empty();
                    messageF.removeClass("d-none");
                    messageF.addClass("row d-flex justify-content-center");

                }



            });
        }
    });

}



function PermissionDataValidation(){

    if( (document.getElementById("input-name").value == '') || ( document.getElementById('input-permissionCount').value == 0 ) ){

        if( document.getElementById("input-name").value == '' ){
            var spanErrorName = $('#errorNameP');
            spanErrorName.removeClass("d-none");
            spanErrorName.addClass("error text-danger");

            var spanUniqueName = $('#errorNameU');
            spanUniqueName.removeClass("error text-danger");
            spanUniqueName.addClass("d-none");
        }

        if( document.getElementById("input-name").value != '' ){

            var routeRequest = mainRoute + "role/uniqueName/" + $("#input-name").val();
            $.get(routeRequest, function (res) {
                if (res.length === 0) {
                    var spanUniqueName = $('#errorNameU');
                    spanUniqueName.removeClass("error text-danger");
                    spanUniqueName.addClass("d-none");
                }
                if (res.length > 0) {

                    var spanErrorName = $('#errorNameP');
                    spanErrorName.removeClass("error text-danger");
                    spanErrorName.addClass("d-none");


                    var spanUniqueName = $('#errorNameU');
                    spanUniqueName.removeClass("d-none");
                    spanUniqueName.addClass("error text-danger");
                }
            });
        }

        if( document.getElementById('input-permissionCount').value == 0 ){
            var spanErrorPermission = $('#errorPermissions');
            spanErrorPermission.removeClass("d-none");
            spanErrorPermission.addClass("row d-flex justify-content-center");
        }

    }else{

        var routeRequest = mainRoute + "role/uniqueName/" + $("#input-name").val();
        $.get(routeRequest, function (res) {
            if (res.length === 0) {
                var spanUniqueName = $('#errorNameU');
                spanUniqueName.removeClass("error text-danger");
                spanUniqueName.addClass("d-none");
                document.getElementById('permissionSave').click();
            }
            if (res.length > 0) {

                var spanErrorName = $('#errorNameP');
                spanErrorName.removeClass("error text-danger");
                spanErrorName.addClass("d-none");


                var spanUniqueName = $('#errorNameU');
                spanUniqueName.removeClass("d-none");
                spanUniqueName.addClass("error text-danger");
            }
        });

    }

}


function PermissionDataValidationUpdate(text){

    if( (document.getElementById("input-name").value == '') || ( document.getElementById('input-permissionCount').value == 0 ) ){

        if( document.getElementById("input-name").value == '' ){
            var spanErrorName = $('#errorNameP');
            spanErrorName.removeClass("d-none");
            spanErrorName.addClass("error text-danger");

            var spanUniqueName = $('#errorNameU');
            spanUniqueName.removeClass("error text-danger");
            spanUniqueName.addClass("d-none");
        }

        if( document.getElementById("input-name").value != '' ){

            var routeRequest = mainRoute + "role/uniqueUpdateName/" + $("#input-name").val()+"/"+text;
            $.get(routeRequest, function (res) {
                if (res.length === 0) {
                    var spanUniqueName = $('#errorNameU');
                    spanUniqueName.removeClass("error text-danger");
                    spanUniqueName.addClass("d-none");
                }
                if (res.length > 0) {

                    var spanErrorName = $('#errorNameP');
                    spanErrorName.removeClass("error text-danger");
                    spanErrorName.addClass("d-none");


                    var spanUniqueName = $('#errorNameU');
                    spanUniqueName.removeClass("d-none");
                    spanUniqueName.addClass("error text-danger");
                }
            });
        }

        if( document.getElementById('input-permissionCount').value == 0 ){
            var spanErrorPermission = $('#errorPermissions');
            spanErrorPermission.removeClass("d-none");
            spanErrorPermission.addClass("row d-flex justify-content-center");
        }

    }else{

        var routeRequest = mainRoute + "role/uniqueUpdateName/" + $("#input-name").val() + "/" + text;
        $.get(routeRequest, function (res) {
            if (res.length === 0) {
                var spanUniqueName = $('#errorNameU');
                spanUniqueName.removeClass("error text-danger");
                spanUniqueName.addClass("d-none");
                document.getElementById('permissionSave').click();
            }
            if (res.length > 0) {

                var spanErrorName = $('#errorNameP');
                spanErrorName.removeClass("error text-danger");
                spanErrorName.addClass("d-none");


                var spanUniqueName = $('#errorNameU');
                spanUniqueName.removeClass("d-none");
                spanUniqueName.addClass("error text-danger");
            }
        });

    }

}