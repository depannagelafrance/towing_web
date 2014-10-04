<?php
$this->load->helper('listbox');
$this->load->helper('date');

$_dossier = $dossier->dossier;
?>

<div>
  <?php

  $this->load->helper('date');

  $this->table->set_heading('Takelbon', 'Oproepnummer', 'Oproep', 'Richting', 'KM-Paal', 'Takeldienst', 'Type');

  //d.id, d.id as 'dossier_id', t.id as 'voucher_id', d.call_number, d.call_date, t.voucher_number, ad.name 'direction_name',
  //adi.name 'indicator_name', c.code as `towing_service`, ip.name as `incident_type`

  if($vouchers && sizeof($vouchers) > 0) {
    foreach($vouchers as $voucher) {
      $this->table->add_row(
        $voucher->voucher_number,
        $voucher->call_number,
        mdate('%d/%m/%Y %H:%i',strtotime($voucher->call_date)),
        $voucher->direction_name,
        $voucher->indicator_name,
        $voucher->towing_service,
        $voucher->incident_type
      );
    }
  }

  echo $this->table->generate();
  ?>
</div>

<?= validation_errors(); ?>
<?= form_open('fast_dispatch/dossier/save/' . $_dossier->dossier_number) ?>
<div>
    <label>Datum:</label>
    <?= mdate('%d/%m/%Y %H:%i',strtotime($_dossier->call_date)); ?>
</div>
<div>
    <label>Takelbon:</label>
    <?= $_dossier->towing_vouchers[0]->voucher_number ?>
</div>
<div>
    <label>Richting</label>
    <?= listbox('direction', $directions, $_dossier->allotment_direction_id); ?>
</div>

<div>
    <label>KM Paal</label>
    <?= listbox('indicator', $indicators, $_dossier->allotment_direction_indicator_id); ?>
</div>

<div>
    <label>Rijstrook</label>
    <?= listbox('traffic_lane', $traffic_lanes, $_dossier->traffic_lane_id); ?>
</div>

<div>
    <label>Type incident</label>
    <?= listbox('incident_type', $incident_types, $_dossier->incident_type_id); ?>
</div>

<div>
    <label>Oproepnr.</label>
    <?= form_input('call_number', $_dossier->call_number); ?>
</div>

<div>
    <label>Assistance</label>
    <?= listbox('insurances', $insurances, $_dossier->towing_vouchers[0]->insurance_id); ?>
</div>

<div>
    <label>Dossiernr.</label>
    <?= form_input('insurance_dossiernr', $_dossier->towing_vouchers[0]->insurance_dossiernr); ?>
</div>

<div>
    <label>Type wagen</label>
    <?= form_input('vehicule_type', $_dossier->towing_vouchers[0]->vehicule_type); ?>
</div>

<div>
    <label>Nummerplaat</label>
    <?= form_input('vehicule_licenceplate', $_dossier->towing_vouchers[0]->vehicule_licenceplate); ?>
</div>

<div>
    <label>Land</label>
    <?= listbox('licence_plate_country',
                  $licence_plate_countries,
                  $_dossier->towing_vouchers[0]->vehicule_country,
                  array(
                      'value_key' => 'name',
                      'label_key' => 'name',
                  )); ?>
</div>

<div class="form-item">
    <label>Afmelding CIC</label>
    <?= form_input('cic', $_dossier->towing_vouchers[0]->cic); ?>
</div>

<div>
    <label>Extra info</label>
    <?= form_textarea('additional_info', $_dossier->towing_vouchers[0]->additional_info); ?>
</div>

<div class="form-item">
  <input type="submit" value="Bewaren" name="btnSave" />
</div>
<?= form_close(); ?>

<pre>

<? var_dump($_dossier); ?>
</pre>


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
    }
  );
});
</script>
