<?php
  $this->load->helper('listbox');
  $this->load->helper('date');

  $_dossier = $dossier->dossier;
?>

<div class="layout-has-sidebar">
  <div class="layout-sidebar">
    <div class="box table_list table_list_small">
      <?php

      $last = $this->uri->total_segments();
      $urlid = $this->uri->segment($last);

      $this->load->helper('date');

      $this->table->set_heading('Bon', 'Datum', 'Tijd');

      //d.id, d.id as 'dossier_id', t.id as 'voucher_id', d.call_number, d.call_date, t.voucher_number, ad.name 'direction_name',
      //adi.name 'indicator_name', c.code as `towing_service`, ip.name as `incident_type`

      if($vouchers && sizeof($vouchers) > 0) {
        foreach($vouchers as $voucher) {

          if($voucher->dossier_number === $urlid){
            $class = 'active';
          }else{
            $class = 'inactive';
          }

          $this->table->add_row(
            array('class' => $class, 'data' => sprintf('<a href="/fast_dispatch/dossier/%s">%s</a>', $voucher->dossier_number, $voucher->voucher_number)),
            array('class' => $class, 'data' => mdate('%d/%m/%Y',strtotime($voucher->call_date))),
            array('class' => $class, 'data' => mdate('%H:%i',strtotime($voucher->call_date)))
          );
        }
      }

      echo $this->table->generate();
      ?>
    </div>
  </div>

  <?php print form_open('fast_dispatch/dossier/save/' . $_dossier->dossier_number) ?>

  <div class="layout-content">

    <div class="box box--unpadded idbar">

      <div class="idbar__item idbar__id">
          <?php print $_dossier->towing_vouchers[0]->voucher_number ?>
      </div>

      <div class="idbar__item">
          <div class="idbar__label">
            <div class="icon--date"></div>
          </div>
          <div class="idbar__value">
            <?php print mdate('%d/%m/%Y',strtotime($_dossier->call_date)); ?>
          </div>
      </div>

      <div class="idbar__item">
        <div class="idbar__label">
          <div class="icon--clock"></div>
        </div>
        <div class="idbar__value">
          <?php print mdate('%H:%i',strtotime($_dossier->call_date)); ?>
        </div>
      </div>

    </div>

<?php
//TODO: @Gert, voorzien van een correcte styling voor de form errors!

$errors = validation_errors();

if($errors) {
  printf('<div style="background: red; color: white; font-size: 1.2em; padding-top:10px; padding-bottom: 10px; padding-left: 4px;">%s</div>', $errors);
}

?>


    <div class="box layout_2col_container">
      <div class="layout_2col_item">
        <div class="form-item-horizontal">
            <label>Richting:</label>
            <?php print listbox('direction', $directions, $_dossier->allotment_direction_id); ?>
        </div>

        <div class="form-item-horizontal">
            <label>KM Paal:</label>
            <?php print listbox('indicator', $indicators, $_dossier->allotment_direction_indicator_id); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Rijstrook:</label>
            <?php print listbox('traffic_lane_id', $traffic_lanes, $_dossier->traffic_lane_id); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Type incident:</label>
            <?php print listbox('incident_type', $incident_types, $_dossier->incident_type_id); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Oproepnr.:</label>
            <?php print form_input('call_number', $_dossier->call_number); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Assistance:</label>
            <?php print listbox('insurance_id', $insurances, $_dossier->towing_vouchers[0]->insurance_id); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Dossiernr.:</label>
            <?php print form_input('insurance_dossiernr', $_dossier->towing_vouchers[0]->insurance_dossiernr); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Type wagen:</label>
            <?php print form_input('vehicule_type', $_dossier->towing_vouchers[0]->vehicule_type); ?>
        </div>

        <div class="form-item-horizontal form-item-licenseplate">
            <label>Nummerplaat:</label>
            <div class="licenseplate-container">
              <?php print form_input('vehicule_licenceplate', $_dossier->towing_vouchers[0]->vehicule_licenceplate); ?>

              <?php print listbox('licence_plate_country',
                            $licence_plate_countries,
                            $_dossier->towing_vouchers[0]->vehicule_country,
                            array(
                                'value_key' => 'name',
                                'label_key' => 'name',
                            )); ?>
            </div>
        </div>


        <div class="form-item-horizontal">
            <label>Afmelding CIC:</label>
            <?php print form_input('cic', $_dossier->towing_vouchers[0]->cic); ?>
        </div>
      </div>

  <!-- second column -->

      <div class="layout_2col_item">

        <div class="form-item-horizontal">
            <label>Perceel</label>
            <?php print form_input('allotment_id', $_dossier->allotment_id); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Perceel:</label>
            <div class="form-value"><?php print $_dossier->allotment_name; ?></div>
        </div>

        <div class="form-item-horizontal">
            <label>Takeldienst:</label>
            <?php print listbox('company_id', array(), $_dossier->company_id); ?>
        </div>



        <div class="form-item-horizontal">
            <label>Extra info:</label>
            <?php print form_textarea('additional_info', $_dossier->towing_vouchers[0]->additional_info); ?>
        </div>

      </div>

    </div>

    <div class="form-item">
      <input type="submit" value="Bewaren" name="btnSave" />
    </div>
    <?php print form_close(); ?>

    <pre>

    <? var_dump($_dossier); ?>
    </pre>

  </div>
</div>

<script>
function fetchAllotmentAndTowingServices()
{
  var direction_id = $('#list_direction option:selected').val();
  var indicator_id = $('#list_indicator option:selected').val();

  $.getJSON("/fast_dispatch/ajax/allotments/"+direction_id+"/"+indicator_id, function(data, status, xhr) {
      if(data && data.length == 1) {
        var allotment = data.shift();

        console.log("allotment " + allotment.id);
        $("input[name*='allotment_id']").val(allotment.id);
        $("input[name*='allotment_name']").val(allotment.name);


        $('#list_company_id').empty();

        $.each(allotment.towing_services, function(index, item) {
            $('#list_company_id').append($('<option/>', {
                    value: item.id,
                    text : item.name
                }));
        });

        $('#list_company_id').trigger('chosen:updated');
      }
  });
}

$('#list_direction').change(function(){
  var id = $('#list_direction option:selected').val();

  $.getJSON("/fast_dispatch/ajax/indicators/"+id, function(data, status, xhr) {
      $('#list_indicator').empty();

      $.each(data, function(index, item) {
          $('#list_indicator').append($('<option/>', {
                  value: item.id,
                  text : item.name
              }));
      });

      $('#list_indicator').trigger('chosen:updated');

  });

  fetchAllotmentAndTowingServices();
});

$('#list_indicator').change(function(){
  fetchAllotmentAndTowingServices();
});


</script>
