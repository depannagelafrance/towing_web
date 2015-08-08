/*
$('#list_direction').change(function(){
  var id = $('#list_direction option:selected').val();

  $.getJSON("/fast_dispatch/ajax/indicators/"+id,
    function(data) {
      $('#list_indicator').empty();

      $.each(data, function(index, item) {
          $('#list_indicator').append($('<option/>', {
                  value: item.id,
                  text : item.name
              }));
      });

      $('#list_indicator').trigger('chosen:updated');

    }
  );
});
*/

$(document).ready(function() {

    /******* REFACTORING JS ********/

    var Dossier = {};
    var url = document.URL.split('/');
    var dossier_number = url[url.length-2];
    var voucher_number = url[url.length-1];

    var dossier_id = $('#data_dossier_id').val();
    var voucher_id = $('#data_voucher_id').val();


    Dossier.dossier_id = dossier_id;
    Dossier.voucher_id = voucher_id;
    Dossier.voucher_number = voucher_number;
    Dossier.dossier_number = dossier_number;

    var Attachements = [];

    $('.close_overlay').on('click', function(){
        parent.$.fancybox.close();
        return false;
    });


    $('input[type="submit"]').on('click', function (){
        Dossier.btnClicked = $(this).attr('name');
    });

    $(document).on('change', '#voucher_switcher', function(){
        var selected = $(this).val();
        var url = '/fast_dossier/dossier/' + Dossier.dossier_number + '/' + selected;
        redirectPage(url);
    });


    //INIT
    initFancyBox('#edit-depot-link');
    initFancyBox('#edit-invoice-data-link');
    initFancyBox('#edit-nuisance-data-link');
    initFancyBox('#add-email-link');
    initFancyBox('#add-nota-link');
    initFancyBox('#add-activity-link');
    initFancyBox('#add-attachment-link');
    initFancyBox('#generate-invoice-link');


    $('#view-nota-link').fancybox({
        'scrolling'		: 'no',
        'titleShow'		: false,
        'beforeLoad' : function(){
            getNotas().success(function(data){
                updateNotaTemplates(data);
            });
        }
    });

    $('#view-email-link').fancybox({
        'scrolling'		: 'no',
        'titleShow'		: false,
        'beforeLoad' : function(){
            getEmails().success(function(data){
                updateEmailTemplates(data);
            });
        }
    });

    $('#view-attachment-link').fancybox({
        'scrolling'		: 'no',
        'titleShow'		: false,
        'beforeLoad' : function(){
            getAttachement().success(function(data){
                updateAttachementTemplates(data);
            });
        }
    });

    //INIT DATETIMEPICKERS
    var times = [
        '06:00', '06:15', '06:30', '06:45',
        '07:00', '07:15', '07:30', '07:45',
        '08:00', '08:15', '08:30', '08:45',
        '09:00', '09:15', '09:30', '09:45',
        '10:00', '10:15', '10:30', '10:45',
        '11:00', '11:15', '11:30', '11:45',
        '12:00', '12:15', '12:30', '12:45',
        '13:00', '13:15', '13:30', '13:45',
        '14:00', '14:15', '14:30', '14:45',
        '15:00', '15:15', '15:30', '15:45',
        '16:00', '16:15', '16:30', '16:45',
        '17:00', '17:15', '17:30', '17:45',
        '18:00', '18:15', '18:30', '18:45',
        '19:00', '19:15', '19:30', '19:45',
        '20:00', '20:15', '20:30', '20:45',
        '21:00', '21:15', '21:30', '21:45',
    ];


    $('.datetimepicker').datetimepicker({
        format:'d/m/Y H:i',
        allowTimes: times,
        step: 15
    });

    $('.datepicker').datetimepicker({
        timepicker:false,
        format:'d/m/Y'
    });

    $('.timepicker').datetimepicker({
        datepicker:false,
        format:'H:i',
        allowTimes: times,
        step: 15
    });

    //Customer Search
    var customerSearchResults = [];
    $("#customersearch").autocomplete({
        source: function( request, response ) {
            var url = prepareAjaxUrl('/fast_dossier/ajax/searchcustomer');
            return $.ajax({
                url		: url,
                type	: 'POST',
                cache	: false,
                data		: {
                    'search' : request.term
                },
                success: function( data ) {
                    customerSearchResults = data;
                    var search = [];
                    var count = 0;
                    $.each( data, function( index, value ) {
                        var item = '';
                        var multiple = false;
                        if(value.first_name && value.last_name){
                            item += value.first_name + ' ' + value.last_name;
                            multiple = true;
                        }

                        if(value.company_name && value.company_vat){
                            if(multiple){
                                item += ' - ';
                            }
                            item += value.company_name + ' [' + value.company_vat + ']';
                            multiple = true;
                        }

                        if(value.street && value.city){
                            if(multiple){
                                item += ' - ';
                            }
                            item += value.street + ' ' + value.street_number  + ', ' + value.zip + ' ' + value.city + ' ' + value.country;
                            multiple = true;
                        }

                        search.push({'label': item,'value': count});
                        count++;
                    });
                    response(search);
                }
            });
        },
        minLength: 1,
        select: function( event, ui ) {
            var id = ui.item.value;
            var selected = customerSearchResults[id];
            $('#customer_search_firstname').val(selected.first_name);
            $('#customer_search_lastname').val(selected.last_name);
            $('#customer_search_company_name').val(selected.company_name);
            $('#customer_search_company_vat').val(selected.company_vat);
            $('#customer_search_street').val(selected.street);
            $('#customer_search_street_nr').val(selected.street_number);
            $('#customer_search_street_pobox').val(selected.street_pobox);
            $('#customer_search_zip').val(selected.zip);
            $('#customer_search_city').val(selected.city);
            $('#customer_search_country').val(selected.country);
            $('#customer_search_phone').val(selected.phone);
            $('#customer_search_email').val(selected.email);
        },
        close: function(event, ui){
            $(this).val('');
        }
    });

    //Causer Search
    var causerSearchResults = [];
    $("#causersearch").autocomplete({
        source: function( request, response ) {
            var url = prepareAjaxUrl('/fast_dossier/ajax/searchcustomer');
            return $.ajax({
                url		: url,
                type	: 'POST',
                cache	: false,
                data		: {
                    'search' : request.term
                },
                success: function( data ) {
                    causerSearchResults = data;
                    var search = [];
                    var count = 0;
                    $.each( data, function( index, value ) {
                        var item = '';
                        var multiple = false;
                        if(value.first_name && value.last_name){
                            item += value.first_name + ' ' + value.last_name;
                            multiple = true;
                        }

                        if(value.company_name && value.company_vat){
                            if(multiple){
                                item += ' - ';
                            }
                            item += value.company_name + ' [' + value.company_vat + ']';
                            multiple = true;
                        }

                        if(value.street && value.city){
                            if(multiple){
                                item += ' - ';
                            }
                            item += value.street + ' ' + value.street_number  + ', ' + value.zip + ' ' + value.city + ' ' + value.country;
                            multiple = true;
                        }

                        search.push({'label': item,'value': count});
                        count++;
                    });
                    response(search);
                }
            });
        },
        minLength: 1,
        select: function( event, ui ) {
            var id = ui.item.value;
            var selected = causerSearchResults[id];
            $('#causer_search_firstname').val(selected.first_name);
            $('#causer_search_lastname').val(selected.last_name);
            $('#causer_search_company_name').val(selected.company_name);
            $('#causer_search_company_vat').val(selected.company_vat);
            $('#causer_search_street').val(selected.street);
            $('#causer_search_street_nr').val(selected.street_number);
            $('#causer_search_street_pobox').val(selected.street_pobox);
            $('#causer_search_zip').val(selected.zip);
            $('#causer_search_city').val(selected.city);
            $('#causer_search_country').val(selected.country);
            $('#causer_search_phone').val(selected.phone);
            $('#causer_search_email').val(selected.email);
        },
        close: function(event, ui){
            $(this).val('');
        }
    });

    /****** Customer *********/
    getCauser().success(function(data){
        updateCauserTemplates(data);
        updateCauserForm(data);
    });

    getCustomer().success(function(data){
        updateCustomerTemplates(data);
        updateCustomerForm(data);
    });

    getDepot().success(function(data){
        updateDepotTemplates(data);
    });

    getActivities().success(function(data){
        updateActivityTemplates(data);
    });

    getAdditionalCosts().success(function(data) {
        updateAdditionalCostsTemplate(data);
    });

    getAvailableActivities().success(function(data){
        updateActivityForm(data);
    });

    getAttachement().success(function(data){
        updateAttachementTemplates(data);
    });



    /****** HANDLEBAR HELPERS  *********/

    Handlebars.registerHelper("inc", function(value, options) {
        return parseInt(value) + 1;
    });

    Handlebars.registerHelper("equal", function(lvalue, rvalue, options) {
        if (arguments.length < 3)
            throw new Error("Handlebars Helper equal needs 2 parameters");
        if( lvalue!=rvalue ) {
            return options.inverse(this);
        } else {
            return options.fn(this);
        }
    });

    Handlebars.registerHelper("math", function(lvalue, operator, rvalue, options) {
        lvalue = parseFloat(lvalue);
        rvalue = parseFloat(rvalue);

        return {
            "+": (lvalue + rvalue).toFixed(2),
            "-": (lvalue - rvalue).toFixed(2),
            "*": (lvalue * rvalue).toFixed(2),
            "/": (lvalue / rvalue).toFixed(2),
            "%": (lvalue % rvalue).toFixed(2)
        }[operator];
    });

    Handlebars.registerHelper('formatNumber', function(value) {
        return value.toFixed(2);
    });



    /****** END HANDLEBAR HELPERS  *********/




    /****** HELPERS *********/

    function initFancyBox(id){
        $(id).fancybox({
            'scrolling'		: 'no',
            'titleShow'		: false
        });
    }



    function redirectPage(url){
        $(location).attr('href',url);
    }

    function prepareAjaxUrl(url){
        return url + '/' + Dossier.dossier_id + '/' + Dossier.voucher_id;
    }

    function serializeFormInputs(inputs){
        var formObj = {};
        $.each(inputs, function (i, input) {
            if(input.name == 'id'){
                formObj[input.name] = parseInt(input.value); //make sure id is numeric
            }else{
                formObj[input.name] = input.value;
            }
        });
        return formObj;
    }

    function serializeActivityCheckboxes(inputs){
        var formArr = [];

        $.each(inputs, function (i, input) {
            var activityObj = {};
            var values = [];
            values = input.value.split("|");
            activityObj.activity_id = parseInt(values[0]);
            activityObj.amount = parseInt(values[1]);
            formArr[i] = activityObj;
        });
        return formArr;
    }

    function parseIsoDatetime(dtstr) {
        var dt = dtstr.split(/[: T-]/).map(parseFloat);
        var iso = new Date(dt[0], dt[1] - 1, dt[2], dt[3] || 0, dt[4] || 0, dt[5] || 0, 0);
        var date = iso.getDate();
        if(date < 10){
            date = '0' + date;
        }
        var month = iso.getMonth() + 1;
        if(month < 10){
            month = 'O' + month;
        }
        var year = iso.getFullYear();
        var hours = iso.getHours();
        var sec = iso.getHours();

        return date + '-' + month + '-' + year + ' ' + hours + ':' + sec;
    }

    function formatUnixTimestampAsDatetime(unix_ts) {
      var t = new Date(parseInt(unix_ts)*1000);
      var formatted = t.getDate()
                + "/"
                + (t.getMonth() + 1)
                + "/"
                + t.getFullYear()
                + " "
                + t.getHours()
                + ":"
                + t.getMinutes()
                + ":"
                + t.getSeconds();

      return formatted;
    }

    /****** END HELPERS *********/






    /****** CAUSER *********/
    function getCauser(){
        var url = prepareAjaxUrl('/fast_dossier/ajax/causer');
        return $.ajax({
            type		: "POST",
            cache	: false,
            url		: url,
            data		: {}
        });
    }

    function setCauser(formObj){
        var url = prepareAjaxUrl('/fast_dossier/ajax/updatecauser');
        return $.ajax({
            type		: "POST",
            cache	: false,
            url		: url,
            data		: {'causer' : formObj}
        });
    }

    function updateCauserTemplates(data){
        var info = Handlebars.Templates['causer/info'];
        $('#causer_info').html(info(data));

        var info_short = Handlebars.Templates['causer/info_short'];
        $('#causer_info_short').html(info_short(data));
    }

    function updateCauserForm(data){
        $.each(data, function(i, item) {
            $('#causer_form').find('input[name="'+ i +'"]').val(item);
        });
    }

    $('#causer_form form').submit(function(event) {
        var inputs = $(this).serializeArray();

        var formObj = {};
        formObj = serializeFormInputs(inputs);

        if(Dossier.btnClicked == 'btnCauserCopy'){
            setCustomer(formObj).success(function(data){
                if(data.id){
                    updateCustomerTemplates(data);
                    updateCustomerForm(data);
                }
                else if(data.result && data.result === 'invalid_vat') {
                    alert('Het nummer: ' + data.vat + ' is geen geldig BTW-nummer.');
                }
            });
        }

        setCauser(formObj).success(function(data){
            if(data.id){
                updateCauserTemplates(data);
                updateCauserForm(data);
                parent.$.fancybox.close();
            }
            else if(data.result && data.result === 'invalid_vat') {
                alert('Het nummer: ' + data.vat + ' is geen geldig BTW-nummer.');
            }
        });

        event.preventDefault();
    });

    /****** END CAUSER *********/




    /******* CUSTOMER *******/
    function getCustomer(){
        var url = prepareAjaxUrl('/fast_dossier/ajax/customer');
        return $.ajax({
            type		: "POST",
            cache	: false,
            url		: url,
            data		: {}
        });
    }

    function setCustomer(formObj){
        var url = prepareAjaxUrl('/fast_dossier/ajax/updatecustomer');
        return $.ajax({
            type		: "POST",
            cache	: false,
            url		: url,
            data		: {'customer' : formObj}
        });
    }

    function setAgencyAsCustomer() {
      var url = prepareAjaxUrl('/fast_dossier/ajax/updateagencycustomer');
      return $.ajax({
          type		: "POST",
          cache	: false,
          url		: url
          //data		: {'customer' : formObj}
      });
    }

    function updateCustomerTemplates(data){
        var template = Handlebars.Templates['customer/info'];
        $('#customer_info').html(template(data));
    }

    function updateCustomerForm(data){
        $.each(data, function(i, item) {
            $('#customer_form').find('input[name="'+ i +'"]').val(item);
        });
    }

    $('#customer_form form').submit(function(event) {
        var inputs = $(this).serializeArray();

        var formObj = {};
        formObj = serializeFormInputs(inputs);

        if(Dossier.btnClicked == 'btnCustomerCopy'){
            setCauser(formObj).success(function(data){
                if(data.id){
                    updateCauserTemplates(data);
                    updateCauserForm(data);
                }
                else if(data.result && data.result === 'invalid_vat') {
                    alert('Het nummer: ' + data.vat + ' is geen geldig BTW-nummer.');
                }
            });
        }

        if(Dossier.btnClicked == 'btnCopyCustomerAWV') {
          setAgencyAsCustomer().success(function(data){
              if(data.id){
                  updateCustomerTemplates(data);
                  updateCustomerForm(data);
                  parent.$.fancybox.close();
              }
          });
        } else {
            setCustomer(formObj).success(function(data){
                if(data.id)
                {
                    updateCustomerTemplates(data);
                    updateCustomerForm(data);
                    parent.$.fancybox.close();
                }
                else if(data.result && data.result === 'invalid_vat') {
                    alert('Het nummer: ' + data.vat + ' is geen geldig BTW-nummer.');
                }
            });
        }

        event.preventDefault();
    });
    /******* END CUSTOMER *******/




    /*******  DEPOT *******/
    function getDepot(){
        var url = prepareAjaxUrl('/fast_dossier/ajax/depot');
        return $.ajax({
            type		: "POST",
            cache	: false,
            url		: url,
            data		: {}
        });
    }

    function setDepot(formObj){
        var url = prepareAjaxUrl('/fast_dossier/ajax/updatedepot');
        return $.ajax({
            type		: "POST",
            cache	: false,
            url		: url,
            data		: {'depot' : formObj}
        });
    }

    function setDepotDefault(formObj){
        var url = prepareAjaxUrl('/fast_dossier/ajax/updatedepottodefault');

        formObj.default_depot = 1;

        return $.ajax({
            type		: "POST",
            cache	: false,
            url		: url,
            data		: {'depot' : formObj}
        });
    }

    function setDepotAWV(formObj){
        var url = prepareAjaxUrl('/fast_dossier/ajax/updatedepottoagency');

        formObj.default_depot = 0;

        return $.ajax({
            type		: "POST",
            cache	: false,
            url		: url,
            data		: {'depot' : formObj}
        });
    }

    function updateDepotTemplates(data){
        var info = Handlebars.Templates['depot/info'];
        $('#depot_info').html(info(data));
    }

    function updateDepotForm(data){
        $.each(data, function(i, item) {
            $('#depot_form').find('input[name="'+ i +'"]').val(item);
        });
    }


    $('#depot_form form').submit(function(event) {
        var inputs = $(this).serializeArray();

        var formObj = {};
        formObj = serializeFormInputs(inputs);

        if(Dossier.btnClicked == 'btnDepotDefault'){
            setDepotDefault(formObj).success(function(data){
                if(data.id){
                    updateDepotTemplates(data);
                    updateDepotForm(data);
                    parent.$.fancybox.close();
                }
            });
        }
        else if(Dossier.btnClicked == 'btnDepotSave')
        {
            setDepot(formObj).success(function(data){
                if(data.id){
                    updateDepotTemplates(data);
                    updateDepotForm(data);
                    parent.$.fancybox.close();
                }
            });
        }
        else if(Dossier.btnClicked == 'btnDepotAWV') {
          setDepotAWV(formObj).success(function(data){
              if(data.id){
                  updateDepotTemplates(data);
                  updateDepotForm(data);
                  parent.$.fancybox.close();
              }
          });
        }

        event.preventDefault();
    });

    /*******  END DEPOT *******/





    /*******  NOTA *******/

    function addNota(formObj){
        var url = '/fast_dossier/ajax/addinternalcommunication';
        return $.ajax({
            type		: "POST",
            cache	: false,
            url		: url,
            data		: {'communication' : formObj}
        });
    }

    function getNotas(){
        var url = prepareAjaxUrl('/fast_dossier/ajax/getinternalcommunication');
        return $.ajax({
            type		: "POST",
            cache	: false,
            url		: url,
            data		: {}
        });
    }

    function updateNotaTemplates(data) {
        var items = {
            notas : []
        };

        $.each( data, function( key, value ) {
            value.cd = formatUnixTimestampAsDatetime(value.cd);
            items.notas.push(value);
        });

        var template = Handlebars.Templates['nota/overview'];
        $('#view-nota-container .notas').html(template(items));
    }

    $('#add-nota-form form').submit(function(event) {
        var inputs = $(this).serializeArray();

        var formObj = {};
        formObj = serializeFormInputs(inputs);

        addNota(formObj).success(function(data){
            getNotas().success(function(data){
                updateNotaTemplates(data);
            });
            parent.$.fancybox.close();
        });

        event.preventDefault();
    });

    /*******  END NOTA *******/





    /*******  EMAIL *******/

    function sendEmail(formObj){
        var url = '/fast_dossier/ajax/addemailcommunication';
        return $.ajax({
            type		: "POST",
            cache	: false,
            url		: url,
            data		: {'communication' : formObj}
        });
    }

    function getEmails(){
        var url = prepareAjaxUrl('/fast_dossier/ajax/getemailcommunication');
        return $.ajax({
            type		: "POST",
            cache	: false,
            url		: url,
            data		: {}
        });
    }

    function updateEmailTemplates(data) {
        var items = {
            emails : []
        };

        $.each( data, function( key, value ) {
            value.cd = formatUnixTimestampAsDatetime(value.cd);
            items.emails.push(value);
        });

        var template = Handlebars.Templates['email/overview'];
        $('#view-email-container .emails').html(template(items));
    }

    $('#add-email-form form').submit(function(event) {

        var inputs = $(this).serializeArray();

        var formObj = {};
        formObj = serializeFormInputs(inputs);

        sendEmail(formObj).success(function(data){
            getEmails().success(function(data){
                updateEmailTemplates(data);
            });
            parent.$.fancybox.close();
        });

        event.preventDefault();
    });

    /*******  END EMAIL *******/

    /*******  ATTACHEMENT *******/



    function addAttachement(formObj){
        var url = prepareAjaxUrl('/fast_dossier/ajax/addAttachment');

        return $.ajax({
            type		: "POST",
            cache	: false,
            url		: url,
            data		: {'file' : formObj}
        });
    }

    function getAttachement(){
        var url = prepareAjaxUrl('/fast_dossier/ajax/getAttachments');
        return $.ajax({
            type		: "POST",
            cache	: false,
            url		: url,
            data		: {}
        });
    }

    function updateAttachementTemplates(data) {
        var items = {
            attachments : []
        };

        $.each( data, function( key, value ) {
            items.attachments.push(value);
        });

        var template = Handlebars.Templates['attachment/overview'];
        $('#view-attachment-container .attachments').html(template(items));
    }

    //ATTACHEMENT UPLOAD
    var Attachments = [];

    $("#add-attachment-form input[type=file]").change(function(event) {
        var html = '';
        Attachments = [];
        $('#attachments__errors').css('display', 'none').html('');

        $.each(event.target.files, function(index, file) {
            var reader = new FileReader();
            reader.onload = function (event) {
                object = {};
                object.file_name = file.name;
                object.file_size = file.size;
                object.content_type = file.type;
                object.content = event.target.result;
                Attachments.push(object);
                html += '<p>' + file.name + '</p>';
            }
            reader.readAsDataURL(file);
        });
    });


    $('#add-attachment-form form').submit(function(event) {
        var Errors = [];
        $.each(Attachments, function(index, file) {
            if(file.content_type == ''){
                Errors[index] = file.file_name + ' kon niet worden geupload omdat dit type bestand niet ondersteund word.';
            }else{
                addAttachement(file).success(function(data){
                    if(data.result != 'OK'){
                        Errors[index] = file.file_name + ' kon niet worden geupload.';
                    }
                });
            }
        });

        Attachments = [];

        if(Errors.length > 0){
            $.each(Errors, function(index, error) {
                $('#attachments__errors').append(error);
            });
            $('#attachments__errors').css('display', 'block');
        }else{
            parent.$.fancybox.close();
            $(this)[0].reset();
        }

        $(this)[0].reset();
        event.preventDefault();

    });




    /*******  END EMAIL *******/





    /*******  ACTIVITIES AND ADDITIONAL COSTS *******/

    function getActivities(){
        var url = prepareAjaxUrl('/fast_dossier/ajax/activities');
        return $.ajax({
            type: "POST",
            cache: false,
            url: url,
            data: {}
        });
    }

    function getAdditionalCosts() {
      var url = prepareAjaxUrl('/fast_dossier/ajax/additionalCosts');
      return $.ajax({
          type: "POST",
          cache: false,
          url: url,
          data: {}
      });
    }

    function getAvailableActivities(){
        var url = prepareAjaxUrl('/fast_dossier/ajax/availableActivities');
        return $.ajax({
            type: "POST",
            cache: false,
            url: url,
            data: {}
        });
    }

    function addActivities(formObj){
        var url = prepareAjaxUrl('/fast_dossier/ajax/addActivitiesToVoucher');
        return $.ajax({
            type: "POST",
            cache: false,
            url: url,
            data: {'activities' : formObj}
        });
    }

    function removeActivity(aid){
        var url = '/fast_dossier/ajax/removeActivityFromVoucher/' + Dossier.voucher_id + '/' + aid;

        return $.ajax({
            type: "POST",
            cache: false,
            url: url,
            data: {}
        });
    }

    function removeAdditionalCost(aid)
    {
      var url = '/fast_dossier/ajax/removeAdditionalCostFromVoucher/' + Dossier.voucher_id + '/' + aid;

      return $.ajax({
          type: "POST",
          cache: false,
          url: url,
          data: {}
      });
    }

    function updateActivityTotalPrice(){
        var total = 0;
        var btw_from_belgium = true;
        if(btw_from_belgium){
            $('.work-container__tot__incl input').each(function() {
                total += parseFloat($(this).val());
            });
            $('.additional-costs-container__incl input').each(function() {
                if($.isNumeric($(this).val())) {
                    total += parseFloat($(this).val());
                }
            });
            $('#payment_total input').val(total.toFixed(2));
        }else{
            $('.work-container__tot__excl input').each(function() {
                total += parseFloat($(this).val());
            });
            $('.additional-costs-container__excl input').each(function() {
                if($.isNumeric($(this).val())) {
                    total += parseFloat($(this).val());
                }
            });
            $('#payment_total input').val(total.toFixed(2));
        }

        $('#payment_total').trigger('change');
    }

    function recalcuteActivityPrice(){
        var insurance = $('#payment_insurance input').val() || 0;
        var cash      = $('#payment_cash input').val() || 0;
        var bank      = $('#payment_bank input').val() || 0;
        var debit     = $('#payment_debit input').val() || 0;
        var credit    = $('#payment_credit input').val() || 0;
        var total     = $('#payment_total input').val() || 0;

        var topay     = total - insurance - cash - bank - debit - credit;
        var paid      = (total - topay).toFixed(2);
        var unpaid    = topay.toFixed(2);

        $('#payment_paid input').val(paid);
        $('#payment_unpaid input').val(unpaid);
    }


    function updateActivityTemplates(data) {
        updateActivityList(data);
    }

    function updateAdditionalCostsTemplate(data) {
        updateAdditionalCostsList(data);
    }

    function updateActivityList(data){
        var items = {
            activities : []
        };

        $.each( data, function( key, value ) {
            items.activities.push(value);
        });

        var template = Handlebars.Templates['activity/activitylist'];
        $('#added-activities .work-container__fields').html(template(items));
    }

    function updateAdditionalCostsList(data){
        var items = {
            costs : []
        };

        $.each( data, function( key, value ) {
            items.costs.push(value);
        });

        var template = Handlebars.Templates['activity/additionalcosts'];
        $('#added-activities .additional-costs-container__fields').html(template(items));
    }

    function updateActivityForm(data){
        if(data.length > 0){
            var items = {
                activities : []
            };

            $.each( data, function( key, value ) {
                items.activities.push(value);
            });

            var template = Handlebars.Templates['activity/checkboxes'];
            $('#add-work-form-ajaxloaded-content').html(template(items));
        }else{
            $('#add-work-form-ajaxloaded-content').html('Alle mogelijke activiteiten zijn toegevoegd');
        }

    }

    //REMOVE
    $(document).on('click','.work-container__remove', function(){
        var aid =$(this).data('id');

        removeActivity(aid).success(function(data){
            updateActivityTemplates(data);
            updateActivityTotalPrice();
            recalcuteActivityPrice();

            getAvailableActivities().success(function(available){
                updateActivityForm(available);
            });
        });

        return false;
    });


    $('#add-activity-form form').submit(function(event) {
        var inputs = $(this).serializeArray();
        var formObj = {};
        formObj = serializeActivityCheckboxes(inputs);

        addActivities(formObj).success(function(data){
                updateActivityTemplates(data);
                updateActivityTotalPrice();
                recalcuteActivityPrice();
                parent.$.fancybox.close();

                getAvailableActivities().success(function(available){
                    updateActivityForm(available);
                });
        });

        event.preventDefault();
    });

    //CHANGE NUMBER
    $(document).on('change','.work-container__field .work-container__number input', function(){
        var unit_incl = $(this).parents('.work-container__field').data('incl');
        var unit_excl = $(this).parents('.work-container__field').data('excl');
        var new_incl = 0;
        var new_excl = 0;

        var number = $(this).val();

        if (!$.isNumeric(number)) {
            $(this).val(1);
            new_incl = unit_incl.toFixed(2);
            new_excl = unit_excl.toFixed(2);
        } else {
            new_incl = (unit_incl * number).toFixed(2);
            new_excl = (unit_excl * number).toFixed(2);
        }

        $(this).parents('.work-container__field').find('.work-container__tot__incl').find('input').val(new_incl);
        $(this).parents('.work-container__field').find('.work-container__tot__excl').find('input').val(new_excl);

        updateActivityTotalPrice();
        recalcuteActivityPrice();
    });

    //CHANGE ADDITIONAL COSTS
    // INCL
    $(document).on('change','.additional-costs-container__field .additional-costs-container__incl input', function() {
        var incl = $(this).val().replace(',', '.');
        var excl = '';
        if(!$.isNumeric(incl)){
            incl = '';
            excl = '';
        }else{
            incl = parseFloat(incl).toFixed(2);
            excl = (incl / 1.21).toFixed(2);
        }
        $(this).parents('.additional-costs-container__field').find('.additional-costs-container__incl').find('input').val(incl);
        $(this).parents('.additional-costs-container__field').find('.additional-costs-container__excl').find('input').val(excl);
        updateActivityTotalPrice();
    });

    //EXCL
    $(document).on('change','.additional-costs-container__field .additional-costs-container__excl input', function() {
        var excl = $(this).val().replace(',', '.');
        var incl = '';
        if(!$.isNumeric(excl)){
            incl = '';
            excl = '';
        }else{
            excl = parseFloat(excl).toFixed(2);
            incl = (excl * 1.21).toFixed(2);
        }
        $(this).parents('.additional-costs-container__field').find('.additional-costs-container__incl').find('input').val(incl);
        $(this).parents('.additional-costs-container__field').find('.additional-costs-container__excl').find('input').val(excl);
        updateActivityTotalPrice();
    });

        //RECALCULATE ON CHANGE
    $('#payment_insurance, #payment_credit, #payment_debit, #payment_cash, #payment_bank, #payment_total').change(function(){
        recalcuteActivityPrice();
    });

    //REMOVE ADDITIONAL COST FROM VOUCHER
    $(document).on('click','.additional-costs-container__remove', function(){
        var aid =$(this).data('id');

        if(confirm('Bent u zeker dat u deze kost wenst te verwijderen?'))
        {
          removeAdditionalCost(aid).success(function(data){
              updateAdditionalCostsTemplate(data);
              updateActivityTotalPrice();
              recalcuteActivityPrice();

              getAdditionalCosts().success(function(costs){
                updateAdditionalCostsTemplate(costs);
              });
          });
        }


        return false;
    });

    /*******  END ACTIVITIES *******/


    /*******  COLLECTOR ********/


    function requestCollectorSignature(){
        var url = prepareAjaxUrl('/fast_dossier/ajax/requestcollectorsignature');

        return $.ajax({
            type: "POST",
            cache: false,
            url: url,
            data: {}
        });
    }

    $('#signature-collector').on('click', function() {
        requestCollectorSignature().success(function(data) {
            alert('De aanvraag voor een handtekening werd verzonden naar de iPad!');
        });
        return false;
    });


    /******* END COLLECTOR ********/


    /*******  CAUSER ********/


    function requestCauserSignature(){
        var url = prepareAjaxUrl('/fast_dossier/ajax/requestcausersignature');

        return $.ajax({
            type: "POST",
            cache: false,
            url: url,
            data: {}
        });
    }

    $('#signature-causer').on('click', function() {
        requestCauserSignature().success(function(data) {
            alert('De aanvraag voor een handtekening werd verzonden naar de iPad!');
        });
        return false;
    });


    /******* END CAUSER ********/


    /*******  TRAFFIC POST ********/

    function requestTrafficPostSignature(){
        var url = prepareAjaxUrl('/fast_dossier/ajax/requesttrafficpostsignature');

        return $.ajax({
            type: "POST",
            cache: false,
            url: url,
            data: {}
        });
    }

    $('#signature-traffic-post').on('click', function() {
        requestTrafficPostSignature().success(function(data) {
            alert('De aanvraag voor een handtekening werd verzonden naar de iPad!');
        });
        return false;
    });


    /******* END TRAFFIC POST ********/

    function fetchDataForListBox($id, $api, cb, $append_empty) {
      $.getJSON($api, function(data, status, xhr) {
        if(data) {
          $selectedValue = $($id).data('selected-id');

          $($id).empty();

          if($append_empty) {
            $($id).append($('<option/>', {
              value: '',
              text : '--'
            }));
          }

          $.each(data, function(index, item) {

            $data = cb(item);


            if($selectedValue && ($selectedValue == item.id || $selectedValue == item.name)) {
              $data["selected"] = "selected";
            }

            $($id).append($('<option/>', $data));
          });

          $($id).trigger('chosen:updated');
        }
      });
    }

    var defaultDataMapper = function(item) {
        return  {
          value     : item.id,
          text      : item.name
        };
    }

    var driverDataMapper = function (item) {
      var $label = item.name;

      $label += " (";
      $label += (item.licence_plate && item.licence_plate != '' ? item.licence_plate : '');
      $label += (item.vehicule && item.vehicule != '' ? (item.licence_plate != '' ? ' - ' + item.vehicule : item.vehicule) : '');
      $label += ")";

      return {
        value     : item.id,
        text      : $label
      };
    }

    var licencePlateDataMapper = function (item) {
      return {
        value     : item.name,
        text      : item.name
      };
    }

    var towingVehiclesDataMapper = function(item) {
      return {
        value   : item.id,
        text    : item.name + "(" + item.licence_plate + ")"
      }
    }

    fetchDataForListBox('#list_insurance_id',             '/fast_dossier/ajax/insurances',            defaultDataMapper, true);
    fetchDataForListBox('#list_collector_id',             '/fast_dossier/ajax/collectors',            defaultDataMapper, true);
    fetchDataForListBox('#list_signa_id',                 '/fast_dossier/ajax/signadrivers',          driverDataMapper, true);
    fetchDataForListBox('#list_towing_id',                '/fast_dossier/ajax/towingdrivers',         driverDataMapper, true);
    fetchDataForListBox('#list_licence_plate_country',    '/fast_dossier/ajax/licenceplatecountries', licencePlateDataMapper, true);
    fetchDataForListBox('#list_towing_vehicle_id',        '/fast_dossier/ajax/towingvehicles',        towingVehiclesDataMapper, true);

    fetchDataForListBox('#list_allotment_direction_id',       '/fast_dossier/ajax/directions', defaultDataMapper, false);

    var direction_id = $('#list_allotment_direction_id').data('selected-id');
    fetchDataForListBox('#list_allotment_direction_indicator_id',  '/fast_dossier/ajax/indicators/'+direction_id, defaultDataMapper, false);


    $('#list_allotment_direction_id').change(function(){
      var id = $('#list_allotment_direction_id option:selected').val();

      fetchDataForListBox('#list_allotment_direction_indicator_id',  '/fast_dossier/ajax/indicators/'+id, defaultDataMapper, false);
    });


    /** VALIDATION MESSAGES **/
    if($('#validation_messages').length != 0)
    {
      $.getJSON('/fast_dossier/ajax/fetchValidationMessages/' + Dossier.voucher_id, function(data, status, xhr) {
        if(data && data.length > 0) {
          $('#validation_messages').append("<h3>Gelieve volgende elementen te controleren</h3><ul id='validation_messages_list'></ul>");

          $.each(data, function(n, element) {
            $('#validation_messages_list').append("<li>" + element.message + "</li>");
          });
        } else {
          $('#validation_messages').hide();
        }
      });
    }

    /** INVOICE */
    // $('#btnInvoiceGenerate').on('click', function(){
    //     if(confirm('Bent u zeker dat u een factuur wenst aan te maken?')) {
    //       $.ajax({
    //           type: "POST",
    //           cache: false,
    //           url: '/invoicing/ajax/createInvoiceForVoucher/' + Dossier.voucher_id,
    //           data: {}
    //       }).success(function(data) {
    //         if(data.result && data.result == 'ok') {
    //           //alert('De factuur zal binnen enkele momenten beschikbaar zijn in de bijlagen van deze takelbon.');
    //           //location.reload();
    //           location.href='/invoicing/overview/batch';
    //         } else if(data.result && data.result == 'validation_errors') {
    //           location.reload();
    //         } else {
    //           alert('Er is iets fout gegaan bij het aanmaken van de factuur!');
    //         }
    //       });
    //
    //     }
    // });


    $('#generate-invoice-form form').submit(function(event) {
        var inputs = $(this).serializeArray();

        var formObj = {};
        formObj = serializeFormInputs(inputs);

        generateInvoice(formObj).success(function(data){
          parent.$.fancybox.close();

          if(data.result && data.result == 'ok') {
            //alert('De factuur zal binnen enkele momenten beschikbaar zijn in de bijlagen van deze takelbon.');
            //location.reload();
            location.href='/invoicing/overview/batch';
          } else if(data.result && data.result == 'validation_errors') {
            location.reload();
          } else {
            alert('Er is iets fout gegaan bij het aanmaken van de factuur!');
          }
        });

        event.preventDefault();
    });


    function generateInvoice(formObj){
        var url = '/invoicing/ajax/createInvoiceForVoucher';
        return $.ajax({
            type		: "POST",
            cache	: false,
            url		: url,
            data		: formObj
        });
    }


    $('#create-invoice-storage-button').on('click', function(){
        if(confirm('Bent u zeker dat u een factuur wenst aan te maken?')) {
          $.ajax({
              type: "POST",
              cache: false,
              url: '/invoicing/ajax/createStorageInvoiceForVoucher/' + Dossier.voucher_id,
              data: {}
          }).success(function(data) {
            if(data.result && data.result == 'ok') {
              //alert('De factuur zal binnen enkele momenten beschikbaar zijn in de bijlagen van deze takelbon.');
              //location.reload();
              location.href='/invoicing/overview/batch';
            } else if(data.result && data.result == 'validation_errors') {
              location.reload();
            } else {
              alert('Er is iets fout gegaan bij het aanmaken van de factuur!');
            }
          });

        }
    });
});
