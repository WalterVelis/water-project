// d-search-contact d-new-contact
function showEditContact(contact_id) {
    name = $('#rowContact' + contact_id).find('td:eq(1)').text();
    $('#edit_contact').val(name);
    $('#d-edit-contact').removeClass('d-none');
    $('#d-new-contact').addClass('d-none');
    $('#hiddenEditContact').val(contact_id);
    $('#errorEditContact').addClass('d-none')
}
function confirmNewContact() {
    name = $('#new_contact').val();
    erroCode = $('#errorNewContact');

    if (name == '') {
        erroCode.removeClass('d-none')
        flagName = false
    } else {
        erroCode.addClass('d-none')
        flagName = true
    }
    if (flagName == true) {
        $.ajax({
            type: 'post',
            url: mainRoute + "client/addContact",
            headers: { 'X-CSRF-TOKEN': $('#tokenBudget').val() },
            data: {
                client_id: $("#client_id").find('option:selected').val(),
                name: name,
            },
            success: function (r) {
                if (r != 0) {
                    fillTableContact(r);
                    showSaveMessage();
                    $('#new_contact').val('');
                }
            }
        });
    }

}
function confirmEditContact() {
    name = $('#edit_contact').val();
    erroCode = $('#errorEditContact');

    if (name == '') {
        erroCode.removeClass('d-none')
        flagName = false
    } else {
        erroCode.addClass('d-none')
        flagName = true
    }
    if (flagName == true) {
        contact_id = $('#hiddenEditContact').val();
        $.ajax({
            type: 'post',
            url: mainRoute + "client/editContact",
            headers: { 'X-CSRF-TOKEN': $('#tokenBudget').val() },
            data: {
                contact_id: contact_id,
                name: name,
            },
            success: function (r) {
                if (r != 0) {
                    showSaveMessage();
                    $('#rowContact' + contact_id).find('td:eq(1)').text(name);
                    //To uptade select2 client_contact_id for step1
                    aux = $('#client_contact_id').find('option').length;
                    aux2 = $('#client_contact_id').find('option:selected').val();
                    save_id = [];
                    save_text = [];
                    for (i = 0; i < aux; i++) {
                        save_id[i] = $('#client_contact_id').find('option:eq(' + i + ')').val();
                        save_text[i] = $('#client_contact_id').find('option:eq(' + i + ')').text();
                        if (save_id[i] == r) {
                            save_text[i] = name;
                        }
                    }
                    $('#client_contact_id').find('option').remove();
                    if (ln() == 'es') {
                        $('#client_contact_id').append('<option value="" selected disabled style="background-color:lightgray">Seleccione un contacto</option>');
                    }
                    else {
                        $('#client_contact_id').append('<option value="" selected disabled style="background-color:lightgray">Select a contact</option>');
                    }
                    for (i = 1; i < aux; i++) {
                        if (save_id[i] != aux2) {
                            html = '<option value="' + save_id[i] + '">' +
                                save_text[i] +
                                '</option>';
                        } else {
                            html = '<option value="' + save_id[i] + '" selected>' +
                                save_text[i] +
                                '</option>';
                        }
                        $('#client_contact_id').append(html);
                    }

                }
            }
        });
    }
    cleanEditContact();
}
function cleanEditContact() {
    $('#d-edit-contact').addClass('d-none');
    $('#d-new-contact').removeClass('d-none');
    $('#edit_contact').val('');
    $('#errorEditContact').addClass('d-none')
    $('#errorNewContact').addClass('d-none')
}
// fillTableContact
function fillTableContact(r) {
    table = $('#contactBudget');
    table.find('tr').remove();

    select = $('#client_contact_id');
    actual = select.find('option:selected').val();

    $(r).each(function (key, value) {
        if (actual == value.id) {
            value.count = value.count - 1;
        }
        if (value.count != 0) {
            btn = "";
        } else {
            btn = '<button type="button" class="btn btn-danger btn-link" type="button" data-original-title="" title="" onclick="deleteContact(' + value.id + ')">' +
                '<i class="material-icons">close</i>' +
                '<div class="ripple-container"></div>' +
                '</button >';
        }
        html = '<tr id="rowContact' + value.id + '">' +
            '<td>' + (key + 1) + '</td>' +
            '<td class="rowC">' + value.name + '</td>' +
            '<td class="td-actions text-right">' +
            '<button rel="tooltip" class="btn btn-success btn-link" type="button" data-original-title="" title="" onclick="showEditContact(' + value.id + ')">' +
            '<i class="material-icons">edit</i>' +
            '<div class="ripple-container"></div>' +
            '</button>' +
            btn +
            '</td>' +
            '</tr>';
        table.append(html);
    });

    select.find('option').remove();
    if (ln() == 'es') {
        select.append('<option value="" disabled selected style="background-color:lightgray">Seleccione un contacto</option>');
    } else {
        select.append('<option value="" disabled selected style="background-color:lightgray">Select a contact</option>');
    }

    $(r).each(function (key, value) {
        html = '<option value="' + value.id + '">' +
            value.name +
            '</option>';
        select.append(html);
    });
    $('#client_contact_id option[value="' + actual + '"').attr("selected", true);
    $('#client_name').val($('#client_id').find('option:selected').text());
    $("#filter_contact").val('');

}
function confirmDeleteContact(contact_id) {
    console.log(contact_id);
    $.ajax({
        type: 'post',
        url: mainRoute + "client/deleteContact",
        headers: { 'X-CSRF-TOKEN': $('#tokenBudget').val() },
        data: {
            contact_id: contact_id,
        },
        success: function (r) {
            if (r != 0) {
                showSaveMessage();
                //To delete form contact table
                $('#rowContact' + contact_id).remove();
                //To delete select2 client_contact_id for step1
                select = $('#client_contact_id');
                actual = select.find('option:selected').val();
                aux = $('#client_contact_id option[value="' + contact_id + '"').remove();
                console.log(contact_id + "---" + actual);
                if ("" + contact_id + "" == actual) {
                    console.log('Despues');
                    $("#client_contact_id").val('').trigger('change');

                }
            }
        }
    });
}
$(document).ready(function () {
    $("#filter_contact").keyup(async function () {
        var valor = $("#filter_contact").val();
        console.log(valor);
        $(".rowC").each(function () {
            nombres = $(this).text().toLowerCase();
            if (nombres.indexOf(valor.toLowerCase()) > -1) {
                $(this).parent("tr").show();
            } else {
                $(this).parent("tr").css("display", "none");
            }
        });
    });
}) 