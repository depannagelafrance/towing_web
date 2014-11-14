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
    'titleShow'		: false
  });

  $('.close_overlay').click(function(){
    parent.$.fancybox.close();
    return false;
  });


  //DEPOT
  $('#edit-depot-form form button').click(function() {
    $('#edit-depot-form form').find('input[name="name"]').val('<?=addslashes($company_depot->name)?>');
    $('#edit-depot-form form').find('input[name="street"]').val('<?=addslashes($company_depot->street)?>');
    $('#edit-depot-form form').find('input[name="street_number"]').val('<?=addslashes($company_depot->street_number)?>');
    $('#edit-depot-form form').find('input[name="street_pobox"]').val('<?=addslashes($company_depot->street_pobox)?>');
    $('#edit-depot-form form').find('input[name="zip"]').val('<?=addslashes($company_depot->zip)?>');
    $('#edit-depot-form form').find('input[name="city"]').val('<?=addslashes($company_depot->city)?>');
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
  $('#edit-invoice-data-form form').bind('submit', function() {

    $('#edit-invoice-data-form').find('.msg__error').hide();
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
    return false;
  });

  //NUISANCE
  $('#edit-nuisance-data-form form').bind('submit', function() {

    $('#edit-nuisance-data-form').find('.msg__error').hide();

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
      url		: "/fast_dossier/ajax/updatecauser/" + did + '/' + vid,
      data		: {'causer' : formObj},
      success: function(data) {
        if(data.id){
          var html = composeAddressHtml(data);

          $(cid).html(html);
          parent.$.fancybox.close();
        }else{
          //could not save data for whatever reason
          $('#edit-nuisance-data-form').find('.msg__error').show();
          $.fancybox.resize();
        }
      }
    });

    return false;
  });

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

          $('.work-container__fields').append('<div class="work-container__field" data-id="'+ id + '" data-incl="'+ incl +'" data-excl="'+ excl +'"><div class="form-item-vertical work-container__task"><input type="text" name="name[]" value="'+ label +'" readonly="readonly" style="background: #F0F0F0"><input type="hidden" name="activity_id[]" value="'+ id +'"></div><div class="form-item-vertical work-container__number"><input type="text" name="amount[]" value="1"></div><div class="form-item-vertical work-container__unitprice"><input type="text" name="fee_incl_vat[]" value="'+ incl +'" readonly="readonly" style="background: #F0F0F0"></div><div class="form-item-vertical work-container__excl"><input type="text" name="cal_fee_excl_vat[]" value="'+ excl +'" readonly="readonly" style="background: #F0F0F0"></div><div class="form-item-vertical work-container__incl"><input type="text" name="cal_fee_incl_vat[]" value="'+ incl +'" readonly="readonly" style="background: #F0F0F0"></div><div class="form-item-vertical work-container__remove"><div class="work-container__remove__btn"><div class="btn--icon--small"><a class="icon--remove--small" href="#">Remove</a></div></div></div></div>');
        }
      });

      update_total_price();
      recalculate_price();
      parent.$.fancybox.close();
      return false;
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
    var cash = $('#payment_cash input').val() || 0;
    var bank = $('#payment_bank input').val() || 0;
    var debit = $('#payment_debit input').val() || 0;
    var credit = $('#payment_credit input').val() || 0;
    var total = $('#payment_total input').val() || 0;

    var topay = total - insurance - cash - bank - debit - credit;
    var paid = (total - topay).toFixed(2);
    var unpaid = topay.toFixed(2);

    $('#payment_paid input').val(paid);
    $('#payment_unpaid input').val(unpaid);

  }
});
