// d-search-contact d-new-contact
function showEditContactAgency(contact_id) {
    name = $('#rowContactAgency' + contact_id).find('td:eq(1)').text();
    $('#edit_contact_agency').val(name);
    $('#d-edit-contact-agency').removeClass('d-none');
    $('#d-new-contact-agency').addClass('d-none');
    $('#hiddenEditContactAgency').val(contact_id);
    $('#errorEditContactAgency').addClass('d-none')
}
function confirmNewContactAgency() {
    name = $('#new_contact_agency').val();
    erroCode = $('#errorNewContactAgency');

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
            url: mainRoute + "agency/addContact",
            headers: { 'X-CSRF-TOKEN': $('#tokenBudget').val() },
            data: {
                agency_id: $("#agency_id").find('option:selected').val(),
                name: name,
            },
            success: function (r) {
                if (r != 0) {
                    fillTableContactAgency(r);
                    showSaveMessage();
                    $('#new_contact_agency').val('');
                }
            }
        });
    }

}
function confirmEditContactAgency() {
    name = $('#edit_contact_agency').val();
    erroCode = $('#errorEditContactAgency');

    if (name == '') {
        erroCode.removeClass('d-none')
        flagName = false
    } else {
        erroCode.addClass('d-none')
        flagName = true
    }
    if (flagName == true) {
        contact_id = $('#hiddenEditContactAgency').val();
        $.ajax({
            type: 'post',
            url: mainRoute + "agency/editContact",
            headers: { 'X-CSRF-TOKEN': $('#tokenBudget').val() },
            data: {
                contact_id: contact_id,
                name: name,
            },
            success: function (r) {
                if (r != 0) {
                    showSaveMessage();
                    $('#rowContactAgency' + contact_id).find('td:eq(1)').text(name);
                    //To uptade select2 client_contact_id for step1
                    aux = $('#agency_contact_id').find('option').length;
                    aux2 = $('#agency_contact_id').find('option:selected').val();
                    save_id = [];
                    save_text = [];
                    for (i = 0; i < aux; i++) {
                        save_id[i] = $('#agency_contact_id').find('option:eq(' + i + ')').val();
                        save_text[i] = $('#agency_contact_id').find('option:eq(' + i + ')').text();
                        if (save_id[i] == r) {
                            save_text[i] = name;
                        }
                    }
                    $('#agency_contact_id').find('option').remove();
                    if (ln() == 'es') {
                        $('#agency_contact_id').append('<option value="" selected disabled style="background-color:lightgray">Seleccione un contacto</option>');
                    } else {
                        $('#agency_contact_id').append('<option value="" selected disabled style="background-color:lightgray">Select a contact</option>');
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
                        $('#agency_contact_id').append(html);
                    }

                }
            }
        });
    }
    cleanEditContactAgency();
}
function cleanEditContactAgency() {
    $('#d-edit-contact-agency').addClass('d-none');
    $('#d-new-contact-agency').removeClass('d-none');
    $('#edit_contact_agency').val('');
    $('#errorEditContactAgency').addClass('d-none')
    $('#errorNewContactAgency').addClass('d-none')

}
// fillTableContact
function fillTableContactAgency(r) {
    table = $('#contactAgencyBudget');
    table.find('tr').remove();

    select = $('#agency_contact_id');
    actual = select.find('option:selected').val();

    $(r).each(function (key, value) {
        if (actual == value.id) {
            value.count = value.count - 1;
        }
        if (value.count != 0) {
            btn = "";
        } else {
            btn = '<button type="button" class="btn btn-danger btn-link" type="button" data-original-title="" title="" onclick="deleteContactAgency(' + value.id + ')">' +
                '<i class="material-icons">close</i>' +
                '<div class="ripple-container"></div>' +
                '</button >';
        }
        html = '<tr id="rowContactAgency' + value.id + '">' +
            '<td>' + (key + 1) + '</td>' +
            '<td class="rowCA">' + value.name + '</td>' +
            '<td class="td-actions text-right">' +
            '<button rel="tooltip" class="btn btn-success btn-link" type="button" data-original-title="" title="" onclick="showEditContactAgency(' + value.id + ')">' +
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
    }
    else {
        select.append('<option value="" disabled selected style="background-color:lightgray">Select a contact</option>');
    }

    $(r).each(function (key, value) {
        html = '<option value="' + value.id + '">' +
            value.name +
            '</option>';
        select.append(html);
    });
    $('#agency_contact_id option[value="' + actual + '"').attr("selected", true);
    $('#agency_name').val($('#agency_id').find('option:selected').text());
    $("#filter_contact_agency").val('');

}
function confirmDeleteContactAgency(contact_id) {
    console.log(contact_id);
    $.ajax({
        type: 'post',
        url: mainRoute + "agency/deleteContact",
        headers: { 'X-CSRF-TOKEN': $('#tokenBudget').val() },
        data: {
            contact_id: contact_id,
        },
        success: function (r) {
            if (r != 0) {
                showSaveMessage();
                //To delete form contact table
                $('#rowContactAgency' + contact_id).remove();
                //To delete select2 client_contact_id for step1
                select = $('#agency_contact_id');
                actual = select.find('option:selected').val();
                aux = $('#agency_contact_id option[value="' + contact_id + '"').remove();
                console.log(contact_id + "---" + actual);
                if ("" + contact_id + "" == actual) {
                    $("#agency_contact_id").val('').trigger('change');

                }
            }
        }
    });
}
$(document).ready(function () {
    $("#filter_contact_agency").keyup(async function () {
        var valor = $("#filter_contact_agency").val();
        console.log(valor);
        $(".rowCA").each(function () {
            nombres = $(this).text().toLowerCase();
            if (nombres.indexOf(valor.toLowerCase()) > -1) {
                $(this).parent("tr").show();
            } else {
                $(this).parent("tr").css("display", "none");
            }
        });
    });
}) 