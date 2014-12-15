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

$(document).ready(function() {

  $('#edit-depot-link').fancybox({
    'scrolling'		: 'no',
    'titleShow'		: false,
  });

  $('#edit-invoice-data-link').fancybox({
    'scrolling'		: 'no',
    'titleShow'		: false
  });

  $('#edit-nuisance-data-link').fancybox({
    'scrolling'		: 'no',
    'titleShow'		: false
  });

  $('#add-email-link').fancybox({
    'scrolling'		: 'no',
    'titleShow'		: false
  });

  $('#add-nota-link').fancybox({
    'scrolling'		: 'no',
    'titleShow'		: false
  });

  $('#view-nota-link').fancybox({
    'scrolling'		: 'no',
    'titleShow'		: false
  });

    $('#view-email-link').fancybox({
        'scrolling'		: 'no',
        'titleShow'		: false
    });


    $('#add-work-link').fancybox({
    'scrolling'		: 'no',
    'titleShow'		: false,
    'beforeLoad' : function (){

          var did = $('#add-work-link').data('did');
          var vid = $('#add-work-link').data('vid');

          $.ajax({
              type		: "POST",
              cache	: false,
              url		: "/fast_dossier/ajax/availableActivities/" + did + '/' + vid,
              success: function(data) {
                 var form = '';
                 var attr = '';

                  $.each(data, function( key, value ) {
                    value.locked = 0;
                    attr += 'data-id="'+ value.id +'" data-label="'+ value.name +'" data-code="'+ value.code +'" data-incl="'+ value.fee_incl_vat +'" data-excl="'+ value.fee_excl_vat +'" data-number-locked="'+ value.locked +'"';
                    form += '<div class="form-item-checkbox">';
                    form += '<input type="checkbox" name="activity" value="'+ value.id +'" '+ attr +' >';
                    form += '<label>'+ value.name +'</label>';
                    form += '</div>';
                    attr = '';
                  });

                 $('#add-work-form-ajaxloaded-content').html(form);

              }
          });
      }
  });

  $('.close_overlay').on('click', function(){
    parent.$.fancybox.close();
    return false;
  });

        //NOTA
    /*
  $('#add-nota-form form').bind('submit', function() {

    var did = $(this).data('did');
    var vid = $(this).data('vid');

    var formObj = {};
    var inputs = $(this).serializeArray();
    $.each(inputs, function (i, input) {
      formObj[input.name] = input.value;
    });

    formObj['dossier_id'] = did;
    formObj['voucher_id'] = vid;

    $.ajax({
      type		: "POST",
      cache	: false,
      url		: "/fast_dossier/ajax/addinternalcommunication",
      data		: {'communication' : formObj},
      success: function(data) {
        if(data.result == 'OK'){
          parent.$.fancybox.close();
        }else{
          $('#add-nota-form').find('.msg__error').show();
          $.fancybox.resize();
        }
      }
    });
    return false;
  });
  */

  //EMAIL
/*
  $('#add-email-form form').bind('submit', function() {

    var did = $(this).data('did');
    var vid = $(this).data('vid');

    var formObj = {};
    var inputs = $(this).serializeArray();
    $.each(inputs, function (i, input) {
      formObj[input.name] = input.value;
    });

    formObj['dossier_id'] = did;
    formObj['voucher_id'] = vid;

    $.ajax({
      type		: "POST",
      cache	: false,
      url		: "/fast_dossier/ajax/addemailcommunication",
      data		: {'communication' : formObj},
      success: function(data) {
        if(data.result == 'OK'){
          parent.$.fancybox.close();
        }else{
          $('#add-email-form').find('.msg__error').show();
          $.fancybox.resize();
        }

      }
    });
    return false;
  });

*/
    
  //WORK

  $('#add-work-form form').bind('submit', function() {
      var formObj = {};
      var inputs = $(this).find('input[type="checkbox"]');

      $.each(inputs, function (i, input) {
        if($(this).is(':checked')){
          var id = $(this).data('id');
          var label = $(this).data('label');
          var code = $(this).data('code');
          var incl = $(this).data('incl');
          var excl = $(this).data('excl');
          var locked = $(this).data('number-locked');

          if(locked == 1){
              $('.work-container__fields').append('<div class="work-container__field" data-id="'+ id + '" data-incl="'+ incl +'" data-excl="'+ excl +'"><div class="form-item-vertical work-container__task"><input type="text" name="name[]" value="'+ label +'" readonly="readonly" style="background: #F0F0F0"><input type="hidden" name="activity_id[]" value="'+ id +'"></div><div class="form-item-vertical work-container__number"><input type="text" name="amount[]" value="1" readonly="readonly" style="background: #F0F0F0"></div><div class="form-item-vertical work-container__unitprice"><input type="text" name="fee_incl_vat[]" value="'+ incl +'" readonly="readonly" style="background: #F0F0F0"></div><div class="form-item-vertical work-container__excl"><input type="text" name="cal_fee_excl_vat[]" value="'+ excl +'" readonly="readonly" style="background: #F0F0F0"></div><div class="form-item-vertical work-container__incl"><input type="text" name="cal_fee_incl_vat[]" value="'+ incl +'" readonly="readonly" style="background: #F0F0F0"></div><div class="form-item-vertical work-container__remove"><div class="work-container__remove__btn"><div class="btn--icon--small"><a class="icon--remove--small" href="#">Remove</a></div></div></div></div>');
          }else{
              $('.work-container__fields').append('<div class="work-container__field" data-id="'+ id + '" data-incl="'+ incl +'" data-excl="'+ excl +'"><div class="form-item-vertical work-container__task"><input type="text" name="name[]" value="'+ label +'" readonly="readonly" style="background: #F0F0F0"><input type="hidden" name="activity_id[]" value="'+ id +'"></div><div class="form-item-vertical work-container__number"><input type="text" name="amount[]" value="1"></div><div class="form-item-vertical work-container__unitprice"><input type="text" name="fee_incl_vat[]" value="'+ incl +'" readonly="readonly" style="background: #F0F0F0"></div><div class="form-item-vertical work-container__excl"><input type="text" name="cal_fee_excl_vat[]" value="'+ excl +'" readonly="readonly" style="background: #F0F0F0"></div><div class="form-item-vertical work-container__incl"><input type="text" name="cal_fee_incl_vat[]" value="'+ incl +'" readonly="readonly" style="background: #F0F0F0"></div><div class="form-item-vertical work-container__remove"><div class="work-container__remove__btn"><div class="btn--icon--small"><a class="icon--remove--small" href="#">Remove</a></div></div></div></div>');
          }
        }
      });

      update_total_price();
      recalculate_price();
      parent.$.fancybox.close();
      return false;
  });

  //VOUCHER SWITCHER
  $(document).on('change', '#voucher_switcher', function(){
   var dossier = $('#voucher_switcher').data('did');
   var selected = $(this).val();
   var url = '/fast_dossier/dossier/' + dossier + '/' + selected;
   redirectPage(url);
  });


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

    $(this).parents('.work-container__field').find('.work-container__incl').find('input').val(new_incl);
    $(this).parents('.work-container__field').find('.work-container__excl').find('input').val(new_excl);

    update_total_price();
    recalculate_price();
  });

  $(document).on('click','.work-container__remove', function(){
    var aid = $(this).data('aid');
    var vid = $(this).data('vid');

    $.ajax({
      type		: "POST",
      cache	: false,
      url		: "/fast_dossier/ajax/removeactivityfromvoucher/" + vid + "/" + aid,
      data		: {},
      success: function(data) {
      }
    });

    $(this).parents('.work-container__field').remove();
    update_total_price();
    recalculate_price();

    return false;
  });

  $('#payment_insurance, #payment_credit, #payment_debit, #payment_cash, #payment_bank, #payment_total').change(function(){
    recalculate_price();
  });

  function update_total_price(){
    var total = 0;
    $('.work-container__incl input').each(function() {
      total += parseFloat($(this).val());
    });
    $('#payment_total input').val(total.toFixed(2));
  }

  function recalculate_price(){

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


  $('#signature-collector').bind('click', function() {
    var did = $(this).data('did');
    var vid = $(this).data('vid');

    $.ajax({
      type		: "POST",
      cache	: false,
      url		: "/fast_dossier/ajax/requestcollectorsignature/" + did + "/" + vid,
      data		: {},
      success: function(data) {
        //do nothing, it's requested.
        alert('De aanvraag voor een handtekening werd verzonden naar de iPad!');
      }
    });
    return false;
  });


  $('#signature-causer').bind('click', function() {
    var did = $(this).data('did');
    var vid = $(this).data('vid');

    $.ajax({
      type		: "POST",
      cache	: false,
      url		: "/fast_dossier/ajax/requestcausersignature/" + did + "/" + vid,
      data		: {},
      success: function(data) {
        //do nothing, it's requested.
        alert('De aanvraag voor een handtekening werd verzonden naar de iPad!');
      }
    });
    return false;
  });

  $('#signature-traffic-post').bind('click', function() {
    var did = $(this).data('did');
    var vid = $(this).data('vid');

    $.ajax({
      type		: "POST",
      cache	: false,
      url		: "/fast_dossier/ajax/requesttrafficpostsignature/" + did + "/" + vid,
      data		: {},
      success: function(data) {
        //do nothing, it's requested.
        alert('De aanvraag voor een handtekening werd verzonden naar de iPad!');
      }
    });
    return false;
  });








    /******* REFACTORING JS ********/

    var Dossier = {};

    /* Document Ready */
    $(document).ready(function() {
        var url = document.URL.split('/');
        var dossier_id = url[url.length-2];
        var voucher_id = url[url.length-1];
        Dossier.dossier_id = dossier_id;
        Dossier.voucher_id = voucher_id;

        $('input[type="submit"]').click(function (){
            Dossier.btnClicked = $(this).attr('name');
        });

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

    });

    /****** Handlebar Helpers *********/

    Handlebars.registerHelper("inc", function(value, options) {
        return parseInt(value) + 1;
    });


    /****** Helpers *********/

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


    /****** Causer *********/
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

    /****** END Causer *********/


    /******* Customer *******/
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
    /******* END Customer *******/

    /*******  Depot *******/
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
                    console.log(data);
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

    /*******  END Depot *******/

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
        $('#view-nota-container').html(template(items));
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
        console.log(data);
        var items = {
            emails : []
        };

        $.each( data, function( key, value ) {
            items.emails.push(value);
        });

        var template = Handlebars.Templates['email/overview'];
        $('#view-email-container').html(template(items));
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


});
