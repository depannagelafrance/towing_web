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

function composeAddressHtml(data) {
  html = '';

  if(data.company_name !== ''){
    html += '<div>' + data.company_name + '</div>';
  }else{
    html += '<div>' + data.last_name + ' ' + data.first_name + '</div>';
  }

  if(data.street !== '' || data.street_number !== ''  ){
    if(data.street_pobox !== ''){
      html += '<div>' + data.street + ' ' + data.street_number + ' ' + data.street_pobox + '</div>';
    } else {
      html += '<div>' + data.street + ' ' + data.street_number + '</div>';
    }
  }

  if((data.zip && data.zip !== '') || (data.city && data.city !== '')  ){
    html += '<div>' + data.zip + ' ' + data.city + '</div>';
  }
  if(data.country && data.country !== ''){
    html += '<div>' + data.country + '</div>';
  }
  if(data.phone !== ''){
    html += '<div>T: ' + data.phone + '</div>';
  }
  if(data.email !== ''){
    html += '<div>E: ' + data.email + '</div>';
  }

  return html;
}

function composeShortAddressHtml(data) {
    html = '';

    if(data.company_name !== ''){
        html += '<div class="nuisance_value">' + data.company_name + '</div>';
    }else{
        html += '<div class="nuisance_value">' + data.first_name + ' ' + data.last_name + '</div>';
    }

    if(data.street !== '' || data.street_number !== ''  ){
        if(data.street_pobox !== ''){
            html += '<div class="nuisance_value">' + data.street + ' ' + data.street_number + ' ' + data.street_pobox + '</div>';
        } else {
            html += '<div class="nuisance_value">' + data.street + ' ' + data.street_number + '</div>';
        }
    }

    if((data.zip && data.zip !== '') || (data.city && data.city !== '')  ){
        html += '<div class="nuisance_value">' + data.zip + ' ' + data.city + '</div>';
    }

    return html;
}


$(document).ready(function() {

  $('#edit-depot-link').fancybox({
    'scrolling'		: 'no',
    'titleShow'		: false,
    'onClosed'		: function() {
      $('#edit-depot-form .msg__error').hide();
    }
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

                  console.log(data);

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

  $('.close_overlay').click(function(){
    parent.$.fancybox.close();
    return false;
  });


  //DEPOT
  $('#edit-depot-form form button').click(function() {
    var form = $(this).parents('form');
    $('#edit-depot-form form').find('input[name="name"]').val(form.data('default-name'));
    $('#edit-depot-form form').find('input[name="street"]').val(form.data('default-street'));
    $('#edit-depot-form form').find('input[name="street_number"]').val(form.data('default-street-number'));
    $('#edit-depot-form form').find('input[name="street_pobox"]').val(form.data('default-street-pobox'));
    $('#edit-depot-form form').find('input[name="zip"]').val(form.data('default-zip'));
    $('#edit-depot-form form').find('input[name="city"]').val(form.data('default-city'));
  });

  $('#edit-depot-form form').bind('submit', function() {

    /* /depot/:dossier/:voucher/:token */
    $('#edit-depot-form').find('.msg__error').hide();

    var cid = $(this).data('cid');
    var did = $(this).data('did');
    var vid = $(this).data('vid');

    var formObj = {};
    var inputs = $(this).serializeArray();
    $.each(inputs, function (i, input) {
      formObj[input.name] = input.value;
    });

    $.ajax({
      type		: "POST",
      cache	: false,
      url		: "/fast_dossier/ajax/updatedepot/" + did + '/' + vid,
      data		: {'depot' : formObj},
      success: function(data) {
        if(data.id) {
          var po = '';
          if(data.street_pobox){
            po = '/'+ data.street_pobox
          }
          var html = data.name + ', ' + data.street + ' ' + data.street_number + po + ', ' + data.zip + ' ' + data.city;
          $(cid).html(html);
          parent.$.fancybox.close();
        } else {
          $('#edit-depot-form').find('.msg__error').show();
          $.fancybox.resize();
        }
      }
    });

    return false;
  });

  //INVOICE
  $('#edit-invoice-data-form form #btninvoicesave, #edit-invoice-data-form form #btninvoicesameascauser').on('click', function() {

    $('#edit-invoice-data-form').find('.msg__error').hide();
    var cid = $(this).parents('form').data('cid');
    var did = $(this).parents('form').data('did');
    var vid = $(this).parents('form').data('vid');

    var formObj = {};
    var inputs = $(this).parents('form').serializeArray();
    $.each(inputs, function (i, input) {
      formObj[input.name] = input.value;
    });

    updatecustomer(did, vid, cid, formObj);

    if(this.id === 'btninvoicesameascauser'){
        updatecauser(did, vid, '#edit-nuisance-data', '#edit-nuisance-short-data', formObj);
    }

    return false;
  });

  //NUISANCE
  $('#edit-nuisance-data-form form #btnnuisancesave, #edit-nuisance-data-form form #btnnuisancesameascauser').bind('click', function() {

    $('#edit-nuisance-data-form').find('.msg__error').hide();

    var cid = $(this).parents('form').data('cid');
    var shortcid = $(this).parents('form').data('shortcid');
    var did = $(this).parents('form').data('did');
    var vid = $(this).parents('form').data('vid');

    var formObj = {};
    var inputs = $(this).parents('form').serializeArray();
    $.each(inputs, function (i, input) {
      formObj[input.name] = input.value;
    });

    updatecauser(did, vid, cid, shortcid, formObj);
    if(this.id === 'btnnuisancesameascauser'){
        updatecustomer(did, vid, '#edit-invoice-data', formObj);
    }

    return false;
  });

  function updatecustomer(did, vid, cid, formObj){
      $.ajax({
          type		: "POST",
          cache	: false,
          url		: "/fast_dossier/ajax/updatecustomer/" + did + '/' + vid,
          data		: {'customer' : formObj},
          success: function(data) {
              if(data.id) {
                  var html = composeAddressHtml(data);
                  $(cid).html(html);
                  parent.$.fancybox.close();
              } else {
                  //could not save data for whatever reason
                  $('#edit-invoice-data-form').find('.msg__error').show();
                  $.fancybox.resize();
              }
          }
      });
  }

  function updatecauser(did, vid, cid, shortcid, formObj){
      $.ajax({
          type		: "POST",
          cache	: false,
          url		: "/fast_dossier/ajax/updatecauser/" + did + '/' + vid,
          data		: {'causer' : formObj},
          success: function(data) {
              console.log(data);
              if(data.id){
                  var html = composeAddressHtml(data);
                  var shorthtml = composeShortAddressHtml(data);

                  $(cid).html(html);
                  $(shortcid).html(shorthtml);
                  parent.$.fancybox.close();
              }else{
                  //could not save data for whatever reason
                  $('#edit-nuisance-data-form').find('.msg__error').show();
                  $.fancybox.resize();
              }
          }
      });
  }




        //NOTA
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

  //NOTA

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


  //WORK

  $('#add-work-form form').bind('submit', function() {
      var formObj = {};
      var inputs = $(this).find('input[type="checkbox"]');

      $.each(inputs, function (i, input) {
        if($(this).is(':checked')){
          console.log($(this));
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
   $(location).attr('href',url);
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
        console.log(data);
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

    $(document).ready(function() {
        var url = document.URL.split('/');
        var dossier_id = url[url.length-2];
        var voucher_id = url[url.length-1];
        Dossier.dossier_id = dossier_id;
        Dossier.voucher_id = voucher_id;

        getCauser().success(function(data){
            console.log(data);
        });

    });

    function prepareAjaxUrl(url){
        return url + '/' + Dossier.dossier_id + '/' + Dossier.voucher_id;
    }

    function getCauser(){
        var url = prepareAjaxUrl('/fast_dossier/ajax/causer');
        return $.ajax({
            type		: "POST",
            cache	: false,
            url		: url,
            data		: {}
        });
    }



});
