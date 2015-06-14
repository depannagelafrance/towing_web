<?php

function displayVoucherTimeField($value, $name) {
  if($value) {
    $render = sprintf('<div class="input_value">%s</div>', asTime($value));
    $render .= form_hidden($name, asJsonDateTime($value));

    return $render;
  } else {
    return "&nbsp;";
  }
}

function displayCustomerInformation($customer) {
  $formatted = '<div class="has_content">';


  if($customer->company_name) {
    $formatted .= '<div>' . $customer->company_name . '</div>';
    $formatted .= '<div>' . $customer->company_vat . '</div>';
  } else {
    $formatted .= '<div>' . $customer->last_name . ' ' . $customer->first_name . '</div>';
  }


  $formatted .= sprintf("<div>%s %s %s <br/>%s %s <br /> %s</div>", $customer->street, $customer->street_number, $customer->street_pobox, $customer->zip, $customer->city, $customer->country);

  $formatted .= sprintf("<div>T: %s</div>", $customer->phone);
  $formatted .= sprintf("<div>E: %s</div>", $customer->email);


  $formatted .= '</div>';

  return $formatted;
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
           <div class="value">
             <?php
                print $_dossier->indicator_name;

                if($_dossier->indicator_zip)
                {
                  printf(" (%s - %s)", $_dossier->indicator_zip, $_dossier->indicator_city);
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

    </div>

    <div class="dossierbar__actions">
      <?php
        if($_voucher->status === 'INVOICED WITHOUT STORAGE') {
          ?>
          <div class="dossierbar__action__item">
            <input type="button" value="Factuur stallingskosten aanmaken" id="create-invoice-storage-button" />
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
            <?php printf("%s (%s)", $_voucher->signa_by, $_voucher->signa_by_vehicle) ?>

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
            <?php print $_voucher->towed_by ?>
          </div>

          <div class="form-item-horizontal towedby-container__licenceplate">
            <label>Voertuig:</label>
            <?php print $_voucher->towed_by_vehicle ?>
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
            <?php print $_voucher->vehicule; ?>
          </div>

          <div class="form-item-horizontal vehicule-container__license">
            <label>Kleur:</label>
            <?php print $_voucher->vehicule_color; ?>
          </div>
        </div>

        <div class="vehicule-container__right">
          <div class="form-item-horizontal vehicule-container__keypresent">
            <label>Sleutels aanwezig?</label>
            <?php printf('<i class="fa fa-%ssquare-o">&nbsp;</i>', ($_voucher->vehicule_keys_present == 1 ? "check-" : "")) ?>
          </div>

          <div class="form-item-horizontal vehicule-container__country">
            <label>Land:</label>
            <?php print $_voucher->vehicule_country ?>
          </div>
        </div>

        <div class="vehicule-container__left">
          <div class="form-item-horizontal vehicule-container__vehicule">
            <label>Type wagen:</label>
            <?php print $_voucher->vehicule_type; ?>
          </div>

          <div class="form-item-horizontal vehicule-container__license">
            <label>Nummerplaat:</label>
            <?php print $_voucher->vehicule_licenceplate; ?>
          </div>
        </div>


      </div>
      <!-- END CAR -->

      <div class="dsform__clearfix dsform_seperation">
        <div class="dsform__left">

        <!-- Customer Info -->
        <div id="readonly_customer_info" class="form-item-vertical facturation-container">
          <label>Facturatiegegevens:</label>
          <div id="edit-invoice-data" class="facturation-container__info">
            <?= displayCustomerInformation($_voucher->customer) ?>
          </div>
        </div>

        <!-- Causer Info -->
        <div id="readonly_causer_info" class="form-item-vertical nuisance-container">
          <label>Hinderverwekker:</label>
          <div id="edit-nuisance-data" class="nuisance-container__info">
            <?= displayCustomerInformation($_voucher->causer) ?>
          </div>
        </div>


        </div>
        <div class="dsform__right">



          <!-- Depot Info -->
          <div class="form-item-horizontal depot-container">
            <label>Depot/Afvoerlocatie:</label>
            <div id="edit-nuisance-data" class="nuisance-container__info">
              <?= $_voucher->depot->display_name ?>
            </div>
          </div>

        </div>
      </div>


      <div class="dsform__clearfix dsform_seperation">
        <div class="dsform__left">
          <!--ASSI-->
          <div class="form-item-horizontal dossiernr-container" style="padding-right: 15px;">
            <label>Assistance:</label>
            <?php
              if($_voucher->insurance_id) {
                foreach($insurances as $d) {
                  if($d->id === $_voucher->insurance_id) {
                    print $d->name;
                  }
                }
              } else {
                print '-- Geen assistance toegekend --';
              }
            ?>
          </div>
          <!--END ASSI-->

          <div class="form-item-horizontal dossiernr-container" style="padding-right: 15px;">
              <label>Factuurnummer assistance:</label>
              <?php print $_voucher->insurance_invoice_number ?>
          </div>
        </div>

        <div class="dsform__right">
          <!--DOSS-->
          <div class="form-item-horizontal dossiernr-container">
              <label>Dossiernr.:</label>
              <?= $_voucher->insurance_dossiernr ?>
          </div>
          <!--END DOSS-->

          <!--WARRANTY-->
          <div class="form-item-horizontal warrenty-container">
              <label>Garantiehouder:</label>
              <?= $_voucher->insurance_warranty_held_by ?>
          </div>
          <!--END WARENTY-->
        </div>
      </div>


      <!--WORK-->
      <div id="added-activities" class="form-item-vertical work-container">
        <?php if(count($_voucher->towing_activities) > 0): ?>

          <?php
            $this->table->set_heading('Activiteit', 'Aantal', 'EHP (excl.)', 'EHP (incl.):', 'Totaal (excl.)', 'Totaal (incl.):');

            foreach($_voucher->towing_activities as $_activity) {
              $this->table->add_row(
                    $_activity->name,
                    $_activity->amount,
                    sprintf("%1\$.2f", $_activity->fee_excl_vat),
                    sprintf("%1\$.2f", $_activity->fee_incl_vat),
                    $_activity->cal_fee_excl_vat,
                    $_activity->cal_fee_incl_vat);
            }

            print $this->table->generate();
          ?>
        <?php endif; ?>

        <!--PAYMENT-->
        <div class="form-item-vertical payment-container">
          <div id="payment_insurance"  class="form-item-vertical payment-container__insurance">
            <label class="notbold">Garantie:</label>
            <?php print  $_voucher->towing_payments->amount_guaranteed_by_insurance; ?>
          </div>

          <div id="payment_total" class="form-item-vertical payment-container__amount_customer">
            <label class="notbold">Te betalen:</label>
            <?php print $_voucher->towing_payments->amount_customer; ?>
          </div>

          <div id="payment_cash" class="form-item-vertical payment-container__paid_in_cash">
            <label class="notbold">Contant:</label>
            <?php print $_voucher->towing_payments->paid_in_cash; ?>
          </div>

          <div id="payment_bank" class="form-item-vertical payment-container__paid_by_bank_deposit">
            <label class="notbold">Overschrijving:</label>
            <?php print $_voucher->towing_payments->paid_by_bank_deposit; ?>
          </div>

          <div id="payment_debit" class="form-item-vertical payment-container__paid_by_debit_card">
            <label class="notbold">Maestro:</label>
            <?php print $_voucher->towing_payments->paid_by_debit_card; ?>
          </div>

          <div id="payment_credit" class="form-item-vertical payment-container__paid_by_credit_card">
            <label class="notbold">Creditcard:</label>
            <?php print $_voucher->towing_payments->paid_by_credit_card; ?>
          </div>

          <div id="payment_paid" class="form-item-vertical payment-container__cal_amount_paid">
            <label class="notbold">Betaald:</label>
            <?php print $_voucher->towing_payments->cal_amount_paid; ?>
          </div>

          <div id="payment_unpaid" class="form-item-vertical payment-container__cal_amount_unpaid">
            <label class="notbold">Openstaand:</label>
            <?php print $_voucher->towing_payments->cal_amount_unpaid; ?>
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
            <?php
              if($_dossier->police_traffic_post_id) {
                foreach($traffic_posts as $d) {
                  if($d->id === $_dossier->police_traffic_post_id) {
                    print $d->name;
                  }
                }
              } else {
                print '-- Geen verkeerspost toegekend --';
              }

            ?>

          </div>

          <div class="form-item-horizontal  autograph-container__police__timestamp">
            <label class="notbold">Tijdstip:</label>
            <?php

            if($_voucher->police_signature_dt && trim($_voucher->police_signature_dt) != "") {
              print mdate('%d/%m/%Y %H:%i',strtotime($_voucher->police_signature_dt));
            } else {
              print "";
            }
           ?>
          </div>
        </div>

        <!-- Causer Short Info -->
        <div id="causer_info_readonly" class="autograph-container__nuisance">
          <label>Bevestiging hinderverwekker:</label>
          <br />
          <?php
          print displayCustomerInformation($_voucher->causer);

          if($_voucher->causer->causer_not_present) {
            print "<br /><strong>Hinderverwekker niet beschikbaar voor handtekening</strong>";
          }
          ?>
        </div>


        <div class="autograph-container__collecting">
          <label>Bevestiging afhaler:</label>

          <div class="form-item-horizontal  autograph-container__collecting__collector">
            <label class="notbold">Afhaler:</label>

            <?php
              if($_voucher->collector_id) {
                foreach($collectors as $d) {
                  if($d->id === $_voucher->collector_id)
                    print $d->name;
                }
              } else {
                print "-- Geen afhaler toegekend -- ";
              }
            ?>
          </div>

          <div class="form-item-horizontal  autograph-container__collecting__date">
            <label class="notbold">Datum:</label>
            <?php
            print $_voucher->vehicule_collected ? mdate('%d/%m/%Y %H:%i',strtotime($_voucher->vehicule_collected)) : ''
            ?>
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

  <!--END ATTACHMENT-->


</div>
