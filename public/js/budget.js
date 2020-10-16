function notifYSuccess(msm) {
    $.notify({
        icon: "done",
        message: msm
    }, {
        type: 'success',
        timer: 3000,
        placement: {
            from: 'top',
            align: 'right'
        }
    });

}

function wait(time) {
    return new Promise(resolve => {
        setTimeout(() => {
            resolve();
        }, time);
    });
}
async function showSaveMessage() {
    $('#show_save').removeClass('d-none');
    await wait(3000);
    $('#show_save').addClass('d-none');
}

function saveMeInput(field) {
    if (checkIt()) {
        var content = $("#" + field).val();
        var idBudget = $("#my_budget").val();
        var token = $('#tokenBudget').val();
        var preview = $("#p_" + field).val();

        if (content != '' && preview != content) {
            var routeRequest = mainRoute + "budget/saveField";

            $.ajax({
                type: 'post',
                url: routeRequest,
                headers: { 'X-CSRF-TOKEN': token },
                data: {
                    idBudget: idBudget,
                    field: field,
                    content: content,
                },
                success: function (r) {
                    if (r != 0) {
                        showSaveMessage();
                        $("#p_" + field).val(content);
                        checkEquivalences(field);
                        if (field == 'client_name') {
                            aux = $('#client_id').find('option').length;
                            aux2 = $('#client_id').find('option:selected').val();
                            save_id = [];
                            save_text = [];
                            for (i = 0; i < aux; i++) {
                                save_id[i] = $('#client_id').find('option:eq(' + i + ')').val();
                                save_text[i] = $('#client_id').find('option:eq(' + i + ')').text();
                                if (save_id[i] == r) {
                                    save_text[i] = content;
                                }
                            }
                            $('#client_id').find('option').remove();
                            if (ln() == 'es') {
                                $('#client_id').append('<option value="" disabled style="background-color:lightgray">Selecione un cliente</option>');
                            } else {
                                $('#client_id').append('<option value="" disabled style="background-color:lightgray">Select a client</option>');
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
                                $('#client_id').append(html);
                            }

                        }
                        if (field == 'agency_name') {
                            aux = $('#agency_id').find('option').length;
                            aux2 = $('#agency_id').find('option:selected').val();
                            save_id = [];
                            save_text = [];
                            for (i = 0; i < aux; i++) {
                                save_id[i] = $('#agency_id').find('option:eq(' + i + ')').val();
                                save_text[i] = $('#agency_id').find('option:eq(' + i + ')').text();
                                if (save_id[i] == r) {
                                    save_text[i] = content;
                                }
                            }
                            $('#agency_id').find('option').remove();
                            if (ln() == 'es') {
                                $('#agency_id').append('<option value="" disabled style="background-color:lightgray">Selecione un cliente</option>');
                            } else {
                                $('#agency_id').append('<option value="" disabled style="background-color:lightgray">Select a client</option>');
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
                                $('#agency_id').append(html);
                            }

                        }
                        // if (field == "project_name") {
                        //     name = $('#project_name').val();
                        //     number = $('#budget_number').val();
                        //     if (name == "") {
                        //         if (ln() == 'es') {
                        //             name = "Presupuesto";
                        //         } else {
                        //             name = "Budget";
                        //         }
                        //     }
                        //     $('#myBudget').find('td:eq(1)').find('a').text(name);
                        //     $('#labelSup').text(number + " " + name);
                        // }

                    }
                }
            });
        }
    }
}

function saveMeSelect(field) {
    if (checkIt()) {
        var content = $("#" + field).find('option:selected').val();
        var idBudget = $("#my_budget").val();
        var token = $('#tokenBudget').val();

        var routeRequest = mainRoute + "budget/saveField";

        if (content != '') {
            $.ajax({
                type: 'post',
                url: routeRequest,
                headers: { 'X-CSRF-TOKEN': token },
                data: {
                    idBudget: idBudget,
                    field: field,
                    content: content,
                },
                success: function (r) {
                    if (r != 0) {
                        console.log(field);
                        if (field == 'client_id') {
                            $('#legal_name').val(r.legal_name);
                            $('.d-client').find('img:eq(0)').attr('src', r.path_logo);
                            $('.d-client').find('img:eq(1)').attr('src', r.path_logo);
                            fillTableContact(r.contacts);
                            cleanEditContact()
                        }
                        if (field == 'agency_id') {
                            $('#legal_agency_name').val(r.legal_name);
                            $('.d-agency').find('img:eq(0)').attr('src', r.path_logo);
                            $('.d-agency').find('img:eq(1)').attr('src', r.path_logo);
                            fillTableContactAgency(r.contacts);
                            cleanEditContactAgency()
                        }
                        if (field == 'client_contact_id') {
                            fillTableContact(r);
                        }
                        if (field == 'agency_contact_id') {
                            fillTableContactAgency(r);
                        }
                        if (field == 'currency') {
                            updateEquivalences(content, r);
                        }
                        showSaveMessage();
                    }
                }
            });
        }
    } else {
        if (field == 'client_id') {
            $('#legal_name').val("");
            $('.d-client').find('img:eq(0)').attr('src', mainRoute + "material/img/image_placeholder.jpg");
            $('.d-client').find('img:eq(1)').attr('src', mainRoute + "material/img/image_placeholder.jpg");
            fillTableContact([]);
            cleanEditContact()
        }
        if (field == 'agency_id') {
            $('#legal_agency_name').val("");
            $('.d-agency').find('img:eq(0)').attr('src', mainRoute + "material/img/image_placeholder.jpg");
            $('.d-agency').find('img:eq(1)').attr('src', mainRoute + "material/img/image_placeholder.jpg");
            fillTableContactAgency([]);
            cleanEditContactAgency()
        }
    }
}

function saveMeClient(field) {
    value = $("#" + field).find('option:selected').val();
    string = $("#" + field).find('option:selected').text();
    if (value != "") {
        if (value == string) {
            var idBudget = $("#my_budget").val();
            var token = $('#tokenBudget').val();

            var routeRequest = mainRoute + "client/addClient";

            $.ajax({
                type: 'post',
                url: routeRequest,
                headers: { 'X-CSRF-TOKEN': token },
                data: {
                    budget_id: idBudget,
                    name: string,
                },
                success: function (r) {
                    if (r != 0) {
                        $('#legal_name').val(r.client.legal_name);
                        console.log(r.client.path_logo);
                        $('.d-client').find('img:eq(0)').attr('src', r.client.path_logo);
                        $('.d-client').find('img:eq(1)').attr('src', r.client.path_logo);
                        $('#' + field).empty();
                        if (ln() == 'es') {
                            $('#' + field).append('<option value="" disabled selected style="background-color:lightgray">Seleccione un cliente</option>');
                        } else {
                            $('#' + field).append('<option value="" disabled selected style="background-color:lightgray">Select a client</option>');
                        }
                        $(r.clients).each(function (key, value) {
                            if (r.client.id == value.id) {
                                $('#' + field).append('<option value="' + value.id + '" selected>' + value.name + '</option>');
                            } else {
                                $('#' + field).append('<option value="' + value.id + '">' + value.name + '</option>');
                            }
                        });
                        $('#contactBudget').find('tr').remove();
                        $('#client_name').val(r.client.name);
                        $('#client_contact_id').empty();
                        if (ln() == 'es') {
                            $('#client_contact_id').append('<option value="" disabled selected style="background-color:lightgray">Seleccione un contacto</option>');
                        } else {
                            $('#client_contact_id').append('<option value="" disabled selected style="background-color:lightgray">Select a contact</option>');
                        }
                        cleanEditContact()
                        showSaveMessage();
                    }
                }
            });
        } else {
            saveMeSelect(field);
        }
        $('.d-client').removeClass('d-none');
    }
}

function saveMeAgency(field) {
    value = $("#" + field).find('option:selected').val();
    string = $("#" + field).find('option:selected').text();
    if (value != "") {
        if (value == string) {
            var idBudget = $("#my_budget").val();
            var token = $('#tokenBudget').val();

            var routeRequest = mainRoute + "agency/addAgency";

            $.ajax({
                type: 'post',
                url: routeRequest,
                headers: { 'X-CSRF-TOKEN': token },
                data: {
                    budget_id: idBudget,
                    name: string,
                },
                success: function (r) {
                    if (r != 0) {
                        $('#legal_agency_name').val(r.agency.legal_name);
                        $('.d-agency').find('img:eq(0)').attr('src', r.agency.path_logo);
                        $('.d-agency').find('img:eq(1)').attr('src', r.agency.path_logo);
                        $('#' + field).empty();

                        if (ln() == 'es') {
                            $('#' + field).append('<option value="" disabled selected style="background-color:lightgray">Seleccione una agencia</option>');
                        } else {
                            $('#' + field).append('<option value="" disabled selected style="background-color:lightgray">Select an agency</option>');
                        }
                        $(r.agencies).each(function (key, value) {
                            if (r.agency.id == value.id) {
                                $('#' + field).append('<option value="' + value.id + '" selected>' + value.name + '</option>');
                            } else {
                                $('#' + field).append('<option value="' + value.id + '">' + value.name + '</option>');
                            }
                        });
                        $('#contactAgencyBudget').find('tr').remove();
                        $('#agency_name').val(r.agency.name);
                        $('#agency_contact_id').empty();
                        if (ln() == 'es') {
                            $('#agency_contact_id').append('<option value="" disabled selected style="background-color:lightgray">Seleccione un contacto</option>');
                        } else {
                            $('#agency_contact_id').append('<option value="" disabled selected style="background-color:lightgray">Select a contact</option>');
                        }
                        cleanEditContact()
                        showSaveMessage();
                    }
                }
            });
        } else {
            saveMeSelect(field);
        }
        $('.d-agency').removeClass('d-none');
    }
}

function saveMeImage(field) {
    if (checkIt()) {

        const fileList = document.getElementById(field).files;
        var image = fileList.length;
        if (image) {

            var idBudget = $("#my_budget").val();
            var token = $('#tokenBudget').val();

            $(this).serialize();
            var data = new FormData();
            var files = document.getElementById(field).files[0];
            data.append(field, files);
            data.append('field', field);
            data.append('idBudget', idBudget);

            var routeRequest = mainRoute + "budget/saveImage";

            $.ajax({
                type: 'post',
                url: routeRequest,
                headers: { 'X-CSRF-TOKEN': token },
                data: data,
                processData: false,
                cache: false,
                contentType: false,
                success: function (r) {
                    if (r != 0) {
                        showSaveMessage();
                    } else {
                        console.log('fails');
                    }
                }
            });
        }
    }
}

function ShowElements() {
    status = $('#hswitchShow').val();
    if (status == '0') {
        $('.uni').each(function () {
            if ($(this).attr('change') == '0' && $(this).attr('bva') == '') {
                $(this).addClass('notShow')
            }
        })
        if ($('.notShow').length > 0) {
            $('.myBlock').each(function () {
                block = $(this).attr('block')
                s_belongs = $('.belongsBlock' + block).length
                s_notShow = 0
                $('.belongsBlock' + block).each(function () {
                    if ($(this).hasClass('notShow')) {
                        s_notShow++
                    }
                })
                if (s_belongs == s_notShow) {
                    $(this).addClass('notShow')
                }
            })
            $('.mySection').each(function () {
                section = $(this).attr('section')
                s_belongs = $('.belongsSection' + section).length
                s_notShow = 0
                $('.belongsSection' + section).each(function () {
                    if ($(this).hasClass('notShow')) {
                        s_notShow++
                    }
                })
                if (s_belongs == s_notShow) {
                    $(this).addClass('notShow')
                }
            })
        }
        status = $('#hswitchShow').val('1');
    } else {
        $('.notShow').removeClass('notShow')
        status = $('#hswitchShow').val('0');
    }
}

function changePill(step) {
    if (checkIt()) {
        var routeRequest = mainRoute + "budget/saveStepWizard";
        $.ajax({
            type: 'post',
            url: routeRequest,
            headers: { 'X-CSRF-TOKEN': $('#tokenBudget').val() },
            data: {
                budget_id: $("#my_budget").val(),
                step: step,
            },
            success: function (r) {
                if (r != 0) {
                }
            }
        });
    }
}

async function changeNext() {
    if (checkIt()) {
        await wait(1000);
        panel = $('.tab-pane.active').attr('id');
        aux = panel.split('step');
        var routeRequest = mainRoute + "budget/saveStepWizard";
        $.ajax({
            type: 'post',
            url: routeRequest,
            headers: { 'X-CSRF-TOKEN': $('#tokenBudget').val() },
            data: {
                budget_id: $("#my_budget").val(),
                step: aux[1],
            },
            success: function (r) {
                if (r != 0) {
                }
            }
        });
    }
}
function ln() {
    return window.navigator.language || navigator.browserLanguage;
}
function evaluateText4(field) {//To let pass only 4 decimals

    valor = $('#' + field).val();
    var res = valor.split(".");

    if (res.length > 1) {
        if (res[1].length > 4) {
            show = parseFloat(res[0] + "." + res[1].substr(0, 2));
            $('#' + field).val(show.toFixed(4));
        }
    }
}
function evaluateText2(field) {//To let pass only 2 decimals

    valor = $('#' + field).val();
    var res = valor.split(".");

    if (res.length > 1) {
        if (res[1].length > 2) {
            show = parseFloat(res[0] + "." + res[1].substr(0, 2));
            $('#' + field).val(show.toFixed(2));
        }
    }
}
function formatNumber(value) {
    if ($('#hswitchRound').val() == '0') {
        v_t = value.split('.');
        const options2 = { style: 'decimal', currency: 'USD', maximumFractionDigits: 0 };
        const numberFormat2 = new Intl.NumberFormat('en-US', options2);
        return (numberFormat2.format(v_t[0])) + "." + v_t[1];
    } else {
        myFloat = parseFloat(value)
        myFloat = Math.round(myFloat)
        const options2 = { style: 'decimal', currency: 'USD' };
        const numberFormat2 = new Intl.NumberFormat('en-US', options2);
        return (numberFormat2.format(myFloat));
    }
}

// JS used in demo
function refreshEvents() {

    $("#myBudget").click(function () {
        budget = $(this)
        if (budget.attr('status') == '0') {
            // $('.belongsBudget').removeClass('d-none')
            // && !(section.hasClass('notShow'))
            $('.belongsBudget').removeClass('d-none')
            $('.tableHead').removeClass('d-none')

            budget.attr('status', '1')
            budget.find('i').css('color', '#ffffff')
            budget.find('a').css('color', '#ffffff')
            budget.find('i').text('keyboard_arrow_up')
        } else {
            $('.belongsBudget').addClass('d-none')
            $('.tableHead').addClass('d-none')
            budget.attr('status', '0')
            budget.find('i').css('color', '#fff')
            budget.find('a').css('color', '#fff')
            budget.find('i').text('keyboard_arrow_down')
            $('#divBudget').scrollTop(0);
            $('#divBudget').perfectScrollbar('update');
        }
    })
    $(".belongsBudget").click(function () {
        section = $(this)
        blocks = $('.belongsSection' + section.attr('section'))
        if (section.attr('status') == '0') {
            blocks.removeClass('d-none')
            section.attr('status', '1')
            section.find('i').css('color', '#fff')
            section.find('a').css('color', '#fff')
            section.find('i').text('keyboard_arrow_up')
        } else {
            blocks.addClass('d-none')
            section.attr('status', '0')
            section.find('i').css('color', '#fff')
            section.find('a').css('color', '#fff')
            section.find('i').text('keyboard_arrow_down')

        }

    })

    $(".myBlock").click(function () {
        block = $(this)
        accounts = $('.belongsBlock' + block.attr('block'))
        if (block.attr('status') == '0') {
            accounts.removeClass('d-none')
            block.attr('status', '1')
            block.find('i').css('color', '#333')
            block.find('a').css('color', '#333')
            block.find('i').text('keyboard_arrow_up')
        } else {
            accounts.addClass('d-none')
            block.attr('status', '0')
            block.find('i').css('color', '#333')
            block.find('a').css('color', '#333')
            block.find('i').text('keyboard_arrow_down')
        }
    })

    $(".myAccount").click(function () {
        account = $(this)
        saccounts = $('.belongsAccount' + account.attr('account'))
        if (account.attr('status') == '0') {
            saccounts.removeClass('d-none')
            account.attr('status', '1')
            account.find('i').text('keyboard_arrow_up')
        } else {
            saccounts.addClass('d-none')
            account.attr('status', '0')
            account.find('i').text('keyboard_arrow_down')
        }
    })

    $(".belongsBudget").attrchange({ //Sections
        trackValues: true,
        callback: function (evnt) {
            section = $(this)
            blocks = $('.belongsSection' + section.attr('section'))
            if (section.hasClass("d-none")) {
                blocks.addClass('d-none')
            } else if (section.attr('status') == '1') {
                blocks.removeClass('d-none')
            }
        }
    });

    $(".myBlock").attrchange({ //blocks
        trackValues: true,
        callback: function (evnt) {
            block = $(this)
            accounts = $('.belongsBlock' + block.attr('block'))
            if (block.hasClass("d-none")) {
                accounts.addClass('d-none')
            } else if (block.attr('status') == '1') {
                accounts.removeClass('d-none')
            }
        }
    });

    $(".myAccount").attrchange({ //accounts
        trackValues: true,
        callback: function (evnt) {
            account = $(this)
            saccounts = $('.belongsAccount' + account.attr('account'))
            if (account.hasClass("d-none")) {
                saccounts.addClass('d-none')
            } else if (account.attr('status') == '1') {
                saccounts.removeClass('d-none')
            }
        }
    });
    // Text
    $(".editText").click(function () {
        if (!$(this).parents('tr').hasClass('client') && (!$(this).parents('tr').hasClass('rowNotApproved') && !$(this).parents('tr').hasClass('rowNotApprovedC') || $('#actualUser').val() == "executive")) {
            if ($(this).parents('tr').hasClass('rowNotApprovedC')) {
                $(this).parents('tr').find('.backRow').click()
            }
            $(this).find('div').addClass('d-none')
            $(this).find('input').removeClass('d-none')
            $(this).find('input').focus()
            cleanSelects(0)
        }
    })
    $(".hideInput").blur(function () {
        $(this).parent('td').find('div').removeClass('d-none')
        before = $(this).parent('td').find('div').text()
        $(this).parent('td').find('div').text($(this).val())
        $(this).addClass('d-none')
        if (before != $(this).val()) {
            $(this).parents('td').parents('tr').attr('change', '1')
            $(this).parents('td').parents('tr').find('.btn').removeClass('d-none')
            if ($('#actualUser').val() == "executive") {
                if (!$(this).parent('td').hasClass('qt') && !$(this).parent('td').hasClass('qu')) {
                    if ($(this).parent('td').find('.cg').length == 1) { //new div cg (change)
                        $(this).parent('td').find('.cg').remove()
                    }
                    $(this).parent('td').find('input:eq(0)').after("<input class='cg' type='hidden' value='" + $(this).val() + "/" + before + "'/>")
                } else {
                    if ($(this).parent('td').find('.cg').length == 1) { //new div cg (change)
                        aux_cg = $(this).parent('td').find('.cg').val().split('/')
                        $(this).parent('td').find('.cg').val($(this).val() + "/" + aux_cg[1])
                    } else {
                        $(this).parent('td').find('input:eq(0)').after("<input class='cg' type='hidden' value='" + $(this).val() + "/" + before + "'/>")
                    }
                }
            }
        }
        checkCompleteThis($(this).parents('td').parents('tr'), 1)
    })
    // Time
    $(".editTime").click(function () {
        if (!$(this).parents('tr').hasClass('client') && (!$(this).parents('tr').hasClass('rowNotApproved') && !$(this).parents('tr').hasClass('rowNotApprovedC') || $('#actualUser').val() == "executive")) {
            cleanSelects(0)
            if ($(this).hasClass("off")) {
                if ($(this).parents('tr').hasClass('rowNotApprovedC')) {
                    $(this).parents('tr').find('.backRow').click()
                }
                if ($('#myTime').attr('status') == '1') {
                    $('#myTime').parents('td').append($('.warehouse').find('.textTime'))
                }
                $(this).removeClass('off')
                $(this).append($('#divTime'))
                $('.warehouse').append($(this).find('.textTime'))
                $('#divTime').removeClass('d-none')
                $('#divTime').find('div').removeClass('d-none')
                $('#myTime').attr('status', '1')
                $('#myTime').attr('update', '1')
                id = $(this).find('input:eq(0)').val()
                text = $("#myTime option[value='" + id + "']").text()
                $("#myTime").val(id).trigger('change');
                $('#myTime').attr('update', '0')
            } else if ($(this).find('#divTime').length == 0) {
                $(this).addClass('off')
            }
        }
    })

    // Unit cost
    $(".editUnitCost").click(function () {
        if (!$(this).parents('tr').hasClass('client') && (!$(this).parents('tr').hasClass('rowNotApproved') && !$(this).parents('tr').hasClass('rowNotApprovedC') || $('#actualUser').val() == "executive")) {
            if ($(this).parents('tr').hasClass('rowNotApprovedC')) {
                $(this).parents('tr').find('.backRow').click()
            }
            $(this).find('div').addClass('d-none')
            $(this).find('g').removeClass('d-none')
            code = $(this).parents('tr').find('.editCurrency').find('input').val()
            if (code == "") {
                aux = ""
            } else {
                array_codes = ['MXN', 'USD', 'EUR'];
                aux = array_codes[parseFloat(code)]
            }
            $(this).find('g').text(aux)
            $(this).find('input:eq(1)').removeClass('d-none')
            $(this).find('input:eq(1)').focus()
            cleanSelects(0)
        }
    })

    $(".hideCost").blur(function () {
        $(this).parents('td').parents('tr').find('.editUnitCost').find('g').addClass('d-none')
        $(this).parent('td').find('div').removeClass('d-none')
        field = $(this).val()
        if (field.trim() == '') {
            cost = 0;
        } else {
            cost = parseFloat(field)
            $(this).parents('td').parents('tr').find('.btn').removeClass('d-none')
        }
        tr = $(this).parents('td').parents('tr')
        if (tr.find('.editCurrency').find('input:eq(0)').val().trim() != '') {
            account_c = parseFloat(tr.find('.editCurrency').find('input:eq(0)').val())
        } else {
            account_c = parseFloat($('#currency').find('option:selected').val())
        }
        // account_c = parseFloat(tr.find('.editCurrency').find('input:eq(0)').val())

        if ($('#show_currency').find('option:selected').val() != '0') {
            console.log("c")
            cvr = conversion(cost, account_c);
            toSum = conversion(cost, account_c);

        } else {
            console.log("cv")
            cvr = currencyValues(cost, account_c);
            toSum = convertBudgetCurrency(cost, account_c);
        }
        if (cost > 0)
            $(this).parent('td').find('div').text(formatNumber(cvr[1]))
        else
            $(this).parent('td').find('div').text("")
        updateTotal(tr, cvr, toSum)
        $(this).addClass('d-none')
        before = $(this).parents('td').find('input:eq(0)').val()
        $(this).parents('td').find('input:eq(0)').val(field)
        if (before != field) {
            $(this).parents('td').parents('tr').attr('change', '1')
            if ($(this).parent('td').find('.cg').length == 1) { //new div cg (change)
                aux_cg = $(this).parent('td').find('.cg').val().split('/')
                $(this).parent('td').find('.cg').val($(this).val() + "/" + aux_cg[1])
            } else {
                $(this).parent('td').find('input:eq(1)').after("<input class='cg' type='hidden' value='" + $(this).val() + "/" + before + "'/>")
            }
        }
        checkCompleteThis($(this).parents('td').parents('tr'), 1)
    })

    // Total Cost
    $(".utc").keyup(function () {
        valor = $(this).val();
        if (valor.length > 1) {
            if (parseFloat(valor) < 0)
                $(this).val(parseFloat(valor) * -1)
        }
        var res = valor.split(".");

        if (res.length > 1) {
            if (res[1].length > 2) {
                show = parseFloat(res[0] + "." + res[1].substr(0, 2));
                $(this).val(show.toFixed(2));
            }
        }
        selectCells($(this).parents('td').parents('tr'))
        if ($(this).parents('td').parents('tr').hasClass('mult')) {
            updateTop('account', $(this).parents('td').parents('tr').attr('account'))
        } else if ($(this).parents('td').parents('tr').hasClass('uni')) {
            updateTop('block', $(this).parents('td').parents('tr').attr('block'))
        }
    })
    // Currency
    $(".editCurrency").click(function () {
        if (!$(this).parents('tr').hasClass('client') && (!$(this).parents('tr').hasClass('rowNotApproved') && !$(this).parents('tr').hasClass('rowNotApprovedC') || $('#actualUser').val() == "executive")) {
            cleanSelects(0)
            console.log($(this).find('#Currency').length)
            if ($(this).hasClass("off")) {
                if ($(this).parents('tr').hasClass('rowNotApprovedC')) {
                    $(this).parents('tr').find('.backRow').click()
                }
                if ($('#myCurrency').attr('status') == '1') {
                    $('#myCurrency').parents('td').append($('.warehouse').find('.textCurrency'))
                }
                $(this).removeClass('off')
                $(this).append($('#divCurrency'))
                $('.warehouse').append($(this).find('.textCurrency'))
                $('#divCurrency').removeClass('d-none')
                $('#divCurrency').find('div').removeClass('d-none')
                $('#myCurrency').attr('status', '1')
                $('#myCurrency').attr('update', '1')
                id = $(this).find('input:eq(0)').val()
                text = $("#myCurrency option[value='" + id + "']").text()
                $("#myCurrency").val(id).trigger('change');
                $('#myCurrency').attr('update', '0')
            } else if ($(this).find('#divCurrency').length == 0) {
                $(this).addClass('off')
            }
        }
    })

    // Vendor
    $(".editVendor").click(function () {
        cleanSelects(0)
        if ($(this).hasClass("off") && (!$(this).parents('tr').hasClass('rowNotApproved') && !$(this).parents('tr').hasClass('rowNotApprovedC') || $('#actualUser').val() == "executive")) {
            if ($(this).parents('tr').hasClass('rowNotApprovedC')) {
                $(this).parents('tr').find('.backRow').click()
            }
            if ($('#myVendor').attr('status') == '1') {
                $('#myVendor').parents('td').append($('.warehouse').find('.textVendor'))
            }
            $(this).removeClass('off')
            $(this).append($('#divVendor'))
            $('.warehouse').append($(this).find('.textVendor'))
            $('#divVendor').removeClass('d-none')
            $('#divVendor').find('div').removeClass('d-none')
            $('#myVendor').attr('status', '1')
            $('#myVendor').attr('update', '1')
            id = $(this).find('input:eq(0)').val()
            text = $("#myVendor option[value='" + id + "']").text()
            $("#myVendor").val(id).trigger('change');
            $('#myVendor').attr('update', '0')
        } else if ($(this).find('#divVendor').length == 0) {
            $(this).addClass('off')
        }
    })
    // To duplicate row
    $('.duplicateRow').click(function () {
        cleanSelects(0)
        row = $(this).parents('td').parents('tr')
        duplicateSubAccount(row)
    })

    // To delete subaccounts
    $('.deleteRow').click(function () {
        cleanSelects(0)
        if (ln() == 'es') {
            text = "¿Esta seguro en eliminar de esta cuenta?"
            btnYes = "Sí, Eliminar"
            btnNot = "No, Cancelar"
        } else {
            text = "Are you sure you want to delete from this account?"
            btnYes = "Yes, delete!"
            btnNot = "No, ¡Cancel!"
        }
        swal({
            html: text,
            showCancelButton: true,
            confirmButtonText: btnYes,
            cancelButtonText: btnNot,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        }).then((result) => {
            if (result.value) {
                row = $(this).parents('td').parents('tr')
                deleteElement(row)
            }
        });
    })
    refreshEventsC()
}
$("#myVendor").change(function () {
    if ($('#myVendor').attr('update') == '0') {
        if ($(this).find('option:selected').text() == $(this).find('option:selected').val()) {
            if (!checkIt()) {
                $('#myVendor').attr('update', '1')
                $("#myVendor").val('').trigger('change');
                $('#myVendor').attr('update', '0')
                return false;
            }
            catchVendor = $(this)
            message = "<b>" + $(this).find('option:selected').text() + "</b>"
            html = "<div class='swal2-content' style='display: block;'>" + document.getElementById('modalVendorText02').innerHTML + " " + message + "?</div>"
            swal({
                html: html,
                showCancelButton: true,
                confirmButtonText: document.getElementById('modalVendorText03').innerHTML,
                cancelButtonText: document.getElementById('modalVendorText04').innerHTML,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then(function (e) {

                if (e.value === true) {
                    $.ajax({
                        type: 'post',
                        url: mainRoute + "vendor/vendorAdd",
                        data: {
                            name: catchVendor.find('option:selected').text(),
                        },
                        success: function (results) {
                            if (results.save_vendor) {
                                $('#myVendor').append('<option value="' + results.id_vendor + '-n">' + catchVendor.find('option:selected').text() + '</option>')
                                $('#myVendor').attr('update', '1')
                                $("#myVendor").val(results.id_vendor + "-n").trigger('change');
                                $('#myVendor').attr('update', '0')
                                alphabeticSelect('myVendor')

                                swal({
                                    title: document.getElementById('modalVendorText06').innerHTML,
                                    confirmButtonText: document.getElementById('modalVendorText07').innerHTML,
                                    confirmButtonClass: 'btn btn-info',
                                    type: "success"
                                });
                                if (catchVendor.parents('td').parents('tr').hasClass('tax-fee')) {
                                    catchVendor.parents('td').parents('tr').attr('changet', '1')
                                    catchVendor.parents('td').parents('tr').find('.btn').removeClass('d-noneTT')
                                } else {
                                    catchVendor.parents('td').parents('tr').attr('change', '1')
                                    catchVendor.parents('td').parents('tr').find('.btn').removeClass('d-none')
                                }
                                // catchVendor.parents('td').append($('.warehouse').find('.textVendor'))
                                text = catchVendor.find('option:selected').text();
                                id = catchVendor.find('option:selected').val();
                                // catchVendor.parents('td').find('.textVendor').text(text)
                                $('.warehouse').find('.textVendor').text(text)
                                if ($('#actualUser').val() == "executive") {
                                    if (catchVendor.parents('td').find('.cg').length == 1) { //new div cg (change)
                                        catchVendor.parents('td').find('.cg').remove()
                                    }
                                    catchVendor.parents('td').find('input:eq(0)').after("<input class='cg' type='hidden' value='" + id + "/" + $(this).parents('td').find('input:eq(0)').val() + "'/>")
                                }
                                catchVendor.parents('td').find('input:eq(0)').val(id)
                                if (catchVendor.parents('td').parents('tr').hasClass('tax-fee')) {
                                    checkCompleteThisTT(catchVendor.parents('td').parents('tr'), 1)
                                } else {
                                    checkCompleteThis(catchVendor.parents('td').parents('tr'), 1)
                                }
                                // catchVendor.parents('td').next().click()

                                // $('.warehouse').append($('#divVendor'))
                                // $('#myVendor').attr('status', '0')
                            } else {

                                swal({
                                    title: results.error_message,
                                    confirmButtonText: document.getElementById('modalVendorText07').innerHTML,
                                    confirmButtonClass: 'btn btn-info',
                                    type: 'error',
                                });
                            }
                        }
                    });

                } else {
                    $('#myVendor').attr('update', '1')
                    $("#myVendor").val('').trigger('change');
                    $('#myVendor').attr('update', '0')
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            }
            )
        } else {
            if ($(this).parents('td').parents('tr').hasClass('tax-fee')) {
                $(this).parents('td').parents('tr').attr('changet', '1')
                $(this).parents('td').parents('tr').find('.btn').removeClass('d-noneTT')
            } else {
                $(this).parents('td').parents('tr').attr('change', '1')
                $(this).parents('td').parents('tr').find('.btn').removeClass('d-none')
            }
            // $(this).parents('td').append($('.warehouse').find('.textVendor'))
            text = $(this).find('option:selected').text();
            id = $(this).find('option:selected').val();
            // $(this).parents('td').find('.textVendor').text(text)
            $('.warehouse').find('.textVendor').text(text)
            if ($('#actualUser').val() == "executive") {
                if ($(this).parents('td').find('.cg').length == 1) { //new div cg (change)
                    $(this).parents('td').find('.cg').remove()
                }
                $(this).parents('td').find('input:eq(0)').after("<input class='cg' type='hidden' value='" + id + "/" + $(this).parents('td').find('input:eq(0)').val() + "'/>")
            }
            $(this).parents('td').find('input:eq(0)').val(id)
            if ($(this).find('option:selected').val() == '-l') {
                $(this).parents('td').parents('tr').addClass('client')
            } else {
                $(this).parents('td').parents('tr').removeClass('client')
            }
            if ($(this).parents('td').parents('tr').hasClass('tax-fee')) {
                checkCompleteThisTT($(this).parents('td').parents('tr'), 1)
            } else {
                checkCompleteThis($(this).parents('td').parents('tr'), 1)

            }
            // $(this).parents('td').next().click()
            // $('.warehouse').append($('#divVendor'))
            // $('#myVendor').attr('status', '0')
        }
    }
})
$("#myCurrency").change(function () {
    if ($('#myCurrency').attr('update') == '0') {
        $(this).parents('td').parents('tr').find('.btn').removeClass('d-none')
        $(this).parents('td').parents('tr').attr('change', '1')
        $(this).parents('td').append($('.warehouse').find('.textCurrency'))
        text = $(this).find('option:selected').text();
        id = $(this).find('option:selected').val();
        actual = $('#show_currency').find('option:selected').val()
        if (actual != '0') {
            array_codes = ['MXN', 'USD', 'EUR'];
            text = array_codes[parseFloat(actual) - 1]
        }
        $(this).parents('td').find('.textCurrency').text(text)
        if ($(this).parents('td').find('.cg').length == 1) { //new div cg (change)
            aux_cg = $(this).parents('td').find('.cg').val().split('/')
            $(this).parents('td').find('.cg').val(id + "/" + aux_cg[1])
        } else {
            $(this).parents('td').find('input:eq(1)').after("<input class='cg' type='hidden' value='" + id + "/" + $(this).parents('td').find('input:eq(0)').val() + "'/>")
        }
        $(this).parents('td').find('input:eq(0)').val(id)
        selectCells($(this).parents('td').parents('tr'))
        if ($(this).parents('td').parents('tr').hasClass('mult')) {
            updateTop('account', $(this).parents('td').parents('tr').attr('account'))
        } else if ($(this).parents('td').parents('tr').hasClass('uni')) {
            updateTop('block', $(this).parents('td').parents('tr').attr('block'))
        }
        checkCompleteThis($(this).parents('td').parents('tr'), 1)
        moveAlong()
        // $('.warehouse').append($('#divCurrency'))
        // $('#myCurrency').attr('status', '0')
    }
})
$("#myTime").change(function () {
    if ($('#myTime').attr('update') == '0') {
        $(this).parents('td').parents('tr').find('.btn').removeClass('d-none')
        $(this).parents('td').append($('.warehouse').find('.textTime'))
        text = $(this).find('option:selected').text();
        id = $(this).find('option:selected').val();
        $(this).parents('td').find('.textTime').text(text)
        if ($('#actualUser').val() == "executive") {
            if ($(this).parents('td').find('.cg').length == 1) { //new div cg (change)
                $(this).parents('td').find('.cg').remove()
            }
            $(this).parents('td').find('input:eq(0)').after("<input class='cg' type='hidden' value='" + id + "/" + $(this).parents('td').find('input:eq(0)').val() + "'/>")
        }
        $(this).parents('td').find('input:eq(0)').val(id)
        $(this).parents('td').parents('tr').attr('change', '1')
        checkCompleteThis($(this).parents('td').parents('tr'), 1)
        // $(this).parents('td').next().click()
        // $('.warehouse').append($('#divTime'))
        // $('#myTime').attr('status', '0')
    }
})
function showSubAccount(account_id) {
    account = $('#myAccount' + account_id)
    if (account.attr('status') == '0') {
        $('.belonsgAccount' + account_id).removeClass('d-none')
        account.attr('status', '1')
        account.find('i').css('color', '#ffffff')
        account.find('a').css('color', '#ffffff')
        account.find('i').text('keyboard_arrow_up')
    } else {
        $('.belongsAccount' + account_id).addClass('d-none')
        account.attr('status', '0')
        account.find('i').css('color', '#fff')
        account.find('a').css('color', '#fff')
        account.find('i').text('keyboard_arrow_down')

    }
}


function selectCells(tr) {
    if (tr.find('.editUnitCost').find('input:eq(1)').val().trim() != '') {
        cost = parseFloat(tr.find('.editUnitCost').find('input:eq(1)').val())
    } else {
        cost = 0;
    }
    if (tr.find('.editCurrency').find('input:eq(0)').val().trim() != '') {
        account_c = parseFloat(tr.find('.editCurrency').find('input:eq(0)').val())
    } else {
        account_c = parseFloat($('#currency').find('option:selected').val())
    }
    if ($('#show_currency').find('option:selected').val() != '0') {
        cvr = conversion(cost, account_c);
        toSum = conversion(cost, account_c);
    } else {
        cvr = currencyValues(cost, account_c);
        toSum = convertBudgetCurrency(cost, account_c);
    }
    if (cost == 0) {
        tr.find('.editUnitCost').find('div').text('')
    } else {
        tr.find('.editUnitCost').find('div').text(formatNumber(cvr[1]))
    }
    updateTotal(tr, cvr, toSum)
}

function updateTotal(tr, cvr, toSum) {
    if (tr.find('.qu').find('input:eq(0)').val().trim() != '') {
        q_unit = parseFloat(tr.find('.qu').find('input:eq(0)').val())
    } else {
        q_unit = 0;
    }
    if (tr.find('.qt').find('input:eq(0)').val().trim() != '') {
        q_time = parseFloat(tr.find('.qt').find('input:eq(0)').val())
    } else {
        q_time = 0;
    }
    auxt = cvr[1] * q_unit * q_time
    if ($('#hswitchRound').val() == '0') {
        auxt = cvr[1] * q_unit * q_time
        auxs = toSum[1] * q_unit * q_time
    }
    else {
        auxt = Math.round(cvr[1]) * q_unit * q_time
        auxs = Math.round(toSum[1]) * q_unit * q_time
    }
    if (auxt == 0) {
        tr.find('.totalCost').text('')
        if (tr.attr('bva') != '' || tr.attr('change') == '1') {
            tr.find('.totalCost').append("<input type='hidden' value='" + auxs.toFixed(2) + "'/>")
        } else {
            tr.find('.totalCost').append("<input type='hidden' value=''/>")
        }
    } else {
        tr.find('.totalCost').text(formatNumber((auxt).toFixed(2)))
        tr.find('.totalCost').append("<input type='hidden' value='" + auxs.toFixed(2) + "'/>")
    }
}

// To hide vendor, time and currency
function cleanSelects(key) {

    if ($('#myVendor').attr('status') == '1' && key != 1) {
        $('#myVendor').parents('td').append($('.warehouse').find('.textVendor'))
        $('#myVendor').attr('status', '0')
        $('.warehouse').append($('#divVendor'))
        $(".editVendor").addClass('off')
        $(".editVendorTT").addClass('off')
    }
    if ($('#myTime').attr('status') == '1' && key != 2) {
        $('#myTime').parents('td').append($('.warehouse').find('.textTime'))
        $('#myTime').attr('status', '0')
        $('.warehouse').append($('#divTime'))
        $(".editTime").addClass('off')
    }
    if ($('#myCurrency').attr('status') == '1' && key != 3) {
        $('#myCurrency').parents('td').append($('.warehouse').find('.textCurrency'))
        $('#myCurrency').attr('status', '0')
        $('.warehouse').append($('#divCurrency'))
        $(".editCurrency").addClass('off')
    }
    //For tax and fee table
    if ($('#myType').attr('status') == '1' && key != 4) {
        $('#myType').parents('td').append($('.warehouse').find('.textTypeTT'))
        $('#myType').attr('status', '0')
        $('.warehouse').append($('#divType'))
        $(".editTypeTT").addClass('off')
    }
    if ($('#myDescriptionTax').attr('status') == '1' && key != 5) {
        $('#myDescriptionTax').parents('td').append($('.warehouse').find('.textDescriptionTT'))
        $('#myDescriptionTax').attr('status', '0')
        $('.warehouse').append($('#divDescriptionTax'))
        $(".editDescriptionTT").addClass('off')
    }
    if ($('#myDescriptionFee').attr('status') == '1' && key != 6) {
        $('#myDescriptionFee').parents('td').append($('.warehouse').find('.textDescriptionTT'))
        $('#myDescriptionFee').attr('status', '0')
        $('.warehouse').append($('#divDescriptionFee'))
        $(".editDescriptionTT").addClass('off')
    }
}

// To detect when shot auto-save
setInterval('checkChanges()', 10000);

function checkChanges() {
    tr = $('tr[change="1"]')
    if (tr.length > 0) {
        if (checkIt()) {
            var data = new FormData();
            data.append('size', tr.length)
            data.append('budget_id', $("#my_budget").val())
            tr.each(function (key) {
                if ($(this).hasClass('uni')) {
                    plus = 1
                } else {
                    plus = 0
                }
                bva = $(this).attr('bva')
                letter = $(this).find('td:eq(0)').find('input:eq(0)').val()
                //Catch vendor
                if ($(this).hasClass('rowNotApprovedC') && $(this).find('td:eq(' + (1 + plus) + ')').find('.cg').length == 1)
                    vendor = $(this).find('td:eq(' + (1 + plus) + ')').find('.cg').val().split('/')[0]
                else
                    vendor = $(this).find('td:eq(' + (1 + plus) + ')').find('input:eq(0)').val()
                //catch description
                if ($(this).hasClass('rowNotApprovedC') && $(this).find('td:eq(' + (2 + plus) + ')').find('.cg').length == 1)
                    description = $(this).find('td:eq(' + (2 + plus) + ')').find('.cg').val().split('/')[0]
                else
                    description = $(this).find('td:eq(' + (2 + plus) + ')').find('input:eq(0)').val()
                //catch quantity unit
                if ($(this).hasClass('rowNotApprovedC') && $(this).find('td:eq(' + (3 + plus) + ')').find('.cg').length == 1)
                    q_unit = $(this).find('td:eq(' + (3 + plus) + ')').find('.cg').val().split('/')[0]
                else
                    q_unit = $(this).find('td:eq(' + (3 + plus) + ')').find('input:eq(0)').val()
                //catch unit
                if ($(this).hasClass('rowNotApprovedC') && $(this).find('td:eq(' + (4 + plus) + ')').find('.cg').length == 1)
                    unit = $(this).find('td:eq(' + (4 + plus) + ')').find('.cg').val().split('/')[0]
                else
                    unit = $(this).find('td:eq(' + (4 + plus) + ')').find('input:eq(0)').val()
                //catch quantity time
                if ($(this).hasClass('rowNotApprovedC') && $(this).find('td:eq(' + (5 + plus) + ')').find('.cg').length == 1)
                    q_time = $(this).find('td:eq(' + (5 + plus) + ')').find('.cg').val().split('/')[0]
                else
                    q_time = $(this).find('td:eq(' + (5 + plus) + ')').find('input:eq(0)').val()
                //catch time
                if ($(this).hasClass('rowNotApprovedC') && $(this).find('td:eq(' + (6 + plus) + ')').find('.cg').length == 1)
                    time = $(this).find('td:eq(' + (6 + plus) + ')').find('.cg').val().split('/')[0]
                else
                    time = $(this).find('td:eq(' + (6 + plus) + ')').find('input:eq(0)').val()
                //catch cost
                if ($(this).hasClass('rowNotApprovedC') && $(this).find('td:eq(' + (7 + plus) + ')').find('.cg').length == 1)
                    cost = $(this).find('td:eq(' + (7 + plus) + ')').find('.cg').val().split('/')[0]
                else
                    cost = $(this).find('td:eq(' + (7 + plus) + ')').find('input:eq(0)').val()
                //catch currency
                if ($(this).hasClass('rowNotApprovedC') && $(this).find('td:eq(' + (8 + plus) + ')').find('.cg').length == 1)
                    currency = $(this).find('td:eq(' + (8 + plus) + ')').find('.cg').val().split('/')[0]
                else
                    currency = $(this).find('td:eq(' + (8 + plus) + ')').find('input:eq(0)').val()
                account = $(this).attr('account')
                data.append('bva' + key, bva)
                data.append('vendor' + key, vendor)
                data.append('description' + key, description)
                data.append('q_unit' + key, q_unit)
                data.append('unit' + key, unit)
                data.append('q_time' + key, q_time)
                data.append('time' + key, time)
                data.append('cost' + key, cost)
                data.append('currency' + key, currency)
                data.append('account' + key, account)
                data.append('letter' + key, letter)
            });

            $.ajax({
                type: 'post',
                url: mainRoute + "budget/saveAccount",
                headers: { 'X-CSRF-TOKEN': token = $('#tokenBudget').val() },
                data: data,
                processData: false,
                cache: false,
                contentType: false,
                success: function (r) {
                    if (r != 0) {
                        showSaveMessage();
                        if (r != 1) {
                            tr = $('tr[change="1"]')
                            for (i = 0; i < r.number; i++) {
                                tr.eq([r.myIndex[i]]).attr('bva', r.ids[i])
                            }
                        }
                        $('tr[change="1"]').attr('change', '0')
                    }
                }
            });
        }
    }
    trd = $('tr[change="2"]')
    if (trd.length > 0) {
        if (checkIt()) {
            var datat = new FormData();
            datat.append('size', trd.length)
            datat.append('budget_id', $("#my_budget").val())
            trd.each(function (key) {
                bva = $(this).attr('bva')
                datat.append('bva' + key, bva)
            })
            $.ajax({
                type: 'post',
                url: mainRoute + "budget/deleteAccount",
                headers: { 'X-CSRF-TOKEN': token = $('#tokenBudget').val() },
                data: datat,
                processData: false,
                cache: false,
                contentType: false,
                success: function (r) {
                    if (r != 0) {
                        showSaveMessage();
                        if (r == 1) {
                            $('.deleteThisTD').remove()
                            $('tr[change="2"]').attr('bva', '')
                            $('tr[change="2"]').attr('change', '0')
                        }
                    }
                }
            });
        }
    }
    trc = $('tr[change="3"]')
    if (trc.length > 0) {
        if (checkIt()) {
            var datac = new FormData();
            datac.append('size', trc.length)
            datac.append('budget_id', $("#my_budget").val())
            datac.append('change', "1")
            trc.each(function (key) {
                bva = $(this).attr('bva')
                datac.append('bva' + key, bva)
            })
            $.ajax({
                type: 'post',
                url: mainRoute + "budget/change",
                headers: { 'X-CSRF-TOKEN': token = $('#tokenBudget').val() },
                data: datac,
                processData: false,
                cache: false,
                contentType: false,
                success: function (r) {
                    if (r != 0) {
                        showSaveMessage();
                        if (r == 1) {
                            $('tr[change="3"]').attr('change', '0')
                        }
                    }
                }
            });
        }
    }
    tre = $('tr[change="4"]')
    if (tre.length > 0) {
        if (checkIt()) {
            var datac = new FormData();
            datac.append('size', tre.length)
            datac.append('budget_id', $("#my_budget").val())
            datac.append('change', "2")
            tre.each(function (key) {
                bva = $(this).attr('bva')
                datac.append('bva' + key, bva)
            })
            $.ajax({
                type: 'post',
                url: mainRoute + "budget/change",
                headers: { 'X-CSRF-TOKEN': token = $('#tokenBudget').val() },
                data: datac,
                processData: false,
                cache: false,
                contentType: false,
                success: function (r) {
                    if (r != 0) {
                        showSaveMessage();
                        if (r == 1) {
                            $('tr[change="4"]').attr('bva', '')
                            $('tr[change="4"]').attr('change', '0')
                            $('.deleteThisTC').remove()
                        }
                    }
                }
            });
        }
    }
    checkChangesTT()
}
function deleteEvents() {

    $("#myBudget").unbind()
    $(".belongsBudget").unbind()
    $(".myBlock").unbind()
    $(".myAccount").unbind()
    $(".belongsBudget").unbind()
    $(".myBlock").unbind()
    $(".myAccount").unbind()
    // Text
    $(".editText").unbind()
    $(".hideInput").unbind()
    // Time
    $(".editTime").unbind()
    // Unit cost
    $(".editUnitCost").unbind()
    // Total Cost
    $(".utc").unbind()
    // Currency
    $(".editCurrency").unbind()
    // Vendor
    $(".editVendor").unbind()
    // To duplicate row
    $('.duplicateRow').unbind()
    // To delete row
    $('.deleteRow').unbind()
    deleteEventsC()
}
// To duplicate sub-account
function duplicateSubAccount(row) {
    deleteEvents()
    account = row.attr('account')
    if (row.hasClass('mult')) { //For account with mult subaccount
        var clone = row.clone()
        clone.attr('bva', '')
        aux = clone.attr('account')
        last = $('.belongsAccount' + account).last()
        main = last.find('td:eq(0)').text()
        headRow = $('#myAccount' + aux)
        next = nextLetter(headRow.attr('last'));
        clone.removeClass('rowNotComplete')
        clone.find('td:eq(0)').text(main.split('-')[0] + "-" + next)
        clone.find('td:eq(0)').append('<input type="hidden" value="' + next + '">')
        headRow.attr('last', next)
        $('.belongsAccount' + aux).attr('last', next)
        clone.find('.td-actions').empty()
        clone.find('.td-actions').append('<button type="button" class="btn btn-sssm btn-link btn-github duplicateRow"><i class="fa fa-copy"></i></button><button type="button" class="btn btn-sssm btn-link btn-github deleteRow"><i class="fa fa-minus-square"></i></button>')
        clone.attr('change', '1')
        last.after(clone)
        gradientColor(clone)
        refreshEvents()
        updateTop('account', aux)
    }
    if (row.hasClass('uni')) { //For accounts with one sub-account
        code = row.find('td:eq(0)').text()
        name = row.find('td:eq(1)').text()
        var clone1 = row.clone()
        letter = clone1.attr('last')
        next = nextLetter(letter)
        clone1.find('td:eq(0)').attr('colspan', 2)
        clone1.find('td:eq(0)').text(code + '-' + clone1.find('td:eq(0)').find('input:eq(0)').val())
        clone1.find('td:eq(0)').append('<input type="hidden" value="' + letter + '">')
        clone1.find('td:eq(1)').remove()
        clone1.attr('class', '')
        clone1.addClass('mult')
        if (row.hasClass('client')) {
            row.removeClass('client')
            clone1.addClass('client')
        }
        clone1.addClass('d-none')
        clone1.find('.td-actions').empty()
        clone1.find('.td-actions').append('<button type="button" class="btn btn-sssm btn-link btn-github duplicateRow"><i class="fa fa-copy"></i></button><button type="button" class="btn btn-sssm btn-link btn-github deleteRow"><i class="fa fa-minus-square"></i></button>')
        clone1.addClass('belongsAccount' + account)
        if (clone1.attr('bva') == '') {
            clone1.attr('change', '1')
        }

        var clone2 = clone1.clone()
        clone2.find('td:eq(0)').text(code + '-' + next)
        clone2.find('td:eq(0)').append('<input type="hidden" value="' + next + '">')
        clone2.attr('bva', '')
        clone2.attr('change', '1')
        row.after(clone1)
        clone1.after(clone2)

        row.empty()
        row.removeClass('uni')
        row.addClass('myAccount')
        row.addClass('mb')
        row.removeClass('rowNotComplete')
        row.removeAttr('change')
        row.removeAttr('bva')
        row.attr('status', '0')
        row.attr('id', 'myAccount' + account)
        html = "<td><a><i class='material-icons'>keyboard_arrow_down</i>" +
            code +
            "</a></td>" +
            "<td colspan='9'><a>" + name +
            "</a></td><td class='text-right'>0.00</td><td></td>"
        row.append(html)
        row.attr('last', next)
        clone1.attr('last', next)
        clone2.attr('last', next)

        refreshEvents()
        gradientColor(clone2)
        aux = clone2.attr('account')
        updateTop('account', aux)
        checkCompleteThis(clone1)
        aux_fs = parseFloat($('#font_size').val())
        updateSize(aux_fs)
    }
}

//Check internet
setInterval('checkOnLine()', 3000);
function checkOnLine() {
    if (navigator.onLine) {
        $('#checkConnection').val('1')
    } else {
        $('#checkConnection').val('0')

    }
}
function checkIt() {
    if (navigator.onLine) {
        return 1
    } else {
        return 0
    }
}
$("#checkConnection").attrchange({ //connection
    trackValues: true,
    callback: function (evnt) {
        status = $(this).val()
        if (status == '1') {
            $('#show_error_c').addClass('d-none')
            $('#show_error_c').attr('show', '0')
            if ($('#show_error_c').attr('active') == '1') {
                $('#show_error_c').attr('active', '0')
                if (ln() == 'es') {
                    message = "Se restrableció la conexión a internet, los cambios serán guardados en breve"
                    getChanges()
                } else {
                    message = "Internet connection was restored, changes will be saved shortly"
                }
                notifYSuccess(message)
                //To active disabled contact buttons
                $('.call-contacts').removeAttr('disabled')
                $('.call-contacts').removeAttr('title')
                $('.call-contacts').each(function () {
                    if ($(this).attr('titlea')) {
                        $(this).attr('title', $(this).attr('titlea'))
                    }
                })
                $('.call-contacts').removeAttr('titlea')
                $('.logButton').removeClass('d-none')
            }
        } else {
            $('#show_error_c').removeClass('d-none')
            if ($('#show_error_c').attr('show') == '0') {
                $('#show_error_c').attr('active', '1')
                $('#show_error_c').attr('show', '1')
                if (ln() == 'es') {
                    message = "No hay conexión a internet, los cambios realizados serán guardados hasta que se restablezca la conexión"
                    title = "Desconectado!"
                } else {
                    message = "There is no internet connection, the changes made will be saved until it is restored the connection"
                    title = "disconnected!"
                }
                // html = "<i class='fa fa-file fa-lg'></i><br>" +
                html = "<i class='material-icons' style='color:#F27474; font-size: 5em;'>cloud_off</i>" +
                    "<div class='swal2-header'><h2 class='swal2-title' id='swal2-title'>" + title + "</h2>" + "</div>" +
                    "<div class='swal2-content' style='display: block;'>" + message + "</div>"
                // <div id="swal2-content" style="display: block;">¿Esta seguro en eliminar esta sección?</div>
                swal({
                    html: html,
                    buttonsStyling: false,
                    confirmButtonClass: "btn btn-success",
                    // type: "error"
                }).catch(swal.noop)

                //To block contacts and dropdown
                $('#contactModal').find('.modal-footer').find('button').click()
                $('#contactAgencyModal').find('.modal-footer').find('button').click()
                $('.call-contacts').attr('disabled', 'true')
                $('.call-contacts').each(function () {
                    if ($(this).attr('title')) {
                        $(this).attr('titlea', $(this).attr('title'))
                    }
                })
                if (ln() == 'es') {
                    newTitle = "Sin conexión, no disponible"
                } else {
                    newTitle = "Offline, not available"
                }
                $('.call-contacts').attr('title', newTitle)
                $('.logButton').addClass('d-none')
            }
        }
    }
});

//Save firsts three steps for offline autosave
function getChanges() {
    //Images part of step 1
    saveMeImage('path_agency_logo')
    saveMeImage('path_client_logo')
    saveMeImage('path_product_company_logo')

    //Step 2
    project_name = $("#project_name").val();
    project_type = $("#project_type").find('option:selected').val();
    genre = $("#genre").find('option:selected').val();
    currency = $("#currency").find('option:selected').val();
    mxn_equivalence = $("#mxn_equivalence").val();
    usd_equivalence = $("#usd_equivalence").val();
    eur_equivalence = $("#eur_equivalence").val();
    product_quantity = $("#product_quantity").val();
    product_description = $("#product_description").val();
    product_duration_hours = $("#product_duration_hours").val();
    product_duration_minutes = $("#product_duration_minutes").val();
    product_duration_seconds = $("#product_duration_seconds").val();

    //Step 3
    product_company = $("#product_company").find('option:selected').val();
    producer_id = $("#producer_id").find('option:selected').val();
    executive_producer_id = $("#executive_producer_id").find('option:selected').val();
    director_id = $("#director_id").find('option:selected').val();
    line_producer_id = $("#line_producer_id").find('option:selected').val();
    creation_date = $("#creation_date").val();
    expected_date_start = $("#expected_date_start").val();
    expected_date_finish = $("#expected_date_finish").val();

    development_quantity = $("#development_quantity").val();
    development_time = $("#development_time").val();
    development_date = $("#development_date").val();

    pre_production_quantity = $("#pre_production_quantity").val();
    pre_production_time = $("#pre_production_time").val();
    pre_production_date = $("#pre_production_date").val();

    production_quantity = $("#production_quantity").val();
    production_time = $("#production_time").val();
    production_date = $("#production_date").val();

    post_production_quantity = $("#post_production_quantity").val();
    post_production_time = $("#post_production_time").val();
    post_production_date = $("#post_production_date").val();

    distribution_quantity = $("#distribution_quantity").val();
    distribution_time = $("#distribution_time").val();
    distribution_date = $("#distribution_date").val();
    premier_air_date = $("#premier_air_date").val();

    panel = $('.tab-pane.active').attr('id')
    aux = panel.split('step')

    show_currency = $('#show_currency').find('option:selected').val()
    font_size = $('#font_size').val()

    $.ajax({
        type: 'post',
        url: mainRoute + "budget/saveAllSteps",
        headers: { 'X-CSRF-TOKEN': $('#tokenBudget').val() },
        data: {
            step: aux[1],
            budget_id: $("#my_budget").val(),
            //Step 2
            project_name: project_name,
            project_type: project_type,
            genre: genre,
            show_currency: show_currency,
            font_size: font_size,
            currency: currency,
            mxn_equivalence: mxn_equivalence,
            usd_equivalence: usd_equivalence,
            eur_equivalence: eur_equivalence,
            product_quantity: product_quantity,
            product_description: product_description,
            product_duration_hours: product_duration_hours,
            product_duration_minutes: product_duration_minutes,
            product_duration_seconds: product_duration_seconds,

            //Steep 3
            product_company: product_company,
            producer_id: producer_id,
            executive_producer_id: executive_producer_id,
            director_id: director_id,
            line_producer_id: line_producer_id,
            creation_date: creation_date,
            expected_date_start: expected_date_start,
            expected_date_finish: expected_date_finish,

            development_quantity: development_quantity,
            development_time: development_time,
            development_date: development_date,

            pre_production_quantity: pre_production_quantity,
            pre_production_time: pre_production_time,
            pre_production_date: pre_production_date,

            production_quantity: production_quantity,
            production_time: production_time,
            production_date: production_date,

            post_production_quantity: post_production_quantity,
            post_production_time: post_production_time,
            post_production_date: post_production_date,

            distribution_quantity: distribution_quantity,
            distribution_time: distribution_time,
            distribution_date: distribution_date,
            premier_air_date: premier_air_date,
        },
        success: function (r) {
            if (r != 0) {
                showSaveMessage()
                $("#p_legal_name").val(legal_name)
                $("#p_legal_agency_name").val(legal_agency_name)
                $("#p_project_name").val(project_name)
                $("#p_mxn_equivalence").val(mxn_equivalence)
                $("#p_usd_equivalence").val(usd_equivalence)
                $("#p_eur_equivalence").val(eur_equivalence)
                $("#p_product_quantity").val(product_quantity)
                $("#p_product_description").val(product_description)
                $("#p_product_duration_hours").val(product_duration_hours)
                $("#p_product_duration_minutes").val(product_duration_minutes)
                $("#p_product_duration_seconds").val(product_duration_seconds)

                //Step 3
                $("#p_creation_date").val(creation_date)
                $("#p_expected_date_start").val(expected_date_start)
                $("#p_expected_date_finish").val(expected_date_finish)

                $("#p_development_quantity").val(development_quantity)
                $("#p_development_time").val(development_time)
                $("#p_development_date").val(development_date)

                $("#p_pre_production_quantity").val(pre_production_quantity)
                $("#p_pre_production_time").val(pre_production_time)
                $("#p_pre_production_date").val(pre_production_date)

                $("#p_production_quantity").val(production_quantity)
                $("#p_production_time").val(production_time)
                $("#p_production_date").val(production_date)

                $("#p_post_production_quantity").val(post_production_quantity)
                $("#p_post_production_time").val(post_production_time)
                $("#p_post_production_date").val(post_production_date)

                $("#p_distribution_quantity").val(distribution_quantity)
                $("#p_distribution_time").val(distribution_time)
                $("#p_distribution_date").val(distribution_date)
                $("#p_premier_air_date").val(premier_air_date)
            }
        }
    });
    //part of step 1
    saveMeClient('client_id')
    saveMeSelect('client_contact_id')
    saveMeInput('legal_name')

    saveMeAgency('agency_id')
    saveMeSelect('agency_contact_id')
    saveMeInput('legal_agency_name')
}

$('.viewConnection').click(function (event) {
    if (!checkIt()) {
        event.preventDefault();
        event.stopPropagation();

        if (ln() == 'es') {
            text = "Sí sale de esta página perderá todos los cambios hechos sin conexión"
        } else {
            text = "If you leave this page you will lose all changes made offline"
        }
        swal({
            text: text,
            buttonsStyling: false,
            confirmButtonClass: "btn btn-success",
        }).catch(swal.noop)
    }
})

function deleteElement(row) {
    deleteEvents()
    if (row.hasClass('mult')) {
        account = row.attr('account')
        belongs = ".belongsAccount" + account

        row.addClass('d-none')
        row.addClass('deleteThisTD')
        row.removeClass("belongsAccount" + account)
        row.removeClass("rowNotComplete")
        row.attr('change', 2)
        if ($(belongs).length == 1) {
            console.log('yes')
            rowAccount = $('#myAccount' + account)
            onlyRow = $(belongs)
            aux_clone = onlyRow.clone()
            console.log(aux_clone.hasClass('rowNotApproved'))
            onlyRow.attr('class', rowAccount.attr('class'))
            if (onlyRow.find('.editVendor').find('input:eq(0)').val() == "-l")
                onlyRow.addClass('client')
            if (aux_clone.hasClass('rowNotApproved'))
                onlyRow.addClass('rowNotApproved')
            if (aux_clone.hasClass('rowNotApprovedC'))
                onlyRow.addClass('rowNotApprovedC')
            if (aux_clone.hasClass('ecg'))
                onlyRow.addClass('ecg')
            if (aux_clone.hasClass('ncg'))
                onlyRow.addClass('ncg')
            onlyRow.removeClass('myAccount')
            onlyRow.removeClass('mb')
            onlyRow.addClass('uni')
            onlyRow.find('td:eq(0)').removeAttr('colspan')
            valtd = onlyRow.find('td:eq(0)').text().split('-')
            onlyRow.find('td:eq(0)').text(valtd[0])
            onlyRow.find('td:eq(0)').append("<input type='hidden' value='" + valtd[1].trim() + "'>")
            onlyRow.find('td:eq(0)').after("<td class='mb'>" + rowAccount.find('td:eq(1)').text() + "</td>")
            rowAccount.remove()
            updateTop('block', onlyRow.attr('block'))
            checkCompleteThis(onlyRow)
        } else {
            updateTop('account', account)
        }
    }
    if (row.hasClass('uni')) {
        row.removeClass('rowNotComplete')
        row.attr('change', '2')
        row.find('td:eq(0)').find('input:eq(0)').val('A')
        //Vendor
        row.find('td:eq(2)').find('g').text('')
        row.find('td:eq(2)').find('input').val('')
        //Description
        row.find('td:eq(3)').find('div').text('')
        row.find('td:eq(3)').find('input').val('')
        //Quantity
        row.find('td:eq(4)').find('div').text('')
        row.find('td:eq(4)').find('input').val('')
        //Unit
        row.find('td:eq(5)').find('div').text('')
        row.find('td:eq(5)').find('input').val('')
        //Quantity
        row.find('td:eq(6)').find('div').text('')
        row.find('td:eq(6)').find('input').val('')
        //Time
        row.find('td:eq(7)').find('g').text('')
        row.find('td:eq(7)').find('input').val('')
        //Unit cost
        row.find('td:eq(8)').find('div').text('')
        row.find('td:eq(8)').find('input').val('')
        //Currency
        row.find('td:eq(9)').find('g').text('')
        row.find('td:eq(9)').find('input').val('')
        //Total cost
        row.find('td:eq(10)').text('')
        row.find('td:eq(10)').append("<input type='hidden' value=''/>")

        //Actions
        row.find('button').addClass('d-none')
        updateTop('block', row.attr('block'))
    }
    aux_fs = parseFloat($('#font_size').val())
    updateSize(aux_fs)
    refreshEvents()
    canApprove()
}
async function gradientColor(clone) {
    clone.css("background-color", "#7da453")
    await wait(100);
    clone.css("background-color", "#88AC62")
    await wait(100);
    clone.css("background-color", "#97B675")
    await wait(100);
    clone.css("background-color", "#A5C088")
    await wait(100);
    clone.css("background-color", "#AFC795")
    await wait(100);
    clone.css("background-color", "#BACFA3")
    await wait(100);
    clone.css("background-color", "#CADAB9")
    await wait(100);
    clone.css("background-color", "#ffffff")
    checkCompleteThis(clone)
}

function nextLetter(letter) {
    msize = letter.trim().length
    console.log(msize)
    mlast = letter[msize - 1]
    if (mlast != 'Z') {
        aux1 = mlast.charCodeAt(0)
        aux2 = aux1 + 1;
        if (msize == 1) {
            return String.fromCharCode(aux2)
        } else {
            return letter[msize - 2] + String.fromCharCode(aux2)
        }

    } else {
        if (msize == 1) {
            return "AA";
        } else {
            console.log()
            aux1 = letter.charCodeAt(0)
            aux2 = aux1 + 1;
            return String.fromCharCode(aux2) + "A";
        }
    }
}
function alphabeticSelect(id_componente) {
    var selectToSort = jQuery('#' + id_componente);
    var optionActual = selectToSort.val();
    selectToSort.html(selectToSort.children('option').sort(function (a, b) {
        return a.text === b.text ? 0 : a.text < b.text ? -1 : 1;
    })).val(optionActual);
}

//To encrease and decrease font size
$('#sizePlus').click(function () {
    value = parseFloat($('#font_size').val())
    value++
    $('#font_size').val(value)
    updateSize(value)
    $('#sizeMinus').removeAttr('disabled')
})
$('#sizeMinus').click(function () {
    value = parseFloat($('#font_size').val())
    value--
    $('#font_size').val(value)
    updateSize(value)
    $('#sizePlus').removeAttr('disabled')
})
function updateSize(size) {
    if (size > 4 && size < 11) {
        pdd = 3
    } else if (size == 4) {
        pdd = 2
    } else if (size == 3) {
        pdd = 1
    } else {
        pdd = 0
    }
    aux = (size + 2)
    exc = aux - 7
    total = 7 + (exc * 0.5)
    ht = total / 20
    if (ht > 0.35) {
        ht = 0.35
    }
    $('.r-space').find('td').css('font-size', (total / 10) + "rem")
    $('.uni').find('td').css('font-size', (total / 9.5) + "rem")
    $('.uni').find('.textVendor').css('font-size', (total / 9.5) + "rem")
    $('.uni').find('.textCurrency').css('font-size', (total / 9.5) + "rem")
    $('.uni').find('.textTime').css('font-size', (total / 9.5) + "rem")

    $('.mult').find('td').css('font-size', (total / 10) + "rem")
    $('.mult').find('.textVendor').css('font-size', (total / 10) + "rem")
    $('.mult').find('.textCurrency').css('font-size', (total / 10) + "rem")
    $('.mult').find('.textTime').css('font-size', (total / 10) + "rem")

    $('.r-space').find('td').css('padding', "0px 3px")
    $('.r-space').find('.textVendor').css('padding', "0px 3px")
    $('.r-space').find('.textCurrency').css('padding', "0px 3px")
    $('.r-space').find('.textTime').css('padding', "0px 3px")

    $('#myBudget').find('td').css('font-size', (total / 8) + "rem")
    $('.mySection').find('td').css('font-size', (total / 8.5) + "rem")
    $('.myBlock').find('td').css('font-size', (total / 9) + "rem")
    $('.myAccount').find('td').css('font-size', (total / 9.5) + "rem")
    $('#total-cost').parent('div').css('font-size', (total / 7.7) + "rem")

    aux_top = ($('#myBudget').height() / 400) * 95
    $('.tableHead').find('td').css('top', aux_top + "%")
    // .r-space-tt is class for fee table
    $('.r-space-tt').find('td').css('font-size', (total / 10) + "rem")
    $('.r-space-tt').find('td').css('padding', "0px 3px")

    $('.r-space-tt').find('.textTypeTT').css('font-size', (total / 10) + "rem")
    $('.r-space-tt').find('.textTypeTT').css('padding', "0px 3px")

    $('.r-space-tt').find('.textDescriptionTT').css('font-size', (total / 10) + "rem")
    $('.r-space-tt').find('.textDescriptionTT').css('padding', "0px 3px")

    $('.r-space-tt').find('.textVendor').css('font-size', (total / 10) + "rem")
    $('.r-space-tt').find('.textVendor').css('padding', "0px 3px")
    $('#myTaxFee').find('td').css('font-size', (total / 8) + "rem")
    aux_top2 = ($('#myTaxFee').height() / 200) * 79
    $('.tableHead2').find('td').css('top', aux_top2 + "%")
    // r-space-yy is class for tax table
    $('.r-space-yy').find('td').css('font-size', (total / 10) + "rem")
    $('.r-space-yy').find('td').css('padding', "0px 3px")

    $('.r-space-yy').find('.textTypeTT').css('font-size', (total / 10) + "rem")
    $('.r-space-yy').find('.textTypeTT').css('padding', "0px 3px")

    $('.r-space-yy').find('.textDescriptionTT').css('font-size', (total / 10) + "rem")
    $('.r-space-yy').find('.textDescriptionTT').css('padding', "0px 3px")

    $('.r-space-yy').find('.textVendor').css('font-size', (total / 10) + "rem")
    $('.r-space-yy').find('.textVendor').css('padding', "0px 3px")
    $('#myTax').find('td').css('font-size', (total / 8) + "rem")
    aux_top2 = ($('#myTax').height() / 200) * 79
    $('.tableHead3').find('td').css('top', aux_top2 + "%")

    if ($('#is_updated').val() == '1') {
        saveMeInput('font_size')
    }
    if (size == 10) {
        $('#sizePlus').attr('disabled', true)
    }
    if (size == 1) {
        $('#sizeMinus').attr('disabled', true)
    }
}
function moveAlong() {
    vendor = $('#myVendor')
    time = $('#myTime')
    currency = $('#myCurrency')
    type = $('#myType')
    description_fee = $('#myDescriptionFee')
    description_tax = $('#myDescriptionTax')
    if (vendor.attr('status') == 1) {
        tr = vendor.parents('td').parents('tr')
        if (tr.hasClass('mult')) {
            aux = 0
        } else {
            aux = 1
        }
        tr.find('td:eq(' + (2 + aux) + ')').click()
    }
    else if (type.attr('status') == 1) {
        tr = type.parents('td').parents('tr')
        tr.find('td:eq(1)').click()
        if ($('#myDescriptionFee').attr('status') == '1')
            $('#myDescriptionFee').select2('open')
        if ($('#myDescriptionTax').attr('status') == '1')
            $('#myDescriptionTax').select2('open')
    }
    else if (description_fee.attr('status') == 1) {
        tr = description_fee.parents('td').parents('tr')
        tr.find('td:eq(2)').click()
        $('#myVendor').select2('open')
    }
    else if (description_tax.attr('status') == 1) {
        tr = description_tax.parents('td').parents('tr')
        tr.find('td:eq(2)').click()
        $('#myVendor').select2('open')
    }
    else if (time.attr('status') == 1) {
        tr = time.parents('td').parents('tr')
        if (tr.hasClass('mult')) {
            aux = 0
        } else {
            aux = 1
        }
        tr.find('td:eq(' + (7 + aux) + ')').click()
    } else if (currency.attr('status') == 1) {
        tr = currency.parents('td').parents('tr')
        next = tr.next()
        while (((!next.hasClass('mult') && !next.hasClass('uni')) || next.hasClass('d-none')) && !next.hasClass('toCloneAccount')) {
            console.log(next)
            next = next.next()
        }
        if (next.hasClass('mult')) {
            aux_i = 0
        } else {
            aux_i = 1
        }
        if (!next.hasClass('toCloneAccount'))
            next.find('td:eq(' + (1 + aux_i) + ')').click()
    }
    else {
        if ($(':focus').length > 0) {
            console.log($(':focus').parents('td'));
            if ($(':focus').parents('td').next().hasClass('editTime')) {
                $(':focus').parents('td').next().click()
                $('#myTime').next().click()
            }
            else if ($(':focus').parent('td').hasClass('editAmountTT')) {
                if ($(':focus').parent('td').parents('tr').next().hasClass('tax-fee')) {
                    $(':focus').parent('td').parents('tr').next().find('td:eq(0)').click()
                    $('#myType').next().click()
                }
            }
            else if ($(':focus').parents('td').next().hasClass('editCurrency')) {
                $(':focus').parents('td').next().click()
                $('#myCurrency').next().click()
            } else {
                $(':focus').parents('td').next().click()
            }
        }
    }
}
function moveBack() {
    currency = $('#myCurrency')
    time = $('#myTime')
    vendor = $('#myVendor')
    description_t = $('#myDescriptionTax')
    description_f = $('#myDescriptionFee')
    if (currency.attr('status') == 1) {
        tr = currency.parents('td').parents('tr')
        if (tr.hasClass('mult')) {
            aux = 0
        } else {
            aux = 1
        }
        tr.find('td:eq(' + (7 + aux) + ')').click()
    } else if (time.attr('status') == 1) {
        tr = time.parents('td').parents('tr')
        if (tr.hasClass('mult')) {
            aux = 0
        } else {
            aux = 1
        }
        tr.find('td:eq(' + (5 + aux) + ')').click()
    } else if (vendor.attr('status') == 1) {
        tr = vendor.parents('td').parents('tr')
        if (tr.hasClass('tax-fee')) {
            tr.find('td:eq(1)').click()
            if ($('#myDescriptionFee').attr('status') == '1')
                $('#myDescriptionFee').select2('open')
            if ($('#myDescriptionTax').attr('status') == '1')
                $('#myDescriptionTax').select2('open')
        }
    }
    else if (description_t.attr('status') == 1) {
        description_t.parents('td').prev().click()
        $('#myType').next().click()
    } else if (description_f.attr('status') == 1) {
        description_f.parents('td').prev().click()
        $('#myType').next().click()

    }
    else {
        if ($(':focus').length > 0) {
            if ($(':focus').parents('td').prev().hasClass('editTime')) {
                $(':focus').parents('td').prev().click()
                $('#myTime').next().click()
            }
            else if ($(':focus').parents('td').prev().hasClass('editVendor')) {
                $(':focus').parents('td').prev().click()
                $('#myVendor').select2('open')
            } else if ($(':focus').parents('td').prev().hasClass('editVendorTT')) {
                $(':focus').parents('td').prev().click()
                $('#myVendor').select2('open')
            } else {
                console.log('no')
                $(':focus').parents('td').prev().click()
            }
        }
    }
}
$('.nav-link').click(async function () {
    aux_fs = parseFloat($('#font_size').val())
    await wait(1000)
    updateSize(aux_fs)
})
$('.btn-wd').click(async function () {
    aux_fs = parseFloat($('#font_size').val())
    await wait(1000)
    updateSize(aux_fs)
})
