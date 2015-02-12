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

      $last = $this->uri->total_segments();
      $url_dossier_id = $this->uri->segment($last - 1);
      $url_takelbon_id = $this->uri->segment($last);


      $this->load->helper('date');

      $this->table->set_heading('Dossier');

      //d.id, d.id as 'dossier_id', t.id as 'voucher_id', d.call_number, d.call_date, t.voucher_number, ad.name 'direction_name',
      //adi.name 'indicator_name', c.code as `towing_service`, ip.name as `incident_type`
      $prev = '';
      if($vouchers && sizeof($vouchers) > 0) {
        foreach($vouchers as $voucher) {
          if($voucher->dossier_number === $url_dossier_id){
            $class = 'active bright';
          }else{
            $class = 'inactive';
          }

          if($prev !== $voucher->dossier_number){

            $prev = $voucher->dossier_number;

            $this->table->add_row(
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
                                              </span></a>', $voucher->dossier_number, $voucher->voucher_number, $voucher->dossier_number, $voucher->call_number, $voucher->incident_type, $voucher->direction_name , $voucher->indicator_name))
            );

          }
        }
      }

      echo $this->table->generate();

      ?>
    </div>
  </div>

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
          <div class="value"><?php print $_dossier->call_number; ?></div>
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

      <div class="detailbar__row">

         <div class="form-item-horizontal less_padded">
           <label>Richting&nbsp;:</label>
           <div class="value"><?php  print $_dossier->direction_name; ?></div>
         </div>

         <div class="form-item-horizontal less_padded">
           <label>KM Paal&nbsp;:</label>
           <div class="value"><?php  print $_dossier->indicator_name; ?></div>
         </div>

         <div class="form-item-horizontal less_padded">
           <label>Rijstrook&nbsp;:</label>
           <div class="value"><?php  print $_dossier->traffic_lane_name; ?></div>
         </div>
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

  ?>

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
          <a class="icon--add" href="/fast_dossier/dossier/voucher/<?=$_dossier->id?>">Add</a>
        </div>
      </div>
    </div>

    <div class="dossierbar__actions">
      <div class="dossierbar__action__item">
        <div class="btn--dropdown">
          <div class="btn--dropdown--btn btn--icon">
            <span class="icon--email">Email</span>
          </div>
          <ul class="btn--dropdown--drop">
            <li><a id="add-email-link" href="#add-email-form">Email verzenden</a></li>
            <li><a id="view-email-link" href="#view-email-container">Emails bekijken</a></li>
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
              'value'       => $_voucher->signa_by_vehicle,
              'readonly'    => 'readonly',
              'style'       => 'background: #F0F0F0'
            );

            print form_hidden($data);
            ?>
          </div>
        </div>

        <div class="signa-container__right">
          <div class="form-item-horizontal signa-container__arrival">
            <label>Aankomst:</label>

            <?php print displayVoucherTimeField($_voucher->signa_arrival, 'signa_arrival'); ?>
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

            <!--ASSI-->
            <div class="form-item-horizontal  assistance-container">
                <label>Assistance:</label>
                <?php print listbox_ajax('insurance_id', $_voucher->insurance_id); ?>
            </div>
            <!--END ASSI-->

        </div>
      </div>

      <div style="width: 64%;margin-bottom: 30px;">


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


      <!--WORK-->
      <div id="added-activities" class="form-item-vertical work-container">
        <?php if(count($_voucher->towing_activities) > 0): ?>
        <div class="work-container__header">
          <div class="work-container__task__label"><label>Activiteiten:</label></div>
          <div class="work-container__number__label"><label>Aantal:</label></div>
          <div class="work-container__incl__label"><label>EHP (excl.):</label></div>
          <div class="work-container__excl__label"><label>EHP (incl.):</label></div>
          <div class="work-container__tot__incl__label"><label>Totaal (excl.):</label></div>
          <div class="work-container__tot__excl__label"><label>Totaal (incl.):</label></div>
        </div>
        <?php endif; ?>
        <div class="work-container__fields"></div>

      <div class="work-container__actions">
        <div class="work-container__add">
          <a id="add-activity-link" class="inform-link" href="#add-activity-form" data-did="<?php print $_dossier->id; ?>" data-vid="<?php print $_voucher->id ;?>" >Activiteit toevoegen</a>
        </div>
      </div>

        <!--PAYMENT-->
        <div class="form-item-vertical payment-container">
          <div id="payment_insurance"  class="form-item-vertical payment-container__insurance">
            <label class="notbold">Garantie:</label>
            <?php print form_input('amount_guaranteed_by_insurance', $_voucher->towing_payments->amount_guaranteed_by_insurance); ?>
          </div>

          <div id="payment_total" class="form-item-vertical payment-container__amount_customer">
            <label class="notbold">Te betalen:</label>
            <?php
            $data = array(
            'name'        => 'amount_customer',
            'value'       => $_voucher->towing_payments->amount_customer,
            'readonly'    => 'readonly',
            'style'       => 'background: #F0F0F0'
            );
            print form_input($data);
            ?>
          </div>

          <div id="payment_cash" class="form-item-vertical payment-container__paid_in_cash">
            <label class="notbold">Contant:</label>
            <?php print form_input('paid_in_cash', $_voucher->towing_payments->paid_in_cash); ?>
          </div>

          <div id="payment_bank" class="form-item-vertical payment-container__paid_by_bank_deposit">
            <label class="notbold">Overschrijving:</label>
            <?php print form_input('paid_by_bank_deposit', $_voucher->towing_payments->paid_by_bank_deposit); ?>
          </div>

          <div id="payment_debit" class="form-item-vertical payment-container__paid_by_debit_card">
            <label class="notbold">Maestro:</label>
            <?php print form_input('paid_by_debit_card', $_voucher->towing_payments->paid_by_debit_card); ?>
          </div>

          <div id="payment_credit" class="form-item-vertical payment-container__paid_by_credit_card">
            <label class="notbold">Creditcard:</label>
            <?php print form_input('paid_by_credit_card', $_voucher->towing_payments->paid_by_credit_card); ?>
          </div>

          <div id="payment_paid" class="form-item-vertical payment-container__cal_amount_paid">
            <label class="notbold">Betaald:</label>
            <?php
            $data = array(
              'name'        => 'cal_amount_paid',
              'value'       => $_voucher->towing_payments->cal_amount_paid,
              'readonly'    => 'readonly',
              'style'       => 'background: #F0F0F0'
            );
            print form_input($data);
            ?>
          </div>

          <div id="payment_unpaid" class="form-item-vertical payment-container__cal_amount_unpaid">
            <label class="notbold">Openstaand:</label>
            <?php
            $data = array(
              'name'        => 'cal_amount_unpaid',
              'value'       => $_voucher->towing_payments->cal_amount_unpaid,
              'readonly'    => 'readonly',
              'style'       => 'background: #F0F0F0'
            );
            print form_input($data);
            ?>
          </div>

        </div>


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
              print mdate('%d/%m/%Y %H:%i',strtotime($_voucher->police_signature_dt));
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
            <label class="notbold">Datum:</label>
            <?php

            $vehicule = array(
                'name' => 'vehicule_collected',
                'class' => 'datetimepicker',
                'value' => $_voucher->vehicule_collected ? mdate('%d/%m/%Y %H:%i',strtotime($_voucher->vehicule_collected)) : ''
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
        </div>
      </div>
    </div>
    <div class="fancybox-form__actions">
      <div class="form-item fancybox-form__actions__cancel">
        <a class="close_overlay" href="#">Annuleren</a>
      </div>

      <div class="form-item fancybox-form__actions__save fancybox-form__actions__twobuttons">
        <?php // print form_button('use_default','Depot ' . $company_depot->name); ?>
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
      );

      print form_open('','',$fact_hidden);
    ?>
    <div class="fancybox-form">
      <h3>Facturatie gegevens Bewerken</h3>
      <div class="invoice-full-container">
        <div class="msg msg__error msg__hidden">Er is een fout opgetreden bij het bewaren van de gegevens</div>
        <div class="invoice-full-container__name">
          <div class="form-item-horizontal invoice-full-container__first_name">
            <label>Voornaam:</label>
            <?php print form_input('first_name', $_voucher->customer->first_name); ?>
          </div>
          <div class="form-item-horizontal invoice-full-container__last_name">
            <label>Achternaam:</label>
            <?php print form_input('last_name', $_voucher->customer->last_name); ?>
          </div>
        </div>

        <div class="invoice-full-container__company">
          <div class="form-item-horizontal invoice-full-container__company_name">
            <label>Bedrijf:</label>
            <?php print form_input('company_name', $_voucher->customer->company_name); ?>
          </div>
          <div class="form-item-horizontal invoice-full-container__company_vat">
            <label>BTW:</label>
            <?php print form_input('company_vat', $_voucher->customer->company_vat); ?>
          </div>
        </div>

        <div class="invoice-full-container__address__street">
          <div class="form-item-horizontal invoice-full-container__street">
            <label>Straat:</label>
            <?php print form_input('street', $_voucher->customer->street); ?>
          </div>
          <div class="form-item-horizontal invoice-full-container__street_number">
            <label>Nr:</label>
            <?php print form_input('street_number', $_voucher->customer->street_number); ?>
          </div>
          <div class="form-item-horizontal invoice-full-container__street_pobox">
            <label>Bus:</label>
            <?php print form_input('street_pobox', $_voucher->customer->street_pobox); ?>
          </div>
        </div>

        <div class="invoice-full-container__address__city">
          <div class="form-item-horizontal invoice-full-container__zip">
            <label>Postcode:</label>
            <?php print form_input('zip', $_voucher->customer->zip); ?>
          </div>
          <div class="form-item-horizontal invoice-full-container__city">
            <label>Gemeente:</label>
            <?php print form_input('city', $_voucher->customer->city); ?>
          </div>
        </div>

        <div class="form-item-horizontal invoice-full-container__country">
          <label>Land:</label>
          <?php print form_input('country', $_voucher->customer->country); ?>
        </div>

        <div class="invoice-full-container__contact">
          <div class="form-item-horizontal invoice-full-container__phone">
            <label>Telefoon:</label>
            <?php print form_input('phone', $_voucher->customer->phone); ?>
          </div>

          <div class="form-item-horizontal invoice-full-container__email">
            <label>Email:</label>
            <?php print form_input('email', $_voucher->customer->email); ?>
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

      <div class="nuisance-full-container">
        <div class="msg msg__error msg__hidden">Er is een fout opgetreden bij het bewaren van de gegevens</div>
        <div class="nuisance-full-container__name">
        <div class="form-item-horizontal nuisance-full-container__first_name">
          <label>Voornaam:</label>
          <?php print form_input('first_name', $_voucher->causer->first_name); ?>
        </div>
        <div class="form-item-horizontal nuisance-full-container__last_name">
          <label>Achternaam:</label>
          <?php print form_input('last_name', $_voucher->causer->last_name); ?>
        </div>
      </div>

      <div class="nuisance-full-container__company">
        <div class="form-item-horizontal nuisance-full-container__company_name">
          <label>Bedrijf:</label>
          <?php print form_input('company_name', $_voucher->causer->company_name); ?>
        </div>
        <div class="form-item-horizontal nuisance-full-container__company_vat">
          <label>Bedrijf VAT:</label>
          <?php print form_input('company_vat', $_voucher->causer->company_vat); ?>
        </div>
      </div>

      <div class="nuisance-full-container__address__street">
        <div class="form-item-horizontal nuisance-full-container__street">
          <label>Straat:</label>
          <?php print form_input('street', $_voucher->causer->street); ?>
        </div>
        <div class="form-item-horizontal nuisance-full-container__street_number">
          <label>Nummer:</label>
          <?php print form_input('street_number', $_voucher->causer->street_number); ?>
        </div>
        <div class="form-item-horizontal nuisance-full-container__street_pobox">
          <label>Bus:</label>
          <?php print form_input('street_pobox', $_voucher->causer->street_pobox); ?>
        </div>
      </div>

      <div class="nuisance-full-container__address__city">
        <div class="form-item-horizontal nuisance-full-container__zip">
          <label>Postcode:</label>
          <?php print form_input('zip', $_voucher->causer->zip); ?>
        </div>
        <div class="form-item-horizontal nuisance-full-container__city">
          <label>Gemeente:</label>
          <?php print form_input('city', $_voucher->causer->city); ?>
        </div>
      </div>

      <div class="form-item-horizontal nuisance-full-container__country">
        <label>Land:</label>
        <?php print form_input('country', $_voucher->causer->country); ?>
      </div>

      <div class="nuisance-full-container__contact">
        <div class="form-item-horizontal nuisance-full-container__phone">
          <label>Telefoon:</label>
          <?php print form_input('phone', $_voucher->causer->phone); ?>
        </div>

        <div class="form-item-horizontal nuisance-full-container__email">
          <label>Email:</label>
          <?php print form_input('email', $_voucher->causer->email); ?>
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
      <!-- NOTAS LOADED BY JS -->
    </div>
    <div class="fancybox-form__actions">
      <div class="form-item fancybox-form__actions__save">
        <a class="close_overlay" href="#">Sluiten</a>
      </div>
    </div>
  </div>

  <!--END NOTA-->


</div>


<?php
// echo "<pre>";
// var_dump($dossier);
// echo "</pre>";
?>
