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

      $this->table->set_heading('Dossier', 'Datum', 'Tijd');

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
                array('class' => $class, 'data' => sprintf('<a href="/fast_dossier/dossier/%s">%s</a>', $voucher->dossier_number, $voucher->dossier_number)), // $voucher->voucher_number),
                array('class' => $class, 'data' =>mdate('%d %M',strtotime($voucher->call_date))),
                array('class' => $class, 'data' =>mdate('%H:%i',strtotime($voucher->call_date)))
          );
        }
      }

      echo $this->table->generate();

      ?>
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

    <div class="box box--unpadded detailbar">
      <div class="detailbar__row">
        <div class="form-item-horizontal less_padded">
          <label>Oproepnr.&nbsp;:</label>
          <div class="value"><?php print $_dossier->call_number; ?></div>
        </div>

        <div class="form-item-horizontal less_padded">
          <label>Perceel&nbsp;:</label>
          <div class="value"><?php print $_dossier->allotment_name ?></div>
        </div>

        <div class="form-item-horizontal less_padded">
          <label>Toegewezen aan&nbsp;:</label>
          <div class="value"><?php print $_dossier->company_name ?></div>
        </div>
      </div>

      <div class="detailbar__row">

         <div class="form-item-horizontal less_padded">
           <label>Richting&nbsp;:</label>
           <div class="value"><?php print $_dossier->direction_name; ?></div>
         </div>

         <div class="form-item-horizontal less_padded">
           <label>KM Paal&nbsp;:</label>
           <div class="value"><?php print $_dossier->indicator_name; ?></div>
         </div>

         <div class="form-item-horizontal less_padded">
           <label>Rijstrook&nbsp;:</label>
           <div class="value"><?php print $_dossier->traffic_lane_name; ?></div>
         </div>
      </div>

      <div class="detailbar__row">

        <div class="form-item-horizontal less_padded">
          <label>Type incident&nbsp;:</label>
          <div class="value"><?php print $_dossier->incident_type_name; ?></div>
        </div>

      </div>

    </div>

  <?= validation_errors(); ?>
  <?= form_open('fast_dossier/dossier/save/' . $_dossier->dossier_number) ?>

  <div class="dossierbar">

    <div class="dossierbar__vouchers">
      <?php
        $_voucher = null;

        foreach($_dossier->towing_vouchers as $_v) :
          $_is_selected = false;

          if($_is_selected = ($_v->voucher_number == $voucher_number)) {
            $_voucher = $_v;
          }
      ?>
          <div class="dossierbar__id active">
            <?php

            if($_is_selected || sizeof($_dossier->towing_vouchers) == 1) {
              printf('%s', $_v->voucher_number);
            } else {
              printf('<a href="/fast_dossier/dossier/%s/%s">%s</a>', $_dossier->dossier_number, $_v->voucher_number, $_v->voucher_number);
            }
            ?>
          </div>
      <?php
        endforeach;
      ?>
    </div>

<?php
if(!$_voucher)
  $_voucher = $_dossier->towing_vouchers[0];
?>

    <div class="dossierbar__mainactions">
      <div class="dossierbar__mainaction__item">
        <div class="btn--icon">
          <a class="icon--edit" href="#">Edit</a>
        </div>
      </div>
      <div class="dossierbar__mainaction__item">
        <div class="btn--icon--highlighted bright">
          <a class="icon--add" href="/fast_dossier/dossier/voucher/<?=$_dossier->id?>">Add</a>
        </div>
      </div>
    </div>

    <div class="dossierbar__actions">
      <div class="dossierbar__action__item">
        <div class="btn--icon">
          <a class="icon--nota" href="">Nota</a>
        </div>
      </div>
      <div class="dossierbar__action__item">
        <div class="btn--icon">
          <a class="icon--attachement" href="">Bijlage</a>
        </div>
      </div>
      <div class="dossierbar__action__item">
        <div class="btn--icon">
          <a class="icon--email" href="">Email</a>
        </div>
      </div>
      <div class="dossierbar__action__item">
        <div class="btn--icon">
          <a class="icon--print--preview" href="/fast_dossier/report/voucher/<?=$_dossier->id?>/<?=$_voucher->id?>">Print Preview</a>
        </div>
      </div>
      <div class="dossierbar__action__item">
        <div class="btn--icon">
          <a class="icon--print" href="">Print</a>
        </div>
      </div>
    </div>

  </div>

  <div class="box dsform">

    <!--SIGNA-->
    <div class="signa-container">
      <div class="signa-container__left">
        <div class="form-item-horizontal signa-container__signa">
          <label>Signa:</label>
          <?php print form_input('signa_by', $_voucher->signa_by); ?>
        </div>

        <div class="form-item-horizontal signa-container__licenceplate">
          <label>Nummerplaat:</label>
          <?php print form_input('signa_by_vehicle', $_voucher->signa_by_vehicle); ?>
        </div>
      </div>

      <div class="signa-container__right">
        <div class="form-item-horizontal signa-container__arrival">
          <label>Aankomst:</label>
          <?php print form_input('signa_arrival', $_voucher->signa_arrival); ?>
        </div>
      </div>
    </div>
    <!-- END SIGNA -->

    <!--TOWED BY-->
    <div class="towedby-container">
      <div class="towedby-container__left">
        <div class="form-item-horizontal towedby-container__towedby">
          <label>Takelaar:</label>
          <?php print form_input('towed_by', $_voucher->towed_by); ?>
        </div>

        <div class="form-item-horizontal towedby-container__licenceplate">
          <label>Nummerplaat:</label>
          <?php print form_input('towed_by_vehicle', $_voucher->towed_by_vehicle); ?>
        </div>
      </div>

      <div class="towedby-container__right">
        <div class="form-item-horizontal towedby-container__call">
          <label>Oproep:</label>
          <?php print form_input('towing_called', $_voucher->towing_called); ?>
        </div>

        <div class="form-item-horizontal towedby-container__arival">
          <label>Aankomst:</label>
          <?php print form_input('towing_arrival', $_voucher->towing_arrival); ?>
        </div>

        <div class="form-item-horizontal towedby-container__start">
          <label>Start:</label>
          <?php print form_input('towing_start', $_voucher->towing_start); ?>
        </div>

        <div class="form-item-horizontal towedby-container__completed">
          <label>Stop:</label>
          <?php print form_input('towing_completed', $_voucher->towing_completed); ?>
        </div>

      </div>
    </div>
    <!-- END TOWEDBY -->

    <!-- VEHICULE -->
    <div class="vehicule-container">
      <div class="vehicule-container__left">
        <div class="form-item-horizontal vehicule-container__vehicule">
          <label>Type wagen:</label>
          <?php print form_input('vehicule_type', $_voucher->vehicule_type); ?>
        </div>

        <div class="form-item-horizontal vehicule-container__license">
          <label>Nummerplaat:</label>
          <?php print form_input('vehicule_licenceplate', $_voucher->vehicule_licenceplate); ?>
        </div>
      </div>

      <div class="vehicule-container__right">
        <div class="form-item-horizontal vehicule-container__country">
          <label>Land:</label>
          <?php print listbox('licence_plate_country',
            $licence_plate_countries,
            $_voucher->vehicule_country,
            array(
              'value_key' => 'name',
              'label_key' => 'name',
            )); ?>
        </div>
      </div>
    </div>
    <!-- END CAR -->

    <!-- DEPOT -->
    <!--
    <div class="depot-full-container">
      <div class="depot-full-container__left">
        <div class="form-item-horizontal depot-full-container__depot">
          <label>Depot:</label>
        </div>

        <div class="form-item-horizontal depot-full-container__street">
          <label>Straat:</label>
        </div>
      </div>
      <div class="depot-full-container__right">

        <div class="form-item-horizontal depot-full-container__streetnr">
          <label>Nr:</label>
        </div>

        <div class="form-item-horizontal depot-full-container__streetbox">
          <label>Box:</label>
        </div>

        <div class="form-item-horizontal depot-full-container__postal">
          <label>Zip:</label>
        </div>

        <div class="form-item-horizontal depot-full-container__city">
          <label>City:</label>
        </div>
      </div>
    </div>
    -->

    <div class="dsform__clearfix">
      <div class="dsform__left">

        <!--FACTURATION-->
        <div class="form-item-vertical facturation-container">
          <label>Facturatiegegevens:</label>
          <div class="facturation-container__info">
            <div>Lorem ipsum 12</div>
            <div>2920 Lorem</div>
            <div>T: 00000000000</div>
            <div>E: info@lorem.com</div>
          </div>
          <a href="#" id="edit-facturation">Bewerken</a>
        </div>
        <!--END FACTURATION-->

        <!--NUISANCE-->
        <div class="form-item-vertical nuisance-container">
          <label>Hinderverwekker:</label>
          <div class="nuisance-container__info">
            <div>Lorem ipsum 12</div>
            <div>2920 Lorem</div>
            <div>T: 00000000000</div>
            <div>E: info@lorem.com</div>
          </div>
          <a href="#">Bewerken</a>
        </div>
        <!--END NUISANCE-->

      </div>
      <div class="dsform__right">

        <!--DEPOT-->
        <div class="form-item-horizontal depot-container">
          <label>Depot:</label>
          <?php print $_voucher->depot->display_name; ?>
          <a href="#">Bewerken</a>
        </div>
        <!-- END DEPOT-->

        <!--ASSI-->
        <div class="form-item-horizontal  assistance-container">
          <label>Assistance:</label>
          <?php print listbox('insurances', $insurances, $_voucher->insurance_id); ?>
        </div>
        <!--END ASSI-->

        <!--DOSS-->
        <div class="form-item-horizontal dossiernr-container">
          <label>Dossiernr.:</label>
          <?= form_input('insurance_dossiernr', $_voucher->insurance_dossiernr); ?>
        </div>
        <!--END DOSS-->

        <!--WARENTY-->
        <div class="form-item-horizontal warrenty-container">
          <label>Garantie:</label>
          <?= form_input('insurance_warranty_held_by', $_voucher->insurance_dossiernr); ?>
        </div>
        <!--END WARENTY-->

      </div>
    </div>


    <!--WORK-->
    <div class="form-item-vertical work-container">
      <div class="work-container__fields">
        <div class="form-item-vertical work-container__task">
          <label>Werkzaamheden:</label>
          <?php
            foreach($_voucher->towing_activities as $_activity) {
              print form_input('name', $_activity->name);
            }
          ?>
        </div>

        <div class="form-item-vertical work-container__number">
          <label>Aantal:</label>
          <?php
          foreach($_voucher->towing_activities as $_activity) {
            print form_input('amount', $_activity->amount);
          }
          ?>
        </div>

        <div class="form-item-vertical work-container__unitprice">
          <label>EHP:</label>
          <?php
          foreach($_voucher->towing_activities as $_activity) {
            print form_input('fee_incl_vat', $_activity->fee_incl_vat);
          }
          ?>
        </div>

        <div class="form-item-vertical work-container__excl">
          <label>Excl:</label>
          <?php
          foreach($_voucher->towing_activities as $_activity) {
            print form_input('fee_incl_vat', $_activity->cal_fee_excl_vat);
          }
          ?>
        </div>

        <div class="form-item-vertical work-container__incl">
          <label>Incl:</label>
          <?php
          foreach($_voucher->towing_activities as $_activity) {
            print form_input('fee_incl_vat', $_activity->cal_fee_incl_vat);
          }
          ?>
        </div>
      </div>
      <div class="work-container__actions">
        <div class="work-container__add">
          <div class="btn--icon--small">
            <a class="icon--add--small" href="#">Add</a>
          </div>
        </div>
      </div>
    </div>
    <!-- END WORK-->

    <!--AUTOGRAPHS-->
    <div class="form-item-vertical autograph-container">
      <div class="autograph-container__police">
        <label>Bevestiging politie:</label>

        <div class="form-item-horizontal  autograph-container__police__trafficpost">
          <label class="notbold">Verkeerspost:</label>
          <?php print listbox('traffic_post_id', $traffic_posts, $_dossier->police_traffic_post_id); ?>
        </div>

        <div class="form-item-horizontal  autograph-container__police__timestamp">
          <label class="notbold">Tijdstip:</label>
          <?php print form_input('police-timestamp'); ?>
        </div>

        <div class="autograph-container__police__autograph">

        </div>

      </div>
      <div class="autograph-container__nuisance">
        <label>Bevestiging hinderverwerker:</label>

        <div class="autograph-container__nuisance__autograph">

        </div>

      </div>
      <div class="autograph-container__collecting">
        <label>Bevestiging afhaler:</label>

        <div class="form-item-horizontal  autograph-container__collecting__collector">
          <label class="notbold">Afhaler:</label>
          <?php print listbox('collector_id', $collectors, $_voucher->collector_id); ?>
        </div>

        <div class="form-item-horizontal  autograph-container__collecting__date">
          <label class="notbold">Datum:</label>
          <?php print form_input('police-timestamp'); ?>
        </div>

        <div class="autograph-container__collecting__autograph">

        </div>

      </div>
    </div>



    <!-- END AUTOGRAPHS-->

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

$(document).ready(function() {
  $('#edit-facturation').click(function(){
    $.fancybox(
      '<div>Lorem isis id et neque</div>'
    );
  });
});

</script>
