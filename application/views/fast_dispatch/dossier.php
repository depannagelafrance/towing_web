<?php
  $this->load->helper('listbox');
  $this->load->helper('date');

  $_dossier = $dossier->dossier;
?>

<div class="layout-has-sidebar">
  <div class="layout-sidebar">
    <div class="box">
      <?php

      $this->load->helper('date');

      $this->table->set_heading('Id', 'Datum', 'Tijd');

      //d.id, d.id as 'dossier_id', t.id as 'voucher_id', d.call_number, d.call_date, t.voucher_number, ad.name 'direction_name',
      //adi.name 'indicator_name', c.code as `towing_service`, ip.name as `incident_type`

      if($vouchers && sizeof($vouchers) > 0) {
        foreach($vouchers as $voucher) {
          $this->table->add_row(
            $voucher->voucher_number,
            mdate('%d/%m/%Y',strtotime($voucher->call_date)),
            mdate('%H:%i',strtotime($voucher->call_date))
          );
        }
      }

      echo $this->table->generate();
      ?>
    </div>
  </div>

  <?php print form_open('fast_dispatch/dossier/save/' . $_dossier->dossier_number) ?>
  <?php print validation_errors(); ?>

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

    <div class="box layout_2col_container">
      <div class="layout_2col_item">
        <div class="form-item-horizontal">
            <label>Richting</label>
            <?php print listbox('direction', $directions, $_dossier->allotment_direction_id); ?>
        </div>

        <div class="form-item-horizontal">
            <label>KM Paal</label>
            <?php print listbox('indicator', $indicators, $_dossier->allotment_direction_indicator_id); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Rijstrook</label>
            <?php print listbox('traffic_lane', $traffic_lanes, $_dossier->traffic_lane_id); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Type incident</label>
            <?php print listbox('incident_type', $incident_types, $_dossier->incident_type_id); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Oproepnr.</label>
            <?php print form_input('call_number', $_dossier->call_number); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Assistance</label>
            <?php print listbox('insurances', $insurances, $_dossier->towing_vouchers[0]->insurance_id); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Dossiernr.</label>
            <?php print form_input('insurance_dossiernr', $_dossier->towing_vouchers[0]->insurance_dossiernr); ?>
        </div>

        <div class="form-item-horizontal">
            <label>Type wagen</label>
            <?php print form_input('vehicule_type', $_dossier->towing_vouchers[0]->vehicule_type); ?>
        </div>

        <div class="form-item-horizontal form-item-licenseplate">
            <label>Nummerplaat</label>
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
            <label>Afmelding CIC</label>
            <?php print form_input('cic', $_dossier->towing_vouchers[0]->cic); ?>
        </div>
      </div>

      <div class="layout_2col_item">

        <div class="form-item-horizontal">
            <label>Extra info</label>
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
$('#list_direction').change(function(){
  var id = $('#list_direction option:selected').val();

  $.getJSON("/fast_dispatch/ajax/indicators/"+id,
    function(data, status, xhr) {
      console.log(data);
      console.log(status);
      console.log(xhr);
      
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
</script>
