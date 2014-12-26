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
    var dossier_id = url[url.length-2];
    var voucher_id = url[url.length-1];
    Dossier.dossier_id = dossier_id;
    Dossier.voucher_id = voucher_id;

    $('.close_overlay').on('click', function(){
        parent.$.fancybox.close();
        return false;
    });


    $('input[type="submit"]').on('click', function (){
        Dossier.btnClicked = $(this).attr('name');
    });

    $(document).on('change', '#voucher_switcher', function(){
        var selected = $(this).val();
        var url = '/fast_dossier/dossier/' + Dossier.dossier_id + '/' + selected;
        redirectPage(url);
    });

    //INIT
    initFancyBox('#edit-depot-link');
    initFancyBox('#edit-invoice-data-link');
    initFancyBox('#edit-nuisance-data-link');
    initFancyBox('#add-email-link');
    initFancyBox('#add-nota-link');
    initFancyBox('#view-nota-link');
    initFancyBox('#view-email-link');
    initFancyBox('#add-activity-link');
    initFancyBox('#add-attachment-link');
    initFancyBox('#view-attachment-link');

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

    getNotas().success(function(data){
        updateNotaTemplates(data);
    });

    getEmails().success(function(data){
        updateEmailTemplates(data);
    });

    getActivities().success(function(data){
        updateActivityTemplates(data);
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
            });
        }

        setCauser(formObj).success(function(data){
            if(data.id){
                updateCauserTemplates(data);
                updateCauserForm(data);
                parent.$.fancybox.close();
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
            });
        }

        setCustomer(formObj).success(function(data){
            if(data.id){
                updateCustomerTemplates(data);
                updateCustomerForm(data);
                parent.$.fancybox.close();
            }
        });

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
        }else{
            if(Dossier.btnClicked == 'btnDepotSave'){
                setDepot(formObj).success(function(data){
                    if(data.id){
                        updateDepotTemplates(data);
                        updateDepotForm(data);
                        parent.$.fancybox.close();
                    }
                });
            }
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
        var url = '/fast_dossier/ajax/addemailcommunication';

        return $.ajax({
            type		: "POST",
            cache	: false,
            url		: url,
            data		: {'file' : formObj},
            enctype: 'multipart/form-data',
            processData: false,  // tell jQuery not to process the data
            contentType: false   // tell jQuery not to set contentType

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

    $('#add-attachement-form form').submit(function(event) {

        var inputs = $(this).serializeArray();

        var formObj = {};
        formObj = serializeFormInputs(inputs);

        formObj = {};

        addAttachement(formObj).success(function(data){

        });
        event.preventDefault();
    });

    /*******  END EMAIL *******/





    /*******  ACTIVITIES *******/

    function getActivities(){
        var url = prepareAjaxUrl('/fast_dossier/ajax/activities');
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

    function updateActivityTotalPrice(){
        var total = 0;
        var btw_from_belgium = true;
        if(btw_from_belgium){
            $('.work-container__tot__incl input').each(function() {
                total += parseFloat($(this).val());
            });
            $('#payment_total input').val(total.toFixed(2));
        }else{
            $('.work-container__tot__excl input').each(function() {
                total += parseFloat($(this).val());
            });
            $('#payment_total input').val(total.toFixed(2));
        }

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

    //RECALCULATE ON CHANGE
    $('#payment_insurance, #payment_credit, #payment_debit, #payment_cash, #payment_bank, #payment_total').change(function(){
        recalcuteActivityPrice();
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

    function fetchDataForListBox($id, $api) {
      $.getJSON($api, function(data, status, xhr) {
        if(data) {
          $selectedValue = $($id).data('selected-id');

          $($id).append($('<option/>', {
            value: '',
            text : '--'
          }));

          $.each(data, function(index, item) {

            $data = {
              value     : item.id,
              text      : item.name
            }

            if($selectedValue && $selectedValue == item.id) {
              $data["selected"] = "selected";
            }

            $($id).append($('<option/>', $data));
          });

          $($id).trigger('chosen:updated');
        }
      });
    }

    fetchDataForListBox('#list_insurance_id', '/fast_dossier/ajax/insurances');
    fetchDataForListBox('#list_collector_id', '/fast_dossier/ajax/collectors');
    fetchDataForListBox('#list_signa_id',     '/fast_dossier/ajax/signadrivers');
    fetchDataForListBox('#list_towing_id',    '/fast_dossier/ajax/towingdrivers');

    $.getJSON('/fast_dossier/ajax/licenceplatecountries', function(data, status, xhr)
    {
      if(data) {
        $selectedValue = $('#list_licence_plate_country').data('selected-id');

        $('#list_licence_plate_country').append($('<option/>', {
          value: '',
          text : '--'
        }));

        $.each(data, function(index, item) {
          $data = {
            value     : item.name,
            text      : item.name
          }

          if($selectedValue && $selectedValue == item.name) {
            $data["selected"] = "selected";
          }

          $('#list_licence_plate_country').append($('<option/>', $data));
        });

        $('#list_licence_plate_country').trigger('chosen:updated');
      }
    });

});
