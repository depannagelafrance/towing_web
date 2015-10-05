<?php

function displayVoucherTimeField($value, $name) {
  if($value) {
    $render = sprintf('<div class="input_value">%s</div>', asTime($value));
    $render .= form_hidden($name, asJsonDateTime($value));

    return $render;
  } else {
    return form_input($name, asTime($value));
  }
}


$this->load->helper('listbox');
$this->load->helper('datetime');
$this->load->helper('date');

$_dossier = $dossier->dossier;
?>
<div class="layout-has-sidebar edit-view">
  <div class="layout-sidebar">
    <div class="box table_list table_list_small">

      <?php
      $this->load->helper('date');

      print showDossierList($this, $search_results, 'Zoekresultaten');
      if(sizeof($search_results) > 0) {
        ?>
          <div style="padding-top: 15px; padding-bottom: 15px;background-color: #f0f0f0">
            <input type="button" value="Wis zoekresultaten" id="btn_delete_search_results">
          </div>
        <?php
      }
      print showDossierList($this, $vouchers, 'Dossiers');

      ?>
    </div>
  </div>

  <?php
  print validation_errors();

  $_voucher = null;

  foreach($_dossier->towing_vouchers as $_v) {
    if($_v->voucher_number == $voucher_number) {
      $_voucher = $_v;
    }
  }

  if(!$_voucher)
    $_voucher = $_dossier->towing_vouchers[0];


  print form_open('fast_dossier/dossier/save/' . $_dossier->dossier_number . '/' . $_voucher->voucher_number);


  // -- dossier_id
  $data = array(
    'name'        => 'data_dossier_id',
    'id'          => 'data_dossier_id',
    'type'        => 'hidden',
    'value'       => $_dossier->id);

  print form_input($data);

  // -- voucher_id
  $data = array(
    'name'        => 'data_voucher_id',
    'type'        => 'hidden',
    'id'          => 'data_voucher_id',
    'value'       => $_voucher->id);

  print form_input($data);
  ?>

  <div class="layout-content">
    <div class="box box--unpadded idbar">

      <div class="idbar__item idbar__id bright has_icon">
        <div class="idbar__icon icon--map"></div>
        <div class="idbar__id__value"><?php print $_dossier->dossier_number; ?></div>
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
          <?php print asTime($_dossier->call_date); ?>
        </div>
      </div>


      <div class="idbar__incident">
        <?php print $_dossier->incident_type_name; ?>
      </div>
  </div>
    <div class="box detailbar">
      <div class="detailbar__row">
        <div class="form-item-horizontal less_padded">
          <label>Oproepnr.&nbsp;:</label>
          <?php print form_input('call_number', $_dossier->call_number); ?>
        </div>

        <div class="form-item-horizontal less_padded">
          <label>Perceel&nbsp;:</label>
          <div class="value"><?php print $_dossier->allotment_name ?></div>
        </div>

        <div class="form-item-horizontal less_padded">
          <label>Toegewezen aan&nbsp;:</label>
          <div class="value"><?php  print $_dossier->company_name ?></div>
        </div>
      </div>

      <div class="detailbar__row" style="padding-left: 15px;">

         <div class="form-item-horizontal less_padded">
           <label>Richting&nbsp;:</label>
           <?php print listbox_ajax('allotment_direction_id', $_dossier->allotment_direction_id); ?>
         </div>

         <div class="form-item-horizontal less_padded">
           <label>KM Paal&nbsp;:</label>
           <?php print listbox_ajax('allotment_direction_indicator_id', $_dossier->allotment_direction_indicator_id); ?>
         </div>

         <div class="form-item-horizontal less_padded">
           <label>Gemeente&nbsp;:</label>
           <div class="value">
             <?php
                if($_dossier->indicator_zip)
                {
                  printf("%s - %s", $_dossier->indicator_zip, $_dossier->indicator_city);
                }
              ?>
           </div>
         </div>

         <div class="form-item-horizontal less_padded">
           <label>Rijstrook&nbsp;:</label>
           <div class="value"><?php  print $_dossier->traffic_lane_name; ?></div>
         </div>
      </div>

    </div>


  <div class="dossierbar">

    <div class="dossierbar__vouchers">
      <select name="voucher_switcher" id="voucher_switcher" data-did="<?php print $_dossier->dossier_number; ?>">
      <?php
        foreach($_dossier->towing_vouchers as $_v){
          $_is_selected = ($_v->voucher_number == $_voucher->voucher_number);

          $sel = '';
          if($_is_selected || sizeof($_dossier->towing_vouchers) == 1){
            $sel = 'selected';
          }
          print '<option value="'. $_v->voucher_number .'" '. $sel .'>'. sprintf("%s (%s)", $_v->voucher_number, $_v->status) .'</option>';
        };
      ?>
      </select>
    </div>

    <div class="dossierbar__mainactions">
      <div class="dossierbar__mainaction__item">
        <div class="btn--icon--highlighted bright">
          <a class="icon--add" href="/fast_dossier/dossier/voucher/<?=$_dossier->id?>" onclick="return confirm('Bent u zeker dat u een nieuwe takelbon wenst aan te maken?');">Add</a>
        </div>
      </div>
    </div>

    <div class="dossierbar__actions">
      <?php
        if($_voucher->status === 'READY FOR INVOICE') {
          ?>
          <div class="dossierbar__action__item">
            <!-- <input type="button" value="Factuur aanmaken" id="create-invoice-button" /> -->
            <div class="btn--dropdown">
              <div class="btn--dropdown--btn btn--icon">
                <span class="icon--invoice">Facturatie</span>
              </div>
              <ul class="btn--dropdown--drop">
                <li><a id="generate-invoice-link" href="#generate-invoice-form">Factuur aanmaken</a></li>
              </ul>
            </div>
          </div>
          <?php
        }
      ?>
      <div class="dossierbar__action__item">
        <div class="btn--dropdown">
          <div class="btn--dropdown--btn btn--icon">
            <span class="icon--email">Email</span>
          </div>
          <ul class="btn--dropdown--drop">
            <li><a id="add-email-link" href="#add-email-form">Email verzenden</a></li>
            <li><a id="view-email-link" href="#view-email-container">Emails bekijken</a></li>
            <li><a id="send-voucher-email-awv-link" href="#send-voucher-email-awv-container">Takelbon verzenden naar AW&amp;V</a></li>
          </ul>
        </div>
      </div>
      <div class="dossierbar__action__item">
        <div class="btn--dropdown">
          <div class="btn--dropdown--btn btn--icon">
            <span class="icon--nota">Nota</span>
          </div>
          <ul class="btn--dropdown--drop">
            <li><a id="add-nota-link" href="#add-nota-form">Nota toevoegen</a></li>
            <li><a id="view-nota-link" href="#view-nota-container">Notas bekijken</a></li>
          </ul>
        </div>
      </div>
      <div class="dossierbar__action__item">
        <div class="btn--dropdown">
          <div class="btn--dropdown--btn btn--icon">
            <span class="icon--attachement">Bijlage</span>
          </div>
          <ul class="btn--dropdown--drop">
            <li><a id="add-attachment-link" href="#add-attachment-form">Bijlage Toevoegen</a></li>
            <li><a id="view-attachment-link" href="#view-attachment-container">Bijlages bekijken</a></li>
          </ul>
        </div>
      </div>
      <div class="dossierbar__action__item">
        <div class="btn--dropdown">
          <div class="btn--dropdown--btn btn--icon">
            <span class="icon--print">Print</span>
          </div>
          <ul class="btn--dropdown--drop">
            <li><a href="/fast_dossier/report/voucher/towing/<?=$_dossier->id?>/<?=$_voucher->id?>">Exemplaar Takeldienst</a></li>
            <li><a href="/fast_dossier/report/voucher/collector/<?=$_dossier->id?>/<?=$_voucher->id?>">Exemplaar Afhaler</a></li>
            <li><a href="/fast_dossier/report/voucher/customer/<?=$_dossier->id?>/<?=$_voucher->id?>">Exemplaar Klant</a></li>
            <li><a href="/fast_dossier/report/voucher/other/<?=$_dossier->id?>/<?=$_voucher->id?>">Exemplaar op Aanvraag</a></li>
          </ul>
        </div>
      </div>

    </div>

  </div>

  <?php
  if($_voucher->status === 'TO CHECK' || $_voucher->status === 'READY FOR INVOICE')
  {
    print '<div class="unpadded" style="background-color: #feec8a; padding-left: 15px; padding-right: 15px; padding-top: 15px; padding-bottom: 15px; margin-bottom: 15px; color: #7f2710;" id="validation_messages"></div>';
  }

  ?>

  <div class="box unpadded dsform">
    <div class="inner_padding">

      <!--SIGNA-->
      <div class="signa-container">
        <div class="signa-container__left">
          <div class="form-item-horizontal signa-container__signa" style="width: 100%;">
            <label>Signa:</label>
            <?php /* print form_input('signa_by', $_voucher->signa_by);*/ ?>
            <?php print listbox_ajax('signa_id', $_voucher->signa_id); ?>


            <?php
            $data = array(
              'name'        => 'signa_by_vehicle',
              'type'        => 'hidden',
              'value'       => $_voucher->signa_by_vehicle);

            print form_input($data);
            ?>
          </div>
        </div>

        <div class="signa-container__right">
          <div class="form-item-horizontal signa-container__arrival">
            <label>Aankomst:</label>

            <?php print displayVoucherTimeField($_voucher->signa_arrival, 'signa_arrival'); ?>
          </div>

          <div class="form-item-horizontal signa-container__arrival">
            <label>Afmelding CIC:</label>

            <?php print displayVoucherTimeField($_voucher->cic, 'cic'); ?>
          </div>
        </div>
      </div>
      <!-- END SIGNA -->



      <!--TOWED BY-->
      <div class="towedby-container">
        <div class="towedby-container__left">
          <div class="form-item-horizontal towedby-container__towedby">
            <label>Takelaar:</label>
            <?php /* print form_input('towed_by', $_voucher->towed_by);*/ ?>
            <?php print listbox_ajax('towing_id', $_voucher->towing_id); ?>
          </div>

          <div class="form-item-horizontal towedby-container__licenceplate">
            <label>Voertuig:</label>
            <?php
            // $data = array(
            //   'name'        => 'towed_by_vehicle',
            //   'value'       => $_voucher->towed_by_vehicle,
            //   'readonly'    => 'readonly',
            //   'style'       => 'background: #F0F0F0'
            // );
            //
            // print form_hidden($data);

            print listbox_ajax('towing_vehicle_id', $_voucher->towing_vehicle_id);
            ?>
          </div>
        </div>

        <div class="towedby-container__right">
          <div class="form-item-horizontal towedby-container__call">
            <label>Oproep:</label>
            <?php print displayVoucherTimeField($_voucher->towing_called, 'towing_called'); ?>
          </div>

          <div class="form-item-horizontal towedby-container__arival">
            <label>Aankomst:</label>
            <?php print displayVoucherTimeField($_voucher->towing_arrival, 'towing_arrival'); ?>
          </div>

          <div class="form-item-horizontal towedby-container__start">
            <label>Start:</label>
            <?php print displayVoucherTimeField($_voucher->towing_start, 'towing_start'); ?>
          </div>

          <div class="form-item-horizontal towedby-container__completed">
            <label>Stop:</label>
            <?php print displayVoucherTimeField($_voucher->towing_completed, 'towing_completed'); ?>
          </div>

        </div>
      </div>
      <!-- END TOWEDBY -->

      <!-- VEHICULE -->
      <div class="vehicule-container">
        <div class="vehicule-container__left">
          <div class="form-item-horizontal vehicule-container__vehicule">
            <label>Voertuig:</label>
            <?php print form_input('vehicule', $_voucher->vehicule); ?>
          </div>

          <div class="form-item-horizontal vehicule-container__license">
            <label>Kleur:</label>
            <?php print form_input('vehicule_color', $_voucher->vehicule_color); ?>
          </div>
        </div>

        <div class="vehicule-container__right">
          <div class="form-item-horizontal vehicule-container__keypresent">
            <label>Sleutels aanwezig?</label>
            <?php print form_checkbox('vehicule_keys_present', 1, ($_voucher->vehicule_keys_present == 1)) ?>
          </div>

          <div class="form-item-horizontal vehicule-container__country">
            <label>Land:</label>
            <?php print listbox_ajax('licence_plate_country', $_voucher->vehicule_country)?>
          </div>
        </div>

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


      </div>
      <!-- END CAR -->

      <div class="dsform__clearfix dsform_seperation">
        <div class="dsform__left">

        <!-- Customer Info -->
        <div id="customer_info" class="form-item-vertical facturation-container"></div>

        <!-- Causer Info -->
        <div id="causer_info" class="form-item-vertical nuisance-container"></div>


        </div>
        <div class="dsform__right">
          <!-- Depot Info -->
          <div id="depot_info" class="form-item-horizontal depot-container"></div>
        </div>
      </div>

      <div class="dsform__clearfix dsform_seperation">
        <div class="dsform__left">
          <!--ASSI-->
          <div class="form-item-horizontal dossiernr-container" style="padding-right: 15px;">
              <label>Assistance:</label>
              <?php print listbox_ajax('insurance_id', $_voucher->insurance_id); ?>
          </div>
          <!--END ASSI-->

          <div class="form-item-horizontal dossiernr-container" style="padding-right: 15px;">
              <label>Factuurnummer assistance:</label>
              <?php print form_input('insurance_invoice_number', $_voucher->insurance_invoice_number); ?>
          </div>
        </div>

        <div class="dsform__right">
          <!--DOSS-->
          <div class="form-item-horizontal dossiernr-container">
              <label>Dossiernr.:</label>
              <?= form_input('insurance_dossiernr', $_voucher->insurance_dossiernr); ?>
          </div>
          <!--END DOSS-->

          <!--WARENTY-->
          <div class="form-item-horizontal warrenty-container">
              <label>Garantiehouder:</label>
              <?= form_input('insurance_warranty_held_by', $_voucher->insurance_warranty_held_by); ?>
          </div>
          <!--END WARENTY-->
        </div>
      </div>


      <!--WORK-->
      <div id="added-activities" class="form-item-vertical work-container">
        <!-- ACTIVITIES -->
        <div class="work-container__header">
          <div class="work-container__task__label"><label>Activiteiten:</label></div>
          <div class="work-container__number__label"><label>Aantal:</label></div>
          <div class="work-container__incl__label"><label>EHP (excl.):</label></div>
          <div class="work-container__excl__label"><label>EHP (incl.):</label></div>
          <div class="work-container__tot__incl__label"><label>Totaal (excl.):</label></div>
          <div class="work-container__tot__excl__label"><label>Totaal (incl.):</label></div>
        </div>

        <div class="work-container__fields"></div>

        <div class="work-container__actions">
          <div class="work-container__add">
            <a id="add-activity-link" class="inform-link" href="#add-activity-form" data-did="<?php print $_dossier->id; ?>" data-vid="<?php print $_voucher->id ;?>" >Activiteit toevoegen</a>
          </div>
        </div>

        <!-- ADDITIONAL COSTS -->
        <div class="additional-costs-container__header">
          <div class="additional-costs-container__task__label"><label>Extra kosten:</label></div>
          <div class="additional-costs-container__incl__label"><label>EHP (excl.):</label></div>
          <div class="additional-costs-container__excl__label"><label>EHP (incl.):</label></div>
        </div>

        <div class="additional-costs-container__fields"></div>

        <div class="additional-costs-container__actions">
        </div>

        <div class="form-item-vertical">
            <div style="float: left; font-weight: bold; width:10%;"><label>Categorie:</label></div>
            <div style="float: left; font-weight: bold; width:10%;"><label>Vrij van BTW? </label></div>
            <div style="float: left; font-weight: bold; width:10%;"><label>Bedrag (excl. BTW): </label></div>
            <div style="float: left; font-weight: bold; width:10%;"><label>Bedrag (incl. BTW):</label> </div>
            <div style="float: left; font-weight: bold; width:10%;"><label>Contant:</label> </div>
            <div style="float: left; font-weight: bold; width:10%;"><label>Overschrijving: </label></div>
            <div style="float: left; font-weight: bold; width:10%;"><label>Maestro:</label> </div>
            <div style="float: left; font-weight: bold; width:10%;"><label>Visa: </label></div>
            <div style="float: left; font-weight: bold; width:10%;"><label>Openstaand (excl. BTW): </label></div>
            <div style="float: left; font-weight: bold; width:10%;"><label>Openstaand (incl. BTW):</label></div>
        </div>

        <div class="payment-detail-container__fields"></div>

      </div>
      <!-- END WORK-->



      <!--AUTOGRAPHS-->
      <div class="autograph-container">
        <div class="autograph-container__police">
          <label>Bevestiging politie:</label>

          <div class="form-item-horizontal  autograph-container__police__trafficpost">
            <label class="notbold">Verkeerspost:</label>
            <?php print listbox('traffic_post_id', $traffic_posts, $_dossier->police_traffic_post_id); ?>
          </div>

          <div class="form-item-horizontal  autograph-container__police__trafficpost">
            <label class="notbold">Handtekening afwezig?</label>
            <input type="checkbox" name="police_not_present" id="police_not_present" value="1" <?php if($_voucher->police_not_present) print 'checked="checked"'; ?>/>
          </div>

          <div class="form-item-horizontal  autograph-container__police__timestamp">
            <label class="notbold">Tijdstip:</label>
            <?php

            // $police_signature_dt = array(
            //     'name' => 'police_signature_dt',
            //     'class' => 'datetimepicker',
            //     'value' => mdate('%d/%m/%Y %H:%i',strtotime($_voucher->police_signature_dt))
            // );
            //
            // print form_input($police_signature_dt);
            //

            if($_voucher->police_signature_dt && trim($_voucher->police_signature_dt) != "") {
              print mdate('%d/%m/%Y %H:%i', $_voucher->police_signature_dt);
            } else {
              print "";
            }
           ?>
          </div>
        </div>

        <!-- Causer Short Info -->
        <div id="causer_info_short" class="autograph-container__nuisance"></div>


        <div class="autograph-container__collecting">
          <label>Bevestiging afhaler:</label>

          <div class="form-item-horizontal  autograph-container__collecting__collector">
            <label class="notbold">Afhaler:</label>
            <?php print listbox_ajax('collector_id', $_voucher->collector_id); ?>
          </div>

          <div class="form-item-horizontal  autograph-container__collecting__date">
            <label class="notbold">Naam:</label>
            <?php
            print $_voucher->collector_name ?>
          </div>

          <div class="form-item-horizontal  autograph-container__collecting__date">
            <label class="notbold">Datum:</label>
            <?php

            $vehicule = array(
                'name' => 'vehicule_collected',
                'class' => 'datetimepicker',
                'value' => $_voucher->vehicule_collected ? mdate('%d/%m/%Y %H:%i',$_voucher->vehicule_collected) : ''
            );

            print form_input($vehicule); ?>
          </div>
        </div>
      </div>
      <!-- AUTHOGRAPH BUTTONS -->
      <div class="autograph-container-buttons">
        <div class="autograph-container__police">
          <?php
          $police_has_autograph = false;
          $police_collecting_url = 'none';
          $police_class = '';
          if(property_exists($_voucher, 'signature_traffic_post') && $_voucher->signature_traffic_post) {
            $police_class = 'active';
            $police_has_autograph = true;
            $police_collecting_url = "/fast_dossier/image/view/" . $_voucher->signature_traffic_post->document_blob_id . '/200/125';
          }
          ?>
          <div class="autograph-block autograph-container__police__autograph <?php print $police_class; ?>" style="background-image: url(<?php print $police_collecting_url; ?>);">
            <?php if($police_has_autograph): ?>
              <!-- a id="edit-autograph-police" class="inform-link icon--edit--small" href="#"></a -->
            <?php else: ?>
              <a class="add_autograph" id="signature-traffic-post"
                  data-did="<?php print $_dossier->dossier_number; ?>"
                  data-vid="<?php print $_voucher->id; ?>"
                  href="#">Voeg een handtekening toe</a>
            <?php endif; ?>
          </div>
        </div>

        <div class="autograph-container__nuisance">
          <?php
          $nuisance_has_autograph = false;
          $nuisance_collecting_url = 'none';
          $nuisance_class = '';
          if(property_exists($_voucher, 'signature_causer') && $_voucher->signature_causer) {
            $nuisance_class = 'active';
            $nuisance_has_autograph = true;
            $nuisance_collecting_url = "/fast_dossier/image/view/" . $_voucher->signature_causer->document_blob_id . '/200/125';
          }
          ?>
          <div class="autograph-block autograph-container__nuisance__autograph <?php print $nuisance_class; ?>" style="background-image: url(<?php print $nuisance_collecting_url; ?>);">
            <?php if($nuisance_has_autograph): ?>
              <!--a id="edit-autograph-nuisance" class="inform-link icon--edit--small" href="#"></a-->
            <?php else: ?>
              <a class="add_autograph" id="signature-causer"
                 data-did="<?php print $_dossier->dossier_number; ?>"
                 data-vid="<?php print $_voucher->id; ?>"
                 href="#">Voeg een handtekening toe</a>
            <?php endif; ?>
          </div>
        </div>

        <div class="autograph-container__collecting">
          <?php
          $collecting_class = '';
          $collecting_has_autograph = false;
          $autograph_collecting_url = 'none';
          if(property_exists($_voucher, 'signature_collector') && $_voucher->signature_collector) {
            $collecting_class = 'active';
            $collecting_has_autograph = true;
            $autograph_collecting_url = "/fast_dossier/image/view/" . $_voucher->signature_collector->document_blob_id . '/200/125';
          }
          ?>
          <div class="autograph-block autograph-container__collecting__autograph <?php print $collecting_class; ?>" style="background-image: url(<?php print $autograph_collecting_url; ?>);">
            <?php if($collecting_has_autograph): ?>
              <!-- a id="edit-autograph-collecting" class="inform-link icon--edit--small" href="#"></a-->
            <?php else: ?>
              <a class="add_autograph" id="signature-collector"
                 data-did="<?php print $_dossier->id; ?>"
                 data-vid="<?php print $_voucher->id; ?>"
                 href="#">Voeg een handtekening toe</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <!-- END AUTOGRAPH BUTTONS -->
      <!-- END AUTOGRAPHS-->
    </div>

    <!-- VEHICLE DAMAGE -->
    <div class="dsform__clearfix dsform_seperation">
      <div class="dsform_left">
        <div class="vehicule-container__left vehicule-extrainfo">
          <div class="form-item-horizontal">
            <label>Schade aan voertuig:</label>
            <?php nl2br(print $_voucher->vehicule_impact_remarks); ?>
          </div>
        </div>
      </div>
    </div>

    <!-- END VEHICLE DAMAGE -->

      <!-- ADDITIONAL INFORMATION -->
      <div class="dsform__clearfix dsform_seperation">
        <div class="dsform_left">
          <div class="vehicule-container__left vehicule-extrainfo">
            <div class="form-item-horizontal">
                <label>Extra informatie:</label>
                <?php nl2br(print $_voucher->additional_info); ?>
            </div>
          </div>
        </div>
      </div>

      <!-- END ADDITIONAL INFORMATION -->

    <!--SAVE-->
    <div class="form__actions">
      <div class="form__actions__cancel"></div>
      <div class="form__actions__save">
        <div class="form-item">
          <input type="submit" value="Bewaren" name="btnSave" />
        </div>
      </div>
    </div>
    <!-- END SAVE -->

  </div>

  <?php
  // echo "<pre>";
  // var_dump($dossier);
  // echo "</pre>";
  ?>


  </div>
  <?php print form_close(); ?>




  <!-- DEPOT -->
  <div id="depot_form" style="display: none;">
    <?php
      $depot_hidden = array(
        'id' => $_voucher->depot->id
      );

      print form_open('', '', $depot_hidden);
    ?>
    <div class="fancybox-form">
      <h3>Depot Bewerken</h3
        <!-- DEPOT -->
      <div class="depot-full-container">
        <div class="msg msg__error msg__hidden">Er is een fout opgetreden bij het bewaren van de gegevens</div>

        <div class="depot-full-container__left">
          <div class="form-item-horizontal depot-full-container__depot">
            <label>Depot:</label>
            <?php print form_input('name', $_voucher->depot->name); ?>
            <?php print form_hidden('default_depot', $_voucher->depot->default_depot) ?>
          </div>

          <div class="form-item-horizontal depot-full-container__street">
            <label>Straat:</label>
            <?php print form_input('street', $_voucher->depot->street); ?>
          </div>
        </div>
        <div class="depot-full-container__right">

          <div class="form-item-horizontal depot-full-container__streetnr">
            <label>Nr:</label>
            <?php print form_input('street_number', $_voucher->depot->street_number); ?>
          </div>

          <div class="form-item-horizontal depot-full-container__streetbox">
            <label>Box:</label>
            <?php print form_input('street_pobox', $_voucher->depot->street_pobox); ?>
          </div>

          <div class="form-item-horizontal depot-full-container__postal">
            <label>Zip:</label>
            <?php print form_input('zip', $_voucher->depot->zip); ?>
          </div>

          <div class="form-item-horizontal depot-full-container__city">
            <label>City:</label>
            <?php print form_input('city', $_voucher->depot->city); ?>
          </div>

          <div class="form-item-horizontal depot-full-container__city">
            <label>Standaard depot?</label>
            <table border="0">
              <tr><td>Ja</td><td>Nee</td></tr>
              <tr><td>
                  <?php
                    print form_radio('default_depot', '1', $_voucher->depot->default_depot == 1);
                  ?>
                </td><td>
                  <?php
                    print form_radio('default_depot', '0', $_voucher->depot->default_depot != 1); ?>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="fancybox-form__actions">
      <div class="form-item fancybox-form__actions__cancel">
        <a class="close_overlay" href="#">Annuleren</a>
      </div>

      <div class="form-item fancybox-form__actions__save fancybox-form__actions__twobuttons">
        <input type="submit" value="AW&amp;V" name="btnDepotAWV" />
        <input type="submit" value="Standaard Depot" name="btnDepotDefault" />
        <input type="submit" value="Bewaren" name="btnDepotSave" />
      </div>
    </div>
    <?php print form_close(); ?>
  </div>


  <!-- INVOICE -->
  <div id="customer_form" style="display: none;">
    <?php

      $fact_hidden = array(
        'id' => $_voucher->customer->id,
        'type' => $_voucher->customer->type //can either be DEFAULT or AGENCY (for AW&V)
      );

      print form_open('','',$fact_hidden);
      print form_input(array('name' => 'type', 'type' => 'hidden', 'value' => $_voucher->customer->type, 'id' => 'customer_search_type'));
    ?>
    <div class="fancybox-form">
      <h3>Facturatie gegevens Bewerken</h3>

      <input id="customersearch" type="text" placeholder="Zoek in bestaande klanten"/>

      <div class="invoice-full-container">
        <div class="msg msg__error msg__hidden">Er is een fout opgetreden bij het bewaren van de gegevens</div>
        <div class="invoice-full-container__name">
          <div class="form-item-horizontal invoice-full-container__first_name">
            <label>Voornaam:</label>
            <?php print form_input(array('name' => 'first_name', 'value' => $_voucher->customer->first_name, 'id' => 'customer_search_firstname')); ?>
          </div>
          <div class="form-item-horizontal invoice-full-container__last_name">
            <label>Achternaam:</label>
            <?php print form_input(array('name' => 'last_name', 'value' => $_voucher->customer->last_name, 'id' => 'customer_search_lastname')); ?>
          </div>
        </div>

        <div class="invoice-full-container__company">
          <div class="form-item-horizontal invoice-full-container__company_name">
            <label>Bedrijf:</label>
            <?php print form_input(array('name' => 'company_name', 'value' => $_voucher->customer->company_name, 'id' => 'customer_search_company_name')); ?>
          </div>
          <div class="form-item-horizontal invoice-full-container__company_vat">
            <label>BTW:</label>
            <?php print form_input(array('name' => 'company_vat', 'value' => $_voucher->customer->company_vat, 'id' => 'customer_search_company_vat')); ?>
          </div>
        </div>

        <div class="invoice-full-container__address__street">
          <div class="form-item-horizontal invoice-full-container__street">
            <label>Straat:</label>
            <?php print form_input(array('name' => 'street', 'value' => $_voucher->customer->street, 'id' => 'customer_search_street')); ?>
          </div>
          <div class="form-item-horizontal invoice-full-container__street_number">
            <label>Nr:</label>
            <?php print form_input(array('name' => 'street_number', 'value' => $_voucher->customer->street_number, 'id' => 'customer_search_street_number')); ?>
          </div>
          <div class="form-item-horizontal invoice-full-container__street_pobox">
            <label>Bus:</label>
            <?php print form_input(array('name' => 'street_pobox', 'value' => $_voucher->customer->street_pobox, 'id' => 'customer_search_street_pobox')); ?>
          </div>
        </div>

        <div class="invoice-full-container__address__city">
          <div class="form-item-horizontal invoice-full-container__zip">
            <label>Postcode:</label>
            <?php print form_input(array('name' => 'zip', 'value' => $_voucher->customer->zip, 'id' => 'customer_search_zip')); ?>
          </div>
          <div class="form-item-horizontal invoice-full-container__city">
            <label>Gemeente:</label>
            <?php print form_input(array('name' => 'city', 'value' => $_voucher->customer->city, 'id' => 'customer_search_city')); ?>
          </div>
        </div>

        <div class="form-item-horizontal invoice-full-container__country">
          <label>Land:</label>
          <?php print form_input(array('name' => 'country', 'value' => $_voucher->customer->country, 'id' => 'customer_search_country')); ?>
        </div>

        <div class="invoice-full-container__contact">
          <div class="form-item-horizontal invoice-full-container__phone">
            <label>Telefoon:</label>
            <?php print form_input(array('name' => 'phone', 'value' => $_voucher->customer->phone, 'id' => 'customer_search_phone')); ?>
          </div>

          <div class="form-item-horizontal invoice-full-container__email">
            <label>Email:</label>
            <?php print form_input(array('name' => 'email', 'value' => $_voucher->customer->email, 'id' => 'customer_search_email')); ?>
          </div>

          <!--
          <div class="form-item-horizontal invoice-full-container__email">
            <label>Referentie:</label>
            <?php // print form_input('invoice_ref', $_voucher->customer->invoice_ref); ?>
          </div>
          -->
        </div>
      </div>
    </div>
    <div class="fancybox-form__actions">
      <div class="form-item fancybox-form__actions__cancel">
        <a class="close_overlay" href="#">Annuleren</a>
      </div>

      <div class="form-item fancybox-form__actions__save fancybox-form__actions__twobuttons">
        <input type="submit" value="AW&amp;V" name="btnCopyCustomerAWV" />
        <input type="submit" value="Gebruik deze gegevens ook voor hinderverwekker" name="btnCustomerCopy" />
        <input type="submit" value="Bewaren" name="btnCustomerSave"/>
      </div>
    </div>
    <?php print form_close(); ?>
  </div>

  <!-- NUISANCE -->
  <div id="causer_form" style="display: none;">

    <?php
      $nuisance_hidden = array(
        'id' => $_voucher->causer->id,
      );
      print form_open('','',$nuisance_hidden);
    ?>
    <div class="fancybox-form">
      <h3>Hinderverwerker gegevens Bewerken</h3>

      <input id="causersearch" type="text" placeholder="Zoek in bestaande klanten"/>

      <div class="nuisance-full-container">
        <div class="msg msg__error msg__hidden">Er is een fout opgetreden bij het bewaren van de gegevens</div>
        <div class="nuisance-full-container__name">
        <div class="form-item-horizontal nuisance-full-container__first_name">
          <label>Voornaam:</label>
          <?php print form_input(array('name' => 'first_name', 'value' => $_voucher->causer->first_name, 'id' => 'causer_search_firstname')); ?>
        </div>
        <div class="form-item-horizontal nuisance-full-container__last_name">
          <label>Achternaam:</label>
          <?php print form_input(array('name' => 'last_name', 'value' => $_voucher->causer->last_name, 'id' => 'causer_search_lastname')); ?>
        </div>
      </div>

      <div class="nuisance-full-container__company">
        <div class="form-item-horizontal nuisance-full-container__company_name">
          <label>Bedrijf:</label>
          <?php print form_input(array('name' => 'company_name', 'value' => $_voucher->causer->company_name, 'id' => 'causer_search_company_name')); ?>
        </div>
        <div class="form-item-horizontal nuisance-full-container__company_vat">
          <label>Bedrijf VAT:</label>
          <?php print form_input(array('name' => 'company_vat', 'value' => $_voucher->causer->company_name, 'id' => 'causer_search_company_vat')); ?>
        </div>
      </div>

      <div class="nuisance-full-container__address__street">
        <div class="form-item-horizontal nuisance-full-container__street">
          <label>Straat:</label>
          <?php print form_input(array('name' => 'street', 'value' => $_voucher->causer->street, 'id' => 'causer_search_street')); ?>
        </div>
        <div class="form-item-horizontal nuisance-full-container__street_number">
          <label>Nummer:</label>
          <?php print form_input(array('name' => 'street_number', 'value' => $_voucher->causer->street_number, 'id' => 'causer_search_street_number')); ?>
        </div>
        <div class="form-item-horizontal nuisance-full-container__street_pobox">
          <label>Bus:</label>
          <?php print form_input(array('name' => 'street_pobox', 'value' => $_voucher->causer->street_pobox, 'id' => 'causer_search_street_pobox')); ?>
        </div>
      </div>

      <div class="nuisance-full-container__address__city">
        <div class="form-item-horizontal nuisance-full-container__zip">
          <label>Postcode:</label>
          <?php print form_input(array('name' => 'zip', 'value' => $_voucher->causer->zip, 'id' => 'causer_search_zip')); ?>
        </div>
        <div class="form-item-horizontal nuisance-full-container__city">
          <label>Gemeente:</label>
          <?php print form_input(array('name' => 'city', 'value' => $_voucher->causer->city, 'id' => 'causer_search_city')); ?>
        </div>
      </div>

      <div class="form-item-horizontal nuisance-full-container__country">
        <label>Land:</label>
        <?php print form_input(array('name' => 'country', 'value' => $_voucher->causer->country, 'id' => 'causer_search_country')); ?>
      </div>

      <div class="nuisance-full-container__contact">
        <div class="form-item-horizontal nuisance-full-container__phone">
          <label>Telefoon:</label>
          <?php print form_input(array('name' => 'phone', 'value' => $_voucher->causer->phone, 'id' => 'causer_search_phone')); ?>
        </div>

        <div class="form-item-horizontal nuisance-full-container__email">
          <label>Email:</label>
          <?php print form_input(array('name' => 'email', 'value' => $_voucher->causer->email, 'id' => 'causer_search_email')); ?>
        </div>
      </div>


      </div>
    </div>
    <div class="fancybox-form__actions">
      <div class="form-item fancybox-form__actions__cancel">
        <a class="close_overlay" href="#">Annuleren</a>
      </div>

      <div class="form-item fancybox-form__actions__save fancybox-form__actions__twobuttons">`
        <input type="submit" value="Gebruik deze gegevens ook voor facturatie" name="btnCauserCopy"/>

        <input type="submit" value="Bewaren" name="btnCauserSave" />
      </div>
    </div>
    <?php print form_close(); ?>
  </div>


  <!-- EMAIL -->
  <div id="add-email-form" style="display: none;">

    <?php

    $email_attr = array(
      'data-vid' => $_voucher->id,
      'data-did' => $_dossier->id
    );

    $email_hidden = array(
        'voucher_id' => $_voucher->id,
        'dossier_id' => $_dossier->id
    );

    print form_open('',$email_attr,$email_hidden);

    ?>

    <div class="fancybox-form">
      <h3>Email versturen</h3>
      <div class="msg msg__error msg__hidden">Er is een fout opgetreden bij het versturen van de email</div>
      <div class="form-item-horizontal">
        <label>Email:</label>
        <?php print form_input('recipients'); ?>
      </div>

      <div class="form-item-horizontal">
        <label>Onderwerp:</label>
        <?php print form_input('subject'); ?>
      </div>

      <div class="form-item-horizontal">
        <label>Bericht:</label>
        <?php print form_textarea('message'); ?>
      </div>

    </div>
    <div class="fancybox-form__actions">
      <div class="form-item fancybox-form__actions__cancel">
        <a class="close_overlay" href="#">Annuleren</a>
      </div>

      <div class="form-item fancybox-form__actions__save">
        <input type="submit" value="Bewaren" name="btnEmailSave" />
      </div>
    </div>
    <?= form_close(); ?>
  </div>

  <div id="view-email-container"  style="display: none;">
    <div class="emails">
      <!-- EMAILS LOADED BY JS -->
    </div>
    <div class="fancybox-form__actions">
      <div class="form-item fancybox-form__actions__save">
        <a class="close_overlay" href="#">Sluiten</a>
      </div>
    </div>
  </div>
  <!-- END EMAIL -->

  <!-- NOTA -->
  <div id="add-nota-form" style="display: none;">
    <?php

    $nota_hidden = array(
      'voucher_id' => $_voucher->id,
      'dossier_id' =>  $_dossier->id
    );

    $nota_attr = array(
      'data-vid' => $_voucher->id,
      'data-did' => $_dossier->id
    );

    print form_open('',$nota_attr,$nota_hidden);

    ?>
    <div class="fancybox-form">
      <h3>Nota toevoegen</h3>
      <div class="msg msg__error msg__hidden">Er is een fout opgetreden bij het bewaren van de nota</div>
      <div class="form-item-horizontal">
        <label>Nota:</label>
        <?php print form_textarea('message'); ?>
      </div>

    </div>
    <div class="fancybox-form__actions">
      <div class="form-item fancybox-form__actions__cancel">
        <a class="close_overlay" href="#">Annuleren</a>
      </div>

      <div class="form-item fancybox-form__actions__save">
        <input type="submit" value="Bewaren" name="btnNotaSave" />
      </div>
    </div>
    <?= form_close(); ?>
  </div>

  <div id="view-nota-container" style="display: none;">
    <div class="notas">
      <!-- NOTAS LOADED BY JS -->
    </div>
    <div class="fancybox-form__actions">
      <div class="form-item fancybox-form__actions__save">
        <a class="close_overlay" href="#">Sluiten</a>
      </div>
    </div>
  </div>

  <!--END NOTA-->

  <!-- WORK -->
  <div id="add-activity-form" style="display: none;">
    <?php print form_open(); ?>
    <div class="fancybox-form">
      <h3>Activiteiten toevoegen</h3>
      <div id="add-work-form-ajaxloaded-content"></div>
    </div>
    <div class="fancybox-form__actions">
      <div class="form-item fancybox-form__actions__cancel">
        <a class="close_overlay" href="#">Annuleren</a>
      </div>

      <div class="form-item fancybox-form__actions__save">
        <input type="submit" value="Bewaren" name="btnWorkSave" />
      </div>
    </div>
    <?= form_close(); ?>
  </div>

  <!-- END WORK -->

  <!-- ATTACHEMENT -->
  <div id="add-attachment-form" style="display: none;">
    <?php
    print form_open_multipart('','','');

    ?>
    <div class="fancybox-form">
      <h3>Bijlage toevoegen</h3>

      <div class="form-item-horizontal">
        <div id="attachments__errors" class="msg msg__error" style="display:none;"></div>
      </div>

      <div class="form-item-horizontal">
        <label>Bijlage:</label>
        <input id="attachments" type="file" name="attachment" multiple/>
      </div>

      <div class="form-item-horizontal">
        <div id="attachments__list"></div>
      </div>

    </div>
    <div class="fancybox-form__actions">
      <div class="form-item fancybox-form__actions__cancel">
        <a class="close_overlay" href="#">Annuleren</a>
      </div>

      <div class="form-item fancybox-form__actions__save">
        <input type="submit" value="Bewaren" name="btnAttachmentSave" />
      </div>
    </div>
    <?= form_close(); ?>
  </div>

  <div id="view-attachment-container" style="display: none;">
    <div class="attachments">
      <!-- ATTACHMENTS LOADED BY JS -->
    </div>
    <div class="fancybox-form__actions">
      <div class="form-item fancybox-form__actions__save">
        <a class="close_overlay" href="#">Sluiten</a>
      </div>
    </div>
  </div>

  <!--END NOTA-->

  <!-- INVOICE -->
  <?php
    if($_voucher->status === 'READY FOR INVOICE')
    {
      $invoice_hidden = array(
        'voucher_id' => $_voucher->id,
        'dossier_id' =>  $_dossier->id
      );

      $invoice_attr = array(
        'data-vid' => $_voucher->id,
        'data-did' => $_dossier->id
      );

      $payment_types = $this->invoice_service->fetchAvailablePaymentTypes();

  ?>

  <div id="generate-invoice-form" style="display: none;">
    <?php
    print form_open('',$invoice_attr,$invoice_hidden);
    ?>
    <div class="fancybox-form">
      <h3>Factuur aanmaken</h3>
      <div class="form-item-horizontal">
        <label>Betalingsinformatie:</label>
        <table>
          <tbody>
            <?php
            foreach($_voucher->towing_payment_details as $detail) {
                $category_key = '';
                $label = '';

                switch($detail->category) {
                  case 'CUSTOMER':
                    $label='Klant';
                    $category_key='customer'; break;
                  case 'INSURANCE':
                    $label = 'Assistance';
                    $category_key='assurance'; break;
                  case 'COLLECTOR':
                    $label = 'Afhaler';
                    $category_key='collector'; break;
                }

                $amount = $detail->amount_incl_vat;

                if($detail->foreign_vat) {
                  $amount = $detail->amount_excl_vat;
                }
            ?>
              <tr>
                  <td>
                      <?= $label ?>
                  </td>
                  <td style="padding-right: 25px;">
                    <?= form_input(array('name' => "invoice_payment_amount_$category_key",
                                         'value' => $amount,
                                         'readonly'    => 'readonly',
                                         'style'       => 'background: #F0F0F0'))?>
                  </td>
              </tr>
                <?
              }
            ?>
          </tbody>
        </table>
      </div>
      <div class="form-item-horizontal">
        <label>Commentaar:</label>
        <?php print form_textarea('message'); ?>
      </div>

    </div>
    <div class="fancybox-form__actions">
      <div class="form-item fancybox-form__actions__cancel">
        <a class="close_overlay" href="#">Annuleren</a>
      </div>

      <div class="form-item fancybox-form__actions__save">
        <input type="submit" value="Aanmaken" name="btnInvoiceGenerate" />
      </div>
    </div>
    <?= form_close(); ?>
  </div>
  <?php } ?>
  <!-- END INVOICE -->

</div>

<?php
function tofloat($num) {
    $dotPos = strrpos($num, '.');
    $commaPos = strrpos($num, ',');
    $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
        ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

    if (!$sep) {
        return floatval(preg_replace("/[^0-9]/", "", $num));
    }

    return floatval(
        preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
        preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
    );
}

function showDossierList($ctx, $data, $title) {
  if(sizeof($data) > 0)
  {
    $last = $ctx->uri->total_segments();
    $url_dossier_id = $ctx->uri->segment($last - 1);
    $url_takelbon_id = $ctx->uri->segment($last);


    $ctx->table->set_heading($title);

    //d.id, d.id as 'dossier_id', t.id as 'voucher_id', d.call_number, d.call_date, t.voucher_number, ad.name 'direction_name',
    //adi.name 'indicator_name', c.code as `towing_service`, ip.name as `incident_type`
    $prev = '';
    $vouchers = $data;

    if($vouchers && sizeof($vouchers) > 0) {
      foreach($vouchers as $voucher) {
        if($voucher->dossier_number === $url_dossier_id){
          $class = 'active bright';
        }else{
          $class = 'inactive';
        }

        // if($prev !== $voucher->dossier_number){

          // $prev = $voucher->dossier_number;

          $ctx->table->add_row(
                array('class' => $class,
                      'data' => sprintf('<a class="id__cell" href="/fast_dossier/dossier/%s/%s">
                                            <span class="id__cell__icon icon--map"></span>
                                            <span class="id__cell__text__type">%s</span>
                                            <span class="id__cell__text">
                                              <span class="id__cell__text__data">
                                                <span class="id__cell__text__info">Oproepnummer: %s</span>
                                                <span class="id__cell__text__nr">%s</span>
                                                <span class="id__cell__text__info">%s %s</span>
                                              </span>
                                            </span></a>', $voucher->dossier_number, $voucher->voucher_number, $voucher->voucher_number, $voucher->call_number, $voucher->incident_type, $voucher->direction_name , $voucher->indicator_name))
          );

        // }
      }
    }

    return $ctx->table->generate();
  }

  return '';
}
?>
