<?php
$this->load->helper('listbox');
$this->load->helper('date');

$_dossier = $dossier->dossier;
?>

<div class="layout-has-sidebar">
  <div class="layout-sidebar">
    <div class="box">

    </div>
  </div>

  <div class="layout-content">
    <div class="box box--unpadded idbar">

      <div class="idbar__item idbar__id">
        <?php print $_dossier->dossier_number; ?>
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

    <div class="box detailbar">
      <div class="detailbar__row">
        <div class="form-item-horizontal">
          <label>Oproepnr.</label>
          <?php print $_dossier->call_number; ?>
        </div>

        <div class="form-item-horizontal">
          <label>Perceel</label>
          <?= $_dossier->allotment_name ?>
        </div>

        <div class="form-item-horizontal">
          <label>Toegewezen aan</label>
          <?= $_dossier->company_name ?>
        </div>
      </div>

      <div class="detailbar__row">

         <div class="form-item-horizontal">
           <label>Richting</label>
           <?= $_dossier->direction_name ?>
         </div>

         <div class="form-item-horizontal">
           <label>KM Paal</label>
           <?=  $_dossier->indicator_name ?>
         </div>

         <div class="form-item-horizontal">
           <label>Rijstrook</label>
           <?= $_dossier->traffic_lane_name ?>
         </div>
      </div>

      <div class="detailbar__row">

        <div class="form-item-horizontal">
          <label>Type incident</label>
          <?= $_dossier->incident_type_name ?>
        </div>

      </div>

    </div>

  <?= validation_errors(); ?>
  <?= form_open('fast_dossier/dossier/save/' . $_dossier->dossier_number) ?>

  <div style="background-color: #fff9c4;">
    <?php
    foreach($_dossier->towing_vouchers as $_voucher) {
      ?>


      <div>
        <label>Takelbon:</label>
        <?= $_voucher->voucher_number ?>
      </div>
    <?
    }
    ?>
  </div>

  <div class="box">
    <?php
    $_voucher = $_dossier->towing_vouchers[0];
    ?>

    <div style="background-color: #fff59d;">
      <div>
        <label>Signa</label>
        <?= form_input('signa_by', $_voucher->signa_by); ?>
      </div>

      <div>
        <label>Nummerplaat</label>
        <?= form_input('signa_by_vehicle', $_voucher->signa_by_vehicle); ?>
      </div>

      <div>
        <label>Aankomst</label>
        <?= form_input('signa_arrival', $_voucher->signa_arrival); ?>
      </div>
    </div>

    <div style="background-color: #fff176;">
      <div>
        <label>Takelaar</label>
        <?= form_input('towed_by', $_voucher->towed_by); ?>
      </div>

      <div>
        <label>Nummerplaat</label>
        <?= form_input('towed_by_vehicle', $_voucher->towed_by_vehicle); ?>
      </div>

      <div>
        <label>Oproep</label>
        <?= form_input('towing_called', $_voucher->towing_called); ?>
      </div>

      <div>
        <label>Aankomst</label>
        <?= form_input('towing_arrival', $_voucher->towing_arrival); ?>
      </div>

      <div>
        <label>Start takel</label>
        <?= form_input('towing_start', $_voucher->towing_start); ?>
      </div>

      <div>
        <label>Stop takel</label>
        <?= form_input('towing_completed', $_voucher->towing_completed); ?>
      </div>
    </div>

    <div style="background-color: #ffee58;">
      <div>
        <label>Type wagen</label>
        <?= form_input('vehicule_type', $_voucher->vehicule_type); ?>
      </div>

      <div>
        <label>Nummerplaat</label>
        <?= form_input('vehicule_licenceplate', $_voucher->vehicule_licenceplate); ?>
      </div>

      <div>
        <label>Land</label>
        <?= listbox('licence_plate_country',
          $licence_plate_countries,
          $_voucher->vehicule_country,
          array(
            'value_key' => 'name',
            'label_key' => 'name',
          )); ?>
      </div>

      <div>
        <label>Depot</label>
        <?= $_voucher->depot->display_name ?>
      </div>
    </div>

    <div style="background-color: #ffeb3b;">
      Facturatiegegevens
    </div>

    <div style="background-color: #fdd835;">
      Hinderverwekker
    </div>

    <div style="background-color: #fbc02d;">
      <div>
        <label>Assistance</label>
        <?= listbox('insurances', $insurances, $_voucher->insurance_id); ?>
      </div>

      <div>
        <label>Dossiernr.</label>
        <?= form_input('insurance_dossiernr', $_voucher->insurance_dossiernr); ?>
      </div>


      <div>
        <label>Gar.houder</label>
        <?= form_input('insurance_warranty_held_by', $_voucher->insurance_dossiernr); ?>
      </div>
    </div>

    <div style="background-color: #f9a825;">
      <?php
      $this->table->set_heading('Werkzaamheden', 'Aantal', 'EHP', 'Excl', 'Incl');


      foreach($_voucher->towing_activities as $_activity) {
        $this->table->add_row(
          form_input('name', $_activity->name),
          form_input('amount', $_activity->amount),
          form_input('fee_incl_vat', $_activity->fee_incl_vat),
          form_input('fee_incl_vat', $_activity->cal_fee_excl_vat),
          form_input('fee_incl_vat', $_activity->cal_fee_incl_vat)
        );
      }

      echo $this->table->generate();
      ?>
    </div>


    <div class="form-item">
      <input type="submit" value="Bewaren" name="btnSave" />
    </div>

  </div>
  <?= form_close(); ?>

</div>


<pre>

<? var_dump($_dossier); ?>
</pre>


<script>
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
</script>
